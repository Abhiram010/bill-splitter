<?php
require_once "../includes/db.php";
require_once "functions.php";
if (isset($_POST['signup'])) {
    $name = $_POST['username'];
    $email = $_POST['usermail'];
    $password = $_POST['password'];
    $passwords = $_POST['hey'];
    $passcheck = $password === $passwords;
    require_once "../includes/db.php";
    require_once "functions.php";
    echo $name, $email, $password, $passwords;
    echo "Hey";
    echo empty($passwords);
    echo "Hey";





    if (emptyInputSignup($name, $email, $password, $passwords) !== false) {
        echo $name, $email, $password, $passwords;
        header("Location: ../login.php?error=emptyinput");
        exit();
    }

    if (invalidEmail($email) !== false) {
        header("Location: ../login.php?error=invalidemail");
        exit();
    }
    if (!$passcheck) {
        header("Location: ../login.php?error=passwordmatch");
        exit();
    }
    $uidcheck = uidExists($conn, $username, $email);
    $theuidresult = $uidcheck[1];
    if ($theuidresult !== false) {
        header("Location: ../login.php?error=uidexists");
        exit();
    }

    createUser($conn, $name, $email, $password);
    // prepared statement
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
} else {
    header('Location: ../login.php');
}