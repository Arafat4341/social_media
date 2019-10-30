<?php
	include('inc/header.php');
	if(!$username){
		header('location:index.php');
	} else{	
		echo "hello, ".$username;
		echo "Would you like to logout? <a href='logout.php'>Logout</a>";
	}
?>