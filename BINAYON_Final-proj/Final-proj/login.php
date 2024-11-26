<?php
include("connect.php");
    $email = $_POST['lgmail'];
    $pass = $_POST['lpass'];

    $sql = "SELECT * FROM userinfo WHERE email = '$email' OR username = '$email';";
    $output = $connect->query($sql);

    if ($output->num_rows > 0) {
        $user = $output->fetch_assoc();
        if (password_verify($pass, $user['pass'])) {
            session_start();
            $_SESSION["userid"] = $user['UIID'];
            $_SESSION["username"] = $user['fname'] . " " . $user['lname'];
            $alert = "0";
        } else {
            $alert = "1";
        }
    } else {
        $alert = "1";
    }
    echo $alert;
?>