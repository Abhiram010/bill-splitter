<?php
if (isset($_POST['addexpense'])) {
    $expense = $_POST['expense'];
    $Amount = $_POST['Amount'];
    $groupRoom = $_POST['code'];
    $Amount = (int)$Amount;
    $Amount = $Amount + $expense;
    $expenseInsert = "UPDATE `groups` SET `groupAmount`='$Amount' WHERE `groupRoom`='$groupRoom'";
    $insertingExpense = mysqli_query($conn, $expenseInsert);
}
