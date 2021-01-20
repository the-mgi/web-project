<?php
session_start();
include "./CRUD/server.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/1umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/43c8618748.js" crossorigin="anonymous"></script>
    <script src="main-seeker.script.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="main-seeker.styles.css">
    <link rel="icon" href="./assets/svgs/final.svg">
    <title>Job Stash Home</title>
</head>
<body onload="afterOnload('./about-us/about-us.page.php', './blog-preview/blog-preview.page.php')">
<header>
    <nav class="navbar navbar-expand-md navbar-dark">
        <a href="#" class="navbar-brand" style="color: black;"><img src="assets/svgs/final.svg" alt="gg_image"
                                                                    width="50" height="50"> Job Stash</a>
        <button style="width: 60px" class="navbar-toggler" data-toggle="collapse" data-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbar" class="navbar-collapse">
            <ul class="navbar-nav">
                <?php
                if (isset($_SESSION["personType"])) {
                    if ($_SESSION['personType'] == 'job_seeker') {
                        echo '<li class="nav-item"><a id="getStarted" href="./seeker-search/seeker-search.page.php" class="nav-link">Get Started</a></li>
                <li class="nav-item"><a id="jobs" href="#" class="nav-link">Jobs I Applied</a></li>
                <li class="nav-item"><a id="resumeLink" href="./cv/cv.page.php" class="nav-link">Create Resume</a></li>';
                    } else if ($_SESSION['personType'] == 'employer') {
                        echo '<li class="nav-item"><a id="newJob" href="./create-job/create-job.page.php" class="nav-link">Create a
                        new Job</a></li>
                <li class="nav-item">
                    <a id="alreadyPostedJobs" href="employer-jobs-status/employer-jobs-status.page.php" class="nav-link">My Jobs</a>
                </li>';
                    }
                } else {
                    echo '<li class="nav-item"><a id="getStarted" href="./seeker-search/seeker-search.page.php" class="nav-link">Get Started</a></li>';
                }

                if (isset($_SESSION['firstName'])) {
                    echo "<li class='nav-item' id='userNameLi'><a id='userName' href='#' class='nav-link'>" . $_SESSION["firstName"] . "<span
                                class='fas fa-user ml-1'></span></a></li>
                          <li class='nav-item' id='logoutLi'><a href='./CRUD/functions.php?function=logout' id='logout' class='nav-link'>Logout</a></li>
";
                } else {
                    echo "<li class='nav-item' id='userNameLi'><a id='userName' href='./login/login.page.php' class='nav-link'>Sign In<span
                                class='fas fa-user ml-1'></span></a></li>";
                }
                ?>
            </ul>
        </div>
    </nav>
</header>
<main>
    <div class="main-container">
        <div class="left-container">
            <img class="o" src="assets/svgs/undraw_interview_rmcf (1).svg" alt="">
        </div>
        <div class="right-container">
            <p>We, as a company, are emerging with a sole purpose in our minds, to NORMALIZE JOB CULTURE for TEENS. Now,
                it doesn't matter from which age group you belong, we've got you covered. Search for a job with US and
                THRIVE!</p>
            <button class="blue-on-white button-300 m-0">Search for a JOB!</button>
        </div>
    </div>
    <div class="main-container bg-transparent order-specific">
        <div class="left-container order-specific-2">
            <p>Networking with people and early career development are two important pillars of
                one's successful professional life.</p>
            <p>The only thing beholding your career to flourish us getting your first
                <mark>EXPERIENCE</mark>
                in profession. We've partnered with most of our employers to give fresh candidates a chance!
            </p>
        </div>
        <div class="right-container order-specific-1">
            <img class="o" src="assets/svgs/undraw_career_development_oqcb.svg" alt="resume">
        </div>
    </div>
    <div class="main-container bg-transparent">
        <div class="left-container">
            <img class="o" src="assets/svgs/undraw_organize_resume_utk5.svg" alt="resume">
        </div>
        <div class="right-container">
            <p style="color: black;">Definitely you would need an industry standard professional RESUME to showcase
                yourself better than ever,
                to fascinate you employer. We got your back! Create your RESUME with our Resume Builder.</p>
            <a href="./cv/cv.page.php"><button class="white-on-blue button-300 m-0">Create Your Resume</button></a>
        </div>
    </div>
</main>
<script src="common.script.js"></script>
<script src="./add-footer.script.js"></script>
</body>
</html>