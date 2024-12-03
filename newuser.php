<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userid'];
    $name = $_POST['name'];
    $phone = $_POST['phonenumber'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password_confirm'];

    if ($password !== $passwordConfirm) {
        $errorMessage = "Passwords do not match.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the database
        $sql = "INSERT INTO User (UserId, Name, Phone, Password) VALUES (:userId, :name, :phone, :password)";
        $stmt = $myPdo->prepare($sql);
        $stmt->execute(['userId' => $userId, 'name' => $name, 'phone' => $phone, 'password' => $hashedPassword]);

        $successMessage = "User created successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New User</title>
</head>
<body>
    <h1>Create New User</h1>
    <?php if (isset($errorMessage)) echo "<p style='color:red;'>$errorMessage</p>"; ?>
    <?php if (isset($successMessage)) echo "<p style='color:green;'>$successMessage</p>"; ?>
    <form method="post" action="">
        <label for="userid">User ID:</label>
        <input type="text" id="userid" name="userid" required><br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="phonenumber">Phone Number:</label>
        <input type="text" id="phonenumber" name="phonenumber"><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <label for="password_confirm">Confirm Password:</label>
        <input type="password" id="password_confirm" name="password_confirm" required><br>
        <input type="submit" value="Create User">
    </form>
</body>
</html>
