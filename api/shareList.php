<?php
require('connect.php');
require('session.php');
$method = $_SERVER['REQUEST_METHOD'];
$out = array();

if($method == 'POST'){
	$input = json_decode(file_get_contents('php://input'),true);
	$shareUser = "";
	$email = $input['email'];
	$list_id = $input['list_id'];
	$sql = "SELECT * FROM users WHERE email='$email'";
	$query = $conn->query($sql);
	while($row = $query->fetch_array()){
		$shareUser = $row['user_id'];
	}
	$out['inpout'] = $input;

		$sql = "INSERT INTO displayedList (`list_id`,`user_id`, `privilege`) VALUES ($list_id,$shareUser,1)";
		if ($conn->query($sql) === TRUE) {
			$out['error'] = 'false';
		} else {
			$out['error'] = $conn->error;
		}
	
	}


if($method == 'GET') {
	$list_id = $_GET['list_id'];
	$sql = "SELECT users.email, users.user_id FROM displayedList 
	LEFT JOIN users ON displayedList.user_id = users.user_id
	WHERE displayedList.list_id='$list_id' AND  displayedList.user_id <> '$user_id'";
	$query = $conn->query($sql);
	$sharedToUsers = array();
	while($row = $query->fetch_array()){
		array_push($sharedToUsers, $row);
	}
	$out['sharedToUsers'] = $sharedToUsers;
}

if($method == 'DELETE'){
	$sharedToUser = $_GET['user_id'];
	$list_id = $_GET['list_id'];
	$sql = "DELETE FROM displayedList WHERE user_id='$sharedToUser' AND list_id='$list_id'";
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