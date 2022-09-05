<?php
session_start();
include './includes/db.php';

if (!isset($_SESSION['userId'])) {
    $a = $_SESSION['userid'];
    header("Location: login.php/code=$a");
} else {
    $ID = $_SESSION["userId"];
    $NAME = $_SESSION["userName"];
    $MAIL = $_SESSION["userEmail"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/account.css">
    <title>Account</title>
</head>

<body>
    <style>
    .content {
        margin-top: 8rem;
    }
    </style>
    <?php
    include "includes/navbar.php";
    $sql = "SELECT * FROM `users` WHERE `userId`='$ID';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>
    <main class="flex content ">
        <span class="flex flex-column">

            <img src="./images/logo.png" alt="" class="profilePhoto">
            <small style="margin: 1rem;text-align:center;">Welcome <?php echo $NAME; ?></small>
        </span>

        <div class="profileData flex">
            <div class="profileInfo">
                <h1 class="green text-center profileHeading">Account <i class="fa-solid fa-person"></i></h1>
                <span>
                    <h1 class="subProfileHead">
                        User Name:
                    </h1>

                    <h2 class="profileText"><?php echo $NAME; ?></h2>
                </span>
                <span>

                    <h1 class="subProfileHead">
                        User mail id:
                    </h1>
                    <h2 class="profileText"><?php echo $MAIL; ?></h2>
                </span>
                <span>
                    <h1 class="subProfileHead">
                        Money:
                    </h1>
                    <h2 class="profileText"><?php echo $row['coins']; ?></h2>
                </span>
                <span>
                    <h1 class="subProfileHead">
                        Reward points:
                    </h1>
                    <h2 class="profileText"><?php echo $row['reward']; ?></h2>
                </span>
            </div>
            <a href="./auth/logout.php" class="logout">Logout</a>

        </div>


    </main>


</body>

</html>