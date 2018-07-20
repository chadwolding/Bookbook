<?php

session_start();

//Gets page header.
require_once '../views/pageStructure/header.php';

// Gets database connection.
require_once '../connection/connection.php';

// Get model for login page (validation).
require_once '../models/loginModel.php';

// Nav bar
require_once '../views/navbars/noAccountNav.php';

// Gets page view.
require_once '../views/pages/loginView.php';

// Gets page footer.
require_once '../views/pageStructure/footer.php';