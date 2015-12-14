<?php require_once("./connection.php"); ?>
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
    float:left;
    margin-left:50px;

    width:350px;
    float:left;
    padding:10px;    
   
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
<h1>Hot TV</h1>
<p>

<?php
    $query = "SELECT TV.TV_Series_ID, TV.Title, TV.Language, TV.Season, TV.Start_Date, 
                TV.Total_Episode, TV.Website, count(*) hot 
              FROM Comment C, TV_Series_Produced TV 
              WHERE C.Searched = 1 and C.TV_Series_ID = TV.TV_Series_ID 
              GROUP BY TV.TV_Series_ID 
              ORDER BY hot DESC";    $tv_set_hot_order = mysqli_query($connection, $query);
    if (!$tv_set_hot_order) {
        printf("Errormessage: %s\n", $connection->error);
        die("Database query failed.");
    }
    $tv_num = 5;
    while ($tv = mysqli_fetch_assoc($tv_set_hot_order) ) {
                if($tv_num > 0){
                    $TV_Series_ID = $tv['TV_Series_ID'];
                    $title = $tv['Title'];
                    $season = $tv['Season'];
                    $language = $tv['Language'];
                    $website = $tv['Website'];
                    $go = "http://".$website;
                    $hot = $tv['hot'];
                    $output  = '<a href="./TV.php?new='.$TV_Series_ID.'">'.$title.' </a></br>';
                    $output .= 'Hot Rate:'.$hot.'</br>';
                    $output .= 'Season:'.$season.'</br>';
                    $output .= 'Language:'.$language.'</br>';
                    $output .= 'Website:'.'<a href="'.$go.'">'.$website.'</a></br></br>'; 
                    print "$output";
                    $tv_num --;
                }
                else{
                    break;
                }
    }
?>
</p>
</section>
<section>
<h1>High Rate TV</h1>
<p>

<?php
    $query = "SELECT TV.TV_Series_ID, TV.Title, TV.Language, TV.Season, TV.Start_Date, 
                TV.Total_Episode, TV.Website, AVG(C.Rate) avgRate 
              FROM Comment C, TV_Series_Produced TV 
              WHERE C.TV_Series_ID = TV.TV_Series_ID 
              GROUP BY TV.TV_Series_ID 
              ORDER BY avgRate DESC";    
              $tv_set_hot_order = mysqli_query($connection, $query);
    if (!$tv_set_hot_order) {
        printf("Errormessage: %s\n", $connection->error);
        die("Database query failed.");
    }
    $tv_num = 5;
    while ($tv = mysqli_fetch_assoc($tv_set_hot_order) ) {
                if($tv_num > 0){
                    $TV_Series_ID = $tv['TV_Series_ID'];
                    $title = $tv['Title'];
                    $season = $tv['Season'];
                    $language = $tv['Language'];
                    $website = $tv['Website'];
                    $go = "http://".$website;
                    $avgRate = round($tv['avgRate'],1);
                    $output  = '<a href="./TV.php?new='.$TV_Series_ID.'">'.$title.' </a></br>';
                    $output .= 'Rate:'.$avgRate.'</br>';
                    $output .= 'Season:'.$season.'</br>';
                    $output .= 'Language:'.$language.'</br>';
                    $output .= 'Website:'.'<a href="'.$go.'">'.$website.'</a></br></br>'; 
                    print "$output";
                    $tv_num --;
                }
                else{
                    break;
                }
    }
?>
</p>
</section>
<footer>
Copyright Epoch TV 2015
</footer>

</body>
</html>