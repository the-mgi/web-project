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
    <link rel="icon" href="../assets/svgs/final.svg">
    <title>Search For a Job</title>
</head>
<body onload="{initializeAll();afterOnload();}">
<?php
include "../nav-bar/nav-bar.php";
?>
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
                        style="height: 50px; border-radius: 5px; transition: .3s;"
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
                        style="height: 50px; border-radius: 5px; transition: .3s; overflow-y: scroll;"
                        name="companies"
                        id="companies"
                        onchange="makeAjaxCall(this, 'searchSuggestionCompany')"
                >
                </select>
            </div>
        </div>
        <div class="jobs-area">
            <div class="all-housing mx-auto" id="mainJobsContainer"></div>
            <div class="job-details mx-auto" id="jobDetails">Select a Job to View details and APPLY!</div>
        </div>
    </div>
</main>
<script src="./seeker-search.script.js"></script>
<script src="../common.script.js"></script>
<script src="../add-footer.script.js"></script>
</body>
</html>
