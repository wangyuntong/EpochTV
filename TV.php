<!---
    Show TV series information
    -->

<?php require_once("./connection.php"); ?>
<?php
    $cookie_name = 'UserId';
    $TV_id = $_GET['new'];
    $url = './TV.php?new=';
    $url .= $TV_id;
    if(!isset($_COOKIE[$cookie_name])) {
    } else {
        $UserId = $_COOKIE[$cookie_name];
    }

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
    height:1500px;
    width:100px;
    float:left;
    padding:5px;
    text-align: center;
}
section {
    width:700px;
    padding:5px;
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
<!-- if the user has a comment with this TV -->
<?php

    $ifRate = 0;
        $query = "SELECT C.Watched, C.Wished, C.Rate 
              FROM Comment C
              WHERE C.TV_Series_ID = \"$TV_id\" and C.User_ID = '$UserId'
              ";
        $comment_set = mysqli_query($connection, $query);
        while ($comment = mysqli_fetch_assoc($comment_set) ) {
            $Watched = $comment['Watched'];
            $Wished = $comment['Wished'];
            $Rate = $comment['Rate'];
            $ifRate = 1;
        }
?>
<!--
    add rate tuple
-->
<?php
    //$url = '';
    if(isset($_POST['rate'])) {
        $new_rate = $_POST['rate'];

        if($ifRate){
        $query = " UPDATE Comment SET Rate = '$new_rate' WHERE TV_Series_ID = '$TV_id' and User_ID = '$UserId'";
        } else {
        $query = " INSERT INTO Comment (TV_Series_ID, User_ID, Rate) 
                    VALUES  ('$TV_id', '$UserId', '$new_rate')";
        }
        $result = mysqli_query($connection, $query);
        if ($result === FALSE){
            die("DB failed!");
        }
}

?>
<!--
already Watched?
-->
<?php
    if(isset($_POST['alreadyWatched'])) {

        if($ifRate){
        $query = " UPDATE Comment SET Watched = 1 WHERE TV_Series_ID = '$TV_id' and User_ID = '$UserId'";
        } else {
        $query = " INSERT INTO Comment (TV_Series_ID, User_ID, Watched) 
                    VALUES  ('$TV_id', '$UserId', 1)";
        }
        $result = mysqli_query($connection, $query);
        if ($result === FALSE){
            die("DB failed!");
        }
}

?>
<!--
wantToWatch?
-->
<?php
    if(isset($_POST['wishList'])) {

        if($ifRate){
        $query = " UPDATE Comment SET Wished = 1 WHERE TV_Series_ID = '$TV_id' and User_ID = '$UserId'";
        } else {
        $query = " INSERT INTO Comment (TV_Series_ID, User_ID, Wished) 
                    VALUES  ('$TV_id', '$UserId', 1)";
        }
        $result = mysqli_query($connection, $query);
        if ($result === FALSE){
            die("DB failed!");
        }
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

<!--select genre info -->
<?php
    $query = "SELECT G.GenreName 
              FROM Genre G 
              WHERE G.TV_Series_ID = \"$TV_id\"
              ";
    $output_genre = 'Genre: ';
    $genre_set = mysqli_query($connection, $query);
    if (!$genre_set) {
        printf("Errormessage: %s\n", $connection->error);
        //die("Database query failed.");
    }
    while ($genre = mysqli_fetch_assoc($genre_set) ) {
                    $GenreName = $genre['GenreName'];
                    $output_genre .= '<a href="./GenreSelect.php?new='.$GenreName.' "> '.$GenreName.'</a> ';
    }
?>
<!--select award info -->
<?php
    $query = "SELECT A.Award_Name, A.Genre, A.Year 
              FROM Award_To A 
              WHERE A.TV_Series_ID = \"$TV_id\"
              ";
    $output_award = '';
    $award_set = mysqli_query($connection, $query);
    if (!$award_set) {
        printf("Errormessage: %s\n", $connection->error);
        //die("Database query failed.");
    }
    if(mysqli_num_rows($award_set) == 0) {
        $output_award .= "No Award Information.";
    }
    else {

        while ($award = mysqli_fetch_assoc($award_set) ) {
                        $Award_Name = $award['Award_Name'];
                        $Genre = $award['Genre'];
                        $Year = $award['Year'];
                        $output_award .= $Year.': ';
                        $output_award .= $Award_Name.', ';
                        $output_award .= $Genre.'</br>';
                            }

    }
?>
<!--select introduction info -->
<?php
    $output_intro = '';
    $query = "SELECT TV.TV_Series_ID, TV.Title, TV.Language, TV.Season, TV.Start_Date, TV.Photo, 
                TV.Total_Episode, TV.Website 
              FROM TV_Series_Produced TV 
              WHERE '$TV_id'= TV.TV_Series_ID 
              ";    
    $tv_set = mysqli_query($connection, $query);
    if (!$tv_set) {
        printf("Errormessage: %s\n", $connection->error);
        //die("Database query failed.");
    }
    while ($tv = mysqli_fetch_assoc($tv_set) ) {
                    $TV_Series_ID = $tv['TV_Series_ID'];
                    $title = $tv['Title'];
                    $season = $tv['Season'];
                    $language = $tv['Language'];
                    $website = $tv['Website'];
                    $go = "http://".$website;
                    $TVphoto = $tv['Photo'];
                    $output_TVphoto =  "<img src='$TVphoto' alt='$title'></br>";
                    $output_intro .= 'Title: <a href="./TV.php?new='.$TV_Series_ID.'">'.$title.' </a></br>';
                    $output_intro .= 'Season: '.$season.'</br>';
                    $output_intro .= 'Language: '.$language.'</br>';
                    $output_intro .= 'Website: '.'<a href="'.$go.'">'.$website.'</a></br>'; 
    }
?>
<!--select actor info -->
<?php
    $output_actor = '';
    $query = "SELECT C.CharacterName, C.ActorName 
              FROM Character_PlayedFeaturing C 
              WHERE '$TV_id'= C.TV_Series_ID 
              ";    
    $actor_set = mysqli_query($connection, $query);
    if (!$actor_set) {
        printf("Errormessage: %s\n", $connection->error);
        //die("Database query failed.");
    }
    if(mysqli_num_rows($actor_set) == 0 ) {
        $output_actor.= "No actor information.";
    }
    else {
        while ($actor = mysqli_fetch_assoc($actor_set) ) {
                        $CharacterName = $actor['CharacterName'];
                        $ActorName = $actor['ActorName'];

                        $output_actor .= '<a href="./actor.php?newactor='.$ActorName.'">'.$ActorName.' </a>';
                        $output_actor .= '...........'.$CharacterName.'</br>';
        }
    }
?>
<!--select comment info -->
<?php
    $ifRate = 0;
    $query = "SELECT C.Watched, C.Wished, C.Rate 
              FROM Comment C
              WHERE C.TV_Series_ID = \"$TV_id\" and C.User_ID = '$UserId'
              ";
    $comment_set = mysqli_query($connection, $query);
    while ($comment = mysqli_fetch_assoc($comment_set) ) {
        $Watched = $comment['Watched'];
        $Wished = $comment['Wished'];
        $Rate = $comment['Rate'];
        if($Rate > 0 ) {
            $ifRate = 1;
        }

    }
?>
<!--select creator info -->
<?php
    $query = "SELECT DISTINCT C.CreatorName
              FROM Creates C
              WHERE '$TV_id'= C.TV_Series_ID
              ";    
    $creator_set = mysqli_query($connection, $query);
    if (!$creator_set) {
        printf("Errormessage: %s\n", $connection->error);
        //die("Database query failed.");
    }
    if(mysqli_num_rows($creator_set) == 0 ) {
        $output_creator = '';

    }
    else {
        $output_creator = 'Creator: ';
        while ($creator = mysqli_fetch_assoc($creator_set) ) {
                        $name = $creator['CreatorName'];

                        $output_creator .= $name.', ';
        }
    }
?>
<section>
<h1>Introduction</h1>
    <p>
        <?php
            echo "$output_TVphoto";
            echo "$output_intro";
            echo "$output_genre</br>";
            echo "$output_creator";

        ?>
    </p>
</section>

<section>
<h1>Award</h1>
    <p>
        <?php
            echo "$output_award";
        ?>
    </p>
</section>

<section>
<h1>Leading Actor</h1>
    <p>
        <?php
            echo "$output_actor";
        ?>
    </p>
</section>

<section>
<h1>Rate</h1>
<p>
    <body>
        <form action="<?php echo $url?>" method="post">
            <?php
                if($ifRate == 1 ){
                    echo "You have rated this TV : ".$Rate." stars.</br>";
            ?>
            Re-rate this TV: <input type="text" name="rate">(1-10)<br>
            <?php
                }
                else{
            ?>
                Rate this TV: <input type="text" name="rate">(1-10)<br>
            <?php
                }
            ?>
            <input type="submit" value="Rate It Now!" >
        </form>
    </body>
</p>
</section>
<section>
<h1>Comment</h1>
<p>
    <body>
        <form action="<?php echo $url?>" method="post">
            <?php
                if(!isset($Watched) || $Watched == 0 ){
             ?>
                <input type="submit" name = "alreadyWatched" value="I've watched this TV!" >
            <?php                   
                }
                else{
                echo "You've watched this TV.</br>";
                }
            ?>
        </form>
        <form action="<?php echo $url?>" method="post">
            <?php
                if(!isset($Wished) || $Wished == 0 ){
             ?>
                <input type="submit" name = "wishList" value="Add to my Wish List!" >
            <?php                   
                }
                else{
                echo "You wanted to watch this TV.</br>";
                }
            ?>
        </form>
    </body>
</p>
</section>

<footer>
Copyright Epoch TV 2015
</footer>

</body>
</html>