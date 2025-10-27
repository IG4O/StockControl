<?php
require_once '../src/venda.php';
require_once '../config/db.php';

$vendas = listarVendas($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Vendas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h2>Lista de Vendas</h2>

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendas as $venda): ?>
                <tr>
                    <td><?= htmlspecialchars($venda['id']) ?></td>
                    <td><?= htmlspecialchars($venda['data_venda']) ?></td>
                    <td>R$ <?= number_format($venda['valor_total'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
