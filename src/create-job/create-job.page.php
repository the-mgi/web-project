<?php
session_start();
if (!isset($_SESSION["personType"])) {
    header("location: ../index.php");
}
$peronType = $_SESSION["personType"];
if (!$peronType == 'employer') {
    header("location: ../index.php");
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.1/uuid.min.js"
            integrity="sha512-4JH7nC4nSqPixxbhZCLETJ+DUfHa+Ggk90LETm25fi/SitneSvtxkcWAUujvYrgKgvrvwv4NDAsFgdwCS79Dcw=="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="create-job.styles.css">
    <title>Title</title>
</head>
<body onload="afterOnload();">
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
                ?></ul>
        </div>
    </nav>
</header>
<main>
    <div class="main-container m-5">
        <div class="login-container">
            <div class="main">
                <p>Create Job</p>
                <hr>
                <form action="../CRUD/functions.php?function=addJob" id="jobCreateForm" method="POST" onsubmit="return false;">
                    <div class="row-o">
                        <div class="col-o" style="width: fit-content;">
                            <label for="jobName"></label>
                            <input type="text" id="jobName" name="jobName" placeholder="Job Post / Job Name" required onkeyup="makeVisible(this);">
                            <div class="is-invalid">Must be letters and 20-100 chars MAX</div>
                        </div>

                        <select
                                required
                                class="form-select pl-3"
                                aria-label="Default select example"
                                style="width: 408px; height: 50px; border-radius: 10px; margin: 10px; transition: .3s"
                                name="jobType"
                        >
                            <option value="" selected>Job Type</option>
                            <option value="Contract">Contract</option>
                            <option value="Part Time">Part Time</option>
                            <option value="Full Time">Full Time</option>
                        </select>
                    </div>
                    <div class="row-o">
                        <div class="col-o">
                            <label for="eligibilityCriteria"></label>
                            <textarea class="text-area" id="eligibilityCriteria" name="eligibilityCriteria" placeholder="Eligibility Criteria" required onkeyup="makeVisible(this);"></textarea>
                            <div class="is-invalid">Must be letters and 100-1000 chars MAX</div>
                        </div>
                    </div>
                    <div class="row-o">
                        <div class="col-o">
                            <label for="jobDesc"></label>
                            <textarea class="text-area" type="text" placeholder="Job Description" id="jobDesc" name="jobDesc" required onkeyup="makeVisible(this);"></textarea>
                            <div class="is-invalid">Must be letters and 500-2000 chars MAX</div>
                        </div>
                    </div>
                    <div class="row-o">
                        <div class="col-o">
                            <label for="jobResp"></label>
                            <textarea class="text-area" type="text" placeholder="Job Responsibilities" id="jobResp" name="jobResp" required onkeyup="makeVisible(this);"></textarea>
                            <div class="is-invalid">Must be letters and 200-500 chars MAX</div>
                        </div>
                    </div>
                    <div class="row-o">
                        <div class="col-o">
                            <label for="offerLow"></label>
                            <input type="number" id="offerLow" name="offerLow" placeholder="Minimum Salary" required>
                            <div class="is-invalid">Must be a number greater than 1</div>
                        </div>
                        <div class="col-o">
                            <label for="offerHigh"></label>
                            <input type="number" id="offerHigh" name="offerHigh" placeholder="Maximum Salary" required min=1000>
                            <div class="is-invalid" style="margin-bottom: 5px;">Must be a number and greater than 1</div>
                        </div>
                    </div>
                    <button style="width: 100%; margin: 0" class="login-btn btn-" id="loginButton" type="submit" value="submit" onclick="forward();">Post Job</button>
                </form>
            </div>
        </div>
    </div>
</main>
<script src="../common.script.js"></script>
<script src="./create-job.script.js"></script>
<script src="../add-footer.script.js"></script>
</body>
</html>
