<?php
define('ROOT', dirname(__DIR__));
require_once ROOT . '/app/Core/Database.php';

$db = Database::getInstance()->getConnection();

$stmt = $db->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
$stmt->execute(['teste@teste.com']);

if (!$stmt->fetch()) {
    $hash = password_hash('teste123', PASSWORD_BCRYPT);
    $stmt = $db->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
    $stmt->execute(['Usuário Teste', 'teste@teste.com', $hash]);
    echo "✓ Usuário de teste criado: teste@teste.com / teste123\n";
} else {
    echo "✓ Usuário de teste já existe.\n";
}
