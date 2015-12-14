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
    width:450px;
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
<h1>Recommand</h1>
</header>

<nav>
<a href="./search.php" >Search</a></br>
<a href="./recommend.php" >Recommand</a></br>
<a href="./genre.php" >Genre</a></br>
<a href="./hot_TV.php" >Hot TV</a></br>
<a href="./successlogin.php" >User Info</a></br>
<a href="./welcome.html" >Log Out</a>
</nav>

<?php require_once("./connection.php"); ?>
<?php
    $cookie_name = 'UserId';
    $UserID = $_COOKIE[$cookie_name];

    $query = "SELECT DOB, Sex FROM User WHERE User_ID = '$UserID'";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        printf("Errormessage: %s\n", $connection->error);
        die("Database query failed.");
    }
    else {
        $user = mysqli_fetch_assoc($result);
        $sex = $user['Sex'];
        $DOB = $user['DOB'];
    }
    if($sex === 'F'){
        $sexString = 'female';
    }
    else {
        $sexString = 'male';
    }
?>

<?php
    $output = '';
    $query = " SELECT TV.TV_Series_ID, TV.Title, TV.Language, TV.Season, TV.Start_Date, 
                TV.Total_Episode, TV.Website, count(C.Wished) num
                FROM TV_Series_Produced TV, User U, Comment C 
                Where U.Sex = '$sex' and C.Wished = 1 and U.User_ID = C.User_ID 
                        and TV.TV_Series_ID = C.TV_Series_ID
                GROUP BY TV.TV_Series_ID
                ORDER BY num DESC";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        printf("Errormessage: %s\n", $connection->error);
        die("Database query failed.");
    }
    $tv_num = 1;
    while ($tv = mysqli_fetch_assoc($result) ) {
                if($tv_num > 0){
                    $TV_Series_ID = $tv['TV_Series_ID'];
                    $title = $tv['Title'];
                    $season = $tv['Season'];
                    $language = $tv['Language'];
                    $website = $tv['Website'];
                    $go = "http://".$website;
                    $wishNum = $tv['num'];
                    $output  = '<a href="./TV.php?new='.$TV_Series_ID.'">'.$title.' </a></br>';
                    $output .= $wishNum.' '.$sexString.' wanted to watch this TV</br>';
                    $output .= 'Season:'.$season.'</br>';
                    $output .= 'Language:'.$language.'</br>';
                    $output .= 'Website:'.'<a href="'.$go.'">'.$website.'</a></br></br>'; 
                    $tv_num --;
                }
                else{
                    break;
                }
    }
?>

<?php
    $output2 = '';
   // $query = "SELECT User_ID, DATEDIFF(year, '$DOB', DOB) FROM User WHERE User_ID != '$UserID'";
    $result = mysqli_query($connection, $query);
    $query = " SELECT TV.TV_Series_ID, TV.Title, TV.Language, TV.Season, TV.Start_Date, 
                TV.Total_Episode, TV.Website, count(C.Wished) num
                FROM TV_Series_Produced TV, User U, Comment C, 
                (SELECT User_ID FROM User WHERE User_ID != '$UserID'
                    and DATEDIFF('$DOB', DOB) < 10*365 ) validUser
                Where C.Wished = 1 
                        and U.User_ID = C.User_ID 
                        and TV.TV_Series_ID = C.TV_Series_ID 
                        and validUser.User_ID = U.User_ID
                GROUP BY TV.TV_Series_ID
                ORDER BY num DESC";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        printf("Errormessage: %s\n", $connection->error);
        die("Database query failed.");
    }
    $tv_num = 1;
    while ($tv = mysqli_fetch_assoc($result) ) {
                if($tv_num > 0){
                    $TV_Series_ID = $tv['TV_Series_ID'];
                    $title = $tv['Title'];
                    $season = $tv['Season'];
                    $language = $tv['Language'];
                    $website = $tv['Website'];
                    $go = "http://".$website;
                    $wishNum = $tv['num'];
                    $output2  = '<a href="./TV.php?new='.$TV_Series_ID.'">'.$title.' </a></br>';
                    $output2 .= $wishNum.' users like your age wanted to watch this TV</br>';
                    $output2 .= 'Season:'.$season.'</br>';
                    $output2 .= 'Language:'.$language.'</br>';
                    $output2 .= 'Website:'.'<a href="'.$go.'">'.$website.'</a></br></br>'; 
                    $tv_num --;
                }
                else{
                    break;
                }
    }
