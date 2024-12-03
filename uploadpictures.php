<?php
include('db_connection.php');
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];

// Handle picture upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $albumId = $_POST['album_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];

    // Define the directory where files will be uploaded
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($fileName);

    // Move the uploaded file to the server's upload directory
    if (move_uploaded_file($fileTmpName, $uploadFile)) {
        // Insert picture details into the database
        $sql = "INSERT INTO Picture (Album_Id, File_Name, Title, Description) VALUES (:albumId, :fileName, :title, :description)";
        $stmt = $myPdo->prepare($sql);
        $stmt->execute(['albumId' => $albumId, 'fileName' => $fileName, 'title' => $title, 'description' => $description]);

        $successMessage = "Picture uploaded successfully!";
    } else {
        $errorMessage = "Failed to upload picture.";
    }
}

// Fetch albums for the dropdown list
$sql = "SELECT Album_Id, Title FROM Album WHERE Owner_Id = :ownerId";
$stmt = $myPdo->prepare($sql);
$stmt->execute(['ownerId' => $userId]);
$albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Pictures</title>
</head>
<body>
    <h1>Upload Pictures</h1>
    <?php if (isset($successMessage)) echo "<p style='color:green;'>$successMessage</p>"; ?>
    <?php if (isset($errorMessage)) echo "<p style='color:red;'>$errorMessage</p>"; ?>
    <form method="post" action="" enctype="multipart/form-data">
        <label for="album_id">Upload to Album:</label>
        <select id="album_id" name="album_id" required>
            <?php foreach ($albums as $album) { ?>
                <option value="<?php echo htmlspecialchars($album['Album_Id']); ?>"><?php echo htmlspecialchars($album['Title']); ?></option>
            <?php } ?>
        </select><br>
        <label for="file">File to Upload:</label>
        <input type="file" id="file" name="file" required><br>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br>
        <input type="submit" value="Upload Picture">
    </form>
</body>
</html>
