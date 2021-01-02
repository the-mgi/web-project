<?php
session_start();
include "./server.php";
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function']; // logout
    if ($function == 'logout') {
        session_destroy();
        header("location: ../login/login.page.php");
    } else if ($function == 'login') {
        $emailAddress = $_POST["email"];
        $password = $_POST["password"];
        $personType = $_POST["personType"];
        $result = verifyUser($emailAddress, $password, $personType);

        if (!is_bool($result)) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION["personType"] = $personType;
                $_SESSION["firstName"] = $row["firstName"];
                header("location: ../index.php");
            }
        } else {
            echo "<script>alert('Username and password combination does not exists.')</script>";
        }
    } else if ($function == 'subscribeToNewsletter') {
    }
}