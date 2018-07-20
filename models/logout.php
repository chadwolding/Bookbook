<?php
/**
 * Created by PhpStorm.
 * User: GTX770
 * Date: 5/4/2018
 * Time: 2:48 PM
 */
session_start();
unset($_SESSION);
session_destroy();

header('location: ../controllers/loginController.php');