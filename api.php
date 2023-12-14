<?php
// api.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
// Load configuration
$config = include('config.php');

$host = $config['host'];
$dbname = $config['dbname'];
$username = $config['username'];
$password = $config['password'];

// Attempt to connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if it's a data request or a connection check
if (!isset($_GET['check'])) {
    // Fetch all data if no filters are provided
    if (empty($_GET)) {
        $sql = "SELECT * FROM data";
    } else {
        // Fetch data based on filters
        $endYear = $_GET['end_year'] ?? '';
        $topics = $_GET['topics'] ?? '';
        $sector = $_GET['sector'] ?? '';
        $region = $_GET['region'] ?? '';
        // Add other filters as needed

        $sql = "SELECT * FROM your_table WHERE your_year_column <= :endYear";
        // Add conditions for other filters
    }

    try {
        $stmt = $pdo->prepare($sql);

        // Bind parameters only if they are provided
        if (!empty($_GET)) {
            $stmt->bindParam(':endYear', $endYear, PDO::PARAM_INT);
        }

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($data);
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    // If it's a connection check, return a simple JSON response
    header('Content-Type: application/json');
    echo json_encode(['status' => 'connected']);
}
?>
