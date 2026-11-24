import { state } from './state.js';
import { AuditoriaService, EstoqueService } from './services.js';
import {
    closeModal,
    formatEuro,
    refreshDashboard,
    renderProdutosSelects,
    renderProdutosTable,
    showNotification
} from './ui.js';

let itensRecebimentoTemporarios = [];
let itensSaidaTemporarios = [];

function atualizarStatusScannerRecebimento(message, isError = false) {
    const statusEl = document.getElementById('rec-scanner-status');
    if (!statusEl) return;

    statusEl.textContent = message;
    statusEl.classList.remove('text-slate-500', 'text-emerald-400', 'text-rose-400');
    if (isError) {
        statusEl.classList.add('text-rose-400');
    } else {
        statusEl.classList.add('text-emerald-400');
    }
}

function initRecebimentoScanner() {
    const scannerInput = document.getElementById('rec-scanner-input');
    if (!scannerInput) return;

    scannerInput.addEventListener('keypress', (e) => {
        if (e.key !== 'Enter') return;

        const code = scannerInput.value.toUpperCase().trim();
        scannerInput.value = '';

        if (!code) return;

        if (code.startsWith('LOC-')) {
            AuditoriaService.log('SCANNER_BIP_REC_LOC', '-', `Endereco bipado no recebimento: ${code}`);
            showNotification(`Localizacao bipada no recebimento: ${code}`);
            atualizarStatusScannerRecebimento(`Localizacao identificada: ${code}.`);
            return;
        }

        const p = state.produtos.find(
            (prod) => prod.codigo_interno === code || prod.part_number === code
        );

        if (!p) {
            showNotification(`Codigo nao localizado para entrada: ${code}`, 'error');
            atualizarStatusScannerRecebimento(`Codigo nao encontrado: ${code}.`, true);
            return;
        }

        const produtoSelect = document.getElementById('rec-item-produto');
        const qtdInput = document.getElementById('rec-item-qtd');

        if (produtoSelect) {
            produtoSelect.value = String(p.id);
        }

        if (qtdInput && !qtdInput.value) {
            qtdInput.value = '1';
        }

        AuditoriaService.log('SCANNER_BIP_REC_PROD', '-', `Artigo bipado no recebimento: ${code}`);
        showNotification(`Artigo preparado para entrada: ${p.descricao_resumida}`);
        atualizarStatusScannerRecebimento(
            `Artigo selecionado: ${p.codigo_interno} - ${p.descricao_resumida}. Informe quantidade/preco e adicione.`
        );

        if (qtdInput) {
            qtdInput.focus();
            qtdInput.select();
        }
    });
}

export function renderRequisicoes() {
    const container = document.getElementById('requisicoes-container');
    container.innerHTML = '';

    const pendentes = state.requisicoes.filter(r => r.status === 'Pendente');

    if (pendentes.length === 0) {
        container.innerHTML = `
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-8 text-center text-slate-500 italic">
                Nenhuma requisicao de pecas aberta ou pendente de atendimento para hoje.
            </div>
        `;
        return;
    }

    pendentes.forEach(r => {
        const p = state.produtos.find(prod => prod.id === r.produto_id) || {};
        const estoqueSuficiente = p.estoque_atual >= r.quantidade;
        const statusEstoqueHTML = estoqueSuficiente
            ? `<span class="text-xs text-emerald-400 font-bold bg-emerald-950/40 px-2 py-0.5 rounded border border-emerald-900/50">Disponivel em Stock (${p.estoque_atual} un)</span>`
            : `<span class="text-xs text-rose-500 font-bold bg-rose-950/40 px-2 py-0.5 rounded border border-rose-900/50">Stock Insuficiente! (${p.estoque_atual} un)</span>`;

        container.innerHTML += `
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="space-y-2 flex-1">
                    <div class="flex items-center space-x-2">
                        <span class="bg-amber-950 text-amber-400 border border-amber-900 px-2 py-0.5 rounded text-xs font-semibold uppercase">OS: ${r.os}</span>
                        <span class="text-xs text-slate-500">Solicitado por: <b>${r.tecnico}</b> para o setor <b>${r.setor}</b></span>
                    </div>
                    <h3 class="text-md font-bold text-white">${p.descricao_resumida} <span class="text-xs font-normal text-slate-400">(Qtd Requerida: ${r.quantidade} un)</span></h3>
                    <div class="flex items-center space-x-3 text-xs text-slate-400">
                        <span>Tag Equipamento: <b class="text-slate-300">${r.equipamento}</b></span>
                        <span>Localizacao de Recolha: <b class="text-emerald-400 code-font">${p.localizacao}</b></span>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-end md:items-center gap-3">
                    ${statusEstoqueHTML}
                    <button onclick="atenderRequisicao(${r.id})" ${!estoqueSuficiente ? 'disabled' : ''} class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-500 disabled:opacity-30 text-white font-semibold text-xs px-4 py-2 rounded-lg flex items-center justify-center space-x-1.5 transition-all">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        <span>Separar & Entregar</span>
                    </button>
                </div>
            </div>
        `;
    });

    lucide.createIcons();
}

