<?php

// Checks to see if a user is being redirected from creating an account. Will show a success message if true.
if (isset($_GET['success'])) {
    $success = '<strong>Success!</strong> You may login to your account.';
}

// If user clicks the login button.
if (isset($_POST['submit'])){

    //Create login error message.
    $loginError = '';

    // Sanitize inputs.
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

    // Store input values as variables.
    $email = $_POST['email'];
    $password =  $_POST['password'];

    // Check to see if inputs are not empty.
    if (!empty($email) && !empty($password)){
        $checkDbForAccount = $connection->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $checkDbForAccount->bindParam(':email', $email);
        $checkDbForAccount->execute();

        // If we get a matching result in the database.
        if ($checkDbForAccount->rowCount() == 1){

            // Get query result
            $result = $checkDbForAccount->fetch();

            if (password_verify($password, $result['password'])){
                $_SESSION['uzzzzzer_id'] = $result['id'];
                $_SESSION['username'] = $result['username'];

                header('location: ../index.php?page=1');
            }
            else{
                $loginError = 'Incorrect email or password. Please try again';
            }
        }
        else{
            $loginError = 'Incorrect email or password. Please try again';
        }

    }
    else{
        // If inputs are empty.
        $loginError = 'Please enter an email and password';
    }
}

?>