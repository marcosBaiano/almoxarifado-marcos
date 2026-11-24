export function renderTabelaItensRecebimento(itens, formatEuro) {
  const tbody = document.getElementById('tabela-itens-recebimento');
  if (!tbody) return;

  if (!itens.length) {
    tbody.innerHTML = '<tr><td colspan="7" class="py-8 text-center text-slate-500 italic">Nenhum item adicionado ao lançamento.</td></tr>';
    return;
  }

  tbody.innerHTML = itens.map((item, index) => `
    <tr>
      <td class="py-2.5 px-4 font-bold text-white">${item.descricao}</td>
      <td class="py-2.5 px-4 text-center text-slate-400 code-font">${item.lote}</td>
      <td class="py-2.5 px-4 text-center text-emerald-400 font-semibold code-font">${item.localizacao}</td>
      <td class="py-2.5 px-4 text-center font-bold text-slate-200">${item.quantidade} un</td>
      <td class="py-2.5 px-4 text-right font-mono text-slate-300">${formatEuro(item.preco_unitario)}</td>
      <td class="py-2.5 px-4 text-right font-mono text-emerald-400 font-semibold">${formatEuro(item.subtotal)}</td>
      <td class="py-2.5 px-4 text-center">
        <button type="button" onclick="removerItemRecebimento(${index})" class="text-rose-500 hover:text-rose-400">
          <i data-lucide="trash-2" class="w-4 h-4 inline"></i>
        </button>
      </td>
    </tr>
  `).join('');

  if (window.lucide) window.lucide.createIcons();
}
