<?php 
include 'includes/db.php';
$login = $_POST['login'];
mysqli_query($conn, "DELETE FROM users WHERE `login` = '$login'");
header("Location: index.php");
mysqli_close($conn);
?>