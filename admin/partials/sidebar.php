<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/admin/css/adminsidebar.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <main class="sidebar d-flex flex-column">
        <a href="/admin/" class="button d-flex text-decoration-none align-items-center ps-2">Dashboard</a>
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Posts
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="/admin/posts.php">View all post</a></li>
            <li><a class="dropdown-item" href="/admin/posts.php?source=add_post">Add posts</a></li>
        </ul>
        <a href="/admin/comments.php" class="button d-flex text-decoration-none align-items-center ps-2">Comments</a>
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Users
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="/admin/users.php">view all users</a></li>
            <li><a class="dropdown-item" href="/admin/users.php?source=add_user">Add users</a></li>
        </ul>
        <a href="/admin/profile.php" class="button d-flex text-decoration-none align-items-center ps-2">Profile</a>
    </main>
</body>

</html>