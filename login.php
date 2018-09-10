<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="css/loginstyle2.css" />
</head>
<body>
<?php
require('db.php');


// If form submitted, insert values into the database.
if (isset($_POST['username'])){
        // removes backslashes
	$username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
	$username = mysqli_real_escape_string($db,$username);
	$password = stripslashes($_REQUEST['password']);
	$password = mysqli_real_escape_string($db,$password);
	//Checking is user existing in the database or not
        $query = "SELECT * FROM `users` WHERE username='$username'
and password='".md5($password)."'";
	$result = mysqli_query($db,$query) or die(mysql_error());
	$rows = mysqli_num_rows($result);
        if($rows==1){
	    $_SESSION['username'] = $username;
            // Redirect user to index.php
	    header("Location: index.php");
         }else{
	echo "<div class='form'>
<h3>Username/password is incorrect.</h3>
<br/>Click here to <a href='login.php'>Login</a></div>";
	}
    }else{
?>
<div id = "justlogo">
	<img src="justshooklogo.png" alt="logo" style="width:250px;height:250px;">
</div>
<div class ="con">
<div class="form">
  <header class="head-form">
  <h2>Log In</h2>
  <p> Enter your login details </p>
</header>
<form action="" method="post" name="login">
<input type="text" name="username" placeholder="Username" required />
<input type="password" name="password" placeholder="Password" required />
<input name="submit" type="submit" value="Login" class="loginSB"/>
</form>
<div id ="noreg">
<p>Not registered yet? <a href='registration.php'>Register Here</a></p>
</div>
</div>
</div>
<?php } ?>
</body>
</html>
