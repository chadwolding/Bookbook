<div class="container">
    <?php

    // Edit post error.
    if (isset($displayError)){
        echo ' 
        <div class="alert alert-danger">
        There was an error editing your post. Please click the edit button again to see the error.
        </div>
        ';
    }

    // Edit post success.
    if (isset($editPostSuccessAlert)){
        echo $editPostSuccessAlert;
    }

    // If comment was successfully added.
    if (isset($_GET['commentSuccess'])){
        echo ' 
        <div class="alert alert-success">
        Your comment has been added.
        </div>
        ';
    }

    // If there is an error adding comment.
    if (isset($commentErrorAlert)){
        echo $commentErrorAlert;
        unset($commentErrorAlert);
    }

    // Shows if comment was removed.
    if (isset($deleteCommentSuccessMessage)) {
        echo $deleteCommentSuccessMessage;
        unset($deleteCommentSuccessMessage);
    }

    // Shows if post was deleted.
    if(isset($deletePostSuccessMessage)){
        echo $deletePostSuccessMessage;
        unset($deletePostSuccessMessage);
    }


    echo '<form class="row mt-5 mb-3" action="accountController.php?user=' . $row['username'] . '&page=1" method="post">
      <div class="col-lg-3" >
      <img class="img-responsive p-1" src = "../images/posts/' . $row['book_image'] . '" style = "max-width: 200px;" >
      </div >
      <div class="col-lg-8" >
      <h3 class="float-lg-right" ><img class="img-responsive mr-1" src = "../images/users/' . $row['avatar'] . '" style = "width: 50px; height: 50px; border-radius: 50%;" > <strong ><button class="btn btn-lg btn-info"  type="submit"> ' . ucwords($row['username']) . ' </button></strong ></h3 >
      <div class="text-left" >
      <h2 > ' . $row['book_title'] . ' </h2 >
      <h4 > ' . $row['book_author'] . ' </h4 >
      <h6 >Posted: ' . $row['post_date_time'] . ' </h6 >
      <h3 class="mt-4 mb-2">' . ucwords($row['username']) . '`s score <strong>' . $row['book_rating'] . '/10</strong></h3>
      <hr >
      <p><strong> ' . ucwords($row['username']) . '`s thoughts: </strong>' . $row['user_post'] . '</p>
      </div>
      </div>
      <input type="hidden" name="user_id" value="' . $row['id'] . '">
      </form>';

    // If the user created the post, there will be an edit and delete button.
    if (isset($_SESSION['uzzzzzer_id']) && $authorResult['user_id'] == $_SESSION['uzzzzzer_id']) {
        echo '<button class="btn btn-warning mt-1 mr-1" type="button" data-toggle="modal" data-target="#editModal">Edit</button>
              <button class="btn btn-danger mt-1 mr-1" type="button" data-toggle="modal" data-target="#deleteModal">Delete</button>
              
        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title">Delete Confirmation</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                Are you sure you want to delete your post on ' . $row['book_title'] . '
              </div>
              <div class="modal-footer">
              <form action="postController.php" method="post">
                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <input type="hidden" name="user_id" value="' . $row['id'] . '">
                <input type="hidden" name="post_id" value="' . $row['post_id'] . '">
                <input type="hidden" name="username" value="' . $row['username'] . '">
                </form>
              </div>
            </div>
          </div>
        </div>
              
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title">Edit Post</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body"> 
                <form enctype="multipart/form-data" action="postController.php" class="" method="post">
        <div class="row">
            <div class="form-group row col-sm-6 mx-auto">
                <label for="title">Book Title</label>
                <input type="text" name="title" id="title"
                       class="form-control ';
        if (!empty($titleError)) echo 'is-invalid';
        echo '"value="' . $title . '">
                <div class="form-control-feedback text-danger">'; if (!empty($titleError)) echo $titleError; echo'</div>
            </div>
            <div class="form-group row col-sm-6 mx-auto">
                <label for="author">Book Author</label>
                <input type="text" name="author" id="author"
                       class="form-control '; if(!empty($authorError)) echo 'is-invalid';
                       echo '"value="' . $author . '">
                <div class="form-control-feedback text-danger">'; if (!empty($authorError)) echo $authorError; echo'</div>
            </div>
            <div class="form-group row col-sm-6 mx-auto">
                <label for="image">Book Image</label>
                <input type="file" name="image" id="image"
                       class="form-control ';
        if(!empty($imageError)) echo 'is-invalid';
                      echo'"value="' . $image . '">
                <div class="form-control-feedback text-danger">'; if (!empty($imageError)) echo $imageError; echo'</div>
            </div>
            <div class="form-group row col-sm-6 mx-auto">
                <label for="rating">Book Rating</label>
                <div class="input-group">
                    <input type="number" name="rating" id="rating" min="0" max="10" step="0.1"
                           class="form-control '; if(!empty($ratingError)) echo 'is-invalid';
                           echo'"value="' . $rating . '">
                    <div class="input-group-append">
                        <span class="input-group-text">/10</span>
                    </div>
                </div>
                <div class="form-control-feedback text-danger">'; if (!empty($ratingError)) echo $ratingError; echo'</div>
            </div>
            <div class="form-group row col-sm-12 mx-auto">
                <label for="review">My Thoughts/Review</label>
                <textarea type="text" name="review" id="review"
                          class="form-control '; if(!empty($reviewError)) echo 'is-invalid';
                          echo'" style="min-height: 35vh;">' . $review . '</textarea>
                <div class="form-control-feedback text-danger">'; if (!empty($reviewError)) echo $reviewError; echo'</div>
            </div>
        </div>
   
                            
              </div>
              <div class="modal-footer">
                <button type="submit" name="edit" class="btn btn-warning">Save changes</button>
                <button type="submit" name="cancelEdit" class="btn btn-secondary">Cancel</button>
                <input type="hidden" name="user_id" value="' . $row['id'] . '">
                <input type="hidden" name="post_id" value="' . $row['post_id'] . '">
                <input type="hidden" name="username" value="' . $row['username'] . '">
                </form>
              </div>
            </div>
          </div>
        </div>      
              ';
    }

    echo '<hr><h2 class="mt-3 mb-4">Comments</h2>';
    if ($getCommentsQuery->rowCount() == 0){
        echo '<h5 class="mb-5">No comments yet</h5>';
    }
    foreach ($getCommentsQuery as $commentRow) {
        //Add edit button for comments.
        if (isset($_SESSION['uzzzzzer_id']) && $_SESSION['uzzzzzer_id'] == $commentRow['commenter_id'] || isset($_SESSION['uzzzzzer_id']) && $_SESSION['uzzzzzer_id'] == $row['user_id']){
            echo '
                    <button class="mt-1 mr-1 deleteComment close float-right" type="button"  id="' . $commentRow['comment_id'] . '" data-toggle="modal" data-target="#deleteCommentModal"><span aria-hidden="true">&times;</span></button>                        
            ';
        }
        echo '
        <div class="row pt-2 pb-2" >
      <div class="col-lg-10" >
      <h4 class="" ><img class="img-responsive mr-1" src = "../images/users/' . $commentRow['avatar'] . '" style = "width: 50px; height: 50px; border-radius: 50%;" > <strong > ' . ucwords($commentRow['username']) . ' </strong ></h4 >
      <div class="text-left" >
      <h6 >Posted: ' . $commentRow['comment_date_time'] . ' </h6 >
      <p >' . $commentRow['comment'] . '</p>
      </div>
      </div>
      </div>';

      echo '
        <hr>
        ';
    }



    if (isset($_SESSION['uzzzzzer_id'])) {
        echo '
            <form class="row mt-3 mb-5" method="post" action="' . $_SERVER['PHP_SELF'] . '">
        <h3>Leave A Comment</h3>
        <div class="form-group col-sm-10">
            <textarea type="text" name="comment" id="comment" style="min-height: 200px;"
                      class="form-control';
        if (!empty($commentError)) echo ' is-invalid';
        echo '"></textarea>
            <div class="form-control-feedback text-danger">';
        if (!empty($commentError)) echo $commentError;
        echo '</div>
            <div class="row mx-auto mt-1">
                <button class="btn btn-success m-1" type="submit" name="submitComment">Comment</button>
                <button class="btn btn-secondary m-1" type="reset">Clear</button>
            </div>
            <input type="hidden" name="post_id" value="' . $post_id . '">
    </form>
        ';
    }
    else{
        echo '
        <h5 class="mt-3 mb-3">Please login or create an account to leave a comment</h5>
        ';
    }
    ?>

    <script>
        $('document').ready( function (){
            $('.deleteComment').click( function (){
                var id = $(this).attr('id');
                $.ajax({
                    url: '../models/getCommentModal.php',
                    data: {id:id},
                    method: 'POST',
                    success: function (data) {
                        $('#deleteCommentModalBody').html(data);
                    }
                });
            });

        });
    </script>

    <!-- Delete Comment Modal THIS WILL GO IN AJAX MODEL-->
    <div class="modal fade" id="deleteCommentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Delete Comment Confirmation</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="deleteCommentModalBody">
                    <!-- AJAX will put comment info here -->
                </div>
            </div>
        </div>
    </div>




</div>
