<?php
//1. Set up the database connection
  $dbhost = "cs4111.cdvq46fbpmdo.us-west-2.rds.amazonaws.com";
  $dbuser = "xw2401";
  $dbpass = "xwyw4111";
  $dbname = "cs4111";
  $dbport = "3306";
  $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $dbport);
  
  //Test if connection occurred.
  if(mysqli_connect_errno()){
    die("Database connection failed: ".
      mysqli_connect_error() .
      " (" . mysqli_connect_errno() . ")"
      );  
  }
?> 