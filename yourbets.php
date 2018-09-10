<?php
//include auth.php file on all secure pages
require("db.php");
include("auth.php");

$sql = "SELECT id FROM users WHERE username LIKE '".$_SESSION['username']."'";
$userid = mysqli_query($db,$sql);
$row=$userid->fetch_array();
  $user = $row['id'];

if($user != 0){
  $sqll = "SELECT * FROM bet_requests WHERE id_from = '".$user."'";
  $getbetss = mysqli_query($db,$sqll);
  $r=$getbetss->fetch_array();
    $title = $r['bet_title'];
    $id_to = $r['id_to'];
    $id_from =$r['id_from'];
    $amount = $r['amount'];
    $accepted=$r['accepted'];

  $s = "SELECT username FROM users WHERE id = '".$id_to."'";
  $getusername = mysqli_query($db,$s);
  $ro=$getusername->fetch_array();
    $username_to = $ro['username'];
    $sentbet='';

  $sq = "SELECT * FROM bet_requests WHERE id_from = '".$user."' AND accepted = '0'";
  $getbets = mysqli_query($db,$sq);
  $row=$getbets->fetch_array();
  $numrows = $getbets->num_rows;
  if($numrows <= 4){

    foreach($getbets as $row){

      $title = $row['bet_title'];
      $id_to = $row['id_to'];
      $id_from =$row['id_from'];
      $amount = $row['amount'];
      $accepted=$row['accepted'];

      $ss = "SELECT username FROM users WHERE id = '".$id_to."'";
      $getusernamee = mysqli_query($db,$ss);
      $roww=$getusernamee->fetch_array();
        $username_to = $roww['username'];


      $sentbet .= '<div id="yoursentbets"> You asked <span style="color: #d8617b">'.$username_to.'</span> to bet with you! You staked <span style="color: #d8617b"> '.$amount.'</span> credits. </br>The bet was <span style="color: #d8617b"> '.$title.'</span> !<div id="linebreak"></div></div>';

    }
  }
    else{
      $sentbet .= '<div id="yoursentbets">You have too many pending bets, please wait for some to be accepted. <p></p>
      The maximum amount of pending bets allowed is 4.</div>';
    }

  }


  $recieved = "SELECT * FROM bet_requests WHERE id_to = '".$user."' AND accepted = '0'";
  $recievedbets = mysqli_query($db, $recieved);
  $recievedrow = $recievedbets->fetch_array();



$recievedbet ='';


foreach($recievedbets as $recievedrow){
  $recievedfromid = $recievedrow['id_from'];
  $recievedamount = $recievedrow['amount'];
  $recievedtitle = $recievedrow['bet_title'];


  $challangerusernamesql = "SELECT username FROM users WHERE id = '".$recievedfromid."'";
  $challangerusername = mysqli_query($db,$challangerusernamesql);
  $challangerrow=$challangerusername->fetch_array();
  $userchallanging = $challangerrow['username'];




  $recievedbet .= '<div id="yourrecievedbets"><span style="color: #d8617b">'.$userchallanging.'</span>
   has requested to bet with you! They staked <span style="color: #d8617b">'.$recievedamount.'</span> credits.
    The bet was <span style="color: #d8617b">'.$recievedtitle.'</span> !
    <form action="yourbets.php" method="post">
      <input type="submit" name="acceptbet" value="accept" placeholder="Accept" />
      <input type="submit" name="declinebet" value="decline" placeholder="Decline" />
    </form>
    <div id="linebreak"></div></div>';

    if (isset($_POST["acceptbet"])) {
        unset($_POST["declinebet"]);

        $updatebetsql = "UPDATE bet_requests SET amount = amount *2, accepted = '1' WHERE bet_title LIKE '".$recievedtitle."' AND id_from = '".$recievedfromid."' ";
        $updatebet = mysqli_query($db, $updatebetsql);

        $updatebalancesql = "UPDATE users SET balance = balance - $recievedamount WHERE username = '".$_SESSION['username']."'";
        $updatebalance = mysqli_query($db, $updatebalancesql);
        header("Refresh:0");

    }if(isset($_POST["declinebet"])){


        unset($_POST["acceptbet"]);
        $updatebetsqll = "DELETE FROM bet_requests WHERE bet_title LIKE '".$recievedtitle."' AND id_from LIKE '".$recievedfromid."'";
        $updatebett = mysqli_query($db, $updatebetsqll);

        $updatebalancesqll = "UPDATE users SET balance = balance + $recievedamount WHERE username = '".$userchallanging."'";
        $updatebalancee = mysqli_query($db, $updatebalancesqll);
        header("Refresh:0");
    }

}
 $active = "SELECT * FROM bet_requests WHERE id_to = '".$user."' AND accepted = '1' AND happened = '0' OR id_from = '".$user."' AND accepted = '1' AND happened = '0' ";
  $activebets = mysqli_query($db, $active);
  $activerow = $activebets->fetch_array();



$activebet ='';
foreach($activebets as $activerow){
  $recievedfromidd = $activerow['id_from'];
  $recievedamountt = $activerow['amount'];
  $recievedtitlee = $activerow['bet_title'];


  $challangerusernamesqll = "SELECT username FROM users WHERE id = '".$recievedfromidd."'";
  $challangerusernamee = mysqli_query($db,$challangerusernamesqll);
  $challangerroww=$challangerusernamee->fetch_array();
  $userchallangingg = $challangerroww['username'];


  $activebet .= '<div id="youractivebets"><span style="color: #d8617b">'.$recievedtitlee.'</span>.
  Against <span style="color: #d8617b">'.$userchallangingg.'</span>. With <span style="color: #d8617b">'.$recievedamountt.'</span> credits on the line!
  Remember.. You <span style="color: #d8617b"> JustShook </span> on it!
    <div id="linebreak"></div></div>';

}

















?>﻿
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Your Bets</title>
<link rel="stylesheet" href="css/betsent.css" />
</head>
<body>
  <div class="page_box">
  <header class="head-form">
  <h2>Your Bets</h2>
  <div class="betbox">
    <span style="color: white ; font-weight: bold; font-size: 15px"> Pending Bets </span>
    <div class="sent">
<?php if($user == $id_from) echo $sentbet  ?>
    </div>
    <span style="color: white ; font-weight: bold; font-size: 15px"> Recieved Bets </span>
    <div class="received">
<?php echo $recievedbet ?>
    </div>

    <span style="color: white ; font-weight: bold; font-size: 15px"> Active Bets </span>
    <div class="active">
      <?php echo $activebet ?>

    </div>




  </div>


<p></p>
<a href='index.php'>
  <div class="homebutton"> Home </div>
</a>


<div id = "justlogo">
	<img src="justshooklogo.png" alt="logo" style="width:250px;height:250px;">
</div>

</div>

</body>
</html>
