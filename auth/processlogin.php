<?php
require_once "../includes/db.php";
require_once 'functions.php';

if (isset($_POST['login'])) {
    $username = $_POST['loginusermail'];
    $password = $_POST['loginpassword'];

    if (empty($username) || empty($password)) {
        header("Location: ../login.php?error=loginemptyinput");
        exit();
    }
    loginUser($conn, $username, $password);
} else {
    header("Location: index.php");
}