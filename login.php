<?php
require 'connection.php';

    if(isset($_POST['UserId'])){
    $UserId=$_POST['UserId'];
    $password=$_POST['Password'];
    setcookie('UserId',$UserId,time()+3600);
    $query="SELECT * FROM  User WHERE  User_ID='".$UserId."'AND Password='".$password."'LIMIT 1";
    $result=mysqli_query($connection,$query);
    if(mysqli_num_rows($result)==1){
      $url="./successlogin.php";
      if (isset($url)) {
   Header("HTTP/1.1 303 See Other"); 
   Header("Location: $url"); }
 }
      else{
        ?>
        <script>
        window.alert("Invalid UserId or password, please try again");
        location.href="login.php";
        </script>
        <?php

        
      }
   }
?>


<!DOCTYPE html>
<html lang="en">
<head>
<style>

header{
  background-color:black;
    color:white;
  text-align: center;
  padding:5px; 
}
section {
    width:1200px;
    height:550px;
    float:left;
    padding:10px; 
    text-align: center;   
   
}
footer {
    background-color:black;
    color:white;
    clear:both;
    text-align:center;
    padding:5px;     
}
button {
  color: black;
  font-weight: bold;
  font-size: 110%;
}
</style>
</head>
    <body>
      <header>
           <div id="header">
        <h1>Login Page</h1>
     </div>
      </header>
      <section>
        <img src="https://33.media.tumblr.com/51619ef4768ea71aaad4e667a0547e6b/tumblr_nxmkcxVznA1tmc5vso2_500.gif
" alt='login' style="width:1000px;height:400px;"></br>
<h2>
       <form method="post" action="login.php">
        UserID<input type="text" name="UserId"/>  <br/>
        Password <input type="password" name="Password"/> <br/>
        <button type="submit" value="Login">Login</button>
       </form>
     </h2>
     </section>

<footer>
Copyright Epoch TV 2015
</footer>
  </body>

</html>