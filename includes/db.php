<?php
$servername = "localhost";
$username = "gmritchapterhost_bill";
$password = "AbhiAbhiAbhi2525";
$dbname = "gmritchapterhost_bill";
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "bill";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}