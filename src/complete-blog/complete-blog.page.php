<?php
session_start();
if (!isset($_REQUEST["id"])) {
    header("location: ../blog-preview/blog-preview.page.php");
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
    <link rel="stylesheet" href="./complete-blog.styles.css">
    <title>Document</title>
</head>
<body onload="afterOnload();">
<header>
    <nav class="navbar navbar-expand-md navbar-dark">
        <a href="../index.php" class="navbar-brand" style="color: black;"><img src="../assets/svgs/final.svg" alt="gg_image"
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
    <div class="con" id="con">
        <!--        --><?php
        include "../CRUD/server.php";
        include "../CRUD/requiredFunctions.php";

        $id = $_REQUEST['id'];
        $singleBlog = searchForABlog($id);
        while ($row = current($singleBlog)) {
            $writtenBy = $row["writtenBy"];
            $heading = $row["heading"];
            $description = $row["description"];
            $content = $row["content"];
            $numberOfTimesRead = $row["numberOfTimesRead"];
            $minsRead = $row["minsRead"];
            $writtenDate = $row["writtenDate"];
            echo "
                <div class='main-seeker-container'>
                    <div class='main-container'>
                        <div class='need'>
                            <div class='popup' id='bookmarkStatus'></div>
                        </div>
                        <div class='date-data'>
                            <p class='add-margin'>
                                <span>&#128339;</span>
                                Reads:
                                <span id='numberOfTimesRead'>$numberOfTimesRead</span>
                            </p>
                            <p class='add-margin'>
                                <span>&#128214;</span>
                                <span id='minRead'>$minsRead</span>
                                mins read
                            </p>
                            <p class='add-margin' id='writtenDate'>$writtenDate</p>
                        </div>
                        <div class='heading-desc'>
                            <h1 id='heading'>$heading</h1>
                        </div>
                        <div class='name-date' style='margin-top: 20px;'>
                            <div class='name'>
                                <h4>by: </h4>
                                <div class='app-profile-title' style='background-color: " . randomColor() . "'>
                                    <p id='firstLetter'>" . substr($writtenBy, 0, 1) . "</p>
                                </div>
                                <h4 id='writtenBy'>$writtenBy</h4>
                            </div>
                            <div class='content' style='margin-top: 20px;'>
                                <h2 id='description' style='opacity: .7'></h2>
                                <p id='content'>$content</p>
                            </div>
                        </div>
                    </div>
                </div>
            ";
            next($singleBlog);
        }
        ?>
    </div>
</main>
<script src="../common.script.js"></script>
<script src="../add-footer.script.js"></script>
</body>
</html>
