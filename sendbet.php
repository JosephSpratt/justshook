<?php
//include auth.php file on all secure pages
require("db.php");
include("auth.php");
$selectedbet='';
$selecteduser='';
$searchbet='';
$searchuser='';
if(isset($_GET['id'])){
$searchbet= $_GET['id'];
$query = mysqli_query($db,"SELECT * FROM bets WHERE id LIKE '%$searchbet%' LIMIT 1") or die("Could not search!");
$count = mysqli_num_rows($query);

if($count == 0){
    $selectedbet="Go back and select a bet";
}
else{
    while($row=mysqli_fetch_array($query)){
        $title=$row['title'];
        $category=$row['category'];

        $selectedbet .='
        <div id="selectedbet">'.$title.' ['.$category.']</div>
        ';
}
}
}
if(isset($_GET['email'])){
$searchuser= $_GET['email'];
$query = mysqli_query($db,"SELECT * FROM users WHERE email LIKE '%$searchuser%' LIMIT 1") or die("Could not search!");
$count = mysqli_num_rows($query);

if($count == 0){
    $selectedbet="Go back and select a User";
}
else{
    while($row=mysqli_fetch_array($query)){
        $username=$row['username'];
        $email=$row['email'];

        $selecteduser .='
        <div id="eachuser">'.$username.' ['.$email.']</div>
        ';
}
}
}

?>﻿
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Send Bet</title>
<link rel="stylesheet" href="css/sendbet.css" />
</head>
<body>
  <div class="page_box">
  <header class="head-form">
  <h2>How much do you <p></p> want to bet?</h2>
  <div class="betbox">
<div id="selectedmsg"> You've Selected...</div>
<?php echo "$selectedbet"; ?>
<div id="selectedmsguser"> To Send to ...</div>
<?php echo "$selecteduser"; ?>
<div id="selectedmsgamount"> Select how many credits you want to bet ...</div>
<?php
$query= mysqli_query($db,"SELECT * FROM `users` WHERE `username` = '".$_SESSION['username']."'")or die(mysql_error());
$arr = mysqli_fetch_array($query);
?>



<form id="inputamount" action="betsent.php" method="GET">
  
  <div id="creditsmsg">
    <div id="scrollbox">
      <marquee behavior="scroll" direction="left">

    You have <span style="color: #d8617b ; font-weight: bolder"><?php echo $arr['balance'] ?></span> credits in your account to bet with!

  </marquee>
</div>
  <input type="number" name="quantity" min="1" max="<?php echo $arr['balance'] ?>"/>
  <input type="hidden" name="id" value="<?php echo $searchbet;?>" />
  <input type="hidden" name="email" value="<?php echo $searchuser;?>" />
  <input type="submit" value="Send Bet!"/>
</form>



  </div>
</div>



<p></p>
<a href='index.php'>
  <div class="homebutton"> Home </div>
</a>




</div>
<div id = "justlogo">
	<img src="justshooklogo.png" alt="logo" style="width:250px;height:250px;">
</div>
</body>
</html>
