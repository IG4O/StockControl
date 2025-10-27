<?php
function registrarLog($conn, $usuario, $acao, $data) {
    $stmt = $conn->prepare("INSERT INTO logs (usuario, acao, data_log) VALUES (:usuario, :acao, :data_log)");
    $stmt->execute(['usuario' => $usuario, 'acao' => $acao , 'data_log' => $data]);
}
?>