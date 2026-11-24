import { filtrarProdutos } from '../models/produtoModel.js';

export function renderProdutosTable(state) {
  const tableBody = document.getElementById('produtos-table-body');
  if (!tableBody) return;

  const searchTerm = document.getElementById('filter-search').value.toLowerCase();
  const categoria = document.getElementById('filter-categoria').value;
  const stockFilter = document.getElementById('filter-estoque').value;

  const filtered = filtrarProdutos(state.produtos, {
    search: searchTerm,
    categoria,
    stock: stockFilter
  });

  if (!filtered.length) {
    tableBody.innerHTML = '<tr><td colspan="8" class="py-12 text-center text-slate-500 italic">Nenhum artigo encontrado com as especificações atuais de busca.</td></tr>';
    return;
  }

  tableBody.innerHTML = filtered.map((produto) => {
    const isCritico = produto.estoque_atual < produto.estoque_minimo;
    const statusStockClass = isCritico
      ? 'text-rose-400 bg-rose-950/40 border border-rose-900/60'
      : 'text-emerald-400 bg-emerald-950/40 border border-emerald-900/40';

    return `
      <tr class="hover:bg-slate-900/40 transition-colors">
        <td class="py-4 px-4 font-semibold text-slate-300 code-font">
          <span class="block">${produto.codigo_interno}</span>
          <span class="text-[11px] text-slate-500 block">P/N: ${produto.part_number}</span>
        </td>
        <td class="py-4 px-4">
          <span class="font-bold text-white block">${produto.descricao_resumida}</span>
          <span class="text-xs text-slate-400 block">${produto.descricao}</span>
        </td>
        <td class="py-4 px-4">
          <span class="text-xs text-slate-300 bg-slate-800 px-2 py-0.5 rounded border border-slate-700">${produto.categoria}</span>
        </td>
        <td class="py-4 px-4 text-center text-xs text-slate-300 font-bold code-font">${produto.localizacao}</td>
        <td class="py-4 px-4 text-center text-xs text-slate-400 code-font">${produto.estoque_minimo} / ${produto.estoque_maximo}</td>
        <td class="py-4 px-4 text-right font-medium text-slate-200 code-font">${formatEuro(produto.preco_custo_medio)}</td>
        <td class="py-4 px-4 text-center">
          <span class="px-2.5 py-1 rounded text-xs font-bold code-font ${statusStockClass}">${produto.estoque_atual} un</span>
        </td>
        <td class="py-4 px-4 text-center">
          <button onclick="verDetalhesProduto(${produto.id})" class="text-xs bg-slate-800 hover:bg-slate-700 text-blue-400 font-semibold px-2.5 py-1.5 rounded-lg border border-slate-700 transition-all inline-flex items-center space-x-1">
            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
            <span>Rastrear</span>
          </button>
        </td>
      </tr>
    `;
  }).join('');

  if (window.lucide) {
    window.lucide.createIcons();
  }
}

export function renderProdutosSelects(state) {
  const recSelect = document.getElementById('rec-item-produto');
  const saiSelect = document.getElementById('sai-item-produto');
  const invSelect = document.getElementById('inv-produto');

  if (!recSelect || !saiSelect || !invSelect) return;

  const options = state.produtos.map((produto) => `<option value="${produto.id}">${produto.codigo_interno} - ${produto.descricao_resumida}</option>`).join('');
  recSelect.innerHTML = options;
  saiSelect.innerHTML = options;
  invSelect.innerHTML = options;
}

function formatEuro(value) {
  return new Intl.NumberFormat('pt-PT', { style: 'currency', currency: 'EUR' }).format(value);
}
