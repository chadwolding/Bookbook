<?php

// Get the right post to display.
if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
}
elseif(isset($_GET['post'])){

    // Store post to show as variable.
    $post = htmlspecialchars($_GET['post']);

    // Validate get
    if (strlen($post)  < 6 && filter_var($post, FILTER_VALIDATE_INT) == true) {
        $post_id = $_GET['post'];
    }
    else{
       header('location: ../index.php?page=1');
    }
}
else{
    header('location: ../index.php?page=1');
}

// If a user clicks delete on a comment and there is a comment id, delete the comment.
if (isset($_POST['deleteComment']) && isset($_POST['comment_id'])){

    // Get comment id.
    $comment_id = $_POST['comment_id'];

    // Update database, set delete indicator.
    $deleteCommentQuery = $connection->prepare('UPDATE comments SET deleted = 1 WHERE id = :comment_id');
    $deleteCommentQuery->bindParam(':comment_id', $comment_id);
    $deleteCommentQuery->execute();

    $deleteCommentSuccessMessage = '<div class="alert alert-success">The comment has been removed.</div>';
}


// If editing a post
if (isset($_POST['edit'])){

// Get user id to save to database.
    $user_id = $_SESSION['uzzzzzer_id'];

//Sanitize inputs
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

// Create error messages
    $titleError = '';
    $authorError = '';
    $imageError = '';
    $ratingError = '';
    $reviewError = '';

//Store input values a variables
    $title = $_POST['title'];
    $author = $_POST['author'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    $username = $_POST['username'];

    // Set image if it exists
    if (!empty($_FILES['image']['name'])) {
        // Get File info (image for new post).
        $image = $_FILES['image']['name'];
    }
    else{
        $image = '';
    }

// Input validation
// Validate title
    if (empty($title) || strlen($title) > 30){
        $titleError = 'Must be between 1 - 30 characters';
    }

// Validate author.
    if (empty($author) || strlen($author) > 50){
        $authorError = 'Must be between 1 - 50 characters';
    }

// Validate image.
    if (strlen($image) > 100){
        $imageError = 'Please try a different image';
    }

// Validate rating
    if (empty($rating) || $rating < 0 || $rating > 10){
        $ratingError = 'Must be between 1 - 10';
    }
    elseif (strlen($rating) > 4){
        $ratingError = 'Must be less than 4 characters';
    }

// Validate Review
    if (empty($review) || strlen($review) > 15000){
        $reviewError = 'Must be less than 15000 characters';
    }


    if (isset($_POST['edit']) && empty($titleError) && empty($imageError) && empty($authorError) && empty($ratingError) && empty($reviewErrorError)){

        $updatePost = $connection->prepare('UPDATE posts SET user_id=:user_id, book_title=:book_title, book_author=:book_author, book_rating=:book_rating, user_post=:user_post WHERE post_id = :post_id');
        $updatePost->bindParam(':user_id', $user_id);
        $updatePost->bindParam(':book_title', $title);
        $updatePost->bindParam(':book_author', $author);
        $updatePost->bindParam(':book_rating', $rating);
        $updatePost->bindParam(':user_post', $review);
        $updatePost->bindParam(':post_id', $post_id);
        $updatePost->execute();

        if (!empty($_FILES['image']['name'])) {

            // Upload Image
            move_uploaded_file($_FILES['image']['tmp_name'],  '../images/posts/' . basename($_FILES['image']['name']));

            // Update image.
            $updatePostImage = $connection->prepare('UPDATE posts SET book_image = :book_image WHERE post_id = :post_id');
            $updatePostImage->bindParam(':book_image', $image);
            $updatePostImage->bindParam(':post_id', $post_id);
            $updatePostImage->execute();

        }

        $editPostSuccessAlert = '<div class="alert alert-success">
        Your changes have been saved.
        </div>';

        if (isset($displayError)){
            unset($displayError);
        }

    }
    else{
        $displayError = true;
    }

}


// Get Username for redirect
if (isset($_POST['username'])){
    $username = $_POST['username'];
}

// If the user confirms deleting of post.
if (isset($_POST['delete'])){
    $deletePostQuery = $connection->prepare('UPDATE posts SET deleted = 1 WHERE post_id = :post_id');
    $deletePostQuery->bindParam(':post_id', $post_id);
    $deletePostQuery->execute();

    // Delete post comments.
    $deletePostComments = $connection->prepare('UPDATE comments SET deleted=1 WHERE post_id = :post_id');
    $deletePostComments->bindParam(':post_id', $post_id);
    $deletePostComments->execute();

     header('location: accountController.php?success&user=' . $username);
    exit();
}

// Get post author id.
$getPostAuthorQuery = $connection->prepare('SELECT user_id FROM posts WHERE post_id = :post_id');
$getPostAuthorQuery->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$getPostAuthorQuery->execute();

$authorResult = $getPostAuthorQuery->fetch();

// If user submits comment.
if (isset($_POST['submitComment'])){

    // Create comment error message.
    $commentError = '';

    // Sanitize textarea
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

    // Store text in variable.
    $comment = $_POST['comment'];

    // Validate comment.
    if (empty($comment)){
        $commentError = 'Please enter a comment';
    }
    if (strlen($comment) > 5000){
        $commentError = 'Comment is too long';
    }

    if (empty($commentError)){

        $dateTimeCommentPosted = new DateTime("now", new DateTimeZone('America/Chicago'));

        $dateTimeCommentPosted = $dateTimeCommentPosted->format('m/d/Y h:i A');

        // Add comment to database.
        $addCommentQuery = $connection->prepare('INSERT INTO comments (commenter_id, post_id, post_author_id, comment, comment_date_time) VALUES (:commenter_id, :post_id, :post_author_id, :comment, :date_time)');
        $addCommentQuery->bindParam('commenter_id', $_SESSION['uzzzzzer_id'], PDO::PARAM_INT);
        $addCommentQuery->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $addCommentQuery->bindParam(':post_author_id', $authorResult['user_id'], PDO::PARAM_INT);
        $addCommentQuery->bindParam(':date_time', $dateTimeCommentPosted);
        $addCommentQuery->bindParam(':comment', $comment);
        $addCommentQuery->execute();

        header('location: postController.php?commentSuccess&post=' . $post_id);
    }

    $commentErrorAlert = '<div class="alert alert-danger">
        There was an error adding your comment. Please try again.
        </div>';
}


// Get Post from database to display in page body.
    $getPostQuery = $connection->prepare('SELECT * FROM posts JOIN users ON users.id = posts.user_id WHERE posts.post_id = :post_id AND posts.deleted=0 LIMIT 1');
    $getPostQuery->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $getPostQuery->execute();

    $row = $getPostQuery->fetch();

    if ($getPostQuery->rowCount() == 0){
        header('location: ../index.php?page=1');
    }

// Get Post Comments from database to display in page body.
    $getCommentsQuery = $connection->prepare('SELECT posts.*, comments.*, users.id, users.username, users.avatar, comments.id as comment_id FROM posts JOIN comments ON posts.post_id = comments.post_id JOIN users ON users.id = comments.commenter_id WHERE comments.post_id = :post_id AND comments.deleted=0 ORDER By comments.id DESC');
    $getCommentsQuery->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $getCommentsQuery->execute();

    // Gets current value on first modal load.
    if (!isset($title)){
        $title = $row['book_title'];
    }
    if (!isset($author)){
        $author = $row['book_author'];
    }
    if (!isset($image)){
        $image = $row['book_image'];
    }
    if (!isset($rating)){
        $rating = $row['book_rating'];
    }
    if (!isset($review)){
        $review = $row['user_post'];
    }
    if (!isset($usernmae)){
        $username = $row['username'];
    }


// Reset edit modal if cancel button is clicked.
if (isset($_POST['cancelEdit'])){
    $title = $row['book_title'];
    $author = $row['book_author'];
    $image = $row['book_image'];
    $rating = $row['book_rating'];
    $review = $row['user_post'];
    $username = $row['username'];
}
