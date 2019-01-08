<?php
require('connect.php');
require('session.php');

$out = array();

$out['email'] = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$out['user_id'] = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$out['nickname'] =isset($_SESSION['nickname']) ? $_SESSION['nickname'] : '';


$conn->close();

header("Content-type: application/json");
echo json_encode($out);
die();


?>