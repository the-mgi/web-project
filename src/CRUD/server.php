<?php declare(strict_types=1);

//include "./dbConnection.php";
use JetBrains\PhpStorm\Pure;

$hostName = "localhost";
$username = "root";
$password = "ayanali78941";
$dbName = "job_portal";
$connection = mysqli_connect($hostName, $username, $password, $dbName);
if (mysqli_connect_error()) {
    die ("i am dead");
}
$connection->set_charset("utf8mb4");
function getEscapedString(string $string): string {
    global $connection;
    return $connection->real_escape_string($string);
}

#[Pure] function getHashedString(string $string): string {
    return hash("sha256", $string);
}

// =======================Users========================
function addUserWhileSigningUp(string $firstName, string $lastName, string $username, string $emailAddress, string $password, string $personType): bool {
    global $connection;
    $emailAddress = getHashedString($emailAddress);
    $password = getHashedString($password);
    $query = "INSERT INTO $personType (username_fk) VALUES ('$username');";
    $connection->query($query);
    $query = "INSERT INTO person (username, password, firstName, lastName, emailAddress, personType) values ('$username', '$password', '$firstName', '$lastName', '$emailAddress', '$personType')";
    return $connection->query($query);
}

function verifyUser($email, $password, $personType): mysqli_result|bool {
    $email = getHashedString($email);
    $password = getHashedString($password);
    global $connection;
    $query = "SELECT * FROM person WHERE emailAddress='$email' and password='$password' AND personType='$personType';";
    return $connection->query($query);
}

function checkIfUsernameOrEmailExists(string $username, string $emailAddress, string $personType): bool {
    $emailAddress = getHashedString($emailAddress);
    global $connection;
    $query = "SELECT username, emailAddress FROM person WHERE (username='$username' or emailAddress='$emailAddress') AND personType='$personType';";
    $result = $connection->query($query);
    if (!is_bool($result)) {
        if ($result->num_rows > 0) {
            return true;
        }
    }
    return false;
}

function updateUserData(string $username, string $country, string $state, string $city, string $area, string $streetAddress, string $contact, string $date, bool $type): mysqli_result|bool {
    global $connection;

    $contact = getEscapedString($contact);
    $querySeeker = "UPDATE job_seeker SET contactNumber='$contact', dateOfBirth='$date' where username_fk='$username'";
    $connection->query($querySeeker);

    $username = getEscapedString($username);
    $country == getEscapedString($country);
    $state = getEscapedString($state);
    $city = getEscapedString($city);
    $area = getEscapedString($area);
    $streetAddress = getEscapedString($streetAddress);
    $type ?
        $query = "INSERT INTO address VALUES ('$username', '$country', '$state', '$city', '$area',  '$streetAddress')" :
        $query = "UPDATE address SET country='$country', state='$state', city='$city', area='$area', streetAddress='$streetAddress' WHERE fk_user='$username'";
    return $connection->query($query);
}

function getSummary(string $userId): mysqli_result|bool {
    global $connection;
    $query = "SELECT summary from job_seeker WHERE username_fk='$userId'";
    return $connection->query($query);
}

function updateSummary(string $username, string $actualSummary): mysqli_result|bool {
    global $connection;
    $actualSummary = getEscapedString($actualSummary);
    $query = "UPDATE job_seeker SET summary='$actualSummary' WHERE username_fk='$username'";
    return $connection->query($query);
}

function getAllSkills(string $userId): mysqli_result|bool {
    global $connection;
    $query = "SELECT skillName, skillDurationYears, id FROM skills WHERE f_user='$userId'";
    return $connection->query($query);
}

function addNewSkill(string $skillName, string $skillYears, string $userId): string|null {
    global $connection;
    $id = md5(uniqid(microtime() . rand()));
    $query = "INSERT INTO skills (f_user, skillName, skillDurationYears, id) VALUES ('$userId', '$skillName', '$skillYears', '$id');";
    if ($connection->query($query)) {
        return $id;
    }
    return null;
}

function getAllEducation(string $userId): mysqli_result|bool {
    global $connection;
    $query = "SELECT courseTitle, instituteName, instituteCity, startYear, startMonth, endYear, endMonth,  isOngoing, id FROM education WHERE username='$userId';";
    return $connection->query($query);
}

function getAllExperience(string $userId): mysqli_result|bool {
    global $connection;
    $query = "SELECT organizationName, organizationCity, startYear, startMonth, endYear, endMonth, isOngoing, id, post FROM experience WHERE fk_username='$userId';";
    return $connection->query($query);
}

function removeData(string $table, string $id): mysqli_result|bool {
    global $connection;
    $query = "DELETE FROM $table WHERE id='$id'";
    return $connection->query($query);
}

function checkIfAddressPresent(string $userId): mysqli_result|bool {
    global $connection;
    $query = "SELECT fk_user FROM address WHERE fk_user='$userId'";
    return $connection->query($query);
}

function getUserFirstName(string $username): mysqli_result|bool {
    global $connection;
    $query = "SELECT firstName, lastName FROM person WHERE username='$username'";
    return $connection->query($query);
}

