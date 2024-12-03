<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'social_media');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect form data
    $userId = $_POST['userId'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if UserId already exists
    $checkQuery = $conn->prepare("SELECT * FROM User WHERE UserId = ?");
    $checkQuery->bind_param("s", $userId);
    $checkQuery->execute();
    $result = $checkQuery->get_result();

    if ($result->num_rows > 0) {
        $error = "User ID already exists!";
    } else {
        // Insert new user into the database
        $query = $conn->prepare("INSERT INTO User (UserId, Name, Phone, Password) VALUES (?, ?, ?, ?)");
        $query->bind_param("ssss", $userId, $name, $phone, $password);
        if ($query->execute()) {
            header('Location: login.php');
            exit();
        } else {
            $error = "Error: " . $query->error;
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h2>Sign Up</h2>
    <form method="POST">
        <label for="userId">User ID:</label>
        <input type="text" id="userId" name="userId" required><br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone"><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Sign Up</button>
    </form>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
</body>
</html>
