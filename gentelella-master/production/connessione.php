<?php
// Connects to Our Database
$username="<HERE YOUR USERNAME>";
$password="<HERE YOUR PASSWORD>";
$database="<HERE YOUR DATABASE>";

$conn=mysqli_connect("sql.patrickzecchin.com", $username, $password)
or die(mysqli_error($conn));
$db=mysqli_select_db($conn,$database)
or die(mysqli_error($db));
date_default_timezone_set('Europe/rome');
?>
