<?php declare(strict_types=1);
//include "./dbConnection.php";
$hostName = "localhost";
$username = "root";
$password = "ayanali78941";
$dbName = "job_portal";
$connection = mysqli_connect($hostName, $username, $password, $dbName);
if (mysqli_connect_error()) {
    echo "I encountered an error";
    die ("i am dead");
}
$connection->set_charset("utf8mb4");
function getEscapedString(string $string): string {
    global $connection;
    return $connection->real_escape_string($string);
}

// =======================Users========================
function addUserWhileSigningUp(string $firstName, string $lastName, string $username, string $emailAddress, string $password, string $personType): bool {
    global $connection;
    $query = "INSERT INTO $personType (username, password, firstName, lastName, emailAddress) values ('$username', '$password', '$firstName', '$lastName', '$emailAddress')";
    return $connection->query($query);
}

function verifyUser($email, $password, $personType): mysqli_result|bool {
    global $connection;
    $query = "SELECT * FROM $personType WHERE emailAddress='$email' and password='$password'";
    return $connection->query($query);
}

function checkIfUsernameOrEmailExists(string $username, string $emailAddress, string $personType): bool {
    global $connection;
    $query = "SELECT username, emailAddress FROM $personType WHERE username='$username' or emailAddress='$emailAddress'";
    if ($connection->query($query)->num_rows > 0) {
        return true;
    }
    return false;
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
                    [$row["name"], $row["desc"], $row["eligibilityCriteria"], $row["responsibilities"], $row["minPay"], $row["maxPay"], $row["fk_companyID"]];
            }
            return $finalJobsData;
        }
    }
    return null;
}

function getAllOpenJobs($count = 20): ?array {
    $query = "SELECT * FROM job WHERE jobStatus = 'open' LIMIT $count";
    return commonGetJobs($query);
}

function searchForAnOpenJobById($id): array {
    $query = "SELECT * FROM job WHERE jobStatus = 'open' AND jobID = '$id'";
    return commonGetJobs($query);
}

function addJob(
    string $fk_employerID,
    string $name,
    string $desc,
    string $eligibilityCriteria,
    string $responsibilities,
    int $minPay,
    int $maxPay,
    string $fk_companyID,
    string $job_type
): bool {
    global $connection;
    $jobID = md5(uniqid(microtime() . rand()));
    $name = getEscapedString($name);
    $desc = getEscapedString($desc);
    $eligibilityCriteria = getEscapedString($eligibilityCriteria);
    $responsibilities = getEscapedString($responsibilities);
    $query = "INSERT INTO job VALUES ('$jobID', '$fk_employerID', '$name', '$desc', '$eligibilityCriteria', '$responsibilities', $minPay, $maxPay, 'Open', '$fk_companyID', '$job_type');";
    return $connection->query($query);
}

function deleteJob(string $id): bool {
    global $connection;
    $query = "DELETE FROM job WHERE jobID = '$id'";
    return $connection->query($query);
}

// =======================Developer Information========================
function addDeveloperInformation(string $developerName, string $developerInformation, string $imagePath): mysqli_result|bool {
    global $connection;
    $id = md5(uniqid(microtime().rand()));
    $developerInformation = $connection->real_escape_string($developerInformation);
    $imagePath = $connection -> real_escape_string($imagePath);
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
