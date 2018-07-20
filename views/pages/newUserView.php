<div class="container">
    <div class="jumbotron text-center">
        <h1 class="display-4">Welcome to Bookbook</h1>
        <p class="lead">Social Media With A Focus On Books</p>
    </div>
    <form class="" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
        <h1 class="text-center">Create Account</h1>
        <div class="form-group row col-sm-6 mx-auto">
            <label for="fullName">Full Name</label>
            <input type="text" name="fullName" id="fullName" class="form-control <?php if(!empty($nameError)) echo 'is-invalid' ?>"  value="<?php if(isset($fullName)) echo $fullName ?>">
            <div class="form-control-feedback text-danger"><?php if(!empty($nameError)) echo $nameError ?></div>
        </div>
        <div class="form-group row col-sm-6 mx-auto">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control <?php if(!empty($usernameError)) echo 'is-invalid' ?>"  value="<?php if(isset($username)) echo $username ?>">
            <div class="form-control-feedback text-danger"><?php if(!empty($usernameError)) echo $usernameError ?></div>
        </div>
        <div class="form-group row col-sm-6 mx-auto">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control <?php if(!empty($emailError)) echo 'is-invalid' ?>" value="<?php if(isset($email)) echo $email ?>">
            <div class="form-control-feedback text-danger"><?php if(!empty($emailError)) echo $emailError ?></div>
        </div>
        <div class="form-group row col-sm-6 mx-auto">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control <?php if(!empty($passwordError)) echo 'is-invalid' ?>">
            <div class="form-control-feedback text-danger"><?php if(!empty($passwordError)) echo $passwordError ?></div>
        </div>
        <div class="form-group row col-sm-6 mx-auto">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control <?php if(!empty($confirmPasswordError)) echo 'is-invalid' ?>">
            <div class="form-control-feedback text-danger"><?php if(!empty($confirmPasswordError)) echo $confirmPasswordError ?></div>
        </div>
        <div class="row col-sm-6 mx-auto">
            <button class="btn btn-success m-1" type="submit" name="submit">Create Account</button>
            <a class="btn m-1 btn-secondary" href="newUserController.php">Clear</a>
        </div>
    </form>
</div>