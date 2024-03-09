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
$phone_number = $email = $registration_number = "";
$phone_number_error = $email_error = $registration_number_error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate phone number
    if (empty($_POST["Mobile Number"])) {
        $phone_number_error = "Phone number is required";
    } else {
        $phone_number = test_input($_POST["Mobile Number"]);
        // Validate phone number format
        if (!preg_match("/^[0-9]{10}$/", $phone_number)) {
            $phone_number_error = "Invalid phone number format";
        }
    }
    // Validate email address
    if (empty($_POST["Email"])) {
        $email_error = "Email address is required";
    } else {
        $email = test_input($_POST["Email"]);
        // Validate email address format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = "Invalid email address format";
        }
    }
    // Validate registration number
    if (empty($_POST["Registration Number"])) {
        $registration_number_error = "Registration number is required";
    } else {
        $registration_number = test_input($_POST["Registration Number"]);
        // Validate registration number format (customize as needed)
        if (!preg_match("/^[A-Za-z0-9]+$/", $registration_number)) {
            $registration_number_error = "Invalid registration number format";
        }
    }
    // If there are no validation errors, insert contact details into database
    if (empty($phone_number_error) && empty($email_error) && empty($registration_number_error)) {
        // Prepare SQL statement for insertion
        $sql = "INSERT INTO contacts (mobile_number, email_address, registration_number) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $phone_number, $email, $registration_number);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Contact details inserted successfully";
            // Clear form data after successful insertion
            $phone_number = $email = $registration_number = "";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
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
