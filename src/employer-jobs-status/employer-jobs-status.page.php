<?php
session_start();
if (isset($_SESSION["personType"])) {
    if ($_SESSION["personType"] == 'job_seeker') {
        header("location: ../seeker-search/seeker-search.page.php");
    }
} else {
    header("location: ../login/login.page.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/43c8618748.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../seeker-search/seeker-search.styles.css">
    <style>
        .li {
            margin: 5px;
            padding: 0;
            width: fit-content;
        }
    </style>

    <title>Title</title>
</head>
<body onload="{initializeAll();afterOnload();}">
<?php
include "../nav-bar/nav-bar.php";
?>
<main>
    <div class="complete-container m-2">
        <div class="jobs-area">
            <div class="all-housing mx-auto" id="mainJobsContainer"></div>
            <div class="job-details mx-auto" id="jobDetails">Select a Job to View details and APPLY!</div>
        </div>
    </div>
</main>
<script src="./employer-job-status.js"></script>
<script src="../common.script.js"></script>
<script src="../add-footer.script.js"></script>
</body>
</html>
