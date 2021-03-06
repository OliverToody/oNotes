<?php
require('connect.php');
require('session.php');
$method = $_SERVER['REQUEST_METHOD'];
$out = array();

if($method == 'POST'){
	$input = json_decode(file_get_contents('php://input'),true);
	$shareUser = "";
	$email = $input['email'];
	$note_id = $input['note_id'];
	$sql = "SELECT * FROM users WHERE email='$email'";
	$query = $conn->query($sql);
	while($row = $query->fetch_array()){
		$shareUser = $row['user_id'];
	}
	$out['inpout'] = $input;

		$sql = "INSERT INTO displayedNotes (`note_id`,`user_id`, `privilege`) VALUES ($note_id,$shareUser,1)";
		if ($conn->query($sql) === TRUE) {
			$out['error'] = 'false';
		} else {
			$out['error'] = $conn->error;
		}
	
		
	}
if($method == 'GET') {
	$note_id = $_GET['note_id'];
	$sql = "SELECT users.email, users.user_id FROM displayedNotes
	LEFT JOIN users ON displayedNotes.user_id = users.user_id
	WHERE displayedNotes.note_id='$note_id' AND  displayedNotes.user_id <> '$user_id'";
	$query = $conn->query($sql);
	$sharedToUsers = array();
	while($row = $query->fetch_array()){
		array_push($sharedToUsers, $row);
	}
	$out['sharedToUsers'] = $sharedToUsers;
}

if($method == 'DELETE'){
	$sharedToUser = $_GET['user_id'];
	$note_id = $_GET['note_id'];
	$sql = "DELETE FROM displayedNotes WHERE user_id='$sharedToUser' AND note_id='$note_id'";
	if ($conn->query($sql) === TRUE) {
		$out['error'] = 'false';
	} else {
		$out['error'] = $conn->error;
	}
	
}

$conn->close();

header("Content-type: application/json");
echo json_encode($out);
die();


?>