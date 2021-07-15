<?php 
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");
//session_destroy();


if(isset($_POST['post'])){
	$post = new Post($con, $userLoggedIn);
	$post->submitPost($_POST['post_text'], 'none');
	header("Location: index.php"); // stop form resubmitting on refresh
}


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

		<div class="post_area"></div>
		<img id="loading" src="assets/images/icons/loading.gif">
		
	</div>

	<script>
	var userLoggedIn = '<?php echo $userLoggedIn; ?>';

	$(document).ready(function() {

		$('#loading').show();

		//original ajax request for loading first posts
		$.ajax({
			url: "includes/handlers/ajax_load_posts.php",
			type: "POST",
			data: "page=1&userLoggedIn=" + userLoggedIn,
			cache: false,

			success: function(data) {
				$('#loading').hide();
				$('.post_area').html(data);
			}
		});

		$(window).scroll(function(){
			var height = $('.post_area').height();// div containing posts
			var scroll_top = $(this).scrollTop();
			var page = $('.post_area').find('.nextPage').val();
			var noMorePosts = $('.post_area').find('.noMorePosts').val();

			if((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
				$('#loading').show();			

				var ajaxReq = $.ajax({
					url: "includes/handlers/ajax_load_posts.php",
					type: "POST",
					data: "page=" + page + "1&userLoggedIn=" + userLoggedIn,
					cache: false,

					success: function(response) {
						$('.post_area').find('.nextPage').remove();  // removes current .nextPage
						$('.post_area').find('.noMorePosts').remove();  // removes current .noMorePosts

						$('#loading').hide();
						$('.post_area').append(response);
					}
				});

			}// end if

			return false;

		}) //end  $(window).scroll(function()

	});		


	</script>


	</div>   <!-- closing tag for wrapper in header.php -->

</body>
</html>

