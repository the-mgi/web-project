<?php
echo "<header>
    <nav class='navbar navbar-expand-md navbar-dark'>
        <a href='../index.php' class='navbar-brand' style='color: black;'><img src='../assets/svgs/final.svg' alt='gg_image'
                                                                    width='50' height='50'> Job Stash</a>
        <button style='width: 60px' class='navbar-toggler' data-toggle='collapse' data-target='#navbar'>
            <span class='navbar-toggler-icon'></span>
        </button>

        <div id='navbar' class='navbar-collapse'>
            <ul class='navbar-nav' style='width: 100%;' id='ulBar'>";
if (isset($_SESSION["personType"])) {
    if ($_SESSION['personType'] == 'job_seeker') {
        echo '
                            <li class="nav-item"><a id="getStarted" href="../seeker-search/seeker-search.page.php" class="nav-link">Get Started</a></li>
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

echo "            </ul>
        </div>
    </nav>
</header>";