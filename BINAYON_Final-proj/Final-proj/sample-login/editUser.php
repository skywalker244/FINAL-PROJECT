<?php

use LDAP\Result;

include("connect.php");
$id = "";
$fname = "";
$lname = "";
$email = "";
$pass = "";
$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        header("location: homepage.php");
        exit;
    }
    $id = $_GET["id"];
    $sql = "SELECT * FROM login WHERE userid = $id;";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: homepage.php");
        exit;
    }
    $fname = $row["fname"];
    $lname = $row["lname"];
    $email = $row["email"];
} else {
    $id = $_POST["id"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["gmail"];
    $pass = $_POST["pass"];
    do{
        if(empty($fname) || empty($lname) || empty($email) || empty($pass)) {
            $errorMessage = "All the fields are required.";
            break;
        }
        $pass = md5($pass);
        $sql = "UPDATE login SET fname = '$fname', lname = '$lname', email = '$email', pass = '$pass' WHERE userid = $id;";
        $result = $conn->query($sql);
        if (!$result) {
            $errorMessage = "Error: ".$conn->error;
            break;
        }
        $fname = "";
        $lname = "";
        $email = "";
        $pass = "";
        
        $successMessage = "Account Updated Successfully.";
        header("location: homepage.php");
        exit;
    } while (false);
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>New User</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <div class="container my-5">
            <h2>New Client</h2>
            <?php
            if(!empty($errorMessage)){
                echo "<div class = 'alert alert-warning alert-dismissible fade-show' role = 'alert'>
                    <strong>$errorMessage</strong>
                    <button type = 'button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                ";
            }
            ?>

            <form method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="row mb-3">
                    <label for="" class="col-sm-3 col-form-label">First Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="fname" value="<?php echo $fname; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="" class="col-sm-3 col-form-label">Last Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="lname" value="<?php echo $lname; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="" class="col-sm-3 col-form-label">Email Address</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" name="gmail" value="<?php echo $email; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="pass" value="<?php echo $pass; ?>">
                    </div>
                </div>

                <?php
                    if(!empty($successMessage)){
                        echo "
                        <div class = 'row mb-3'>
                            <div class = 'offset sm-3 col-sm-6'>
                                <div class = 'alert alert-success alert-dismissible fade show' role = 'alert'>
                                    <strong>$successMessage</strong>
                                    <button type = 'button' class = 'btn-close' data-bs-dismiss = 'alert' aria-label = 'Close'></button>
                                </div>
                            </div>
                        </div>
                        ";
                    }
                ?>

                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <div class="col-sm-3 d-grid">
                        <a href="homepage.php" class="btn btn-outline-primary" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>