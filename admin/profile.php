    <?php
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="./css/adminindex.css">
        <title>Document</title>
    </head>

    <body>
        <!-- --------------------login check----------------- -->
        <?php
        include "../login_check.php";
        ?>
        <!-- -----------navbar------------- -->
        <?php
        include_once "./partials/nav.php";
        ?>

        <!-- -----------------main---------------- -->
        <main class="admin d-flex">
            <section class="sidebar w-25 p-3">
                <?php
                include_once "./partials/sidebar.php";
                ?>
            </section>



            <section class="body w-75 p-3">
                <?php
                if (isset($_COOKIE['username'])) {
                    $username = $_COOKIE['username'];

                    //including connection
                    include_once "../partials/classes.php";
                    $conn = new db("localhost", "root", "", "cms");
                    $connDB = $conn->getConnection();
                    $sql = "SELECT * FROM `users` WHERE `username`='$username'";
                    $result = mysqli_query($connDB, $sql);

                    $row = mysqli_fetch_assoc($result);
                    $firstname = $row['user_firstname'];
                    $lastname = $row['user_lastname'];
                    $email = $row['user_email'];
                    $role = $row['user_role'];
                    $username = $row['username'];
                    $id = $row['user_id'];

                    if (isset($_POST['update_profile'])) {
                        $newFirstname = $_POST['firstname'];
                        $newLastname = $_POST['lastname'];
                        $newEmail = $_POST['email'];
                        $newRole = $_POST['role'];
                        $newUsername = $_POST['username'];
                        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                        $sql = "UPDATE `users` SET 
                        `user_firstname`='$newFirstname',
                        `user_lastname`='$newLastname',
                        `user_email`='$newEmail',
                        `user_role`='$newRole',
                        `username`='$newUsername',
                        `user_password`='$hashed_password' 
                        WHERE `user_id`='$id'";

                        $result = mysqli_query($connDB, $sql);
                        if ($result) {
                            echo '
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>User updated!</strong> 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            ';
                        } else {
                            echo '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>User cannot be updated!</strong> 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            ';
                        }
                    }
                } else {
                    echo "hello";
                }
                ?>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Firstname</label>
                        <input type="text" value="<?php echo $firstname ?>" required class="form-control" name="firstname">
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Lastname</label>
                        <input type="text" value="<?php echo $lastname ?>" required class="form-control" name="lastname">
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Email</label>
                        <input type="text" value="<?php echo $email ?>" required class="form-control" name="email">
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" aria-label="Default select example" name="role">
                            <option <?php if ($role == "user") echo "selected"; ?> value="user">User</option>
                            <option <?php if ($role == "admin") echo "selected"; ?> value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Username</label>
                        <input type="text" value="<?php echo $username ?>" required class="form-control" name="username">
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">Password</label>
                        <input type="password" placeholder="Enter new password" required class="form-control" name="password">
                    </div>

                    <button type="submit" name="update_profile" class="btn btn-primary">Update profile</button>
                </form>

            </section>
        </main>


    </body>

    </html>
    <?php
    ob_end_flush();
    ?>