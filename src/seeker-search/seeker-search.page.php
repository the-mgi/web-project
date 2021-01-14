<?php
session_start();
if (isset($_SESSION["personType"])) {
    if ($_SESSION["personType"] == 'employer') {
        header("location: ../employer-jobs-status/employer-jobs-status.page.php");
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
    <link rel="stylesheet" href="./seeker-search.styles.css">
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
        <div class="top-search-criteria mx-auto my-3">
            <div class="make-row">
                <label for="keyword"></label>
                <input type="text" id="keyword" placeholder="Keywords"
                       onkeyup="makeAjaxCall(this, 'searchSuggestionKeyword');">

                <label for="jobPostName"></label>
                <input type="text" id="jobPostName" placeholder="Job Post / Job Name"
                       onkeyup="makeAjaxCall(this, 'searchSuggestionJobName')">
            </div>
            <div class="make-row">
                <select
                        required
                        class="form-select pl-1"
                        aria-label="Default select example"
                        style="height: 50px; border-radius: 10px; transition: .3s;"
                        id="partFull"
                        name="partFull"
                        onchange="makeAjaxCall(this, 'searchSuggestionJobType')"
                >
                    <option value="">Job Type</option>
                    <option value="Full Time">Full Time</option>
                    <option value="Part Time">Part Time</option>
                    <option value="Contract">Contract</option>
                </select>
                <select
                        required
                        class="form-select pl-1"
                        aria-label="Default select example"
                        style="height: 50px; border-radius: 10px; transition: .3s; overflow-y: scroll;"
                        name="companies"
                        id="companies"
                        onchange="makeAjaxCall(this, 'searchSuggestionCompany')"
                >
                </select>
            </div>
            <div class="make-row">
                <button type="button">Save</button>
            </div>
        </div>
        <div class="jobs-area">
            <div class="all-housing mx-auto" id="mainJobsContainer"></div>
            <div class="job-details mx-auto" id="jobDetails">Select a Job to View details and APPLY!</div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="width: 60px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="content">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="width: 100px;">Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="./seeker-search.script.js"></script>
<script src="../common.script.js"></script>
<script src="../add-footer.script.js"></script>
</body>
</html>
