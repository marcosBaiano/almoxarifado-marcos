import { initialState } from './models/state.js';
import { switchTab, openModal, closeModal, showNotification } from './controllers/appController.js';
import { criarProduto, processarRecebimento, processarSaida } from './controllers/produtoController.js';
import { renderDashboard } from './views/dashboardView.js';
import { renderProdutosTable, renderProdutosSelects } from './views/produtosView.js';
import { renderTabelaItensRecebimento } from './views/recebimentoView.js';
import { renderTabelaItensSaida } from './views/saidaView.js';
import { renderRequisicoes } from './views/requisicoesView.js';
import { renderAuditoria } from './views/auditoriaView.js';
import { renderScannerResult, hideScannerResult } from './views/scannerView.js';
import { registrarMovimentacao } from './services/estoqueService.js';

window.state = initialState;
window.itensRecebimentoTemporarios = [];
window.itensSaidaTemporarios = [];

window.switchTab = switchTab;
window.openModal = openModal;
window.closeModal = closeModal;
window.showNotification = showNotification;
window.criarProduto = (event) => criarProduto(window.state, event);
window.processarRecebimento = (event) => processarRecebimento(window.state, event);
window.processarSaida = (event) => processarSaida(window.state, event);

window.formatEuro = (value) => new Intl.NumberFormat('pt-PT', { style: 'currency', currency: 'EUR' }).format(value);

window.adicionarItemRecebimento = function () {
  const produtoId = parseInt(document.getElementById('rec-item-produto').value);
  const qtd = parseInt(document.getElementById('rec-item-qtd').value);
  const preco = parseFloat(document.getElementById('rec-item-preco').value);

  if (Number.isNaN(qtd) || qtd <= 0 || Number.isNaN(preco) || preco <= 0) {
    showNotification('Informe valores reais e válidos para a entrada do artigo.', 'error');
    return;
  }

  const produto = window.state.produtos.find((item) => item.id === produtoId);
  if (!produto) return;

  window.itensRecebimentoTemporarios.push({
    produto_id: produtoId,
    descricao: produto.descricao_resumida,
    localizacao: produto.localizacao,
    lote: produto.lote_control,
    quantidade: qtd,
    preco_unitario: preco,
    subtotal: qtd * preco
  });

  renderTabelaItensRecebimento(window.itensRecebimentoTemporarios, window.formatEuro);
  document.getElementById('rec-item-qtd').value = '';
  document.getElementById('rec-item-preco').value = '';
};

window.removerItemRecebimento = function (idx) {
  window.itensRecebimentoTemporarios.splice(idx, 1);
  renderTabelaItensRecebimento(window.itensRecebimentoTemporarios, window.formatEuro);
};

window.adicionarItemSaida = function () {
  const produtoId = parseInt(document.getElementById('sai-item-produto').value);
  const qtd = parseInt(document.getElementById('sai-item-qtd').value);
  const produto = window.state.produtos.find((item) => item.id === produtoId);

  if (Number.isNaN(qtd) || qtd <= 0) {
    showNotification('Informe uma quantidade válida para retirada.', 'error');
    return;
  }

  if (!produto) return;

  if (produto.estoque_atual < qtd) {
    showNotification(`Quantidade requisitada excede o stock atual de ${produto.estoque_atual} un.`, 'error');
    return;
  }

  window.itensSaidaTemporarios.push({
    produto_id: produtoId,
    descricao: produto.descricao_resumida,
    localizacao: produto.localizacao,
    quantidade: qtd
  });

  renderTabelaItensSaida(window.itensSaidaTemporarios);
  document.getElementById('sai-item-qtd').value = '';
};

window.removerItemSaida = function (idx) {
  window.itensSaidaTemporarios.splice(idx, 1);
  renderTabelaItensSaida(window.itensSaidaTemporarios);
};

window.atualizarEstoqueDisponivelSaida = function () {
  const produtoId = parseInt(document.getElementById('sai-item-produto').value);
  const produto = window.state.produtos.find((item) => item.id === produtoId);
  const element = document.getElementById('sai-estoque-disponivel');
  if (element && produto) {
    element.textContent = `Stock disponível: ${produto.estoque_atual} un`;
  }
};

