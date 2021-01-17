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
    <link rel="stylesheet" href="../seeker-search/seeker-search.styles.css">
    <title>Jobs I applied</title>
</head>
<body onload="afterOnload();">
<?php
include "../nav-bar/nav-bar.php";
?>
<main>
    <div class="main-container-jobs">
        <div class="single-job-container-applied m-5"></div>
    </div>
</main>

<script type="text/javascript" src="../common.script.js"></script>
<script type="text/javascript" src="./applied-for.script.js"></script>
<script type="text/javascript" src="../add-footer.script.js"></script>
</body>
</html>
