<?php
if ($_SESSION["type"] == "Employer") {
    echo "<script>console.log('i received employer');</script>";
} else if ($_SESSION["type"] == "Job Seeker") {
    echo "<script>console.log('i received Job Seeker')</script>";
} else {
    header("location: ../login/login.page.html");
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
    <link rel="stylesheet" href="seeker-search.styles.css">
    <title>Title</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-md navbar-dark">
        <a href="#" class="navbar-brand" style="color: black;"><img src="../assets/svgs/final.svg" alt="gg_image"
                                                                    width="50" height="50"> Job Stash</a>
        <button style="width: 60px" class="navbar-toggler" data-toggle="collapse" data-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbar" class="navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item"><a id="getStarted" href="../seeker-search/seeker-search.page.php" class="nav-link">Get Started</a></li>
                <li class="nav-item"><a id="jobs" href="#" class="nav-link">Jobs I Applied</a></li>
                <li class="nav-item"><a id="newJob" href="../create-job/create-job.page.html" class="nav-link">Create a new Job</a></li>
                <li class="nav-item"><a id="alreadyPostedJobs" href="../employer-jobs-status/employer-jobs-status.page.html" class="nav-link">My Jobs</a></li>
            </ul>
        </div>
    </nav>

</header>
<main>
    <div class="complete-container m-2">
        <div class="top-search-criteria mx-auto my-3">
            <div class="make-row">
                <label for="keyword"></label>
                <input type="text" id="keyword" placeholder="Keywords">

                <label for="jobPostName"></label>
                <input type="text" id="jobPostName" placeholder="Job Post / Job Name">
            </div>
            <div class="make-row">
                <select
                        required
                        class="form-select pl-1"
                        aria-label="Default select example"
                        style="height: 50px; border-radius: 10px; transition: .3s;"
                        id="partFull"
                >
                    <option value="fullTime" selected>Full Time</option>
                    <option value="partTime">Part Time</option>
                </select>
                <select
                        required
                        class="form-select pl-1"
                        aria-label="Default select example"
                        style="height: 50px; border-radius: 10px; transition: .3s;"
                        id="companies"
                >
                    <option value="" selected>Select Company</option>
                </select>
            </div>
            <div class="make-row">
                <button type="button">Save</button>
            </div>
        </div>
        <div class="jobs-area m-auto">
            <div class="all-housing mx-auto" id="mainJobsContainer"></div>
            <div class="job-details mx-auto">
                <h3 id="postName">Customer Sales Representative</h3>
                <h5><span>by:</span> <strong id="company">Google Inc.</strong></h5>
                <h5><span>Company Ratings:</span> <strong id="obtainedRating">4.8</strong> out of <strong>5</strong>
                </h5>
                <h5><span>Location:</span> <strong id="jobLocation">Islamabad</strong></h5>
                <h5><strong>Job Status: </strong> <span class="badge rounded-pill bg-primary"
                                                        style="color: white; font-size: 18px;">Open</span>
                </h5>
                <hr style="width: 100%; border-color: #cdc9c9;">
                <p><strong>Job Description</strong><br> <span id="description">Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                    unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived
                    not only five centuries, but also the leap into electronic typesetting, remaining essentially
                    unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem
                    Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including
                    versions of Lorem Ipsum.</span></p>
                <p><strong>Responsibilities</strong><br><span id="responsibilities">Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                    unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived
                    not only five centuries, but also the leap into electronic typesetting, remaining essentially
                    unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem
                    Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including
                    versions of Lorem Ipsum.</span></p>
                <p><strong>Salary</strong><br><strong>PKR</strong> <span id="minSalary">10000</span> - <span
                            id="maxSalary">20000</span></p>
                <button><span class="fa fa-check"></span> Apply Now</button>
            </div>
        </div>
    </div>
</main>
<footer>
    <div class="footer-main-row-def">
        <div class="col-zero col-footer">
            <h3 class="footer-h3">Our Company</h3>
            <h5><span class="fa fa-id-card-alt span-footer"></span> <a href="../about-us/about-us.page.html">About
                    Us</a></h5>
            <h5><span class="fas fa-blog span-footer"></span> <a href="../blog-preview/blog-preview.page.html">Blogs</a>
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
<script src="./seeker-search.script.js"></script>
<script src="../employer-jobs-status/employer-job-status-COMMON.script.js"></script>
<script src="../common.script.js"></script>
</body>
</html>
