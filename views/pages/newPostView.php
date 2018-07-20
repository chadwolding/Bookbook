<div class="container">
    <div class="jumbotron text-center">
        <h1 class="display-4">Create a Post</h1>
        <p class="lead">Tell the world what you have been reading.</p>
    </div>
    <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="" method="post">
        <div class="row">
            <div class="form-group row col-sm-6 mx-auto">
                <label for="title">Book Title</label>
                <input type="text" name="title" id="title"
                       class="form-control <?php if(!empty($titleError)) echo 'is-invalid' ?>"
                       value="<?php if (isset($title)) echo $title ?>">
                <div class="form-control-feedback text-danger"><?php if (!empty($titleError)) echo $titleError ?></div>
            </div>
            <div class="form-group row col-sm-6 mx-auto">
                <label for="author">Book Author</label>
                <input type="text" name="author" id="author"
                       class="form-control <?php if(!empty($authorError)) echo 'is-invalid' ?>"
                       value="<?php if (isset($author)) echo $author ?>">
                <div class="form-control-feedback text-danger"><?php if (!empty($authorError)) echo $authorError ?></div>
            </div>
            <div class="form-group row col-sm-6 mx-auto">
                <label for="image">Book Image</label>
                <input type="file" name="image" id="image"
                       class="form-control <?php if(!empty($imageError)) echo 'is-invalid' ?>"
                       value="<?php if (isset($image)) echo $image ?>">
                <div class="form-control-feedback text-danger"><?php if (!empty($imageError)) echo $imageError ?></div>
            </div>
            <div class="form-group row col-sm-6 mx-auto">
                <label for="rating">Book Rating</label>
                <div class="input-group">
                    <input type="number" name="rating" id="rating" min="0" max="10" step="0.1"
                           class="form-control <?php if(!empty($ratingError)) echo 'is-invalid' ?>"
                           value="<?php if (isset($rating)) echo $rating ?>">
                    <div class="input-group-append">
                        <span class="input-group-text">/10</span>
                    </div>
                </div>
                <div class="form-control-feedback text-danger"><?php if (!empty($ratingError)) echo $ratingError ?></div>
            </div>
            <div class="form-group row col-sm-12 mx-auto">
                <label for="review">My Thoughts/Review</label>
                <textarea type="text" name="review" id="review"
                          class="form-control <?php if(!empty($reviewError)) echo 'is-invalid' ?>" style="min-height: 250px;"><?php if (isset($review)) echo $review ?></textarea>
                <div class="form-control-feedback text-danger"><?php if (!empty($reviewError)) echo $reviewError ?></div>
            </div>
            <div class="row col-sm-12 mx-auto">
                <button class="btn btn-success m-1" type="submit" name="submit">Create Post</button>
                <a class="btn m-1 btn-secondary" href="newPostController.php">Clear</a>
            </div>
        </div>
    </form>
</div>