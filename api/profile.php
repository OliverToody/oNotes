<?php
require('connect.php');
require('session.php');

$out = array();

$out['email'] = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';
$out['user_id'] = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : '';
$out['nickname'] =isset($_COOKIE['nickname']) ? $_COOKIE['nickname'] : '';


$conn->close();

header("Content-type: application/json");
echo json_encode($out);
die();


?>