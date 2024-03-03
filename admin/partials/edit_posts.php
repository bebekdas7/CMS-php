<?php
ob_start();
?>

<!-- // Check if db class is not already included -->
<?php
if (!class_exists('db')) {
    include_once "../partials/db.php";
}
?>
<!-- code to get the data of id and show in fields -->
<?php
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    //making db class object
    $conn = new db("localhost", "root", "", "cms");
    $connDB = $conn->getConnection();

    $sql = "SELECT * FROM `posts` WHERE post_id = '$post_id'";
    $result = mysqli_query($connDB, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $post_id = $row['post_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_content = $row['post_content'];
    }
}
?>

<form id="editForm" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="id" class="form-label">Post Id</label>
        <input value="<?php echo $post_id; ?>" type="text" required class="form-control" name="post_id">
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input value="<?php echo $post_title; ?>" type="text" required class="form-control" name="post_title">
    </div>

    <div class="mb-3">
        <label for="author" class="form-label">Author</label>
        <input value="<?php echo $post_author; ?>" type="text" required class="form-control" name="post_author">
    </div>

    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input value="<?php echo $post_date; ?>" type="date" required class="form-control" name="post_date">
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <br>
        <img src="../images/<?php echo $post_image ?>" alt="image" width="100">
        <input type="file" name="post_image">
    </div>

    <div class="mb-3">
        <label for="tags" class="form-label">Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" required class="form-control" name="post_tags">
    </div>

    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Content</label>
        <textarea name="post_content" required class="form-control" cols="30" rows="10">
        <?php echo $post_content; ?>
        </textarea>
    </div>

    <button type="submit" name="edit_post" class="btn btn-primary">Submit</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js">
</script>
<script>
    $(document).ready(function() {
        $('#editForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            jQuery.ajax({
                url: "../../apis/edit_api.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        alert("Post updated successfully");
                        window.location.href = "posts.php";
                    } else {
                        alert("Error in updating post");
                    }
                },
                error: function(response) {
                    alert(response.message);
                }
            });
        });
    });
</script>
<?php
ob_end_flush();
?>