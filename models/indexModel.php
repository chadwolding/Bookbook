<?php

// Get how many posts to show per page.
$postsPerPage = 3;

// Finds out which page we are on.
if(isset($_GET['page']) & !empty($_GET['page'])){
    $currentPage = filter_var($_GET['page'], FILTER_VALIDATE_INT);
    if (!is_integer($currentPage) || $currentPage > 10000 || $_GET['page'] <= 0){
        $currentPage = 1;
        header('location: index.php?page=1');
    }
}

else{
    $currentPage = 1;
}


// Gets what posts to start with to display on page.
$start = ($currentPage-1) * $postsPerPage;

// Get Posts from database to display in page body.
$getPostsQuery = $connection->prepare('SELECT * FROM posts JOIN users ON users.id = posts.user_id WHERE posts.deleted=0 ORDER BY posts.post_id DESC LIMIT :start, :postsPerPage');
$getPostsQuery->bindParam(':start', $start, PDO::PARAM_INT);
$getPostsQuery->bindParam(':postsPerPage', $postsPerPage, PDO::PARAM_INT);
$getPostsQuery->execute();

// Count the number of row on the page.
$numRows = $getPostsQuery->rowCount();

if ($numRows < 1 && $_GET['page'] > 0){ echo
header('location: index.php?page=' . ($currentPage - 1));
    exit();
}


// If no more rows are found, user will be redirected to page 1.
if ($numRows == 0){
    header('location: index.php?page=1');
} ?>
