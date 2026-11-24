<?php

require __DIR__ . '/db.php';

try {
    $action = $_GET['action'] ?? '';
    $pdo = db();

    if ($action === 'snapshot') {
        $produtos = $pdo->query(
            "SELECT p.*, c.nome AS categoria
             FROM produtos p
             INNER JOIN categorias c ON c.id = p.categoria_id
             WHERE p.ativo = 1
             ORDER BY p.id"
        )->fetchAll();

        $codigos = $pdo->query('SELECT * FROM produto_codigos_barras ORDER BY principal DESC, id ASC')->fetchAll();
        $movimentacoes = $pdo->query('SELECT * FROM movimentacoes ORDER BY id ASC')->fetchAll();
        $auditoria = $pdo->query('SELECT * FROM auditoria ORDER BY id ASC')->fetchAll();
        $setores = $pdo->query('SELECT * FROM setores ORDER BY id ASC')->fetchAll();
        $solicitacoes = $pdo->query('SELECT * FROM solicitacoes ORDER BY id ASC')->fetchAll();
        $itens = $pdo->query('SELECT * FROM solicitacao_itens ORDER BY id ASC')->fetchAll();

        $itensPorSolicitacao = [];
        foreach ($itens as $item) {
            $itensPorSolicitacao[(int) $item['solicitacao_id']][] = [
                'produto_id' => (int) $item['produto_id'],
                'quantidade_solicitada' => (float) $item['quantidade_solicitada'],
                'quantidade_atendida' => (float) $item['quantidade_atendida'],
            ];
        }

        foreach ($solicitacoes as &$solicitacao) {
            $solicitacao['itens'] = $itensPorSolicitacao[(int) $solicitacao['id']] ?? [];
        }

        json_response([
            'success' => true,
            'data' => [
                'produtos' => $produtos,
                'produtoCodigosBarras' => $codigos,
                'movimentacoes' => $movimentacoes,
                'auditoria' => $auditoria,
                'solicitacoes' => $solicitacoes,
                'setores' => $setores,
            ],
        ]);
    }

    $data = request_json();

    if ($action === 'produto_salvar') {
        $id = isset($data['id']) ? (int) $data['id'] : 0;
        $categoriaNome = $data['categoria'] ?? 'Mecânica';
        $stmt = $pdo->prepare('SELECT id FROM categorias WHERE nome = ? LIMIT 1');
        $stmt->execute([$categoriaNome]);
        $categoriaId = (int) ($stmt->fetchColumn() ?: 2);

        if ($id > 0) {
            $stmt = $pdo->prepare(
                "UPDATE produtos
                 SET nome = ?, texto_breve = ?, marca = ?, part_number = ?, categoria_id = ?, unidade = ?,
                     localizacao = ?, estoque_atual = ?, estoque_minimo = ?, estoque_maximo = ?, imagem_url = ?
                 WHERE id = ?"
            );
            $stmt->execute([
                $data['nome'] ?? '',
                $data['texto_breve'] ?? ($data['nome'] ?? ''),
                $data['marca'] ?? '',
                $data['part_number'] ?? null,
                $categoriaId,
                $data['unidade'] ?? 'UN',
                $data['localizacao'] ?? null,
                $data['estoque_atual'] ?? 0,
                $data['estoque_minimo'] ?? 0,
                $data['estoque_maximo'] ?? 100,
                $data['imagem'] ?? ($data['imagem_url'] ?? null),
                $id,
            ]);
        } else {
            $stmt = $pdo->query("SELECT COALESCE(MAX(id), 0) + 1 FROM produtos");
            $id = (int) $stmt->fetchColumn();
            $codigoInterno = $data['codigo_interno'] ?? sprintf('IT-%03d', $id);
            $stmt = $pdo->prepare(
                "INSERT INTO produtos (
                    id, codigo_interno, codigo_barras, nome, texto_breve, marca, part_number,
                    categoria_id, unidade, localizacao, estoque_atual, estoque_minimo, estoque_maximo, imagem_url
                 ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $id,
                $codigoInterno,
                $data['codigo_barras'],
                $data['nome'],
                $data['texto_breve'] ?? $data['nome'],
                $data['marca'],
                $data['part_number'] ?? null,
                $categoriaId,
                $data['unidade'] ?? 'UN',
                $data['localizacao'] ?? null,
                $data['estoque_atual'] ?? 0,
                $data['estoque_minimo'] ?? 0,
                $data['estoque_maximo'] ?? 100,
                $data['imagem'] ?? ($data['imagem_url'] ?? null),
            ]);
        }

        if (!empty($data['codigo_barras'])) {
            $stmt = $pdo->prepare(
                "INSERT INTO produto_codigos_barras (produto_id, codigo_barras, principal, origem)
                 VALUES (?, ?, 1, 'CADASTRO')
                 ON DUPLICATE KEY UPDATE produto_id = VALUES(produto_id)"
            );
            $stmt->execute([$id, trim($data['codigo_barras'])]);
        }

        json_response(['success' => true, 'id' => $id]);
    }

    if ($action === 'barcode_associar') {
        $produtoId = (int) ($data['produto_id'] ?? 0);
        $barcode = trim((string) ($data['codigo_barras'] ?? ''));

        if ($produtoId <= 0 || $barcode === '') {
            json_response(['success' => false, 'message' => 'Produto ou codigo de barras invalido.'], 422);
        }

        $stmt = $pdo->prepare('SELECT produto_id FROM produto_codigos_barras WHERE codigo_barras = ? LIMIT 1');
        $stmt->execute([$barcode]);
        $existing = $stmt->fetchColumn();
        if ($existing && (int) $existing !== $produtoId) {
            json_response(['success' => false, 'message' => 'Codigo ja associado a outro produto.'], 409);
        }

        $stmt = $pdo->prepare(
            "INSERT INTO produto_codigos_barras (produto_id, codigo_barras, principal, origem)
             VALUES (?, ?, 0, 'ASSOCIACAO_RECEBIMENTO')
             ON DUPLICATE KEY UPDATE produto_id = VALUES(produto_id)"
        );
        $stmt->execute([$produtoId, $barcode]);

        json_response(['success' => true]);
    }

    if ($action === 'recebimento_commit') {
        $items = $data['items'] ?? [];
        $sessionId = $data['sessao_recebimento'] ?? null;

        $pdo->beginTransaction();
        foreach ($items as $item) {
            $produtoId = (int) $item['produto_id'];
            $qty = (float) $item['quantidade'];
            $stmt = $pdo->prepare('SELECT estoque_atual, unidade FROM produtos WHERE id = ? FOR UPDATE');
            $stmt->execute([$produtoId]);
            $product = $stmt->fetch();
            if (!$product) {
                throw new RuntimeException('Produto nao localizado.');
            }

            $previous = (float) $product['estoque_atual'];
            $posterior = $previous + $qty;
            $pdo->prepare('UPDATE produtos SET estoque_atual = ? WHERE id = ?')->execute([$posterior, $produtoId]);
            $stmt = $pdo->prepare(
                "INSERT INTO movimentacoes (
                    produto_id, tipo_movimentacao, quantidade, unidade, saldo_anterior,
                    saldo_posterior, usuario_id, sessao_recebimento, origem
                 ) VALUES (?, 'ENTRADA', ?, ?, ?, ?, ?, ?, 'SCANNER')"
            );
            $stmt->execute([$produtoId, $qty, $product['unidade'], $previous, $posterior, current_user_id(), $sessionId]);
        }
        audit_log($pdo, 'CONFERENCIA RECEBIMENTO', 'Recebimento Lotes', 'Staging Pendente', "Lote confirmado na sessao {$sessionId}");
        $pdo->commit();

        json_response(['success' => true]);
    }

    if ($action === 'saida_direta') {
        $produtoId = (int) $data['produto_id'];
        $qty = (float) $data['quantidade'];
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('SELECT estoque_atual, unidade FROM produtos WHERE id = ? FOR UPDATE');
        $stmt->execute([$produtoId]);
        $product = $stmt->fetch();
        if (!$product) {
            throw new RuntimeException('Produto nao localizado.');
        }
        $previous = (float) $product['estoque_atual'];
        if ($previous < $qty) {
            throw new RuntimeException('Saldo insuficiente.');
        }
        $posterior = $previous - $qty;
        $pdo->prepare('UPDATE produtos SET estoque_atual = ? WHERE id = ?')->execute([$posterior, $produtoId]);
        $stmt = $pdo->prepare(
            "INSERT INTO movimentacoes (
                produto_id, tipo_movimentacao, quantidade, unidade, saldo_anterior, saldo_posterior,
                usuario_id, solicitante, setor_id, equipamento, despachante_usuario_id, origem, observacao
             ) VALUES (?, 'SAIDA', ?, ?, ?, ?, ?, ?, ?, ?, ?, 'SCANNER', ?)"
        );
        $stmt->execute([
            $produtoId,
            $qty,
            $product['unidade'],
            $previous,
            $posterior,
            current_user_id(),
            $data['solicitante'] ?? null,
            $data['setor_id'] ?? null,
            $data['equipamento'] ?? null,
            current_user_id(),
            $data['observacao'] ?? null,
        ]);
        audit_log($pdo, 'SAIDA DIRETA', 'Saida de Material', "{$previous} {$product['unidade']}", "{$posterior} {$product['unidade']}");
        $pdo->commit();
        json_response(['success' => true]);
    }

    if ($action === 'solicitacao_criar') {
        $pdo->beginTransaction();
        $numero = $data['numero_solicitacao'] ?? ('REQ-' . date('Y') . '-' . str_pad((string) random_int(1, 999), 3, '0', STR_PAD_LEFT));
        $stmt = $pdo->prepare(
            "INSERT INTO solicitacoes (numero_solicitacao, solicitante, setor_id, equipamento, prioridade, status)
             VALUES (?, ?, ?, ?, ?, 'PENDENTE')"
        );
        $stmt->execute([
            $numero,
            $data['solicitante'],
            $data['setor_id'],
            $data['equipamento'] ?? null,
            $data['prioridade'] ?? 'MEDIA',
        ]);
        $solicitacaoId = (int) $pdo->lastInsertId();
        $stmtItem = $pdo->prepare(
            'INSERT INTO solicitacao_itens (solicitacao_id, produto_id, quantidade_solicitada, quantidade_atendida)
             VALUES (?, ?, ?, 0)'
        );
        foreach (($data['itens'] ?? []) as $item) {
            $stmtItem->execute([$solicitacaoId, $item['produto_id'], $item['quantidade_solicitada']]);
        }
        audit_log($pdo, 'CRIACAO REQUISICAO', 'Solicitacao de Material', 'Inexistente', "Criado pedido {$numero}");
        $pdo->commit();
        json_response(['success' => true, 'id' => $solicitacaoId]);
    }

    if ($action === 'solicitacao_entregar') {
        $reqId = (int) ($data['solicitacao_id'] ?? 0);
        $pdo->beginTransaction();
        $items = $pdo->prepare('SELECT * FROM solicitacao_itens WHERE solicitacao_id = ?');
        $items->execute([$reqId]);
        foreach ($items->fetchAll() as $item) {
            $produtoId = (int) $item['produto_id'];
            $qty = (float) $item['quantidade_solicitada'];
            $stmt = $pdo->prepare('SELECT estoque_atual, unidade FROM produtos WHERE id = ? FOR UPDATE');
            $stmt->execute([$produtoId]);
            $product = $stmt->fetch();
            if (!$product || (float) $product['estoque_atual'] < $qty) {
                throw new RuntimeException('Saldo insuficiente para entrega.');
            }
            $previous = (float) $product['estoque_atual'];
            $posterior = $previous - $qty;
            $pdo->prepare('UPDATE produtos SET estoque_atual = ? WHERE id = ?')->execute([$posterior, $produtoId]);
            $pdo->prepare('UPDATE solicitacao_itens SET quantidade_atendida = ? WHERE id = ?')->execute([$qty, $item['id']]);
            $stmtMov = $pdo->prepare(
                "INSERT INTO movimentacoes (
                    produto_id, tipo_movimentacao, quantidade, unidade, saldo_anterior,
                    saldo_posterior, usuario_id, solicitacao_id, origem, observacao
                 ) VALUES (?, 'SAIDA', ?, ?, ?, ?, ?, ?, 'DIGITACAO', ?)"
            );
            $stmtMov->execute([$produtoId, $qty, $product['unidade'], $previous, $posterior, current_user_id(), $reqId, "Despacho requisicao {$reqId}"]);
        }
        $pdo->prepare("UPDATE solicitacoes SET status = 'ENTREGUE', despachante_usuario_id = ? WHERE id = ?")->execute([current_user_id(), $reqId]);
        audit_log($pdo, 'DESPACHO REQUISICAO', 'Painel Separacao', 'Pendente', "Despachado pedido {$reqId}");
        $pdo->commit();
        json_response(['success' => true]);
    }

    if ($action === 'estoque_ajustar') {
        $produtoId = (int) $data['produto_id'];
        $newStock = (float) $data['estoque_atual'];
        $reason = $data['observacao'] ?? '';
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('SELECT estoque_atual, unidade FROM produtos WHERE id = ? FOR UPDATE');
        $stmt->execute([$produtoId]);
        $product = $stmt->fetch();
        if (!$product) {
            throw new RuntimeException('Produto nao localizado.');
        }
        $previous = (float) $product['estoque_atual'];
        $pdo->prepare('UPDATE produtos SET estoque_atual = ? WHERE id = ?')->execute([$newStock, $produtoId]);
        $stmt = $pdo->prepare(
            "INSERT INTO movimentacoes (
                produto_id, tipo_movimentacao, quantidade, unidade, saldo_anterior,
                saldo_posterior, usuario_id, origem, observacao
             ) VALUES (?, 'AJUSTE', ?, ?, ?, ?, ?, 'DIGITACAO', ?)"
        );
        $stmt->execute([$produtoId, abs($newStock - $previous), $product['unidade'], $previous, $newStock, current_user_id(), $reason]);
        audit_log($pdo, 'AJUSTE ESTOQUE', 'Consulta & Ajustes', "{$previous} {$product['unidade']}", "{$newStock} {$product['unidade']} motivo: {$reason}");
        $pdo->commit();
        json_response(['success' => true]);
    }

    json_response(['success' => false, 'message' => 'Acao nao encontrada.'], 404);
} catch (Throwable $e) {
    if (isset($pdo) && $pdo instanceof PDO && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    json_response(['success' => false, 'message' => $e->getMessage()], 500);
}
