<?php
    require("includes/header.php");
    require_once("includes/header.php");
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
    	<?php
            echo '<br/>
                  <div class="text-right col-lg-8 col-lg-offset-2">
                    <a href=Search.php?username=' . $username . '&password=' . $password . '>Back to Search</a>
                  </div>
                  <br/>';
        ?>
        <br/>
        <br/>
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

                    $query = "SELECT DISTINCT restaurant.id, restaurant.name, restaurant.website, restaurant.phone, 
                                         location.streetAddress, location.city, location.state, location.zip 
                                   FROM restaurant
                                   INNER JOIN location ON restaurant.lid = location.id 
                                   INNER JOIN tag_restaurant ON restaurant.id = tag_restaurant.rid
                                   INNER JOIN tag ON tag_restaurant.tid = tag.id
                             ";
                                   
                    $queryTypes= "";
                    $queryParams = array();

                    $where = false;
                    
                    if(array_key_exists('city', $_GET))
                    {
                        $query .= ' WHERE ';
                        $where = true;

                        $first = true;
                        $cities = $_GET['city'];

                        foreach($cities as $c)
                        {
                            if($first==true)
                            {
                                $query .= 'location.city=(?) ';
                                $first = false;
                            }
                            else
                            {
                                $query .= 'OR location.city=(?) ';
                            }
                            $queryTypes .= "s";
                            $queryParams[] = $c;
                        } 
                    }

                    if(array_key_exists('tag', $_GET))
                    {
                        $first = true;

                        if(!$where)
                        {
                            $query .= ' WHERE (';
                        }
                        else
                        {
                            $query .= ' AND (';
                        }
                        
                        $tags = $_GET['tag'];

                        foreach($tags as $t)
                        {
                            if($first == true)
                            {
                                $query .= 'tag.description=(?) ';
                                $first = false;
                            }
                            else
                            {
                                $query .= 'OR tag.description=(?) ';
                            }
        
                            $queryTypes .= "s";
                            $queryParams[] = $t;
                        } 
                        $query .= ')';
                    }

                    // //show query info
                    // echo $query . '<br/>'; 
                    // echo $queryTypes . '<br/>';
                    // var_dump($queryParams);

                    if(!($stmt = $mysqli->prepare($query)))
                    {
                        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    }

                    if(count($queryParams) > 0)
                    {
                        $bindArr = array();
                        $bindArr[] = $queryTypes;
                        foreach ($queryParams as $key => $value) 
                        {
                            $bindArr[] = &$queryParams[$key];
                        }
                        if(!call_user_func_array(array($stmt, 'bind_param'), $bindArr))
                        {   
                            echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
                        }
                    }

                    if(!$stmt->execute()){
                        echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
                    } 
                    if(!$stmt->bind_result($rid, $name, $website, $phone, $streetAddress, $city, $state, $zip)){
                        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    while($stmt->fetch()){
                        echo '<tr>
                                <th scope="row"><a href=./RestaurantPage.php?' . $_SERVER['QUERY_STRING'] . '&rid=' . $rid . '>' . $name .  '</a></th>   
                                <td><a href="' . $website . '"> ' . $website . '</a></td>
                                <td>' . $phone . '</td>
                                <td>' . $streetAddress . '</td>
                                <td>' . $city . '</td>
                                <td>' . $state . '</td>
                                <td>' . $zip . '</td>
                            </tr>';

                            // '<th scope="row"><a href="./RestaurantPage.php?username=' . $username . '&password=' . $password . '&rid=' . $rid . '">' . $name. '</a></th>
                    }
                    $stmt->close();
                ?>
                </tbody>
        	</table>
        </div>
  	</body>
</html>