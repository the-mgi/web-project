<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/43c8618748.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="login.styles.css">
</head>

<body class="body-back-image" onload="afterOnload();">
<div class="main-container">
    <div class="login-container">
        <div class="header">
            <img src="../assets/svgs/final.svg" alt="xd-copy-svg">
            <p>Job Stash</p>
        </div>
        <div class="main">
            <p>LOGIN</p>
            <hr>
            <form action="../CRUD/functions.php?function=login" method="POST" onsubmit="return false;" id="formSignUp">
                <div class="select-box">
                    <select
                            required
                            class="form-select pl-3"
                            aria-label="Default select example"
                            style="width: 408px; height: 50px; border-radius: 10px; margin: 15px; transition: .3s"
                            name="personType"
                    >
                        <option value="" selected>You are...</option>
                        <option value="employer">Employer</option>
                        <option value="job_seeker">Job Seeker</option>
                    </select>
                </div>
                <label for="email"></label>
                <input type="email" class="email" name="email" id="email" placeholder="Email Address" required onkeyup="validateForm(this)">
                <div class="is-invalid">Please Provide a valid email address</div>

                <label for="password"></label>
                <input type="password" class="password" name="password" id="password" placeholder="Password" required onkeyup="validateForm(this)">
                <div class="is-invalid">Must be alphanumeric (@, _ and - are also allowed) of 8-20 characters</div>

                <p class="txt"><a href="../forgot-pass/forgot-pass.page.html">Forgot Password?</a></p>
                <button class="login-btn btn-" id="loginButton" type="submit" value="submit" onclick="forLogin();">Login</button>
                <p class="txt-t"><a href="../sign-up/sign-up.page.php">Don't have an account? Create a New One!</a></p>
                <p class="txt-t sign-up-with">Or Sign Up With</p>
            </form>
            <div class="o-auth-container">
                <div class="google" role="button">
                    <img class="img-last" src="../assets/svgs/google.svg" alt="google-logo">
                </div>
                <div class="facebook" role="button">
                    <img class="img-last" src="../assets/svgs/facebook.svg" alt="facebook-logo">
                </div>
                <div class="github" role="button">
                    <img class="img-last g" src="../assets/svgs/github-sign.svg" alt="github-logo">
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../common.script.js"></script>
<script src="../add-footer.script.js"></script>
</body>

</html>

<!-- is-invalid class can be used with javascript to mark input field invalid-->