window.atualizarEstoqueAtualInventario = function () {
  const produtoId = parseInt(document.getElementById('inv-produto').value);
  const produto = window.state.produtos.find((item) => item.id === produtoId);
  const element = document.getElementById('inv-qtd-sistema');
  if (element && produto) {
    element.value = `${produto.estoque_atual} un`;
  }
};

window.lancarInventario = function () {
  const produtoId = parseInt(document.getElementById('inv-produto').value);
  const qtdFisica = parseInt(document.getElementById('inv-qtd-fisica').value);
  if (Number.isNaN(qtdFisica) || qtdFisica < 0) {
    showNotification('Informe um valor de contagem física correto.', 'error');
    return;
  }

  const produto = window.state.produtos.find((item) => item.id === produtoId);
  if (!produto) return;

  registrarMovimentacao(window.state, produto.id, 'AJUSTE', qtdFisica, 'INV-' + new Date().getFullYear(), 'Ajuste Físico de Inventário');
  showNotification('Ajuste de inventário efetuado com registo de auditoria imutável.');
  document.getElementById('inv-qtd-fisica').value = '';
  window.atualizarEstoqueAtualInventario();
};

window.verDetalhesProduto = function (id) {
  const produto = window.state.produtos.find((item) => item.id === id);
  if (!produto) return;

  const container = document.getElementById('modal-detalhes-conteudo');
  const logsRelacionados = window.state.movimentacoes.filter((movimentacao) => movimentacao.produto_id === produto.id);

  const logsHTML = logsRelacionados.length
    ? logsRelacionados.map((movimentacao) => {
        const badgeClass = movimentacao.tipo === 'ENTRADA' ? 'text-emerald-400' : movimentacao.tipo === 'SAIDA' ? 'text-rose-400' : 'text-blue-400';
        return `
          <tr class="border-b border-slate-900 text-xs">
            <td class="py-2 text-slate-400 font-mono">${movimentacao.timestamp}</td>
            <td class="py-2 font-bold ${badgeClass}">${movimentacao.tipo}</td>
            <td class="py-2 text-white font-semibold text-center">${movimentacao.quantidade} un</td>
            <td class="py-2 text-slate-300 font-mono">${movimentacao.documento_ref}</td>
          </tr>`;
      }).join('')
    : '<tr><td colspan="4" class="py-3 text-center text-slate-500 text-xs italic">Nenhuma movimentação registada para este artigo.</td></tr>';

  container.innerHTML = `
    <div class="flex items-center space-x-3 border-b border-slate-800 pb-4 mb-4">
      <div class="bg-blue-950 p-2 rounded-lg text-blue-400">
        <i data-lucide="package-search" class="w-8 h-8"></i>
      </div>
      <div>
        <span class="text-[10px] uppercase font-bold tracking-widest text-blue-400 code-font">${produto.codigo_interno}</span>
        <h3 class="text-xl font-bold text-white">${produto.descricao_resumida}</h3>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-4 text-sm mb-6">
      <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
        <span class="text-[10px] text-slate-500 uppercase block">Part Number / Marca</span>
        <span class="text-white font-semibold block mt-0.5">${produto.part_number} (${produto.marca})</span>
      </div>
      <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
        <span class="text-[10px] text-slate-500 uppercase block">Endereço de Armazenamento</span>
        <span class="text-emerald-400 font-bold block mt-0.5 code-font">${produto.localizacao}</span>
      </div>
      <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
        <span class="text-[10px] text-slate-500 uppercase block">Fabricante & Distribuição</span>
        <span class="text-white block mt-0.5">${produto.fabricante}</span>
      </div>
      <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
        <span class="text-[10px] text-slate-500 uppercase block">Criticidade Mín/Máx</span>
        <span class="text-white block mt-0.5 code-font">Mínimo: ${produto.estoque_minimo} un / Máximo: ${produto.estoque_maximo} un</span>
      </div>
    </div>

    <div>
      <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2 flex items-center">
        <i data-lucide="history" class="w-3.5 h-3.5 text-blue-400 mr-2"></i>
        Card de Rastreabilidade Física do Artigo
      </h4>
      <div class="bg-slate-900 rounded-lg p-3 max-h-48 overflow-y-auto border border-slate-850">
        <table class="w-full text-left">
          <thead>
            <tr class="text-[10px] text-slate-500 uppercase border-b border-slate-800">
              <th class="py-1">Data</th>
              <th class="py-1">Operação</th>
              <th class="py-1 text-center">Quant.</th>
              <th class="py-1">Doc / O.S</th>
            </tr>
          </thead>
          <tbody>${logsHTML}</tbody>
        </table>
      </div>
    </div>
  `;
  openModal('modal-detalhes-produto');
  if (window.lucide) window.lucide.createIcons();
};

