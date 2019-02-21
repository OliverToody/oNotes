<?php
require('connect.php');
require('session.php');
$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET'){
	$sql = "SELECT L.id, L.list_name, L.category, DL.user_id, DL.privilege, U.email FROM displayedList DL 
	LEFT JOIN lists L ON DL.list_id = L.id 
	LEFT JOIN users U ON U.user_id = L.user_id 
	WHERE DL.user_id = '$user_id'";
	$query = $conn->query($sql);
	$items = array();

	while($row = $query->fetch_array()){
		array_push($items, $row);
	}

	$out['lists'] = $items;
}

if($method == 'DELETE'){
	$item_id_request = $_REQUEST['item_id'];
	$sql = "DELETE FROM lists WHERE id='$item_id_request'";
	if ($conn->query($sql) === TRUE) {
		$out['error'] = 'false';
	} else {
		$out['error'] = $conn->error;
	}

}

if($method == 'POST'){
	$sql = "insert into lists set user_id='$user_id', list_name='Untitled', category='blue'";
	if ($conn->query($sql) === TRUE) {
		$last_id = $conn->insert_id;
		$out['last'] = $last_id;
	} else {
		$out['error'] = $conn->error;
	}
	
	$sql = "insert into displayedList set list_id='$last_id', user_id='$user_id', privilege='3'";
	if ($conn->query($sql) === TRUE) {
		$out['error'] = false;
	} else {
		$out['error'] = $conn->error;
	}
}
	

$conn->close();

header("Content-type: application/json");
echo json_encode($out);
die();


?>