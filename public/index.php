<?php
require_once '../src/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (login($_POST['email'], $_POST['senha'])) {
        header('Location: principal.php');
        
        exit;
    } else {
        $erro = "Usuário ou senha inválidos!";
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
    <body class="bg-light d-flex align-items-center" style="height: 100vh;">
        <div class="container text-center">
            <h2>Dona Guió</h2>
            <form method="POST" class="w-25 mx-auto mt-4">
                <input class="form-control mb-2" type="email" name="email" placeholder="Email" required>
                <input class="form-control mb-2" type="password" name="senha" placeholder="Senha" required>
                <?php if (isset($erro)) echo "<div class='text-danger'>$erro</div>"; ?>
                <button class="btn btn-primary w-100">Entrar</button>
            </form>
        </div>

        <!-- <a href="principal.php">teste</a> -->
    </body>
</html>
