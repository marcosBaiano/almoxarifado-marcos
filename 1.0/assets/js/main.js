import {
    applyFilters,
    closeModal,
    openModal,
    renderAuditoria,
    switchTab,
    verDetalhesProduto
} from './modules/ui.js';
import {
    adicionarItemRecebimento,
    adicionarItemSaida,
    atenderRequisicao,
    bootstrapViews,
    criarProduto,
    lancarEstoqueRapidoScanner,
    lancarInventario,
    limparFormRecebimento,
    limparFormSaida,
    processarRecebimento,
    processarSaida,
    removerItemRecebimento,
    removerItemSaida,
    atualizarEstoqueAtualInventario,
    atualizarEstoqueDisponivelSaida
} from './modules/features.js';

Object.assign(window, {
    switchTab,
    applyFilters,
    openModal,
    closeModal,
    verDetalhesProduto,
    atenderRequisicao,
    adicionarItemRecebimento,
    removerItemRecebimento,
    processarRecebimento,
    limparFormRecebimento,
    atualizarEstoqueDisponivelSaida,
    adicionarItemSaida,
    removerItemSaida,
    processarSaida,
    limparFormSaida,
    criarProduto,
    atualizarEstoqueAtualInventario,
    lancarInventario,
    lancarEstoqueRapidoScanner
});

window.onload = function onLoad() {
    bootstrapViews();
    renderAuditoria();
};
