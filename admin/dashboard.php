<?php
require_once __DIR__ . '/../core/functions.php';
requireAdmin();
$pdo = getDBConnection();

// Handle create
if (isset($_POST['action']) && $_POST['action'] === 'create') {
    $expires = $_POST['expires'] ? date('Y-m-d H:i:s', strtotime($_POST['expires'])) : null;
    $key = generateLicenseKey();
    $stmt = $pdo->prepare('INSERT INTO license_keys (license_key, expires_at, created_by) VALUES (?, ?, ?)');
    $stmt->execute([$key, $expires, $_SESSION['admin_id']]);
}

// Handle delete, ban, pause, resume, reset
if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    switch ($_POST['action']) {
        case 'delete':
            $pdo->prepare('DELETE FROM license_keys WHERE id=?')->execute([$id]);
            break;
        case 'ban':
            $pdo->prepare("UPDATE license_keys SET status='banned' WHERE id=?")->execute([$id]);
            break;
        case 'pause':
            $pdo->prepare("UPDATE license_keys SET status='paused' WHERE id=?")->execute([$id]);
            break;
        case 'resume':
            $pdo->prepare("UPDATE license_keys SET status='active' WHERE id=?")->execute([$id]);
            break;
        case 'reset':
            $pdo->prepare("UPDATE license_keys SET locked_fingerprint=NULL, locked_ip=NULL WHERE id=?")->execute([$id]);
            break;
    }
}

$licenses = $pdo->query('SELECT * FROM license_keys ORDER BY id DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
<p><a href="auth.php?logout=1">Logout</a></p>
    <h2>Admin Dashboard</h2>
    <form method="post">
        <input type="hidden" name="action" value="create">
        <label>Expires (YYYY-MM-DD HH:MM:SS or blank): <input type="text" name="expires"></label>
        <button type="submit">Generate Key</button>
    </form>
    <h3>Licenses</h3>
    <table border="1">
        <tr><th>ID</th><th>Key</th><th>Status</th><th>Expires</th><th>Locked IP</th><th>Locked Device</th><th>Actions</th></tr>
        <?php foreach($licenses as $lic): ?>
        <tr>
            <td><?=$lic['id']?></td>
            <td><?=htmlspecialchars($lic['license_key'])?></td>
            <td><?=$lic['status']?></td>
            <td><?=$lic['expires_at']?></td>
            <td><?=$lic['locked_ip']?></td>
            <td><?=$lic['locked_fingerprint']?></td>
            <td>
                <form method="post" style="display:inline">
                    <input type="hidden" name="id" value="<?=$lic['id']?>">
                    <button name="action" value="delete">Delete</button>
                    <?php if($lic['status']!='banned'): ?><button name="action" value="ban">Ban</button><?php endif; ?>
                    <?php if($lic['status']=='paused'): ?><button name="action" value="resume">Resume</button><?php else: ?><button name="action" value="pause">Pause</button><?php endif; ?>
                    <button name="action" value="reset">Reset Lock</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
