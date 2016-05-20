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
    	<title>Restaurant List</title>
  	</head>
  	<body>
    	<!-- Restaurant List -->
    	<table>
    		<tr>
    			<th>Name</th>
    			<th>Website</th>
    			<th>Phone Number</th>
    			<th>Address</th>
    			<th>City</th>
    			<th>State</th>
                <th>Zip</th>
    		</tr>

    		<!-- Populate List using php (sql query) -->
            <?php

                //Notice: Undefined index: tag in /nfs/stak/students/w/winlaws/public_html/CS340/FinalProject/RestaurantList.php
                //when city not defined
                if($_GET['city'])
                {
                    if(!($stmt = $mysqli->prepare("SELECT restaurant.id, restaurant.name, restaurant.website, restaurant.phone, 
                                                          location.streetAddress, location.city, location.state, location.zip 
                                                   FROM restaurant
                                                   INNER JOIN location ON restaurant.lid = location.id 
                                                   WHERE city=(?)")))
                    {
                        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    }
                    if(!($stmt->bind_param("s",$_GET['city']))){
                        echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
                    }
                    if(!$stmt->execute()){
                        echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
                    } 
                    if(!$stmt->bind_result($rid, $name, $website, $phone, $streetAddress, $city, $state, $zip)){
                        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    while($stmt->fetch()){
                        echo '<tr>
                                <td><a href="./RestaurantPage.php?rid=' . $rid . '">' . $name. '</a></td>
                                <td><a href="' . $website . '"> ' . $website . '</a></td>
                                <td>' . $phone . '</td>
                                <td>' . $streetAddress . '</td>
                                <td>' . $city . '</td>
                                <td>' . $state . '</td>
                                <td>' . $zip . '</td>
                            </tr>';
                    }
                    $stmt->close();
                }

                //Notice: Undefined index: tag in /nfs/stak/students/w/winlaws/public_html/CS340/FinalProject/RestaurantList.php
                //When tag not defined
                if($_GET['tag'])
                {
                    if(!($stmt = $mysqli->prepare("SELECT restaurant.id, restaurant.name, restaurant.website, restaurant.phone, 
                                                          location.streetAddress, location.city, location.state, location.zip 
                                                   FROM restaurant
                                                   INNER JOIN location ON restaurant.lid = location.id 
                                                   INNER JOIN tag_restaurant ON restaurant.id = tag_restaurant.rid
                                                   WHERE tag_restaurant.tid = (SELECT tag.id FROM tag WHERE tag.description=(?))")))
                    {
                        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    }
                    if(!($stmt->bind_param("s",$_GET['tag']))){
                        echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
                    }
                    if(!$stmt->execute()){
                        echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
                    } 
                    if(!$stmt->bind_result($rid, $name, $website, $phone, $streetAddress, $city, $state, $zip)){
                        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    while($stmt->fetch()){
                        echo '<tr>
                                <td><a href="./RestaurantPage.php?rid=' . $rid . '">' . $name. '</a></td>
                                <td><a href="' . $website . '"> ' . $website . '</a></td>
                                <td>' . $phone . '</td>
                                <td>' . $streetAddress . '</td>
                                <td>' . $city . '</td>
                                <td>' . $state . '</td>
                                <td>' . $zip . '</td>
                            </tr>';
                    }
                    $stmt->close();
                }
            ?>
    	</table>
  	</body>
</html>