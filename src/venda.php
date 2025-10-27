<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/utils.php';

function registrarVenda($conn, $valorTotal, $usuario) {
    $stmt = $conn->prepare("INSERT INTO vendas (valor_total, data) VALUES (:valor, NOW())");
    $stmt->execute(['valor' => $valorTotal]);
    // registrarLog($conn, $usuario, "Registrou uma venda no valor de R$ " . number_format($valorTotal, 2, ',', '.'));
}

function listarVendas($conn) {
    $stmt = $conn->query("SELECT * FROM vendas ORDER BY data DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
