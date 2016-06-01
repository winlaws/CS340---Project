<?php
$host = "oniddb.cws.oregonstate.edu";
$dbUsername = "lewisch-db";
$dbPass= "2HjqtP1ieKV2vkIg";
$db = "lewisch-db";

ini_set('display_errors', 'On');
$mysqli = new mysqli($host,$dbUsername,$dbPass,$db);

if($mysqli->connect_error) {
    die("Connection to server failed!: " . $mysqli->connect_error);
}

if(empty($_POST) == false)
{
    $username = $_POST['username'];
    $password = $_POST['password'];
}
else if(empty($_GET) == false)
{
    $username = $_GET['username'];
    $password = $_GET['password'];
}

?>

<!-- Put this inside php tags in a form so posts get sent with the proper username and data
             echo "<input type='hidden' name='username' value='" . $username . "'/>";
             echo "<input type='hidden' name='password' value='" . $password . "'/>";
-->