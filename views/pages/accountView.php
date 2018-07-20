<div class="container">
    <?php
    //Display success message if post was deleted.
    if (isset($_GET['success'])) {
        echo '<div class="alert alert-success">Your post has been removed.</div>';
    }
    //Display success message if post was deleted.
    if (isset($_GET['successAvatar'])) {
        echo '<div class="alert alert-success">Your avatar has been changed.</div>';
    }

    //Display avatar change error.
    if (isset($imageErrorAlert)) {
        echo $imageErrorAlert;
    }


    if (isset($_POST['follow_button'])){
        echo '<div class="alert alert-success">' . ucwords($basicAccountInfo['username']) . ' is now in your circle.</div>';
    }
    if (isset($_POST['unfollow_button'])){
        echo '<div class="alert alert-success">' . ucwords($basicAccountInfo['username']) . ' has left your circle.</div>';
    }

    ?>
    <div class="jumbotron text-center">
        <h1 class="text-center mb-4 mt-1"><?php echo ucwords($basicAccountInfo['username']); ?>'s Profile</h1>
        <img class="img-responsive d-block mx-auto mb-1 mt-2" src="../images/users/<?php echo $basicAccountInfo['avatar']; ?>"
             style="border-radius: 10px; height: 200px; width: 200px;">
        <?php if (isset($_SESSION['uzzzzzer_id']) && $_SESSION['uzzzzzer_id'] == $basicAccountInfo['id']){
            echo '<button class="btn btn-warning mt-1 mr-1" type="button" data-toggle="modal" data-target="#changeAvatarModal">Change Avatar</button>';
        }  ?>
        <?php
        // Check if we are already following the user.
        if (isset($_SESSION['uzzzzzer_id']) && $_SESSION['uzzzzzer_id'] != $basicAccountInfo['id'] && $_SESSION['uzzzzzer_id'] != $followerResult['follower_user_id'])
        {
            echo '<form action="accountController.php?user=' . $basicAccountInfo['username'] . '" method="Post"><button name="follow_button" class="btn-lg btn btn-info m-3">Follow</button></form>';
        }

        // Display this if not already following the user
        if (isset($_SESSION['uzzzzzer_id']) && $_SESSION['uzzzzzer_id'] != $basicAccountInfo['id'] && $_SESSION['uzzzzzer_id'] == $followerResult['follower_user_id'])
        {
            echo '<form action="accountController.php?user=' . $basicAccountInfo['username'] . '" method="Post"><button name="unfollow_button" class="btn-lg btn btn-warning m-3">Unfollow</button></form>';
        }
        ?>
        <div class="row mt-3">
            <div class="col-md-4 text-center mb-3">
                <h2><strong>Recent Book</strong><br> <?php if (isset($postInfo[0]['book_title'])) echo $postInfo[0]['book_title']; else{ echo '';} ?></h2>
            </div>
            <div class="col-md-4 text-center mb-3">
                <h2><strong>Post Count</strong><br> <?php echo $getPostInfo->rowCount(); ?></h2>
            </div>
            <div class="col-md-4 text-center mb-3">
                <h2><strong>Comment Count</strong><br> <?php echo $getCommentInfo->rowCount(); ?></h2>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4 text-center mb-3">
                <h2><strong>Following</strong><br> <?php echo $getFollowingCountQueryResult['following_count']; ?></h2>
            </div>
            <div class="col-md-4 text-center mb-3">
                <h2><strong>Followers</strong><br> <?php echo $getFollowerCountQueryResult['follower_count']; ?></h2>
            </div>
            <div class="col-md-4 text-center mb-3">
                <h2><strong>Average Review</strong><br> <?php echo $averageScore['avg']; ?></h2>
            </div>
        </div>
    </div>

    <h1 class="text-center mt-2 mb-3"><?php if (isset($_SESSION['uzzzzzer_id']) && $_SESSION['uzzzzzer_id'] == $basicAccountInfo['id']){ echo 'My Posts';} else{ echo ucwords($basicAccountInfo['username']) . '`s Profile';}  ?></h1>
    <hr>
    <?php
    foreach ($getMyPostsQuery as $row) {
        echo '
                <form method="post" action="postController.php" class="mb-3 p-3">
                
                <div class="row">
                <div class="col-lg-3">
                <img class="img-responsive p-1" src="../images/posts/' . $row['book_image'] . '" style="max-width: 200px;"> 
                </div>
                <div class="col-lg-8">
                <h3 class="float-lg-right"><img class="img-responsive mr-1" src="../images/users/' . $row['avatar'] . '" style="width: 50px; height: 50px; border-radius: 50%;"> <strong>' . ucwords($row['username']) . '</strong></h3>
                <div class="text-left">
                <h2>' . $row['book_title'] . '</h2>
                <h4>' . $row['book_author'] . '</h4>
                <h6 >Posted: ' . $row['post_date_time'] . ' </h6 >
                <hr>
                <p><strong>' . ucwords($row['username']) . '`s thoughts: </strong>' . substr($row['user_post'], 0, 750)  .'...</p>
                </div>
                <h3>' . ucwords($row['username']) . '`s Score <strong>' . $row['book_rating'] . '/10</strong></h3>
                <button class="btn btn-info mt-1 float-right" type="submit" name="submit">More</button>
                <input type="hidden" value="' . $row['post_id'] . '" name="post_id">';

        // If a user created a post they can edit the post. This inserts a button to edit.
//        if (isset($_SESSION['uzzzzzer_id'])) {
//            if ($row['uzzzzzer_id'] == $_SESSION['uzzzzzer_id']) {
//                echo '<input type="hidden" name="id" value="' . $row['id'] . '">
//                        ';
//            }
//        }
        echo '</div>
                </div>
                </form>
                <hr>
                ';
    }

    ?>

    <!-- Change Avatar Modal -->
    <div class="modal fade" id="changeAvatarModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Change Avatar</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  enctype="multipart/form-data" action="accountController.php" method="post">
                        <label for="image">Avatar</label>
                        <input type="file" name="image" id="image"
                               class="form-control <?php if(!empty($imageError)) echo 'is-invalid' ?>"
                               value="<?php if (isset($image)) echo $image ?>">
                        <div class="form-control-feedback text-danger"><?php if (!empty($imageError)) echo $imageError ?></div>
                </div>
                <div class="modal-footer">
                        <button type="submit" class="btn btn-warning" name="changeAvatar">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <nav class="mx-auto">
        <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="accountController.php?user=<?php echo $basicAccountInfo['username'] ?>&page=<?php if ($currentPage == 1) {
                    echo $currentPage = 1;
                } else {
                    echo $currentPage - 1;
                } ?>">Previous</a></li>
            <li class="page-item"><a class="page-link"
                                     href="accountController.php?user=<?php echo $basicAccountInfo['username'] ?>&page=<?php echo $currentPage ?>"><strong><?php echo $currentPage ?></strong></a>
            </li>
            <li class="page-item"><a class="page-link" href="accountController.php?user=<?php echo $basicAccountInfo['username'] ?>&page=<?php if ($numRows < $postsPerPage) {echo $currentPage;} else {echo $currentPage + 1;} ?>">Next</a></li>
        </ul>
    </nav>

</div>
