<?php
require_once __DIR__ . '/../config/db.php';

if ($conn) {
    echo "✅ Conexão bem-sucedida!";
} else {
    echo "❌ Falha na conexão!";
}