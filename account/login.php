<?php

  ob_start();
  session_start();
  if(isset($_SESSION['user'])!="")
  {
    header("Location: home.php");
  }
  include_once 'php/dbconnect.php';

  if(isset($_POST['btn-signup']))
  {
    
    $error = false;

    //email cleanup
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    //username cleanup
    $regUsername = trim($_POST['regUsername']);
    $regUsername = strip_tags($regUsername);
    $regUsername = htmlspecialchars($regUsername);

    //password cleanup
    $regPassword = trim($_POST['regPassword']);
    $regPassword = strip_tags($regPassword);
    $regPassword = htmlspecialchars($regPassword);

    //confirm password cleanup
    $repPassword = trim($_POST['repPassword']);
    $repPassword = strip_tags($repPassword);
    $repPassword = htmlspecialchars($repPassword);

    //username validation
    if(empty($regUsername))
    {
      $error = true;
      ?>
        <script>
           alert("Please enter a username.");
        </script>
      <?php
    } else if (strlen($regUsername) < 3) {
      $error = true;
      ?>
        <script>
          alert("Name must have atleast 3 characters.");
        </script>
      <?php
    } else if (!preg_match("/[^a-z_\-0-9]/i",$regUsername)) {
      $error = true;
      ?>
        <script>
          alert("Name must contain alphanumeric characters only.");
        </script>
      <?php
    }

    //email validation
    if( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
      $error = true;
      ?>
        <script>
          alert("Please enter valid email address.");
        </script>
      <?php
    } else {
     // check email exist or not
      global $conn;
     $query = "SELECT userEmail FROM userTable WHERE userEmail='$email'";
     $result = mysql_query($query, $conn);
     $count = mysql_num_rows($result);
     if($count!=0){
      $error = true;
      ?>
        <script>
          alert("Provided Email is already in use.");
        </script>
      <?php
     }
    }

    //password validation
    if(empty($regPassword)){
      $error = true;
      ?>
        <script>
          alert("Please enter a password.");
        </script>
      <?php
    } else if(strlen($regPassword) < 6) {
      $error = true;
      ?>
        <script>
          alert("Password must have atleast 6 characters.");
        </script>
      <?php
    }

    //SHA-256 password encryption
    $regPass= hash('sha256', $regPassword);

    // if there's no error, continue to signup
    if( !$error ) {
   
     $query = "INSERT INTO userTable(userName,userEmail,userPass) VALUES('$regUsername','$email','$regPass')";
     $res = mysql_query($query);
     if($res) {
      ?>
        <script>
          alert("Successfully registered, you may login now");
        </script>
      <?php
      unset($name);
      unset($email);
      unset($pass);
     } else {
      ?>
        <script>
          alert("Something went wrong, try again later...");
        </script>
      <?php
     } 
    }
    
  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"/>

  <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'/>
<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

      <link rel="stylesheet" href="css/style.css"/>

  
</head>

<body>
  
<!-- Mixins-->
<!-- Pen Title-->
<div class="container">
  <div class="card"></div>
  <div class="card">
    <h1 class="title">Login</h1>
    <form method="post" autocomplete="off">
      <div class="input-container">
        <input name="username" id="#{label}" required="required"/>
        <label for="#{label}">Username</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input name="password" id="#{label}" required="required" type="password"/>
        <label for="#{label}">Password</label>
        <div class="bar"></div>
      </div>
      <div class="button-container">
        <button type="submit" name="btn-login"><span>Go</span></button>
      </div>
      <div class="footer"><a href="#">Forgot your password?</a></div>
    </form>
  </div>
  <div class="card alt">
    <div class="toggle"></div>
    <h1 class="title">Register
      <div class="close"></div>
    </h1>
    <form method="post" autocomplete="off">
      <div class="input-container">
        <input name="email" id="#{label}" required="required" type="email"/>
        <label for="#{label}">Email</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input name"regUsername" id="#{label}" required="required" type="username"/>
        <label for="#{label}">Username</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input name="regPassword" id="#{label}" required="required" type="password"/>
        <label for="#{label}">Password</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input name="repPassword" id="#{label}" required="required" type="password"/>
        <label for="#{label}">Repeat Password</label>
        <div class="bar"></div>
      </div>
      <div class="button-container">
        <button type="submit" name="btn-signup"><span>Next</span></button>
      </div>
    </form>
  </div>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>

</body>
</html>