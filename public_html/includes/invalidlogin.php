<?php
require("includes/header.php");
require_once("includes/header.php");
?>
<?php
$validlogin = false;

 if(empty($username) == false && empty($password) == false)
 {
     if(!($stmt = $mysqli->prepare("SELECT id FROM user WHERE username=? AND password=?"))){
         echo "Username check prepare failed: "  . $stmt->errno . " " . $stmt->error;
     }

     if(!($stmt->bind_param("ss",$username,$password))){
         echo "Username check bind param failed: "  . $stmt->errno . " " . $stmt->error;
     }

     if(!$stmt->execute()){
         echo "Username check execute failed: "  . $stmt->errno . " " . $stmt->error;
     }

     if(!$stmt->bind_result($id))
     {
         echo "Username bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
     }

     $stmt->fetch();

     unset($stmt);

     if(empty($id) == false)
         $validlogin = true;
 }

if($validlogin == false)
{
?>
<html>
<head>
    <title>Database Restaraunts</title>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css" />
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <a href="index.php">
                <h3>Restaraunt Database Project</h3>
            </a>
        </div>
        <div class="login_container">
            <a href="index.php"><h3>Invalid Login Credential. Return to main page and login.</h3></a>
        </div>
</div>
</body>
</html>
<?php
    exit(0);
}
?>