<?php 
include("connect.php");

$email = $_POST['email'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$pass = $_POST['password'];
$date = date("Y-m-d");

$sql = "SELECT * FROM userinfo WHERE email = '$email';";
$output = $connect->query($sql);

if ($output->num_rows > 0) {
    $alert = "2";
} else {
    if (!empty($pass)) {
        if(strlen($pass) > 7) {
            $password = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO userinfo(email, fname, lname, pass, dateReg, flag) VALUES('$email', '$fname', '$lname', '$password', '$date', 0);";
            if ($connect->query($sql) === TRUE) {
                $sql = "SELECT UIID FROM userinfo WHERE email = '$email';";
                $result = $connect->query($sql);
                if (!$result) {
                    die("Invalid Query: ".$conn->error);
                }
                while($row = $result->fetch_assoc())
                {
                    $userid = $row["UIID"];
                }
    
                $sql = "SELECT PIID FROM prodinfo";
                $result = $connect->query($sql);
                if (!$result) {
                    die("Invalid Query: ".$conn->error);
                }
                while($row = $result->fetch_assoc())
                {
                    $sql = "INSERT INTO favinfo(UIID, PIID, flag) VALUES('$userid', '$row[PIID]', 0)";
                    if ($connect->query($sql)) {
                        $alert = "1";
                    } else { $alert = "0"; }
                }  
                $alert = "1";
            }
        } else {
            $alert = "3";
        }
    } else {
        $alert = "0";
    }
}
echo $alert;
?>