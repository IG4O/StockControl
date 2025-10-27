<?php
require_once '../src/auth.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dona Guió</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Aumenta levemente a altura da navbar */
        .navbar {
            padding-top: 1rem;
            padding-bottom: 1rem;
            font-size: 1.1rem;
        }

        /* Deixa o nome “Dona Guió” mais destacado */
        .navbar-brand {
            font-weight: 600;
            font-size: 1.3rem;
        }

        /* Botão "Sair" em vermelho */
        .nav-link.btn-sair {
            color: #fff !important;
            background-color: #dc3545;
            border-radius: 6px;
            padding: 6px 14px;
            transition: 0.3s;
        }

        .nav-link.btn-sair:hover {
            background-color: #b02a37;
        }

        iframe {
            width: 100%;
            height: calc(100vh - 72px); /* ajusta a altura conforme navbar maior */
            border: none;
        }
    </style>
</head>
<body>
    <!-- Navbar fixa -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand ms-2" href="#">Dona Guió</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Menu principal -->
                <ul class="navbar-nav me-auto ms-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="carregarPagina('estoque.php')">Estoque</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="carregarPagina('relatorio.php')">Relatório</a>
                    </li>
                </ul>

                <!-- Botão de sair -->
                <ul class="navbar-nav me-2">
                    <li class="nav-item">
                        <a class="nav-link btn-sair" href="logout.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo dinâmico -->
    <iframe id="conteudo" src="estoque.php"></iframe>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function carregarPagina(pagina) {
            document.getElementById('conteudo').src = pagina;
        }
    </script>
</body>
</html>
