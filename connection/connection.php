<?php
try {
    $connection = new PDO("mysql:host=localhost;dbname=Bookbook", 'cwolding', 'ChWo3433');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $ex) {
    echo "error " . $ex->getMessage();
}