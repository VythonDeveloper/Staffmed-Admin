<?php
session_start();
unset($_SESSION['number']);
unset($_SESSION['password']);
session_regenerate_id(true);
header('Location:index.php');
exit();
?>
