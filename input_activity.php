<?php
require_once "dbconn.php";
$actname = $desc = $createat = "";
$actnameerr = $descerr = $createaterr = "";
if ($_SERVER["REQUEST_METHOD"]== "POST") {
echo 'hello' ;
    echo $_POST['activity'];
    $inputactname = trim($_POST["activity"]);
    if (empty($inputactname)) {
        $actnameerr = "Please enter a activity";
        echo "Please enter an activity.";
    } else {
        $actname = $inputactname;
    }

    //Validate description
    $inputdesc = trim($_POST["description"]);
    if (empty($inputdesc)) {
        $descerr = "Please enter a desc";
        echo "Please enter a desc";
    } else {
        $desc = $inputdesc;
    }
    //Validation of description
    $inputcreateat = trim($_POST["created_at"]);
    if (empty($inputcreateat)) {
        $createaterr = "Please enter your date.";
        echo "Please enter your date";
    } else {
        $createat = $inputcreateat;
    }
    if (empty($createaterr) && empty($descerr) && empty($actnameerr)) {
        // Prepare an insert statement
        echo "thocc";
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