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
<body onload="afterOnload();">
<?php
include "../nav-bar/nav-bar.php";
?>
<main>
    <div class="sort-functionality" id="sortFunctionality">
    </div>
    <div class="m" id="main-container">
        <?php
        include "../CRUD/server.php";
        $allBlogs = getAllBlogsData();
        while ($row = current($allBlogs)) {
            $idBlog = key($allBlogs);
            $writtenBy = $row["writtenBy"];
            $heading = $row["heading"];
            $description = $row["description"];
            $numberOfTimesRead = $row["numberOfTimesRead"];
            $minsRead = $row["minsRead"];
            $writtenDate = $row["writtenDate"];
            echo "
            <div class='container-o'>
                <a href='../complete-blog/complete-blog.page.php?id=$idBlog' style='text-decoration: none; color: inherit;'>
                    <div class='blog-preview' id=$idBlog>
                    <div class='hover-written-by'>$writtenBy</div>
                    <div class='con'>
                        <div class='col'>
                            <h2>$heading</h2>
                            <h3>$description</h3>
                        </div>
                        <div class='row'>
                            <div class='right row'>
                                <p class='for-margin' style='margin-right: 30px'>
                                    <span>&#128339;</span>
                                    Reads:
                                    <span>$numberOfTimesRead</span>
                                </p>
                                <p class='for-margin'>
                                    <span>&#128214;</span>
                                    <span>$minsRead</span>
                                    mins read
                                </p>
                                <p class='for-margin'>$writtenDate</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
            ";
            next($allBlogs);
        }
        ?>
    </div>
</main>
<script src="../common.script.js"></script>
<script src="../add-footer.script.js"></script>
</html>
