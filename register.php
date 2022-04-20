
<?php
//requiring connection
require_once "./dbconn.php";
#initialization of the variable with empty string.
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

#$_SERVER['REQUEST_METHOD'] == 'POST'
# determines whether the request was a POST or GET request.
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank";
    }
    //IF not empty proceed forward.
    else {
        # mysqli_prepare Prepares the SQL query, and returns a statement
        #handle to be used for further operations on the statement.
        $sql = "SELECT id FROM registered_users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // Set the value of param username
            $param_username = trim($_POST['username']);
            // Try to execute this statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                    echo $username_err;
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);

// Check for password
    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
    } elseif (strlen(trim($_POST['password'])) < 5) {
        $password_err = "Password cannot be less than 5 characters";
    } else {
        $password = trim($_POST['password']);
    }

// Check for confirm password field
    if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
        $password_err = "Passwords should match";
    }

// If there were no errors, go ahead and insert into the database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        $sql = "INSERT INTO registered_users (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set these parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // Try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                header("location: welcon.php");
            } else {
                echo "Something went wrong... cannot redirect!";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="./stylsheet.css">
    <title>Document</title>
    <style>

    </style>
</head>
<body>
<center><h4>Login to विजी's calendar</h4></center>
<div class="container mt-4">
    <hr>
    <center> <form action="register.php" method="post">
            <label class="userlabel" for="username">Username:</label>
            <input id = "us1" class="username" type="text" name="username" id="username" placeholder="Username"><br>
            <label class = "pasword" for="password">Password:</label>
            <input id="pas2" class ="password" type="password"  name="password" id="password" placeholder="Password"><br>
            <label  class = "cpasword" for="confirm_password">Confirm Password:</label>
            <input id="pas2" class ="cpassword" type="password"  name="confirm_password" id="confirm_password" placeholder="Confirm Password"><br>
            <button id="regsub" class="button" type="submit" >Sign in</button><br>
            <a id=regbut" class ="reg"href="register.php">Register</a>
            <a id ="logbut" class="log" href="login.php">Login</a></center>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="stylejs.js"></script>
</body>
</html>