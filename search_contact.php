<!DOCTYPE html>
<html>

<head>
    <title>Contact Search</title>
</head>

<body>
    <h1>Contact Search</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="registration_number">Enter Registration Number:</label>
        <input type="text" id="registration_number" name="registration_number" required>
        <input type="submit" value="Search">
    </form>
</body>

</html>