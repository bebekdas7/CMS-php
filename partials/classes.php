<!-- class for comment operations -->
<?php
include_once "db.php";

class cmnt
{
    public $post_id;
    public $name;
    public $email;
    public $post_content;
    public $comment_status = "unapproved";

    public function post_comment($post_id, $name, $email, $post_content)
    {
        $comment_post_id = $post_id;
        $comment_name = $name;
        $comment_email = $email;
        $comment_content = $post_content;
        $comment_status = $this->comment_status;

        //making connection 
        $conn = new db("localhost", "root", "", "cms");
        $connDB = $conn->getConnection();

        //query to insert comment in database
        $sql = "
            INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) VALUES (NULL, '$comment_post_id', '$comment_name', '$comment_email', '$comment_content', '$comment_status', current_timestamp());
        ";
        $result = mysqli_query($connDB, $sql);
        if ($result) {
            echo '<script>window.location.href= "/index.php"</script>';
        } else {
            echo '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Something went wrong!</strong> Post cannot be added.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ';
        }
    }
    //approve comments
    function approveCmnt($id)
    {
        //include the database connection file
        $conn = new db("localhost", "root", "", "cms");
        $connDB = $conn->getConnection();

        //sql query to delete the comment
        $sql = "UPDATE `comments` SET `comment_status`='approved' WHERE `comment_id`='$id'";
        $result = mysqli_query($connDB, $sql);
        $result = mysqli_query($connDB, $sql);
        if ($result) {
            echo '<script>window.location.href= "/admin/comments.php"</script>';
        } else {
            echo '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Something went wrong!</strong> Post cannot be added.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ';
        }
    }
    function unapproveCmnt($id)
    {
        //include the database connection file
        $conn = new db("localhost", "root", "", "cms");
        $connDB = $conn->getConnection();

        //sql query to delete the comment
        $sql = "UPDATE `comments` SET `comment_status`='unapproved' WHERE `comment_id`='$id'";
        $result = mysqli_query($connDB, $sql);
        $result = mysqli_query($connDB, $sql);
        if ($result) {
            echo '<script>window.location.href= "/admin/comments.php"</script>';
        } else {
            echo '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Something went wrong!</strong> Post cannot be added.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ';
        }
    }

    //delete comment function
    function deleteCmnt($id)
    {
        //include the database connection file
        $conn = new db("localhost", "root", "", "cms");
        $connDB = $conn->getConnection();

        //sql query to delete the comment
        $sql = "DELETE FROM `comments` WHERE `comment_id`='$id'";
        $result = mysqli_query($connDB, $sql);
        if ($result) {
            echo '<script>window.location.href= "/admin/comments.php"</script>';
        } else {
            echo '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Something went wrong!</strong> Post cannot be added.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ';
        }
    }
}
class Token
{
    public function saveToken($token, $user_id)
    {
        include_once "db.php";
        $conn = new db("localhost", "root", "", "cms");
        $connDB = $conn->getConnection();

        $token = mysqli_real_escape_string($connDB, $token);
        $user_id = mysqli_real_escape_string($connDB, $user_id);

        // to check the row wirh same userid hai ki nhi
        $check_sql = "SELECT * FROM `api_token` WHERE `user_id`='$user_id'";
        $check_result = mysqli_query($connDB, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $update_sql = "UPDATE `api_token` SET `user_token`='$token', `token_expiry` = NOW() + INTERVAL 15 MINUTE WHERE `user_id`='$user_id'";
            $update_result = mysqli_query($connDB, $update_sql);

            if ($update_result) {
                echo '<script>window.location.href= "/index.php"</script>';
            } else {
                echo '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Something went wrong!</strong> Cannot update token expiry.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ';
            }
        } else {
            $insert_sql = "INSERT INTO `api_token` (`api_id`, `user_id`, `user_token`, `token_expiry`) VALUES (NULL, '$user_id', '$token', NOW() + INTERVAL 15 MINUTE)";
            $insert_result = mysqli_query($connDB, $insert_sql);

            if ($insert_result) {
                echo '<script>window.location.href= "/index.php"</script>';
            } else {
                echo '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Something went wrong!</strong> Cannot save token.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ';
            }
        }
    }

    public function updteToken($token)
    {
        include_once "db.php";
        $conn = new db("localhost", "root", "", "cms");
        $connDB = $conn->getConnection();

        $token = mysqli_real_escape_string($connDB, $token);
        $check_sql = "SELECT * FROM `api_token` WHERE `user_token`='$token'";
        $check_result = mysqli_query($connDB, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $update_sql = "UPDATE `api_token` SET `token_expiry` = NOW() + INTERVAL 15 MINUTE WHERE `user_token`='$token'";
            $update_result = mysqli_query($connDB, $update_sql);

            if ($update_result) {
                return true;
            }
        }
    }
}


?>