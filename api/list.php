<?php
require('connect.php');
require('session.php');
$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET'){
	$sql = "SELECT * FROM common_items WHERE user_id = '$user_id'";
	$query = $conn->query($sql);
	$items = array();

	while($row = $query->fetch_array()){
		array_push($items, $row);
	}


	$out['listItems'] = $items;
}

if($method == 'DELETE'){
	$item_id_request = $_REQUEST['item_id'];
	$sql = "DELETE FROM common_items WHERE id='$item_id_request'";
	if ($conn->query($sql) === TRUE) {
		$out['error'] = 'false';
	} else {
		$out['error'] = $conn->error;
	}
	
}

if($method == 'POST'){
$input = json_decode(file_get_contents('php://input'),true);
$input['user_id'] = $user_id;
$input['category'] = "blue";

$out['input'] = $input;

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

	$sql = "insert into common_items set $set";
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