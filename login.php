<?php
require_once __DIR__ . '/core/verify_license.php';
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>License Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/fingerprint2.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        if (!document.cookie.includes('fingerprint')) {
            Fingerprint2.getV18({}, (result) => {
                document.cookie = 'fingerprint=' + result + '; path=/; max-age=' + (60*60*24*365);
            });
        }
    });
    </script>
</head>
<body>
<div class="container">
    <h2>Enter License Key</h2>
    <?php if(!empty($error)): ?>
        <p style="color:red;"><?=htmlspecialchars($error)?></p>
    <?php endif; ?>
    <form method="post" action="login.php">
        <input type="text" name="license_key" placeholder="License Key" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
