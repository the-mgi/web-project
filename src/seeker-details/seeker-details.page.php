<?php
session_start();
if (isset($_SESSION["personType"])) {
    if ($_SESSION["personType"] == 'job_seeker') {
        header("location: ../seeker-search/seeker-search.page.php");
    }
} else {
    header("location: ../login/login.page.php");
}
if (!isset($_REQUEST["userDetails"])) {
    header("location: ../employer-jobs-status/employer-jobs-status.page.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/43c8618748.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../cv/cv.styles.css">
    <link rel="stylesheet" href="../seeker-search/seeker-search.styles.css">
    <link rel="stylesheet" href="./seeker-details.styles.css">
    <link rel="icon" href="../assets/svgs/final.svg">
    <title>Details</title>
</head>
<body onload="{initializeVariables();afterOnload();}">
<?php
include "../nav-bar/nav-bar.php";
?>
<main>
    <div class="main-container-user-details mx-auto my-5">
        <div class="add-delete">
            <button class="hire" onclick="hireSeeker();">Hire</button>
            <button class="delete-application" onclick="deleteJobApplication();">Delete Application</button>
        </div>
        <?php
        include "../CRUD/server.php";
        $userData = getUserCompleteData($_REQUEST["userDetails"]);
        $jobId = $_REQUEST["jobId"];
        echo "<script>window.localStorage['jobId'] = '$jobId'</script>";
        if (!is_bool($userData)) {
            if ($userData->num_rows > 0) {
                $row = $userData->fetch_assoc();
                echo "
                    <div id='".$row["username"]."' class='user-data'>
                        <p class='m-2'><span><strong>Name: </strong></span><span>".ucfirst($row["firstName"])."</span> <span>".ucfirst($row["lastName"])."</span></p>
                        <p class='m-2'><span><strong>Email Address: </strong></span>".$row["emailAddress"]."</p>
                        <p class='m-2'><span><strong>Contact Number: </strong></span>".$row["contactNumber"]."</p>
                        <p class='m-2'><span><strong>Date Of Birth: </strong></span>".$row["dateOfBirth"]."</p>
                        <p class='m-2'><span><strong>Summary: </strong></span>".$row["summary"]."</p>
                        <p><strong>Skills</strong></p>
                    </div> ";
            }
        }
        ?>
    </div>
</main>
<script src="../common.script.js"></script>
<script type="text/javascript" src="./seeker-details.script.js"></script>
<script src="../add-footer.script.js"></script>
</body>
</html>
