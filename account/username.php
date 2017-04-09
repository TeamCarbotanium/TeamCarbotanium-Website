<?php
	ob_start();
	session_start();
	if(!isset($_SESSION['userid']))
	{
		header("Location: login.php");
	}
	include_once 'php/dbconnect.php';
	if(isset($_POST['btn-username'])!="")
	{
		//username cleanup
	    $regUsername = trim($_POST['regUsername']);
	    $regUsername = strip_tags($regUsername);
	    $regUsername = htmlspecialchars($regUsername);

	    //username validation
	    if(empty($regUsername))
	    {
	      $error = true;
	      $regUsernameErr = "Please enter a username.";
	    } else if (strlen($regUsername) < 3) {
	      $error = true;
	      $regUsernameErr = "Username must be atleast 3 characters long.";
	    } else if (!preg_match("/^[a-zA-Z0-9]*$/",$regUsername)) {
	      $error = true;
	      $regUsernameErr = "Username must contain alphanumeric characters only.";
	    }

	    if( !$error ) {
   
	    	$query = ("UPDATE userTable SET userName WHERE userId = $_SESSION['user']");
	    	$res = mysqli_query($conn, $query);
	    	if($res) {
	      		$success = "Successfully registered!";
	      		unset($regUsername);
	      		//go to verify page
	     	} else {
	     	 $error = "Something went wrong, please try again later.";
	     	} 
	    }
	}
?>
<!DOCTYPE html>
<html>
	<head>
	  	<meta charset="UTF-8">
	  	<title>Create a username</title>
	  
	  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"/>

	  	<link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'/>
		<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
		<link rel="stylesheet" href="css/style.css"/>  
	</head>

	<body>
	<!-- Mixins-->
	<!-- Pen Title-->
	<?php
	  if(isset($regUsernameErr))
	  {
	    ?>
	      	<h3 class="error"><?php echo $regUsernameErr; ?></h3>
	    <?php
	  }else if(isset($error))
	  {
	  	?>
	  		<h3 class="error"><?php echo $error; ?></h3>
	  	<?php
	  }
	?>
	<div class="container">
	  <div class="card"></div>
	  <div class="card">
	    <h1 class="title">Create a username</h1>
	    <form method="post" autocomplete="off">
	      <div class="input-container">
	        <input name="regUsername" id="#{label}" required="required"/>
	        <label for="#{label}">Username</label>
	        <div class="bar"></div>
	      </div>
	      <div class="button-container">
	        <button type="submit" name="btn-username"><span>Go</span></button>
	      </div>
	    </form>
	  </div>
	  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	  <script src="js/index.js"></script>
	</body>
</html>