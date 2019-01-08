<?php
require('connect.php');


$nickname = htmlentities($_POST["nickname"]);
$password = htmlentities($_POST["password"]);
$email = htmlentities($_POST["email"]);


//$password_hashed = crypt($password, PASSWORD_DEFAULT);
$zhoduje = False;

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// output data of each row
    while($row = $result->fetch_assoc()) {

     $nickname1 = $row ['username'];

       if($nickname1 ==  $nickname) {

            $zhoduje = True;
           }

}

if(! $zhoduje) {
$sql = "INSERT INTO users (username, password, email, regdate) VALUES('$nickname', '$password','$email', NOW())";

if ($conn->query($sql) === TRUE) {
    echo "New user created successfully. Please click on the confirmation link we sent you to your email to complete the registration.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
           header("Refresh:2; url=main.html"); 

}
else {

echo "The name is already taken.";
header("Refresh:1; url=main.html"); 
}




?>