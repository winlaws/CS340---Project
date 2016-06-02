<?php
    require("includes/header.php");
    require_once("includes/header.php");
    require("includes/invalidlogin.php");
    require_once("includes/invalidlogin.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
    	<title>Restaurant Page</title>

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
            // New Review Added 
            if(!empty($_POST))
            {
                if(!($stmt = $mysqli->prepare("INSERT INTO review(uid, rid, rating, reviewtxt, reviewDate) VALUES (?,?,?,?,?)"))){
                    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                }
                $date = date("Y-m-d H:i:s");
                if(!($stmt->bind_param("iiiss",$_POST['uid'],$_POST['rid'],$_POST['rating'],$_POST['txt'],$date))){
                    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->execute()){
                    echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        Execute failed:' .  $stmt->errno . " " . $stmt->error . '
                    </div>';
                } 
                else {
                    echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        New Review Added
                    </div>';
                }                
            }
            
            // <!-- Back to List -->
            $link = "./RestaurantList.php?";
            $first = true;
            foreach($_GET as $key => $value)
            {
                if($key != 'rid')
                {
                    if($first == true)
                    {
                        if($key == 'city' || $key == 'tag')
                        {
                            foreach($value as $key_sub => $value_sub)
                            {
                                $link .= $key . "%5B%5D=" . $value_sub;
                            }
                        }
                        else 
                        {
                            $link .= $key . "=" . $value;
                        }
                        $first = false;
                    }
                    else
                    {
                        if($key == 'city' || $key == 'tag')
                        {
                            foreach($value as $key_sub => $value_sub)
                            {
                                $link .= "&" . $key . "%5B%5D=" . $value_sub;
                            }
                        }
                        else 
                        {
                            $link .= "&" . $key . "=" . $value;
                        }
                    }
                } 
            }

            //echo $link;
            echo '<br/>
                  <div class="text-right col-lg-8 col-lg-offset-2">
                    <a href="' . $link . '">Back to Restaurant List</a>
                  </div>
                  <br/>';

            // Restaurant Info - get using php (sql query)
            if(!($stmt = $mysqli->prepare("SELECT restaraunt.name, restaraunt.website, restaraunt.phone, 
                                                  location.streetAddress, location.city, location.state, location.zip 
                                            FROM restaraunt
                                            INNER JOIN location ON restaraunt.lid = location.id 
                                            WHERE restaraunt.id=(?)")))
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

            echo '<div class="col-lg-8 col-lg-offset-2">';
            
            while($stmt->fetch()){
                echo '<div class="text-center">
                        <h1>' . $name . '</h1>
                        Website: <a href="' . $website . '">' . $website . '</a> <br/>
                        Phone: ' . $phone . '<br/>'
                        . $streetAddress . '<br/>'
                        . $city . ', ' . $state . ' ' . $zip .
                    '</div>';
            }
            $stmt->close();
        ?>
        	
        <!-- Review Section -->
		<br/>
        <?php
            echo '<!-- Add New Review -->
                <h3>Reviews</h3> 
                <div>
                    <a href="./WriteNewReview.php?username=' . $username . '&password=' . $password . '&rid=' . $_GET['rid'] . '">Write New Review</a> <br/>
                </div>';

            // Get reviews using query
            if(!($stmt = $mysqli->prepare("SELECT review.rating, user.username, review.reviewDate, review.reviewtxt 
                                            FROM review
                                            INNER JOIN user ON review.uid = user.id 
                                            WHERE review.rid=(?)
                                            ORDER BY review.reviewDate DESC")))
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
                    <div class="well">
                        <div>
                            <h4>' . $rating . '/5 - ' . $username . ' - ' . $date . '</h4>
                        </div>
                        <div>'
                            . $txt .
                        '</div>
                    </div>';
            }
            $stmt->close();

            echo '</div>';
        ?>
        </div>
  	</body>
</html>