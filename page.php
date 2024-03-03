<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="css/page.css">
    <title>Document</title>
</head>

<body>
    <!-- --------------------checking login--------------- -->
    <?php
    include "login_check.php";
    ?>
    <!-- ---------------navbar------------ -->
    <?php include "partials/nav.php"; ?>
    <div class="page container p-3">
        <?php
        if (isset($_GET['p_id'])) {
            $p_id = $_GET['p_id'];

            // Importing connection
            include_once 'partials/db.php';
            $conn = new db("localhost", "root", "", "cms");
            $connDB = $conn->getConnection();

            $view_sql = "UPDATE posts SET post_views = (post_views + 1) WHERE post_id= $p_id";
            $view_result = mysqli_query($connDB, $view_sql);

            // SQL query to get the data
            $sql = "SELECT * FROM `posts` WHERE post_id = '$p_id'";
            $result = mysqli_query($connDB, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                global $post_id;
                $post_id = $row['post_id'];
        ?>
                <h1 class="text-primary"><?php echo $row['post_title']; ?></h1>
                <h5 class="mb-3">by <span class="text-primary"><?php echo $row['post_author']; ?></span></h5>
                <p><?php echo $row['post_date']; ?></p>
                <hr class="w-75">
                <img src="/images/<?php echo $row['post_image']; ?>" alt="poster" class="img-responsive" width="600" height="300">
                <hr class="w-75">
                <p class="w-75 text-dark"><?php echo $row['post_content']; ?>.</p>
        <?php
            }
        }
        ?>
        <div class="comment-box w-75 mt-4 p-3">
            <div id="notification-container"></div>

            <h4>Leave a comment</h4>
            <form action="" id="commentForm" method="post">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control mb-1" id="name" name="name" id="name">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control mb-1" id="email" name="email" id="email">
                <label for="comment" class="form-label">Comment</label>
                <textarea name="comment" class="form-control" id="comment" name=" comment" cols="30" rows="10"></textarea>
                <input type="submit" name="submit_comment" value="Submit" class="btn btn-primary mt-2">
            </form>
        </div>
        <?php
        // Making connections
        $conn = new db("localhost", "root", "", "cms");
        $connDB = $conn->getConnection();

        // SQL query to get the data
        $sql = "SELECT * FROM `comments` WHERE comment_post_id='$post_id' AND comment_status= 'approved' ORDER BY comment_id ASC";
        $result = mysqli_query($connDB, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="comments mt-4 p-3 w-75">
                <h6 class="mb-1 fw-bold"><u><?php echo $row['comment_author']; ?></u><small class="ms-2 text-secondary fw-normal"><?php echo $row['comment_date']; ?></small></h6>
                <p class="mb-0"><?php echo $row['comment_content']; ?></p>
            </div>
        <?php
        }
        ?>
    </div>

    <script>
        $(document).ready(function() {
            $("#commentForm").submit(function(e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "partials/comment.php",
                    data: {
                        submit_comment: '1',
                        post_id: <?php echo $post_id ?>,
                        name: $('#name').val(),
                        email: $('#email').val(),
                        comment: $('#comment').val(),
                    },
                    success: function(response) {
                        var alertHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            '<strong>Comment added successfully!</strong> Your comment will be listed after review.' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>';
                        $('#notification-container').html(alertHTML);
                        $("#commentForm")[0].reset();
                    },
                    error: function(response) {
                        var alertHTMLerror = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            '<strong>Something went wrong!</strong> Please wait someti.' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>';
                        $('#notification-container').html(alertHTMLerror);
                    }
                });
            });
        });
    </script>
</body>

</html>