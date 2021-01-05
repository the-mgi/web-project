<?php
session_start();
include "./server.php";
function displayAllJobs(?array $result, string $string = 'No Job Found'): void {
    if ($result != null) {
        while ($row = current($result)) {
            $jobId = key($result);
            $name = $row["name"];
            $desc = $row["desc"];
            $eligibilityCriteria = $row["eligibilityCriteria"];
            $responsibilities = $row["responsibilities"];
            $companyName = getCompanyData($row["fk_companyID"])->fetch_assoc()["companyName"];
            $status = $row["jobStatus"];
            $class = 'badge rounded-pill bg-primary p-2';
            if ($status != 'Open') {
                $class = 'badge rounded-pill bg-danger p-2';
            }
            echo "
                    <div class='single-container mb-3' id='$jobId' onclick='openJobDetails(this)'>
                        <h3>$name</h3>
                        <h5>by: <strong>$companyName</strong></h5>
                        <p>
                            <span><strong>Summary</strong></span>
                            <br>
                            <span>$desc</span>
                        </p>
                        <h5><strong><span>Job Status: </span></strong><span class='" . $class . "' style='color: white;'>" . $status . "</span></h5>
                    </div>
                ";
            next($result);
        }
    } else {
        echo "<div class='single-container mb-3 pe-auto'>$string</div>";
    }
}

function writeJobDetails($result): void {
    $key = key($result);
    $companyData = getCompanyData($result[$key]["fk_companyID"])->fetch_assoc();
    $status = $result[$key]["jobStatus"];
    $class = 'badge rounded-pill bg-primary p-2';
    if ($status != 'Open') {
        $class = 'badge rounded-pill bg-danger p-2';
    }
    echo "
            <h3 id='postName'>" . $result[$key]['name'] . "</h3>
                <h5><span>by:</span> <strong id='company'>" . $companyData['companyName'] . "</strong></h5>
                <h5><span>Company Ratings:</span> <strong id='obtainedRating'>" . $companyData['rating'] . "</strong> out of <strong>5</strong>
                </h5>
                <h5><span>Location:</span> <strong id='jobLocation'>" . $companyData['location'] . "</strong></h5>
                <h5><strong>Job Status: </strong> <span class='" . $class . "' style='color: white; font-size: 18px;'>" . $status . "</span>
                </h5>
                <hr style='width: 100%; border-color: #cdc9c9;'>
                <p><strong>Job Description</strong><br> <span id='description'>" . $result[$key]['desc'] . "</span></p>
                <p><strong>Responsibilities</strong><br><span id='responsibilities'>" . $result[$key]['responsibilities'] . "</span></p>
                <p><strong>Eligibility Criteria</strong><br><span id='eligibilityCriteria'>" . $result[$key]['eligibilityCriteria'] . "</span></p>
                <p><strong>Job Type: </strong>" . $result[$key]['jobType'] . "</p>
                <p>
                    <strong>Salary</strong>
                    <br>
                    <strong>PKR</strong>
                    <span id='minSalary'>" . $result[$key]['minPay'] . "</span>
                     -
                    <span id='maxSalary'>" . $result[$key]['maxPay'] . "</span>
                </p>";
}

