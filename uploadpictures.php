<?php include('./common/header.php'); ?>

<?php
include('db_connection.php');
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

<div class="container mt-5">
    <h1 class="mb-4">Upload Pictures</h1>
    <p>Accepted Pictures types: JPG (JPEG), GIF and PNG</p>
    <p>You can upload multiple pictures at a time by pressing the shift key while selecting pictures</p>
<p>When uploading multiple pictures, the title and description fields will be applied to all pictures</p>
    <?php if (isset($successMessage)) echo "<div class='alert alert-success'>$successMessage</div>"; ?>
    <?php if (isset($errorMessage)) echo "<div class='alert alert-danger'>$errorMessage</div>"; ?>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="album_id" class="form-label">Upload to Album:</label>
            <select id="album_id" name="album_id" class="form-select" required>
                <?php foreach ($albums as $album) { ?>
                    <option value="<?php echo htmlspecialchars($album['Album_Id']); ?>"><?php echo htmlspecialchars($album['Title']); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">File to Upload:</label>
            <input type="file" id="file" name="file" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea id="description" name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Upload Picture</button>
    </form>
</div>

<?php include('./common/footer.php'); ?>