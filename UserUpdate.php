<!DOCTYPE HTML> 
<html>
<head>
</head>
<body> 

<?php 
require 'connection.php';
$UserId=$_COOKIE['UserId'];
if(isset($_POST['name']))
{
$Name=$_POST['name'];
$year=$_POST['year'];
$month=$_POST['month'];
$day=$_POST['day'];
$password=$_POST['Password'];
$passconf=$_POST['Passconf'];
$Gender=$_POST['gender'];
if(!$Name||!$password||!$passconf||!$Gender){
?>
  <script>
   window.alert('You have not complete the form!');
   location.href='UserUpdate.php';
   </script>

   <?php
}else if(strlen($password)!=6||strlen($passconf)!=6){
   ?>
   <script>
   window.alert('The password must have 6 chars!');
   location.href='UserUpdate.php';
   </script>
   <?php
   }

   
  else if($password!=$passconf)
      {
      ?>
<script>
      window.alert('The password do not match!');
   location.href='UserUpdate.php';
      </script>
      <?php
   }

else{ 
$Birth=$year.'-'.$month.'-'.$day;
$query1="UPDATE User SET Username='$Name',Password='$password',DOB='$Birth',Sex='$Gender' WHERE User_ID='$UserId'";
$query2="SELECT * FROM User WHERE User_ID='$UserId'";

$result1=mysqli_query($connection,$query1);
$result2=mysqli_query($connection,$query2);


while($User=mysqli_fetch_assoc($result2)){
      echo "UserID: ".$User['User_ID']."<br>";
      echo "UserName: ".$User['Username']."<br>";
      echo "Birthday: ".$User['DOB']."<br>";
      echo "Password: ****** <br>";
      echo "Sex: ".$User['Sex']."<br>";

}
Header("HTTP/1.1 303 See Other"); 
$url="./successlogin.php";
Header("Location: $url");
 }

}
?>
<h2>Please Update Your Information,User <?php echo $UserId ?> </h2>


<form method="post" action="UserUpdate.php"> 
   Name: <input type="text" name="name">
   <br><br>
 DOB:<select name="year" id="year" >
<script>
for(i=1900;i<2016;i++){
document.write("<option value='"+i+"'>"+i+"</option>")
}
</script>
</select>
<select name="month" id="month" >
<script>
for(i=1;i<=12;i++){
document.write("<option value='"+i+"'>"+i+"</option>")
}
</script>
</select>
<select name="day" id="day" >
<script>
for(i=1;i<=31;i++){
document.write("<option value='"+i+"'>"+i+"</option>")
}
</script>
</select>

   <br><br>
      Password:<input type="password" name="Password">
   <br><br>
      Re-enter:<input type="password" name="Passconf">
   <br><br>
      Gender:
   <input type="radio" name="gender" value="F">Female
   <input type="radio" name="gender" value="M">Male
   <br><br>
   <input type="submit"  value="Update"> 
</form>

</body>
</html>