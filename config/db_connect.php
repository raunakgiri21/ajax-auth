<?php
 // connect to the database
  $conn = mysqli_connect('localhost','root','','users-php');

  // check connection status
  if(!$conn) {
    echo 'Connection failed: ' . mysqli_connect_error();
    exit();
  }
?>