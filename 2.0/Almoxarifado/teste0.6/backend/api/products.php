<?php

require __DIR__ . '/bootstrap.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$db = loadDb($storagePath);

if ($method === 'GET') {
    jsonResponse(['ok' => true, 'data' => $db['produtos']]);
}

if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input) || empty($input['nome']) || empty($input['codigo_barras'])) {
        jsonResponse(['ok' => false, 'error' => 'Payload inválido'], 422);
    }

    $maxId = 0;
    foreach ($db['produtos'] as $p) {
        $pid = (int)($p['id'] ?? 0);
        if ($pid > $maxId) { $maxId = $pid; }
    }

    $input['id'] = $maxId + 1;
    $db['produtos'][] = $input;
    saveDb($storagePath, $db);

    jsonResponse(['ok' => true, 'data' => $input], 201);
}

jsonResponse(['ok' => false, 'error' => 'Método não suportado'], 405);
