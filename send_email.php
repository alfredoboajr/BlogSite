<?php
// Include the database configuration file
require_once 'db_config.php';

// Get form data
$name = sanitizeInput($_POST['name']);
$email = sanitizeInput($_POST['email']);
$message = sanitizeInput($_POST['message']);

// Set email details
$to = 'barneyisvaccinated@gmail.com';  // Replace with your email address
$subject = 'New Contact Form Submission';
$body = "Name: $name\nEmail: $email\nMessage: $message";
$headers = "From: $email";

try {
    // Create a new PDO instance with prepared statements
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);

    // Execute the prepared statement
    $stmt->execute();

    // Data saved to the database
    if (sendEmail($to, $subject, $body, $headers)) {
        echo '<script>alert("Email sent successfully");</script>';
    } else {
        throw new Exception("Email sending failed");
    }

} catch (Exception $e) {
    echo '<script>alert("An error occurred: ' . $e->getMessage() . '");</script>';
}

// Function to send email using SMTP
function sendEmail($to, $subject, $body, $headers) {
    require_once 'PHPMailer/PHPMailer.php';
    require_once 'PHPMailer/SMTP.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com';  // Replace with your SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = 'your_username';  // Replace with your SMTP username
    $mail->Password = 'your_password';  // Replace with your SMTP password
    $mail->Port = 587;  // Replace with your SMTP port
    $mail->SMTPSecure = 'tls';  // Replace with the appropriate encryption (e.g., ssl or tls)

    $mail->setFrom($headers);
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->Body = $body;

    return $mail->send();
}
?>
