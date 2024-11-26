<?php
include("connect.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "DELETE FROM login WHERE userid = $id";
    $conn->query($sql);
}

header("location: homepage.php");
exit;
?>