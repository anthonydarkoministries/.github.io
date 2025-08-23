<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// Database configuration
$host = 'localhost';
$dbname = 'website_forms';
$username = 'root';
$password = '';

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin_login.php');
    exit;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query to get all submissions from all tables
    $tables = [
        'giving_submissions' => 'Giving', 
        'membership_submissions' => 'Membership',
        'partnership_submissions' => 'Partnership', 
        'prayer_submissions' => 'Prayer',
        'discipleship_submissions' => 'Discipleship'
    ];
    
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Form Submissions - Anthony Darko Ministries</title>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: #f0f9ff;
                color: #333;
                line-height: 1.6;
                padding: 20px;
            }
            .container {
                max-width: 1200px;
                margin: 0 auto;
                background: white;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                padding: 20px;
            }
            header {
                background: #0d9488;
                color: white;
                padding: 20px;
                border-radius: 8px;
                margin-bottom: 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            h1 {
                margin-bottom: 10px;
            }
            .table-container {
                overflow-x: auto;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 15px 0;
            }
            th, td {
                padding: 12px 15px;
                text-align: left;
                border-bottom: 1px solid #e9ecef;
            }
            th {
                background: #f8f9fa;
                font-weight: 600;
                color: #495057;
            }
            tr:hover {
                background: #f8f9fa;
            }
            .back-btn {
                display: inline-block;
                background: #0d9488;
                color: white;
                padding: 10px 20px;
                border-radius: 5px;
                text-decoration: none;
                margin-top: 20px;
            }
            .back-btn:hover {
                background: #0c7c71;
            }
            .logout-btn {
                background: #dc3545;
                color: white;
                padding: 8px 15px;
                border-radius: 5px;
                text-decoration: none;
            }
            .logout-btn:hover {
                background: #bd2130;
            }
            .admin-bar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <header>
                <div>
                    <h1><i class='fas fa-database'></i> Form Submissions</h1>
                    <p>Anthony Darko Ministries - All Form Data</p>
                </div>
                <a href='?logout=true' class='logout-btn'><i class='fas fa-sign-out-alt'></i> Logout</a>
            </header>
            
            <div class='admin-bar'>
                <div>Welcome, <strong>{$_SESSION['admin_username']}</strong></div>
                <a href='index.php' class='back-btn'><i class='fas fa-arrow-left'></i> Back to Website</a>
            </div>";
    
    foreach ($tables as $table => $name) {
        echo "<h2>" . $name . " Submissions</h2>";
        
        $stmt = $pdo->query("SELECT * FROM $table ORDER BY submission_date DESC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($results) > 0) {
            echo "<div class='table-container'>";
            echo "<table>";
            echo "<tr>";
            // Print headers
            foreach ($results[0] as $key => $value) {
                echo "<th>" . ucfirst(str_replace('_', ' ', $key)) . "</th>";
            }
            echo "</tr>";
            
            // Print data
            foreach ($results as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p>No submissions found in " . $name . " form</p>";
        }
    }
    
    echo "</div></body></html>";
    
} catch (PDOException $e) {
    echo "<div class='container'><h2>Error</h2><p>" . $e->getMessage() . "</p><p>Please check your database connection.</p></div>";
}
?>