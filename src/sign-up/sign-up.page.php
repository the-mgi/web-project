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
    <title>Sign Up</title>
</head>
<body class="body-back-image" onload="afterOnload();">
<main>
    <div class="main-container">
        <div class="login-container">
            <div class="header">
                <img src="../assets/svgs/final.svg" alt="xd-copy-svg">
                <p>Job Stash</p>
            </div>
            <div class="main">
                <p>Sign Up</p>
                <hr>
                <form action="../CRUD/functions.php?function=signUp" method="POST" onsubmit="return false;" id="formSignUp">
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

                    <label for="firstName"></label>
                    <input type="text" id="firstName" name="firstName" placeholder="First Name" required
                           onkeyup="validateForm(this)">
                    <div class="is-invalid">Should be letters and 5-10 characters long</div>

                    <label for="lastName"></label>
                    <input type="text" id="lastName" name="lastName" placeholder="Last Name" required
                           onkeyup="validateForm(this)">
                    <div class="is-invalid">Should be letters and 5-10 characters long</div>

                    <label for="username"></label>
                    <input type="text" id="username" name="username" placeholder="Username" required
                           onkeyup="validateForm(this)">
                    <div class="is-invalid">Username must be alpha-numeric 5-12 characters long</div>

                    <label for="email"></label>
                    <input type="email" id="email" name="email" placeholder="Email Address" required
                           onkeyup="validateForm(this)">
                    <div class="is-invalid">Please Provide a valid email address</div>

                    <label for="password"></label>
                    <input type="password" id="password" name="password" placeholder="Password" required
                           onkeyup="validateForm(this)">
                    <div class="is-invalid">Must be alphanumeric (@, _ and - are also allowed) of 8-20 characters</div>

                    <button class="login-btn btn-" id="loginButton" type="submit" value="submit"
                            onclick="validateAll();">Sign up
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>
<script src="../common.script.js"></script>
<script src="../add-footer.script.js"></script>
</body>
</html>
