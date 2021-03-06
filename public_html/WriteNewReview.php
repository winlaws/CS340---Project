<?php
    require("includes/header.php");
    require_once("includes/header.php");
    require("includes/invalidlogin.php");
    require_once("includes/invalidlogin.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Write New Review</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>   

      <!-- Customized CSS -->
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
      <!-- Display Back to Search Link -->
      <?php
        //get restaurant name
        if(!($stmt = $mysqli->prepare("SELECT restaurant.name FROM restaurant WHERE restaurant.id=(?)")))
        {
            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
        }
        if(!($stmt->bind_param("i",$_GET['rid']))){
            echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
        }
        if(!$stmt->execute()){
            echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
        } 
        if(!$stmt->bind_result($name)){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }
        if(!$stmt->fetch()){
            echo 'Error: Restaurant ID Not Found - Cannot Write Review';
        }
        
        //Display Restaurant Review Form
        else {
           echo '<br/>
              <div class="text-right">
                <a href=Search.php?username=' . $username . '&password=' . $password . '&rid=' . $_GET['rid'] . '>Back to ' . $name . ' Restaurant Page</a>
              </div>
              <br/>';
 
          echo '<div class="backdrop">';
          echo '<h1 class="text-center"> Write New Review For ' . $name . '</h1>
                <br/>
                <form method="post" action="RestaurantPage.php?username=' . $username . '&password=' . $password . '&rid=' . $_GET['rid'] . '" class="subform">
                    <input type="hidden" name="username" value="' . $username . '"/>
                    <input type="hidden" name="password" value="' . $password . '"/>

                    <input type="hidden" name="rid" value="' . $_GET['rid'] . '"></input>     
                    <input type="hidden" name="uid" value="' . $id . '"></input>
                    


                    <div class="form-group">
                      <label class="white-text" for="rating">Rating</label>               
                      <br/>
                      <div class="text-center">
                        <input type="radio" name="rating" class="radio-inline" value=1><span class="white-text">1</span></input>&nbsp&nbsp&nbsp&nbsp
                        <input type="radio" name="rating" class="radio-inline" value=2><span class="white-text" >2</span></input>&nbsp&nbsp&nbsp&nbsp
                        <input type="radio" name="rating" class="radio-inline" value=3 checked><span class="white-text">3</span></input>&nbsp&nbsp&nbsp&nbsp
                        <input type="radio" name="rating" class="radio-inline" value=4><span class="white-text">4</span></input>&nbsp&nbsp&nbsp&nbsp
                        <input type="radio" name="rating" class="radio-inline" value=5><span class="white-text">5</span></input>
                      </div>
                    </div>
              
                    <div class="form-group">
                      <label class="white-text" for="txt">Review Text</label>
                      <textarea name="txt" placeholder="Write Review Here..." class="form-control"></textarea>
                    </div>

                    <br/>
                    <div class="text-center">
                      <input type="submit" class="btn btn-primary"></input>
                    </div>
                </form>';
        }
        $stmt->close();
        echo '</div>';
      ?> 
    </div>
  </body>
</html>