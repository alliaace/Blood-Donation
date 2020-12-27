<?php
session_start();
session_unset();
$_SESSION["isloggedin"]=FALSE;
header("Location: http://localhost/blooddonationf/site/");
die();
?>