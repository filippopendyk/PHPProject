<?php
include('db_connection.php');
include('./common/header.php');

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

<div class="container mt-5">
    <h1 class="mb-4">Create New User</h1>
    <?php if (isset($errorMessage)) echo "<div class='alert alert-danger'>$errorMessage</div>"; ?>
    <?php if (isset($successMessage)) echo "<div class='alert alert-success'>$successMessage</div>"; ?>
    <form method="post" action="">
        <div class="mb-3">
            <label for="userid" class="form-label">User ID:</label>
            <input type="text" id="userid" name="userid" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="phonenumber" class="form-label">Phone Number:</label>
            <input type="text" id="phonenumber" name="phonenumber" class="form-control">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password_confirm" class="form-label">Confirm Password:</label>
            <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>

<?php include('./common/footer.php'); ?>
