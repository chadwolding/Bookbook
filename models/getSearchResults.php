<?php
/**
 * Created by PhpStorm.
 * User: GTX770
 * Date: 5/4/2018
 * Time: 4:50 PM
 */

require_once '../connection/connection.php';

// The string to search for.
$searchString = filter_var($_POST['searchItems'], FILTER_SANITIZE_STRING);

$searchQuery = $connection->prepare("SELECT * FROM posts WHERE book_title LIKE '%$searchString%' ORDER BY book_title ASC");
$searchQuery->bindParam(':searchString', $searchString);
$searchQuery->execute();

$result = '';

foreach ($searchQuery as $row){
    echo $row['book_title'];
}