export function renderTabelaItensSaida(itens) {
  const tbody = document.getElementById('tabela-itens-saida');
  if (!tbody) return;

  if (!itens.length) {
    tbody.innerHTML = '<tr><td colspan="4" class="py-8 text-center text-slate-500 italic">Nenhuma peça adicionada para saída.</td></tr>';
    return;
  }

  tbody.innerHTML = itens.map((item, index) => `
    <tr>
      <td class="py-2.5 px-4 font-bold text-white">${item.descricao}</td>
      <td class="py-2.5 px-4 text-center text-emerald-400 font-semibold code-font">${item.localizacao}</td>
      <td class="py-2.5 px-4 text-center font-bold text-slate-200">${item.quantidade} un</td>
      <td class="py-2.5 px-4 text-center">
        <button type="button" onclick="removerItemSaida(${index})" class="text-rose-500 hover:text-rose-400">
          <i data-lucide="trash-2" class="w-4 h-4 inline"></i>
        </button>
      </td>
    </tr>
  `).join('');

  if (window.lucide) window.lucide.createIcons();
}
