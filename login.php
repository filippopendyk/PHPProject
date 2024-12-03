<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userid'];
    $password = $_POST['password'];

    $sql = "SELECT Password FROM User WHERE UserId = :userId";
    $stmt = $myPdo->prepare($sql);
    $stmt->execute(['userId' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['Password'])) {
        // Start a new session and redirect to a protected page
        session_start();
        $_SESSION['userId'] = $userId;
        header("Location: myalbums.php");
        exit();
    } else {
        $errorMessage = "Invalid user ID or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($errorMessage)) echo "<p style='color:red;'>$errorMessage</p>"; ?>
    <form method="post" action="">
        <label for="userid">User ID:</label>
        <input type="text" id="userid" name="userid" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
