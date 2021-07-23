<?php
class Notification {
    private $user_obj;
    private $con;
 
    public function __construct($con, $user){
        $this->con = $con;
        $this->user_obj = new User($con, $user);
    }
        public function getUnreadNumber() {
        $userLoggedIn = $this->user_obj->getUsername();
        $query = mysqli_query($this->con, "SELECT * FROM messages WHERE viewed='no' AND user_to='$userLoggedIn'");
        return mysqli_num_rows($query);
    }

    public function getNotifications($data, $limit) {

        $page = $data['page'];
        $userLoggedIn = $this->user_obj->getUsername();
        $return_string = "";

        if($page == 1)
            $start = 0;
        else 
            $start = ($page - 1) * $limit;

        $set_viewed_query = mysqli_query($this->con, "UPDATE notifications SET viewed='yes' WHERE user_to='$userLoggedIn'");

        $query = mysqli_query($this->con, "SELECT * FROM notifications WHERE user_to='$userLoggedIn' ORDER BY id DESC");

        if(mysqli_num_rows($query) == 0) {
            echo "You have no notifications!";
            return;
        }
    }


    public function insertNotification($post_id, $user_to, $type) {

        $userLoggedIn = $this->user_obj->getUsername();
        $userLoggedInName = $this->user_obj->getFirstAndLastName();

        $date_time = date("Y-m-d H:i:s");

        switch($type) {
            case 'comment':
                $message = $userLoggedInName . " commented on your post";
                break;
            case 'like':
                $message = $userLoggedInName . " liked your post";
                break;
            case 'profile_post':
                $message = $userLoggedInName . " posted on your profile";
                break;
            case 'comment_non_owner':
                $message = $userLoggedInName . " commented on a post you commented on";
                break;
            case 'profile_comment':
                $message = $userLoggedInName . " commented on your profile post";
                break;
        }

        $link = "post.php?id=" . $post_id;

        $insert_query = mysqli_query($this->con, "INSERT INTO notifications VALUES('', '$user_to', '$userLoggedIn', '$message', '$link', '$date_time', 'no', 'no')");
    }

}

?>


