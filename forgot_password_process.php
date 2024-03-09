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
// Initialize variables for form data and error messages
$email = $email_error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email address
    if (empty($_POST["email"])) {
        $email_error = "Email address is required";
    } else {
        $email = test_input($_POST["email"]);
        // Validate email address format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = "Invalid email address format";
        }
    }

    // If there are no validation errors, generate a unique token, store it in the database, and send a reset password email
    if (empty($email_error)) {
        // Generate a unique token
        $token = bin2hex(random_bytes(32));

        // Store the token in the database
        $sql = "INSERT INTO password_reset_tokens (email, token) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $token);
        if ($stmt->execute()) {
            // Send reset password email
            $subject = "Password Reset";
            $message = "To reset your password, click the following link: http://example.com/reset_password.php?token=$token";
            $headers = "From: dmwandau@kabarak.ac.ke";

            if (mail($email, $subject, $message, $headers)) {
                echo "Reset password email sent successfully";
            } else {
                echo "Error sending reset password email";
            }
        } else {
            echo "Error storing reset password token in the database";
        }
    }
}

// Function to sanitize user input
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Close database connection
$conn->close();
