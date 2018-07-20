<?php

// Get database connection.
require_once '../connection/connection.php';

// Get the id of the comment to delete.
$comment_id = $_POST['id'];

// Get comment info.
$getCommentQuery = $connection->prepare('SELECT users.username, comments.comment FROM users JOIN comments ON comments.commenter_id = users.id WHERE comments.id = :comment_id LIMIT 1');
$getCommentQuery->bindParam(':comment_id', $comment_id);
$getCommentQuery->execute();

$getCommentRowToDelete = $getCommentQuery->fetch();

// Get Modal Body.
echo '

                
                
                <p>Are you sure you want to delete ' . $getCommentRowToDelete['username'] . '`s comment?</p>
                <p>"' . $getCommentRowToDelete['comment'] . '"</p>
                </div>
                <div class="modal-footer">
                    <form action="postController.php" method="post">
                        <button type="submit" class="btn btn-danger" name="deleteComment">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="hidden" name="comment_id" value="' . $comment_id . '">
                    </form>
';
