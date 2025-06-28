<?php
require_once __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = trim($_POST['license_key'] ?? '');
    if (!$key) {
        $error = 'License required';
    } else {
        $result = verifyLicense($key);
        if (isset($result['success'])) {
            header('Location: profile.php');
            exit;
        } else {
            $error = $result['error'];
        }
    }
}
?>
