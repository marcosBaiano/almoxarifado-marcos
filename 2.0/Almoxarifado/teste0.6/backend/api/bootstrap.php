<?php

header('Content-Type: application/json; charset=utf-8');

$storagePath = __DIR__ . '/../data/db.json';

function jsonResponse(array $payload, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function loadDb(string $path): array
{
    if (!file_exists($path)) {
        return [
            'produtos' => [],
            'movimentacoes' => [],
            'auditoria' => [],
            'solicitacoes' => []
        ];
    }

    $raw = file_get_contents($path);
    $data = json_decode((string)$raw, true);
    return is_array($data) ? $data : [
        'produtos' => [],
        'movimentacoes' => [],
        'auditoria' => [],
        'solicitacoes' => []
    ];
}

function saveDb(string $path, array $db): void
{
    if (!is_dir(dirname($path))) {
        mkdir(dirname($path), 0777, true);
    }
    file_put_contents($path, json_encode($db, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}
