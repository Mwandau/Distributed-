<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and sanitize user input data
$username = $conn->real_escape_string(trim($_POST['username']));
$pasword = $conn->real_escape_string(trim($_POST['password']));
$email = $conn->real_escape_string(trim($_POST['email']));

// Check if all input fields are filled
if (empty($username) || empty($pasword) || empty($email)) {
    echo "All fields are required";
    exit();
}

// Check user already exists
$sql = "SELECT * FROM users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo "user already exists";
    exit();
}

// Check if the email is already taken
$sql = "SELECT * FROM users WHERE Email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo "Email already taken";
    exit();
}

// Insert user data into the database
$sql = "INSERT INTO users (Username, Pasword, Email) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $pasword, $email);
if ($stmt->execute()) {
    echo "User registered successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$stmt->close();
$conn->close();

// Redirect to login page after successful registration
header('Location: login.php');
exit();
