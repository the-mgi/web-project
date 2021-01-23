<?php
session_start();
if (!isset($_REQUEST["id"])) {
    header("location: ../blog-preview/blog-preview.page.php");
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
    <link rel="stylesheet" href="./complete-blog.styles.css">
    <link rel="icon" href="../assets/svgs/final.svg">
    <title>Read Blog</title>
</head>
<body onload="{afterOnload(); initializationsVars();}">
<?php
include "../nav-bar/nav-bar.php";
?>
<main>
    <div class="con" id="con">
        <!--        --><?php
        include "../CRUD/server.php";
        include "../CRUD/requiredFunctions.php";

        $id = $_REQUEST['id'];
        if (isset($_SESSION["username"])) {
            $username = $_SESSION["username"];
        } else {
            $username = "";
        }
        $singleBlog = searchForABlog($id, $username);
        while ($row = current($singleBlog)) {
            $imageSource = "";
            $writtenBy = $row["writtenBy"];
            $heading = $row["heading"];
            $description = $row["description"];
            $content = $row["content"];
            $numberOfTimesRead = $row["numberOfTimesRead"];
            $minsRead = $row["minsRead"];
            $writtenDate = $row["writtenDate"];
            $isBookmarked = $row["isBookmarked"];
            $isBookmarked == 'TRUE' ?
                $imageSource = "../assets/svgs/bookmarkFilled.svg" :
                $imageSource = "../assets/svgs/bookmark.svg";
            echo "
                <div class='main-seeker-container'>
                    <div class='main-container'>
                        <div class='popup-container'>
                            <div class='popup' id='popup'>Bookmark Removed</div>
                        </div>
                        <div class='date-data'>
                            <p class='add-margin'>
                                <span>&#128339;</span>
                                Reads:
                                <span id='numberOfTimesRead'>$numberOfTimesRead</span>
                            </p>
                            <p class='add-margin'>
                                <span>&#128214;</span>
                                <span id='minRead'>$minsRead</span>
                                mins read
                            </p>
                            <p class='add-margin' id='writtenDate'>
                                <span>&#128198;</span>
                                <span>$writtenDate</span>
                            </p>
                            <p>
                                <span role='button' onclick='bookmarkAddOrRemove(this)'><img src='$imageSource' alt='bookmark-icon' style='width: 18px;opacity: .6;'></span>
                            </p>
                        </div>
                        <div class='heading-desc'>
                            <h1 id='heading'>$heading</h1>
                        </div>
                        <div class='name-date' style='margin-top: 20px;'>
                            <div class='name'>
                                <h4>by: </h4>
                                <div class='app-profile-title' style='background-color: " . randomColor() . "'>
                                    <p id='firstLetter'>" . substr($writtenBy, 0, 1) . "</p>
                                </div>
                                <h4 id='writtenBy'>$writtenBy</h4>
                            </div>
                            <div class='content' style='margin-top: 20px;'>
                                <h2 id='description' style='opacity: .7'></h2>
                                <p id='contentBlog'>$content</p>
                            </div>
                        </div>
                    </div>
                </div>
            ";
            next($singleBlog);
        }
        ?>
    </div>
</main>
<script src="../common.script.js"></script>
<script src="../add-footer.script.js"></script>
<script src="./complete-blog.script.js"></script>
</body>
</html>