?>
<?php
    $output3 = '';

    $query = " SELECT TV.TV_Series_ID, TV.Title, TV.Language, TV.Season, TV.Start_Date, 
                TV.Total_Episode, TV.Website, AVG(C.Rate) rate
                FROM TV_Series_Produced TV, User U, Comment C, 
                (SELECT User_ID FROM User WHERE User_ID != '$UserID'
                    and DATEDIFF('$DOB', DOB) < 10*365 and Sex = '$sex') validUser
                Where C.Rate != 'null'
                        and U.User_ID = C.User_ID 
                        and TV.TV_Series_ID = C.TV_Series_ID 
                        and validUser.User_ID = U.User_ID
                GROUP BY TV.TV_Series_ID
                ORDER BY rate DESC";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        printf("Errormessage: %s\n", $connection->error);
        die("Database query failed.");
    }
    $tv_num = 1;
    while ($tv = mysqli_fetch_assoc($result) ) {
                if($tv_num > 0){
                    $TV_Series_ID = $tv['TV_Series_ID'];
                    $title = $tv['Title'];
                    $season = $tv['Season'];
                    $language = $tv['Language'];
                    $website = $tv['Website'];
                    $go = "http://".$website;
                    $rate = round($tv['rate'],1);
                    $output3  = '<a href="./TV.php?new='.$TV_Series_ID.'">'.$title.' </a></br>';
                    $output3 .= 'Similar users rate this TV '.$rate.' stars. </br>';
                    $output3 .= 'Season:'.$season.'</br>';
                    $output3 .= 'Language:'.$language.'</br>';
                    $output3 .= 'Website:'.'<a href="'.$go.'">'.$website.'</a></br></br>'; 
                    $tv_num --;
                }
                else{
                    break;
                }
    }
?>
<?php
    $output4 = '';

    $query = " SELECT TV.TV_Series_ID, TV.Title, TV.Language, TV.Season, TV.Start_Date, 
                TV.Total_Episode, TV.Website, G.GenreName
                FROM TV_Series_Produced TV, User U, Comment C, 
                (SELECT G.GenreName 
                    FROM Genre G, Comment C 
                    WHERE C.TV_Series_ID = G.TV_Series_ID and C.User_ID = '$UserID'
                            and C.Rate > any (SELECT C1.Rate
                                            FROM Comment C1
                                            WHERE C1.User_ID = '$UserID')
                    )validGenre, Genre G
                Where U.User_ID = C.User_ID 
                    and TV.TV_Series_ID = C.TV_Series_ID 
                    and TV.TV_Series_ID = G.TV_Series_ID
                    and validGenre.GenreName = G.GenreName";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        printf("Errormessage: %s\n", $connection->error);
        die("Database query failed.");
    }
    $tv_num = 1;
    while ($tv = mysqli_fetch_assoc($result) ) {
                if($tv_num > 0){
                    $TV_Series_ID = $tv['TV_Series_ID'];
                    $title = $tv['Title'];
                    $season = $tv['Season'];
                    $language = $tv['Language'];
                    $website = $tv['Website'];
                    $go = "http://".$website;
                    $GenreName = $tv['GenreName'];
                    $output4  = '<a href="./TV.php?new='.$TV_Series_ID.'">'.$title.' </a></br>';
                    $output4 .= 'Genre: <a href="./GenreSelect.php?new='.$GenreName.' "> '.$GenreName.'</a> </br>';                    $output4 .= 'Season:'.$season.'</br>';
                    $output4 .= 'Language:'.$language.'</br>';
                    $output4 .= 'Website:'.'<a href="'.$go.'">'.$website.'</a></br></br>'; 
                    $tv_num --;
                }
                else{
                    break;
                }
    }
?>
<section>
<h1>Gender Recommand</h1>
    <p>

        <?php
            echo "$output";
        ?>
    </p>
</section>
<section>
<h1>Age Recommand</h1>
    <p>
        <?php
            echo "$output2";
        ?>
    </p>
</section>
<section>
<h1>Common User Rate Recommand</h1>
    <p>
        <?php
            echo "$output3";
        ?>
    </p>
</section>
<section>
<h1>Genre Recommand</h1>
    <p>
        <?php
            echo "$output4";
        ?>
    </p>
</section>
</body>
</html>

<footer>
Copyright Epoch TV 2015
</footer>

</body>
</html>