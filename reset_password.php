<?php
// Simulate password reset by sending email (you should implement this functionality)
$email = $_POST['email'];
$message = "Your password reset link: http://example.com/reset.php?email=$email";
// Send email
mail($email, "Password Reset", $message);
// Redirect back to login page with success message
header('Location: login.php?reset=1');
exit;
