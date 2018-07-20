<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../connection/connection.php';

require_once '../views/pageStructure/header.php';

//Check to see if session id is set to display certain navbar.
if (isset($_SESSION['uzzzzzer_id'])) {
    require_once '../views/navbars/accountNav.php';
} else {
    require_once '../views/navbars/noAccountNav.php';
}

require_once '../models/accountModel.php';

require_once '../views/pages/accountView.php';

require_once '../views/pageStructure/footer.php';