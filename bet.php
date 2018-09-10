<?php
//include auth.php file on all secure pages
require("db.php");
include("auth.php");
$output='';
if(isset($_POST['searchbet'])){
    $searchkey= $_POST['searchbet'];
    $searchkey=preg_replace("#[^0-9a-z]#i", "", $searchkey);

    $query = mysqli_query($db,"SELECT * FROM bets WHERE title LIKE '%$searchkey%' OR category LIKE '%$searchkey%' LIMIT 10") or die("Could not search!");
    $count = mysqli_num_rows($query);

    if($count == 0){
        $output="There was no search result!";
    }
    else{
        while($row=mysqli_fetch_array($query)){
            $title=$row['title'];
            $category=$row['category'];

            $output .='<a href="searchuserbet.php?id='.$row['id'].'" style="text-decoration: none"">
            <div id="eachbet">'.$title.' [Category:'.$category.']</div>
            </a>';



        }
    }
}
?>﻿
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Create a New Bet</title>
<link rel="stylesheet" href="css/bet.css" />
</head>
<body>
  <div class="page_box">
  <header class="head-form">
  <h2>Create a Bet</h2>
  <div class="betbox">
    <form action="bet.php" method="post">
      <input type="text" name="searchbet" placeholder="Search for a bet" />
      <input type="submit" value="Search" />
    </form>
    <div class="list_bets">
    <?php echo "$output"; ?>

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
