<?php
require('connect.php');
require('session.php');
$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET'){
	$sql = "SELECT * FROM lists WHERE user_id = '$user_id'";
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
	$sql = "DELETE FROM working_list WHERE list_id='$item_id_request'";
	if ($conn->query($sql) === TRUE) {
		$out['error'] = 'false';
	} else {
		$out['error'] = $conn->error;
	}
	
}

if($method == 'POST'){
	$sql = "insert into lists set user_id='$user_id', list_name='New List', category='blue'";
	if ($conn->query($sql) === TRUE) {
		$last_id = $conn->insert_id;
		$out['last'] = $last_id;
	} else {
		$out['error'] = $conn->error;
	}
}
	

/*
if($method == 'PUT'){

    $input = json_decode(file_get_contents('php://input'),true);
    $newnote = $input['notePost']['note'];
    $newnotetitle = $input['notePost']['note_title'];
    $note_id = $input['notePost']['note_id'];
    $newnotecategory = $input['notePost']['note_category'];
    $deadline = $input['notePost']['deadline'];
    
        $sql = "update notes set note='$newnote', note_title='$newnotetitle', note_category='$newnotecategory'  WHERE note_id='$note_id'";
        if ($conn->query($sql) === TRUE) {
            $out['error'] = 'false';
        } else {
            $out['error'] = $conn->error;
            $out['this'] = "is erro";

        }
        
    }
*/
$conn->close();

header("Content-type: application/json");
echo json_encode($out);
die();


?>