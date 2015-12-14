<!DOCTYPE html>
<html>
<head>
<style>
header {

    background-color:black;
    color:white;
    text-align:center;
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

footer {
    background-color:black;
    color:white;
    clear:both;
    text-align:center;
    padding:5px;     
}
</style>

<body>
<header>
<h1><?php echo $_GET['new']; ?> </h1> 
</header>
<nav>
<a href="./search.php" >Search</a></br>
<a href="./recommend.php" >Recommand</a></br>
<a href="./genre.php" >Genre</a></br>
<a href="./hot_TV.php" >Hot TV</a></br>
<a href="./successlogin.php" >User Info</a></br>
<a href="./welcome.html" >Log Out</a>
</nav>
<center>
<?php 
 require 'connection.php';
 $genreGet= $_GET['new'];
 $query="SELECT * FROM Genre G,TV_Series_Produced T WHERE 
 G.GenreName='$genreGet' AND G.TV_Series_ID=T.TV_Series_ID";
 $result=mysqli_query($connection,$query);
 while ($info=mysqli_fetch_assoc($result)) {
    echo "Title:".'<a href="./TV.php?new='.$info['TV_Series_ID'].'">'.$info['Title'].' </a></br>';
    echo "Season:".$info['Season']."<br>";
 	echo "Start_Date:".$info['Start_Date']."<br>";
 	echo "Language:".$info['Language']."<br>";
 	echo "Total_Episode:".$info['Total_Episode']."<br>";
 	echo "Website:".'<a href="http://'.$info['Website'].'">'.$info['Website'].' </a></br>';
 	echo  "<hr>";}

?>
</center>
</body>

<footer>
Copyright Epoch TV 2015
</footer>
</html>