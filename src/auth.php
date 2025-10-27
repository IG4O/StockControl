<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/utils.php';

function login($email, $senha) {
    global $conn; // <-- importante!

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
    $stmt->execute(['email' => $email, 'senha' => $senha]);

    if ($stmt->rowCount() > 0) {
        session_start();
        $_SESSION['usuario'] = $email;
        return true;
    }
    return false;
}


// <?php
// require_once __DIR__ . '/../config/db.php';

// function login($email, $senha) {
//     global $conn; // <-- importante!

//     $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
//     $stmt->execute(['email' => $email, 'senha' => $senha]);

//     if ($stmt->rowCount() > 0) {
//         session_start();
//         $_SESSION['usuario'] = $email;
//         return true;
//     }
//     return false;
// }

// function proteger() {
//     if (!isset($_SESSION['usuario'])) {
//         header("Location: login.php");
//         exit;
//     }
// }

// function autenticarUsuario($conn, $usuario, $senha) {
//     $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha");
//     $stmt->execute(['usuario' => $usuario, 'senha' => $senha]);
//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }

?>
