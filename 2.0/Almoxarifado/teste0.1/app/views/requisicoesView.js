export function renderRequisicoes(state) {
  const container = document.getElementById('requisicoes-container');
  if (!container) return;

  const pendentes = state.requisicoes.filter((requisicao) => requisicao.status === 'Pendente');

  if (!pendentes.length) {
    container.innerHTML = '<div class="bg-slate-950 border border-slate-800 rounded-xl p-8 text-center text-slate-500 italic">Nenhuma requisição de peças aberta ou pendente de atendimento para hoje.</div>';
    return;
  }

  container.innerHTML = pendentes.map((requisicao) => {
    const produto = state.produtos.find((item) => item.id === requisicao.produto_id) || {};
    const estoqueSuficiente = produto.estoque_atual >= requisicao.quantidade;
    const statusEstoqueHTML = estoqueSuficiente
      ? `<span class="text-xs text-emerald-400 font-bold bg-emerald-950/40 px-2 py-0.5 rounded border border-emerald-900/50">Disponível em Stock (${produto.estoque_atual} un)</span>`
      : `<span class="text-xs text-rose-500 font-bold bg-rose-950/40 px-2 py-0.5 rounded border border-rose-900/50">Stock Insuficiente! (${produto.estoque_atual} un)</span>`;

    return `
      <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="space-y-2 flex-1">
          <div class="flex items-center space-x-2">
            <span class="bg-amber-950 text-amber-400 border border-amber-900 px-2 py-0.5 rounded text-xs font-semibold uppercase">OS: ${requisicao.os}</span>
            <span class="text-xs text-slate-500">Solicitado por: <b>${requisicao.tecnico}</b> para o setor <b>${requisicao.setor}</b></span>
          </div>
          <h3 class="text-md font-bold text-white">${produto.descricao_resumida} <span class="text-xs font-normal text-slate-400">(Qtd Requerida: ${requisicao.quantidade} un)</span></h3>
          <div class="flex items-center space-x-3 text-xs text-slate-400">
            <span>Tag Equipamento: <b class="text-slate-300">${requisicao.equipamento}</b></span>
            <span>Localização de Recolha: <b class="text-emerald-400 code-font">${produto.localizacao}</b></span>
          </div>
        </div>
        <div class="flex flex-col sm:flex-row items-end md:items-center gap-3">
          ${statusEstoqueHTML}
          <button onclick="atenderRequisicao(${requisicao.id})" ${!estoqueSuficiente ? 'disabled' : ''} class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-500 disabled:opacity-30 text-white font-semibold text-xs px-4 py-2 rounded-lg flex items-center justify-center space-x-1.5 transition-all">
            <i data-lucide="check-circle" class="w-4 h-4"></i>
            <span>Separar & Entregar</span>
          </button>
        </div>
      </div>
    `;
  }).join('');

  if (window.lucide) window.lucide.createIcons();
}
