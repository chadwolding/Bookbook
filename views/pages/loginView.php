<div class="container">
    <!-- Show a success message if user is being redirected from register page. -->
    <?php if (isset($success)) {
        echo '<div class="alert alert-success">' . $success . '</div>';
    }
    ?>
    <div class="jumbotron text-center">
        <h1 class="display-4">Welcome to Bookbook</h1>
        <p class="lead">Social Media With A Focus On Books</p>
    </div>
    <form class="" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
        <h1 class="text-center">Login</h1>
        <div class="form-group row col-sm-4 mx-auto">
            <label for="email">Email</label>
            <input type="text" name="email" id="email"
                   class="form-control <?php if(!empty($loginError)) echo 'is-invalid' ?>"
                   value="<?php if (isset($email)) echo $email ?>">
        </div>
        <div class="form-group row col-sm-4 mx-auto">
            <label for="password">Password</label>
            <input type="password" name="password" id="password"
                   class="form-control <?php if(!empty($loginError)) echo 'is-invalid' ?>">
            <div class="form-control-feedback text-danger"><?php if (!empty($loginError)) echo $loginError ?></div>
        </div>
        <div class="row col-sm-4 mx-auto">
            <button class="btn btn-success m-1" type="submit" name="submit">Login</button>
            <a class="btn m-1 btn-secondary" href="loginController.php">Clear</a>
        </div>
    </form>
</div>

