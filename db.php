<?php
// Enter your Host, username, password, database below.

$db = mysqli_connect("dragon","js881","lti7cop","js881");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  session_start();
?>
