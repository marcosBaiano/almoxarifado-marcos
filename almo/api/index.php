<?php

require __DIR__ . '/db.php';

function csv_cell($value): string
{
    $value = (string) ($value ?? '');
    // Evita que uma célula seja interpretada como fórmula ao abrir no Excel.
    if ($value !== '' && in_array($value[0], ['=', '+', '-', '@'], true)) {
        $value = "'" . $value;
    }
    return '"' . str_replace('"', '""', $value) . '"';
}

function export_csv(string $filename, array $headers, array $rows): void
{
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    echo "\xEF\xBB\xBF";
    echo implode(';', array_map('csv_cell', $headers)) . "\r\n";
    foreach ($rows as $row) {
        echo implode(';', array_map('csv_cell', $row)) . "\r\n";
    }
    exit;
}

function import_number($value, string $field, int $line): float
{
    $value = trim((string) $value);
    if ($value === '') {
        return 0.0;
    }
    $hasDot = strpos($value, '.') !== false;
    $hasComma = strpos($value, ',') !== false;
    $normalized = $hasDot && $hasComma
        ? str_replace(',', '.', str_replace('.', '', $value))
        : str_replace(',', '.', $value);
    if (!is_numeric($normalized)) {
        throw new RuntimeException("Linha {$line}: {$field} deve ser numérico.");
    }
    return (float) $normalized;
}

