<?php
session_start();
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
    <link rel="stylesheet" href="./blog-preview.styles.css">
    <link rel="icon" href="../assets/svgs/final.svg">
    <title>Blogs</title>
</head>
<body onload="{afterOnload(); allInitializations();}">
<?php
include "../nav-bar/nav-bar.php";
?>
<main>
    <div class="m" id="main-container">
        <div class="sort-functionality" id="sortFunctionality">
            <label for="selectBox" style="width: 0; height: 0"></label>
            <select
                    required
                    class="form-select pl-3"
                    aria-label="Default select example"
                    style="width: 200px; height: 50px; border-radius: 5px; margin-bottom: 15px; transition: .3s"
                    name="personType"
                    onchange="sortBlogs(this)"
            >
                <option value="" selected>Sort by</option>
                <option value="date">Date</option>
                <option value="numberOfReads">Popularity</option>
                <option value="readingTime">Reading Time</option>
                <option value="showBookmarked">Bookmarked</option>
            </select>
        </div>
        <div class="h" id="allPreviews"></div>
    </div>
</main>
<script src="../common.script.js"></script>
<script src="../add-footer.script.js"></script>
<script src="./blog-preview.script.js" type="text/javascript"></script>
</body>
</html>
