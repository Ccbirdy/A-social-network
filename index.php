<?php 
include("includes/header.php");
//session_destroy();
?>
	<div class="user_details column">    <!-- 2 classes -->
		<a href="#">  <img src=" <?php echo $user['profile_pic']; ?>">  </a>

		<div class="user_details_left_right"> 
		<a href="#">  <!-- name is a link to profile -->

		<?php 
		echo $user['first_name'] . " " .  $user['last_name'];

		 ?>
		</a>
		<br>
		<?php echo "Posts: " . $user['num_posts'] . "<br>" ;
		echo "Likes: " . $user['num_likes'];

		 ?>

	</div>


	</div>   <!-- closing tag for wrapper in header.php -->

</body>
</html>

