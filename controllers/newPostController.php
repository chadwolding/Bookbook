<?php
session_start();

if (!isset($_SESSION['uzzzzzer_id'])){
    header('location loginController.php');
    exit();
}

require_once '../views/pageStructure/header.php';

require_once '../views/navbars/accountNav.php';

require_once '../connection/connection.php';

require_once '../models/newPostModel.php';

require_once '../views/pages/newPostView.php';

require_once '../views/pageStructure/footer.php';