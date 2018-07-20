<?php
// Gets database connection.
require_once 'connection/connection.php';

// Gets the page header.
require_once 'views/pageStructure/header.php';

session_start();

//Check to see if session id is set to display certain navbar.
if (isset($_SESSION['uzzzzzer_id'])) {
    require_once 'views/navbars/accountIndexNav.php';
} else {
    require_once 'views/navbars/noAccountIndexNav.php';
}

// Creates a success message if a user created a post.
if (isset($_GET['success'])) {
    $success = '<strong>Success!</strong> Your post has been created.';
}

// Gets index model.
require_once 'models/indexModel.php';

// Get page body view.
require_once 'views/pages/indexView.php';

// Gets the page footer.
require_once 'views/pageStructure/footer.php';