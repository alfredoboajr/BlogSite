<?php
session_start();

// Check if the user is authenticated
if (empty($_SESSION['authenticated'])) {
    // Redirect to the login page
    header("Location: contact.php");
    exit();
}

// Check if the submission ID is provided
if (isset($_POST['submission_id'])) {
    $submissionId = $_POST['submission_id'];

    // Delete the submission from the database
    require_once 'db_config.php'; // Include database configuration

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the DELETE statement using prepared statements
    $sql = "DELETE FROM contacts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $submissionId); // "i" for integer parameter
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Redirect back to contacts.php
        header("Location: contact.php");
        exit();
    } else {
        echo "Error deleting submission.";
    }

    $stmt->close();
    $conn->close();
} else {
    // If submission ID is not provided, redirect back to contacts.php
    header("Location: contact.php");
    exit();
}
