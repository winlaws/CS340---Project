<?php
include("includes/header.php");
?>
<?php

$usernameTaken = false;
$passwordsMatch = true;

if(empty($_POST) == false)
{
    //If we have duplicate passwords we can't register the user
    if($_POST['password'] != $_POST["verifypassword"])
    {
        $passwordsMatch = false;
    }

    //Check the username is unique
    if(!($stmt = $mysqli->prepare("SELECT id FROM user WHERE username=?"))){
        echo "Username check prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!($stmt->bind_param("s",$_POST['username']))){
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
        $usernameTaken = true;
    }

    //Only register the user if the password and user name are valid
    if(empty($id) == true && $passwordsMatch == true)
    {
        //Check if the location currently exists to prevent duplicates
        if(!($stmt = $mysqli->prepare("SELECT id FROM location WHERE streetAddress=? AND city=? AND state=? LIMIT 1"))){
            echo "Location check prepare failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!($stmt->bind_param("sss",$_POST['street'],$_POST['city'],$_POST['province']))){
            echo "Location check bind param failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->execute()){
            echo "Location check execute failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->bind_result($lid))
        {
            echo "Location check bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }

        $stmt->fetch();

        unset($stmt);

        //Add the location if it doesn't exist in our database currently
        if(empty($lid) == true)
        {
            //Insert a location into the database to reference
            if(!($stmt = $mysqli->prepare("INSERT INTO location(streetAddress, city, state, zip) VALUES (?, ?, ?, ?)"))){
                echo "Location insert prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }

            if(!($stmt->bind_param("sssi",$_POST['street'],$_POST['city'],$_POST['province'],intval($_POST['zipcode'])))){
                echo "Location insert bind failed: "  . $stmt->errno . " " . $stmt->error;
            }

            if(!$stmt->execute()){
                echo "Location insert execute failed: "  . $stmt->errno . " " . $stmt->error;
            }

            unset($stmt);

            //Check if the location currently exists to prevent duplicates
            if(!($stmt = $mysqli->prepare("SELECT id FROM location WHERE streetAddress=? AND city=? AND state=? LIMIT 1"))){
                echo "Location check prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }

            if(!($stmt->bind_param("sss",$_POST['street'],$_POST['city'],$_POST['province']))){
                echo "Location check bind param failed: "  . $stmt->errno . " " . $stmt->error;
            }

            if(!$stmt->execute()){
                echo "Location check execute failed: "  . $stmt->errno . " " . $stmt->error;
            }

            if(!$stmt->bind_result($lid))
            {
                echo "Location check bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }

            $stmt->fetch();

            unset($stmt);
        }

        //Create new user
        if(!($stmt = $mysqli->prepare("INSERT INTO user (username, password, lid) VALUES (?, ?, ?)"))){
            echo "User register prepare failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!($stmt->bind_param("ssi",$_POST['username'],$_POST['password'], $lid))){
            echo "User register bind param failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->execute()){
            echo "User register execute failed: "  . $stmt->errno . " " . $stmt->error;
        }
        else
        {
            $registerSuccess = true; //Used for changing html rendering
        }
    }
}

?>

<html>
<head>
    <title>
        Registration
    </title>
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
        <?php
if(empty($registerSuccess) == false && $registerSuccess == true)
{
        ?>

        <div class="login_container">
            <h3>You have successfully registered</h3>
        </div>

        <script>
            setTimeout(function () {
                window.location = "index.php";
            }, 2000);
        </script>

        <?php
}
else
{
        ?>
        <div class="login_container">
            <form class="login" action="register.php" method="post">

                <?php
                if($usernameTaken)
                {
                ?>
                <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-warning-sign"></span> Username is already taken. Please choose another.
                </div>
                <?php
                }
                ?>
                <!--
                <label class="form_label">First Name </label>
                <br />
                <input type="text" name="fname" />
                <br />
                <label class="form_label">Last Name </label>
                <br />
                <input type="text" name="lname" />
                <br />
                <label class="from_label">Email </label>
                <br />
                <input type="text" name="email" />
                <br />
                 -->
                <label class="form_label">Street Address </label>
                <br />
                <input type="text" name="street" />
                <br />
                <label class="form_label">City </label>
                <br />
                <input type="text" name="city" />
                <br />
                <label class="form_label">State </label>
                <br />
                <input type="text" name="province" />
                <br />
                <label class="form_label">Zipcode (5-digits) </label>
                <br />
                <input type="text" pattern="[0-9]{5}" name="zipcode" />
                <br />
                <label class="form_label">Username </label>
                <br />
                <input type="text" name="username" />
                <br />
                <?php
                    if($passwordsMatch == false)
                    {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-warning-sign"></span> Passwords do not match!
                    </div>
                <?php
                    }
                ?>
                <label class="form_label">Password </label>
                <br />
                <input type="password" name="password" />
                <br />
                <label class="form_label">Verify Password </label>
                <br />
                <input type="password" name="verifypassword" />
                <br />
                <input class="btn btn-primary" type="submit" value="Register" />
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

