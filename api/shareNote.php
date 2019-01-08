<?php
require('connect.php');
require('session.php');
$method = $_SERVER['REQUEST_METHOD'];
$out = array();

if($method == 'POST'){
	$input = json_decode(file_get_contents('php://input'),true);

	$username = $input['shared_to_user'];
	$sql = "SELECT * FROM users WHERE username='$username'";
	$query = $conn->query($sql);
	while($row = $query->fetch_array()){
		$input['shared_to_user'] = $row['user_id'];
	}
		// escape the columns and values from the input object
	$columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input));
	$values = array_map(function ($value) use ($conn) {
	  if ($value===null) return null;
	  return mysqli_real_escape_string($conn,(string)$value);
	},array_values($input));

	
	// build the SET part of the SQL command
	$set = '';
	for ($i=0;$i<count($columns);$i++) {
	  $set.=($i>0?',':'').'`'.$columns[$i].'`=';
	  $set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
	}
	
		$sql = "insert into shared_notes set $set";
		if ($conn->query($sql) === TRUE) {
			$out['error'] = 'false';
		} else {
			$out['error'] = $conn->error;
		}
		
	}
if($method == 'GET') {
	$user_id = $_SESSION['user_id'];
	$input = json_decode(file_get_contents('php://input'),true);
	$also_shared_to = array();
	$note_id= $_REQUEST['note_id'];
	$sql = "SELECT * FROM shared_notes LEFT JOIN users ON users.user_id = shared_notes.shared_to_user WHERE note_id='$note_id'";
	$query = $conn->query($sql);
	while($row = $query->fetch_array()){
		array_push($also_shared_to, $row);
	}
}
$out['shared_to'] = $also_shared_to;

$conn->close();

header("Content-type: application/json");
echo json_encode($out);
die();


?>