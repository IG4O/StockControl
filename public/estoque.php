<?php
session_start();
require_once __DIR__ . '/../src/produto.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

$usuario = $_SESSION['usuario'];
date_default_timezone_set('America/Sao_Paulo');
$dataregistro = date('Y-m-d H:i:s');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['adicionar'])) {
        adicionarProduto($conn, $_POST['nome'], $_POST['quantidade'], $_POST['valor'], $usuario, $dataregistro, $_POST['custo'],  $_POST['marca']);
    } elseif (isset($_POST['remover'])) {        
        removerProduto($conn, $_POST['id'], $usuario, $dataregistro, $_POST['nome']);
    }
}

$produtos = listarProdutos($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Estoque - Dona Guió</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function confirmarExclusao(event) {
            if (!confirm("Tem certeza que deseja excluir este produto do estoque?")) {
                event.preventDefault();
            }
        }

        function confirmarEdicao(event){
            if (!confirm("Tem certeza que deseja editar este produto?")) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body class="bg-light">

<style>
    body {
        margin-top: -20px; /* Compensa a navbar mais alta */
    }
</style>

<div class="container mt-5">
    <h2 class="text-primary mb-4 text-center">Estoque</h2>

    <!-- Formulário de adição -->
    <form method="POST" class="d-flex justify-content-center mb-4 gap-2">
        <input type="text" name="nome" placeholder="Nome" class="form-control w-25" required>
        <input type="text" name="marca" placeholder="Marca" class="form-control w-25">
        <input type="number" name="quantidade" placeholder="Quantidade" class="form-control w-25" required>
        <input type="number" step="0.01" name="custo" placeholder="Preço custo" class="form-control w-25" required>
        <input type="number" step="0.01" name="valor" placeholder="Preço venda" class="form-control w-25" required>
        <button name="adicionar" class="btn btn-success">Adicionar</button>
    </form>

    <!-- Tabela -->
    <div class="table-responsive shadow-sm">
        <table class="table table-striped table-hover text-center align-middle">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Marca</th>
                    <th>Quantidade</th>
                    <th>Preço Custo</th>
                    <th>Preço Unitário</th>
                    <th>Data Registro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalEstoque = 0;
                foreach ($produtos as $p): 
                    $subtotal = floatval($p['quantidade']) * floatval($p['valor']);
                    $totalEstoque += $subtotal;
                ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['nome']) ?></td>
                        <td><?= htmlspecialchars($p['marca']) ?></td>
                        <td><?= $p['quantidade'] ?></td>
                        <td>R$ <?= number_format($p['custo'], 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($p['valor'], 2, ',', '.') ?></td>
                        <td><?= isset($p['dataregistro']) ? date('d/m/Y', strtotime($p['dataregistro'])) : '-' ?></td>
                        <td>
                            <form method="POST" style="display:inline">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <input type="hidden" name="nome" value="<?= $p['nome'] ?>">
                                <!-- <button name="alterar" class="btn btn-sm btn-info" onclick="confirmarEdicao(event)">Alterar</button> -->
                                <button name="remover" class="btn btn-sm btn-danger" onclick="confirmarExclusao(event)">Excluir</button>                                
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Total -->
     
    <div class="text-end mt-3">
        <h5><strong>Valor total em estoque:</strong> R$ <?= number_format($totalEstoque, 2, ',', '.') ?></h5>
    </div>
<!-- 
    <div class="text-center mt-4">
        <a href="relatorio.php" class="btn btn-secondary me-2">Relatórios</a>
        <a href="logout.php" class="btn btn-outline-danger">Sair</a>
    </div> -->
</div>

</body>
</html>