export function atenderRequisicao(id) {
    const req = state.requisicoes.find(r => r.id === id);
    if (!req) return;

    const p = state.produtos.find(prod => prod.id === req.produto_id);
    if (!p) return;

    try {
        EstoqueService.registrarMovimentacao(p.id, 'SAIDA', req.quantidade, req.os, req.setor, 'Manuel Silva');
        req.status = 'Atendida';
        showNotification('Requisicao processada e peca baixada com sucesso.');
        renderRequisicoes();
    } catch (err) {
        showNotification(err.message, 'error');
    }
}

export function adicionarItemRecebimento() {
    const produtoId = parseInt(document.getElementById('rec-item-produto').value, 10);
    const qtd = parseInt(document.getElementById('rec-item-qtd').value, 10);
    const preco = parseFloat(document.getElementById('rec-item-preco').value);

    if (Number.isNaN(qtd) || qtd <= 0 || Number.isNaN(preco) || preco <= 0) {
        showNotification('Informe valores reais e validos para a entrada do artigo.', 'error');
        return;
    }

    const p = state.produtos.find(prod => prod.id === produtoId);
    if (!p) return;

    itensRecebimentoTemporarios.push({
        produto_id: produtoId,
        descricao: p.descricao_resumida,
        localizacao: p.localizacao,
        lote: p.lote_control,
        quantidade: qtd,
        preco_unitario: preco,
        subtotal: qtd * preco
    });

    renderTabelaItensRecebimento();
    document.getElementById('rec-item-qtd').value = '';
    document.getElementById('rec-item-preco').value = '';
}

export function removerItemRecebimento(idx) {
    itensRecebimentoTemporarios.splice(idx, 1);
    renderTabelaItensRecebimento();
}

function renderTabelaItensRecebimento() {
    const tbody = document.getElementById('tabela-itens-recebimento');
    tbody.innerHTML = '';

    if (itensRecebimentoTemporarios.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="py-8 text-center text-slate-500 italic">Nenhum item adicionado ao lancamento.</td></tr>';
        return;
    }

    itensRecebimentoTemporarios.forEach((item, index) => {
        tbody.innerHTML += `
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
        `;
    });

    lucide.createIcons();
}

export function processarRecebimento(e) {
    e.preventDefault();

    if (itensRecebimentoTemporarios.length === 0) {
        showNotification('Adicione pelo menos um artigo a lista antes de salvar.', 'error');
        return;
    }

    const doc = document.getElementById('rec-documento').value;

    itensRecebimentoTemporarios.forEach(item => {
        EstoqueService.registrarMovimentacao(item.produto_id, 'ENTRADA', item.quantidade, doc, item.localizacao);
    });

    showNotification('Entrada de stock processada e lotes registados com sucesso.');
    limparFormRecebimento();
}

export function limparFormRecebimento() {
    itensRecebimentoTemporarios = [];
    document.getElementById('form-recebimento').reset();
    renderTabelaItensRecebimento();
}

export function atualizarEstoqueDisponivelSaida() {
    const produtoId = parseInt(document.getElementById('sai-item-produto').value, 10);
    const p = state.produtos.find(prod => prod.id === produtoId);
    if (p) {
        document.getElementById('sai-estoque-disponivel').textContent = `Stock disponivel: ${p.estoque_atual} un`;
    }
}

