<?php
//include auth.php file on all secure pages
require("db.php");
include("auth.php");
$num='';
if(isset($_GET['quantity'])){
// Fetching variables of the form which travels in URL
$num=$_GET['quantity'];
$q=(int)$num;
$quantity=(float)$q;

$id = $_GET['id'];
$email = $_GET['email'];

$sql = "UPDATE users SET balance = balance - $quantity WHERE username = '".$_SESSION['username']."'";
if(mysqli_query($db,$sql)){


$newbalance = mysqli_query($db,"SELECT balance FROM users WHERE username LIKE '".$_SESSION['username']."'");
while ($row = $newbalance->fetch_assoc()) {
    $balance= "<div id='shownewbalance'>Your new balance is ".$row['balance']."</div>";
}
}



else{
  header( "Location: bet.php" );
}
}
$quantity='';
$id_to='';
$bet_title='';
$id_from='';
if(isset($_GET['email'])){
  $sql = "SELECT id FROM users WHERE email = '".$_GET['email']."'";
  $userid = mysqli_query($db,$sql);
  while($row=$userid->fetch_array()){
    $id_to = $row['id'];
    $id_to=intval($id_to);
  }
  $sq = "SELECT title FROM bets WHERE id = '".$_GET['id']."'";
  $titleid = mysqli_query($db,$sq);
  while($row=$titleid->fetch_array()){
    $bet_title = $row['title'];
    $bet_title = mysqli_real_escape_string($db, $bet_title);
  }
  $num=intval($num);
  $q = "SELECT id FROM users WHERE username = '".$_SESSION['username']."'";
  $id = mysqli_query($db,$q);
  while($row=$id->fetch_array()){
    $id_from = $row['id'];
    $id_from=intval($id_from);

  }


  $s = "INSERT into `bet_requests` (id_from,id_to,amount,bet_title,accepted,happened)
VALUES ('$id_from', '$id_to', '$num','$bet_title', '0','0')";
if (mysqli_query($db, $s)) {
$yourbets = "<div id='yourbets'>Go to 'Your Bets' to see active, sent and recieved bets!</div>";
} else {
  echo "Error updating record: " . mysqli_error($db);
}

}



?>﻿
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Bet Sent!</title>
<link rel="stylesheet" href="css/betsent.css" />
</head>
<body>
  <div class="page_box">
  <header class="head-form">
  <h2>Bet Sent!</h2>
  <div class="betbox">
    <div id="successmsg">You have successfully sent your bet!</div>
    <?php echo "$balance"; ?>
    <?php echo "$yourbets"; ?>



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
