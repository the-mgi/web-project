<?php
session_start();
if (!isset($_SESSION["personType"])) {
    header("location: ../login/login.page.php");
} else {
    if ($_SESSION["personType"] == 'employer') {
        header("location: ../employer-jobs-status/employer-jobs-status.page.php");
    }
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
    <link rel="stylesheet" href="../external-libraries/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="cv.styles.css">
    <link rel="icon" href="../assets/svgs/final.svg">
    <title>Create CV</title>
</head>
<body onload="{initializeAll();afterOnload();}">
<?php
include "../nav-bar/nav-bar.php";
?>
<main>
    <div class="main-container m-5">
        <!--    <div class="bg-image"></div>-->
        <div class="login-container">
            <div class="main">
                <p>Create Resume</p>
                <hr>
                <form action="../CRUD/functions.php?function=updateCV" method="POST" id="cvForm">
                    <div class="select-box row-o">
                        <select
                                required
                                class="form-select px-2"
                                aria-label="Default select example"
                                style="width: 408px; height: 50px; border-radius: 5px; margin: 10px; transition: .3s"
                                id="select-box"
                                disabled
                        >
                            <option>You are...</option>
                            <option value="employer">Employer</option>
                            <option value="job_seeker" selected>Job Seeker</option>
                        </select>
                        <label for="contact"></label>
                        <input type="text" id="contact" name="contact" placeholder="Contact No." required
                               title="Contact No. +923xxxxxxxxx" onkeyup="makeVisibleDiv(this);">
                    </div>

                    <div class="row-o">
                        <label for="firstName"></label>
                        <?php
                        echo "<input type='text' id='firstName' name='firstName' value='" . ucfirst($_SESSION["firstName"]) . "' placeholder='First Name' required disabled>"
                        ?>

                        <label for="lastName"></label>
                        <?php
                        echo "<input type='text' id='lastName' value='" . ucfirst($_SESSION["lastName"]) . "' placeholder='Last Name' required disabled>"
                        ?>
                    </div>

                    <div class="row-o">
                        <label for="email"></label>
                        <?php
                        echo "<input type='email' class='email' id='email' value='" . $_SESSION["emailAddress"] . "' placeholder='Email Address' required disabled>"
                        ?>

                        <label for="datePicker"></label>
                        <input type="text" id="datePicker" name="datePicker"
                               placeholder="Date Of Birth. Format: yy-mm-dd" required
                               autocomplete="off">
                    </div>

                    <div class="row-o">
                        <label for="countries"></label>
                        <?php
                        include "../CRUD/server.php";
                        $allCountries = getAllCountries();
                        echo '<select
                                required
                                class="form-select px-2"
                                aria-label="Default select example"
                                style="width: 408px; height: 50px; border-radius: 5px; margin: 10px; transition: .3s"
                                id="countries"
                                onchange="updateCitiesSelectBox()"
                                name="countrySelected"
                        >
                        <option value="" selected>Select Your country</option>
                        ';
                        if (!is_bool($allCountries)) {
                            if ($allCountries->num_rows > 0) {
                                while ($row = $allCountries->fetch_assoc()) {
                                    $countryName = $row["country_name"];
                                    $countryCode = $row["country_code"];
                                    echo "<option value='$countryCode'>$countryName</option>";
                                }
                            }
                        }
                        echo "</select>";
                        ?>
                        <label for="cities"></label>
                        <select
                                required
                                class="form-select px-2"
                                aria-label="Default select example"
                                style="width: 408px; height: 50px; border-radius: 5px; margin: 10px; transition: .3s"
                                id="cities"
                                name="citySelected"
                                disabled
                        >
                            <option value="" selected>Select Your City</option>
                            '
                        </select>
                    </div>

                    <div class="row-o">
                        <label for="streetAddress"></label>
                        <input type="text" id="streetAddress" name="streetAddress" placeholder="Street Address"
                               required>
                        <label for="state"></label>
                        <input type="text" placeholder="state" id="state" name="state" required>
                    </div>

                    <div class="row-o">
                        <label for="area"></label>
                        <input type="text" placeholder="Area" id="area" name="area" required
                        >
                    </div>

                    <div class="summary-pencil-col" id="topCon">
                        <div id="summaryPencil" class="summary-pencil">
                            Summary About Yourself
                            <span id="pencil" role="button" onclick="summaryToTextareaContainer()">&#128393;</span>
                        </div>
                        <p class="summary-no-edit" id="actualSummary"></p>
                    </div>

                    <div class="summary-pencil-col" id="skillDisplayCon">
                        <div id="skillsPencil" class="summary-pencil" role="button">
                            Skills
                            <span id="pencil-skills" style="font-size: 25px" onclick="addSkillContainer()">&#x2b;</span>
                        </div>
                        <div class="all-skills-display" id="skillsContainer"></div>
                    </div>

                    <div class="summary-pencil-col" id="educationDisplayCon">
                        <div id="educationPlus" class="summary-pencil" role="button">
                            Education
                            <span id="educationPlusSymbol" style="font-size: 25px" onclick="addEducationContainer()">&#x2b;</span>
                        </div>
                        <div class="all-skills-display" id="educationContainer"></div>
                    </div>

                    <div class="summary-pencil-col" id="experienceContainerCon">
                        <div id="experiencePlus" class="summary-pencil" role="button">
                            Experience
                            <span id="experiencePlusSymbol" style="font-size: 25px" onclick="addExperienceContainer()">&#x2b;</span>
                        </div>
                           <div class="all-skills-display" id="experienceContainer"></div>
                    </div>

                    <button style="width: 100%; margin: 0" class="login-btn btn-" id="loginButton" type="submit"
                            value="submit" onclick="forwardO();">Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript"
        src="../external-libraries/http_ajax.googleapis.com_ajax_libs_jquery_3.5.1_jquery.js"></script>
<script type="text/javascript" src="../external-libraries/jquery-ui.min.js"></script>

<script src="./cv.script.js"></script>
<script src="./form-validation.script.js"></script>
<script src="../common.script.js"></script>
<script src="../add-footer.script.js"></script>
</body>
</html>
