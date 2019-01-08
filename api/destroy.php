<?php
session_start();

	session_destroy();
	
echo "Succesfully logout";

header("Refresh:0; url=../main.html"); 

?>