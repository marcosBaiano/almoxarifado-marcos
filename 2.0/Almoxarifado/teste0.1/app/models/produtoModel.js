export function isProdutoCritico(produto) {
  return produto.estoque_atual < produto.estoque_minimo;
}

export function filtrarProdutos(produtos, filters = {}) {
  const searchTerm = (filters.search || '').toLowerCase();
  const categoria = filters.categoria || 'todos';
  const stockFilter = filters.stock || 'todos';

  return produtos.filter((produto) => {
    const matchesSearch =
      produto.codigo_interno.toLowerCase().includes(searchTerm) ||
      produto.descricao.toLowerCase().includes(searchTerm) ||
      produto.part_number.toLowerCase().includes(searchTerm);

    const matchesCategory = categoria === 'todos' || produto.categoria === categoria;

    let matchesStock = true;
    if (stockFilter === 'critico') {
      matchesStock = produto.estoque_atual < produto.estoque_minimo;
    } else if (stockFilter === 'seguro') {
      matchesStock = produto.estoque_atual >= produto.estoque_minimo;
    }

    return matchesSearch && matchesCategory && matchesStock;
  });
}

export function criarProdutoPayload(formData) {
  return {
    id: Date.now(),
    codigo_interno: formData.codigo.toUpperCase(),
    part_number: formData.partNumber.toUpperCase(),
    descricao: formData.descricao,
    descricao_resumida: formData.descricao.split(' ').slice(0, 3).join(' '),
    categoria: formData.categoria,
    marca: formData.marca,
    fabricante: 'Forn. Homologado SAMA',
    estoque_minimo: Number(formData.min),
    estoque_maximo: Number(formData.max),
    ponto_reposicao: Math.ceil(Number(formData.min) * 1.5),
    preco_custo_medio: Number(formData.preco),
    lote_control: 'LOT-REG-' + new Date().getFullYear(),
    validade_control: 'N/A',
    localizacao: formData.localizacao.toUpperCase(),
    estoque_atual: 0
  };
}
