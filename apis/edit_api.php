<?php
$username = $_COOKIE['username'];
$sql = "SELECT * FROM users WHERE username='$username'";

include "../partials/db.php";
$conn = new db("localhost", "root", "", "cms");
$connDB = $conn->getConnection();
$result = mysqli_query($connDB, $sql);
$row = mysqli_fetch_assoc($result);
//getd the user role
$userRole = $row['user_role']; //got the user role
$userid = $row['user_id'];

if ($userRole == "admin" && isset($_COOKIE['usertoken'])) {
    $currentToken = $_COOKIE['usertoken'];
    $token = mysqli_real_escape_string($connDB, $currentToken);
    $checkToken = "SELECT * FROM api_token WHERE user_id='$userid' AND user_token= '$currentToken'";
    $result = mysqli_query($connDB, $checkToken);
    if (mysqli_num_rows($result) > 0) {
        $userTokenValidation = true;
    } else {
        $userTokenValidation = false;
    }
} else {
    $userTokenValidation = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $userRole == "admin" && $userTokenValidation) {
    include "../admin/partials/classes.php";
    header('Content-Type: application/json');

    $new_post = new post();
    $new_post->edit_post(
        $_POST['post_id'],
        $_POST['post_title'],
        $_POST['post_author'],
        $_POST['post_date'],
        $_FILES['post_image']['name'],
        $_POST['post_tags'],
        $_POST['post_content']
    );

    $response = array(
        'success' => true,
        'message' => 'Post created successfully.'
    );
    echo json_encode($response);
} else {
    $response = array(
        'success' => false,
        'message' => 'Error: Invalid request or unauthorized access.'
    );
    echo json_encode($response);
}
