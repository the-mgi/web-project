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
<header>
    <nav class="navbar navbar-expand-md navbar-dark">
        <a href="#" class="navbar-brand" style="color: black;"><img src="../assets/svgs/final.svg" alt="gg_image"
                                                                    width="50" height="50"> Job Stash</a>
        <button style="width: 60px" class="navbar-toggler" data-toggle="collapse" data-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbar" class="navbar-collapse">
            <ul class="navbar-nav">
                <?php
                if (isset($_SESSION["personType"])) {
                    if ($_SESSION['personType'] == 'job_seeker') {
                        echo '<li class="nav-item"><a id="getStarted" href="../seeker-search/seeker-search.page.php" class="nav-link">Get Started</a></li>
                <li class="nav-item"><a id="jobs" href="#" class="nav-link">Jobs I Applied</a></li>';
                    } else if ($_SESSION['personType'] == 'employer') {
                        echo '<li class="nav-item"><a id="newJob" href="../create-job/create-job.page.php" class="nav-link">Create a
                        new Job</a></li>
                <li class="nav-item">
                    <a id="alreadyPostedJobs" href="../employer-jobs-status/employer-jobs-status.page.php" class="nav-link">My Jobs</a>
                </li>';
                    }
                } else {
                    echo '<li class="nav-item"><a id="getStarted" href="../seeker-search/seeker-search.page.php" class="nav-link">Get Started</a></li>';
                }

                if (isset($_SESSION['firstName'])) {
                    echo "<li class='nav-item' id='userNameLi'><a id='userName' href='#' class='nav-link'>" . $_SESSION["firstName"] . "<span
                                class='fas fa-user ml-1'></span></a></li>
                          <li class='nav-item' id='logoutLi'><a href='../CRUD/functions.php?function=logout' id='logout' class='nav-link'>Logout</a></li>
";
                } else {
                    echo "<li class='nav-item' id='userNameLi'><a id='userName' href='../login/login.page.php' class='nav-link'>Sign In<span
                                class='fas fa-user ml-1'></span></a></li>";
                }
                ?>
            </ul>
        </div>
    </nav>

</header>
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
