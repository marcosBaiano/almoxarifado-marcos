export function renderAuditoria(state) {
  const container = document.getElementById('auditoria-table-body');
  if (!container) return;

  container.innerHTML = state.auditoria.map((item) => `
    <tr class="hover:bg-slate-900/20">
      <td class="py-3 px-4 text-slate-400 font-mono">${item.timestamp}</td>
      <td class="py-3 px-4 font-bold text-slate-300">${item.usuario}</td>
      <td class="py-3 px-4 font-semibold text-amber-500">${item.evento}</td>
      <td class="py-3 px-4 text-slate-400 max-w-xs truncate" title='${item.dados_anteriores}'>${item.dados_anteriores}</td>
      <td class="py-3 px-4 text-slate-300 max-w-xs truncate" title='${item.dados_novos}'>${item.dados_novos}</td>
      <td class="py-3 px-4 text-slate-500 font-mono">${item.ip}</td>
    </tr>
  `).join('');
}
