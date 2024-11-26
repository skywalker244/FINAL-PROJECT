<?php

include 'connect.php';

if (isset($_POST['signUp'])){
    $FN = $_POST['fname'];
    $LN = $_POST['lname'];
    $EM = $_POST['gmail'];
    $PASS = $_POST['pass'];
    $PASS = md5($PASS);

    $checkEM = "SELECT * FROM login WHERE email = '$EM';";
    $result = $conn->query($checkEM);
    if($result->num_rows>0){
        echo "This Email Address Already Exists!";
    }
    else{
        $insertQuery = "INSERT INTO login(fname,lname,email,pass)
        VALUES('$FN', '$LN', '$EM', '$PASS');";
        if ($conn->query($insertQuery)==TRUE){
            header("location: exp.php");
            header("Content-type: text/css");
        }
        else{
            echo "Error:".$conn->error;
        }
    }
}

if (isset($_POST['login'])){
    $em = $_POST['gmail'];
    $pass = $_POST['pass'];
    $pass = md5($pass);
    $sql = "SELECT * FROM login WHERE email = '$em' AND pass = '$pass';";
    $result = $conn->query($sql);
    if ($result->num_rows>0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['gmail'] = $row['email'];
        header("Location: homepage.php");
        exit();
    }
    else{
        echo "Incorrect Email Address or Password.";
    }
}   
?>