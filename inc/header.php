<?php
	include('inc/connect.php');
	session_start();
	if (!isset($_SESSION['user_login'])) {
		$username = '';
	}
	else{
		$username = $_SESSION['user_login'];
	}
?>
<!DOCTYPE html>

<html>

<head>
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script src="js/main.js" type="text/javascript"></script>
</head>

<body>
	<div class="header col-md-12">
		<div class="logo col-md-3">
			<a href="home.php" style="text-decoration: none;"><h3>Find Friends</h3></a>
		</div>
		<div class="col-md-3">
			<div class="searchbox">
				<form class="form-inline" method="GET" action="search.php">
				  <div class="form-group">
				    <input type="text" class="form-control" id="exampleInputName2" placeholder="search">
				  </div>
				  <button type="submit" class="btn btn-default" name="search">Search</button>
				</form>
			</div>
		</div>
		<div class="col-md-2"></div>
		<?php
			if(!$username){
				echo '<div class="col-md-4">
						<div class="navbar">
							<ul class="nav nav-pills">
							  <li role="presentation"><a href="index.php">Sign Up</a></li>
							  <li role="presentation"><a href="index.php">Login</a></li>
							</ul>
						</div>
					</div>';
			}
			else{
				echo '<div class="col-md-4">
						<div class="navbar">
							<ul class="nav nav-pills">
							  <li role="presentation"><a href="'.$username.'">Profile</a></li>
							  <li role="presentation"><a href="account_settings.php">Account Settings</a></li>
							  <li role="presentation"><a href="logout.php">Logout</a></li>
							</ul>
						</div>
					</div>';
			}
		?>
	</div>

