

	<?php include("inc/header.php"); ?>
	<?php
		
		$reg = @$_POST['reg'];
		$fn = ""; 
		$ln = ""; 
		$un = ""; 
		$em = ""; 
		$em2 = ""; 
		$pswd = ""; 
		$pswd2 = ""; 
		$d = ""; 
		$u_check = "";
		
		$fn = strip_tags(@$_POST['fname']);
		$ln = strip_tags(@$_POST['lname']);
		$un = strip_tags(@$_POST['username']);
		$em = strip_tags(@$_POST['email']);
		$em2 = strip_tags(@$_POST['email2']);
		$pswd = strip_tags(@$_POST['password']);
		$pswd2 = strip_tags(@$_POST['password2']);
		$d = date("Y-m-d"); 

		if (isset($reg)) {
		if ($em==$em2) {
		
		$sql = "SELECT username FROM users WHERE username='$un'";

		$u_check = mysqli_query($con, $sql);
		
		$check = mysqli_num_rows($u_check);
		
		$e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");
		
		$email_check = mysqli_num_rows($e_check);
		if ($check == 0) {
		  if ($email_check == 0) {
		
		if ($fn&&$ln&&$un&&$em&&$em2&&$pswd&&$pswd2) {
		
			if ($pswd==$pswd2) {
		
				if (strlen($un)>25||strlen($fn)>25||strlen($ln)>25) {
					echo "The maximum limit for username/first name/last name is 25 characters!";
				}
				else
				{
				
					if (strlen($pswd)>30||strlen($pswd)<5) {
						echo "Your password must be between 5 and 30 characters long!";
					}
					else
					{
				
						$pswd = md5($pswd);
						$pswd2 = md5($pswd2);
						$query = mysqli_query($con, "INSERT INTO users(`username`, `first_name`, `last_name`, `email`, `password`, `sign_up_date`, `activated`) VALUES ('$un','$fn','$ln','$em','$pswd','$d','0')");
						if(!$query){
							echo "not successful";
						}
						
					}
				}
			}
			else {
				echo "Your passwords don't match!";
			}
		}
		else
		{
			echo "Please fill in all of the fields";
		}
		}
		else
		{
		 echo "Sorry, but it looks like someone has already used that email!";
		}
		}
		else
		{
		echo "Username already taken ...";
		}
		}
		else {
		echo "Your E-mails don't match!";
		}
		}

		if (isset($_POST["user_login"]) && isset($_POST["password_login"])) {
			$user_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["user_login"]); // filter everything but numbers and letters
		    $password_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password_login"]); // filter everything but numbers and letters
			$md5password_login = md5($password_login);	
		    $sql = mysqli_query($con, "SELECT id FROM users WHERE username='$user_login' AND password='$md5password_login' LIMIT 1"); // query the person
			//Check for their existance
			$userCount = mysqli_num_rows($sql); //Count the number of rows returned
			if ($userCount == 1) {
				while($row = mysqli_fetch_array($sql)){ 
		             $id = $row["id"];
				}
				
				 $_SESSION["user_login"] = $user_login;

				 header("location: home.php");
				 
		         exit("<meta http-equiv=\"refresh\" content=\"0\">");
			}
			else {
				echo 'That information is incorrect, try again';
				exit();
			}
		}

	?>
	<div class="col-md-12 lb">
		<div class="col-md-2"></div>
		<div class="fl col-md-3">
			<div class="col-md-12">
				<h4>Already a member? Sign in bellow!</h4>
			</div>
			<div class="lf col-md-12">
				<form method="POST" action="index.php">
					<div class="form-group">
					    
					    <input name="user_login" type="text" class="form-control" id="exampleInputEmail1" placeholder="Username">
					 </div>
					 <div class="form-group">
					    
					    <input name="password_login" type="password" class="form-control" id="exampleInputEmail1" placeholder="Password">
					 </div>
					 <button name="login" type="submit" class="btn btn-primary">Login</button>

				</form>
			</div>
		</div>
		<div class="col-md-2"></div>
		<div class="col-md-3">
			<div class="sl col-md-12">
				<h4>Sign Up Bellow!</h4>
			</div>
			<div class="sform col-md-12">
				<form action="index.php" method="POST">

				  <div class="form-group">
				    
				    <input name="fname" type="text" class="form-control" id="exampleInputEmail1" placeholder="First Name">
				  </div>

				  <div class="form-group">
				    
				    <input name="lname" type="text" class="form-control" id="exampleInputEmail1" placeholder="Last Name">
				  </div>

				  <div class="form-group">
				    
				    <input name="username" type="text" class="form-control" id="exampleInputEmail1" placeholder="Username">
				  </div>

				  <div class="form-group">
				    
				    <input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
				  </div>

				  <div class="form-group">
				    
				    <input name="email2" type="email" class="form-control" id="exampleInputEmail1" placeholder="Email (Again)">
				  </div>

				  <div class="form-group">
				    
				    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
				  </div>

				  <div class="form-group">
				    
				    <input name="password2" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password (Again)">
				  </div>
				  
				  <button name="reg" type="submit" class="btn btn-primary">Sign Up!</button>
				</form>
			</div>
		</div>
	<?php include('inc/footer.php'); ?>