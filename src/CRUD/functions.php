<?php
session_start();
include "./server.php";
$columnName = "";
function displayAllJobs(?array $result, string $string = 'No Job Found'): void {
    if ($result != null) {
        while ($row = current($result)) {
            $jobId = key($result);
            $name = $row["name"];
            $desc = $row["desc"];
            $eligibilityCriteria = $row["eligibilityCriteria"];
            $responsibilities = $row["responsibilities"];
            $companyName = getCompanyName($row["fk_employer"]);
            $status = $row["jobStatus"];
            $class = 'badge rounded-pill bg-primary p-2';
            if ($status != 'Open') {
                $class = 'badge rounded-pill bg-danger p-2';
            }
            echo "
                    <div class='single-container mb-3' id='$jobId' onclick='openJobDetails(this)'>
                        <h3>$name</h3>
                        <h5>by: <strong>" . $companyName['companyName'] . "</strong></h5>
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
    $companyData = getCompanyData($result[$key]["fk_employer"])->fetch_assoc();
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

function educationExperience(string $table = "education"): mysqli_result|bool {
    $dataArray = array();
    $dataArray["crsName"] = $_REQUEST["crsName"];
    $dataArray["insName"] = $_REQUEST["insName"];
    $dataArray["insCity"] = $_REQUEST["insCity"];
    $dataArray["fromYear"] = $_REQUEST["fromYear"];
    $dataArray["fromMonth"] = $_REQUEST["fromMonth"];
    $dataArray["toYear"] = $_REQUEST["toYear"];
    $dataArray["toMonth"] = $_REQUEST["toMonth"];
    $dataArray["username"] = $_SESSION["username"];
    return addEducationExperience($table, $dataArray);
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
                    $_SESSION["firstName"] = ucfirst($row["firstName"]);
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
            $emailNewsletter = $_REQUEST["emailNewsLetter"];
            $result = addEmailInNewsletter($emailNewsletter);
            echo $result;
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
                $result = checkIf($_SESSION["username"], $jobId);
                $stringOnButton = "Apply Now";
                if (!is_bool($result)) {
                    if ($result->num_rows > 0) {
                        $stringOnButton = "Already Applied";
                        $disabled = 'disabled';
                    }
                }
                echo "
            <button " . $disabled . " id='$jobId' onclick='applyForJob(this)'>
                <span class='fa fa-check'></span>
               $stringOnButton
            </button>";
            }
            break;
        case 'applyForJob':
            $jobId = $_REQUEST['jobId'];
            $result = addInApplyFor($_SESSION["username"], $jobId);
            if ($result) {
                echo "true";
            } else {
                echo "false";
            }
            break;
        case 'jobsIApplied':
            $result = getAppliedJobs($_SESSION["username"]);
            if (!is_bool($result)) {
                if ($result->num_rows > 0) {

                } else {

                }
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
                $r = getJobWithCompanyId($company);
                displayAllJobs($r);
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
                $eligibility = $_REQUEST["eligibilityCriteria"];
                $description = $_REQUEST["jobDesc"];
                $responsibilities = $_REQUEST["jobResp"];
                $offerLow = $_REQUEST["offerLow"];
                $offerMax = $_REQUEST["offerHigh"];
                $jobType = $_REQUEST["jobType"];

                $employerId = $_SESSION["username"];

                $result = addJob($employerId, $jobName, $description, $eligibility, $responsibilities, $offerLow, $offerMax, $jobType);
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
                    $getAll = getPeopleWhoAppliedFor($jobId);
                    if (!is_bool($getAll)) {
                        if ($getAll->num_rows > 0) {
                            echo "<p><span><strong>People who applied for this job.</strong></span><br><ol>";
                            while ($row = $getAll->fetch_assoc()) {
                                $usernameGot = $row["user_key"];
                                $fullName = getUserFirstName($usernameGot);
                                while ($userFullName = $fullName->fetch_assoc()) {
                                    echo "<li class='m-1 p-0'><a target='_blank' href='../seeker-details/seeker-details.page.php?userDetails=" . $usernameGot . "&jobId=" . $jobId . "'>" . ucfirst($userFullName["firstName"]) . " " . ucfirst($userFullName["lastName"]) . "</a></li>";
                                }
                            }
                            echo "</ol></p>";
                        } else {
                            echo "<p><strong>No one has yet applied for the job</strong></p>";
                        }
                    }
                }
            }

            displayJobDetails();
            break;
        case 'updateCV': // un-complete
            $contact = $_REQUEST["contact"];
            $date = $_REQUEST["datePicker"];
            $countrySelected = $_POST["countrySelected"];
            $citySelected = $_POST["citySelected"];
            $streetAddress = $_REQUEST["streetAddress"];
            $state = $_REQUEST["state"];
            $area = $_REQUEST["area"];
            function checkIfAddressExists(): bool {
                $result = checkIfAddressPresent($_SESSION["username"]);
                if (!is_bool($result)) {
                    if ($result->num_rows > 0) {
                        return false;
                    }
                }
                return true;
            }

            $result = updateUserData($_SESSION["username"], $countrySelected, $state, $citySelected, $area, $streetAddress, $contact, $date, type: checkIfAddressExists());
            header("location: ../seeker-search/seeker-search.page.php");
            break;
        case 'getSummary':
            function obtainSummary() {
                $resultGetSummary = getSummary($_SESSION["username"]);
                if (!is_bool($resultGetSummary)) {
                    if ($resultGetSummary->num_rows > 0) {
                        $row = $resultGetSummary->fetch_assoc();
                        $summary = $row["summary"];
                        if (strlen($summary) > 0) {
                            echo $summary;
                            return;
                        }
                    }

                }
                echo "No Summary Present. Click the edit icon to add one.";
            }

            obtainSummary();
            break;
        case 'updateSummary':
            $actualSummary = $_REQUEST["actualSummary"];
            updateSummary($_SESSION["username"], $actualSummary);
            break;
        case 'getSkillsAll':
            function obtainAllSkills() {
                $resultGetAllSkills = getAllSkills($_SESSION["username"]);
                if (!is_bool($resultGetAllSkills)) {
                    if ($resultGetAllSkills->num_rows > 0) {
                        while ($row = $resultGetAllSkills->fetch_assoc()) {
                            $id = $row["id"];
                            $id = strval($id);
                            $functionString = strval("onclick='removeCurrentSkill(this)'");
                            echo "<h5 class='space-between' id='$id'>
                                    <span class='badge rounded-pill span-tag'>" . $row['skillName'] . " -- " . $row['skillDurationYears'] . " Years</span>
                                    <span class='cross' role='button' $functionString>&#10006;</span>
                                  </h5>";
                        }
                        return;
                    }
                }
                echo "<p id='noSkillPresent'>You have not added any skill yet. Press Add ICON to Add one.</p>";
            }

            obtainAllSkills();
            break;
        case 'getEducationsAll':
            function obtainAllData() {
                $result = getAllEducation($_SESSION["username"]);
                if (!is_bool($result)) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row["id"];
                            echo "
                        <div class='first'>
                            <p class='add-margin-5 space-between'>
                                <strong><span>" . $row["courseTitle"] . "</span>
                                </strong><span role='button' id='$id' onclick='removeCurrentEducation(this)'>&#10006;</span></p>
                            <p class='add-margin-5'><span>" . $row["instituteName"] . "</span> - <span>" . $row["instituteCity"] . "</span></p>
                            <p class='add-margin-5'>
                                <span>" . $row["startMonth"] . "</span>
                                <span>" . $row["startYear"] . "</span>
                                to
                                <span>" . $row["endMonth"] . "</span>
                                <span>" . $row["endYear"] . "</span>
                            </p>
                            <hr>     
                        </div>
                        ";
                        }
                        return;
                    }
                    echo "<div class='first' id='noEducationalRecordPresent'>You have not added any educational background yet. Press ADD icon to Add one.</div>";
                }
            }

            obtainAllData();
            break;
        case 'getExperienceAll':
            function obtainAllDataExperience() {
                $result = getAllExperience($_SESSION["username"]);
                if (!is_bool($result)) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row["id"];
                            echo "
                        <div class='first' >
                            <p class='add-margin-5 space-between'>
                                <strong><span>" . $row["post"] . "</span>
                                </strong><span role='button' id='$id' onclick='removeCurrentExperience(this)'>&#10006;</span></p>
                            <p class='add-margin-5'><span>" . $row["organizationName"] . "</span> - <span>" . $row["organizationCity"] . "</span></p>
                            <p class='add-margin-5'>
                                <span>" . $row["startMonth"] . "</span>
                                <span>" . $row["startYear"] . "</span>
                                to
                                <span>" . $row["endMonth"] . "</span>
                                <span>" . $row["endYear"] . "</span>
                            </p>
                            <hr>     
                        </div>
                        ";
                        }
                        return;
                    }
                    echo "<div class='first' id='noEducationalRecordPresent'>You have not added any educational background yet. Press ADD icon to Add one.</div>";
                }
            }

            obtainAllDataExperience();
            break;
        case 'addNewSkill':
            function addNewSkillD() {
                $skillName = $_REQUEST["skillName"];
                $skillYears = $_REQUEST["skillYears"];
                $result = addNewSkill($skillName, $skillYears, $_SESSION["username"]);
                if ($result != null) {
                    echo "
                <h5 class='space-between' id='$result'>
                <span class='badge rounded-pill span-tag'>" . ucwords($skillName) . " -- " . $skillYears . " Years</span>
                <span class='cross' role='button' onclick='removeCurrentSkill($result)'>&#10006;</span>           
                </h5>";
                    return;
                }
            }

            addNewSkillD();
            break;
        case 'removeSkill':
            $columnName = 'skill';
            $id = $_REQUEST["id"];
            $result = removeData(table: $columnName, id: $id);
            echo $result;
            break;
        case 'removeEducation':
            $columnName = 'education';
            $id = $_REQUEST["id"];
            $result = removeData(table: $columnName, id: $id);
            echo $result;
            break;
        case 'removeExperience':
            $columnName = 'experience';
            $id = $_REQUEST["id"];
            $result = removeData(table: $columnName, id: $id);
            echo $result;
            break;
        case 'getCities':
            $countryCode = $_REQUEST["country_code"];
            $citiesForCountry = getCitiesOfSelectedCountry($countryCode);
            echo "<option value='' selected>Select Your City</option>";
            if (!is_bool($citiesForCountry)) {
                if ($citiesForCountry->num_rows > 0) {
                    while ($row = $citiesForCountry->fetch_assoc()) {
                        $cityName = $row["city_name"];
                        $city_id = $row["city_id"];
                        echo "<option value='$city_id'>$cityName</option>";
                    }
                }
            }
            break;
        case 'writeSkillsEmployer':
            function obtainAllSkills() {
                $userId = $_REQUEST["userID"];
                $resultGetAllSkills = getAllSkills($userId);
                if (!is_bool($resultGetAllSkills)) {
                    if ($resultGetAllSkills->num_rows > 0) {
                        while ($row = $resultGetAllSkills->fetch_assoc()) {
                            $id = $row["id"];
                            $id = strval($id);
                            echo "<h5 class='space-between' id='$id'>
                                    <span class='badge rounded-pill span-tag'>" . $row['skillName'] . " -- " . $row['skillDurationYears'] . " Years</span>
                                  </h5>";
                        }
                        return;
                    }
                }
                echo "<p id='noSkillPresent'>User has not added any skills</p>";
            }

            obtainAllSkills();
            break;
        case 'addEducationDataEmployer':
            function obtainAllData() {
                $userId = $_REQUEST["userID"];
                $result = getAllEducation($userId);
                if (!is_bool($result)) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row["id"];
                            echo "
                        <div class='first'>
                            <p><strong>Education</strong></p>
                            <p class='add-margin-5 space-between'>
                                <strong><span>" . $row["courseTitle"] . "</span></p>
                            <p class='add-margin-5'><span>" . $row["instituteName"] . "</span> - <span>" . $row["instituteCity"] . "</span></p>
                            <p class='add-margin-5'>
                                <span>" . $row["startMonth"] . "</span>
                                <span>" . $row["startYear"] . "</span>
                                to
                                <span>" . $row["endMonth"] . "</span>
                                <span>" . $row["endYear"] . "</span>
                            </p>
                            <hr>     
                        </div>
                        ";
                        }
                        return;
                    }
                    echo "<div class='first' id='noEducationalRecordPresent'><span><strong>Education</strong></span><br>No educational record present for this user.</div>";
                }
            }

            obtainAllData();
            break;
        case 'addExperienceDataEmployer':
            function obtainAllDataExperience() {
                $userId = $_REQUEST["userID"];
                $result = getAllExperience($userId);
                if (!is_bool($result)) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row["id"];
                            echo "
                        <div class='first' >
                            <p><strong>Experience</strong></p>
                            <p class='add-margin-5 space-between'>
                                <strong><span>" . $row["post"] . "</span></p>
                            <p class='add-margin-5'><span>" . $row["organizationName"] . "</span> - <span>" . $row["organizationCity"] . "</span></p>
                            <p class='add-margin-5'>
                                <span>" . $row["startMonth"] . "</span>
                                <span>" . $row["startYear"] . "</span>
                                to
                                <span>" . $row["endMonth"] . "</span>
                                <span>" . $row["endYear"] . "</span>
                            </p>
                            <hr>     
                        </div>
                        ";
                        }
                        return;
                    }
                    echo "<div class='first' id='noEducationalRecordPresent'><span><strong>Education</strong></span><br>No experience record present for this user.</div>";
                }
            }

            obtainAllDataExperience();
            break;
        case 'hireSeeker':
            $job = $_REQUEST["jobId"];
            $seekerId = $_REQUEST["seekerId"];
            $salaryOffered = $_REQUEST["salaryOffered"];
            $result = hireSeeker($job, $seekerId, $salaryOffered);
            echo $result;
            break;
        case 'deleteJobApplication':
            $job = $_REQUEST["jobId"];
            $seekerId = $_REQUEST["seekerId"];
            $result = deleteJobApplication($job, $seekerId);
            echo "$result";
            break;
        case 'education':
            echo educationExperience();
            break;
        case 'experience':
            echo educationExperience("experience");
            break;
        case 'addBlogPreview':
            if (!isset($_SESSION["username"])) {
                $username = "";
            } else {
                $username = $_SESSION["username"];
            }
            $allBlogs = getAllBlogsData($username);
            print_r(json_encode($allBlogs));
            break;
        case 'addOrRemoveBookmark':
            function func() {
                if (!isset($_SESSION["username"])) {
                    echo "FALSE";
                    return;
                }
                $username = $_SESSION["username"];
                $choice = $_REQUEST["choice"];
                $blogID = $_REQUEST["blogID"];
                $choice == 'remove' ?
                    $r = (removeBookmark($username, $blogID) == '1' ? 'TRUE' : 'FALSE') :
                    $r = (bookmarkBlog($username, $blogID) == '1' ? 'TRUE' : 'FALSE');
                echo $r;
            }

            func();
            break;
        default:
            print_r("I got nothing to do for you!!");
    }
}