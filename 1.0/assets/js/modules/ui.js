import { state } from './state.js';

export function switchTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
    document.getElementById(`tab-${tabId}`).classList.remove('hidden');

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('bg-blue-600', 'text-white', 'font-medium');
        btn.classList.add('text-slate-400', 'hover:text-slate-200', 'hover:bg-slate-900');
    });

    const activeBtn = document.getElementById(`btn-${tabId}`);
    if (activeBtn) {
        activeBtn.classList.remove('text-slate-400', 'hover:text-slate-200', 'hover:bg-slate-900');
        activeBtn.classList.add('bg-blue-600', 'text-white', 'font-medium');
    }
}

export function showNotification(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');

    toastMessage.textContent = message;

    if (type === 'error') {
        toast.classList.remove('bg-emerald-600', 'border-emerald-500');
        toast.classList.add('bg-rose-600', 'border-rose-500');
    } else {
        toast.classList.remove('bg-rose-600', 'border-rose-500');
        toast.classList.add('bg-emerald-600', 'border-emerald-500');
    }

    toast.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');

    setTimeout(() => {
        toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
    }, 3000);
}

export function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

export function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

export function formatEuro(val) {
    return new Intl.NumberFormat('pt-PT', { style: 'currency', currency: 'EUR' }).format(val);
}

export function refreshDashboard() {
    document.getElementById('kpi-total-produtos').textContent = state.produtos.length;

    const criticos = state.produtos.filter(p => p.estoque_atual < p.estoque_minimo);
    document.getElementById('kpi-estoque-critico').textContent = criticos.length;

    const pendentes = state.requisicoes.filter(r => r.status === 'Pendente');
    document.getElementById('kpi-req-pendentes').textContent = pendentes.length;

    const valorTotal = state.produtos.reduce((acc, curr) => acc + (curr.estoque_atual * curr.preco_custo_medio), 0);
    document.getElementById('kpi-valor-estoque').textContent = formatEuro(valorTotal);

    const alertasContainer = document.getElementById('alertas-criticos-container');
    alertasContainer.innerHTML = '';

    if (criticos.length === 0) {
        alertasContainer.innerHTML = `
            <div class="bg-emerald-950/20 border border-emerald-900/60 p-4 rounded-lg text-center text-emerald-400 text-xs font-semibold">
                Nenhum produto em nivel critico de stock.
            </div>
        `;
    } else {
        criticos.forEach(p => {
            alertasContainer.innerHTML += `
                <div class="bg-rose-950/20 border border-rose-900/40 p-3 rounded-lg flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-white block">${p.descricao_resumida}</span>
                        <span class="text-[10px] text-slate-400 block code-font">${p.codigo_interno} • Part Number: ${p.part_number}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-rose-400 font-bold block">${p.estoque_atual} de ${p.estoque_minimo} Min</span>
                        <span class="text-[9px] text-slate-500 uppercase font-semibold">Reposicao Critica</span>
                    </div>
                </div>
            `;
        });
    }

    const dashboardMovsTable = document.getElementById('dashboard-movimentacoes-table');
    dashboardMovsTable.innerHTML = '';

    state.movimentacoes.slice(0, 5).forEach(m => {
        const produto = state.produtos.find(p => p.id === m.produto_id) || {};
        const badges = {
            ENTRADA: 'bg-emerald-950 text-emerald-400 border border-emerald-900/50',
            SAIDA: 'bg-rose-950 text-rose-400 border border-rose-900/50',
            AJUSTE: 'bg-blue-950 text-blue-400 border border-blue-900/50'
        };

        dashboardMovsTable.innerHTML += `
            <tr>
                <td class="py-3 px-4 text-xs text-slate-400 font-medium code-font">${m.timestamp}</td>
                <td class="py-3 px-4">
                    <span class="font-bold text-white block">${produto.descricao_resumida || 'Peca Desconhecida'}</span>
                    <span class="text-xs text-slate-500 code-font">${produto.codigo_interno || ''}</span>
                </td>
                <td class="py-3 px-4">
                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold tracking-wider uppercase ${badges[m.tipo]}">${m.tipo}</span>
                </td>
                <td class="py-3 px-4 font-semibold text-white text-center">${m.quantidade} un</td>
                <td class="py-3 px-4 text-xs text-slate-400">${m.destino}</td>
                <td class="py-3 px-4 text-xs font-bold text-slate-300 code-font">${m.documento_ref}</td>
                <td class="py-3 px-4 text-xs text-slate-400">${m.operador}</td>
            </tr>
        `;
    });
}

