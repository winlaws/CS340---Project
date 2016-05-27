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
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  	</head>
  	<body>
    	<!-- Restaurant List -->
    	<div class="col-lg-8 col-lg-offset-2">
            <table class="table">
        		<thead class="thead-inverse">
                    <tr>
            			<th>Restaurant Name</th>
            			<th>Website</th>
            			<th>Phone Number</th>
            			<th>Address</th>
            			<th>City</th>
            			<th>State</th>
                        <th>Zip</th>
            		</tr>
                </thead>
                <tbody>
        		<!-- Populate List using php (sql query) -->
                <?php

                    $query = "SELECT restaurant.id, restaurant.name, restaurant.website, restaurant.phone, 
                                         location.streetAddress, location.city, location.state, location.zip 
                                   FROM restaurant
                                   INNER JOIN location ON restaurant.lid = location.id 
                                   INNER JOIN tag_restaurant ON restaurant.id = tag_restaurant.rid";
                                   
                                   //"WHERE city=(?) AND tag_restaurant.tid = (SELECT tag.id FROM tag WHERE tag.description=(?))";
                    //echo $query;  

                    if(array_key_exists('city', $_GET))
                    {
                        $query = $query . ' WHERE ';
                        
                        $first=true;
                        $cities = $_GET['city'];

                        foreach($cities as $c)
                        {
                            if($first==true)
                            {
                                $query = $query . 'city=(?)';
                                $first=false;
                            }
                            else
                            {
                                $query = $query . 'OR city=(?)';
                            }
                        }
                        
                    }  

                    echo $query;  

                    // if(array_key_exists('tag', $_GET))
                    // {
                    //     $query = "SELECT restaurant.id, restaurant.name, restaurant.website, restaurant.phone, 
                    //                      location.streetAddress, location.city, location.state, location.zip 
                    //                FROM restaurant
                    //                INNER JOIN location ON restaurant.lid = location.id 
                    //                INNER JOIN tag_restaurant ON restaurant.id = tag_restaurant.rid
                    //                WHERE city=(?) AND tag_restaurant.tid = (SELECT tag.id FROM tag WHERE tag.description=(?))")))
                    //     {
                    //         echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    //     }
                    //     if(!($stmt->bind_param("s",$_GET['tag']))){
                    //         echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
                    //     }
                    //     if(!$stmt->execute()){
                    //         echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
                    //     } 
                    //     if(!$stmt->bind_result($rid, $name, $website, $phone, $streetAddress, $city, $state, $zip)){
                    //         echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    //     }
                    //     while($stmt->fetch()){
                    //         echo '<tr>
                    //                 <th scope="row"><a href="./RestaurantPage.php?rid=' . $rid . '">' . $name. '</a></th>
                    //                 <td><a href="' . $website . '"> ' . $website . '</a></td>
                    //                 <td>' . $phone . '</td>
                    //                 <td>' . $streetAddress . '</td>
                    //                 <td>' . $city . '</td>
                    //                 <td>' . $state . '</td>
                    //                 <td>' . $zip . '</td>
                    //             </tr>';
                    //     }
                    //     $stmt->close();
                    // }
                    //     if(!($stmt = $mysqli->prepare($query)))
                    //     {
                    //         echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    //     }
                    //     if(!($stmt->bind_param("s",$_GET['tag']))){
                    //         echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
                    //     }
                    //     if(!$stmt->execute()){
                    //         echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
                    //     } 
                    //     if(!$stmt->bind_result($rid, $name, $website, $phone, $streetAddress, $city, $state, $zip)){
                    //         echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    //     }
                    //     while($stmt->fetch()){
                    //         echo '<tr>
                    //                 <th scope="row"><a href="./RestaurantPage.php?rid=' . $rid . '">' . $name. '</a></th>
                    //                 <td><a href="' . $website . '"> ' . $website . '</a></td>
                    //                 <td>' . $phone . '</td>
                    //                 <td>' . $streetAddress . '</td>
                    //                 <td>' . $city . '</td>
                    //                 <td>' . $state . '</td>
                    //                 <td>' . $zip . '</td>
                    //             </tr>';
                    //     }
                    //     $stmt->close();
                    // }
                ?>
                </tbody>
        	</table>
        </div>
  	</body>
</html>