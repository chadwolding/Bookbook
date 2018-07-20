<div class="container">

    <?php
    // Shows a success message if user created a post.
    if (isset($success)) {
        echo '<div class="alert alert-success">' . $success . '</div>';
    }

    if ($currentPage == 1) {
        echo '<div class="jumbotron text-center">
        <h1 class="display-4">My Circle</h1>
        <p class="lead">See what your friends have been reading</p>
        <a class="btn btn-success" href="newPostController.php">Create Post</a>
        </div>';
    }

    ?>

    <?php

    // Each post will be its own form.
    foreach ($getPostsQuery as $row) {
        echo '
                <form method="post" action="postController.php" class="mb-3 p-3">
                
                <div class="row">
                <div class="col-lg-3">
                <img class="img-responsive p-1" src="../images/posts/' . $row['book_image'] .'" style="max-width: 200px;"> 
                </div>
                <div class="col-lg-8">
                <h3 class="float-lg-right"><img class="img-responsive mr-1" src="../images/users/'. $row['avatar'] .'" style="width: 50px; height: 50px; border-radius: 50%;"> <strong>' . ucwords($row['username']) .'</strong></h3>
                <div class="text-left">
                <h2>'. $row['book_title'] . '</h2>
                <h4>'. $row['book_author'] . '</h4>
                <h6 >Posted: ' . $row['post_date_time'] . ' </h6 >
                <hr>
                <p><strong>' . ucwords($row['username']). '`s thoughts: </strong>'. substr($row['user_post'], 0, 750)  .'...</p>
                </div>
                <h3>' . ucwords($row['username']). '`s Score <strong>' .$row['book_rating'] . '/10</strong></h3>
                <button class="btn btn-info mt-1 float-right" type="submit" name="submit">More</button>
                <input type="hidden" value="'. $row['post_id'] .'" name="post_id">';

        // If a user created a post they can edit the post. This inserts a button to edit.
        if (isset($_SESSION['uzzzzzer_id'])) {
            if ($row['user_id'] == $_SESSION['uzzzzzer_id']) {
                echo '  <input type="hidden" name="id" value="' .$row['id'] . '">
                        ';
            }
        }
        echo '</div>
                </div>
                </form>
                <hr>
                ';
    }

    ?>
    <nav class="mx-auto">
        <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="myCircleController.php?page=<?php if ($currentPage == 1){ echo $currentPage = 1;} else{ echo $currentPage - 1;} ?>">Previous</a></li>
            <li class="page-item"><a class="page-link" href="myCircleController.php?page=<?php echo $currentPage?>"><strong><?php echo $currentPage?></strong></a></li>
            <li class="page-item"><a class="page-link" href="myCircleController.php?page=<?php if ($numRows < $postsPerPage){ echo $_GET['page'];} else{ echo $currentPage + 1;}  ?>">Next</a></li>
        </ul>
    </nav>
</div>