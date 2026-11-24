export function renderScannerResult(produto) {
  const resultCard = document.getElementById('scanner-result-card');
  if (!resultCard) return;

  resultCard.classList.remove('hidden');
  resultCard.innerHTML = `
    <div class="flex items-start justify-between border-b border-slate-800 pb-4 mb-4">
      <div>
        <span class="text-xs font-mono text-blue-400 font-bold block">${produto.codigo_interno}</span>
        <h3 class="text-lg font-bold text-white">${produto.descricao_resumida}</h3>
        <p class="text-xs text-slate-400">${produto.descricao}</p>
      </div>
      <div class="bg-emerald-950/50 border border-emerald-900 px-3 py-1.5 rounded text-center">
        <span class="text-[10px] text-slate-400 uppercase block font-semibold">Endereço</span>
        <span class="text-sm font-mono font-bold text-emerald-400">${produto.localizacao}</span>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-4 text-xs mb-4">
      <div class="bg-slate-900 p-2 rounded">
        <span class="text-slate-500 uppercase block">Stock Atual</span>
        <span class="text-sm font-bold text-white">${produto.estoque_atual} un</span>
      </div>
      <div class="bg-slate-900 p-2 rounded">
        <span class="text-slate-500 uppercase block">Lote / Validade</span>
        <span class="text-sm font-bold text-white font-mono">${produto.lote_control} / ${produto.validade_control}</span>
      </div>
    </div>

    <div class="flex items-center space-x-2 pt-2">
      <input type="number" id="quick-add-qty" placeholder="Quant." class="w-24 bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm text-center text-slate-200 focus:outline-none focus:border-blue-500">
      <button onclick="lancarEstoqueRapidoScanner(${produto.id}, 'SAIDA')" class="bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs px-4 py-2.5 rounded-lg flex-1 transition-all">Baixar Stock</button>
      <button onclick="lancarEstoqueRapidoScanner(${produto.id}, 'ENTRADA')" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs px-4 py-2.5 rounded-lg flex-1 transition-all">Dar Entrada</button>
    </div>
  `;
}

export function hideScannerResult() {
  const resultCard = document.getElementById('scanner-result-card');
  if (resultCard) resultCard.classList.add('hidden');
}
