<?php
require('connect.php');
require('session.php');
$method = $_SERVER['REQUEST_METHOD'];
$out = array();
if($method == 'GET'){ 
	$sql = "SELECT list_id, id, item, checked FROM list_items WHERE list_id IN (SELECT list_id FROM displayedList WHERE user_id='$user_id')";
	$query = $conn->query($sql);
	$items = array();
	$lists = array();

	while($row = $query->fetch_array()){
		array_push($items, $row);
	}

	$sql = "SELECT * FROM lists WHERE user_id = '$user_id'";
	$query = $conn->query($sql);

	while($row = $query->fetch_array()){
		array_push($lists, $row);
	}


	$out['listWItems'] = $items;
	$out['listWInfo'] = $lists;
}

if($method == 'DELETE'){
	$item_id_request = $_REQUEST['item_id'];
	$sql = "DELETE FROM list_items WHERE id='$item_id_request'";
	if ($conn->query($sql) === TRUE) {
		$out['error'] = 'false';
	} else {
		$out['error'] = $conn->error;
	}
	
}

if($method == 'POST'){
$input = json_decode(file_get_contents('php://input'),true);

$list_id = $input['list_id'];
$list_name = $input['list_name'];
$list_category= $input['list_category'];
$list_items = $input['item'];
$sql = "DELETE FROM list_items WHERE list_id='$list_id'";
	if ($conn->query($sql) === TRUE) {
		$out['error1'] = 'false';
	} else {
		$out['error1'] = $conn->error;
	}

	$sql = "INSERT INTO list_items (`list_id`,`item`,`user_id`,`checked`) VALUES ";
	foreach ($list_items as $item) {
		$item_item = $item['item'];
		if($item['checked']) {
			$item_checked = 1;
		} else {
			$item_checked = 0;
		}
		$sql .= "('" . $list_id."', '" . $item_item . "', '".$user_id . "', '". $item_checked . "'), ";
		$out['item'] = $item;
	};

	$sql = substr($sql, 0,-2);
	$out['sql'] = $sql;
	if ($conn->query($sql) === TRUE) {
		$out['error'] = 'false';
	} else {
		$out['error'] = $conn->error;
	}
	if(isset($list_name)) {
	$sql = "UPDATE lists SET list_name='$list_name', category='$list_category' WHERE id='$list_id'";
        if ($conn->query($sql) === TRUE) {
            $out['error'] = 'false';
        } else {
            $out['error'] = $conn->error;
            $out['this'] = "is erro";

		}
	}

	
}

$conn->close();

header("Content-type: application/json");
echo json_encode($out);
die();


?>