<?php
session_start();
require_once __DIR__ . '/../src/relatorio.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    excluirLog($conn, $id);
}

$logs = listarLogs($conn);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Atividades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Confirmação antes de excluir
        function confirmarExclusao(event) {
            if (!confirm("Tem certeza que deseja excluir este item?")) {
                event.preventDefault();
            }
        }
    </script>
</head>

<!-- <style>
    body {
        margin-top: 90px; /* Compensa a navbar mais alta */
    }
</style> -->
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-primary mb-4 text-center">Relatório de Atividades</h2>

        <table class="table table-bordered table-striped align-middle shadow-sm">
            <thead class="table-primary text-center">
                <tr>
                    <th>Usuário</th>
                    <th>Ação</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php 
                $totalItens = 0;
                foreach ($logs as $log): 
                    $totalItens++;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($log['usuario']) ?></td>
                        <td><?= htmlspecialchars($log['acao']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($log['data_log'])) ?></td>
                        <td>
                            <a href="relatorio.php?id=<?= $log['id'] ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="confirmarExclusao(event)">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="mt-4 text-end">
            <h5><strong>Total de registros:</strong> <?= $totalItens ?></h5>
        </div>

        <!-- <div class="text-center mt-4">
            <a href="estoque.php" class="btn btn-secondary">← Voltar ao Estoque</a>
        </div> -->
    </div>
</body>
</html>
