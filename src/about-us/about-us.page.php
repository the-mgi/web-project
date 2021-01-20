<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/43c8618748.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="./about-us.styles.css">
    <link rel="icon" href="../assets/svgs/final.svg">
    <title>About Us</title></head>
<body onload="afterOnload();">
<?php
include "../nav-bar/nav-bar.php";
?>
<main id="mainTag">
    <div class="main-housing">
        <?php
        include "../CRUD/server.php";
        $result = getAllDeveloperDetails();
        while ($row = current($result)) {
            $id = key($result);
            $imagePath = $row["imagePath"];
            $developerName = $row["developerName"];
            $developerInformation = $row["developerInformation"];
            echo "
            <div class='col-o'>
            <img src='$imagePath' alt='developer-image'>
            <div class='data'>
                <h3>$developerName</h3>
                <p>$developerInformation</p>
            </div>
        </div>
            ";
            next($result);
        }
        ?>
    </div>
</main>
<script src="../common.script.js"></script>
<script src="../add-footer.script.js"></script>
</body>
</html>