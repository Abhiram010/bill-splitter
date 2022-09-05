<?php
session_start();
include '../includes/db.php';
$groupCode = $_GET['code'];
$userId = $_SESSION['userId'];
$sql = "DELETE FROM `groupusers` WHERE `groupRoom` = '$groupCode' AND `userId` = '$userId'";
$result = mysqli_query($conn, $sql);
if ($result) {
    header("Location: ../dashboard.php");
    exit();
}
