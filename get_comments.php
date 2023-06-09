<?php
// Include the database configuration
require_once 'db_config.php';

// Connect to the database
$mysqli = new mysqli($hostname, $username, $password, $database);
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Prepare the query to retrieve comments from the database
$query = "SELECT name, comment, created_at FROM comments ORDER BY id DESC";

// Execute the query
$result = $mysqli->query($query);

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $timestamp = strtotime($row['created_at']);
            $formattedTime = date("F j, Y, g:i a", $timestamp);

            echo '<div class="comment">';
            echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
            echo '<span class="timestamp">' . htmlspecialchars($formattedTime) . '</span>';
            echo '<p>' . htmlspecialchars($row['comment']) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<div class="no-comments">No comments yet.</div>';
    }
} else {
    echo 'Error: ' . $mysqli->error;
}

// Close the database connection
$mysqli->close();
?>
