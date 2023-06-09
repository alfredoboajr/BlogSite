<?php
require_once 'db_config.php'; // Include database configuration

// Retrieve form data
$paymayaName = $_POST['paymaya_name'];
$ipAddress = $_SERVER['REMOTE_ADDR'];

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO donations (paymaya_name, screenshot, ip_address) VALUES (?, ?, ?)");

    // Bind parameters
    $stmt->bindParam(1, $paymayaName);
    $stmt->bindParam(2, $screenshot);
    $stmt->bindParam(3, $ipAddress);

    // Check if a file was uploaded successfully
    if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] === UPLOAD_ERR_OK) {
        // Set the file name and move it to a secure location
        $fileName = $_FILES['screenshot']['name'];
        $tmpFilePath = $_FILES['screenshot']['tmp_name'];
        $uploadDir = '/path/to/secure/location/'; // Set the secure upload directory
        $destination = $uploadDir . $fileName;
        move_uploaded_file($tmpFilePath, $destination);

        // Update the screenshot parameter with the file name
        $screenshot = $fileName;
    } else {
        // Handle file upload error
        $screenshot = null; // Set the screenshot parameter as null or handle the error accordingly
    }

    // Execute the statement
    $stmt->execute();

    // Close the database connection
    $pdo = null;

    // Redirect to a success page or display a success message
    header('Location: donation_success.html');
    exit;
} catch (PDOException $e) {
    // Handle database errors
    echo "Error: " . $e->getMessage();
}
