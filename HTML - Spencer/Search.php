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
    	<title>Search</title>
  	</head>
  	<body>
    	<!-- Resaurant Search -->
    	<form method="get" action="RestaurantList.php">
    		<fieldset>
				<legend>Search By City</legend>
				<select name="city">
					<?php
						if(!($stmt = $mysqli->prepare("SELECT DISTINCT city FROM location"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}
						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						if(!$stmt->bind_result($city)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						while($stmt->fetch()){
							echo '<option value="'. $city . '"> ' . $city . '</option>\n';
						}
						$stmt->close();
					?>
				</select>
				<input type="submit"></input>
			</fieldset>
		</form>
    	
    	<form method="get" action="RestaurantList.php">
    		<fieldset>
				<legend>Search By Tag</legend>
				<select name="tag">
					<?php
						if(!($stmt = $mysqli->prepare("SELECT description FROM tag"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}
						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						if(!$stmt->bind_result($tag)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						while($stmt->fetch()){
							echo '<option value="'. $tag . '"> ' . $tag . '</option>\n';
						}
						$stmt->close();
					?>
				<input type="submit"></input>
			</fieldset>
		</form>
  	</body>
</html>