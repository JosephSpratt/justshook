<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Registration</title>
<link rel="stylesheet" href="css/loginstyle.css" />
</head>
<body>
<?php
require('db.php');
// If form submitted, insert values into the database.
if (isset($_REQUEST['username'])){
        // removes backslashes
	$username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
	$username = mysqli_real_escape_string($db,$username);
	$email = stripslashes($_REQUEST['email']);
	$email = mysqli_real_escape_string($db,$email);
	$password = stripslashes($_REQUEST['password']);
	$password = mysqli_real_escape_string($db,$password);
	$trn_date = date("Y-m-d H:i:s");
	$balance = 50;
        $query = "INSERT into `users` (username, password, email, trn_date, balance)
VALUES ('$username', '".md5($password)."', '$email', '$trn_date','$balance')";
        $result = mysqli_query($db,$query);
        if($result){
            echo "<div class='form'>
<h3>You are registered successfully.</h3>
<br/>Click here to <a href='login.php'>Login</a></div>";
        }
    }else{
?>
<div id = "justlogo">
	<img src="justshooklogo.png" alt="logo" style="width:250px;height:250px;">
</div>
<div class="form">

<div class="con">
  <header class="head_form">
  <h2>Register</h2>
  <p>Create an account below</p>
</header>
<form name="registration" action="" method="post">
<input id="txt-input" type="text" name="username" placeholder="Username" required />
<input id="txt-input" type="email" name="email" placeholder="Email" required />
<input id="txt-input" type="password" name="password" placeholder="Password" required />
<input id="txt-input" type="submit" name="submit" value="Register" />
</form>
</div>
</div>
<?php } ?>
</body>
</html>
