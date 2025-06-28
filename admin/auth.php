<?php
require_once __DIR__ . '/../core/functions.php';
requireAdmin();

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}
?>
