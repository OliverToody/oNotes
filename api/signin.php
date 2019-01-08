<?php
session_start();// Starting Session

require('connect.php');
require_once '../lib/google-api-php-client-2.2.2/vendor/autoload.php';
$clientid = "161857244723-521c5i25359db4t6p6igfj6vjgd48c5o.apps.googleusercontent.com";
	
//Id Token to verify the user
$id_token = isset($_POST['idtoken']) ? $_POST['idtoken'] : '';
$google_username = isset($_POST['google_username']) ? $_POST['google_username'] : '';
$google_email = isset($_POST['google_email']) ? $_POST['google_email'] : '';

//retrieving google user id 
$client = new Google_Client(['client_id' => $clientid ]);  // Specify the CLIENT_ID of the app that accesses the backend
$payload = $client->verifyIdToken($id_token);
if ($payload) {
  $userid = $payload['sub'];
//$_SESSION['user_id'] = $userid;

$sql = "SELECT * FROM users WHERE google_user_id='$userid'";
$result = $conn->query($sql);

if(! mysqli_num_rows($result) == 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    $id = $row['user_id']; 
    $email = $row['email']; 
    $nickname1 = $row ['username'];

    $_SESSION['user_id'] = $id; 
    $_SESSION['nickname'] = $nickname1;
    $_SESSION['email'] = $email;

    $out['redirect'] = 'yes';
    }

} else {
    $sql = "INSERT INTO users (google_user_id, username, email, regdate) VALUES($userid, '$google_username','$google_email', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "New user created successfully. Please click on the confirmation link we sent you to your email to complete the registration.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $out['redirect'] = 'not';
    
}
}
  else {
  // Invalid ID token
}


echo json_encode($out);
die();
?>