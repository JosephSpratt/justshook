<?php
//include auth.php file on all secure pages
require("db.php");
include("auth.php");
$users='';
if(isset($_POST['searchuser'])){
    $searchkey= $_POST['searchuser'];
    $searchkey=preg_replace("#[^0-9a-z]#i", "", $searchkey);

    $query = mysqli_query($db,"SELECT * FROM users WHERE username LIKE '%$searchkey%' OR email LIKE '%$searchkey%' LIMIT 6") or die("Could not search!");
    $count = mysqli_num_rows($query);

    if($count == 0){
        $users="There was no search result!";
    }
    else{
        while($row=mysqli_fetch_array($query)){
            $username=$row['username'];
            $email=$row['email'];

            $users .=
            '<a href="sendbet.php?id='.$_GET['id'].'&email='.$email.'" style="text-decoration: none"">
            <div id="eachuser">'.$username.' ['.$email.']</div>
            </a>';



        }
    }
}

$selectedbet='';
$submitbox='';
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
            $submitbox .='  <form action="searchuserbet.php?id='.$searchbet.'" method="post">
                <input type="text" name="searchuser" placeholder="Search for a User" />
                <input type="submit" value="Search" />
              </form>';


        }
      }

}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Select a User to challenge!</title>
<link rel="stylesheet" href="css/searchuserbet.css" />
</head>
<body>

  <div class="page_box">
  <header class="head-form">
  <h2>Who would you like <p>to challenge!? </p></h2>
  <div class="betbox">
  <?php echo "$submitbox"; ?>
    <div id="selectedmsg"> You've Selected...</div>
    <?php echo "$selectedbet"; ?>
    <div class="list_users">

    <?php echo "$users"; ?>

  </div>


  </div>
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
