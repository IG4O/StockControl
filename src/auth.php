<?php
session_start();
require_once __DIR__ . '/../config/db.php';

function login($email, $senha) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);    
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario;
        return true;
    }
    return false;
}

function proteger() {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php");
        exit;
    }
}
?>
