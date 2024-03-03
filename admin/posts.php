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
            if (isset($_GET['source'])) {
                $source = $_GET['source'];
            } else {
                $source = '';
            }

            //switch statement
            switch ($source) {
                case 'add_post':
                    include "partials/add_post.php";
                    break;

                case 'edit_post':
                    include "partials/edit_posts.php";
                    break;

                default:
                    include "partials/view_all_post.php";
                    break;
            }
            ?>
        </section>
    </main>

</body>

</html>