function getUserCompleteData(string $username): mysqli_result|bool {
    global $connection;
    $query = "SELECT person.*, job_seeker.* FROM person, job_seeker WHERE person.username='$username' AND job_seeker.username_fk='$username'";
    return $connection->query($query);
}

function addEducationExperience(string $table, array $allVariables): mysqli_result|bool {
    global $connection;
    $id = md5(uniqid(microtime() . rand()));
    $crsName = getEscapedString($allVariables["crsName"]);
    $insName = getEscapedString($allVariables["insName"]);
    $insCity = getEscapedString($allVariables["insCity"]);
    $fromYear = getEscapedString($allVariables["fromYear"]);
    $fromMonth = getEscapedString($allVariables["fromMonth"]);
    $toYear = getEscapedString($allVariables["toYear"]);
    $toMonth = getEscapedString($allVariables["toMonth"]);
    $username = $allVariables["username"];
    $query = "INSERT INTO $table VALUES ('$username', '$crsName', '$insName', '$insCity', '$fromYear', '$fromMonth', '$toYear', '$toMonth', 0, '$id')";
    return $connection->query($query);
}

// =======================Blogs========================
function commonGetBlog($query): ?array {
    global $connection;
    $results = $connection->query($query);
    if (gettype($results) != 'boolean') {
        $finalArrayOfBlogs = array();
        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                $finalArrayOfBlogs[$row['blogID']] =
                    [
                        "writtenBy" => $row["writtenBy"],
                        "heading" => $row["heading"],
                        "description" => $row["description"],
                        "content" => $row["content"],
                        "numberOfTimesRead" => $row["numberOfTimesRead"],
                        "minsRead" => $row["minsRead"],
                        "writtenDate" => $row["writtenDate"]
                    ];
            }
        }
        return $finalArrayOfBlogs;
    }
    return null;
}

function getAllBlogsData($count = 20): ?array {
    $query = "SELECT * FROM blogs LIMIT $count;";
    return commonGetBlog($query);
}

function searchForABlog(string $id): ?array {
    $query = "SELECT * FROM blogs WHERE blogID = '$id';";
    return commonGetBlog($query);
}

function addBlog(
    string $writtenBy,
    string $heading,
    string $description,
    string $content,
    int $numberOfTimesRead,
    int $minsRead,
    string $date
): bool {
    global $connection;
    $id = md5(uniqid(microtime() . rand()));
    $writtenBy = getEscapedString($writtenBy);
    $heading = getEscapedString($heading);
    $description = getEscapedString($description);
    $content = getEscapedString($content);
    $query = "INSERT INTO blogs VALUES ('$id', '$writtenBy', '$heading', '$description', '$content', '$numberOfTimesRead', '$minsRead', '$date')";
    return $connection->query($query);
}

function deleteBlog(string $id): bool {
    global $connection;
    $query = "DELETE FROM blogs WHERE blogID = '$id'";
    return $connection->query($query);
}

// =======================Jobs========================
function commonGetJobs($query): ?array {
    global $connection;
    $results = $connection->query($query);
    if (gettype($results) != 'boolean') {
        if ($results->num_rows > 0) {
            $finalJobsData = array();
            while ($row = $results->fetch_assoc()) {
                $finalJobsData[$row["jobID"]] =
                    [
                        "name" => $row["name"],
                        "desc" => $row["desc"],
                        "eligibilityCriteria" => $row["eligibilityCriteria"],
                        "responsibilities" => $row["responsibilities"],
                        "minPay" => $row["minPay"],
                        "maxPay" => $row["maxPay"],
                        "jobType" => $row["jobType"],
                        "fk_employer" => $row["fk_employer"],
                        "jobStatus" => $row["jobStatus"]
                    ];
            }
            return $finalJobsData;
        }
    }
    return null;
}

function getAllOpenJobs($count = 20): ?array {
    $query = "SELECT * FROM job WHERE job.jobStatus = 'open' LIMIT $count";
    return commonGetJobs($query);
}

function searchForAnOpenJobById(string $id): array {
    $query = "SELECT * FROM job WHERE jobID = '$id';";
    return commonGetJobs($query);
}

function searchForAJobWith(string $columnToSearch, string $keyword): ?array {
    $query = "SELECT * FROM job WHERE job.jobStatus = 'Open' AND job.$columnToSearch LIKE '%$keyword%'";
    return commonGetJobs($query);
}

function getJobWithCompanyId(string $companyId): ?array {
    $query = "select * from job where fk_employer = (select employerId from company where companyID='$companyId');";
    return commonGetJobs($query);
}

function getJobsOfAnEmployer(string $employerUsername): ?array {
    $query = "SELECT * FROM job WHERE fk_employer='$employerUsername';";
    return commonGetJobs($query);
}

function getPeopleWhoAppliedFor(string $jobId): mysqli_result|bool {
    global $connection;
    $query = "SELECT user_key FROM apply_for WHERE job_key='$jobId' AND pay_offered is null";
    return $connection->query($query);
}

