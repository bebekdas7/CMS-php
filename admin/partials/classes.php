<?php
ob_start();
?>
<?php

// Check if db class is not already included
if (!class_exists('db')) {
    include_once "../partials/db.php";
}

//classes for all post operations
class post
{
    public $title;
    public $author;
    public $date;
    public $image;
    public $tags;
    public $content;

    //function to add post
    function post_to_db($title, $author, $date, $image, $tags, $content)
    {
        $post_title = $title;
        $post_author = $author;
        $post_date = $date;
        $post_image = $image;
        $post_tags = $tags;
        $post_content = $content;
        $post_comment = 0;

        move_uploaded_file($_FILES['post_image']['tmp_name'], "../images/$post_image");

        //importing connections
        // include "../partials/db.php";
        $connpost = new db("localhost", "root", "", "cms");
        $connDB = $connpost->getConnection();

        //sql query to insert post data into database
        $sql = "
            INSERT INTO `posts` (
                `post_id`, 
                `post_title`, 
                `post_author`, 
                `post_date`, 
                `post_image`, 
                `post_content`, 
                `post_tags`, 
                `post_comment`, 
                `post_status`
            ) VALUES (
                NULL, 
                '$post_title', 
                '$post_author', 
                '$post_date', 
                '$post_image', 
                '$post_content', 
                '$post_tags', 
                '$post_comment', 
                'draft'
            )";
        $result = mysqli_query($connDB, $sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //function to delete post
    function delete_post($id)
    {
        $conndelete = new db("localhost", "root", "", "cms");
        $connDB = $conndelete->getConnection();

        // sql query to delete the post
        $sql = "DELETE FROM `posts` WHERE `post_id` = $id";
        $result = mysqli_query($connDB, $sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //function to edit post
    function edit_post($id, $title, $author, $date, $image, $tags, $content)
    {
        $post_id = $id;
        $post_title = $title;
        $post_author = $author;
        $post_date = $date;
        $post_image = $image;
        $post_tags = $tags;
        $post_content = $content;

        move_uploaded_file($_FILES['post_image']['tmp_name'], "../images/$post_image");

        // importing connections
        // include "../partials/db.php";
        $connededit = new db("localhost", "root", "", "cms");
        $connDB = $connededit->getConnection();

        // sql query to update the post
        $sql = "
            UPDATE `posts` SET 
            `post_title` = '$post_title',
            `post_author` = '$post_author',
            `post_date` = '$post_date',
            `post_image` = '$post_image',
            `post_content` = '$post_content',
            `post_tags` = '$post_tags',
            `post_comment` = '4',
            `post_status` = 'draft'
            WHERE `posts`.`post_id` = '$post_id';
        ";
        $result = mysqli_query($connDB, $sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //publish post
    function publish_post($id)
    {
        $post_id = $id;

        //use connections
        $conn = new db("localhost", "root", "", "cms");
        $connDB = $conn->getConnection();

        $sql = "UPDATE `posts` SET `post_status` = 'published' WHERE `post_id` = '$post_id'";
        $result = mysqli_query($connDB, $sql);
        if ($result) {
            echo '<script>window.location.href= "/admin/posts.php"</script>';
        } else {
            echo '
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Cannot update!</strong> There is some server error.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
        }
    }
    function unpublish_post($id)
    {
        $post_id = $id;

        //use connections
        $conn = new db("localhost", "root", "", "cms");
        $connDB = $conn->getConnection();

        $sql = "UPDATE `posts` SET `post_status` = 'draft' WHERE `post_id` = '$post_id'";
        $result = mysqli_query($connDB, $sql);
        if ($result) {
            echo '<script>window.location.href= "/admin/posts.php"</script>';
        } else {
            echo '
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Cannot update!</strong> There is some server error.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
        }
    }
}

class user
{
    public $title;
    public $author;
    public $date;
    public $image;
    public $tags;
    public $content;

    //function to add post
    function post_user($firstname, $lastname, $email, $role, $username, $password)
    {
        $firstname = $firstname;
        $lastname = $lastname;
        $email = $email;
        $role = $role;
        $username = $username;
        $password = $password;

        //importing connections
        // include "../partials/db.php";
        $connuser = new db("localhost", "root", "", "cms");
        $connDB = $connuser->getConnection();

        //sql query to insert post data into database
        $sql = "
        INSERT INTO `users` (
            `user_id`, 
            `username`, 
            `user_password`, 
            `user_firstname`, 
            `user_lastname`, 
            `user_email`, 
            `user_role`
        ) VALUES (
            NULL, 
            '$username', 
            '$password',
            '$firstname', 
            '$lastname', 
            '$email', 
            '$role'
        )";

        $result = mysqli_query($connDB, $sql);

        if ($result) {
            echo '<script>window.location.href= "/admin/users.php"</script>';
        } else {
            echo '
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Something went wrong!</strong> User cannot be added.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ';
        }
    }
    //function to delete user
    function delete_user($id)
    {
        $conndelete = new db("localhost", "root", "", "cms");
        $connDB = $conndelete->getConnection();

        // sql query to delete the post
        $sql = "DELETE FROM `users` WHERE `user_id` = $id";
        $result = mysqli_query($connDB, $sql);

        // check if deleted or not and then respont
        if ($result) {
            echo "<script>alert('User Deleted Successfully')</script>";
            echo '<script>window.location.href= "/admin/users.php"</script>';
        } else {
            echo '
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Cannot delete!</strong> There is some server error.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
        }
    }
}
?>
<?php
ob_end_flush()
?>