export function adicionarItemSaida() {
    const produtoId = parseInt(document.getElementById('sai-item-produto').value, 10);
    const qtd = parseInt(document.getElementById('sai-item-qtd').value, 10);

    if (Number.isNaN(qtd) || qtd <= 0) {
        showNotification('Informe uma quantidade valida para retirada.', 'error');
        return;
    }

    const p = state.produtos.find(prod => prod.id === produtoId);
    if (!p) return;

    if (p.estoque_atual < qtd) {
        showNotification(`Quantidade requisitada excede o stock atual de ${p.estoque_atual} un.`, 'error');
        return;
    }

    itensSaidaTemporarios.push({
        produto_id: produtoId,
        descricao: p.descricao_resumida,
        localizacao: p.localizacao,
        quantidade: qtd
    });

    renderTabelaItensSaida();
    document.getElementById('sai-item-qtd').value = '';
}

export function removerItemSaida(idx) {
    itensSaidaTemporarios.splice(idx, 1);
    renderTabelaItensSaida();
}

function renderTabelaItensSaida() {
    const tbody = document.getElementById('tabela-itens-saida');
    tbody.innerHTML = '';

    if (itensSaidaTemporarios.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="py-8 text-center text-slate-500 italic">Nenhuma peca adicionada para saida.</td></tr>';
        return;
    }

    itensSaidaTemporarios.forEach((item, index) => {
        tbody.innerHTML += `
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
        `;
    });

    lucide.createIcons();
}

export function processarSaida(e) {
    e.preventDefault();

    if (itensSaidaTemporarios.length === 0) {
        showNotification('Adicione itens de recolha antes de efetuar a saida de stock.', 'error');
        return;
    }

    const os = document.getElementById('sai-os').value;
    const setor = document.getElementById('sai-setor').value;

    try {
        itensSaidaTemporarios.forEach(item => {
            EstoqueService.registrarMovimentacao(item.produto_id, 'SAIDA', item.quantidade, os, setor);
        });
        showNotification('Saida efetuada. Stock atualizado com as respetivas baixas.');
        limparFormSaida();
    } catch (err) {
        showNotification(err.message, 'error');
    }
}

export function limparFormSaida() {
    itensSaidaTemporarios = [];
    document.getElementById('form-saida').reset();
    renderTabelaItensSaida();
    atualizarEstoqueDisponivelSaida();
}

export function criarProduto(e) {
    e.preventDefault();

    const codigo = document.getElementById('p-codigo').value.toUpperCase();
    const pn = document.getElementById('p-pn').value.toUpperCase();
    const desc = document.getElementById('p-descricao').value;
    const categoria = document.getElementById('p-categoria').value;
    const marca = document.getElementById('p-marca').value;
    const preco = parseFloat(document.getElementById('p-preco').value);
    const min = parseInt(document.getElementById('p-min').value, 10);
    const max = parseInt(document.getElementById('p-max').value, 10);
    const loc = document.getElementById('p-localizacao').value.toUpperCase();

    if (state.produtos.some(p => p.codigo_interno === codigo)) {
        showNotification('Ja existe um produto registado com este codigo interno!', 'error');
        return;
    }

    const novoPrd = {
        id: state.produtos.length + 1,
        codigo_interno: codigo,
        part_number: pn,
        descricao: desc,
        descricao_resumida: desc.split(' ').slice(0, 3).join(' '),
        categoria,
        marca,
        fabricante: 'Forn. Homologado SAMA',
        estoque_minimo: min,
        estoque_maximo: max,
        ponto_reposicao: Math.ceil(min * 1.5),
        preco_custo_medio: preco,
        lote_control: `LOT-REG-${new Date().getFullYear()}`,
        validade_control: 'N/A',
        localizacao: loc,
        estoque_atual: 0
    };

    state.produtos.push(novoPrd);
    AuditoriaService.log('PROD_CRIADO', '-', novoPrd);

    showNotification('Novo artigo adicionado ao catalogo com sucesso!');
    closeModal('modal-novo-produto');
    document.getElementById('form-novo-produto').reset();

    renderProdutosTable();
    renderProdutosSelects();
    refreshDashboard();
}

export function atualizarEstoqueAtualInventario() {
    const produtoId = parseInt(document.getElementById('inv-produto').value, 10);
    const p = state.produtos.find(prod => prod.id === produtoId);
    if (p) {
        document.getElementById('inv-qtd-sistema').value = `${p.estoque_atual} un`;
    }
}

