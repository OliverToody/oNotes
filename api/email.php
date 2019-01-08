<?php
require('connect.php');
require('session.php');
$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
	$input = json_decode(file_get_contents('php://input'),true);
	//var_dump($input);
	$msg  = $input['email_content'];
	$recepient  = 'oliver.tomondy@gmail.com'; //$input['email_recepient'];
	$subject  = $input['email_subject'];
	mail($recepient, $subject, $msg);
	$out['msg'] = $msg;
	$out['recepient'] = "$recepient";
	$out['subject']= $subject;
}

$conn->close();

header("Content-type: application/json");
echo json_encode($out);
die();


?>