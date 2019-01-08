
<?php
session_start();// Starting Session

// Establishing Connection with Server by passing server_name, user_id and password as a parameter
require('connect.php');
// Selecting Database

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
mysqli_close($conn); // Closing Connection
header('Location: main.html'); // Redirecting To Home Page
}
?>