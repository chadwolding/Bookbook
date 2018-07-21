<?php

// Get the correct profile page.
if (isset($_POST['user_id'])){
    $user_id = $_POST['user_id'];
}
else{
    if (isset($_GET['user'])){
        $userParam = htmlspecialchars($_GET['user']);
        if (strlen($userParam < 30)){

            // Get user Id from param.
            $getUserId = $connection->prepare('SELECT id FROM users WHERE username = :username LIMIT 1');
            $getUserId->bindParam(':username', $userParam);
            $getUserId->execute();
            $getUserIdRow = $getUserId->fetch();

            // If we have a match, set the user id.
            if ($getUserId->rowCount() == 1){
                $user_id = $getUserIdRow['id'];
            }
            else{
                // If someone tries entering an invalid parameter, they are redirected to home page.
                header('location: ../index.php');
            }

        }
    }
    else {
        if (isset($_SESSION['uzzzzzer_id'])) {
            $user_id = $_SESSION['uzzzzzer_id'];
        }
        else{
            header('location: ../index.php');
        }
    }
}

// Get how many posts to show per page.
$postsPerPage = 3;

// Finds out which page we are on.
if(isset($_GET['page']) & !empty($_GET['page'])){
    $currentPage = filter_var($_GET['page'], FILTER_VALIDATE_INT);
    if (!is_integer($currentPage) || $currentPage > 10000 || $currentPage <= 0){
        $currentPage = 1;
        header('location: accountController.php?page=1');
    }
}

else{
    $currentPage = 1;
}

// Gets what posts to start with to display on page.
$start = ($currentPage-1) * $postsPerPage;

// Get all my posts
$getMyPostsQuery = $connection->prepare('SELECT * FROM posts JOIN users ON users.id = posts.user_id WHERE users.id='. $user_id . ' AND posts.deleted=0 ORDER BY posts.post_id DESC  LIMIT :start, :postsPerPage');
$getMyPostsQuery->bindParam(':start', $start, PDO::PARAM_INT);
$getMyPostsQuery->bindParam(':postsPerPage', $postsPerPage, PDO::PARAM_INT);
$getMyPostsQuery->execute();

// Count the number of row on the page.
$numRows = $getMyPostsQuery->rowCount();

// If no more rows are found, user will be redirected to page 1.
if ($numRows == 0){
   // header('location: accountController.php?page=1');
}

//Get account member info.
$getBasicAccountInfo = $connection->prepare('SELECT * FROM users WHERE id=' . $user_id);
$getBasicAccountInfo->execute();
$basicAccountInfo = $getBasicAccountInfo->fetch();

// Get Session ID.
if (isset($_SESSION['uzzzzzer_id'])){
    $session_user_id = $_SESSION['uzzzzzer_id'];
}

// User is updating their avatar.
if (isset($_POST['changeAvatar'])){

    // Create error messages
    $imageError = '';

    // If an image exists
    if (!empty($_FILES['image']['name'])) {
        // Get File info (image for new post).
        $name = $_FILES['image']['name'];
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $size = $_FILES['image']['size'];

// Allow certain file formats.
        if (strtolower($ext) != "jpg" && strtolower($ext) != "png" && strtolower($ext) != "jpeg" || substr_count($name, ".") > 1) {
            $imageError = "Only JPG, JPEG, & PNG files are allowed.";
    }

    // Set image if it exists
    if (!empty($_FILES['image']['name'])) {
        // Get File info (image for new post).
        $image = $_FILES['image']['name'];
    }
    else{
        $image = '';
    }

// Input validation
// Validate image.
    if (empty($image) || strlen($image) > 100){
        $imageError = 'Required';
    }

    // If image valid, update database.
    if (isset($_POST['changeAvatar']) && empty($imageError) && !empty($image)){

        // Upload Image
        move_uploaded_file($_FILES['image']['tmp_name'],  '../images/users/' . basename($_FILES['image']['name']));

        $changeAvatarQuery = $connection->prepare('UPDATE users SET avatar = :avatar WHERE id = :id');
        $changeAvatarQuery->bindParam(':avatar', $image);
        $changeAvatarQuery->bindParam(':id', $_SESSION['uzzzzzer_id']);
        $changeAvatarQuery->execute();

        header('location: accountController.php?successAvatar&user=' . $_SESSION['username']);
    }

    $imageErrorAlert = ' <div class="alert alert-danger">
        There was an error updating your avatar. Please try again.
        </div>';
}

// Get persons account id
$account_id = $basicAccountInfo['id'];

// If the follow button was clicked.
if (isset($_POST['follow_button'])){
    $followQuery = $connection->prepare('INSERT INTO followers (follower_user_id, following_user_id) VALUES (:session_user_id, :account_id)');
    $followQuery->bindParam(':session_user_id', $session_user_id);
    $followQuery->bindParam(':account_id', $account_id);
    $followQuery->execute();
}

// If the unfollow button was clicked.
if (isset($_POST['unfollow_button'])){
    $unfollowQuery = $connection->prepare('DELETE FROM followers WHERE follower_user_id = :session_user_id AND following_user_id = :account_id LIMIT 1');
    $unfollowQuery->bindParam(':session_user_id', $session_user_id);
    $unfollowQuery->bindParam(':account_id', $account_id);
    $unfollowQuery->execute();
}

// Get post info.
$getPostInfo = $connection->prepare('SELECT * FROM posts WHERE user_id=' . $user_id . ' AND deleted=0 ORDER BY post_id DESC');
$getPostInfo->execute();
$postInfo = $getPostInfo->fetchAll();

// Get comment info.
$getCommentInfo = $connection->prepare('Select * FROM comments WHERE commenter_id=' . $user_id . ' AND deleted = 0');
$getCommentInfo->execute();
$commentInfo = $getCommentInfo->fetchAll();

// Get average score
$getAverageScore = $connection->prepare('Select ROUND(AVG(book_rating),2) AS avg FROM posts WHERE deleted=0 AND user_id=' . $user_id);
$getAverageScore->execute();
$averageScore = $getAverageScore->fetch();

// Get follower info for buttons.
$getFollowerInfoQuery = $connection->prepare('SELECT * FROM followers WHERE follower_user_id = :session_user_id AND following_user_id = :account_id LIMIT 1');
$getFollowerInfoQuery->bindParam(':session_user_id', $session_user_id);
$getFollowerInfoQuery->bindParam(':account_id', $account_id);
$getFollowerInfoQuery->execute();

// Get follower count.
$getFollowingCountQuery = $connection->prepare('SELECT DISTINCT COUNT(following_user_id) AS following_count FROM followers WHERE follower_user_id = :account_id');
$getFollowingCountQuery->bindParam(':account_id', $account_id);
$getFollowingCountQuery->execute();
$getFollowingCountQueryResult = $getFollowingCountQuery->fetch();

// Get following count.
$getFollowerCountQuery = $connection->prepare('SELECT DISTINCT COUNT(follower_user_id) AS follower_count FROM followers WHERE following_user_id = :account_id');
$getFollowerCountQuery->bindParam(':account_id', $account_id);
$getFollowerCountQuery->execute();
$getFollowerCountQueryResult = $getFollowerCountQuery->fetch();
$followerResult = $getFollowerInfoQuery->fetch();
