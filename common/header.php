<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Course Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo dirname($_SERVER['SCRIPT_NAME']) . '/styles.css'; ?>"/>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark m">
  <div class="container-fluid">
    <a class="navbar-brand" href=""/><img class="navbar-img" src="<?php echo dirname($_SERVER['SCRIPT_NAME']) . '/assets/logo.png'; ?>"/></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="Index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">My Friends</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="myalbums.php">My Albums</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">My Pictures</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="uploadpictures.php">Upload Pictures</a>
        </li>
        <?php if (isset($_SESSION['userId'])): ?>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Log Out</a>
        </li>
        <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Log In</a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
