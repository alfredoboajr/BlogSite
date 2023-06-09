<?php
require_once('db_config.php');

// Get the name and comment from the form submission
$name = isset($_POST['name']) ? $mysqli->real_escape_string($_POST['name']) : '';
$comment = isset($_POST['comment']) ? $mysqli->real_escape_string($_POST['comment']) : '';

// Prepare the query using a prepared statement
$query = "INSERT INTO comments (name, comment) VALUES (?, ?)";
$stmt = $mysqli->prepare($query);

// Bind the parameters and execute the statement
$stmt->bind_param("ss", $name, $comment);
if ($stmt->execute()) {
    echo 'Comment posted successfully!';
} else {
    echo 'Error posting comment.';
}

// Close the prepared statement and database connection
$stmt->close();
$mysqli->close();
?>
