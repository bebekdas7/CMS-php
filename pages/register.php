<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/register.css">
    <title>Document</title>
</head>

<body>
    <?php
    include "../partials/nav.php";
    // include "../partials/db.php";
    if (isset($_POST['register'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $role = "user";
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];
        //importing connection
        $conn = new db("localhost", "root", "", "cms");
        $connDB = $conn->getConnection();

        //sql query to check and insert data
        $checksql = "SELECT * FROM `users` WHERE `username`= '$username'";
        $checkresult = mysqli_query($connDB, $checksql);

        //condition to check if username already exists
        if (mysqli_num_rows($checkresult) > 0) {
            echo '
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Username already taken!</strong> Please Login.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        } else {
            //compare and hash and push password and confirm password
            if ($password == $confirmpassword) {
                $hashpassword = password_hash($password, PASSWORD_DEFAULT);
                //inserting data query
                $sql = "INSERT INTO `users` (`user_firstname`, `user_lastname`, `user_email`, `user_role`, `username`, `user_password`) VALUES ('$firstname', '$lastname', '$email', '$role', '$username', '$hashpassword')";
                $result = mysqli_query($connDB, $sql);
                if ($result) {
                    setcookie("username", $username, time() + (60 * 15), "/");
                    echo '
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Registration Successful!</strong> Please Login.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                    header("Location: ../index.php");
                }
            } else {
                echo '
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Password does not match!</strong> Check password and register again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }
        }
    }

    ?>
    <main class="register-main d-flex flex-column justify-content-center align-items-center">
        <section class="register d-flex flex-column justify-content-center align-items-center p-5">
            <h2 class="mb-4">Register </h2>
            <form action="register.php" method="post" class="w-100">
                <input type="text" placeholder="Firat Name" name="firstname" class="mb-2 form-control w-100">

                <input type="text" placeholder="Lastname" name="lastname" class="mb-2 form-control w-100">

                <input type="text" placeholder="Email" name="email" class="mb-2 form-control w-100">

                <input type="text" placeholder="Username" name="username" class="mb-2 form-control w-100">

                <input type="password" placeholder="Password" name="password" class="mb-2 form-control w-100">

                <input type="password" placeholder="Confirm Password" name="confirmpassword" class="mb-2 form-control w-100">

                <input type="submit" value="Register" name="register" class="btn btn-success">

                <p>Back to <a href="../index.php">Login</a>!</p>
            </form>
        </section>
    </main>
</body>

</html>