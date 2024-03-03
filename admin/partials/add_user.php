<?php
ob_start();
?>
<?php
if (isset($_POST['create_user'])) {
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    include "classes.php";
    $new_post = new user();
    $new_post->post_user(
        $_POST['firstname'],
        $_POST['lastname'],
        $_POST['email'],
        $_POST['role'],
        $_POST['username'],
        $hashed_password
    );
}
?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Firstname</label>
        <input type="text" required class="form-control" name="firstname">
    </div>

    <div class="mb-3">
        <label for="author" class="form-label">Lastname</label>
        <input type="text" required class="form-control" name="lastname">
    </div>

    <div class="mb-3">
        <label for="author" class="form-label">Email</label>
        <input type="text" required class="form-control" name="email">
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" aria-label="Default select example" name="role">
            <option selected>Select</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="date" class="form-label">Username</label>
        <input type="text" required class="form-control" name="username">
    </div>

    <div class="mb-3">
        <label for="tags" class="form-label">Password</label>
        <input type="text" required class="form-control" name="password">
    </div>

    <button type="submit" name="create_user" class="btn btn-primary">Submit</button>
</form>
<?php
ob_end_flush();
?>