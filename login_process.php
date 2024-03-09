<?php

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve username and password from the login form
$username_input = mysqli_real_escape_string($conn, $_POST['username']);
$password_input = $_POST['password'];

// SQL statement to retrieve user data
$sql = "SELECT username, pasword FROM users WHERE username =?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username_input);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists in the database
if ($result->num_rows > 0) {
    // User exists, retrieve stored password
    $user = $result->fetch_assoc();
    $stored_password = $user['pasword'];

    echo "Input Password: " . $password_input . "<br>"s;
    echo "Stored Password: " . $stored_password . "<br>";
    // Verify password
    if ($password_input === $stored_password) {
        // Passwords match, user is authenticated
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username_input;

        header('Location: contact_form.php');
    } else {
        // Passwords do not match
        echo "Incorrect password. Please try again or click forgot password";
    }
} else {
    // User does not exist
    echo "User not found. Please check your username.";
}

// Close database connection
$conn->close();
