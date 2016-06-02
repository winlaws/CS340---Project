<?php
include("includes/header.php");
?>

<?php
    $successfulLogin = false;

    if(empty($_POST) == false)
    {
        //Check the username is unique
        if(!($stmt = $mysqli->prepare("SELECT id FROM user WHERE username=? AND password=?"))){
            echo "Username check prepare failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!($stmt->bind_param("ss",$_POST['username'],$_POST['password']))){
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
        {
            $successfulLogin = true;
        }
    }
?>

<html>
<head>
    <title>Database Restaurants</title>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css"/>
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <a href="index.php">
                <h3>Restaurant Database Project</h3>
            </a>
        </div> 
        <?php
            if($successfulLogin == true)
            {
                echo "<script>\n";
                echo "window.location = 'Search.php?username=" . $username . "&password=" . $password . "';\n";
                echo "</script>\n";
            }
            else
            {
        ?>
            <div class="login_container" style="width: 500px; margin: 50px auto 0 auto;">
                <?php
                if(empty($_POST) == false)
                {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-warning-sign"></span>Invalid Login Credentials. Please try again.
                </div>
                <?php
                }
                ?>
                <form class="login" action="index.php" method="post">
                    <label class="form_label">Username </label>
                    <input type="text" name="username" />
                    <br />
                    <br />
                    <label class="form_label">Password </label>
                    <input type="password" name="password" />
                    <br />
                    <br />
                    <input class="btn btn-primary" type="submit" value="Login" />
                    <a href="register.php">Register</a>
                </form>
            </div>
        <?php
        }
        ?>
    </div>
</body>
</html>

<?php

unset($_POST);

?>