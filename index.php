<?php
//include auth.php file on all secure pages

require('db.php');
include('auth.php');
$query= mysqli_query($db,"SELECT * FROM `users` WHERE `username` = '".$_SESSION['username']."'")or die(mysql_error());
$arr = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome Home</title>
<link rel="stylesheet" href="css/homepage.css" />
</head>
<body>
  <div id = "justlogo">
  	<img src="justshooklogo.png" alt="logo" style="width:250px;height:250px;">
  </div>

  <div id="con">
    <div id="head_bar">
      <div id="scrollbox">

        <marquee behavior="scroll" direction="left">

      You have <span style="color: #d8617b ; font-weight: bolder"><?php echo $arr['balance'] ?></span> credits in your account to bet with!

    </marquee>
  </div>
    <div id="indexwelcome"> Hello <?php echo $_SESSION['username']; ?>!</div> <p></p>
    <div id="indexwelcome2"> Please see <span style="color: #d8617b ; font-weight: bold"> About</span> if you're unsure about anything. </div><p></p>
    <div id="indexwelcome3"> If not please bet responsibly, have fun and good luck! </div>
  </div>

<div id="bottom_bar">
<div class="menu">
  <h2>Home</h2>

  <div class="menu_con">
  <div class="logoutbox">
  <a href="logout.php">Logout</a></div>
  <a href='account.php'><div class="accountbox"> Account </div></a>
  <a href='bet.php'>
    <div class="topicsearchbox"> Create a New Bet </div></a>
  <a href='yourbets.php'><div class="usersearchbox"> Your Bets </div></a>
  <a href='about.php'><div class="aboutbox"> About </div></a>

</div>
</div>
<div id="copyright"> Copyright © 2018 Joseph Spratt. All rights reserved.</div>
</div>

</div>
</body>
</html>
