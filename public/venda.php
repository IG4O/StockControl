<?php

session_start();
require_once '../config/db.php';
require_once '../src/produto.php';
require_once '../src/venda.php';

$produtos = listarProdutos($conn);
$datavenda = date('Y-m-d H:i:s');

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

$usuario = $_SESSION['usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_venda'])) {
    $itens = $_POST['produtos'] ?? [];
    $descontos = $_POST['desconto'] ?? [];
    $total = 0;    

    foreach ($itens as $id => $qtd) {
        if ($qtd > 0) {
            $produto = buscarProdutoPorId($conn, $id);
            $preco = $produto['valor'];
            $desconto = isset($descontos[$id]) ? floatval($descontos[$id]) : 0;

            $subtotal = $qtd * $preco * (1 - ($desconto / 100));
            $total += $subtotal;

            // Dá baixa no estoque
            atualizarEstoque($conn, $id, $produto['quantidade'] - $qtd);

            // Salva item da venda (se tiver tabela itens_venda)
            // registrarVenda($conn, $id, $qtd, $preco, $desconto, $subtotal);
        }
    }

    // Registra a venda principal
    registrarVenda($conn, $total, $usuario, $datavenda, $desconto, $id, $qtd);

    header("Location: venda.php?sucesso=1");
    exit;
}

$vendas = listarVendas($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registrar Venda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {margin-top: +10px; background-color: #f8fafc; }
        h2 { text-align: center; color: #0d6efd; margin-bottom: 30px; }
        .table { background: #fff; border-radius: 10px; overflow: hidden; }
        .table th { background-color: #eaf3ff; }
        .btn-primary { border-radius: 8px; }
        .total-venda { font-size: 1.2rem; font-weight: 600; text-align: right; margin-top: 15px; }
        .alert { text-align: center; }
        .selecionar {padding: -40%;}
    </style>
</head>
<body class="container">

    <h2>Venda</h2>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="alert alert-success">✅ Venda registrada com sucesso!</div>
    <?php endif; ?>

    <form method="POST" id="formVenda" onsubmit="return confirmarVenda()">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <input type="text" id="filtro" class="form-control w-75" placeholder="🔍 Filtrar produtos...">
            <div class="total-venda">Total: <span id="totalVenda">R$ 0,00</span></div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle text-center" id="tabelaProdutos">
                <thead>
                    <tr>
                        <th></th>
                        <th>Produto</th>
                        <th>Estoque</th>
                        <th>Preço (R$)</th>
                        <th>Quantidade</th>
                        <th>Desconto %</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $p): ?>
                        <tr>
                            <td><input type="checkbox" class="form-check-input produtoCheck" data-id="<?= $p['id'] ?>"></td>
                            <td><?= htmlspecialchars($p['nome']) ?></td>
                            <td><?= $p['quantidade'] ?></td>
                            <td><?= number_format($p['valor'], 2, ',', '.') ?></td>
                            <td>
                                <input type="number" name="produtos[<?= $p['id'] ?>]" class="form-control form-control-sm qtdInput" min="0" max="<?= $p['quantidade'] ?>"  disabled>
                            </td>
                            <td>
                                <input type="number" name="desconto[<?= $p['id'] ?>]" class="form-control form-control-sm descInput" min="0" max="100"  disabled>
                            </td>
                            <td class="subtotal">R$ 0,00</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <button type="submit" name="confirmar_venda" class="btn btn-primary px-5">Confirmar Venda</button>
        </div>
    </form>

    <script>
        // Ativar/desativar campos quando marcar produto
        document.querySelectorAll('.produtoCheck').forEach(chk => {
            chk.addEventListener('change', () => {
                const row = chk.closest('tr');
                const qtdInput = row.querySelector('.qtdInput');
                const descInput = row.querySelector('.descInput');
                qtdInput.disabled = descInput.disabled = !chk.checked;
                if (!chk.checked) {
                    qtdInput.value = "";
                    descInput.value = "";
                }
                atualizarSubtotal();
            });
        });

        // Atualiza subtotal quando muda quantidade ou desconto
        document.querySelectorAll('.qtdInput, .descInput').forEach(input => {
            input.addEventListener('input', atualizarSubtotal);
        });

        function atualizarSubtotal() {
            let total = 0;
            document.querySelectorAll('#tabelaProdutos tbody tr').forEach(row => {
                const chk = row.querySelector('.produtoCheck');
                const qtd = parseFloat(row.querySelector('.qtdInput').value) || 0;
                const desc = parseFloat(row.querySelector('.descInput').value) || 0;
                const preco = parseFloat(row.children[3].textContent.replace(',', '.'));
                const subtotalCell = row.querySelector('.subtotal');

                if (chk.checked && qtd > 0) {
                    let subtotal = qtd * preco * (1 - (desc / 100));
                    subtotalCell.textContent = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
                    total += subtotal;
                } else {
                    subtotalCell.textContent = 'R$ 0,00';
                }
            });
            document.getElementById('totalVenda').textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
        }

        // Filtro de produtos
        document.getElementById('filtro').addEventListener('keyup', e => {
            const filtro = e.target.value.toLowerCase();
            document.querySelectorAll('#tabelaProdutos tbody tr').forEach(row => {
                const nome = row.children[1].textContent.toLowerCase();
                row.style.display = nome.includes(filtro) ? '' : 'none';
            });
        });

        // Confirmação antes de registrar a venda
        function confirmarVenda() {
            const total = document.getElementById('totalVenda').textContent;
            return confirm(`Deseja confirmar a venda no valor total de ${total}?`);
        }
    </script>
</body>
</html>
