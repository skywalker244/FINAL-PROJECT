<?php

session_start();
include("connect.php");
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Homepage</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body style = "display:block;">
        <div style="text-align:center; padding:15%;">
            <p style = "font-size:50px; font-weight:bold;">
                Hello! Welcome User 
                <?php
                    if(isset($_SESSION['gmail'])){
                    $em = $_SESSION['gmail'];
                    $query = mysqli_query($conn, "SELECT * FROM `login` WHERE email = '$em';");
                    while($row = mysqli_fetch_array($query)){
                        echo $row["fname"]." ".$row["lname"];
                    }
                }
                ?>
            </p>
        </div>
        <div style="margin: 20px;">
            <h1>List Of Users</h1>
            <br>
            <a class = 'btn btn-primary btn-sm' href = 'newUser.php'>Add Account</a>
            <table class="table">
                <thead><tr>
                <th>User ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Email Address</th>
                <th>Password</th>
                <th>Action</th>
                </tr></thead>

                <tbody>
                    <?php
                    $sql = "SELECT * FROM login";
                    $result = $conn->query($sql);
                    if (!$result) {
                        die("Invalid Query: ".$conn->error);
                    }
                    while($row = $result->fetch_assoc())
                    {
                        echo "<tr>
                        <td>$row[userid]</td>
                        <td>$row[fname]</td>
                        <td>$row[lname]</td>
                        <td>$row[email]</td>
                        <td>$row[pass]</td>
                        <td>
                            <a class = 'btn btn-primary btn-sm' href = 'editUser.php?id=$row[userid]'>Update</a>
                            <a class = 'btn btn-danger btn-sm' href = 'deleteUser.php?id=$row[userid]'>Delete</a>
                        </td>
                        </tr>";
                    }                                    
                    ?>
                </tbody>
            </table>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>