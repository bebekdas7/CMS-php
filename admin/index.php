<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/adminindex.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title>Admin | CMS</title>
</head>

<body>
    <!-- --------------------login check----------------- -->
    <?php
    include "../login_check.php";
    ?>
    <!-- -----------navbar------------- -->
    <?php
    include_once "./partials/nav.php";
    include_once "../partials/db.php";
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
            }
            ?>
            <div>
                <h1>Admin Dashboard <small class="text-secondary"><?php echo $username ?></small></h1>
            </div>


            <div class="mt-3 d-flex gap-3 justify-content-around">
                <div class="widgets w-25 p-1 bg-primary d-flex flex-column">
                    <span class="d-flex justify-content-around align-items-center ">
                        <div class="icon">
                            <i class="fas fa-file-lines"></i>
                        </div>
                        <div class="widget-detail d-flex flex-column align-items-center">
                            <h1 class="mb-0 text-light">
                                <?php
                                //dynamic post count
                                $conn = new db("localhost", "root", "", "cms");
                                $connDB = $conn->getConnection();

                                $sql = "SELECT * FROM posts";
                                $result = mysqli_query($connDB, $sql);
                                $post_count = mysqli_num_rows($result);
                                echo $post_count;
                                ?>
                            </h1>
                            <h4 class="mb-0 text-light">Posts</h4>
                        </div>
                    </span>
                    <a href="/admin/posts.php">
                        <span class="text-primary text-center">View Details</span>
                    </a>
                </div>

                <div class="widgets w-25 p-1 bg-success d-flex flex-column">
                    <span class="d-flex justify-content-around align-items-center ">
                        <div class="icon">
                            <i class="fa-solid fa-comments"></i>
                        </div>
                        <div class="widget-detail d-flex flex-column align-items-center">
                            <h1 class="mb-0 text-light">
                                <?php
                                //dynamic post count
                                $conn = new db("localhost", "root", "", "cms");
                                $connDB = $conn->getConnection();

                                $sql = "SELECT * FROM `comments`";
                                $result = mysqli_query($connDB, $sql);
                                $comment_count = mysqli_num_rows($result);
                                echo $comment_count;
                                ?>
                            </h1>
                            <h4 class="mb-0 text-light">Comments</h4>
                        </div>
                    </span>
                    <a href="/admin/comments.php">
                        <span class="text-success text-center">View Details</span>
                    </a>
                </div>

                <div class="widgets w-25 p-1 bg-warning d-flex flex-column">
                    <span class="d-flex justify-content-around align-items-center ">
                        <div class="icon">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="widget-detail d-flex flex-column align-items-center">
                            <h1 class="mb-0 text-light">
                                <?php
                                //dynamic post count
                                $conn = new db("localhost", "root", "", "cms");
                                $connDB = $conn->getConnection();

                                $sql = "SELECT * FROM `users`";
                                $result = mysqli_query($connDB, $sql);
                                $users_count = mysqli_num_rows($result);
                                echo $users_count;
                                ?>
                            </h1>
                            <h4 class="mb-0 text-light">Users</h4>
                        </div>
                    </span>
                    <a href="/admin/users.php">
                        <span class="text-warning text-center">View Details</span>
                    </a>
                </div>

                <div class="widgets w-25 p-1 bg-danger d-flex flex-column">
                    <span class="d-flex justify-content-around align-items-center ">
                        <div class="icon">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <div class="widget-detail d-flex flex-column align-items-center">
                            <h1 class="mb-0 text-light">1</h1>
                            <h4 class="mb-0 text-light">Profiles</h4>
                        </div>
                    </span>
                    <a href="/admin/profile.php">
                        <span class="text-danger text-center">View Details</span>
                    </a>
                </div>
            </div>

            <?php
            $sql = "SELECT * FROM `comments` WHERE `comment_status`= 'unapproved'";
            $unapproved_comment_query = mysqli_query($connDB, $sql);
            $unapproved_comment_count = mysqli_num_rows($unapproved_comment_query);


            $sql = "SELECT * FROM `users` WHERE `user_role`= 'admin'";
            $admin_role_query = mysqli_query($connDB, $sql);
            $admin_role_count = mysqli_num_rows($admin_role_query);


            $sql = "SELECT * FROM `posts` WHERE `post_status`= 'draft'";
            $draft_post_query = mysqli_query($connDB, $sql);
            $draft_post_count = mysqli_num_rows($draft_post_query);
            ?>

            <div class="chart mt-4">
                <!-- js of chart -->
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],
                            <?php
                            $text = ['Active-Posts', 'Draft-Posts', 'Active-Users', 'admins', 'Comments', 'Unapproved-Comments'];
                            $counts = [$post_count, $draft_post_count, $users_count, $admin_role_count, $comment_count, $unapproved_comment_count];

                            for ($i = 0; $i < 6; $i++) {
                                echo "['" . $text[$i] . "', " . $counts[$i] . "],";
                            }
                            ?>
                        ]);

                        var options = {
                            chart: {
                                title: '',
                                subtitle: '',
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>

                <!-- html of chart -->
                <div id="columnchart_material" style="width: auto; height: 340px;"></div>

            </div>
        </section>
    </main>


</body>

</html>