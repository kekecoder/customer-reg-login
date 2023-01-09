<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=braze", 'root', 'jerusalem1991');

    $conn->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);
} catch (PDOException $e) {
    echo "Error, unable to connect to the database " . $e->getMessage();
}