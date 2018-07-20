<?php

// If the new user clicks the button to submit their info.
if (isset($_POST['submit'])){

    // Sanitize all inputs.
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

    // Create input error messages.
    $nameError = '';
    $usernameError = '';
    $emailError = '';
    $passwordError = '';
    $confirmPasswordError = '';

    // Post variables from account creation form.
    $fullName = $_POST['fullName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check database to see if account already created.
    $query = $connection->prepare('SELECT username, email FROM users WHERE username = :username OR email = :email LIMIT 1');
    $query->bindParam(':email', $email);
    $query->bindParam(':username', $username);
    $query->execute();

    $result = $query->fetch();

    // Input validation
    // Validate name
    if (strlen($fullName) < 3 || strlen($fullName) > 30){
        $nameError = 'Must be between 3 - 30 characters';
    }

    // Validate username
    if (strlen($username) < 3|| strlen($username) > 20){
        $usernameError = 'Must be between 3 - 20 characters';
    }
    elseif ($result['username'] == $username){
        $usernameError = 'Username already in use';
    }

    // Validate email
    if (!preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/im', $email)){
        $emailError = 'Not a valid email';
    }
    elseif (strlen($email) > 75){
        $emailError = 'Email has too many characters.';
    }
    elseif ($result['email'] == $email){
        $emailError = 'Email already in use';
    }

    // Validate confirm password matches password
    if ($confirmPassword != $password){
        $confirmPasswordError = 'Passwords do not match';
    }

    // Validate password
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/', $password)){
        $passwordError = 'Must be 8 characters long, contain a special character, and contain a number.';
    }
    elseif (strlen($password) > 30){
        $passwordError = 'Password has too many characters';
    }
    else
    {
        // Hash password if it matches our validation
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    // If no error messages exist, we can create the new account and save to database.
    if(empty($nameError) && empty($usernameError) && empty($emailError) && empty($passwordError) && empty($confirmPasswordError)){
        $addUserToDb = $connection->prepare('INSERT INTO users (full_name, email, username, password) VALUES (:fullname, :email, :username, :password)');
        $addUserToDb->bindParam(':fullname', $fullName);
        $addUserToDb->bindParam(':email', $email);
        $addUserToDb->bindParam(':username', $username);
        $addUserToDb->bindParam(':password', $password);
        $addUserToDb->execute();

        header('Location: loginController.php?success');
    }
}

?>