<?php require_once("./connection.php"); ?>
<?php
    $cookie_name = 'UserId';
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
    height:600px;
    width:100px;
    float:left;
    padding:5px;
    text-align: center;
    overflow: auto;
    overflow-x: hidden;
    overflow-y: hidden;
}
section {
    width:800px;
    float:left;
    padding:10px;    
    margin-left: 50px;
   
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
<?php
    $output = '';
    //collect
    if(isset($_POST['search'])) {
        $searchq = $_POST['search'];
        $searchq = preg_replace("#[^0-9a-z ]#i", "", $searchq);
        
        $query_actor = " SELECT TV.Title, C.ActorName, TV.TV_Series_ID, A.Photo
        FROM TV_Series_Produced TV, Character_PlayedFeaturing C , Actor A 
        WHERE C.ActorName LIKE '%$searchq%' and TV.TV_Series_ID = C.TV_Series_ID
        and A.ActorName = C.ActorName
        ";
        $searchr_actor= mysqli_query($connection, $query_actor);
        echo $connection->error;
        $query = " SELECT * FROM TV_Series_Produced WHERE Title LIKE '%$searchq%'";
        $searchr= mysqli_query($connection, $query);

        $output = "<h1>TV Result</h1></br>";
        if (mysqli_num_rows($searchr) == 0 ) {
            $output .= "No search results";
        } else {
            while($tv = mysqli_fetch_assoc($searchr)) {
                    $TV_Series_ID = $tv['TV_Series_ID'];
                    $title = $tv['Title'];
                    $season = $tv['Season'];
                    $language = $tv['Language'];
                    $website = $tv['Website'];
                    $go = "http://".$website;
                    $TVphoto = $tv['Photo'];
                    $output .=  "<img src='$TVphoto' alt='$title'></br>";
                    $output .= '<a href="./TV.php?new='.$TV_Series_ID.'">'.$title.' </a></br>';
                    $output .= 'Season:'.$season.'</br>';
                    $output .= 'Language:'.$language.'</br>';
                    $output .= 'Website:'.'<a href="'.$go.'">'.$website.'</a></br></br>';
              
              $query = "SELECT C.TV_Series_ID, C.User_ID, C.Searched
              FROM Comment C
              WHERE C.TV_Series_ID = '$TV_Series_ID' and  C.User_ID = '$UserId'";
              $ifComment= mysqli_query($connection, $query);  
              if (mysqli_num_rows($ifComment) == 0 ) {
                  $query = " INSERT INTO Comment (TV_Series_ID, User_ID, Searched) 
                    VALUES  ('$TV_Series_ID', '$UserId', 1)";
              } else{
                $com= mysqli_fetch_assoc($ifComment);
                if ($com['Searched'] != 1 ){
                  $query = " UPDATE Comment SET Searched = 1 WHERE TV_Series_ID = '$TV_Series_ID' and User_ID = '$UserId'";
                }
              }
              $ifSearched= mysqli_query($connection, $query);
              if(!$ifSearched) {
                echo "Update search fail</br>";
              }
            }
        }


        $output .= "</br><h1>Actor Result</h1></br>";
        if (mysqli_num_rows($searchr_actor) == 0) {
            $output .= "No search results";
        } else {
            while($actor = mysqli_fetch_assoc($searchr_actor)) {
                    $name = $actor['ActorName'];
                    $title = $actor['Title'];
                    $TV_Series_ID = $actor['TV_Series_ID'];
                    $Actor_photo = $actor['Photo'];
                    $output .=  "<img src='$Actor_photo' alt='$name'></br>";
                    $output .= '<a href="./actor.php?newactor='.$name.'">'.$name.' </a></br>';
                    $output .= 'Featuring in: <a href="./TV.php?new='.$TV_Series_ID.'">'.$title.' </a></br></br>';
            }            
        }

    } 

      if(isset($_POST['rate'])){
        $output = '';
      $rate=$_POST['rate'];
      $language=$_POST['language'];
      $genre=$_POST['genre'];
      if($rate == ""){
        $rate = 0;
      }
      $query="SELECT *FROM 
      (SELECT C.TV_Series_ID
      FROM Comment C ,TV_Series_Produced T,Genre G 
      WHERE C.TV_Series_ID=T.TV_Series_ID AND T.Language='$language' 
      AND G.TV_Series_ID=C.TV_Series_ID AND G.GenreName='$genre'
      Group By C.TV_Series_ID
      Having AVG(C.Rate)>$rate) TV,TV_Series_Produced T
      WHERE TV.TV_Series_ID=T.TV_Series_ID
      ";


      $result=mysqli_query($connection,$query);
      if (mysqli_num_rows($result) == 0) {
            $output .= "No search results";
        } else {
            while($advanced= mysqli_fetch_assoc($result)) {
                    $TV_Series_ID = $advanced['TV_Series_ID'];
                    $title=$advanced['Title'];
                    $season=$advanced['Season'];
                    $language=$advanced['Language'];
                    $website=$advanced['Website'];
                    $go="http://".$website;
                    $TVphoto = $advanced['Photo'];
                    $output .=  "<img src='$TVphoto' alt='$title'></br>";
                 $output.= '<a href="./TV.php?new='.$TV_Series_ID.'">'.$title.' </a></br>';
                  $output.='Season:'.$season.'</br>';
                   $output.= 'Language:'.$language.'</br>';
                   $output.='Website:'. '<a href="'.$go.'">'.$website.'</a></br></br>';

              $query = "SELECT C.TV_Series_ID, C.User_ID, C.Searched
              FROM Comment C
              WHERE C.TV_Series_ID = '$TV_Series_ID' and  C.User_ID = '$UserId'";
              $ifComment= mysqli_query($connection, $query);  
              if (mysqli_num_rows($ifComment) == 0 ) {
                  $query = " INSERT INTO Comment (TV_Series_ID, User_ID, Searched) 
                    VALUES  ('$TV_Series_ID', '$UserId', 1)";
              } else{
                $com= mysqli_fetch_assoc($ifComment);
                if ($com['Searched'] != 1 ){
                  $query = " UPDATE Comment SET Searched = 1 WHERE TV_Series_ID = '$TV_Series_ID' and User_ID = '$UserId'";
                }
              }
              $ifSearched= mysqli_query($connection, $query);
              if(!$ifSearched) {
                echo "Update search fail</br>";
              }
            }       
        }//end if
      }//end if 
    
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
<h1>Search</h1>
<p>
    <body>
            <form action="search.php" method="post">
                <input type="text" name="search" placeholder="TV series and actors..." />
                <input type="submit" value=">>" />
            </form>





<h1>Advanced Search</h1>
<form action="search.php" method="post">
       Genre: <select name="genre">
         <?php
        require 'connection.php';
        $query1="SELECT DISTINCT GenreName FROM Genre";
       $result1=mysqli_query($connection,$query1);
       while($genre=mysqli_fetch_assoc($result1)){
       ?>
       <option value="<?php echo $genre['GenreName'];?>"> <?php echo $genre['GenreName'];?></option>
       <?php
   }
          ?>
      </select>

      Language: <select name="language">
         <?php
        $query2="SELECT DISTINCT Language FROM TV_Series_Produced";
       $result2=mysqli_query($connection,$query2);
       while($language=mysqli_fetch_assoc($result2)){
       ?>
       <option value="<?php echo $language['Language'];?>"> <?php echo $language['Language'];?></option>
       <?php
   }
          ?>
      </select>

    Rate:<input type="text" name="rate" placeholder="rate >0-9"/>
  <input type="submit" value=">>"/>
        </form>
        <?php echo "</br>$output"; ?>

</p>
</section>

<footer>
Copyright Epoch TV 2015
</footer>

</body>
</html>