<?php
    //Turn on error reporting
    ini_set('display_errors', 'On');

    //Connects to the database
    $mysqli = new mysqli("oniddb.cws.oregonstate.edu","winlaws-db","rlMuClW21tvqXRNz","winlaws-db");
    if(!$mysqli || $mysqli->connect_errno)
    {
        echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
?>

<!DOCTYPE html>
<html lang="en">
	<head>
    	<title>Add New Review</title>
  	</head>
  	<body>
    	<!-- Run php query to add review -->
    	<?php
        if(!($stmt = $mysqli->prepare("INSERT INTO review(uid, rid, rating, reviewtxt, reviewDate) VALUES (?,?,?,?,?)"))){
          echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
        }
        $date = date("Y-m-d H:i:s");
        if(!($stmt->bind_param("iiiss",$_POST['uid'],$_POST['rid'],$_POST['rating'],$_POST['txt'],$date))){
          echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
        }
        if(!$stmt->execute()){
          echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
        } 
        else {
          echo "New Review Added.";
        }
      ?>

    	<!-- back to restaurant page -->
    	<!-- <br/>
    	<a href="./RestaurantPage.php?rid=1">Back to Restaurant Page</a> -->
  	</body>
</html>