<?php 
include("includes/header.php");

$message_obj = new Message($con, $userLoggedIn);

if(isset($_GET['u'])) {
	$user_to = $_GET['u'];
	//echo "user_to here v1 :".$user_to ."<br>";
}	
else {
	$user_to = $message_obj->getMostRecentUser(); // in message class, Message.php
	//echo "user_to here: v2;".$user_to ."<br>";
	if($user_to == false) {  // if you haven't sent message to anybody
		$user_to = 'new';  // send new message
		//echo "user_to here: v3;".$user_to ."<br>";
	}		
}

if($user_to != "new")     // if not tring to send new message then create a new obj to
	$user_to_obj = new User($con, $user_to);
	//echo "user_to here: v4;".$user_to ."<br>";

 ?>

 <div class="user_details column">  <!-- from index.php -->
		<a href="<?php echo $userLoggedIn; ?>">  <img src="<?php echo $user['profile_pic']; ?>"> </a>

		<div class="user_details_left_right">
			<a href="<?php echo $userLoggedIn; ?>">
			<?php 
			echo $user['first_name'] . " " . $user['last_name'];

			 ?>
			</a>
			<br>
			<?php echo "Posts: " . $user['num_posts']. "<br>"; 
			echo "Likes: " . $user['num_likes'];

			?>
		</div>
	</div>
	
	<div class="main_column column" id="main_column">
		<?php  
		if($user_to != "new"){
			echo "<h4>You and <a href='$user_to'>" . $user_to_obj->getFirstAndLastName() . "</a></h4><hr><br>";

			echo "<div class='loaded_messages' id='scroll_messages'>";
				echo $message_obj->getMessages($user_to);
			echo "</div>";
		}
		else {
			echo "<h4>New Message</h4>";
		}
		?>

		<div class="message_post">
			<form action="" method="POST">
				<?php
				if($user_to == "new") {
					echo "Select the friend you would like to message <br><br>";
					echo "To: <input type='text' >";
					echo "<div class='results'></div>";
				}			
					
				else {
					echo "<textarea name='message_body' id='message_textarea' placeholder='Write your message ...'></textarea>";
					echo "<input type='submit' name='post_message' class='info' id='message_submit' value='Send'>";
				}

				?>
			</form>

		</div>

	</div>