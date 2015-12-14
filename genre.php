
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
nav {
    line-height:30px;
    background-color:#eeeeee;
    height:600px;
    width:100px;
    float:left;
    padding:5px;
    text-align: center;
}
body {
    width:1200px; 
    height:600px;
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

</style>
</head>
   	<body>
   		 <header>
           <h1>Genre Page</h1>
        </header>
<nav>
<a href="./search.php" >Search</a></br>
<a href="./recommend.php" >Recommand</a></br>
<a href="./genre.php" >Genre</a></br>
<a href="./hot_TV.php" >Hot TV</a></br>
<a href="./successlogin.php" >User Info</a></br>
<a href="./welcome.html" >Log Out</a>
</nav>
 <?php
require 'connection.php';
$query="SELECT DISTINCT GenreName FROM Genre";
$result=mysqli_query($connection,$query);
while($genre=mysqli_fetch_assoc($result)){
 $url="./GenreSelect.php";

 $genre=$genre["GenreName"];
 echo '<a href="'.$url.'?new='.$genre.' "> '.$genre.'</a>';
 echo "<hr/>";}
?>


<footer>
Copyright Epoch TV 2015
</footer>
	</body>
</html>