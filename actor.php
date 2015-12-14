<!---
    Show Actor information
    -->

<?php require_once("./connection.php"); ?>
<?php
    $ActorName = $_GET['newactor'];
?>
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
section {
    width:700px;
    padding:10px;
    float:left;
    margin-left:50px;
   
   
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
<!--select introduction info -->
<?php
    $output_intro = '';
    $query = "SELECT A.ActorName, A.DOB, A.Sex, A.Nationality, A.Photo, A.Description 
                FROM Actor A 
                WHERE A.ActorName = '$ActorName'
              ";    
    $actor_set = mysqli_query($connection, $query);
    if (!$actor_set) {
        printf("Errormessage: %s\n", $connection->error);
        //die("Database query failed.");
    }
    while ($actor = mysqli_fetch_assoc($actor_set) ) {
        $DOB = $actor['DOB'];
        $Sex = $actor['Sex'];
        $Nationality = $actor['Nationality'];
        $Photo = $actor['Photo'];
        $Description = $actor['Description'];

        $output_intro .=  "<img src='$Photo' alt='$ActorName'></br>";
        $output_intro .= 'Name: '.$ActorName.'</br>';
        $output_intro .= 'DOB: '.$DOB.'</br>';
        $output_intro .= 'Sex: '.$Sex.'</br>';
        $output_intro .= 'Nationality: '.$Nationality.'</br>';

    }
?>
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
<h1>Actor Information</h1>
<p>
<?php
echo "$output_intro";
?>
<h2>Description</h2>
<?php
echo "$Description";
?>
</p>
</section>

<footer>
Copyright Epoch TV 2015
</footer>

</body>
</html>