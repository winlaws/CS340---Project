<?php
	require("includes/header.php");
  	require_once("includes/header.php");
    require("includes/invalidlogin.php");
    require_once("includes/invalidlogin.php");
?>

<!DOCTYPE html>
<html lang="en">
	<head>
    	<title>Search</title>
        <!-- Bootstrap -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	    <link rel="stylesheet" href="../../bootstrap-3.3.6-dist/css/bootstrap-multiselect.css">
		<script type="text/javascript" src="../../bootstrap-3.3.6-dist/js/bootstrap-multiselect.js"></script>
        
        <!-- Multiselect stuff - NEEDS TO BE FIXED -->
        <link rel="stylesheet" href="../../bootstrap-3.3.6-dist/css/bootstrap-multiselect.css">
        <script type="text/javascript" src="../../bootstrap-3.3.6-dist/js/bootstrap-multiselect.js"></script>

        <!-- Customized CSS -->
        <link rel="stylesheet" href="stylesheet.css" />
  	</head>
  	<body>
           <div class="container">
                <div class="jumbotron">
                <?php
                     echo "<a href='" . "Search.php?username=" . $username . "&password=" . $password . "'>\n";
                ?>                
                <h3>Restaraunt Database Project</h3>
                </a>
                <?php
                echo "<a href=\"adminRestaurant.php?username=" . $username . "&password=" . $password . "\">\n";
                echo  "Admin Tools - Edit and Delete Restaraunt Information";
                echo "</a>\n";
                ?>

            </div>
  		    <div class="login_container">
	  		<h1 class="text-center">Search For Restaurants</h1>
	    	<!-- Resaurant Search -->
	    	<form class="login" method="get" action="RestaurantList.php">
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
					<input type="submit" class="btn btn-primary"></input>
				</div>
			</form>
		    </div>

          </div>
		<!-- Initialize the plugin: -->
		<script type="text/javascript">
			$(document).ready(function() {
			        $('.multiselect').multiselect({includeSelectAllOption: true});
			});
		</script>
  	</body>
</html>