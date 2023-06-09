<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Redirect to the donation list page if logged in
    header('Location: donation_list.php');
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Replace "your_password" with your desired password
    $password = 'password';

    // Verify the entered password
    if (isset($_POST['password']) && password_verify($_POST['password'], password_hash($password, PASSWORD_DEFAULT))) {
        // Set session variables and redirect to the donation list page
        $_SESSION['loggedin'] = true;
        header('Location: donation_list.php');
        exit;
    } else {
        // Display an error message
        $error = 'Invalid password. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error)) { ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php } ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
