<?php
session_start();

// Check if the user is authenticated
if (empty($_SESSION['authenticated'])) {
    // Redirect to the login page
    header("Location: contact.php");
    exit();
}

// Create a PDO instance
require_once 'db_config.php'; // Include database configuration

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch donation data from the database
    $stmt = $pdo->query("SELECT * FROM donations");

    // Loop through the rows and display them in the HTML table
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['paymaya_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['screenshot']) . "</td>";
        echo "<td>" . htmlspecialchars($row['ip_address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['donation_timestamp']) . "</td>";
        echo "<td><a href='delete_donation.php?id=" . htmlspecialchars($row['id']) . "'>Delete</a></td>";
        echo "</tr>";
    }

    // Close the database connection
    $pdo = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
