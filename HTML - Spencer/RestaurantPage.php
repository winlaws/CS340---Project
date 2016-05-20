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
    	<title>Restaurant Page</title>
  	</head> 
  	<body>
    	<!-- Restaurant Info - get using php (sql query)-->
    	<?php
            if(!($stmt = $mysqli->prepare("SELECT restaurant.name, restaurant.website, restaurant.phone, 
                                                  location.streetAddress, location.city, location.state, location.zip 
                                            FROM restaurant
                                            INNER JOIN location ON restaurant.lid = location.id 
                                            WHERE restaurant.id=(?)")))
            {
                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }
            if(!($stmt->bind_param("i",$_GET['rid']))){
                echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
            }
            if(!$stmt->execute()){
                echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
            } 
            if(!$stmt->bind_result($name, $website, $phone, $streetAddress, $city, $state, $zip)){
                echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            while($stmt->fetch()){
                echo '<div>
                        <div>'
                            . $name .
                        '</div>
                        <div>
                            Website: <a href="' . $website . '">' . $website . '</a>
                        </div>
                        <div>
                            Phone: ' . $phone .
                        '</div>  
                        <div>'
                            . $streetAddress . '<br/>'
                            . $city . ', ' . $state . ' ' . $zip .
                        '</div>
                    </div>';
            }
            $stmt->close();
        ?>

        
    	<!-- Back to List -->
    	<!-- <br/>
    	<a href="./RestaurantList.php?city=Miami">Back to Restaurant List</a>
    	<br/> -->
    	
        <!-- Review Section -->
		<br/>
    	
        <?php
            echo '<div>
                    <!-- Add New Review -->
                    Reviews - <a href="./WriteNewReview.php?rid=' . $_GET['rid'] . '">Write New Review</a> <br/>';

            // Get reviews using query
            if(!($stmt = $mysqli->prepare("SELECT review.rating, user.username, review.reviewDate, review.reviewtxt 
                                            FROM review
                                            INNER JOIN user ON review.uid = user.id 
                                            WHERE review.rid=(?)
                                            ORDER BY review.reviewDate")))
            {
                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }
            if(!($stmt->bind_param("i",$_GET['rid']))){
                echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
            }
            if(!$stmt->execute()){
                echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
            } 
            if(!$stmt->bind_result($rating, $username, $date, $txt)){
                echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            while($stmt->fetch()){
                echo '<br/> 
                    <div>'
                        . $rating . '/5 - ' . $username . ' - ' . $date .
                    '</div>
                    <div>'
                        . $txt .
                    '</div>';
            }
            $stmt->close();

            echo '</div>';
        ?>
  	</body>
</html>