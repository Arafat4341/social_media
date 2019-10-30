<?php include('./inc/header.php'); ?>

<?php
if (isset($_GET['u'])) {

	$user = mysqli_real_escape_string($con, $_GET['u']);

	if (ctype_alnum($user)) {


		$check = mysqli_query($con, "SELECT username, first_name FROM users WHERE username='$user'");
		if (mysqli_num_rows($check)==1) {
			$get = mysqli_fetch_assoc($check);
			$user = $get['username'];
			$first_name = $get['first_name'];

	
		}
		else
		{
			echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/social_media/index.php\">";
			
			exit();
		}
	}
}

$post = @$_POST['post'];
	if($post != ""){
		$date_added = date("Y-m-d");
		$added_by = $username;
		$user_posted_to = $user;

		$sql_command = "INSERT INTO `posts`(`body`, `date_added`, `added_by`, `user_posted_to`) VALUES ('$post', '$date_added', '$added_by', '$user_posted_to')";

		$query = mysqli_query($con, $sql_command) or die(mysqli_error());
	}

$check_pic = mysqli_query($con, "SELECT profile_pic FROM users WHERE username='$user'");
	$get_pic_row = mysqli_fetch_assoc($check_pic);
	$profile_pic_db = $get_pic_row['profile_pic'];

	if ($profile_pic_db=="") {
		$profile_pic = "image/default_pic.jpg";
	}
	else{
		$profile_pic = "userdata/profile_pic/".$profile_pic_db;
	}

?>
<div class="col-md-2"></div>
<div class="probody col-md-8">
	<div class="lpi col-md-3">
		<div class="bb pp col-md-12">
			<img height="200" width="174" src="<?php echo $profile_pic ?>" alt="<?php echo $username;?>'s profile" title="<?php echo $username;?>'s profile" />
		</div>
		<div class="bp col-md-12">
		
			
			<form action="<?php echo $user; ?>" method='POST'>

			<?php

				$friendsArray = "";
				$countFriends = "";
				$friendsArray12 = "";
				$addAsFriend = "";
				$selectFriendsQuery = mysqli_query($con,"SELECT friend_array FROM users WHERE username='$user'");
				$friendRow = mysqli_fetch_assoc($selectFriendsQuery);
				$friendArray = $friendRow['friend_array'];
				if ($friendArray != "") {
				   $friendArray = explode(",",$friendArray);
				   $countFriends = count($friendArray);
				   $friendArray12 = array_slice($friendArray, 0, 12);

				$i = 0;
				if (in_array($username,$friendArray)) {

				 $addAsFriend = '<input class="btn btn-primary" type="submit" name="removefriend" value="Un-Friend">';
				}
				else
				{

				 $addAsFriend = "<input class='btn btn-primary' type='submit' name='addfriend' value='Add Friend'>";
				}
				
				if($username!=$user){echo $addAsFriend;}
				}
				else
				{

				 $addAsFriend = '<input class="btn btn-primary" type="submit" name="addfriend" value="Add Friend">';
				 if($username!=$user){echo $addAsFriend;}
				}
				$msg = "";
				if($username!=$user){
					$msg="<button type='submit' name='message' class='msg btn btn-primary'>Message</button>";
				}
				echo $msg;
			?>

			</form>
			
			<?php
				if(isset($_POST['addfriend'])){
					$friend_request = $_POST['addfriend'];
					$user_to = $user;
					$user_from = $username;
					if($user_to==$user_from){
						echo "<script>alert('You can not send a friend request to yourself!')</script>";
					}
					else{
						$create_request = mysqli_query($con, "INSERT INTO `friend_requests`(`user_from`, `user_to`) VALUES ('$user_from','$user_to')");
						if($create_request){
							echo "<script>alert('Friend request has been send!')</script>";
						}
					}
				}
			?>

		</div>
		<div class="textheader col-md-12">
			<b><h5><?php echo $user; ?>'s profile</h5></b>
		</div>
		<div class="bb profileLeftSideContent col-md-12">
			<p><?php
				$about_query = mysqli_query($con, "SELECT bio from users WHERE username = '$user'");
				$get_result = mysqli_fetch_assoc($about_query);
				echo $get_result['bio'];
			?></p>
		</div>
		<div class="textheader col-md-12">
			<h5><?php echo $user; ?>'s friends
		</div>
		<div class="bb profileLeftSideContent col-md-12">
		  <div class="frnd">
			<div class="lp col-md-3">
				<img src="#" height="50" width="40">
			</div>
			<div class="lp col-md-3">
				<img src="#" height="50" width="40">
			</div>
			<div class="lp col-md-3">
				<img src="#" height="50" width="40">
			</div>
			<div class="lp col-md-3">
				<img src="#" height="50" width="40">
			</div>
			<div class="lp col-md-3">
				<img src="#" height="50" width="40">
			</div>
			<div class="lp col-md-3">
				<img src="#" height="50" width="40">
			</div>
			<div class="lp col-md-3">
				<img src="#" height="50" width="40">
			</div>
			<div class="lp col-md-3">
				<img src="#" height="50" width="40">
			</div>
			<div class="lp col-md-3">
				<img src="#" height="50" width="40">
			</div>
			<div class="lp col-md-3">
				<img src="#" height="50" width="40">
			</div>
			<div class="lp col-md-3">
				<img src="#" height="50" width="40">
			</div>
			<div class="lp col-md-3">
				<img src="#" height="50" width="40">
			</div>
		  </div>
		</div>
	</div>
	<div class="lp col-md-9">
		<div class="us postform col-md-12 bb">
			<?php
				if($username != $user){
					echo "<div class='col-md-12 us'><h5>Post Something On $user's Wall</h5></div>";
				}
				else{
					echo "<div class='col-md-12 us'><h5>Update status</h5></div>";
				}
			?>
						
			<form action="<?php echo $user; ?>" method = "POST">
				<textarea id="post" name="post" class="form-control" rows="3"></textarea>
				<button type="submit" name="send" class="btn btn-primary">Post</button>
			</form>		
		</div>
		<div class="profilepost col-md-12">
			<?php
				$getposts = mysqli_query($con, "SELECT * FROM posts WHERE user_posted_to = '$user' ORDER BY id desc limit 10") or die(mysql_errno());

				while ($row = mysqli_fetch_assoc($getposts)) {
						$id = $row['id'];
						$body = $row['body'];	
						$date_added = $row['date_added'];
						$added_by = $row['added_by'];
						$user_posted_to = $row['user_posted_to'];
					
					echo "<div class='posts col-md-12'>
							<a href='$added_by'>$added_by</a><br><span>$date_added</span><br><p>$body</p><br>
						  </div>";
				}

			?>
		</div>
	</div>
</div>