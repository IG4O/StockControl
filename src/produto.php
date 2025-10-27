<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/utils.php';

function listarProdutos($conn) {
    $stmt = $conn->query("SELECT * FROM produtos ORDER BY id");
    $preco = isset($produto['valor']) && $produto['valor'] !== null ? $produto['valor'] : 0;        
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function adicionarProduto($conn, $nome, $quantidade, $preco, $usuario, $data) {

    $stmt = $conn->prepare("INSERT INTO produtos (nome, quantidade, valor, usuario, dataregistro) VALUES (:nome, :quantidade, :valor, :usuario, :dataregistro)");
    $stmt->execute([
        ':nome' => $nome,
        ':quantidade' => $quantidade,
        ':valor' => $preco ?: 0,        
        ':dataregistro' => $data,
        ':usuario' => $usuario
    ]);
    registrarLog($conn, $usuario, "Adicionou o produto '$nome'", $data);
}

function atualizarProduto($conn, $id, $nome, $quantidade, $preco, $usuario, $data) {
    $stmt = $conn->prepare("INSERT INTO produtos (nome, quantidade, valor, usuario) VALUES (:nome, :quantidade, :valor, :usuario)");
    $stmt->execute([
        ':nome' => $nome,
        ':quantidade' => $quantidade,
        ':valor' => $preco,
        ':usuario' => $usuario
    ]);
    registrarLog($conn, $usuario, "Atualizou o produto '$nome'", $data);
}

function removerProduto($conn, $id, $usuario, $data) {
    $stmt = $conn->prepare("DELETE FROM produtos WHERE id=:id");
    $stmt->execute(['id' => $id]);
    registrarLog($conn, $usuario, "Removeu um produto (ID: $id)", $data);
}
?>