export function renderProdutosTable() {
    const tableBody = document.getElementById('produtos-table-body');
    tableBody.innerHTML = '';

    const searchTerm = document.getElementById('filter-search').value.toLowerCase();
    const catFilter = document.getElementById('filter-categoria').value;
    const stockFilter = document.getElementById('filter-estoque').value;

    const filtered = state.produtos.filter(p => {
        const matchesSearch = p.codigo_interno.toLowerCase().includes(searchTerm)
            || p.descricao.toLowerCase().includes(searchTerm)
            || p.part_number.toLowerCase().includes(searchTerm);

        const matchesCat = catFilter === 'todos' || p.categoria === catFilter;

        let matchesStock = true;
        if (stockFilter === 'critico') {
            matchesStock = p.estoque_atual < p.estoque_minimo;
        } else if (stockFilter === 'seguro') {
            matchesStock = p.estoque_atual >= p.estoque_minimo;
        }

        return matchesSearch && matchesCat && matchesStock;
    });

    if (filtered.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="8" class="py-12 text-center text-slate-500 italic">Nenhum artigo encontrado com as especificacoes atuais de busca.</td>
            </tr>
        `;
        return;
    }

    filtered.forEach(p => {
        const isCritico = p.estoque_atual < p.estoque_minimo;
        const statusStockClass = isCritico
            ? 'text-rose-400 bg-rose-950/40 border border-rose-900/60'
            : 'text-emerald-400 bg-emerald-950/40 border border-emerald-900/40';

        tableBody.innerHTML += `
            <tr class="hover:bg-slate-900/40 transition-colors">
                <td class="py-4 px-4 font-semibold text-slate-300 code-font">
                    <span class="block">${p.codigo_interno}</span>
                    <span class="text-[11px] text-slate-500 block">P/N: ${p.part_number}</span>
                </td>
                <td class="py-4 px-4">
                    <span class="font-bold text-white block">${p.descricao_resumida}</span>
                    <span class="text-xs text-slate-400 block">${p.descricao}</span>
                </td>
                <td class="py-4 px-4">
                    <span class="text-xs text-slate-300 bg-slate-800 px-2 py-0.5 rounded border border-slate-700">${p.categoria}</span>
                </td>
                <td class="py-4 px-4 text-center text-xs text-slate-300 font-bold code-font">${p.localizacao}</td>
                <td class="py-4 px-4 text-center text-xs text-slate-400 code-font">${p.estoque_minimo} / ${p.estoque_maximo}</td>
                <td class="py-4 px-4 text-right font-medium text-slate-200 code-font">${formatEuro(p.preco_custo_medio)}</td>
                <td class="py-4 px-4 text-center">
                    <span class="px-2.5 py-1 rounded text-xs font-bold code-font ${statusStockClass}">
                        ${p.estoque_atual} un
                    </span>
                </td>
                <td class="py-4 px-4 text-center">
                    <button onclick="verDetalhesProduto(${p.id})" class="text-xs bg-slate-800 hover:bg-slate-700 text-blue-400 font-semibold px-2.5 py-1.5 rounded-lg border border-slate-700 transition-all inline-flex items-center space-x-1">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                        <span>Rastrear</span>
                    </button>
                </td>
            </tr>
        `;
    });

    lucide.createIcons();
}

export function renderProdutosSelects() {
    const recSelect = document.getElementById('rec-item-produto');
    const saiSelect = document.getElementById('sai-item-produto');
    const invSelect = document.getElementById('inv-produto');

    const options = state.produtos.map(p => `<option value="${p.id}">${p.codigo_interno} - ${p.descricao_resumida}</option>`).join('');

    recSelect.innerHTML = options;
    saiSelect.innerHTML = options;
    invSelect.innerHTML = options;
}

export function renderAuditoria() {
    const container = document.getElementById('auditoria-table-body');
    container.innerHTML = '';

    state.auditoria.forEach(a => {
        container.innerHTML += `
            <tr class="hover:bg-slate-900/20">
                <td class="py-3 px-4 text-slate-400 font-mono">${a.timestamp}</td>
                <td class="py-3 px-4 font-bold text-slate-300">${a.usuario}</td>
                <td class="py-3 px-4 font-semibold text-amber-500">${a.evento}</td>
                <td class="py-3 px-4 text-slate-400 max-w-xs truncate" title='${a.dados_anteriores}'>${a.dados_anteriores}</td>
                <td class="py-3 px-4 text-slate-300 max-w-xs truncate" title='${a.dados_novos}'>${a.dados_novos}</td>
                <td class="py-3 px-4 text-slate-500 font-mono">${a.ip}</td>
            </tr>
        `;
    });
}

export function applyFilters() {
    renderProdutosTable();
}

export function verDetalhesProduto(id) {
    const p = state.produtos.find(prod => prod.id === id);
    if (!p) return;

    const container = document.getElementById('modal-detalhes-conteudo');
    const logsRelacionados = state.movimentacoes.filter(m => m.produto_id === p.id);

    let logsHTML = '';
    if (logsRelacionados.length === 0) {
        logsHTML = '<tr><td colspan="4" class="py-3 text-center text-slate-500 text-xs italic">Nenhuma movimentacao registada para este artigo.</td></tr>';
    } else {
        logsRelacionados.forEach(m => {
            const badgeClass = m.tipo === 'ENTRADA' ? 'text-emerald-400' : m.tipo === 'SAIDA' ? 'text-rose-400' : 'text-blue-400';
            logsHTML += `
                <tr class="border-b border-slate-900 text-xs">
                    <td class="py-2 text-slate-400 font-mono">${m.timestamp}</td>
                    <td class="py-2 font-bold ${badgeClass}">${m.tipo}</td>
                    <td class="py-2 text-white font-semibold text-center">${m.quantidade} un</td>
                    <td class="py-2 text-slate-300 font-mono">${m.documento_ref}</td>
                </tr>
            `;
        });
    }

    container.innerHTML = `
        <div class="flex items-center space-x-3 border-b border-slate-800 pb-4 mb-4">
            <div class="bg-blue-950 p-2 rounded-lg text-blue-400">
                <i data-lucide="package-search" class="w-8 h-8"></i>
            </div>
            <div>
                <span class="text-[10px] uppercase font-bold tracking-widest text-blue-400 code-font">${p.codigo_interno}</span>
                <h3 class="text-xl font-bold text-white">${p.descricao_resumida}</h3>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm mb-6">
            <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                <span class="text-[10px] text-slate-500 uppercase block">Part Number / Marca</span>
                <span class="text-white font-semibold block mt-0.5">${p.part_number} (${p.marca})</span>
            </div>
            <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                <span class="text-[10px] text-slate-500 uppercase block">Endereco de Armazenamento</span>
                <span class="text-emerald-400 font-bold block mt-0.5 code-font">${p.localizacao}</span>
            </div>
            <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                <span class="text-[10px] text-slate-500 uppercase block">Fabricante & Distribuicao</span>
                <span class="text-white block mt-0.5">${p.fabricante}</span>
            </div>
            <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                <span class="text-[10px] text-slate-500 uppercase block">Criticidade Min/Max</span>
                <span class="text-white block mt-0.5 code-font">Minimo: ${p.estoque_minimo} un / Maximo: ${p.estoque_maximo} un</span>
            </div>
        </div>

        <div>
            <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2 flex items-center">
                <i data-lucide="history" class="w-3.5 h-3.5 text-blue-400 mr-2"></i>
                Card de Rastreabilidade Fisica do Artigo
            </h4>
            <div class="bg-slate-900 rounded-lg p-3 max-h-48 overflow-y-auto border border-slate-850">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] text-slate-500 uppercase border-b border-slate-800">
                            <th class="py-1">Data</th>
                            <th class="py-1">Operacao</th>
                            <th class="py-1 text-center">Quant.</th>
                            <th class="py-1">Doc / O.S</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${logsHTML}
                    </tbody>
                </table>
            </div>
        </div>
    `;

    openModal('modal-detalhes-produto');
    lucide.createIcons();
}
