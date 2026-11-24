<?php

function db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $config = require __DIR__ . '/../config/database.php';
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        $config['host'],
        $config['database'],
        $config['charset']
    );

    $pdo = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}

function json_response(array $payload, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function request_json(): array
{
    $raw = file_get_contents('php://input');
    if ($raw === '' || $raw === false) {
        return [];
    }

    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function current_user_id(): int
{
    return 104;
}

function audit_log(PDO $pdo, string $operation, string $screen, string $before, string $after): void
{
    $stmt = $pdo->prepare(
        'INSERT INTO auditoria (usuario_id, ip_address, computador_nome, tela, operacao, valor_anterior, valor_novo)
         VALUES (?, ?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([
        current_user_id(),
        $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
        gethostname() ?: 'WEB',
        $screen,
        $operation,
        $before,
        $after,
    ]);
}
