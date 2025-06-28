<?php
// Database connection using PDO
function getDBConnection() {
    static $pdo;
    if ($pdo === null) {
        $host = getenv('MYSQL_HOST') ?: '127.0.0.1';
        $db   = getenv('MYSQL_DB')   ?: 'license';
        $user = getenv('MYSQL_USER') ?: 'root';
        $pass = getenv('MYSQL_PASS') ?: '';
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $options);
    }
    return $pdo;
}
?>
