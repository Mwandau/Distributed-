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

// Check if the search form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve registration number from the form
    $registrationNumber = $_POST['registration_number'];

    // Search for contact details using the registration number
    $sql = "SELECT * FROM contacts WHERE registration_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $registration_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Contact details found, display them
        while ($row = $result->fetch_assoc()) {
            echo "Mobile Number: " . $row['mobile_number'] . "<br>";
            echo "Email Address: " . $row['email_address'] . "<br>";
            echo "Registration Number: " . $row['registration_number'] . "<br>";
        }
    } else {
        // No contact details found for the given registration number
        echo "No contact details found for the given registration number.";
    }
}

// Close database connection
$conn->close();
