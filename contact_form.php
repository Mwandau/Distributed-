<!DOCTYPE html>
<html>

<head>
    <title>Contact Form</title>
</head>

<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="Mobile Number">Mobile Number:</label>
        <input type="text" id="Mobile Number" name="Mobile Number" value="">
        <br><br>
        <label for="Email">Email:</label>
        <input type="text" id="Email" name="Email" value="">
        <br>
        <br>
        <label for="Registration Number">Registration Number:</label>
        <input type="text" id="Registration Number" name="Registration Number" value="">
        <br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>

</html>