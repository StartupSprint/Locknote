<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
require_once('db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Locknote - Dashboard</title>
</head>
<body>
    <h1>Welcome to Locknote</h1>
    <a href="logout.php">Logout</a>

    <!-- Add code for displaying and managing notes here -->
</body>
</html>
