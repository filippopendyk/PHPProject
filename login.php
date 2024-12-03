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

<?php include('./common/header.php'); ?>

<div class="container mt-5">
    <h1 class="mb-4">Login</h1>
    <?php if (isset($errorMessage)) echo "<div class='alert alert-danger'>$errorMessage</div>"; ?>
    <form method="post" action="">
        <div class="mb-3">
            <label for="userid" class="form-label">User ID:</label>
            <input type="text" id="userid" name="userid" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<?php include('./common/footer.php'); ?>