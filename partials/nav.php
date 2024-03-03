<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/index.php">Home</a>
                    </li>
                    <?php
                    $cookie = isset($_COOKIE['username']) ? $_COOKIE['username'] : null;

                    include "db.php";
                    $conn = new db("localhost", "root", "", "cms");
                    $connDB = $conn->getConnection();

                    $role = '';
                    $sql = "SELECT * FROM `users` WHERE `username`='$cookie'";
                    $result = mysqli_query($connDB, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $role = $row['user_role'];
                        if ($role == 'admin') {
                            break;
                        }
                    }

                    if ($cookie && $role == "admin") {
                        echo '
                            <li class="nav-item">
                                <a class="nav-link" href="../admin/index.php">Admin</a>
                            </li>
                        ';
                    }
                    ?>

                    <li class="nav-item d-flex align-items-center ms-3">
                        <?php
                        if ($cookie) {
                            echo "Welcome " . $cookie;
                        } else {
                            echo '<h6 class="mb-0">Welcome guest</h6>';
                        }
                        ?>
                    </li>
                </ul>
                <form class="d-flex" action="search.php" method="post">
                    <input class="form-control me-2" name="data" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" name="search" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
</body>

</html>