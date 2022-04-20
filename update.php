<?php

require_once "dbconn.php";

//Define variables and initialize with empty values
$actname = $desc = $createat = "";
$actnameerr = $descerr = $createaterr = "";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Validate first name
    $actname = trim($_POST["activity"]);
    if (empty($inputactname)) {
        $actnameerr = "Please enter a activity";
        echo "Please enter an activity.";
    } elseif (!filter_var($actname, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $actnameerr = "Please enter a valid activity";
        echo "Please enter a valid activity";
    } else {
        $actname = $inputactname;
    }

    //Validate description
    $inputdesc = trim($_POST["description"]);
    if (empty($inputdesc)) {
        $inputdesc = "Please enter a desc";
        echo "Please enter a desc";
    } elseif (!filter_var($inputdesc, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $descerr = "Please enter a desc";
        echo "Please enter a valid desc";

    } else {
        $desc = $inputdesc;
    }
    //Validation of description
    $createat = trim($_POST["created_at"]);
    if (empty($inputcreateat)) {
        $createaterr = "Please enter your date.";
        echo "Please enter your date";
    } else {
        $createat = $inputcreateat;
    }
    if (empty($first_name_err) && empty($last_name_err) && empty($email_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO activity (activity, description, created_at) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $activity, $desc, $createat);

            // Set parameters
            $activity = trim($_POST['activity']);
            $desc = trim($_POST['description']);
            $createat = trim($_POST['created_at']);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                header("location: Retrieve.php");
            } else {
                echo "ERROR: Could not execute query: $sql. " . mysqli_error($conn);
            }
        } else {
            echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
        }

// Close statement
        mysqli_stmt_close($stmt);

// Close connection
        mysqli_close($conn);
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form</title>
</head>
<body>
<a href="Retrieve.php">List</a>
<form action="create.php" method="post" enctype="multipart/form-data">
    Activity name <input type="text" placeholder="Enter Activity" name="activity"> <br>
    Description <input type="text" placeholder="Enter Description" name="description"> <br>
    Date of Creation[MM/DD/YYYY] <input type="date" placeholder="Enter date of creation here[MM/DD/YYYY]" name="created_at"> <br>
    <input type="submit" value="Submit">
</form>

</body>
</html>