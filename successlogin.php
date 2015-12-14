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

section{margin-left:200px;

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
<h1>Epoch TV</h1>
</header>


<nav>
<a href="./search.php" >Search</a></br>
<a href="./recommend.php" >Recommand</a></br>
<a href="./genre.php" >Genre</a></br>
<a href="./hot_TV.php" >Hot TV</a></br>
<a href="./successlogin.php" >User Info</a></br>
<a href="./welcome.html" >Log Out</a>
</nav>


<section>
<h1
style="font-size:200%">User-Information
</h1>
<p>
	<?php
	require 'connection.php';
	$UserId=$_COOKIE['UserId'];
	 $query="SELECT * FROM  User WHERE  User_ID='$UserId'";
    $result=mysqli_query($connection,$query);
    while($User=mysqli_fetch_assoc($result)){
    	echo "UserID: ".$User['User_ID']."<br>";
    	echo "UserName: ".$User['Username']."<br>";
    	echo "Birthday: ".$User['DOB']."<br>";
    	echo "Password: ****** <br>";
    	echo "Sex: ".$User['Sex']."<br>";
    	
    }
	?>
	<form method="post" action="UserUpdate.php">
        <input type="submit" name="Update" value="Update" />
       </form>

</p>

<p>
<?php
$queryWatched="SELECT T.Title ,T.TV_Series_ID
FROM TV_Series_Produced T, Comment C 
WHERE T.TV_Series_ID=C.TV_Series_ID AND C.User_ID='$UserId'
AND   C.Watched=1 ";

$watched=mysqli_query($connection,$queryWatched);
if(!$watched)
    {echo $connection->error;}
else if(mysqli_num_rows($watched)>0)
{   echo "<h2>Watched:"."<br/></h2>";
    while($Title1=mysqli_fetch_assoc($watched)){
         echo '<a href="./TV.php?new='.$Title1['TV_Series_ID'].'">'.$Title1['Title'].' </a></br>';
     }
 }
 else {echo "<h2>Watched: No record"."<br/></h2>";}
    
 $queryWished="SELECT T.Title,T.TV_Series_ID 
FROM TV_Series_Produced T, Comment C 
WHERE T.TV_Series_ID=C.TV_Series_ID AND C.User_ID='$UserId'
AND   C.Wished=1 ";

$wished=mysqli_query($connection,$queryWished);
if(!$wished)
    {echo $connection->error;}
else if(mysqli_num_rows($wished)>0)
{   echo "<h2>Wish List:"."</br></h2>";
    while($Title2=mysqli_fetch_assoc($wished)){
         echo '<a href="./TV.php?new='.$Title2['TV_Series_ID'].'">'.$Title2['Title'].' </a></br>';
     }
 }
 else {echo "<h2>Wish List: No record"."<br/></h2>";}


 $querySearched="SELECT T.Title,T.TV_Series_ID
FROM TV_Series_Produced T, Comment C 
WHERE T.TV_Series_ID=C.TV_Series_ID AND C.User_ID='$UserId'
AND   C.Searched=1 ";

$searched=mysqli_query($connection,$querySearched);
if(!$searched)
    {echo $connection->error;}
else if(mysqli_num_rows($searched)>0)
{   echo "<h2>Search History:"."<br/></h2>";
    while($Title3=mysqli_fetch_assoc($searched)){
       
        echo '<a href="./TV.php?new='.$Title3['TV_Series_ID'].'">'.$Title3['Title'].' </a></br>';
     }
 }
 else {echo "<h2>Search History: No record"."<br/></h2>";}
?>
</p>    
</section>


<footer>
Copyright Epoch TV 2015
</footer>

</body>
</html>

