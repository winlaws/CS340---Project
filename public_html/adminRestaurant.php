<?php
require("includes/header.php");
require_once("includes/header.php");
require("includes/invalidlogin.php");
require_once("includes/invalidlogin.php");
?>

<?php
if(empty($_GET) == false && isset($_GET['type']) == true && $_GET['type'] == 'delete' && isset($_GET['id']) == true  && is_numeric($_GET['id']) == true)
{
    if(!($stmt = $mysqli->prepare("DELETE FROM restaurant WHERE id = ?"))){
        echo "Restaraunt delete prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!($stmt->bind_param("i",$_GET['id']))){
        echo "restaurant delete bind param failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!$stmt->execute()){
        echo "restaurant delete execute failed: "  . $stmt->errno . " " . $stmt->error;
    }      

    unset($stmt);
}
else if(empty($_POST) == false)
{
    //Check that the restaurant doesn't already exist
    if(!($stmt = $mysqli->prepare("SELECT R.id FROM restaurant R INNER JOIN location L ON R.lid=L.id WHERE R.name= ? AND L.streetAddress=? AND L.city=? AND L.state=? LIMIT 1"))){
        echo "restaurant check prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!($stmt->bind_param("ssss",$_POST['name'], $_POST['street'],$_POST['city'],$_POST['province']))){
        echo "restaurant check bind param failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!$stmt->execute()){
        echo "restaurant check execute failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!$stmt->bind_result($id))
    {
        echo "restaurant check bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }

    $matchFound = false;
    while($stmt->fetch())
    {
        if(empty($id) == false)
            $matchFound = true;
    }

    //Add the restaurant if it doesn't already exist
    if($matchFound == false)
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

        while($stmt->fetch()){}

        //Add the location if it doesn't exist in our database currently
        if(empty($lid) == true)
        {
            //Insert a location into the database to reference
            if(!($stmt = $mysqli->prepare("INSERT INTO location(streetAddress, city, state, zip) VALUES (?, ?, ?, ?)"))){
                echo "Location insert prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }

            $zip = intval($_POST['zip']);
            if(!($stmt->bind_param("sssi",$_POST['street'],$_POST['city'],$_POST['province'],$zip))){
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

        //Insert restaurant into database
        if(!($stmt = $mysqli->prepare("INSERT INTO restaurant (name, website, phone, lid) VALUES (?, ?, ?, ?)"))){
            echo "restaurant insert prepare failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!($stmt->bind_param("sssi",$_POST['name'], $_POST['website'],$_POST['phone'], $lid))){
            echo "restaurant insert bind param failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->execute()){
            echo "restaurant Insert execute failed: "  . $stmt->errno . " " . $stmt->error;
        }

        //Get the id of the restaurant for connecting to tags
        if(!($stmt = $mysqli->prepare("SELECT R.id FROM restaurant R INNER JOIN location L ON R.lid=L.id WHERE R.name= ? AND L.streetAddress=? AND L.city=? AND L.state=? LIMIT 1"))){
            echo "restaurant check prepare failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!($stmt->bind_param("ssss",$_POST['name'], $_POST['street'],$_POST['city'],$_POST['province']))){
            echo "restaurant check bind param failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->execute()){
            echo "restaurant check execute failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->bind_result($rid))
        {
            echo "restaurant check bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }

        $stmt->fetch();
        
        unset($stmt);

        if(isset($_POST['tags']) == true && strlen($_POST['tags']) > 0)
        {
            //Add Tags!
            $tags = explode(',',$_POST['tags']);
            $tagCount = count($tags);
            for($i = 0;$i < $tagCount;$i++)
            {
                //See if tag currently exists
                //Check that the restaurant doesn't already exist
                if(!($stmt = $mysqli->prepare("SELECT id FROM tag WHERE description = ?"))){
                    echo "Tag select prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }

                $t = $tags[$i];
                if(!($stmt->bind_param("s",$t))){
                    echo "Tag select bind param failed: "  . $stmt->errno . " " . $stmt->error;
                }

                if(!$stmt->execute()){
                    echo "Tag select execute failed: "  . $stmt->errno . " " . $stmt->error;
                }

                if(!$stmt->bind_result($tid))
                {
                    echo "Tag select bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }

                $stmt->fetch();
                unset($stmt);

                //Add tag to database if it doesn't already exist
                if(empty($tid) == true)
                {
                    if(!($stmt = $mysqli->prepare("INSERT INTO tag (description) VALUES (?)"))){
                        echo "Tag insert prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    }

                    $t = trim($tags[$i]);
                    if(!($stmt->bind_param("s",$t))){
                        echo "Tag insert bind param failed: "  . $stmt->errno . " " . $stmt->error;
                    }

                    if(!$stmt->execute()){
                        echo "Tag insert execute failed: "  . $stmt->errno . " " . $stmt->error;
                    }   

                    //Now that we have inserted it we need to get the id
                    if(!($stmt = $mysqli->prepare("SELECT id FROM tag WHERE description = ?"))){
                        echo "Tag select prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    }

                    if(!($stmt->bind_param("s",$t))){
                        echo "Tag select bind param failed: "  . $stmt->errno . " " . $stmt->error;
                    }

                    if(!$stmt->execute()){
                        echo "Tag select execute failed: "  . $stmt->errno . " " . $stmt->error;
                    }

                    if(!$stmt->bind_result($tid))
                    {
                        echo "Tag select bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }

                    $stmt->fetch();
                    unset($stmt);
                }

                //Connect the tag to the restaurant
                if(!($stmt = $mysqli->prepare("INSERT INTO tag_restaurant (rid,tid) VALUES (?,?)"))){
                    echo "Tag-restaurant insert prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }

                if(!($stmt->bind_param("ii",$rid, $tid))){
                    echo "Tag-restaurant insert bind param failed: "  . $stmt->errno . " " . $stmt->error;
                }

                if(!$stmt->execute()){
                    echo "Tag-restaurant insert execute failed: "  . $stmt->errno . " " . $stmt->error;
                }   

                unset($stmt);
            }
        }
    }
}


?>

<html>
<head>
    <title>Database Restaurants</title>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css" />
    <script src="AdminNavigation.js"></script>
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <?php
            echo "<a href='" . "Search.php?username=" . $username . "&password=" . $password . "'>\n";
            ?>                
                <h3>Restaurant Database Project</h3>
            </a>
        </div>

        <div class="login_container">
            <form class="login" action="" method="post">
                <div class="subform">
                    
                    <?php
                    if(empty($matchFound) == false && $matchFound == true)
                    {
                    ?>
                    <div class="alert alert-warning">
                    <strong> Warning! </strong> Restayrant with this name already is registered at this location. Edit this value rather than add it.
                    </div>
                    <?php
                    }
                    ?>
                    <h3> Restaurant Information </h3>
                    <label>Name</label>
                    <input type="text" name="name"/>
                    <br />
                    <label>Website</label>
                    <input  type="text" name="website"/>
                     <br />
                    <label>Phone</label>
                    <input type="tel" name="phone" />
                    <p style="color: white;">Enter your tags with a comma after each individual tag</p>
                    <label>Tags</label>
                    <input type="text" name="tags" />
                </div>

                <div class="subform">
                    <h3> Location Information </h3>
                    <br/>
                    <label class="form_label">Street Address </label>
                    <input type="text" name="street" />
                    <br />
                    <label class="form_label">City </label>
                    <input type="text" name="city" />
                    <br />
                    <label class="form_label">State  </label>
                    <input type="text" name="province" />
                    <br />

                    <label class="form_label">Zipcode (5-digits) </label>
                    <input pattern="[0-9]{5}" type="text" name="zipcode" />
                </div>
                 <?php
                    echo "<input type='hidden' name='username' value='" . $username . "'/>\n";
                    echo "<input type='hidden' name='password' value='" . $password . "'/>\n";
                ?>
                <input class="btn btn-primary" type="submit" value="Submit" />
            </form>
        </div>

        <table>
            <caption>Restaurant Data</caption>
            <tbody>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Website</th>
                    <th>Phone Number</th>
                    <th>Tags</th>
                    <th>Street Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zipcode</th>
                    <th></th>
                </tr>
                <?php
                
                //Check if the location currently exists to prevent duplicates
                if(!($stmt = $mysqli->prepare("SELECT L.streetAddress, L.city, L. state, L.zip, R.id, R.name, R.website, R.phone FROM location L INNER JOIN restaurant R ON R.lid=L.id"))){
                    echo "restaurant select prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }

                if(!$stmt->execute()){
                    echo "restaurant select execute failed: "  . $stmt->errno . " " . $stmt->error;
                }

                if(!$stmt->bind_result($address, $city, $state, $zip, $id, $name, $website, $phone))
                {
                    echo "restaurant select bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }

                $restaraunts = array();

                $restarauntCount = 0;
                while($stmt->fetch())
                {
                    $obj;
                    $obj['id'] = $id;
                    $obj['name'] = $name;
                    $obj['website'] = $website;
                    $obj['address'] = $address;
                    $obj['city'] = $city;
                    $obj['state'] = $state;
                    $obj['zip'] = $zip;
                    $obj['phone'] = $phone;

                    array_push($restaraunts,$obj);
                }

                $restarauntCount = count($restaraunts);
                for($i = 0; $i < $restarauntCount;$i++)
                {

                    if(isset($restaraunts[$i]['id']) == false)
                        continue;

                    //Fetch the tags for the associated restaurant
                    if(!($stmt = $mysqli->prepare("SELECT T.description FROM restaurant R INNER JOIN tag_restaurant TR ON R.id=TR.rid INNER JOIN tag T ON T.id=TR.tid WHERE R.id = ?"))){
                        echo "Tag select prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    }

                    if(!$stmt->bind_param("i",$restaraunts[$i]['id']))
                    {
                          echo "Tag select bind param failed: "  . $stmt->errno . " " . $stmt->error;
                    }

                    if(!$stmt->execute()){
                          echo "Tag select execute failed: "  . $stmt->errno . " " . $stmt->error;
                    }

                    if(!$stmt->bind_result($tag))
                    {
                         echo "Tag select bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    //Create our tagstring we will use
                    $tagstring = "";
                    $count = 0;
                    while($stmt->fetch())
                    {
                       if($count != 0)
                          $tagstring = $tagstring . ", " . $tag;
                       else
                          $tagstring = $tagstring . $tag;

                       $count++;
                    }

                     //Add data to table
                     echo "<tr>\n<td>\n" . $restaraunts[$i]['id'] . "\n</td>\n<td>\n" . $restaraunts[$i]['name'];
                     echo "\n</td>\n<td>\n<a href='http://" . $restaraunts[$i]['website'] .  "'>\n" . $restaraunts[$i]['website'] . "</a>\n";                      
                     echo "\n</td>\n<td>\n" . $restaraunts[$i]['phone'].  "\n</td>\n";

                     //Add the rest of the data
                     echo "<td>\n" . $tagstring . "\n</td>\n<td>\n" . $restaraunts[$i]['address']. "\n</td>\n<td>\n" . $restaraunts[$i]['city'] . "\n</td>\n<td>\n" . $restaraunts[$i]['state'] . "\n</td>\n<td>\n" . $restaraunts[$i]['zip'] . "\n</td>\n";
                       
                     //Add buttons for editing and deleting
                     echo "<td>\n<button onclick='EditRestaraunt(" . $restaraunts[$i]['id'] . ",\"" . $username . "\",\"" . $password . "\")' type='button' class='btn btn-warning'>Edit</button>\n";
                     echo "<button onclick='DeleteRestaraunt(" . $restaraunts[$i]['id'] . ",\"" . $username . "\",\"" . $password . "\")' type='button' class='btn btn-danger'>Delete</button>\n</td>\n</tr>\n";
                }
                ?>
            </tbody>
        </table>

    </div>
</body>
</html>

<?php
unset($_POST);
?>
