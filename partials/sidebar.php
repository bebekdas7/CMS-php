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
    <link rel="stylesheet" href="./css/sidebar.css">
    <title>Document</title>
</head>

<body>
    <section class="sidebar d-flex flex-column gap-3 p-4">
        <?php
        if (isset($_POST['login'])) {
            include_once "db.php";
            include_once "classes.php";
            $conn = new db("localhost", "root", "", "cms");
            $connDB = $conn->getConnection();

            $username = $_POST['username'];
            $password = $_POST['password'];

            //sql query for login
            $sql = "SELECT * FROM `users` WHERE `username` = '$username'";
            $result = mysqli_query($connDB, $sql);

            //set to lcalstorage if login is successfull'
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $user_id = $row['user_id'];
                $ogpassword = $row['user_password'];
                if (password_verify($password, $ogpassword)) {
                    $token = $userToken = bin2hex(random_bytes(4));
                    echo $token;
                    echo $user_id;
                    $savetoken = new token();
                    $savetoken->saveToken($token, $user_id);

                    setcookie("usertoken", $token, time() + (60 * 15), "/");
                    setcookie("username", $username, time() + (60 * 15), "/");
                    // header("location: ../index.php");
                } else {
                    echo '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Wrong password!</strong> Please check your password.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ';
                }
            } else {
                echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Login Failed!</strong> You should check your login details.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }
        }
        ?>
        <?php
        if (!isset($_COOKIE['username'])) {
            echo '
                <div class="login p-2">
                <h4 class="mb-4">Login</h4>
                <form action="index.php" method="post">
                <input type="text" placeholder="Username" name="username" class="mb-2">
                <input type="text" placeholder="Password" name="password" class="mb-2">
                <input type="submit" value="Login" name="login" class="btn btn-primary mb-1">
                </form>
                <p>Don\'t have an account? <a href="../pages/register.php">Register here</a></p>
                </div>';
        } else {
            echo '
                <div class="login p-2">
                <h4 class="mb-4">Logout</h4>
                <button class="btn btn-danger w-100 logout">Logout</button>
                </form>
                </div>';
        }
        ?>
    </section>

    <script type="text/javascript">
        const logout = document.querySelector(".logout");
        logout.addEventListener("click", () => {
            document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            document.cookie = "usertoken=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            window.location.href = "../index.php";
        })
    </script>
</body>

</html>
<?php
ob_end_flush();
?>