window.atenderRequisicao = function (id) {
  const requisicao = window.state.requisicoes.find((item) => item.id === id);
  if (!requisicao) return;

  const produto = window.state.produtos.find((item) => item.id === requisicao.produto_id);
  if (!produto) return;

  try {
    registrarMovimentacao(window.state, produto.id, 'SAIDA', requisicao.quantidade, requisicao.os, requisicao.setor, 'Manuel Silva');
    requisicao.status = 'Atendida';
    showNotification('Requisição processada e peça baixada com sucesso.');
    renderRequisicoes(window.state);
  } catch (error) {
    showNotification(error.message, 'error');
  }
};

window.lancarEstoqueRapidoScanner = function (produtoId, tipo) {
  const qtyInput = document.getElementById('quick-add-qty');
  const qty = parseInt(qtyInput.value);
  if (Number.isNaN(qty) || qty <= 0) {
    showNotification('Informe uma quantidade válida para movimentar via leitor.', 'error');
    return;
  }

  try {
    registrarMovimentacao(window.state, produtoId, tipo, qty, 'SCANNER-AUTOMATICO', 'Scanner de Balcão');
    showNotification(`Transação processada via scanner: ${tipo} de ${qty} un efetuada.`);
    document.getElementById('scanner-result-card').classList.add('hidden');
  } catch (error) {
    showNotification(error.message, 'error');
  }
};

function renderAll() {
  renderDashboard(window.state);
  renderProdutosTable(window.state);
  renderProdutosSelects(window.state);
  renderRequisicoes(window.state);
  renderAuditoria(window.state);
  window.atualizarEstoqueDisponivelSaida();
  window.atualizarEstoqueAtualInventario();
}

window.onload = function () {
  renderAll();
  if (window.lucide) window.lucide.createIcons();
};

window.addEventListener('DOMContentLoaded', () => {
  const scannerInput = document.getElementById('scanner-input');
  if (scannerInput) {
    scannerInput.addEventListener('keypress', function (event) {
      if (event.key === 'Enter') {
        const code = this.value.toUpperCase().trim();
        this.value = '';

        if (code.startsWith('LOC-')) {
          showNotification(`Localização identificada: ${code}`, 'success');
          window.state.auditoria.unshift({
            id: window.state.auditoria.length + 1,
            timestamp: new Date().toISOString().replace('T', ' ').substring(0, 19),
            usuario: 'Manuel Silva',
            evento: 'SCANNER_BIP_LOC',
            dados_anteriores: '-',
            dados_novos: `Endereço bipado: ${code}`,
            ip: '192.168.10.45'
          });
          renderAuditoria(window.state);
          return;
        }

        const produto = window.state.produtos.find((item) => item.codigo_interno === code);
        if (!produto) {
          showNotification(`Nenhum artigo encontrado para o código: ${code}`, 'error');
          hideScannerResult();
          return;
        }

        showNotification(`Artigo Encontrado: ${produto.descricao_resumida}`);
        window.state.auditoria.unshift({
          id: window.state.auditoria.length + 1,
          timestamp: new Date().toISOString().replace('T', ' ').substring(0, 19),
          usuario: 'Manuel Silva',
          evento: 'SCANNER_BIP_PROD',
          dados_anteriores: '-',
          dados_novos: `Artigo bipado: ${code}`,
          ip: '192.168.10.45'
        });
        renderAuditoria(window.state);
        renderScannerResult(produto);
      }
    });
  }
});
