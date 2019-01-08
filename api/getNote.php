<?php
require('connect.php');
require('session.php');
$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET'){
    $note_id = $_REQUEST['note_id'];
	$sql = "SELECT * FROM notes WHERE user_id='$user_id' AND note_id='$note_id'";
	$query = $conn->query($sql);
	$note = array();

	while($row = $query->fetch_array()){
		array_push($note, $row);
	}
	$out['note'] = $note;
}

$conn->close();

header("Content-type: application/json");
echo json_encode($out);
die();


?>