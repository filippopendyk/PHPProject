<?php
include('db_connection.php');
include('./common/header.php');

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $albumId = $_POST['album_id'];

    $sql = "DELETE FROM Album WHERE Album_Id = :albumId AND Owner_Id = :ownerId";
    $stmt = $myPdo->prepare($sql);
    $stmt->execute(['albumId' => $albumId, 'ownerId' => $userId]);

    $successMessage = "Album deleted successfully!";
}

$sql = "SELECT a.Album_Id, a.Title, a.Description, a.Accessibility_Code, COUNT(p.Picture_Id) AS num_pics 
        FROM Album a 
        LEFT JOIN Picture p ON a.Album_Id = p.Album_Id 
        WHERE a.Owner_Id = :ownerId 
        GROUP BY a.Album_Id, a.Title, a.Description, a.Accessibility_Code";
$stmt = $myPdo->prepare($sql);
$stmt->execute(['ownerId' => $userId]);
$albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1>My Albums</h1>
    <?php if (isset($successMessage)) echo "<p style='color:green;'>$successMessage</p>"; ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Number of Pictures</th>
                <th scope="col">Accessibility</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($albums as $album): ?>
                <tr>
                    <td><?php echo htmlspecialchars($album['Title']); ?></td>
                    <td><?php echo htmlspecialchars($album['Description']); ?></td>
                    <td><?php echo htmlspecialchars($album['num_pics']); ?></td>
                    <td>
                        <?php
                        if ($album['Accessibility_Code'] === 'shared') {
                            echo "Accessible by owner & friends";
                        } elseif ($album['Accessibility_Code'] === 'private') {
                            echo "Accessible by owner";
                        }
                        ?>
                    </td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="album_id" value="<?php echo htmlspecialchars($album['Album_Id']); ?>">
                            <input type="submit" class="btn btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include('./common/footer.php'); ?>