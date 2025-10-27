<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/utils.php';

function listarLogs($conn) {
    $stmt = $conn->query("SELECT * FROM logs order by data_log");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>