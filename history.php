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
    ?>
    <main class="content flex Dashboard">
        <h1 style='font-weight: 300; text-align: center;'>History <i class="fa-solid fa-money-bill-transfer green"></i>
        </h1>

        <?php
        include "./includes/navbar.php";
        include "./includes/db.php";
        $userId = $_SESSION['userId'];
        $gettransactions = "SELECT * FROM `transcations` WHERE `userId`='$userId';";
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
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
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
                        <td>$transactioncheck[date]</td>
                        <td>$transactioncheck[time]</td>
                        <td>Completed</td>
                    </tr>";
            }
            echo "</tbody>
                </table>";
        } else {
            echo "<img src='./images/zeroTransactions.svg' alt='no transactions' class='nogroups'><h2 style='font-weight:300; font-size:1.5rem;margin:25px;'>No Transactions</h2>";
        }
        ?>

    </main>
</body>

</html>