<?php

// Get how many posts to show per page.
$postsPerPage = 3;

// Finds out which page we are on.
if(isset($_GET['page']) & !empty($_GET['page'])){
    $currentPage = filter_var($_GET['page'], FILTER_VALIDATE_INT);
    if (!is_integer($currentPage) || $currentPage > 10000 || $_GET['page'] <= 0){
        $currentPage = 1;
        header('location: myCircleController.php?page=' . 1);
    }
}
else{
    $currentPage = 1;
}

// Gets what posts to start with to display on page.
$start = ($currentPage-1) * $postsPerPage;

// Get user ID.
if (isset($_SESSION['uzzzzzer_id'])){
    $user_id = $_SESSION['uzzzzzer_id'];
}

// Get Posts from database to display in page body.
$getPostsQuery = $connection->prepare('SELECT * FROM posts JOIN users ON users.id = posts.user_id JOIN followers ON users.id = followers.following_user_id WHERE followers.follower_user_id = :user_id AND posts.deleted=0 ORDER BY posts.post_id DESC LIMIT :start, :postsPerPage');
$getPostsQuery->bindParam(':start', $start, PDO::PARAM_INT);
$getPostsQuery->bindParam(':postsPerPage', $postsPerPage, PDO::PARAM_INT);
$getPostsQuery->bindParam(':user_id', $user_id);
$getPostsQuery->execute();

// Count the number of row on the page.
$numRows = $getPostsQuery->rowCount();


 ?>
