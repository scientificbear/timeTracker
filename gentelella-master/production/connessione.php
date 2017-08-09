<?php
// Connects to Our Database
$username="<HERE YOUR USERNAME>";
$password="<HERE YOUR PASSWORD>";
$database="<HERE YOUR DATABASE NAME>";
$host="<HERE YOUR HOST>"

$conn=mysqli_connect($host, $username, $password)
or die(mysqli_error($conn));
$db=mysqli_select_db($conn,$database)
or die(mysqli_error($db));
date_default_timezone_set('Europe/rome');
?>
