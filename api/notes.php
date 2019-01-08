<?php
require('connect.php');
require('session.php');
$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET'){
	$sql = "SELECT notes.note_id, notes.user_id, notes.note_title, notes.note_category, notes.note, notes.updated, notes.created, shared_notes_p.privilege_description, shared_notes_p.privilege_name , shared_notes_p.share_id, users.username AS ownerName, shared_notes_p.privilege_id, shared_notes_p.owner_id FROM notes LEFT JOIN (SELECT * FROM shared_notes LEFT JOIN privileges ON shared_notes.privilege = privileges.privilege_id ) AS shared_notes_p ON shared_notes_p.note_id = notes.note_id LEFT JOIN users ON notes.user_id = users.user_id WHERE notes.user_id = '$user_id' OR shared_notes_p.shared_to_user ='$user_id' ORDER BY notes.updated DESC ";
	$query = $conn->query($sql);
	$notes = array();

	while($row = $query->fetch_array()){
		array_push($notes, $row);
	}


	$out['notes'] = $notes;
}

if($method == 'DELETE'){
	$note_id_request = $_REQUEST['note_id'];
   echo $note_id_request;
	$sql = "DELETE FROM notes WHERE note_id='$note_id_request'";
	if ($conn->query($sql) === TRUE) {
		$out['error'] = 'false';
	} else {
		$out['error'] = $conn->error;
	}
	
}

if($method == 'POST'){
$input = json_decode(file_get_contents('php://input'),true);
$input['notePost']['user_id'] = $user_id;
$input = $input['notePost'];
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

	$sql = "insert into notes set $set";
	if ($conn->query($sql) === TRUE) {
		$out['error'] = 'false';
	} else {
		$out['error'] = $conn->error;
	}
	
}

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

$conn->close();

header("Content-type: application/json");
echo json_encode($out);
die();


?>