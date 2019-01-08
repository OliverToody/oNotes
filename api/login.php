<?php
session_start();

require 'connect.php';



$nickname = htmlentities($_POST["nickname"]);
$password = htmlentities($_POST["password"]);

//$password_hashed = crypt($password1);

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// output data of each row
while($row = $result->fetch_assoc()) {
$id = $row['user_id']; 
$email = $row['email']; 

$nickname1 = $row ['username'];
$password1 = $row ['password'];

if($nickname == $nickname1 and $password == $password1) {

$_SESSION['user_id'] = $id; 
$_SESSION['nickname'] = $nickname;
$_SESSION['email'] = $email;
header('Location: ../index.php');    

}

}

echo "<b>Password is wrong <br>";

header("Refresh:10; url=../main.html"); 
?>


