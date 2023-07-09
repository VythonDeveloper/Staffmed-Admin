<?php
//error_reporting(0);
include "./function.inc.php";
session_start();
session_regenerate_id();

if(isset($_SESSION['number']) && $_SESSION['number']!='' && isset($_SESSION['password']) && $_SESSION['password']!=''){
  $number = getSafeValue($_SESSION['number']);
  $md_password = getSafeValue($_SESSION['password']);

  $res = mysqli_query($conn, "Select res.*, ct.city from restaurants as res, cities as ct where ct.id = res.cityId and res.number = '$number' and res.password = '$md_password'");
  if(mysqli_num_rows($res) > 0){
    while($row = mysqli_fetch_assoc($res)){
      $_SESSION['number'] = $row['number'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['password'] = $row['password'];
      $_SESSION['name'] = $row['name'];
      $_SESSION['executiveName'] = $row['executiveName'];
      $_SESSION['city'] = $row['city'];
      $_SESSION['address'] = $row['address'];
      $_SESSION['coverImage'] = $row['coverImage'];
      $_SESSION['id'] = $row['id'];
    }
  }
  else{
    header("Location:index.php");
  }
}
else{
  header("Location:index.php");
}
?>