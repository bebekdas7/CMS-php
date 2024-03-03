<?php
ob_start();
?>
<form enctype="multipart/form-data" id="postForm">
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" required class="form-control" name="post_title">
    </div>

    <div class="mb-3">
        <label for="author" class="form-label">Author</label>
        <input type="text" required class="form-control" name="post_author">
    </div>

    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" required class="form-control" name="post_date">
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" required accept=".jpg, .jpeg, .png" class="form-control" name="post_image">
    </div>

    <div class="mb-3">
        <label for="tags" class="form-label">Tags</label>
        <input type="text" required class="form-control" name="post_tags">
    </div>

    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Content</label>
        <textarea name="post_content" required class="form-control" cols="30" rows="10"></textarea>
    </div>

    <button type="submit" name="create_post" class="btn btn-primary">Submit</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js">
</script>
<script>
    $(document).ready(function() {
        $('#postForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '../../apis/post_api.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.success) {
                        alert("Post created successfully");
                        $('#postForm')[0].reset();
                    } else {
                        alert(data.message);
                    }
                },
                error: function(response) {
                    alert("Error occured");
                }
            });
        })
    })
</script>
<?php
ob_end_flush();
?>