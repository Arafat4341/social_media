<?php
	include('inc/header.php');
	if($username){

	}
	else{
		die('You must log in to view this page');
	}
?>

<?php
	$senddata = @$_POST['senddata'];
	$old_password = @$_POST['oldpass'];
	$new_password = @$_POST['newpass'];
	$repeat_password = @$_POST['newpass2'];
	if(isset($senddata)){
		$pass_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$username' ");
		while ($row = mysqli_fetch_assoc($pass_query)) {
			$db_password = $row['password'];
			$old_password_md5 = md5($old_password);

			if($old_password_md5 == $db_password){
				if($new_password == $repeat_password){
					if(strlen($new_password)<5){
						echo "<script>alert('Your password must be at least 5 characters long!')</script>";
					}
					else{
						$new_password_md5 = md5($new_password);
						$pass_update_query = mysqli_query($con, "UPDATE users SET password = '$new_password_md5' WHERE username='$username'");
						if($pass_update_query){
							echo "<script>alert('Password has been updated!')</script>";
						}
					}
				}
				else{
					echo "<script>alert('Passwords don't match!')</script>";
					
				}
			}
			else{
				echo "<script>alert('Old password is incorrect!')</script>";
			}
		}
	}
	else{
		echo "";
	}

	$senddata1 = @$_POST['senddata1'];
	$get_info = mysqli_query($con, "SELECT first_name, last_name, bio FROM users WHERE username = '$username'");
	$get_row = mysqli_fetch_assoc($get_info);
	$db_first_name = $get_row['first_name'];
	$db_last_name = $get_row['last_name'];
	$db_bio = $get_row['bio'];

	if(isset($senddata1)){
		$first_name = @$_POST['newfn'];
		$last_name = @$_POST['newln'];
		$bio = @$_POST['abtyou'];

		if(strlen($first_name)<4){
			echo "<script>alert('Your first name must be at least 4 characters long!')</script>";
		}
		else{
			if(strlen($last_name)<5){
				echo "<script>alert('Your last name must be at least 5 characters long!')</script>";
			}
			else{
				$info_submit_query = mysqli_query($con, "UPDATE users SET 
					first_name = '$first_name',
					last_name = '$last_name',
					bio = '$bio' WHERE username = '$username' ");
				if($info_submit_query){
					echo "<script>alert('Your profile info has been updated!')</script>";
					header('location: profile.php');
				}
			}
		}
		
	}


	$check_pic = mysqli_query($con, "SELECT profile_pic FROM users WHERE username='$username'");
	$get_pic_row = mysqli_fetch_assoc($check_pic);
	$profile_pic_db = $get_pic_row['profile_pic'];

	if ($profile_pic_db=="") {
		$profile_pic = "image/default_pic.jpg";
	}
	else{
		$profile_pic = "userdata/profile_pic/".$profile_pic_db;
	}


	if(isset($_FILES['profilepic'])){
		 if (((@$_FILES["profilepic"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png") || (@$_FILES["profilepic"]["type"]=="image/gif"))&&(@$_FILES["profilepic"]["size"] < 1048576)){

		 	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		 	$rand_dir_name = substr(str_shuffle($chars), 0,15);
		 	mkdir("userdata/profile_pic/$rand_dir_name");
		 	if (file_exists("userdata/profile_pic/$rand_dir_name/".@$_FILES["profilepic"]["name"]))
			{
			    echo @$_FILES["profilepic"]["name"]." Already exists";
			}
			else{
				 move_uploaded_file(@$_FILES["profilepic"]["tmp_name"],"userdata/profile_pic/$rand_dir_name/".@$_FILES["profilepic"]["name"]);
				 
				 $profile_pic_name = @$_FILES['profilepic']['name'];

				 $profile_pic_query = mysqli_query($con, "UPDATE users SET profile_pic='$rand_dir_name/$profile_pic_name' WHERE username = '$username'");

				 header('location: account_settings.php');

			}
		 }
  
	}
	else{

	}
?>
	

<div class="col-md-2"></div>
<div style="background-color: white" class="col-md-8">
	<h2>Edit your account settings bellow</h2><br>
	<div class="row">
		<div class="col-md-4">
			<form method="post" action="" enctype="multipart/form-data">
			  <img style="margin-bottom: 5px;" src="<?php echo $profile_pic; ?>" width="70" height="70" />
				<div class="form-group">
					<label>Upload your profile picture</label>
					<input style="margin-bottom: 15px;" type="file" name="profilepic">
					<button type="submit" name="uploadpic" class="btn btn-primary">Upload Image</button>
				</div>
			</form>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<h3>Change your password:</h3>
			<form method="POST" action="#">
			  
			  <div class="form-group">
			    <label>Existing Password</label>
			    <input name="oldpass" type="password" class="form-control" id="exampleInputPassword1" placeholder="Old Password">
			  </div>
			  <div class="form-group">
			    <label>New Password</label>
			    <input name="newpass" type="password" class="form-control" id="exampleInputPassword1" placeholder="New Password">
			  </div>
			  <div class="form-group">
			    <label>Repeat Password</label>
			    <input name="newpass2" type="password" class="form-control" id="exampleInputPassword1" placeholder="Repeat Password">
			  </div>
			  <button name="senddata" type="submit" class="btn btn-primary">Update Information</button>
			  </form>

			  <hr><br>

			  <h3>Update your profile:</h3>
			  <form method="POST" action="#">
			   <div class="form-group">
			    <label>First Name</label>
			    <input name="newfn" type="text" class="form-control" value="<?php echo $db_first_name; ?>">
			  </div>
			 <div class="form-group">
			    <label>Last Name</label>
			    <input name="newln" type="text" class="form-control" value="<?php echo $db_last_name; ?>">
			  </div>
			  <div class="form-group">
			    <label>About Yourself</label>
			    <textarea name="abtyou" class="form-control" rows="4"><?php echo $db_bio; ?></textarea>
			  </div>
			  <button name="senddata1" type="submit" class="btn btn-primary">Update Information</button><hr>
			</form>
		</div>
	</div>
</div>