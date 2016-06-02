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
    <?php
      if(!($stmt = $mysqli->prepare("SELECT restaurant.name FROM restaraunt WHERE restaurant.id=(?)")))
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
      else {
        echo '<div class="col-lg-8 col-lg-offset-2">
                <h1 class="text-center"> Write New Review For ' . $name . '</h1>
                <br/>
                <form method="post" action="RestaurantPage.php?username=' . $username . '&password=' . $password . '&rid=' . $_GET['rid'] . '" class="col-lg-6 col-lg-offset-3">
                    <input type="hidden" name="username" value="' . $username . '"/>
                    <input type="hidden" name="password" value="' . $password . '"/>

                    <input type="hidden" name="rid" value="' . $_GET['rid'] . '"></input>     
                    <input type="hidden" name="uid" value="' . $id . '"></input>
                    


                    <div class="form-group">
                      <label for="rating">Rating</label>               
                      <br/>
                      <div class="text-center">
                        <input type="radio" name="rating" class="radio-inline" value=1>1</input>
                        <input type="radio" name="rating" class="radio-inline" value=2>2</input>
                        <input type="radio" name="rating" class="radio-inline" value=3 checked>3</input>
                        <input type="radio" name="rating" class="radio-inline" value=4>4</input>
                        <input type="radio" name="rating" class="radio-inline" value=5>5</input>
                      </div>
                    </div>
              
                    <div class="form-group">
                      <label for="txt">Review Text</label>
                      <textarea name="txt" placeholder="Write Review Here..." class="form-control"></textarea>
                    </div>

                    <br/>
                    <div class="text-center">
                      <input type="submit" class="btn btn-default"></input>
                    </div>
                </form>
              </div>';
      }
      $stmt->close();
    ?> 
  </body>
</html>