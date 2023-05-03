<?php
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASSWORD = "root";
$DB_NAME = "InterBD";
$DB_PORT = "3306";

// Variáveis do banco remoto
// $DB_HOST = $_ENV["DB_HOST"];
// $DB_USER = $_ENV["DB_USER"];
// $DB_PASSWORD = $_ENV["DB_PASSWORD"];
// $DB_NAME = $_ENV["DB_NAME"];
// $DB_PORT = $_ENV["DB_PORT"];

// Create connection
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, $DB_PORT);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create database
// $sql = "CREATE DATABASE inter_teste";
// if ($conn->query($sql) === TRUE) {
//   echo "Database created successfully";
// } else {
//   echo "Error creating database: " . $conn->error;
// }

// $conn->close();
?>