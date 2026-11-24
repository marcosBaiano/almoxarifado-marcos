import { criarProdutoPayload } from '../models/produtoModel.js';
import { showNotification, closeModal } from './appController.js';
import { registrarMovimentacao } from '../services/estoqueService.js';

export function criarProduto(state, event) {
  event.preventDefault();

  const formData = {
    codigo: document.getElementById('p-codigo').value,
    partNumber: document.getElementById('p-pn').value,
    descricao: document.getElementById('p-descricao').value,
    categoria: document.getElementById('p-categoria').value,
    marca: document.getElementById('p-marca').value,
    preco: document.getElementById('p-preco').value,
    min: document.getElementById('p-min').value,
    max: document.getElementById('p-max').value,
    localizacao: document.getElementById('p-localizacao').value
  };

  if (state.produtos.some((produto) => produto.codigo_interno === formData.codigo.toUpperCase())) {
    showNotification('Já existe um produto registado com este código interno!', 'error');
    return;
  }

  const novoProduto = criarProdutoPayload(formData);
  state.produtos.push(novoProduto);
  state.auditoria.unshift({
    id: state.auditoria.length + 1,
    timestamp: new Date().toISOString().replace('T', ' ').substring(0, 19),
    usuario: 'Manuel Silva',
    evento: 'PROD_CRIADO',
    dados_anteriores: '-',
    dados_novos: JSON.stringify(novoProduto),
    ip: '192.168.10.45'
  });

  showNotification('Novo artigo adicionado ao catálogo com sucesso!');
  closeModal('modal-novo-produto');
  document.getElementById('form-novo-produto').reset();
}

export function processarRecebimento(state, event) {
  event.preventDefault();
  const tipo = document.getElementById('rec-tipo').value;
  const documento = document.getElementById('rec-documento').value;
  const itens = window.itensRecebimentoTemporarios || [];

  if (!itens.length) {
    showNotification('Adicione pelo menos um artigo à lista antes de salvar.', 'error');
    return;
  }

  itens.forEach((item) => {
    registrarMovimentacao(state, item.produto_id, 'ENTRADA', item.quantidade, documento, item.localizacao);
  });

  state.auditoria.unshift({
    id: state.auditoria.length + 1,
    timestamp: new Date().toISOString().replace('T', ' ').substring(0, 19),
    usuario: 'Manuel Silva',
    evento: `RECEBIMENTO_${tipo.toUpperCase()}`,
    dados_anteriores: '-',
    dados_novos: JSON.stringify({ documento, itens }),
    ip: '192.168.10.45'
  });

  showNotification('Entrada de stock processada e lotes registados com sucesso.');
}

export function processarSaida(state, event) {
  event.preventDefault();
  const itens = window.itensSaidaTemporarios || [];

  if (!itens.length) {
    showNotification('Adicione itens de recolha antes de efetuar a saída de stock.', 'error');
    return;
  }

  const os = document.getElementById('sai-os').value;
  const setor = document.getElementById('sai-setor').value;

  try {
    itens.forEach((item) => {
      registrarMovimentacao(state, item.produto_id, 'SAIDA', item.quantidade, os, setor);
    });

    state.auditoria.unshift({
      id: state.auditoria.length + 1,
      timestamp: new Date().toISOString().replace('T', ' ').substring(0, 19),
      usuario: 'Manuel Silva',
      evento: 'SAIDA_OS',
      dados_anteriores: '-',
      dados_novos: JSON.stringify({ os, setor, itens }),
      ip: '192.168.10.45'
    });

    showNotification('Saída efetuada. Stock atualizado com as respetivas baixas.');
  } catch (error) {
    showNotification(error.message, 'error');
  }
}
