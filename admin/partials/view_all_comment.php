<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Author</th>
            <th scope="col">Email</th>
            <th scope="col">Content</th>
            <th scope="col">Status</th>
            <th scope="col">Response</th>
            <th scope="col">Date</th>
            <th scope="col">Approve</th>
            <th scope="col">Unapprove</th>
            <th scope="col">Delete</th>
            <!-- <th scope="col">operations</th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        include "../partials/db.php";
        $conn = new db("localhost", "root", "", "cms");
        $connDB = $conn->getConnection();

        //query to get all the posts from database
        $sql = "SELECT * FROM `comments`";
        $result = mysqli_query($connDB, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <tr>
                    <td><?php echo $row['comment_id']; ?></td>
                    <td><?php echo $row['comment_author']; ?></td>
                    <td><?php echo $row['comment_email']; ?></td>
                    <td><?php echo substr($row['comment_content'], 0, 17); ?>..</td>
                    <td><?php echo $row['comment_status']; ?></td>
                    <td>Some time</td>
                    <td><?php echo $row['comment_date']; ?></td>
                    <td><a href="/admin/comments.php?approve=<?php echo $row['comment_id']; ?>">Approve</a></td>
                    <td><a href="/admin/comments.php?unapprove=<?php echo $row['comment_id']; ?>">Unapprove</a></td>
                    <td><a href="/admin/comments.php?pid=<?php echo $row['comment_id']; ?>" class="delete_comment">Delete</a></td>
                </tr>
        <?php
            }
        } else {
            echo "No data Available";
        }
        ?>
    </tbody>
</table>
<?php
include_once "../partials/classes.php";

//for approving
if (isset($_GET['approve'])) {
    $approveComment = new cmnt();
    $approveComment->approveCmnt($_GET['approve']);
}

//for unapproving
if (isset($_GET['unapprove'])) {
    $unapproveComment = new cmnt();
    $unapproveComment->unapproveCmnt($_GET['unapprove']);
}

//for deleting
if (isset($_GET['pid'])) {
    //include the comment class to delete
    $deleteComment = new cmnt();
    $deleteComment->deleteCmnt($_GET['pid']);
}
?>