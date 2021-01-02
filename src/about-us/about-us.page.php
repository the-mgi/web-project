<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/43c8618748.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="./about-us.styles.css">
    <title>Title</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-md navbar-dark">
        <a href="../index.php" class="navbar-brand" style="color: black;"><img src="../assets/svgs/final.svg" alt="gg_image"
                                                                    width="50" height="50"> Job Stash</a>
        <button style="width: 60px" class="navbar-toggler" data-toggle="collapse" data-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbar" class="navbar-collapse">
            <ul class="navbar-nav" style="width: 100%;" id="ulBar">
                <?php
                if (isset($_SESSION["personType"])) {
                    if ($_SESSION['personType'] == 'job_seeker') {
                        echo '<li class="nav-item"><a id="getStarted" href="../seeker-search/seeker-search.page.php" class="nav-link">Get Started</a></li>
                <li class="nav-item"><a id="jobs" href="#" class="nav-link">Jobs I Applied</a></li>';
                    } else if ($_SESSION['personType'] == 'employer') {
                        echo '<li class="nav-item"><a id="newJob" href="../create-job/create-job.page.php" class="nav-link">Create a
                        new Job</a></li>
                <li class="nav-item">
                    <a id="alreadyPostedJobs" href="../employer-jobs-status/employer-jobs-status.page.html" class="nav-link">My Jobs</a>
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
<main id="mainTag">
    <div class="main-housing">
        <?php
        include "../CRUD/server.php";
        $result = getAllDeveloperDetails();
        while ($row = current($result)) {
            $id = key($result);
            $imagePath = $row["imagePath"];
            $developerName = $row["developerName"];
            $developerInformation = $row["developerInformation"];
            echo "
            <div class='col-o'>
            <img src='$imagePath' alt='developer-image'>
            <div class='data'>
                <h3>$developerName</h3>
                <p>$developerInformation</p>
            </div>
        </div>
            ";
            next($result);
        }
        ?>
    </div>
</main>
<footer>
    <div class="footer-main-row-def">
        <div class="col-zero col-footer">
            <h3 class="footer-h3">Our Company</h3>
            <h5><span class="fa fa-id-card-alt span-footer"></span> <a href="#">About Us</a></h5>
            <h5><span class="fas fa-blog span-footer"></span> <a href="../blog-preview/blog-preview.page.php">Blogs</a>
            </h5>
        </div>
        <div class="col-two col-footer">
            <h3 class="footer-h3">Follow Us</h3>
            <h5><span class="fa fa-facebook-square span-footer"></span> <a href="https://www.facebook.com/job.stash"
                                                                           target="_blank">Facebook</a></h5>
            <h5><span class="fa fa-twitter-square span-footer"></span> <a href="https://twitter.com/JobStash?s=20"
                                                                          target="_blank">Twitter</a></h5>
            <h5><span class="fa fa-linkedin-square span-footer"></span> <a
                        href="https://www.linkedin.com/in/job-stash-55bb66201/" target="_blank">LinkedIn</a></h5>
        </div>

        <div class="col-two col-footer">
            <h3 class="footer-h3">Contact Us</h3>
            <h5><span class="fa fa-envelope span-footer"></span> <span role="button"
                                                                       id="openMail">support@josbstash.com</span></h5>
            <h5><span class="fa fa-phone span-footer"></span> <span role="button">+923156180891</span></h5>
            <h5><span class="fab fa-telegram span-footer"></span> <span role="button">@jobstash</span></h5>
        </div>
        <div class="col-one col-footer">
            <h3 class="footer-h3">Newsletter</h3>
            <label for="letter-email" id=""></label>
            <input class="news-e" type="email" placeholder="Email Address" id="letter-email">
            <button class="blue-on-white button-300">Sign Up For News Letter</button>
        </div>
    </div>
    <div class="outer">
        <div class="bottom-rights">
            <span class="fa fa-copyright"></span>
            <span>themgi inc. </span>
            <span>2020 All Right Reserved</span>
        </div>
    </div>
</footer>
<script src="../common.script.js"></script>
</body>
</html>