if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function']; // logout
    switch ($function) {
        case 'logout':
            session_destroy();
            header("location: ../login/login.page.php");
            break;
        case 'login':
            $emailAddress = $_POST["email"];
            $password = $_POST["password"];
            $personType = $_POST["personType"];
            $result = verifyUser($emailAddress, $password, $personType);

            if (!is_bool($result)) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $_SESSION["row"] = $row;
                    $_SESSION["personType"] = $personType;
                    $_SESSION["firstName"] = $row["firstName"];
                    $_SESSION["username"] = $row["username"];
                    $_SESSION["emailAddress"] = $emailAddress;
                    $_SESSION["lastName"] = $row["lastName"];
                    header("location: ../index.php");
                } else {
                    echo "<script>alert('Username and password combination does not exists.'); window.location.href = '../login/login.page.php';</script>";
                }
            }
            break;
        case 'subscribeToNewsletter':

            break;
        case 'signUp':
            /**
             * Add user to database, while user is signing up and route to index.php page
             */
            function addUser() {
                $firstName = $_POST["firstName"];
                $lastName = $_POST["lastName"];
                $username = $_POST["username"];
                $emailAddress = $_POST["email"];
                $password = $_POST["password"];
                $personType = $_POST["personType"];
                if (checkIfUsernameOrEmailExists($username, $emailAddress, $personType)) {
                    echo "<script>
                        alert('This username or password already exists.'); 
                        window.location.href = '../login/login.page.php';
                      </script>";
                    return;
                }
                $result = addUserWhileSigningUp($firstName, $lastName, $username, $emailAddress, $password, $personType);
                if ($result) {
                    $result = verifyUser($emailAddress, $password, $personType);
                    if (!is_bool($result)) {
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $_SESSION["personType"] = $personType;
                            $_SESSION["firstName"] = $row["firstName"];
                            $_SESSION["username"] = $row["username"];
                            $_SESSION["emailAddress"] = $row["emailAddress"];
                            $_SESSION["lastName"] = $row["lastName"];
                            header("location: ../index.php");
                        } else {
                            header("location: ../sign-up/sign-up.page.php");
                        }
                    }
                }
            }

            addUser();
            break;
        case 'addJobsToPage':
            $result = getAllOpenJobs();
            displayAllJobs($result);
            break;
        case 'particularJob':
            $jobId = $_REQUEST['jobId'];
            $result = searchForAnOpenJobById($jobId);
            if ($result != null) {
                writeJobDetails($result);
                $disabled = 'disabled';
                if (isset($_SESSION["personType"])) {
                    if ($_SESSION["personType"] == 'job_seeker') {
                        $disabled = '';
                    }
                }
                echo "
            <button " . $disabled . ">
                <span class='fa fa-check'></span>
                Apply Now
            </button>";
            }
            break;
        case 'searchSuggestionKeyword':
            /**
             * Search for all the jobs and display, which contains a given substring in their SUMMARY (job description)
             */
            function searchSuggestionKeyword() {
                $keywordToSearch = $_REQUEST["searchString"];
                $result = searchForAJobWith('desc', $keywordToSearch);
                displayAllJobs($result);
            }

            searchSuggestionKeyword();
            break;
        case 'searchSuggestionJobName':
            /**
             * Search for all the jobs and display, which contains a given substring in their NAMES
             */
            function searchSuggestionName() {
                $keywordToSearch = $_REQUEST["searchString"];
                $result = searchForAJobWith('name', $keywordToSearch);
                displayAllJobs($result);
            }

            searchSuggestionName();
            break;
        case 'searchSuggestionJobType':
            /**
             * Search for all the jobs and display, which belongs to a certain job type
             */
            function searchSuggestionType() {
                $jobType = $_REQUEST["searchString"];
                $result = searchForAJobWith('jobType', $jobType);
                displayAllJobs($result);
            }

            searchSuggestionType();
            break;
        case 'searchSuggestionCompany':
            /**
             * Search for all the jobs and display, which belongs to a certain company
             */
            function searchSuggestionCompany() {
                $company = $_REQUEST["searchString"];
                $result = searchForAJobWith('fk_companyId', $company);
                displayAllJobs($result);
            }

            searchSuggestionCompany();
            break;
        case 'populateCompaniesSelectBox':
            /**
             * Populate the select box of companies of job_seeker search for job page
             */
            function populateSelectBox() {
                echo "<option value='' selected>Select Company</option>";
                $result = getAllCompaniesData();
                if (!is_bool($result)) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $companyName = $row["companyName"];
                            $companyID = $row["companyID"];
                            echo "<option value='$companyID'>$companyName</option>";
                        }
                    }
                }
            }

            populateSelectBox();
            break;
        case 'addJob':
            /**
             * Create job related to a certain employer, who is signed in.
             */
            function createJob() {
                $jobName = $_REQUEST["jobName"];
                $jobType = $_REQUEST["jobType"];
                $eligibility = $_REQUEST["eligibilityCriteria"];
                $description = $_REQUEST["jobDesc"];
                $responsibilities = $_REQUEST["jobResp"];
                $offerLow = $_REQUEST["offerLow"];
                $offerMax = $_REQUEST["offerHigh"];
                $jobType = $_REQUEST["jobType"];

                $employerId = $_SESSION["username"];
                $companyId = getCompanyIdFromCompanyUsingEmployerId($employerId);

                $result = addJob($employerId, $jobName, $description, $eligibility, $responsibilities, $offerLow, $offerMax, '06b73ae0e09eee55712e094721dc5b97', $jobType);
                if ($result) {
                    header("location: ../employer-jobs-status/employer-jobs-status.page.php");
                } else {
                    echo "Job Not Created";
                }
            }

            createJob();
            break;
        case 'addJobsToPageForEmployer':
            /**
             * Display all the jobs that have been posted by an employer, to the employer who posted them
             */
            function getJobs() {
                $result = getJobsOfAnEmployer($_SESSION["username"]);
                displayAllJobs($result, 'You have not created any job yet. <br>Create one here. <a href="../create-job/create-job.page.php">Create Job</a>');
            }

            getJobs();
            break;
        case 'particularJobEmployer':
            /**
             * Display all the job details to employer, along with the people who applied for the selected particular job.
             */
            function displayJobDetails() {
                $jobId = $_REQUEST['jobId'];
                $result = searchForAnOpenJobById($jobId);
                if ($result != null) {
                    writeJobDetails($result);
                    $peopleWhoApplied = getPeopleWhoAppliedFor($jobId);
                    echo "<p><span><strong>People who applied for this job.</strong></span><br><ol><li class='li'>Muhammad Usama</li><li class='li'>Rohaan Ali</li><li class='li'>Muhammad Ayan Ali</li></ol></p>";
                }
            }

            displayJobDetails();
            break;
        case 'saveAddress':
            $street = $_REQUEST["streetAddress"];
            $area = $_REQUEST["area"];
            $city = $_REQUEST["city"];
            $state = $_REQUEST["state"];
            $country = $_REQUEST["country"];
            addAddressOfUser($_SESSION["username"], $country, $state, $city, $area, $street);
            break;
    }
}

