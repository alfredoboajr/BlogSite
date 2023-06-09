<?php
session_start();

// Check if the user is authenticated
$isAuthenticated = false;

// Check if the password is submitted
if (isset($_POST['password'])) {
    $password = $_POST['password'];  // Replace with your desired password

    // Check if the password is correct
    if (password_verify($password, '$2y$10$SCgHSW.BT0ZcqjsTQKX3neu4Zbw9mC9aDQa77edfU1E0rFvuNDZ26')) {  // Replace the hashed password
        $isAuthenticated = true;
        // Set a session variable to remember the authentication
        $_SESSION['authenticated'] = true;
    }
}

// If not authenticated, display the login form
if (!$isAuthenticated && empty($_SESSION['authenticated'])) {
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Login</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            
            h1 {
                color: #333;
            }
            
            form {
                margin-top: 20px;
            }
            
            input[type="password"] {
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
                font-size: 16px;
                width: 200px;
            }
            
            button[type="submit"] {
                background-color: #2980b9;
                color: #fff;
                border: none;
                padding: 10px 16px;
                border-radius: 4px;
                cursor: pointer;
            }
            
            button[type="submit"]:hover {
                background-color: #1a5276;
            }
        </style>
    </head>
    <body>
        <h1>Login</h1>
        <form method="post" action="contact.php">
            <input type="password" name="password" placeholder="Enter Password">
            <button type="submit">Login</button>
        </form>
    </body>
    </html>';
    exit(); // Stop further execution if not authenticated
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Form Submissions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        td button {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        td button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <h1>Contact Form Submissions</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once 'db_config.php'; // Include database configuration

            // Create a database connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM contacts";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                    echo '<td><form method="post" action="delete_submission.php">';
                    echo '<input type="hidden" name="submission_id" value="' . $row['id'] . '">';
                    echo '<button type="submit">Delete</button>';
                    echo '</form></td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No submissions found.</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
