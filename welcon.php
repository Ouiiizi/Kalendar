<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: index.html");
}
?>
<html>

<head>
</head>
<body>


</body>
</html>





