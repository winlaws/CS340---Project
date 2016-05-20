<!DOCTYPE html>
<html lang="en">
	<head>
    	<title>Write New Review</title>
  	</head>
  	<body>
    	<form method="post" action="AddNewReview.php">
    		<!-- hidden user id field -->
    		<!-- hidden restaurant id field -->
			<!-- hidden date/time field -->
    		<input type="hidden" name="uid" value=1></input>
    		
    		<?php 
    			echo '<input type="hidden" name="rid" value="' . $_GET['rid'] . '"></input>';    		
    		?>
    			
    		<input type="radio" name="rating" value=1>1</input>
			<input type="radio" name="rating" value=2>2</input>
			<input type="radio" name="rating" value=3>3</input>
			<input type="radio" name="rating" value=4>4</input>
			<input type="radio" name="rating" value=5>5</input>
		
			<br/>
			<textarea name="txt">Write Review Here...</textarea>

			<br/>
			<input type="submit"></input>
		</form>
  	</body>
</html>