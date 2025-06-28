<?php
require_once __DIR__ . '/db.php';

session_start();

function generateLicenseKey($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

function getFingerprint() {
    return $_COOKIE['fingerprint'] ?? '';
}

function verifyLicense($licenseKey) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare('SELECT * FROM license_keys WHERE license_key = ?');
    $stmt->execute([$licenseKey]);
    $license = $stmt->fetch();
    if (!$license) {
        return ['error' => 'License not found'];
    }
    if ($license['status'] === 'banned') {
        return ['error' => 'License banned'];
    }
    if ($license['status'] === 'expired' || ($license['expires_at'] && strtotime($license['expires_at']) < time())) {
        return ['error' => 'License expired'];
    }
    if ($license['status'] === 'paused') {
        return ['error' => 'License paused'];
    }
    $fingerprint = getFingerprint();
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    if ($license['locked_fingerprint'] && $license['locked_fingerprint'] !== $fingerprint) {
        return ['error' => 'Device mismatch'];
    }
    if ($license['locked_ip'] && $license['locked_ip'] !== $ip) {
        return ['error' => 'IP mismatch'];
    }
    // Lock if not already locked
    if (!$license['locked_fingerprint'] || !$license['locked_ip']) {
        $stmt = $pdo->prepare('UPDATE license_keys SET locked_fingerprint=?, locked_ip=?, last_used_at=NOW() WHERE id=?');
        $stmt->execute([$fingerprint, $ip, $license['id']]);
    } else {
        $stmt = $pdo->prepare('UPDATE license_keys SET last_used_at=NOW() WHERE id=?');
        $stmt->execute([$license['id']]);
    }
    $_SESSION['license_id'] = $license['id'];
    return ['success' => true, 'license' => $license];
}

function requireLicense() {
    if (!isset($_SESSION['license_id'])) {
        header('Location: login.php');
        exit;
    }
}

function requireAdmin() {
    if (!isset($_SESSION['admin_id'])) {
        header('Location: index.php');
        exit;
    }
}
?>
