<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Author</th>
            <th scope="col">Title</th>
            <th scope="col">Image</th>
            <th scope="col">Status</th>
            <th scope="col">Tags</th>
            <th scope="col">Comments</th>
            <th scope="col">Date</th>
            <th scope="col">Publish</th>
            <th scope="col">UnPublish</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
            <!-- <th scope="col">operations</th> -->
        </tr>
    </thead>
    <tbody id="tbody">
        <div class="d-flex justify-content-between align-items-center gap-3">
            <div class="d-flex gap-2">
                <input class="form-control input-group" id="search" type="text">
                <button class="btn btn-success" id="search-btn" onclick="searchPost()">Search</button>
            </div>
            <div class="d-flex gap-3 align-items-center">
                <p class="mb-0">Sort by:</p>

                <button class="btn btn-primary" onclick="getPublish()">published</button>
                <a href="#" class="btn btn-primary" onclick="getUnpublish()">unpublished</a>
            </div>
        </div>
        <?php
        include_once "../partials/db.php";
        $conn = new db("localhost", "root", "", "cms");
        $connDB = $conn->getConnection();

        //query to get all the posts from database
        $sql = "SELECT * FROM `posts`";
        $result = mysqli_query($connDB, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $post_id = $row['post_id'];
        ?>
                <tr id="row_<?php echo $row['post_id']; ?>">
                    <th scope="row"><?php echo $row['post_id']; ?></th>
                    <td><?php echo $row['post_author']; ?></td>
                    <td><?php echo $row['post_title']; ?></td>
                    <td><?php echo '<img src="../images/' . $row['post_image'] . '" class="img-responsive" width="60">' ?></td>
                    <td><?php echo $row['post_status']; ?></td>
                    <td><?php echo $row['post_tags']; ?></td>
                    <td><?php
                        $get_comment_query = "SELECT * FROM `comments` WHERE `comment_post_id`={$row['post_id']}";
                        $result_comment = mysqli_query($connDB, $get_comment_query);
                        echo mysqli_num_rows($result_comment);
                        ?></td>
                    <td><?php echo $row['post_date']; ?></td>
                    <td><a href="/admin/posts.php?publish=<?php echo $row['post_id']; ?>">Publish</a></td>
                    <td><a href="/admin/posts.php?draft=<?php echo $row['post_id']; ?>">Unpublish</a></td>
                    <td><a href="posts.php?source=edit_post&id=<?php echo $row['post_id']; ?>">Edit</a></td>
                    <td><a href="#" onclick="deletePost(<?php echo $row['post_id']; ?>)">Delete</a></td>
                </tr>
        <?php
            }
        } else {
            echo "No data Available";
        }
        ?>
    </tbody>
</table>
<?php

if (isset($_GET['publish'])) {
    include "classes.php";
    $publishpost = new post();
    $publishpost->publish_post($_GET['publish']);
}

if (isset($_GET['draft'])) {
    include "classes.php";
    $publishpost = new post();
    $publishpost->unpublish_post($_GET['draft']);
}
?>

<!-- //script here -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- For sorting  -->
<script>
    function getPublish() {
        jQuery.ajax({
            url: "/admin/partials/ajax/ajax_publish_post.php",
            type: "post",
            success: function(data) {
                $("tbody").html(data);
            }
        })
    }

    function getUnpublish() {
        jQuery.ajax({
            url: "/admin/partials/ajax/ajax_unpublish_post.php",
            type: "post",
            success: function(data) {
                $("tbody").html(data);
            }
        })
    }

    // For searching
    function searchPost() {
        $search = $("#search").val();
        jQuery.ajax({
            url: "/admin/partials/ajax/ajax_search_post.php",
            type: "post",
            data: {
                search: $search
            },
            success: function(data) {
                $("tbody").html(data);
            }
        })
    }

    //for deleting post
    function deletePost(id) {
        jQuery.ajax({
            url: "/apis/delete_api.php",
            type: "post",
            data: {
                delete_post: true,
                pid: id
            },
            success: function(response) {
                alert(response.message);
                $("#row_" + id).remove();
            },
            error: function(response) {
                alert(response.message);
            }
        })
    }
</script>