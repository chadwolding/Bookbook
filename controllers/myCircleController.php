<?php
session_start();

if (!isset($_SESSION['uzzzzzer_id'])){
    header('location loginController.php');
    exit();
}

require_once '../connection/connection.php';

require_once '../views/pageStructure/header.php';

//Check to see if session id is set to display certain navbar.
if (isset($_SESSION['uzzzzzer_id'])) {
    require_once '../views/navbars/accountNav.php';
} else {
    require_once '../views/navbars/noAccountNav.php';
}

require_once '../models/myCircleModel.php';

require_once '../views/pages/myCircleView.php';

require_once '../views/pageStructure/footer.php';