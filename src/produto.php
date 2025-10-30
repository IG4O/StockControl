<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/utils.php';

function listarProdutos($conn) {
    $stmt = $conn->query("SELECT * FROM produtos ORDER BY id");
    // $preco = isset($produto['valor']) && $produto['valor'] !== null ? $produto['valor'] : 0;        
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function adicionarProduto($conn, $nome, $quantidade, $preco, $usuario, $data, $custo, $marca) {

    if ($marca == null || $marca == 0){
        $marca = "-";
    }

    $stmt = $conn->prepare("INSERT INTO produtos (nome, quantidade, valor, usuario, dataregistro, custo, marca) VALUES (:nome, :quantidade, :valor, :usuario, :dataregistro, :custo, :marca)");
    $stmt->execute([
        ':nome' => $nome,
        ':quantidade' => $quantidade,
        ':valor' => $preco ?: 0,
        ':dataregistro' => $data,
        ':usuario' => $usuario,
        ':custo' => $custo ?: 0,
        ':marca' => $marca ?: 0
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

function removerProduto($conn, $id, $usuario, $data, $nome) {
    $stmt = $conn->prepare("DELETE FROM produtos WHERE id=:id");
    $stmt->execute([':id' => $id]);
    registrarLog($conn, $usuario, "Removeu um produto '$nome'", $data);
}


function buscarProdutoPorId($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function atualizarEstoque($conn, $id, $novaQtd) {
    $stmt = $conn->prepare("UPDATE produtos SET quantidade = :quantidade WHERE id = :id");
    $stmt->execute(['quantidade' => $novaQtd, 'id' => $id]);
}
?>
