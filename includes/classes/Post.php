<?php 
class Post {
	private $user;
	private $con;

	public function __construct($con, $user){
		$this->con = $con;		
		$this->user_obj = new User($con, $user);
	}

	public function submitPost($bodym $user_to) {
		$body = strip_tags($body); // removes html tags
		$body = mysqli_real_escape_string($this->con, $body);
		$check_empty = preg_replace('/\s+/','',$body); // delete all spaces

		if ($check_empty != "") {
			// if we are in sb else's profile ,allow user to post , like private message?
			
			// current date and time
			$date_added = date("Y-m-d H:i:s");
			// get username
			$added_by = $this->$user_obj->getUsername();

			// if user is not on own profile , user_to is 'none'
			if($user_to = $added_by) {
				$user_to = "none";
			}
		}

		
	}
}

 ?>