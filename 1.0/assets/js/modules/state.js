export const state = {
    produtos: [
        {
            id: 1,
            codigo_interno: 'PRD1001',
            part_number: 'PN-6204-C3',
            descricao: 'Rolamento Rigido de Esferas de Alta Precisao',
            descricao_resumida: 'Rolamento 6204-C3',
            categoria: 'Mecânica',
            marca: 'SKF',
            fabricante: 'SKF do Brasil S.A.',
            estoque_minimo: 10,
            estoque_maximo: 50,
            ponto_reposicao: 15,
            preco_custo_medio: 45.50,
            lote_control: 'LOT-2026/A',
            validade_control: '2030-12-31',
            localizacao: 'LOC-A1-E3',
            estoque_atual: 8
        },
        {
            id: 2,
            codigo_interno: 'PRD1002',
            part_number: 'PN-CON-90',
            descricao: 'Contator Trifasico de Potencia 24VCC 9A',
            descricao_resumida: 'Contator Trifasico 9A',
            categoria: 'Elétrica',
            marca: 'WEG',
            fabricante: 'WEG Equipamentos S.A.',
            estoque_minimo: 5,
            estoque_maximo: 20,
            ponto_reposicao: 8,
            preco_custo_medio: 120.00,
            lote_control: 'N/A',
            validade_control: 'N/A',
            localizacao: 'LOC-E3-P2',
            estoque_atual: 14
        },
        {
            id: 3,
            codigo_interno: 'PRD1003',
            part_number: 'PN-VLV-12',
            descricao: 'Eletrovalvula de Controle Direcional 5/2 vias G1/4',
            descricao_resumida: 'Eletrovalvula 5/2 vias',
            categoria: 'Pneumática',
            marca: 'Festo',
            fabricante: 'Festo Portugal Lda.',
            estoque_minimo: 4,
            estoque_maximo: 15,
            ponto_reposicao: 6,
            preco_custo_medio: 280.00,
            lote_control: 'N/A',
            validade_control: 'N/A',
            localizacao: 'LOC-P1-R4',
            estoque_atual: 3
        },
        {
            id: 4,
            codigo_interno: 'PRD1004',
            part_number: 'PN-ORING-K3',
            descricao: 'Kit de Juntas O-Ring Nitrilica NBR 70 Shore',
            descricao_resumida: 'Kit O-Ring Nitrilica',
            categoria: 'Hidráulica',
            marca: 'Parker',
            fabricante: 'Parker Hannifin Corp.',
            estoque_minimo: 2,
            estoque_maximo: 10,
            ponto_reposicao: 4,
            preco_custo_medio: 85.00,
            lote_control: 'LOT-PRK-12',
            validade_control: '2028-06-30',
            localizacao: 'LOC-H2-N1',
            estoque_atual: 7
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
        },
        {
            id: 2,
            produto_id: 2,
            timestamp: '2026-07-14 10:15:22',
            tipo: 'ENTRADA',
            quantidade: 5,
            saldo_anterior: 9,
            saldo_posterior: 14,
            documento_ref: 'NF-9900232',
            operador: 'Manuel Silva',
            destino: 'LOC-E3-P2'
        },
        {
            id: 3,
            produto_id: 3,
            timestamp: '2026-07-14 11:00:00',
            tipo: 'SAIDA',
            quantidade: 1,
            saldo_anterior: 4,
            saldo_posterior: 3,
            documento_ref: 'OS-2026-0044',
            operador: 'Manuel Silva',
            destino: 'Fresagem CNC e Ferramentaria'
        }
    ],
    auditoria: [
        {
            id: 1,
            timestamp: '2026-07-14 08:00:00',
            usuario: 'Manuel Silva',
            evento: 'LOGIN_SISTEMA',
            dados_anteriores: '-',
            dados_novos: 'Sessao iniciada via IP 192.168.10.45',
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
        },
        {
            id: 2,
            os: 'OS-2026-0051',
            tecnico: 'Ana Rodrigues',
            setor: 'Fresagem CNC e Ferramentaria',
            equipamento: 'Centro CNC Haas VF-2',
            produto_id: 3,
            quantidade: 1,
            status: 'Pendente'
        }
    ]
};
