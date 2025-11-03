<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/utils.php';

function login($email, $senha) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
    $stmt->execute(['email' => $email, 'senha' => $senha]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['usuario'] = $email;
        return true;
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return false;
}
