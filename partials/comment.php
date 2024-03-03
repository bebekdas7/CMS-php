<?php
if (isset($_POST['submit_comment'])) {
    //connection and comment class   
    include_once 'db.php';
    include_once 'classes.php';

    // Get form data
    $post_id = $_POST['post_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment_content = $_POST['comment'];

    $comment = new cmnt();
    $comment->post_comment($post_id, $name, $email, $comment_content);
    echo "Comment submitted successfully!!!!!";
} else {
    echo "Invalid request!";
}
