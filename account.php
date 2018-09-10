<?php
//include auth.php file on all secure pages
require("db.php");
include("auth.php");
$sql = "SELECT id FROM users WHERE username LIKE '".$_SESSION['username']."'";
$userid = mysqli_query($db,$sql);
$row=$userid->fetch_array();
  $user = $row['id'];

 $wonsent = "SELECT * FROM bet_requests WHERE id_from = '".$user."' AND accepted = '1' AND happened = '1'";
 $wonsentbetss = mysqli_query($db, $wonsent);
 $wonsentrow = $wonsentbetss->fetch_array();

 $wonsentbets='';
 foreach($wonsentbetss as $wonsentrow){
   $wontitle = $wonsentrow['bet_title'];
   $wonagainstid = $wonsentrow['id_to'];
   $wonamount = $wonsentrow['amount'];



   $challangerusernamesql = "SELECT username FROM users WHERE id = '".$wonagainstid."'";
   $challangerusername = mysqli_query($db,$challangerusernamesql);
   $challangerrow=$challangerusername->fetch_array();
   $userchallanging = $challangerrow['username'];

   $wonsentbets .= '<li><span style="color: #d8617b; font-weight:bold";>'.$wontitle.'</span></br> Status:<span style="color: green; font-weight: bold";> WON </span>
    ( <span style="color: #d8617b; font-weight:bold";>'.$wonamount.' credits</span> ) against '.$userchallanging.'</li>
      <form action="account.php" method="post">
        <input id="claimbet" type="submit" name="claimbet" value="claim" placeholder="Claim" />
        </form>';
        if (isset($_POST["claimbet"])) {

          $updatebetsqll = "DELETE FROM bet_requests WHERE bet_title LIKE '".$wontitle."' AND id_to LIKE '".$wonagainstid."'";
          $updatebett = mysqli_query($db, $updatebetsqll);

          $updatebalancesql = "UPDATE users SET balance = balance + $wonamount WHERE username = '".$_SESSION['username']."'";
          $updatebalance = mysqli_query($db, $updatebalancesql);
          header("Refresh:0");
        }
  }


  $wonsent2 = "SELECT * FROM bet_requests WHERE id_to = '".$user."' AND accepted = '1' AND happened = '2'";
  $wonsentbetss2 = mysqli_query($db, $wonsent2);
  $wonsentrow = $wonsentbetss->fetch_array();

  $wonsentbets2='';
  foreach($wonsentbetss2 as $wonsentrow2){
    $wontitle2 = $wonsentrow2['bet_title'];
    $wonagainstid2 = $wonsentrow2['id_from'];
    $wonamount2 = $wonsentrow2['amount'];




    $challangerusernamesql2 = "SELECT username FROM users WHERE id = '".$wonagainstid2."'";
    $challangerusername2 = mysqli_query($db,$challangerusernamesql2);
    $challangerrow2=$challangerusername2->fetch_array();
    $userchallanging2 = $challangerrow2['username'];

    $wonsentbets2 .= '<li><span style="color: #d8617b; font-weight:bold";>'.$wontitle2.'</span></br> Status:<span style="color: green; font-weight: bold";> WON </span>
     ( <span style="color: #d8617b; font-weight:bold";>'.$wonamount2.' credits</span> ) against '.$userchallanging2.'</li>
     <form action="account.php" method="post">
       <input id="claimbet" type="submit" name="claimbet" value="claim" placeholder="Claim" />
       </form>';
       if (isset($_POST["claimbet"])) {

         $updatebetsqll = "DELETE FROM bet_requests WHERE bet_title LIKE '".$wontitle2."' AND id_from LIKE '".$wonagainstid2."'";
         $updatebett = mysqli_query($db, $updatebetsqll);

         $updatebalancesql = "UPDATE users SET balance = balance + $wonamount2 WHERE username = '".$_SESSION['username']."'";
         $updatebalance = mysqli_query($db, $updatebalancesql);
         
         header("Refresh:0");
       }
   }

   $lostsent = "SELECT * FROM bet_requests WHERE id_from = '".$user."' AND accepted = '1' AND happened = '2'";
   $lostsentbetss = mysqli_query($db, $lostsent);
   $lostsentrow = $lostsentbetss->fetch_array();

   $lostsentbets='';
   foreach($lostsentbetss as $lostsentrow){
     $losttitle = $lostsentrow['bet_title'];
     $lostagainstid = $lostsentrow['id_to'];
     $lostamount = $lostsentrow['amount'];



     $challangerusernamesqllost = "SELECT username FROM users WHERE id = '".$lostagainstid."'";
     $challangerusernamelost = mysqli_query($db,$challangerusernamesqllost);
     $challangerrowlost=$challangerusernamelost->fetch_array();
     $userchallanginglost = $challangerrowlost['username'];

     $lostsentbets .= '<li><span style="color: #d8617b; font-weight:bold";>'.$losttitle.'</span></br> Status:<span style="color: red; font-weight: bold";> LOST </span>
      ( <span style="color: #d8617b; font-weight:bold";>'.$lostamount.' credits</span> ) against '.$userchallanginglost.'</li>';
    }

    $lostsent2 = "SELECT * FROM bet_requests WHERE id_to = '".$user."' AND accepted = '1' AND happened = '1'";
    $lostsentbetss2 = mysqli_query($db, $lostsent2);
    $lostsentrow2 = $lostsentbetss2->fetch_array();

    $lostsentbets2='';
    foreach($lostsentbetss2 as $lostsentrow2){
      $losttitle2 = $lostsentrow2['bet_title'];
      $lostagainstid2 = $lostsentrow2['id_from'];
      $lostamount2 = $lostsentrow2['amount'];



      $challangerusernamesqllost2 = "SELECT username FROM users WHERE id = '".$lostagainstid2."'";
      $challangerusernamelost2 = mysqli_query($db,$challangerusernamesqllost2);
      $challangerrowlost2=$challangerusernamelost2->fetch_array();
      $userchallanginglost2 = $challangerrowlost2['username'];

      $lostsentbets2 .= '<li><span style="color: #d8617b; font-weight:bold";>'.$losttitle2.'</span></br> Status:<span style="color: red; font-weight: bold";> LOST </span>
       ( <span style="color: #d8617b; font-weight:bold";>'.$lostamount2.' credits</span> ) against '.$userchallanginglost2.'</li>';
     }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Search Results</title>
<link rel="stylesheet" href="css/account.css" />
</head>
<body>
  <div class="page_box">
  <header class="head-form">
  <h2>Account Details</h2>
  <div class="accountbox">

   <div id="accountwelcome"> Welcome <?php echo $_SESSION['username']; ?> see your account details below. </div>
   <?php
   $query= mysqli_query($db,"SELECT * FROM `users` WHERE `username` = '".$_SESSION['username']."'")or die(mysql_error());
   $arr = mysqli_fetch_array($query);
   ?>

     <div id="credits">You have <div id="balance"><?php echo $arr['balance'] ?> </div>credits remaining. </div>
     <div id="history"> Your Recent Bets </div>
     <p></p>

  <ul style="list-style-type:none" id="betlist">
  <?php echo $wonsentbets; ?>
  <?php echo $wonsentbets2; ?>
  <?php echo $lostsentbets; ?>
  <?php echo $lostsentbets2; ?>

</ul>

  </div>

  <a href='index.php'>
    <div class="homebutton"> Home </div>
  </a>




</div>
<div id = "justlogo">
	<img src="justshooklogo.png" alt="logo" style="width:250px;height:250px;">
</div>
</body>
</html>
