<?php
session_start();
include '../includes/db.php';
function
genrateRoom($conn)
{

    $groupRoom = rand(100000, 999999);
    $sql = "SELECT * FROM `groups` WHERE `groupRoom` = '$groupRoom'";
    $counter = 1;
    // result using fetchArray 
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        genrateRoom($conn);
        $counter++;
        if ($counter > 899999) {
            echo "Rooms are full";
        }
    } else {
        return $groupRoom;
    }
}

$ID = $_SESSION['userId'];
include "../includes/db.php";
if (isset($_POST['newgroup'])) {


    $groupName = $_POST['groupname'];
    $groupAmount = 0;
    $groupRoom = genrateRoom($conn);

    if (empty($groupName)) {
        header("Location: spilt.php?error=emptyinput");
        exit();
    }
    echo  $groupRoom;
    $sql = "INSERT INTO `groups`(`groupName`, `groupRoom`, `groupAmount`, `groupCreator`) VALUES ('$groupName','$groupRoom','$groupAmount','$ID');";
    $groupUserInsert = "INSERT INTO `groupusers` (`groupRoom`, `userId`) VALUES ('$groupRoom','$ID');";
    $insertingUser = mysqli_query($conn, $groupUserInsert);
    echo $insertingUser;
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: ../group.php?code=$groupRoom");
        exit();
    } else {
        header("Location: spilt.php?error=stmtfailed");
        exit();
    }
}