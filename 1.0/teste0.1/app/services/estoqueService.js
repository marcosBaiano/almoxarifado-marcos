export function registrarMovimentacao(state, produtoId, tipo, quantidade, documentoRef, destino, operador = 'Manuel Silva') {
  const produto = state.produtos.find((item) => item.id === produtoId);
  if (!produto) {
    throw new Error('Artigo não localizado no banco de dados.');
  }

  const saldoAnterior = produto.estoque_atual;
  let saldoPosterior = saldoAnterior;

  if (tipo === 'ENTRADA') {
    saldoPosterior += quantidade;
  } else if (tipo === 'SAIDA') {
    if (saldoAnterior < quantidade) {
      throw new Error(`Rotina transacional abortada: stock insuficiente de ${produto.descricao_resumida}.`);
    }
    saldoPosterior -= quantidade;
  } else if (tipo === 'AJUSTE') {
    saldoPosterior = quantidade;
  }

  produto.estoque_atual = saldoPosterior;

  const movimentacao = {
    id: state.movimentacoes.length + 1,
    produto_id: produtoId,
    timestamp: new Date().toISOString().replace('T', ' ').substring(0, 19),
    tipo,
    quantidade,
    saldo_anterior: saldoAnterior,
    saldo_posterior: saldoPosterior,
    documento_ref: documentoRef,
    operador,
    destino
  };

  state.movimentacoes.unshift(movimentacao);

  state.auditoria.unshift({
    id: state.auditoria.length + 1,
    timestamp: movimentacao.timestamp,
    usuario: operador,
    evento: `MOV_ESTOQUE_${tipo}`,
    dados_anteriores: JSON.stringify({ estoque_anterior: saldoAnterior }),
    dados_novos: JSON.stringify({ estoque_posterior: saldoPosterior }),
    ip: '192.168.10.45'
  });

  return movimentacao;
}
