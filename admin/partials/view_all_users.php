<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Username</th>
            <th scope="col">Password</th>
            <th scope="col">Firstname</th>
            <th scope="col">Lastname</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Delete</th>
            <!-- <th scope="col">Date</th> -->
            <!-- <th scope="col">operations</th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        include_once "../partials/db.php";
        $conn = new db("localhost", "root", "", "cms");
        $connDB = $conn->getConnection();

        //query to get all the posts from database
        $sql = "SELECT * FROM `users`";
        $result = mysqli_query($connDB, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <tr>
                    <th scope="row"><?php echo $row['user_id']; ?></th>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo substr($row['user_password'], 0, 20); ?></td>
                    <td><?php echo $row['user_firstname']; ?></td>
                    <td><?php echo $row['user_lastname']; ?></td>
                    <td><?php echo $row['user_email']; ?></td>
                    <td><?php echo $row['user_role']; ?></td>
                    <td><a href="/admin/users.php?pid=<?php echo $row['user_id']; ?>">Delete</a></td>
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
if (isset($_GET['delete'])) {
    include "classes.php";
    $deletepost = new post();
    $deletepost->delete_post($_GET['delete']);
}

if (isset($_GET['pid'])) {
    include "classes.php";
    $deleteuser = new user();
    $deleteuser->delete_user($_GET['pid']);
}
?>