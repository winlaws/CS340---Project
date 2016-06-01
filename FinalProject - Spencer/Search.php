<?php
	require("includes/header.php");
  	require_once("includes/header.php");
?>

<!DOCTYPE html>
<html lang="en">
	<head>
    	<title>Search</title>

    	<link rel="stylesheet" href="stylesheet.css">

    	<link rel="stylesheet" href="../../bootstrap-3.3.6-dist/css/bootstrap.min.css">

	    <!-- Optional theme -->
	    <link rel="stylesheet" href="../../bootstrap-3.3.6-dist/css/bootstrap-theme.min.css">

	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	    <!-- Latest compiled and minified JavaScript -->
	    <script src="../../bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>   
  	
	    <link rel="stylesheet" href="../../bootstrap-3.3.6-dist/css/bootstrap-multiselect.css">
		<script type="text/javascript" src="../../bootstrap-3.3.6-dist/js/bootstrap-multiselect.js"></script>
  	</head>
  	<body>
  		<div class="col-lg-6 col-lg-offset-3">
	  		<h1 class="text-center">Search For Restaurants</h1>
	    	<!-- Resaurant Search -->
	    	<form method="get" action="RestaurantList.php">
	    		<?php
		    		echo "<input type='hidden' name='username' value='" . $username . "'/>";
	             	echo "<input type='hidden' name='password' value='" . $password . "'/>";
	            ?>
	    		<div class="form-group">
	    			<label for="city[]">By City</label>
	    			<br/>
					<select name="city[]" class="form-control multiselect" multiple="multiple">
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
				</div>
				<div class="form-group">
					<label for="tag[]">By Tag</label>
					<br/>
					<select id="test" name="tag[]" class="form-control multiselect" multiple="multiple">
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
					</select>
				</div>
				<div class="text-center">
					<input type="submit" class="btn btn-default"></input>
				</div>
			</form>
		</div>

		<!-- Initialize the plugin: -->
		<script type="text/javascript">
			$(document).ready(function() {
			        $('.multiselect').multiselect({includeSelectAllOption: true});
			});
		</script>
  	</body>
</html>