function countries(): array {
    return [
        'AF' => 'Afghanistan',
        'AL' => 'Albania',
        'DZ' => 'Algeria',
        'AS' => 'American Samoa',
        'AD' => 'Andorra',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctica',
        'AG' => 'Antigua And Barbuda',
        'AR' => 'Argentina',
        'AM' => 'Armenia',
        'AW' => 'Aruba',
        'AU' => 'Australia',
        'AT' => 'Austria',
        'AZ' => 'Azerbaijan',
        'BS' => 'Bahamas',
        'BH' => 'Bahrain',
        'BD' => 'Bangladesh',
        'BB' => 'Barbados',
        'BY' => 'Belarus',
        'BE' => 'Belgium',
        'BZ' => 'Belize',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BT' => 'Bhutan',
        'BO' => 'Bolivia',
        'BA' => 'Bosnia And Herzegovina',
        'BW' => 'Botswana',
        'BV' => 'Bouvet Island',
        'BR' => 'Brazil',
        'IO' => 'British Indian Ocean Territory',
        'BN' => 'Brunei Darussalam',
        'BG' => 'Bulgaria',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'KH' => 'Cambodia',
        'CM' => 'Cameroon',
        'CA' => 'Canada',
        'CV' => 'Cape Verde',
        'KY' => 'Cayman Islands',
        'CF' => 'Central African Republic',
        'TD' => 'Chad',
        'CL' => 'Chile',
        'CN' => 'China',
        'CX' => 'Christmas Island',
        'CC' => 'Cocos (keeling) Islands',
        'CO' => 'Colombia',
        'KM' => 'Comoros',
        'CG' => 'Congo',
        'CD' => 'Congo, The Democratic Republic Of The',
        'CK' => 'Cook Islands',
        'CR' => 'Costa Rica',
        'CI' => 'Cote D\'ivoire',
        'HR' => 'Croatia',
        'CU' => 'Cuba',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'DK' => 'Denmark',
        'DJ' => 'Djibouti',
        'DM' => 'Dominica',
        'DO' => 'Dominican Republic',
        'TP' => 'East Timor',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'SV' => 'El Salvador',
        'GQ' => 'Equatorial Guinea',
        'ER' => 'Eritrea',
        'EE' => 'Estonia',
        'ET' => 'Ethiopia',
        'FK' => 'Falkland Islands (malvinas)',
        'FO' => 'Faroe Islands',
        'FJ' => 'Fiji',
        'FI' => 'Finland',
        'FR' => 'France',
        'GF' => 'French Guiana',
        'PF' => 'French Polynesia',
        'TF' => 'French Southern Territories',
        'GA' => 'Gabon',
        'GM' => 'Gambia',
        'GE' => 'Georgia',
        'DE' => 'Germany',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Greece',
        'GL' => 'Greenland',
        'GD' => 'Grenada',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GN' => 'Guinea',
        'GW' => 'Guinea-bissau',
        'GY' => 'Guyana',
        'HT' => 'Haiti',
        'HM' => 'Heard Island And Mcdonald Islands',
        'VA' => 'Holy See (vatican City State)',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IR' => 'Iran, Islamic Republic Of',
        'IQ' => 'Iraq',
        'IE' => 'Ireland',
        'IL' => 'Israel',
        'IT' => 'Italy',
        'JM' => 'Jamaica',
        'JP' => 'Japan',
        'JO' => 'Jordan',
        'KZ' => 'Kazakstan',
        'KE' => 'Kenya',
        'KI' => 'Kiribati',
        'KP' => 'Korea, Democratic People\'s Republic Of',
        'KR' => 'Korea, Republic Of',
        'KV' => 'Kosovo',
        'KW' => 'Kuwait',
        'KG' => 'Kyrgyzstan',
        'LA' => 'Lao People\'s Democratic Republic',
        'LV' => 'Latvia',
        'LB' => 'Lebanon',
        'LS' => 'Lesotho',
        'LR' => 'Liberia',
        'LY' => 'Libyan Arab Jamahiriya',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MO' => 'Macau',
        'MK' => 'Macedonia, The Former Yugoslav Republic Of',
        'MG' => 'Madagascar',
        'MW' => 'Malawi',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malta',
        'MH' => 'Marshall Islands',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MU' => 'Mauritius',
        'YT' => 'Mayotte',
        'MX' => 'Mexico',
        'FM' => 'Micronesia, Federated States Of',
        'MD' => 'Moldova, Republic Of',
        'MC' => 'Monaco',
        'MN' => 'Mongolia',
        'MS' => 'Montserrat',
        'ME' => 'Montenegro',
        'MA' => 'Morocco',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar',
        'NA' => 'Namibia',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'NL' => 'Netherlands',
        'AN' => 'Netherlands Antilles',
        'NC' => 'New Caledonia',
        'NZ' => 'New Zealand',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigeria',
        'NU' => 'Niue',
        'NF' => 'Norfolk Island',
        'MP' => 'Northern Mariana Islands',
        'NO' => 'Norway',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PS' => 'Palestinian Territory, Occupied',
        'PA' => 'Panama',
        'PG' => 'Papua New Guinea',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'PR' => 'Puerto Rico',
        'QA' => 'Qatar',
        'RE' => 'Reunion',
        'RO' => 'Romania',
        'RU' => 'Russian Federation',
        'RW' => 'Rwanda',
        'SH' => 'Saint Helena',
        'KN' => 'Saint Kitts And Nevis',
        'LC' => 'Saint Lucia',
        'PM' => 'Saint Pierre And Miquelon',
        'VC' => 'Saint Vincent And The Grenadines',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'Sao Tome And Principe',
        'SA' => 'Saudi Arabia',
        'SN' => 'Senegal',
        'RS' => 'Serbia',
        'SC' => 'Seychelles',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapore',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'SB' => 'Solomon Islands',
        'SO' => 'Somalia',
        'ZA' => 'South Africa',
        'GS' => 'South Georgia And The South Sandwich Islands',
        'ES' => 'Spain',
        'LK' => 'Sri Lanka',
        'SD' => 'Sudan',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard And Jan Mayen',
        'SZ' => 'Swaziland',
        'SE' => 'Sweden',
        'CH' => 'Switzerland',
        'SY' => 'Syrian Arab Republic',
        'TW' => 'Taiwan, Province Of China',
        'TJ' => 'Tajikistan',
        'TZ' => 'Tanzania, United Republic Of',
        'TH' => 'Thailand',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinidad And Tobago',
        'TN' => 'Tunisia',
        'TR' => 'Turkey',
        'TM' => 'Turkmenistan',
        'TC' => 'Turks And Caicos Islands',
        'TV' => 'Tuvalu',
        'UG' => 'Uganda',
        'UA' => 'Ukraine',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'US' => 'United States',
        'UM' => 'United States Minor Outlying Islands',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VU' => 'Vanuatu',
        'VE' => 'Venezuela',
        'VN' => 'Viet Nam',
        'VG' => 'Virgin Islands, British',
        'VI' => 'Virgin Islands, U.s.',
        'WF' => 'Wallis And Futuna',
        'EH' => 'Western Sahara',
        'YE' => 'Yemen',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe',
    ];
}