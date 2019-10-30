<?php include('inc/header.php'); ?>

<div class="col-md-3"></div>
<div class="frnrq col-md-6">
<?php

	$user_from = "";
	$user_to = "";
	$id = "";
	$friend_requests = mysqli_query($con, "SELECT * from friend_requests where user_to = '$username' ");
	if(mysqli_num_rows($friend_requests) == 0){
		echo "You have no friend requests at this time!";
	}
	else{
		while($get_rows = mysqli_fetch_assoc($friend_requests)){
			$id = $get_rows['id'];
			$user_to = $get_rows['user_to'];
			$user_from = $get_rows['user_from'];

			echo "<div class= 'col-md-12'>$user_from wants to be your friend</div>
					
			";
	

	
?>
<div class='col-md-12'>
	<form action='friend_requests.php' method='POST'>
		<input name='acceptrequest<?php echo $user_from; ?>' class='btn btn-primary' type='submit' value='Accept'>
		<input name='ignorerequest<?php echo $user_from; ?>' class='btn btn-default' type='submit' value='Ignore'><hr>
	</form>
</div>

		

<?php
	if(isset($_POST['acceptrequest'.$user_from])){
		$get_friend_check = mysqli_query($con, "SELECT friend_array from users where username = '$username'");
		$get_friend_row = mysqli_fetch_assoc($get_friend_check);
		$friend_array = $get_friend_row['friend_array'];
		$friendArray_explode = explode(",",$friend_array);
  		$friendArray_count = count($friendArray_explode);

  		  $get_friend_check_friend = mysqli_query($con, "SELECT friend_array FROM users WHERE username='$user_from'");
		  $get_friend_row_friend = mysqli_fetch_assoc($get_friend_check_friend);
		  $friend_array_friend = $get_friend_row_friend['friend_array'];
		  $friendArray_explode_friend = explode(",",$friend_array_friend);
		  $friendArray_count_friend = count($friendArray_explode_friend);

		    if ($friend_array == "") {
			     $friendArray_count = count(NULL);
			  }
			  if ($friend_array_friend == "") {
			     $friendArray_count_friend = count(NULL);
			  }
			  if ($friendArray_count == NULL) {
			   $add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array,'$user_from') WHERE username='$username'");
			  }
			  if ($friendArray_count_friend == NULL) {
			   $add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array,'$user_to') WHERE username='$user_from'");
			  }
			  if($friendArray_count >= 1){
				$add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array,',$user_from') WHERE username='$username'");
			  }
			  if($friendArray_count_friend >= 1){
				$add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array,',$user_to') WHERE username='$user_from'");
			  }
			  echo "<script>alert('You are now friends with'+$user_from)</script>";
			  $delete_request = mysqli_query($con, "DELETE FROM friend_requests where user_to = '$user_to' && user_from = '$user_from' ");
			  header('Location: friend_requests.php');

	}
	if(isset($_POST['ignorerequest'.$user_from])){
		echo "friend request has been deleted!";
		$delete_request = mysqli_query($con, "DELETE FROM friend_requests where user_to = '$user_to' && user_from = '$user_from' ");

		header('Location: friend_requests.php');
		
	}
?>

<?php 	} } ?>
</div>
