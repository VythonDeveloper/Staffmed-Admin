<?php
//error_reporting(0);
include "./function.inc.php";
session_start();
session_regenerate_id();

if(isset($_SESSION['adminUsername']) && $_SESSION['adminUsername']!='' && isset($_SESSION['adminPassword']) && $_SESSION['adminPassword']!=''){
  $username = getSafeValue($_SESSION['adminUsername']);
  $md_password = getSafeValue($_SESSION['adminPassword']);

  $res = mysqli_query($conn, "Select * from admin where username = '$username' and password = '$md_password'");
  if(mysqli_num_rows($res) > 0){
    while($row = mysqli_fetch_assoc($res)){
      $_SESSION['adminUsername'] = $username;
      $_SESSION['adminPassword'] = $md_password;
      $_SESSION['adminId'] = $row['id'];
      $_SESSION['adminFullname'] = $row['fullname'];
      $_SESSION['adminPhone'] = $row['phone'];
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