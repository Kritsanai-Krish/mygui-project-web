<?php
require_once __DIR__ . '/core/functions.php';
requireLicense();

$pdo = getDBConnection();
$stmt = $pdo->prepare('SELECT * FROM license_keys WHERE id=?');
$stmt->execute([$_SESSION['license_id']]);
$license = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>License Profile</h2>
    <p>Key: <?=htmlspecialchars($license['license_key'])?></p>
    <p>Status: <?=htmlspecialchars($license['status'])?></p>
    <p>Expires: <?=htmlspecialchars($license['expires_at'])?></p>
    <p>Locked IP: <?=htmlspecialchars($license['locked_ip'])?></p>
    <p>Locked Device: <?=htmlspecialchars($license['locked_fingerprint'])?></p>
    <p><a href="index.php">Go to Menu</a></p>
</div>
</body>
</html>
