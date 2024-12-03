<?php
include('db_connection.php');
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $accessibility = $_POST['accessibility'];
    $description = $_POST['description'];
    $ownerId = $_SESSION['userId'];

    $sql = "INSERT INTO Album (Title, Description, Owner_Id, Accessibility_Code) VALUES (:title, :description, :ownerId, :accessibility)";
    $stmt = $myPdo->prepare($sql);
    $stmt->execute(['title' => $title, 'description' => $description, 'ownerId' => $ownerId, 'accessibility' => $accessibility]);

    $successMessage = "Album added successfully!";
}

// Fetch accessibility options for the dropdown list
$sql = "SELECT Accessibility_Code, Description FROM Accessibility";
$stmt = $myPdo->prepare($sql);
$stmt->execute();
$accessibilities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include('./common/header.php'); ?>

    <h1>Add Album</h1>
    <?php if (isset($successMessage)) echo "<p style='color:green;'>$successMessage</p>"; ?>
    <form method="post" action="">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>
        <label for="accessibility">Accessibility:</label>
        <select id="accessibility" name="accessibility" required>
            <?php foreach ($accessibilities as $accessibility) { ?>
                <option value="<?php echo htmlspecialchars($accessibility['Accessibility_Code']); ?>"><?php echo htmlspecialchars($accessibility['Description']); ?></option>
            <?php } ?>
        </select><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br>
        <input type="submit" value="Add Album">
    </form>

<?php include('./common/footer.php'); ?>
