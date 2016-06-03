<?php
	require("includes/header.php");
  	require_once("includes/header.php");
?>

<!DOCTYPE html>
<html lang="en">
	<head>
    	<title>Search</title>

    	<!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

  		<!-- Bootstrap multiselect plugin -->
	    <link rel="stylesheet" href="./bootstrap-3.3.6-dist/css/bootstrap-multiselect.css">
		<script type="text/javascript" src="./bootstrap-3.3.6-dist/js/bootstrap-multiselect.js"></script>
        
        <link rel="stylesheet" href="stylesheet.css" />
    </head>
  	<body>
  		<div class="container">
            <div class="jumbotron">
                <?php
                    echo "<a href='" . "Search.php?username=" . $username . "&password=" . $password . "'>\n<h3>Restaraunt Database Project</h3></a>";
                    echo "<a href=\"adminRestaurant.php?username=" . $username . "&password=" . $password . "\">\nAdmin Tools - Edit and Delete Restaraunt Information</a>\n";
                ?>
            </div>

            <div class="backdrop">
		  		<h1 class="text-center">Search For Restaurants</h1>
		    	<!-- Resaurant Search Form-->
		    	<form method="get" action="RestaurantList.php">
		  			<!-- user login info -->
		    		<?php
			    		echo "<input type='hidden' name='username' value='" . $username . "'/>";
		             	echo "<input type='hidden' name='password' value='" . $password . "'/>";
		            ?>
		    		
		    		<!-- city multiselect -->
		    		<div class="form-group">
		    			<label class="white-text" for="city[]">By City</label>
		    			<br/>
						<select name="city[]" class="form-control multiselect" multiple="multiple">
							<!-- Query to populate city multiselect with restaurant cities -->
							<?php
								if(!($stmt = $mysqli->prepare("SELECT DISTINCT city FROM restaurant
															   INNER JOIN location ON restaurant.lid = location.id"))){
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
					
					<!-- tag multiselect -->
					<div class="form-group">
						<label class="white-text" for="tag[]">By Tag</label>
						<br/>
						<select id="test" name="tag[]" class="form-control multiselect" multiple="multiple">
							<!-- Query to populate tag multiselect with tags -->
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
					
					<!-- submit button -->
					<div class="text-center">
						<input type="submit" class="btn btn-primary" />
					</div>
				</form>
			</div>      
        </div>
		
		<!-- Initialize the multiselect plugin: -->
		<script type="text/javascript">
			$(document).ready(function() {
			        $('.multiselect').multiselect({includeSelectAllOption: true});
			});
		</script>
  	</body>
</html>