function addJob(
    string $fk_employerID,
    string $name,
    string $desc,
    string $eligibilityCriteria,
    string $responsibilities,
    int $minPay,
    int $maxPay,
    string $job_type
): bool {
    global $connection;
    $jobID = md5(uniqid(microtime() . rand()));
    $name = getEscapedString($name);
    $desc = getEscapedString($desc);
    $eligibilityCriteria = getEscapedString($eligibilityCriteria);
    $responsibilities = getEscapedString($responsibilities);
    $query = "INSERT INTO job VALUES ('$jobID', '$name', '$desc', '$eligibilityCriteria', '$responsibilities', $minPay, $maxPay, 'Open', '$job_type', '$fk_employerID');";
    echo $query;
    return $connection->query($query);
}

/**
 * get employerID as input, and returns the company Name as output string
 * @param string $employerId
 * @return array|string|null
 */
function getCompanyName(string $employerId): array|string|null {
    global $connection;
    $query = "SELECT companyName FROM company WHERE companyID = (SELECT companyID FROM company WHERE employerId='$employerId');";

    $result = $connection->query($query);
    if (!is_bool($result)) {
        return $result->fetch_assoc();
    }
    return "";
}

function deleteJob(string $id): bool {
    global $connection;
    $query = "DELETE FROM job WHERE jobID = '$id'";
    return $connection->query($query);
}

function getAllCompaniesData(): bool|mysqli_result {
    global $connection;
    $query = "SELECT companyName, companyID FROM company ORDER BY companyName;";
    return $connection->query($query);
}

function getCompanyData(string $id): bool|mysqli_result {
    global $connection;
    $query = "SELECT companyName, rating, location FROM company WHERE employerId='$id';";
    return $connection->query($query);
}

// =======================Developer Information========================
function addDeveloperInformation(string $developerName, string $developerInformation, string $imagePath): mysqli_result|bool {
    global $connection;
    $id = md5(uniqid(microtime() . rand()));
    $developerInformation = $connection->real_escape_string($developerInformation);
    $imagePath = $connection->real_escape_string($imagePath);
    $query = "INSERT INTO developer_information VALUES ('$id', '$developerName', '$developerInformation', '$imagePath');";
    return $connection->query($query);
}

function editDeveloperInformation(string $id, string $newDeveloperInformation): mysqli_result|bool {
    global $connection;
    $query = "UPDATE developer_information SET developerInformation='$newDeveloperInformation' WHERE developerId='$id';";
    return $connection->query($query);
}

function getAllDeveloperDetails(): ?array {
    global $connection;
    $query = "SELECT * FROM developer_information;";
    $result = $connection->query($query);
    if (!is_bool($result)) {
        $finalArray = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $finalArray[$row["developerId"]] = [
                    "developerName" => $row["developerName"],
                    "developerInformation" => $row["developerInformation"],
                    "imagePath" => $row["imagePath"]
                ];
            }
        }
        return $finalArray;
    }
    return null;
}

// =======================Countries Cities========================
function getAllCountries(): mysqli_result|bool {
    global $connection;
    $query = "SELECT * FROM countries";
    return $connection->query($query);
}

function getCitiesOfSelectedCountry(string $countryCode): mysqli_result|bool {
    global $connection;
    $query = "SELECT city_name, city_id FROM cities WHERE country_code='$countryCode'";
    echo $query;
    return $connection->query($query);

}

// =======================apply for========================
/**
 * search in the apply for table, for a certain match of jobId and userID, to check
 * if the user already has applied for the job or not
 * @param string $username
 * @param string $id
 * @return mysqli_result|bool
 */
function checkIf(string $username, string $id): mysqli_result|bool {
    global $connection;
    $query = "SELECT id FROM apply_for WHERE user_key='$username' AND job_key='$id'";
    return $connection->query($query);
}

function addInApplyFor(string $username, string $jobID): mysqli_result|bool {
    global $connection;
    $id = md5(uniqid(microtime() . rand()));
    $query = "INSERT INTO apply_for (id, job_key, user_key) VALUES ('$id', '$jobID', '$username')";
    return $connection->query($query);
}

function getAppliedJobs(string $username): mysqli_result|bool {
    global $connection;
    $query = "SELECT job_key, pay_offered FROM apply_for WHERE user_key='$username'";
    return $connection->query($query);
}

function hireSeeker(string $jobId, string $seekerID, int $salaryOffered): bool|mysqli_result {
    global $connection;
    $query = "UPDATE apply_for SET pay_offered=$salaryOffered WHERE user_key='$seekerID' AND job_key='$jobId'";
    $connection->query($query);
    $query = "UPDATE job SET jobStatus='Hired' WHERE jobID='$jobId'";
    return $connection->query($query);
}

function deleteJobApplication(string $jobId, string $seekerId): mysqli_result|bool {
    global $connection;
    $query = "DELETE FROM apply_for WHERE job_key='$jobId' AND user_key='$seekerId'";
    return $connection->query($query);
}

// =======================newsletter========================
function addEmailInNewsletter(string $emailAddress): mysqli_result|bool {
    $emailAddress = getHashedString($emailAddress);
    global $connection;
    $query = "INSERT INTO newsletter VALUES ('$emailAddress')";
    return $connection->query($query);
}