export function lancarInventario() {
    const produtoId = parseInt(document.getElementById('inv-produto').value, 10);
    const qtdFisica = parseInt(document.getElementById('inv-qtd-fisica').value, 10);

    if (Number.isNaN(qtdFisica) || qtdFisica < 0) {
        showNotification('Informe um valor de contagem fisica correto.', 'error');
        return;
    }

    const p = state.produtos.find(prod => prod.id === produtoId);
    if (!p) return;

    EstoqueService.registrarMovimentacao(p.id, 'AJUSTE', qtdFisica, `INV-${new Date().getFullYear()}`, 'Ajuste Fisico de Inventario');
    showNotification('Ajuste de inventario efetuado com registo de auditoria imutavel.');

    document.getElementById('inv-qtd-fisica').value = '';
    atualizarEstoqueAtualInventario();
}

export function initScanner() {
    const scannerInput = document.getElementById('scanner-input');

    scannerInput.addEventListener('keypress', function onScannerKeypress(e) {
        if (e.key !== 'Enter') return;

        const code = scannerInput.value.toUpperCase().trim();
        scannerInput.value = '';

        if (code.startsWith('LOC-')) {
            showNotification(`Localizacao identificada: ${code}`, 'success');
            AuditoriaService.log('SCANNER_BIP_LOC', '-', `Endereco bipado: ${code}`);
            return;
        }

        const p = state.produtos.find(prod => prod.codigo_interno === code);
        const resultCard = document.getElementById('scanner-result-card');

        if (!p) {
            showNotification(`Nenhum artigo encontrado para o codigo: ${code}`, 'error');
            resultCard.classList.add('hidden');
            return;
        }

        showNotification(`Artigo Encontrado: ${p.descricao_resumida}`);
        AuditoriaService.log('SCANNER_BIP_PROD', '-', `Artigo bipado: ${code}`);

        resultCard.classList.remove('hidden');
        resultCard.innerHTML = `
            <div class="flex items-start justify-between border-b border-slate-800 pb-4 mb-4">
                <div>
                    <span class="text-xs font-mono text-blue-400 font-bold block">${p.codigo_interno}</span>
                    <h3 class="text-lg font-bold text-white">${p.descricao_resumida}</h3>
                    <p class="text-xs text-slate-400">${p.descricao}</p>
                </div>
                <div class="bg-emerald-950/50 border border-emerald-900 px-3 py-1.5 rounded text-center">
                    <span class="text-[10px] text-slate-400 uppercase block font-semibold">Endereco</span>
                    <span class="text-sm font-mono font-bold text-emerald-400">${p.localizacao}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 text-xs mb-4">
                <div class="bg-slate-900 p-2 rounded">
                    <span class="text-slate-500 uppercase block">Stock Atual</span>
                    <span class="text-sm font-bold text-white">${p.estoque_atual} un</span>
                </div>
                <div class="bg-slate-900 p-2 rounded">
                    <span class="text-slate-500 uppercase block">Lote / Validade</span>
                    <span class="text-sm font-bold text-white font-mono">${p.lote_control} / ${p.validade_control}</span>
                </div>
            </div>

            <div class="flex items-center space-x-2 pt-2">
                <input type="number" id="quick-add-qty" placeholder="Quant." class="w-24 bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm text-center text-slate-200 focus:outline-none focus:border-blue-500">
                <button onclick="lancarEstoqueRapidoScanner(${p.id}, 'SAIDA')" class="bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs px-4 py-2.5 rounded-lg flex-1 transition-all">
                    Baixar Stock
                </button>
                <button onclick="lancarEstoqueRapidoScanner(${p.id}, 'ENTRADA')" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs px-4 py-2.5 rounded-lg flex-1 transition-all">
                    Dar Entrada
                </button>
            </div>
        `;
    });
}

export function lancarEstoqueRapidoScanner(produtoId, tipo) {
    const qtyInput = document.getElementById('quick-add-qty');
    const qty = parseInt(qtyInput.value, 10);

    if (Number.isNaN(qty) || qty <= 0) {
        showNotification('Informe uma quantidade valida para movimentar via leitor.', 'error');
        return;
    }

    try {
        EstoqueService.registrarMovimentacao(produtoId, tipo, qty, 'SCANNER-AUTOMATICO', 'Scanner de Balcao');
        showNotification(`Transacao processada via scanner: ${tipo} de ${qty} un efetuada.`);
        document.getElementById('scanner-result-card').classList.add('hidden');
    } catch (err) {
        showNotification(err.message, 'error');
    }
}

export function bootstrapViews() {
    refreshDashboard();
    renderProdutosTable();
    renderProdutosSelects();
    renderRequisicoes();

    atualizarEstoqueDisponivelSaida();
    atualizarEstoqueAtualInventario();

    lucide.createIcons();
    initRecebimentoScanner();
    initScanner();
}
