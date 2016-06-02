<?php
require("includes/header.php");
require_once("includes/header.php");
require("includes/invalidlogin.php");
require_once("includes/invalidlogin.php");
?>

<?php
$invalidUrl = true;
$editSuccess = false;
if(empty($_POST) == false)
{
   $invalidUrl = !isset($_POST['id']);
   if($invalidUrl == false)
   {
      $editSuccess = true;
   }

   //Update restaurant information
   if(!($stmt = $mysqli->prepare("UPDATE restaurant SET name = ?, website = ?, phone = ? WHERE id = ?"))){
        echo "restaurant select prepare failed: "  . $stmt->errno . " " . $stmt->error;
   }

   if(!($stmt->bind_param("sssi",$_POST['name'],$_POST['website'],$_POST['phone'],$_POST['id']))){
        echo "restaurant select bind param failed: "  . $stmt->errno . " " . $stmt->error;
   }

   if(!$stmt->execute()){
       echo "restaurant select execute failed: "  . $stmt->errno . " " . $stmt->error;
   }  

   unset($stmt);

   //Select location
   if(!($stmt = $mysqli->prepare("SELECT lid FROM restaurant WHERE id = ?"))){
        echo "restaurant select prepare failed: "  . $stmt->errno . " " . $stmt->error;
   }

   if(!($stmt->bind_param("i",$_POST['id']))){
        echo "restaurant select bind param failed: "  . $stmt->errno . " " . $stmt->error;
   }

   if(!$stmt->execute()){
       echo "restaurant select execute failed: "  . $stmt->errno . " " . $stmt->error;
   }  

   if(!$stmt->bind_result($lid))
   {
       echo "Location select bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
   }
   
   $stmt->fetch();
   unset($stmt);

       //Check number of restaurant bound to this address
       if(!($stmt = $mysqli->prepare("SELECT id FROM restaurant WHERE lid=?"))){
           echo "restaurant select prepare failed: "  . $stmt->errno . " " . $stmt->error;
       }

       if(!($stmt->bind_param("i",$lid))){
           echo "restaurant select bind param failed: "  . $stmt->errno . " " . $stmt->error;
       }

       if(!$stmt->execute()){
           echo "restaurant select execute failed: "  . $stmt->errno . " " . $stmt->error;
       }  

       if(!$stmt->bind_result($id))
       {
           echo "Location select bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
       }

       $count = 0;
       while($stmt->fetch())
       {
           $count++;
       }

       if($count == 1) //Only one restaurant at this location so we can just update it
       {
           //Update location
           if(!($stmt = $mysqli->prepare("UPDATE location SET streetAddress = ?, city = ?, state = ?, zip = ? WHERE id = ?"))){
               echo "location update prepare failed: "  . $stmt->errno . " " . $stmt->error;
           }

           $z = $_POST['zipcode'];
           if(!($stmt->bind_param("sssii",$_POST['street'],$_POST['city'],$_POST['province'],$z,$lid))){
               echo "location update bind param failed: "  . $stmt->errno . " " . $stmt->error;
           }

           if(!$stmt->execute()){
               echo "location update execute failed: "  . $stmt->errno . " " . $stmt->error;
           }  

           unset($stmt);
       }
       else //If multiple locations shared the same location we make a new one
       {
           //Check if location has been updated
           if(!($stmt = $mysqli->prepare("SELECT streetAddress, city, state, zip FROM location WHERE id = ?"))){
               echo "restaurant select prepare failed: "  . $stmt->errno . " " . $stmt->error;
           }

           if(!($stmt->bind_param("i",$_POST['id']))){
               echo "restaurant select bind param failed: "  . $stmt->errno . " " . $stmt->error;
           }

           if(!$stmt->execute()){
               echo "restaurant select execute failed: "  . $stmt->errno . " " . $stmt->error;
           }  

           if(!$stmt->bind_result($street, $city, $state, $zip))
           {
               echo "Location select bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
           }
           
           $stmt->fetch();
           unset($stmt);

           //Create a new entry if it needs to be updated
           if(!($_POST['street'] == $street && $_POST['city'] == $city && $_POST['state'] == $state && intval($_POST['zip']) == $zip))
           {
               //Update location
               if(!($stmt = $mysqli->prepare("INSERT INTO location (streetAddress, city, state, zip) VALUES (?,?,?,?)"))){
                   echo "insert location prepare failed: "  . $stmt->errno . " " . $stmt->error;
               }

               $z = intval($_POST['zipcode']);
               if(!($stmt->bind_param("sssi",$_POST['street'],$_POST['city'],$_POST['province'],$z))){
                   echo "insert location bind param failed: "  . $stmt->errno . " " . $stmt->error;
               }

               if(!$stmt->execute()){
                   echo "insert location execute failed: "  . $stmt->errno . " " . $stmt->error;
               }  

               unset($stmt);

               //Get the new location
               if(!($stmt = $mysqli->prepare("SELECT id FROM location WHERE streetAddress = ? AND city = ? AND state = ? AND zip = ? LIMIT 1"))){
                   echo "location select prepare failed: "  . $stmt->errno . " " . $stmt->error;
               }

               if(!($stmt->bind_param("sssi",$_POST['street'],$_POST['city'],$_POST['province'],$z))){
                   echo "location select bind param failed: "  . $stmt->errno . " " . $stmt->error;
               }

               if(!$stmt->execute()){
                   echo "location select execute failed: "  . $stmt->errno . " " . $stmt->error;
               }  

               if(!$stmt->bind_result($lid))
               {
                   echo "location select bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
               }

               $stmt->fetch();
               unset($stmt);

                   //Set the restaurant ID to a new id
                   if(!($stmt = $mysqli->prepare("UPDATE restaurant SET lid = ? WHERE id = ?"))){
                       echo "restaurant select prepare failed: "  . $stmt->errno . " " . $stmt->error;
                   }

                   if(!($stmt->bind_param("ii", $lid, $_POST['id']))){
                       echo "restaurant select bind param failed: "  . $stmt->errno . " " . $stmt->error;
                   }

                   if(!$stmt->execute()){
                       echo "restaurant select execute failed: "  . $stmt->errno . " " . $stmt->error;
                   }  
           }
       }

   //Delete existing tags
   if(!($stmt = $mysqli->prepare("DELETE FROM tag_restaurant WHERE rid = ?"))){
        echo "Tag delete prepare failed: "  . $stmt->errno . " " . $stmt->error;
   }

   if(!($stmt->bind_param("i",$_POST['id']))){
        echo "Tag delete bind param failed: "  . $stmt->errno . " " . $stmt->error;
   }

   if(!$stmt->execute()){
        echo "Tag delete select execute failed: "  . $stmt->errno . " " . $stmt->error;
   }  
   unset($stmt);

   //Update Tags!
   $tags = explode(',',$_POST['tags']);
   $tagCount = count($tags);
   for($i = 0;$i < $tagCount;$i++)
   {
       //See if tag currently exists
       //Check that the restaurant doesn't already exist
       if(!($stmt = $mysqli->prepare("SELECT id FROM tag WHERE description = ?"))){
             echo "Tag select prepare failed: "  . $stmt->errno . " " . $stmt->error;
       }

       $t = trim($tags[$i]);
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
       if(isset($tid) == false)
       {
          if(!($stmt = $mysqli->prepare("INSERT INTO tag (description) VALUES (?)"))){
               echo "Tag insert prepare failed: "  . $stmt->errno . " " . $stmt->error;
          }

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

          if(!$stmt->bind_result($tid)){
              echo "Tag select bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }

              $stmt->fetch();
              unset($stmt);
        }

        //Connect the tag to the restaurant
        if(!($stmt = $mysqli->prepare("INSERT INTO tag_restaurant (rid,tid) VALUES (?,?)"))){
              echo "Tag-restaurant insert prepare failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!($stmt->bind_param("ii",$_POST['id'], $tid))){
             echo "Tag-restaurant insert bind param failed: "  . $stmt->errno . " " . $stmt->error;
        }

         if(!$stmt->execute()){
              echo "Tag-restaurant insert execute failed: "  . $stmt->errno . " " . $stmt->error;
         }   

         unset($stmt);
         
   }
    $editSuccess = true;
}
else if(empty($_GET) == false)
{
    $invalidUrl = !isset($_GET['id']);
    if($invalidUrl == false)
    {
        //Connect the tag to the restaurant
        if(!($stmt = $mysqli->prepare("SELECT name, website, phone, lid FROM restaurant WHERE id = ?"))){
              echo "restaurant select prepare failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!($stmt->bind_param("i",$_GET['id']))){
             echo "restaurant select bind param failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->execute()){
            echo "restaurant select execute failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->bind_result($name, $website, $phone, $lid))
        {
            echo "Tag select bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }        

        while($stmt->fetch()){}
        
         //Connect the tag to the restaurant
        if(!($stmt = $mysqli->prepare("SELECT streetAddress, city, state, zip FROM location WHERE id = ?"))){
              echo "Location select prepare failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!($stmt->bind_param("i",$lid))){
             echo "Location select bind param failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->execute()){
            echo "Location select execute failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->bind_result($address, $city, $state, $zip))
        {
            echo "Location select bind result failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }        

        while($stmt->fetch()){}
        
        //Get associated tags
         if(!($stmt = $mysqli->prepare("SELECT T.description FROM restaurant R INNER JOIN tag_restaurant TR ON R.id=TR.rid INNER JOIN tag T ON T.id=TR.tid WHERE R.id = ?"))){
              echo "Tag select prepare failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!($stmt->bind_param("i",$_GET['id']))){
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
                 $tagstring = $tagstring . ", " . trim($tag);
              else
                 $tagstring = $tag;
              $count++;
        }

        unset($stmt);         
    }
}

?>

<html>
<head>
    <title>Database Restaurant</title>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css" />
</head>
<body>
    <?php
    //We will navigate back to the proper window if this one doesn't have the required information to perform an edit
    if($invalidUrl == true || $editSuccess == true)  {
        echo "<script>\n";
        echo "window.location = \"adminRestaurant.php?username=" . $username . "&password=" . $password . "\";";
        echo "</script>\n";

    } else {
        
    ?>
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
                    <h3> Restaurant Information </h3>
                    <label>Name</label>
                    <input type="text" name="name" value=<?php echo "\"" . $name . "\""?> />
                    <br />
                    <label>Website</label>
                    <input type="text" name="website" value=<?php echo "\"" . $website . "\""?> />
                    <br />
                    <label>Phone</label>
                    <input type="tel" name="phone" value=<?php echo "\"" . $phone . "\""?> />
                    <p style="color: white;">Enter your tags with a comma after each individual tag</p>
                    <label>Tags</label>
                    <input type="text" name="tags" value=<?php echo "\"" . $tagstring . "\""?> />
                </div>

                <div class="subform">
                    <h3> Location Information </h3>
                    <br />
                    <label class="form_label">Street Address </label>
                    <input type="text" name="street" value=<?php echo "\"" . $address . "\""?> />
                    <br />
                    <label class="form_label">City </label>
                    <input type="text" name="city" value=<?php echo "\"" . $city . "\""?> />
                    <br />
                    <label class="form_label">State  </label>
                    <input type="text" name="province" value=<?php echo "\"" . $state . "\""?> />
                    <br />
                    <label class="form_label">Zipcode (5-digits) </label>
                    <input type="text" name="zipcode" value=<?php echo "\"" . $zip . "\""?> />
                </div>
                 <?php
                    echo "<input type='hidden' name='id' value='" . $_GET['id'] . "'/>\n";
                    echo "<input type='hidden' name='username' value='" . $username . "'/>\n";
                    echo "<input type='hidden' name='password' value='" . $password . "'/>\n";
                 ?>
                <input class="btn btn-primary" type="submit" value="Submit" />
            </form>
        </div>
    </div>
    <?php
    }
    ?>
</body>
</html>
