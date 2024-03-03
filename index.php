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
    <link rel="stylesheet" href="./css/hero.css">

    <title>Document</title>
</head>

<body>
    <!-- ----------NAVBAR-------------- -->
    <?php
    include 'partials/nav.php';
    ?>


    <!-- ---------BODY--------------- -->
    <main class="hero-main d-flex ">
        <section class="main px-2 py-4">
            <?php
            //importing connections
            include_once 'partials/db.php';
            $conn = new db("localhost", "root", "", "cms");
            $connDB = $conn->getConnection();

            //sql query to get all the posts
            $sql = "SELECT * FROM `posts` WHERE `post_status`= 'published'";
            $result = mysqli_query($connDB, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="hero mb-5">
                    <a href="/page.php?p_id=<?php echo $row['post_id']; ?>" class="text-decoration-none fs-1 fw-semibold text-primary mb-0"><?php echo $row['post_title']; ?></a>
                    <p class="fw-semibold mb-2">by <span class="text-primary"><?php echo $row['post_author']; ?></span></p>
                    <p class="mb-1"><?php echo $row['post_date']; ?></p>
                    <hr class="w-75">
                    <div class="img-container">
                        <img src="<?php echo 'images/' . $row['post_image'] ?>" class="img-responsive" alt="Post image">
                    </div>
                    <hr class="w-75">
                    <p class="mb-0 w-75"><?php echo substr($row['post_content'], 0, 100); ?>...
                    </p>
                    <button class="btn btn-primary mt-2">Read More</button>
                </div>
            <?php
            }
            ?>
        </section>
        <?php
        include './partials/sidebar.php';
        ?>
    </main>
</body>

</html>
<?php
ob_end_flush();
?>