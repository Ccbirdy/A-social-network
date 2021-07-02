<?php 
include("includes/header.php");
//session_destroy();
?>
	<div class="user_details column">    <!-- 2 classes -->
		<a href="<?php echo $userLoggedIn; ?>">  <img src=" <?php echo $user['profile_pic']; ?>">  </a> <!-- profile pic link to person profile page -->

		<div class="user_details_left_right"> 
			<a href="<?php echo $userLoggedIn; ?>">  <!-- name is a link to profile -->
			<?php 
			echo $user['first_name'] . " " .  $user['last_name'];

			 ?>
			</a>
			<br>
			<?php echo "Posts: " . $user['num_posts'] . "<br>" ;
			echo "Likes: " . $user['num_likes'];

			 ?>
		 </div>

	</div>
	<div class="main_column column">
		<form class="post_form" action="index.php" method="POST">
			<textarea name="post_text" id="post_text" placeholder="Got something to share?"></textarea>
			<input type="submit" name="post" id="post_button" value="CCpost !">
			<hr>
			
		</form>
		
	</div>


	</div>   <!-- closing tag for wrapper in header.php -->

</body>
</html>

