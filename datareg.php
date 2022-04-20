<?php
require_once "./dbconn.php";
var_dump($_POST);
if (empty($_POST['actname']))
    echo 'No input provided';

if(empty($_POST['date']))
    echo 'No input provided.';
?>