try {
    $action = $_GET['action'] ?? '';
    $pdo = db();

    if ($action === 'exportar_csv') {
        $entity = (string) ($_GET['entidade'] ?? '');
        $mode = (string) ($_GET['modo'] ?? 'dados');
        $exports = [
            'categorias' => [['nome', 'codigo_classe'], 'SELECT nome, codigo_classe FROM categorias ORDER BY nome'],
            'setores' => [['nome', 'codigo'], 'SELECT nome, codigo FROM setores ORDER BY nome'],
            'localizacoes' => [['codigo', 'descricao', 'coluna1', 'ativo'], 'SELECT codigo, descricao, coluna1, ativo FROM localizacoes ORDER BY codigo'],
            'produtos' => [['codigo_interno', 'codigo_barras', 'nome', 'texto_breve', 'marca', 'modelo', 'part_number', 'categoria', 'unidade', 'localizacao', 'estoque_atual', 'estoque_minimo', 'estoque_maximo', 'valor_unitario', 'solicitacao_reposicao', 'em_aberto', 'imagem_url', 'observacao', 'ativo'], "SELECT p.codigo_interno, p.codigo_barras, p.nome, p.texto_breve, p.marca, p.modelo, p.part_number, c.nome AS categoria, p.unidade, p.localizacao, p.estoque_atual, p.estoque_minimo, p.estoque_maximo, p.valor_unitario, p.solicitacao_reposicao, p.em_aberto, p.imagem_url, p.observacao, p.ativo FROM produtos p INNER JOIN categorias c ON c.id = p.categoria_id ORDER BY p.codigo_interno"],
            'produto_codigos_barras' => [['codigo_interno', 'codigo_barras', 'principal'], 'SELECT p.codigo_interno, pcb.codigo_barras, pcb.principal FROM produto_codigos_barras pcb INNER JOIN produtos p ON p.id = pcb.produto_id ORDER BY p.codigo_interno, pcb.principal DESC'],
            'movimentacoes' => [['data_hora', 'tipo_movimentacao', 'codigo_interno', 'produto', 'quantidade', 'unidade', 'saldo_anterior', 'saldo_posterior', 'solicitante', 'setor', 'equipamento', 'sessao_recebimento', 'observacao'], 'SELECT m.data_hora, m.tipo_movimentacao, p.codigo_interno, p.nome, m.quantidade, m.unidade, m.saldo_anterior, m.saldo_posterior, m.solicitante, s.nome AS setor, m.equipamento, m.sessao_recebimento, m.observacao FROM movimentacoes m INNER JOIN produtos p ON p.id = m.produto_id LEFT JOIN setores s ON s.id = m.setor_id ORDER BY m.data_hora DESC'],
            'solicitacoes' => [['numero_solicitacao', 'data_registro', 'solicitante', 'setor', 'equipamento', 'prioridade', 'status'], 'SELECT so.numero_solicitacao, so.data_registro, so.solicitante, st.nome AS setor, so.equipamento, so.prioridade, so.status FROM solicitacoes so INNER JOIN setores st ON st.id = so.setor_id ORDER BY so.data_registro DESC'],
            'solicitacoes_compra' => [['data_solicitacao', 'codigo_interno', 'produto', 'quantidade', 'unidade', 'data_chegada', 'fornecedor', 'nota_fiscal', 'status', 'observacao'], 'SELECT sc.data_solicitacao, p.codigo_interno, sc.texto_breve_material, sc.quantidade, sc.unidade, sc.data_chegada, sc.fornecedor, sc.nota_fiscal, sc.status, sc.observacao FROM solicitacoes_compra sc INNER JOIN produtos p ON p.id = sc.produto_id ORDER BY sc.data_solicitacao DESC'],
            'localizacao_saldos' => [['localizacao', 'codigo_interno', 'produto', 'quantidade', 'ajuste', 'observacao', 'atualizado_em'], 'SELECT l.codigo, p.codigo_interno, p.nome, ls.quantidade, ls.ajuste, ls.observacao, ls.atualizado_em FROM localizacao_saldos ls INNER JOIN localizacoes l ON l.id = ls.localizacao_id INNER JOIN produtos p ON p.id = ls.produto_id ORDER BY l.codigo, p.codigo_interno'],
            'auditoria' => [['data_hora', 'usuario', 'tela', 'operacao', 'valor_anterior', 'valor_novo', 'ip_address', 'computador_nome'], 'SELECT a.data_hora, u.nome, a.tela, a.operacao, a.valor_anterior, a.valor_novo, a.ip_address, a.computador_nome FROM auditoria a INNER JOIN usuarios u ON u.id = a.usuario_id ORDER BY a.data_hora DESC'],
        ];
        if (!isset($exports[$entity])) {
            throw new RuntimeException('Tabela ou relatório não disponível para exportação.');
        }
        [$headers, $sql] = $exports[$entity];
        $rows = $mode === 'modelo' ? [] : $pdo->query($sql)->fetchAll(PDO::FETCH_NUM);
        export_csv(($mode === 'modelo' ? 'modelo_' : 'relatorio_') . $entity . '_' . date('Y-m-d_H-i-s') . '.csv', $headers, $rows);
    }

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
        $nome = trim((string) ($data['nome'] ?? ''));
        $marca = trim((string) ($data['marca'] ?? ''));
        if ($nome === '' || $marca === '') {
            json_response(['success' => false, 'message' => 'Nome e marca do produto sao obrigatorios.'], 422);
        }
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
                $nome,
                $data['texto_breve'] ?? $nome,
                $marca,
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
                trim((string) ($data['codigo_barras'] ?? '')),
                $nome,
                $data['texto_breve'] ?? $nome,
                $marca,
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
        if (!is_array($items) || $items === []) {
            json_response(['success' => false, 'message' => 'Informe ao menos um item para recebimento.'], 422);
        }

        $pdo->beginTransaction();
        foreach ($items as $item) {
            $produtoId = (int) $item['produto_id'];
            $qty = (float) $item['quantidade'];
            if ($produtoId <= 0 || $qty <= 0) {
                throw new RuntimeException('Produto e quantidade de recebimento devem ser validos.');
            }
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
        if ($produtoId <= 0 || $qty <= 0) {
            json_response(['success' => false, 'message' => 'Produto e quantidade de saida devem ser validos.'], 422);
        }
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
        $itensSolicitados = $data['itens'] ?? [];
        if (trim((string) ($data['solicitante'] ?? '')) === '' || (int) ($data['setor_id'] ?? 0) <= 0 || !is_array($itensSolicitados) || $itensSolicitados === []) {
            json_response(['success' => false, 'message' => 'Solicitante, setor e ao menos um item sao obrigatorios.'], 422);
        }
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
        foreach ($itensSolicitados as $item) {
            if ((int) ($item['produto_id'] ?? 0) <= 0 || (float) ($item['quantidade_solicitada'] ?? 0) <= 0) {
                throw new RuntimeException('Os itens da solicitacao devem possuir produto e quantidade validos.');
            }
            $stmtItem->execute([$solicitacaoId, $item['produto_id'], $item['quantidade_solicitada']]);
        }
        audit_log($pdo, 'CRIACAO REQUISICAO', 'Solicitacao de Material', 'Inexistente', "Criado pedido {$numero}");
        $pdo->commit();
        json_response(['success' => true, 'id' => $solicitacaoId]);
    }

    if ($action === 'solicitacao_entregar') {
        $reqId = (int) ($data['solicitacao_id'] ?? 0);
        if ($reqId <= 0) {
            json_response(['success' => false, 'message' => 'Solicitacao invalida.'], 422);
        }
        $pdo->beginTransaction();
        $reqStmt = $pdo->prepare('SELECT status FROM solicitacoes WHERE id = ? FOR UPDATE');
        $reqStmt->execute([$reqId]);
        if ($reqStmt->fetchColumn() !== 'PENDENTE') {
            throw new RuntimeException('Solicitacao nao encontrada ou indisponivel para entrega.');
        }
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
        if ($produtoId <= 0 || $newStock < 0) {
            json_response(['success' => false, 'message' => 'Produto e saldo ajustado devem ser validos.'], 422);
        }
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

    if ($action === 'importar_csv') {
        $entity = (string) ($data['entidade'] ?? '');
        $rows = $data['linhas'] ?? [];
        $allowed = ['categorias', 'setores', 'localizacoes', 'produtos', 'produto_codigos_barras'];
        if (!in_array($entity, $allowed, true) || !is_array($rows) || $rows === []) {
            json_response(['success' => false, 'message' => 'Informe uma tabela permitida e ao menos uma linha de dados.'], 422);
        }
        if (count($rows) > 5000) {
            json_response(['success' => false, 'message' => 'O limite por importação é de 5.000 linhas.'], 422);
        }
        $value = static function (array $row, string $field): string {
            return trim((string) ($row[$field] ?? ''));
        };
        $line = static function (array $row, int $index): int {
            return (int) ($row['__linha'] ?? ($index + 2));
        };

        $pdo->beginTransaction();
        $included = 0;
        $updated = 0;
        if ($entity === 'categorias') {
            $seen = [];
            foreach ($rows as $index => $row) {
                $number = $line($row, $index); $name = $value($row, 'nome');
                if ($name === '') throw new RuntimeException("Linha {$number}: nome é obrigatório.");
                if (isset($seen[mb_strtolower($name)])) throw new RuntimeException("Linha {$number}: categoria repetida no arquivo.");
                $seen[mb_strtolower($name)] = true;
                $stmt = $pdo->prepare('SELECT id FROM categorias WHERE nome = ?'); $stmt->execute([$name]);
                $exists = (bool) $stmt->fetchColumn();
                $stmt = $pdo->prepare('INSERT INTO categorias (nome, codigo_classe) VALUES (?, ?) ON DUPLICATE KEY UPDATE codigo_classe = VALUES(codigo_classe)');
                $stmt->execute([$name, $value($row, 'codigo_classe') ?: null]);
                $exists ? $updated++ : $included++;
            }
        } elseif ($entity === 'setores') {
            $seen = [];
            foreach ($rows as $index => $row) {
                $number = $line($row, $index); $name = $value($row, 'nome'); $code = $value($row, 'codigo');
                if ($name === '' || $code === '') throw new RuntimeException("Linha {$number}: nome e codigo são obrigatórios.");
                if (isset($seen[mb_strtolower($code)])) throw new RuntimeException("Linha {$number}: código de setor repetido no arquivo.");
                $seen[mb_strtolower($code)] = true;
                $stmt = $pdo->prepare('SELECT id FROM setores WHERE codigo = ?'); $stmt->execute([$code]); $exists = (bool) $stmt->fetchColumn();
                $stmt = $pdo->prepare('INSERT INTO setores (nome, codigo) VALUES (?, ?) ON DUPLICATE KEY UPDATE nome = VALUES(nome)'); $stmt->execute([$name, $code]);
                $exists ? $updated++ : $included++;
            }
        } elseif ($entity === 'localizacoes') {
            $seen = [];
            foreach ($rows as $index => $row) {
                $number = $line($row, $index); $code = $value($row, 'codigo');
                if ($code === '') throw new RuntimeException("Linha {$number}: codigo é obrigatório.");
                if (isset($seen[mb_strtolower($code)])) throw new RuntimeException("Linha {$number}: localização repetida no arquivo.");
                $seen[mb_strtolower($code)] = true;
                $stmt = $pdo->prepare('SELECT id FROM localizacoes WHERE codigo = ?'); $stmt->execute([$code]); $exists = (bool) $stmt->fetchColumn();
                $active = $value($row, 'ativo'); $active = $active === '' ? 1 : (int) $active;
                $stmt = $pdo->prepare('INSERT INTO localizacoes (codigo, descricao, coluna1, ativo) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE descricao = VALUES(descricao), coluna1 = VALUES(coluna1), ativo = VALUES(ativo)');
                $stmt->execute([$code, $value($row, 'descricao') ?: null, $value($row, 'coluna1') ?: null, $active ? 1 : 0]);
                $exists ? $updated++ : $included++;
            }
        } elseif ($entity === 'produtos') {
            $categories = $pdo->query('SELECT id, nome FROM categorias')->fetchAll(); $categoryIds = [];
            foreach ($categories as $category) $categoryIds[mb_strtolower($category['nome'])] = (int) $category['id'];
            $locations = $pdo->query('SELECT codigo FROM localizacoes')->fetchAll(PDO::FETCH_COLUMN); $locationCodes = array_flip(array_map('mb_strtolower', $locations));
            $internalSeen = []; $barcodeSeen = [];
            foreach ($rows as $index => $row) {
                $number = $line($row, $index); $internal = $value($row, 'codigo_interno'); $barcode = $value($row, 'codigo_barras');
                $name = $value($row, 'nome'); $brand = $value($row, 'marca'); $category = $value($row, 'categoria');
                if ($internal === '' || $barcode === '' || $name === '' || $brand === '' || $category === '') throw new RuntimeException("Linha {$number}: codigo_interno, codigo_barras, nome, marca e categoria são obrigatórios.");
                if (isset($internalSeen[mb_strtolower($internal)]) || isset($barcodeSeen[$barcode])) throw new RuntimeException("Linha {$number}: código interno ou código de barras repetido no arquivo.");
                $internalSeen[mb_strtolower($internal)] = true; $barcodeSeen[$barcode] = true;
                if (!isset($categoryIds[mb_strtolower($category)])) throw new RuntimeException("Linha {$number}: categoria '{$category}' não existe. Importe categorias primeiro.");
                $location = $value($row, 'localizacao');
                if ($location !== '' && !isset($locationCodes[mb_strtolower($location)])) throw new RuntimeException("Linha {$number}: localização '{$location}' não existe. Importe localizações primeiro.");
                $byInternal = $pdo->prepare('SELECT id FROM produtos WHERE codigo_interno = ?'); $byInternal->execute([$internal]); $productId = $byInternal->fetchColumn();
                $byBarcode = $pdo->prepare('SELECT id FROM produtos WHERE codigo_barras = ?'); $byBarcode->execute([$barcode]); $barcodeProduct = $byBarcode->fetchColumn();
                if ($barcodeProduct && (int) $barcodeProduct !== (int) $productId) throw new RuntimeException("Linha {$number}: código de barras já pertence a outro produto.");
                $fields = [$name, $value($row, 'texto_breve') ?: $name, $brand, $value($row, 'modelo') ?: null, $value($row, 'part_number') ?: null, $categoryIds[mb_strtolower($category)], $value($row, 'unidade') ?: 'UN', $location ?: null, import_number($row['estoque_atual'] ?? '', 'estoque_atual', $number), import_number($row['estoque_minimo'] ?? '', 'estoque_minimo', $number), import_number($row['estoque_maximo'] ?? '', 'estoque_maximo', $number), import_number($row['valor_unitario'] ?? '', 'valor_unitario', $number), $value($row, 'solicitacao_reposicao') ?: null, import_number($row['em_aberto'] ?? '', 'em_aberto', $number), $value($row, 'imagem_url') ?: null, $value($row, 'observacao') ?: null, $value($row, 'ativo') === '' ? 1 : ((int) $value($row, 'ativo') ? 1 : 0)];
                if ($productId) {
                    $stmt = $pdo->prepare('UPDATE produtos SET codigo_barras=?, nome=?, texto_breve=?, marca=?, modelo=?, part_number=?, categoria_id=?, unidade=?, localizacao=?, estoque_atual=?, estoque_minimo=?, estoque_maximo=?, valor_unitario=?, solicitacao_reposicao=?, em_aberto=?, imagem_url=?, observacao=?, ativo=? WHERE id=?');
                    $stmt->execute(array_merge([$barcode], $fields, [(int) $productId])); $updated++;
                } else {
                    $stmt = $pdo->prepare('INSERT INTO produtos (codigo_interno, codigo_barras, nome, texto_breve, marca, modelo, part_number, categoria_id, unidade, localizacao, estoque_atual, estoque_minimo, estoque_maximo, valor_unitario, solicitacao_reposicao, em_aberto, imagem_url, observacao, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                    $stmt->execute(array_merge([$internal, $barcode], $fields)); $productId = (int) $pdo->lastInsertId(); $included++;
                }
                $pdo->prepare('UPDATE produto_codigos_barras SET principal = 0 WHERE produto_id = ?')->execute([(int) $productId]);
                $stmt = $pdo->prepare("INSERT INTO produto_codigos_barras (produto_id, codigo_barras, principal, origem) VALUES (?, ?, 1, 'IMPORTACAO') ON DUPLICATE KEY UPDATE produto_id = VALUES(produto_id), principal = 1, origem = 'IMPORTACAO'");
                $stmt->execute([(int) $productId, $barcode]);
            }
        } else {
            $seen = [];
            foreach ($rows as $index => $row) {
                $number = $line($row, $index); $internal = $value($row, 'codigo_interno'); $barcode = $value($row, 'codigo_barras');
                if ($internal === '' || $barcode === '') throw new RuntimeException("Linha {$number}: codigo_interno e codigo_barras são obrigatórios.");
                if (isset($seen[$barcode])) throw new RuntimeException("Linha {$number}: código de barras repetido no arquivo."); $seen[$barcode] = true;
                $stmt = $pdo->prepare('SELECT id FROM produtos WHERE codigo_interno = ?'); $stmt->execute([$internal]); $productId = $stmt->fetchColumn();
                if (!$productId) throw new RuntimeException("Linha {$number}: produto '{$internal}' não encontrado.");
                $stmt = $pdo->prepare('SELECT produto_id FROM produto_codigos_barras WHERE codigo_barras = ?'); $stmt->execute([$barcode]); $owner = $stmt->fetchColumn();
                if ($owner && (int) $owner !== (int) $productId) throw new RuntimeException("Linha {$number}: código de barras já pertence a outro produto.");
                $principal = $value($row, 'principal') === '' ? 0 : ((int) $value($row, 'principal') ? 1 : 0);
                $stmt = $pdo->prepare("INSERT INTO produto_codigos_barras (produto_id, codigo_barras, principal, origem) VALUES (?, ?, ?, 'IMPORTACAO') ON DUPLICATE KEY UPDATE principal = VALUES(principal)");
                $stmt->execute([$productId, $barcode, $principal]); $owner ? $updated++ : $included++;
            }
        }
        audit_log($pdo, 'IMPORTACAO CSV', 'Importador', 'Nenhuma alteração', "{$entity}: {$included} incluído(s), {$updated} atualizado(s)");
        $pdo->commit();
        json_response(['success' => true, 'message' => "Importação concluída: {$included} incluído(s) e {$updated} atualizado(s)."]);
    }

    json_response(['success' => false, 'message' => 'Acao nao encontrada.'], 404);
} catch (Throwable $e) {
    if (isset($pdo) && $pdo instanceof PDO && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    json_response(['success' => false, 'message' => $e->getMessage()], 500);
}
