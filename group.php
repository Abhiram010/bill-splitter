<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
    exit();
}
include './includes/db.php';
$code  = $_GET['code'];
$debtCounter = 0;
$sql = "SELECT * FROM `groups` WHERE `groupRoom` = '$code'";
$result = mysqli_query($conn, $sql);
$groupinfo = mysqli_fetch_assoc($result);
$result = mysqli_num_rows($result);
if (!empty($code)) {
    if (!$result > 0) {
        header("Location: login.php?error=none");
    }
} else {
    header("Location: login.php?error=none");
}
// group data
$Name = $groupinfo['groupName'];
$Room = $groupinfo['groupRoom'];
$Amount = $groupinfo['groupAmount'];
$AdminId = $groupinfo['groupCreator'];
$payment = $groupinfo['payment'];
$groupwallet = $groupinfo['wallet'];
$clearing = $groupinfo['clearing'];
$getAdminInfo = "SELECT userName,userEmail FROM users WHERE `userId` = '$AdminId'";
$result = mysqli_query($conn, $getAdminInfo);
$adminData = mysqli_fetch_assoc($result);
// Admin data
$admin = $adminData['userName'];
$adminMail = $adminData['userEmail'];
// get users count
$userCount = "SELECT * FROM groupusers WHERE `groupRoom`='$code'";
$resultusers = mysqli_query($conn, $userCount);
$userId = $_SESSION['userId'];
$forStatus  = "SELECT * FROM `groupusers` WHERE `groupRoom` = '$code' AND `userId` = '$userId'";
$resultStatus = mysqli_query($conn, $forStatus);
$status = mysqli_fetch_assoc($resultStatus);
$status = $status['status'];
$count = 0;
while ($resultuserCount = mysqli_fetch_assoc($resultusers)) {
    $count = $count + 1;
}
$sqlgetexpenses = "SELECT * FROM `expenses` WHERE `groupID`='$code'";
$runexpense =  mysqli_query($conn, $sqlgetexpenses);
$amounts = [];
$expensesdetails = [];
while ($row = mysqli_fetch_assoc($runexpense)) {
    $amount = (int)$row['amount'];
    array_push($amounts, $amount);
    $details = $row['userID'] . "?#" . $row['amount'];
    array_push($expensesdetails, $details);
}
$avg = 0;
foreach ($amounts as $amount) {
    $avg = $amount + $avg;
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/group.css">
    <!-- <link rel="stylesheet" href="css/dashboard.css"> -->

    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
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
    <script>
    function addmoney() {
        // invoke custom popup
        let popup = document.getElementById('popup');
        popup.style.display = 'block';
    }

    function addusertogroup() {
        let popup = document.getElementById('popup1');
        popup.style.display = 'block';
    }
    </script>
</head>

<body>
    <?php
    include "./includes/navbar.php";
    ?>
    <style>
    .content {
        margin-top: 6rem;
    }
    </style>
    <main class="content">
        <div class="RoomHeading flex">
            <div class="flex  introHead">
                <img src="./images/group.svg" alt="" style="height: 8rem;">
                <span class="flex RoomData extracssRoom">
                    <span class="flex" style="justify-content:flex-start;width:100%;">
                        <h2>Name: <?php echo $Name; ?></h2>
                        <h2>ID: <?php echo $code; ?></h2>
                    </span>
                    <span>
                        <?php
                        if ($AdminId == $userId) {
                            if ($payment == 0) {
                                echo " <button id='addusertogroup' onclick='addusertogroup()' class='viewbutton'>Add
                                Members</button>";
                            } else {
                                echo " <button id='addusertogroup' onclick='addusertogroup()' class='viewbutton disabledbutton' disabled>Add
                                Members</button>";
                            }
                        }
                        ?>
                    </span>

                    <span class=" flex">
                        <h2>Members: <?php echo $count ?></h2>
                        <h2>Expenses: <?php echo $Amount ?>
                        </h2>
                    </span>
                </span>
            </div>
        </div>
        <?php
        $data = [];
        // get users id in group
        $userId = $_SESSION['userId'];
        $getuser = "SELECT * FROM `groupusers` WHERE `groupRoom`='$code'";
        $exe_getuser = mysqli_query($conn, $getuser);
        $Groupinusers = [];
        // loop thourgh users 
        while ($userData = mysqli_fetch_assoc($exe_getuser)) {
            $groupUserID =  $userData['userId'];
            // get expenses, all user data
            $groupUsers = "SELECT * FROM `users` WHERE `userId` = '$groupUserID'";
            $exe_groupUsers = mysqli_query($conn, $groupUsers);
            // get all data related to user
            while ($groupUserData = mysqli_fetch_assoc($exe_groupUsers)) {
                // get data related to expenses added in group.
                $groupUserExpenses = "SELECT * FROM `expenses` WHERE `userID` = '$groupUserID' AND `groupID` = '$code'";
                $exe_groupUserExpenses = mysqli_query($conn, $groupUserExpenses);
                // calculating his expenses.
                $totalExpense = 0;
                $balance010 = $groupUserData['coins'];
                $userIds = [];
                $amountData = [];
                while ($expenseHemade = mysqli_fetch_assoc($exe_groupUserExpenses)) {
                    $expenseHemade = $expenseHemade['amount'];
                    $expenseHemade = (int)$expenseHemade;
                    $totalExpense = (int)$totalExpense + $expenseHemade;
                }
                $avg = (int) $avg;
                $count = (int) $count;
                $averageMoney = 0;
                $averageMoney  = $avg / $count;
                $averageMoney = (int)$averageMoney;
                $heShouldPay = $totalExpense - $averageMoney;
                $debtCounter = 0;


                $statusCounter = 0;
                $UserdataId = $groupUserData['userId'];
                $tempArray = [$UserdataId, $heShouldPay];
                array_push($data, $tempArray);
                $TheUsername = $groupUserData['userName'];


                echo "
        <div class='RoomHeading  flex'>
            <div class='flex RoomData RoomMember'>
              <div>
            <h2>Name: $groupUserData[userName]</h2>
            </div>
            <div>
            <h2>Expense: $totalExpense</h2>
            </div>
            <div>
";
                if ($heShouldPay < 0) {
                    echo "<h2>Pay: $heShouldPay</h2>";
                    $debtCounter = $debtCounter + 1;
                } else {
                    echo "<h2>Get: $heShouldPay</h2>";
                }

                echo " </div>
            ";
                if ($heShouldPay < 0) {
                    $debtCounter = $debtCounter + 1;
                }
                array_push($Groupinusers, [$UserdataId, $heShouldPay]);
                // own user
                if ($groupUserID == $userId) {
                    $status = $userData['status'];
                    if ($payment == 0) {
                        echo "<div class='paymentAndExpense'><button class='viewbutton' onclick='addmoney()'>Add Money</button></div>";
                    } else {
                        $userStatus = $userData['status'];
                        if ($userStatus == 0) {
                            if ($heShouldPay < 0) {
                                echo "<div class='paymentAndExpense'><form action='' method='post'><button class='viewbutton ' type='submit' name='pay' >Pay</button></form></div>";
                            } else {

                                $sqlStatusupdate = "UPDATE `groupusers` SET `status`=1 WHERE `groupRoom`='$code' AND `userId`='$userId'";
                                $exe_sqlStatusupdate = mysqli_query($conn, $sqlStatusupdate);
                            }
                        } else {
                            echo "<div><h2>Receieve: $heShouldPay</h2></div>";
                        }
                    }
                }
                // other users
                else {
                    $status = $userData['status'];
                    if ($payment == 0) {
                        if ($userId == $userData['userId']) {
                            echo "<div class='paymentAndExpense'><button class='viewbutton ' onclick='addmoney()'>Add Money</button></div>";
                        } else {
                            echo "<div class='paymentAndExpense'><button class='viewbutton disabledbutton ' onclick='addmoney()' disabled>Add Money</button></div>";
                        }
                    } else {
                        $userStatus = $userData['status'];
                        if ($userStatus == 0) {
                            if ($heShouldPay < 0) {

                                echo "<div class='paymentAndExpense'><form action='' method='post'><button class='viewbutton disabledbutton' type='submit' name='pay' disabled>Pay</button></form></div>";
                            } else {
                                $sqlStatusupdate = "UPDATE `groupusers` SET `status`=1 WHERE `groupRoom`='$code' AND `userId`='$userId'";
                                $exe_sqlStatusupdate = mysqli_query($conn, $sqlStatusupdate);
                                echo "<div><h2>Receieve: $heShouldPay</h2></div>";
                            }
                        } else {
                            if ($heShouldPay > 0) {
                                echo "<div><h2>Receive: $heShouldPay</h2></div>";
                            } else {
                                echo "<div><h2>Payment done</h2></div>";
                            }
                        }
                    }
                }
                echo "
            </div>
            </div>    
        ";
            }
        }

        ?>
        <!-- forms -->
        <div class="popup" id="popup">
            <div class="popup_inner">
                <h1>Add Expense</h1>
                <form action='' method='post' class="flex popform" id="popform">
                    <span class="flex" style="flex-direction:column;">
                        <label>
                            Expense:
                        </label>
                        <input name='expense' type='number' min=10 required>
                        <label>
                            Description:
                        </label>
                        <input type="text" name="decription" required>
                        <small>Write very short description max 5 words</small>
                    </span>
                    <span>
                        <button name='addexpense' type='submit'>Submit</button>
                        <button id='closeAddExpenseForm' style='margin-top:3rem;'>Close</button>
                    </span>
                </form>
            </div>
        </div>
        <div class="popup" id="popup1">
            <div class="popup_inner">
                <h1>Add Member</h1>
                <form action='' method='post' class="flex popform" id="popform">
                    <span class="flex" style="flex-direction:column;">
                        <label>
                            Username:
                        </label>
                        <input name='username' type='text' required>
                        <small>Username as given when signup</small>
                    </span>
                    <span>
                        <button name='adduser' type='submit'>Submit</button>
                        <button id='closeAddExpenseForm' style='margin-top:3rem;'>Close</button>
                    </span>
                </form>
            </div>
        </div>
        <script>
        function addmoney() {
            // invoke custom popup
            let popup = document.getElementById('popup');
            popup.style.display = 'block';
        }
        </script>
        <?php
        // payments enabling
        if (isset($_POST['enablepayment'])) {
            $enablepayment = "UPDATE `groups` SET `payment`='1' WHERE `groupRoom`='$code'";
            $insertingExpense = mysqli_query($conn, $enablepayment);
            echo "<script>location.href='group.php?code=$code'</script>";
        }
        // adding member
        if (isset($_POST['addexpense'])) {
            $expense = $_POST['expense'];
            $decription = $_POST['decription'];
            if (!empty($expense) || !empty($decription)) {
                $Amount = $Amount + $expense;
                $expenseInsert = "UPDATE `groups` SET `groupAmount`='$Amount' WHERE `groupRoom`='$code'";
                $insertingExpense = mysqli_query($conn, $expenseInsert);
                $expenseInserttable = "INSERT INTO `expenses`(`groupID`,`userID`,`amount`,`Description`) VALUES ('$code','$userId','$expense','$decription')";
                $insertingIntoExpense = mysqli_query($conn, $expenseInserttable);
                // update the expenses in the groupusers table
                $exp = $totalExpense + $expense;
                $getGroupUsers = "UPDATE `groupusers` SET `expenses` = '$exp' WHERE `groupRoom`='$code' AND `userId`='$userId'";
                // update the group expense
                $newGroupBalance = $Amount + $expense;
                $groupExpenseUpdate = "UPDATE `group` SET = `groupAmount` = '$newGroupBalance' WHERE `groupRoom`='$code'";
                $updateGroupExpense = mysqli_query($conn, $groupExpenseUpdate);
                $updateGroupUsers = mysqli_query($conn, $getGroupUsers);
                echo "<script>location.href='group.php?code=$code'</script>";
            } else {
                // sweetalert
                echo "<script>
    Swal.fire({
        title: 'Error',
        text: 'Empty feilds are not accepted',
        icon: 'error',
        confirmButtonText: 'Ok'
    })
    </script>";
            }
        }
        // pay form submission
        if (isset($_POST['pay'])) {
            if ($balance010 > $heShouldPay) {
                $balance010 = $balance010 - $heShouldPay;
                // 10% of permember
                $forreward = $heShouldPay;
                if ($heShouldPay < 1) {
                    $forreward = $heShouldPay * -1;
                }
                $reward = $forreward * 0.1;
                $payReward = "UPDATE `users` SET `coins`='$balance010' ,`reward` = '$reward' WHERE `userId`='$_SESSION[userId]'";
                $respayReward = mysqli_query($conn, $payReward);
                $transactionId = rand(10000000, 99999999);
                $userId = $_SESSION['userId'];
                // get date 
                $date = date("Y-m-d");
                // get current time
                $time = date("h:i:sa");
                $amount = (string)$heShouldPay;
                $transaction = "INSERT INTO `transcations`(`transactionId`, `amount`, `userId`, `groupRoom`, `touserId`,`date`,`time`) VALUES ('$transactionId','$amount','$userId','$code','$Name','$date','$time')";
                $insertingTransaction = mysqli_query($conn, $transaction);
                $updategroupusers = "UPDATE `groupusers` SET `status`='1' WHERE `userId`='$_SESSION[userId]' AND `groupRoom`='$code'";
                $insertinggroupusers = mysqli_query($conn, $updategroupusers);
                $groupwallet = $groupwallet + $heShouldPay;
                $updatewallet = "UPDATE `groups` SET `wallet` = '$groupwallet' WHERE `groupRoom` ='$code'";
                $exe_updatewallet = mysqli_query($conn, $updatewallet);
                echo "<script>
    Swal.fire({
        title: 'success',
        text: 'Payment Successfull',
        icon: 'success',
        confirmButtonText: 'Ok'
    })
    </script>";
            } else {
                echo "<script>
    Swal.fire({
        title: 'Error',
        text: 'Not enough balance',
        icon: 'error',
        confirmButtonText: 'Ok'
    })
    </script>";
            }
        }
        // end of the pay 
        // clearing the payemnts

        // function completePayment($conn, $userIds, $amountData, $code)
        // {
        //     $tempCounter = 0;
        //     $one = 1;
        //     foreach ($userIds as $id) {
        //         $clearingupdate = "UPDATE `groups` SET `clearing`='1' WHERE `groupRoom`='$code'";
        //         $exe_clearingupdate = mysqli_query($conn, $clearingupdate);
        //         header("Location: dashboard.php?code=$amountData[$tempCounter]");
        //         // exit();
        //         $tempCounter = $tempCounter + 1;
        //     }
        // }
        // adding members into group
        if (isset($_POST['adduser'])) {
            $username = $_POST['username'];
            $getData = "SELECT userId,userName FROM users WHERE userName='$username'";
            $result = mysqli_query($conn, $getData);
            $theresult = mysqli_fetch_assoc($result);
            $resultArray = mysqli_num_rows($result);
            if (!$resultArray > 0) {
                echo "<script>
    Swal.fire({
        title: 'Error',
        text: 'User not found',
        icon: 'error',
        confirmButtonText: 'Ok'
    })
    </script>";
            } else {
                $userIdToInsert = (int)$theresult['userId'];
                if (in_array($userIdToInsert, $Groupinusers)) {
                    echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'User Already in Group',
                icon: 'error',
                confirmButtonText: 'Ok'
            })
                </script>";
                } else {
                    $userIdToInsert = (int)$theresult['userId'];
                    $groupUserInsert = "INSERT INTO `groupusers` (`groupRoom`, `userId`) VALUES ('$code','$userIdToInsert');";
                    $insertingUser = mysqli_query($conn, $groupUserInsert);
                    echo "<script>location.href='group.php?code=$code'</script>";
                }
            }
        }

        $getExpenseData = "SELECT * FROM `expenses` WHERE `groupID`='$code'";
        $exe_getExpenseData = mysqli_query($conn, $getExpenseData);
        echo "<h2 style='font-weight:300;margin:20px;' class='green'>Expenses added are</h2>";
        echo "<div class='tablerow1 flex'>
                <table class='table1'>
                    <thead class='thead'>
                        <tr>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody class='tbody'>";
        // echo "
        // <div class='RoomHeading  flex'>
        //     <div class='flex RoomData RoomMember'>
        //     <div><h2>User Name</h2></div>
        //     <div><h2>Amount</h2></div>
        //     <div><h2>Description</h2></div>
        //       </div></div>";

        while ($get_expenses = mysqli_fetch_assoc($exe_getExpenseData)) {
            // var_dump($get_expenses);
            // get the user name
            $userid = $get_expenses['userID'];
            $getUserName = "SELECT userName FROM `users` WHERE `userId`='$userid'";
            $exe_getUserName = mysqli_query($conn, $getUserName);
            $get_userName = mysqli_fetch_assoc($exe_getUserName);
            $Expusername = $get_userName['userName'];
            //     echo "
            // <div class='RoomHeading  flex'>
            //     <div class='flex RoomData RoomMember'>
            //     <div><h2>$Expusername</h2></div>
            //     <div><h2>$get_expenses[amount]</h2></div>
            //     <div><h2 class='wordlimit'>$get_expenses[Description]</h2></div>
            //       </div></div>";
            echo "<tr>
                        <td>$Expusername</h2></td>
                        <td><h2>$get_expenses[amount]</td>
                        
                        <td>$get_expenses[Description]</td>
                        
                       
                    </tr>";
        }
        echo "</tbody>
                </table></div>";
        if (isset($_POST['settlepayments'])) {
            // var_dump($Groupinusers);
            $balance = 0;
            $tempCounter = 0;
            $one = 1;
            $sqlStatusupdate = "UPDATE `groups` SET `clearing`=1 WHERE `groupRoom`='$code'";
            $exe_sqlStatusupdate = mysqli_query($conn, $sqlStatusupdate);

            foreach ($Groupinusers as $member) {
                $id = $member[0];
                $amount = $member[1];
                $transactionId = rand(10000000, 99999999);
                $date = date("Y-m-d");
                // get current time
                $time = date("h:i:sa");
                $getBalance = "SELECT coins FROM `users` WHERE `userId`='$id'";
                $exe_getBalance = mysqli_query($conn, $getBalance);
                $dataUser = mysqli_fetch_assoc($exe_getBalance);
                $balance = $dataUser['coins'];
                if ($amount < 0) {
                    $amount = $amount * -1;
                    $balance = $balance - $amount;
                } else {
                    $balance = $balance + $amount;
                }
                $sqldata = "UPDATE `users` SET `coins`='$balance' WHERE `userId`='$id'";
                $res = mysqli_query($conn, $sqldata);
                // INserting into transaction table
                $insertTransaction = "INSERT INTO `transactions` (`transactionId`, `userId`, `amount`, `date`, `time`, `groupRoom`) VALUES ('$transactionId', '$id', '$balance', '$date', '$time', '$code');";
                $exe_insertTransaction = mysqli_query($conn, $insertTransaction);
            }
        }

        echo "<div class='Adminarea'><h4 style='text-align:center;margin:25px;'>Admin updates  <br><small style='text-align:center'>Admin: $admin</small></h4>";


        if ($AdminId == $userId) {
            $getclearingInfo = "SELECT clearing  FROM `groups` WHERE `groupRoom`='$code'";
            $exe_getclearingInfo = mysqli_query($conn, $getclearingInfo);
            $row_getclearingInfo = mysqli_fetch_assoc($exe_getclearingInfo);
            $clearingInfo = $row_getclearingInfo['clearing'];

            $getstatus = "SELECT status FROM `groupusers` WHERE `groupRoom`='$code'";
            $exe_getstatus = mysqli_query($conn, $getstatus);
            $row_getstatus = mysqli_num_rows($exe_getstatus);
            echo $row_getstatus;
            if ($payment == 1) {
                if ($row_getstatus == $count) {
                    if ($clearingInfo == 0) {

                        echo "<center><h4 class='green'style='margin:25px;' >All paid Click Quick settle to autmate transactionsd</h4></center>";

                        echo "<center><<form action='' method='post'><button class='viewbutton' style='margin-top:15px;' type='submit' name='settlepayments'>Quick Settle</button></form></center>";
                    } else {
                        echo "<center><h4 class='green'style='margin:25px;' >Payments are settled</h4></center>";
                    }
                } else {
                    echo "<h4 style='text-align:center;'>Still payment are pendings</h4> ";
                }
            }
        } else {
            $getclearingInfo = "SELECT clearing  FROM `groups` WHERE `groupRoom`='$code'";
            $exe_getclearingInfo = mysqli_query($conn, $getclearingInfo);
            $row_getclearingInfo = mysqli_fetch_assoc($exe_getclearingInfo);
            $clearingInfo = $row_getclearingInfo['clearing'];

            $getstatus = "SELECT status FROM `groupusers` WHERE `groupRoom`='$code'";
            $exe_getstatus = mysqli_query($conn, $getstatus);
            $row_getstatus = mysqli_num_rows($exe_getstatus);
            echo $row_getstatus;
            if ($payment == 1) {
                if ($status == 0) {
                    // get me
                    echo "<h4 style='text-align:center;'>$TheUsername please complete payment</h4> ";
                } else {
                    echo "<h4 style='text-align:center;'>$TheUsername you have completed payment</h4> ";
                }
                if ($row_getstatus == $count) {
                    if ($clearingInfo == 0) {
                        echo "<h4 style='text-align:center;'>Waiting for $admin quick money settle</h4> ";
                    } else {
                        echo "<h4 style='text-align:center;'>Quick settlement started</h4> ";
                    }
                } else {
                    echo "<h4 style='text-align:center;'>Waiting for other members to complete payment</h4> ";
                }
            }
        }


        // payment enable
        if ($admin == $_SESSION['userName']) {
            if (!$payment == 0) {
                echo "<center><h4 class='green'style='margin:25px;' >Payments are Enabled</h4></center>";
            } else {
                echo "<center><form action='' method='post'><button class='viewbutton' style='margin-top:15px;' type='submit' name='enablepayment'>Enable Payments</button></form></center>";
            }
        } else {
            if ($payment == 0) {
                echo "<center><h4 class='green'style='margin:25px;' >Once $admin Enable payment you can Pay!</h4></center>";
            } else {
                echo "<center><h4 class='green'style='margin:25px;' >$admin Enabled Payments</h4></center>>";
            }
        }

        echo "</div>";
        function sendupdate()
        {
            echo "<h2>Payments are completed</h2>";
        }
        ?>


    </main>
</body>

</html>