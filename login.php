<?php
//This script will handle login
session_start();
// check if the user is already logged in
if(isset($_SESSION['username']))
{
    header("location: welcon.php");
    exit;
}
require_once "dbconn.php";
$username = $password = "";
$err = "";
// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){

    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username and password";
        echo $err;
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


    if(empty($err))
    {
        $sql = "SELECT id, username, password FROM registered_users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;

        // Try to execute this statement
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1)
            {
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if(mysqli_stmt_fetch($stmt))
                {
                    if(password_verify($password, $hashed_password))
                    {
                        // this means the password is correct. Allow user to login
                        session_start();
                        $_SESSION["username"] = $username;
                        $_SESSION["id"] = $id;
                        $_SESSION["loggedin"] = true;
                        //Redirect user to welcome page
                        include "welcon.php";
                    }
                }

            }

        }
    }


}


?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="stylsheet.css">
    <title>PHP login system!</title>
</head>
<body>



<div class="container mt-4">
    <center> <h3>Login to विजी's Calendar</h3></center>
    <hr>

    <center><form action="login.php" method="post">
            <label  class="userlabel" for="email">Username:</label>
            <input  id ="us1" class="username"type="text" name="username" id="email" placeholder="Enter Username"><br>
            <label for="password" class="pasword">Password:</label>
            <input id ="pass1" class="password"type="password" name="password" id="password" placeholder="Enter Password"><br>
        <button id="logsub" class="button" type="submit" >Submit</button>
        </form></center>



  <center>  <a id ="regbut" class ="reg"href="register.php">Register</a>
      <a id=logbut" class="log" href="login.php">Login</a></center>
</div>

</body>
<script src ="stylejs.js"></script>
</html>
