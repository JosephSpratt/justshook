<?php
require('db.php');
include('auth.php');
$_SESSION['uid'] = 1;


if(isset($_GET['keywords'])) {
  $keywords = $db->escape_string($_GET['keywords']);


   $query = $db->query
   ("SELECT * FROM `users` WHERE username LIKE '%{$keywords}%'");
}
$results= $query;

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 <meta charset="utf-8">
 <title>Search Results</title>
 <link rel="stylesheet" href="css/searchresults.css" />
 </head>
 <body>
   <div class="con">
     <div class="page_box">
   <header class="head_form"> Add users as friends from this list below. Once they have accepted you can begin betting with them! </header>
   <p></p>
   <div> Found <?php echo $results->num_rows; ?> results </div>

    <?php foreach($results as $row) {?>
    <?php $id = $row["id"]; ?>

   <?php if($id != $_SESSION['uid']) { ?>

   <h3><?php echo $row["username"] ?>  [<?php echo $row["email"]; ?>]  </h3>


      <?php
    }

    ?>
 		</div>
    <a href='index.php'>
      <div class="homebutton"> Home </div>
    </a>
  </div>
</body>
</html>
