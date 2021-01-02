<?php
session_start();
include "../CRUD/server.php";
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$username = $_POST["username"];
$emailAddress = $_POST["email"];
$password = $_POST["password"];
$personType = $_POST["personType"];
if (checkIfUsernameOrEmailExists($username, $emailAddress, $personType)) {
    header("location: ../sign-up/sign-up.page.php");
} else {
    addUserWhileSigningUp($firstName, $lastName, $username, $emailAddress, $password, $personType);
    $_SESSION["personType"] = $personType;
    header("location: ../main-seeker/index.php");
}
