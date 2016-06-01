<?php
$host = "oniddb.cws.oregonstate.edu";
$dbUsername = "winlaws-db";
$dbPass= "rlMuClW21tvqXRNz";
$db = "winlaws-db";

ini_set('display_errors', 'On');
$mysqli = new mysqli($host,$dbUsername,$dbPass,$db);

    //Turn on error reporting
//    ini_set('display_errors', 'On');

    //Connects to the database
//    $mysqli = new mysqli("oniddb.cws.oregonstate.edu","winlaws-db","rlMuClW21tvqXRNz","winlaws-db");
//    if(!$mysqli || $mysqli->connect_errno)
//    {
//        echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
//    }


if($mysqli->connect_error) {
    die("Connection to server failed!: " . $conn->connect_error);
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