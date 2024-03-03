<?php
include_once "../../../partials/db.php";
$conn = new db("localhost", "root", "", "cms");
$connDB = $conn->getConnection();
$search = $_POST['search'];

$sql = "SELECT * FROM `posts` WHERE `post_title`= '$search'";
$result = mysqli_query($connDB, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<th scope='row'>" . $row['post_id'] . "</th>";
        echo "<td>" . $row['post_author'] . "</td>";
        echo "<td>" . $row['post_title'] . "</td>";
        echo "<td><img src='../images/" . $row['post_image'] . "' class='img-responsive' width='60'></td>";
        echo "<td>" . $row['post_status'] . "</td>";
        echo "<td>" . $row['post_tags'] . "</td>";

        $get_comment_query = "SELECT COUNT(*) as comment_count FROM `comments` WHERE `comment_post_id`={$row['post_id']}";
        $result_comment = mysqli_query($connDB, $get_comment_query);
        $comment_count = mysqli_fetch_assoc($result_comment)['comment_count'];
        echo "<td>" . $comment_count . "</td>";

        echo "<td>" . $row['post_date'] . "</td>";
        echo "<td><a href='/admin/posts.php?publish=" . $row['post_id'] . "'>Publish</a></td>";
        echo "<td><a href='/admin/posts.php?draft=" . $row['post_id'] . "'>Unpublish</a></td>";
        echo "<td><a href='posts.php?source=edit_post&id=" . $row['post_id'] . "'>Edit</a></td>";
        echo "<td><a href='/admin/posts.php?delete=" . $row['post_id'] . "'>Delete</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='12'>No posts found.</td></tr>";
}
