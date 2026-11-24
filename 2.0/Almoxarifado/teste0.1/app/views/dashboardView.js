export function renderDashboard(state) {
  const totalProdutos = document.getElementById('kpi-total-produtos');
  const estoqueCritico = document.getElementById('kpi-estoque-critico');
  const requisicoesPendentes = document.getElementById('kpi-req-pendentes');
  const valorEstoque = document.getElementById('kpi-valor-estoque');
  const alertas = document.getElementById('alertas-criticos-container');
  const tabela = document.getElementById('dashboard-movimentacoes-table');

  if (!totalProdutos || !estoqueCritico || !requisicoesPendentes || !valorEstoque || !alertas || !tabela) {
    return;
  }

  const criticos = state.produtos.filter((produto) => produto.estoque_atual < produto.estoque_minimo);
  const valorTotal = state.produtos.reduce((acc, produto) => acc + produto.estoque_atual * produto.preco_custo_medio, 0);
  const pendentes = state.requisicoes.filter((requisicao) => requisicao.status === 'Pendente');

  totalProdutos.textContent = state.produtos.length;
  estoqueCritico.textContent = criticos.length;
  requisicoesPendentes.textContent = pendentes.length;
  valorEstoque.textContent = formatEuro(valorTotal);

  alertas.innerHTML = criticos.length
    ? criticos.map((produto) => `
      <div class="bg-rose-950/20 border border-rose-900/40 p-3 rounded-lg flex items-center justify-between">
        <div>
          <span class="text-xs font-bold text-white block">${produto.descricao_resumida}</span>
          <span class="text-[10px] text-slate-400 block code-font">${produto.codigo_interno} • Part Number: ${produto.part_number}</span>
        </div>
        <div class="text-right">
          <span class="text-xs text-rose-400 font-bold block">${produto.estoque_atual} de ${produto.estoque_minimo} Mín</span>
          <span class="text-[9px] text-slate-500 uppercase font-semibold">Reposição Crítica</span>
        </div>
      </div>
    `).join('')
    : '<div class="bg-emerald-950/20 border border-emerald-900/60 p-4 rounded-lg text-center text-emerald-400 text-xs font-semibold">Nenhum produto em nível crítico de stock.</div>';

  tabela.innerHTML = state.movimentacoes.slice(0, 5).map((movimentacao) => {
    const produto = state.produtos.find((item) => item.id === movimentacao.produto_id) || {};
    const badges = {
      ENTRADA: 'bg-emerald-950 text-emerald-400 border border-emerald-900/50',
      SAIDA: 'bg-rose-950 text-rose-400 border border-rose-900/50',
      AJUSTE: 'bg-blue-950 text-blue-400 border border-blue-900/50'
    };

    return `
      <tr>
        <td class="py-3 px-4 text-xs text-slate-400 font-medium code-font">${movimentacao.timestamp}</td>
        <td class="py-3 px-4">
          <span class="font-bold text-white block">${produto.descricao_resumida || 'Peça Desconhecida'}</span>
          <span class="text-xs text-slate-500 code-font">${produto.codigo_interno || ''}</span>
        </td>
        <td class="py-3 px-4">
          <span class="px-2 py-0.5 rounded text-[10px] font-semibold tracking-wider uppercase ${badges[movimentacao.tipo]}">${movimentacao.tipo}</span>
        </td>
        <td class="py-3 px-4 font-semibold text-white text-center">${movimentacao.quantidade} un</td>
        <td class="py-3 px-4 text-xs text-slate-400">${movimentacao.destino}</td>
        <td class="py-3 px-4 text-xs font-bold text-slate-300 code-font">${movimentacao.documento_ref}</td>
        <td class="py-3 px-4 text-xs text-slate-400">${movimentacao.operador}</td>
      </tr>
    `;
  }).join('');
}

function formatEuro(value) {
  return new Intl.NumberFormat('pt-PT', { style: 'currency', currency: 'EUR' }).format(value);
}
