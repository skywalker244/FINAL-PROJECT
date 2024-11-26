<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "pastryshop";
$connect = new mysqli($host, $user, $pass, $db);
if ($connect->connect_error){
    die("Connection Failed".$conn->connect_error);
}
?>