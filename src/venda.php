<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/utils.php';


function registrarVenda($conn, $valorTotal, $usuario, $datavenda, $desconto, $idproduto, $quantidade) {
    $stmt = $conn->prepare("INSERT INTO vendas (quantidade, data_venda, idproduto, totalvenda, usuario, desconto) VALUES (:quantidade, :data_venda, :idproduto, :totalvenda, :usuario, :desconto)");
    
    $stmt->execute([
        'totalvenda' => $valorTotal,
        'data_venda' => $datavenda,
        'usuario' => $usuario,
        'desconto' => $desconto,
        'idproduto' => $idproduto,
        'quantidade' => $quantidade,
    ]);

    registrarLog($conn, $usuario, "Registrou uma venda no valor de R$ " . number_format($valorTotal, 2, ',', '.'), $datavenda);
    return $conn->lastInsertId();
}

function listarVendas($conn) {
    $stmt = $conn->query("SELECT * FROM vendas");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
