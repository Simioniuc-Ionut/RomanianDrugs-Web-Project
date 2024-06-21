<?php

$servername = "127.0.0.1:3307";
$username = "root";
$password = "";


try {
    $dbConnection = new PDO("mysql:host=$servername;dbname=projectdb", $username, $password);

    // set the PDO error mode to exception
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //echo "Connected successfully to database";
} catch (PDOException $e) {
    echo "Connection failed to database: " . $e->getMessage();
}