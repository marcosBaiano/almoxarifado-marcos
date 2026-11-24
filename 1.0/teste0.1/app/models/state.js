export const initialState = {
  produtos: [
    {
      id: 1,
      codigo_interno: '7896643412170',
      part_number: 'PN-6204-C3',
      descricao: 'Rolamento Rígido de Esferas de Alta Precisão',
      descricao_resumida: 'Rolamento 6204-C3',
      categoria: 'Mecânica',
      marca: 'SKF',
      fabricante: 'SKF do Brasil S.A.',
      estoque_minimo: 10,
      estoque_maximo: 50,
      ponto_reposicao: 15,
      preco_custo_medio: 45.5,
      lote_control: 'LOT-2026/A',
      validade_control: '2030-12-31',
      localizacao: 'LOC-A1-E3',
      estoque_atual: 8
    },
    {
      id: 2,
      codigo_interno: 'PRD1002',
      part_number: 'PN-CON-90',
      descricao: 'Contator Trifásico de Potência 24VCC 9A',
      descricao_resumida: 'Contator Trifásico 9A',
      categoria: 'Elétrica',
      marca: 'WEG',
      fabricante: 'WEG Equipamentos S.A.',
      estoque_minimo: 5,
      estoque_maximo: 20,
      ponto_reposicao: 8,
      preco_custo_medio: 120,
      lote_control: 'N/A',
      validade_control: 'N/A',
      localizacao: 'LOC-E3-P2',
      estoque_atual: 14
    },
    {
      id: 3,
      codigo_interno: 'PRD1003',
      part_number: 'PN-VLV-12',
      descricao: 'Eletroválvula de Controle Direcional 5/2 vias G1/4',
      descricao_resumida: 'Eletroválvula 5/2 vias',
      categoria: 'Pneumática',
      marca: 'Festo',
      fabricante: 'Festo Portugal Lda.',
      estoque_minimo: 4,
      estoque_maximo: 15,
      ponto_reposicao: 6,
      preco_custo_medio: 280,
      lote_control: 'N/A',
      validade_control: 'N/A',
      localizacao: 'LOC-P1-R4',
      estoque_atual: 3
    }
  ],
  movimentacoes: [
    {
      id: 1,
      produto_id: 1,
      timestamp: '2026-07-14 09:30:15',
      tipo: 'SAIDA',
      quantidade: 2,
      saldo_anterior: 10,
      saldo_posterior: 8,
      documento_ref: 'OS-2026-0043',
      operador: 'Manuel Silva',
      destino: 'Linha de Injeção Plástica'
    }
  ],
  auditoria: [
    {
      id: 1,
      timestamp: '2026-07-14 08:00:00',
      usuario: 'Manuel Silva',
      evento: 'LOGIN_SISTEMA',
      dados_anteriores: '-',
      dados_novos: 'Sessão iniciada via IP 192.168.10.45',
      ip: '192.168.10.45'
    }
  ],
  requisicoes: [
    {
      id: 1,
      os: 'OS-2026-0050',
      tecnico: 'Vítor Martins',
      setor: 'Linha de Injeção Plástica',
      equipamento: 'Injetora Romi 300T',
      produto_id: 1,
      quantidade: 2,
      status: 'Pendente'
    }
  ]
};

export function cloneState(state) {
  return JSON.parse(JSON.stringify(state));
}
