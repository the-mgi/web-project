<?php
session_start();
if (isset($_SESSION["username"])) {
    print_r($_SESSION);
    $personType = $_SESSION["personType"];
    if ($personType == 'job_seeker') {
        header("location: ../seeker-search/seeker-search.page.php");
    } else {
        header("location: ../employer-jobs-status/employer-jobs-status.page.php");
    }
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
    <link rel="stylesheet" href="../styles.css">
    <link rel="icon" href="../assets/svgs/final.svg">
    <title>Forgot Password</title>
    <style>

    </style>
</head>
<body class="body-back-image">
<div class="main-container">
    <div class="login-container">
        <div class="header">
            <img src="../assets/svgs/final.svg" alt="xd-copy-svg">
            <p>Job Stash</p>
        </div>
        <div class="main">
            <p>Forgot Your Password?</p>
            <hr>
            <form action="" onsubmit="return false;" id="formSignUp">
                <div class="select-box">
                    <select
                            required
                            class="form-select pl-3"
                            aria-label="Default select example"
                            style="width: 408px; height: 50px; border-radius: 5px; margin: 15px; transition: .3s"
                    >
                        <option value="" selected>You are...</option>
                        <option value="1">Employer</option>
                        <option value="2">Job Seeker</option>
                    </select>
                </div>
                <label for="email"></label>
                <input type="email" class="email" id="email" name="email" placeholder="Email Address" required
                       onkeyup="validateForm(this)">
                <div class="is-invalid">Please provide a valid email address</div>

                <button class="login-btn btn-" id="loginButton" type="submit" value="submit"
                        onclick="forForgotPassword();">Send Verification Email
                </button>
            </form>
        </div>
    </div>
</div>
<script src="../common.script.js"></script>
</body>
</html>
