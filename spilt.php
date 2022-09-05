<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spilt Amount</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/split.css">
    <!-- jquery cdn js cdn -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!-- sweetalert2 js cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.29/sweetalert2.all.js"
        integrity="sha512-W5SwJPyOiXXyfvtnUlX/T1s6PLgKSuUcSD++cdbY0zOPi4/Ymu4dCzBHnlH5OPxKPRp6XyBp+3jvmxuMyCsoaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php
    if (!isset($_SESSION['userId'])) {
        header("Location: login.php");
    }

    ?>
</head>

<body>
    <?php
    include "./includes/navbar.php";

    ?>
    <style>
    .content {
        margin-top: 8rem;
    }
    </style>
    <main class="content flex spilt">
        <img src="./images/spilt.svg" alt="" class="introImg">

        <form action="./operate/newGroup.php" method="post" class="flex spiltform ">
            <h2>Create Group</h2>
            <label for="groupname">Name</label>
            <input type="text" name="groupname" required>
            <button type="submit" name="newgroup">Submit</button>
        </form>


    </main>

</body>

</html>