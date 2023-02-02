<?php
$con = mysqli_connect("localhost","d03a143f","ZXftqJqPNtoEBmV5","d03a143f");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error() ." | Seems like you haven't created the DATABASE with an exact name";
  }
?>