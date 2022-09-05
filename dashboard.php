<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/group.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <!-- jquery cdn js cdn -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!-- sweetalert2 js cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.29/sweetalert2.all.js"
        integrity="sha512-W5SwJPyOiXXyfvtnUlX/T1s6PLgKSuUcSD++cdbY0zOPi4/Ymu4dCzBHnlH5OPxKPRp6XyBp+3jvmxuMyCsoaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://kit.fontawesome.com/e8988c25e2.js" crossorigin="anonymous"></script>
    <?php
    if (!isset($_SESSION['userId'])) {
        header("Location: login.php");
    }
    ?>
</head>

<body>
    <?php
    include "./includes/navbar.php";
    include "./includes/db.php";
    // set coins 
    $userId = $_SESSION['userId'];
    $sql = "SELECT * FROM `users` WHERE `userId` = '$userId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $rewards = $row['reward'];
    $coins = $row['coins'];


    ?>
    <main class="content flex Dashboard">
        <div class="flex floating-bars">
            <h3><i class="fa-solid fa-wallet green"></i>Wallet: <?= $coins; ?></h3>
            <h3><i class="fa-solid fa-gift" style="color: goldenrod;"></i>Rewards points: <?= $rewards; ?></h3>
            <button class="joinbutton" onclick="joinme()">Join <i class="fa-solid fa-hand-point-up"></i></button>

        </div>


        <h1 style="font-weight: 300; text-align: center;">Groups <i class="fa-solid fa-user-group green"></i></h1>

        <?php
        // include db
        include "./includes/db.php";
        echo $_SESSION['userId'];
        $sql = "SELECT * FROM `groupusers` WHERE `userId` = '$_SESSION[userId]'";
        $result = mysqli_query($conn, $sql);
        $groupscheck = mysqli_num_rows($result);
        if ($groupscheck > 0) {


            echo "<div class='groups flex'>";
            while ($resultCheck = mysqli_fetch_assoc($result)) {

                $link = $resultCheck['groupRoom'];
                $sql2 = "SELECT * FROM `groups` WHERE `groupRoom` = '$link'";
                $result2 = mysqli_query($conn, $sql2);



                while ($resultCheck2 = mysqli_fetch_assoc($result2)) {
                    echo "<div class='card'>
                    
                    <div class='card-header'>
                        <h5 class='green'>Group Name:</h5>
                            <h3>$resultCheck2[groupName]</h3>
                            <h5 class='green'>Group code:</h5>
                            <h4>$resultCheck2[groupRoom]</h4>
                        </div>
                            <div class='card-action'><a href='group.php?code=$resultCheck2[groupRoom]' class='leavebutton-green'>View</a>
                            <a href='./operate/leave.php?code=$resultCheck2[groupRoom]' class='leavebutton'>Leave</a></div>
                        </div>";
                    // echo $resultCheck2['groupName'], $resultCheck2['groupRoom'];
                }
            }
            echo "</div>";
        } else {
            echo "<img src='./images/zeroGroups.svg' alt='no groups' class='nogroups'><h2 style='font-weight:300; font-size:1.5rem;margin:25px;'>Join in a Group or Create in spiltbill</h2>";
        }

        ?>
        <style>
        .groups {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            width: 20rem;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
            transition: 0.5s;
            position: relative;
            background: none;
            /* blur background with green animated background image */
            background: url(./images/blur.svg);

        }

        @keyframes animate {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 100% 0;
            }
        }

        .card-header {
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: flex-start;
            padding: 15px;
        }

        .card-header h3,
        h4 {
            margin: 0 0 10px;
        }

        .card-action {
            display: flex;
            justify-content: center;
            align-items: center;

        }

        .card-action a {
            text-decoration: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: 0.5s;
        }

        .cardBackgroundImg {
            position: absolute;
            /* center the image */

            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* make it responsive */
            width: 100%;
            z-index: -1;
            filter: blur(1px);
            /* filter: brightness(50%); */
            height: 10rem;

        }
        </style>

        <h1 style='font-weight: 300; text-align: center;'>Transactions <i
                class="fa-solid fa-money-bill-transfer green"></i>
        </h1>

        <?php
        $userId = $_SESSION['userId'];
        $gettransactions = "SELECT * FROM `transcations` WHERE `userId`='$userId' ORDER BY `id` DESC LIMIT 5;";
        $transactionresult = mysqli_query($conn, $gettransactions);
        $transactioncheck = mysqli_num_rows($transactionresult);

        if ($transactioncheck > 0) {
            echo "<div class='tablerow1 flex'>
                <table class='table1'>
                    <thead class='thead'>
                        <tr>
                            <th>Transaction Id</th>
                            <th>Group ID</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody class='tbody'>";
            while ($transactioncheck = mysqli_fetch_assoc($transactionresult)) {
                $getsentname = "SELECT * FROM `users` WHERE `userId` = '$transactioncheck[touserId]'";
                $sentnameresult = mysqli_query($conn, $getsentname);
                // get name of the user
                $sentnamerow = mysqli_fetch_assoc($sentnameresult);
                // $sentname = $sentnamerow['userName'];

                echo "<tr>
                        <td>$transactioncheck[transactionId]</td>
                        <td>$transactioncheck[groupRoom]</td>
                        
                        <td>$transactioncheck[amount]</td>
                        
                       
                    </tr>";
            }
            echo "</tbody>
                </table>";
        } else {
            echo "<img src='./images/zeroTransactions.svg' alt='no transactions' class='nogroups'><h2 style='font-weight:300; font-size:1.5rem;margin:25px;'>No Transactions</h2>";
        }

        ?>
        <center> <a href="history.php" class="green" style="text-decoration:none;text-align:center;">View all
                transactions <i class="fa-solid fa-link" style='color:white;'></i></a> </center>
        <div class="popup" id="popup2">
            <div class="popup_inner">
                <h1>Join group</h1>
                <form action='' method='post' class="flex popform" id="popform">
                    <span class="flex" style="flex-direction:column;">

                        <label>
                            Group ID:
                        </label>
                        <input name='groupnumber' />
                        <small>public number</small>
                    </span>
                    <span>
                        <button name='joingroup' type='submit'>Submit</button>
                        <button id='closeAddExpenseForm' style='margin-top:3rem;'>Close</button>
                    </span>
                </form>
            </div>
        </div>


    </main>
    <!-- jquery cdn js cdn -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!-- sweetalert2 js cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.29/sweetalert2.all.js"
        integrity="sha512-W5SwJPyOiXXyfvtnUlX/T1s6PLgKSuUcSD++cdbY0zOPi4/Ymu4dCzBHnlH5OPxKPRp6XyBp+3jvmxuMyCsoaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
    function joinme() {
        document.getElementById('popup2').style.display = 'flex';
    }
    </script>
    <?php
    $usersingroup = [];
    if (isset($_POST['joingroup'])) {
        $groupnumber = $_POST['groupnumber'];
        $sql = "SELECT * FROM `groups` WHERE `groupRoom` = '$groupnumber'";
        $groupusercheck = "SELECT * FROM `groupusers` WHERE `groupRoom` = '$groupnumber'";
        $groupuserresult = mysqli_query($conn, $groupusercheck);
        $result = mysqli_query($conn, $sql);
        $resultcheck = mysqli_num_rows($result);
        // appending the users into array
        while ($checkifexists = mysqli_fetch_assoc($groupuserresult)) {
            // echo "<script>alert($checkifexists[userId]);</script>";
            array_push($usersingroup, $checkifexists['userId']);
        }

        // check the group if exists
        if ($resultcheck > 0) {
            // check if the user is already in the group
            if (!in_array($userId, $usersingroup)) {
                $userId = $_SESSION['userId'];
                // if user not in group
                $sql2 = "INSERT INTO `groupusers` (`userId`, `groupRoom`) VALUES ('$_SESSION[userId]', '$groupnumber')";
                $result2 = mysqli_query($conn, $sql2);
                if ($result2) {
                    echo "<script>
    Swal.fire({
        title: 'success',
        text: 'Group found',
        icon: 'success',
        confirmButtonText: 'Ok'
    })
    </script>";

                    echo "<script>
    window.location.href = 'dashboard.php'
    </script>";
                }
            } else {

                echo "<script>
    Swal.fire({
        title: 'Error',
        text: 'User already in group',
        icon: 'error',
        confirmButtonText: 'Ok'
    })
    </script>";
            }
        } else {
            echo "<script>
    Swal.fire({
        title: 'Error',
        text: 'Incorrect group number',
        icon: 'error',
        confirmButtonText: 'Ok'
    })
    </script>";
        }
    }
    ?>

</body>

</html>
