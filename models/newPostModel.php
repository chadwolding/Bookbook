<?php

if (isset($_POST['submit'])){

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

// Get File info (image for new post).
$name = $_FILES['image']['name'];
$ext = pathinfo($name, PATHINFO_EXTENSION);
$size = $_FILES['image']['size'];

// Allow certain file formats.
if(strtolower($ext) != "jpg" && strtolower($ext) != "png" && strtolower($ext) != "jpeg" || substr_count($name, ".") > 1) {
    $imageError = "Only JPG, JPEG, & PNG files are allowed.";
}

//Store input values a variables
$title = $_POST['title'];
$author = $_POST['author'];
$image = $_FILES['image']['name'];
$rating = $_POST['rating'];
$review = $_POST['review'];

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
if (empty($image) || strlen($image) > 100){
$imageError = 'Required';
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

if (isset($_POST['submit']) && empty($titleError) && empty($authorError) && empty($imageError) && empty($ratingError) && empty($reviewErrorError)){

    move_uploaded_file($_FILES['image']['tmp_name'],  '../images/posts/' . basename($_FILES['image']['name']));

    $dateTimePosted = new DateTime("now", new DateTimeZone('America/Chicago'));

    $dateTimePosted = $dateTimePosted->format('m/d/Y h:i A');

$createPost = $connection->prepare('INSERT INTO posts (user_id, book_title, book_author, book_rating, user_post, book_image, post_date_time) VALUES (:user_id, :book_title, :book_author, :book_rating, :user_post, :book_image, :post_date_time)');
$createPost->bindParam(':user_id', $user_id);
$createPost->bindParam(':book_title', $title);
$createPost->bindParam(':book_author', $author);
$createPost->bindParam(':post_date_time', $dateTimePosted);
$createPost->bindParam(':book_rating', $rating);
$createPost->bindParam(':user_post', $review);
$createPost->bindParam(':book_image', $image);
$createPost->execute();

header('location: ../index.php?success');
}
}

?>