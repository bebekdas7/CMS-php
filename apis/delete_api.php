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

if (isset($_POST['delete_post']) && $userRole == "admin" && $userTokenValidation) {
    include "../admin/partials/classes.php";
    header('Content-Type: application/json');

    $deletepost = new post();
    $deletepost->delete_post($_POST['pid']);

    $response = array(
        'success' => true,
        'message' => 'Post deleted successfully.'
    );

    echo json_encode($response);
} else {
    $response = array(
        'success' => false,
        'message' => 'Error: Invalid request.'
    );
    echo json_encode($response);
}
