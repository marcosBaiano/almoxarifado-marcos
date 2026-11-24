        <section id="tab-engenharia" class="tab-content hidden flex flex-col gap-6">
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 shadow-lg flex flex-col gap-8">
                
                <div class="flex items-center gap-3 border-b border-slate-900 pb-4">
                    <div class="bg-indigo-600/10 p-2.5 rounded text-indigo-400 border border-indigo-500/20">
                        <i data-lucide="book-open" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-white">EspecificaÃ§Ã£o TÃ©cnica de Arquitetura & MER</h2>
                        <p class="text-xs text-slate-400">Modelagem do SIGA-MNT desenvolvida para escalabilidade horizontal do ERP.</p>
                    </div>
                </div>

                <!-- ARQUITETURA DE MICROSERVIÃ‡OS / EXPANSÃƒO -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-slate-900 p-5 rounded-lg border border-slate-850 flex flex-col gap-2">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-indigo-400">1. Requisitos do Sistema</h4>
                        <p class="text-[11px] text-slate-400 leading-relaxed">
                            <strong>Funcionais:</strong> SessÃµes de staging para bipagem consecutiva, pipeline de busca de fornecedores em multi-nÃ­vel, requisiÃ§Ã£o de entrega com baixa atÃ´mica pÃ³s-separaÃ§Ã£o e bloqueio de saldo negativo.<br>
                            <strong>NÃ£o Funcionais:</strong> LatÃªncia de bipe &lt; 50ms (In-Memory Staging), seguranÃ§a contra injeÃ§Ã£o SQL via Prepared Statements nativos (PDO) e integridade referencial estrita contra deleÃ§Ãµes acidentais (Cascade restrito).
                        </p>
                    </div>
                    <div class="bg-slate-900 p-5 rounded-lg border border-slate-850 flex flex-col gap-2">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-indigo-400">2. Mapa de ExpansÃ£o de MÃ³dulos</h4>
                        <p class="text-[11px] text-slate-400 leading-relaxed">
                            <strong>MÃ³dulo Compras:</strong> Acoplado ao gatilho de saldo abaixo do mÃ­nimo do almoxarifado via fila de compras automÃ¡tica.<br>
                            <strong>MÃ³dulo PatrimÃ´nio & Ferramentas:</strong> Estende a tabela de produtos unificada, tipando materiais de consumo rÃ¡pido vs. ativos de controle de calibraÃ§Ã£o periÃ³dica (rastreÃ¡veis).
                        </p>
                    </div>
                    <div class="bg-slate-900 p-5 rounded-lg border border-slate-850 flex flex-col gap-2">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-indigo-400">3. EstratÃ©gia de IdentificaÃ§Ã£o</h4>
                        <p class="text-[11px] text-slate-400 leading-relaxed">
                            <strong>ProdutoLookupProvider:</strong> Mecanismo de resoluÃ§Ã£o estruturado em fila de provedores de API (Google Merchant $\rightarrow$ BrasilAPI $\rightarrow$ Cadastro Manual), isolado do domÃ­nio das regras de negÃ³cio.
                        </p>
                    </div>
                </div>

                <!-- SCRIPT SQL DE ENGENHARIA -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Modelo Entidade-Relacionamento e Script DDL MySQL (Preparado para ExpansÃ£o)
                    </h4>
                    <pre class="bg-slate-900 p-4 rounded-lg border border-slate-850 text-slate-300 text-[10.5px] code-font overflow-x-auto select-all max-h-80">
CREATE DATABASE IF NOT EXISTS erp_almoxarifado CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE erp_almoxarifado;

-- 1. TABELA DE PERFIS DE PERMISSÃƒO
CREATE TABLE permissoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_perfil VARCHAR(50) NOT NULL UNIQUE,
    pode_ajustar TINYINT(1) NOT NULL DEFAULT 0,
    pode_cadastrar TINYINT(1) NOT NULL DEFAULT 1,
    pode_retirar TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- 2. TABELA DE USUÃRIOS DO ERP
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    permissao_id INT NOT NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (permissao_id) REFERENCES permissoes(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 3. TABELA DE CATEGORIAS (Mapeamento das Classes da Planilha de ReferÃªncia)
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    codigo_classe VARCHAR(10) NULL
) ENGINE=InnoDB;

-- 4. TABELA DE SETORES E CENTROS DE CUSTO
CREATE TABLE setores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    codigo VARCHAR(20) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- 5. TABELA DE PRODUTOS (ESTOQUE CENTRAL)
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_interno VARCHAR(50) NOT NULL UNIQUE,
    codigo_barras VARCHAR(100) NOT NULL UNIQUE,
    nome VARCHAR(255) NOT NULL,
    texto_breve VARCHAR(255) NULL,
    marca VARCHAR(100) NOT NULL,
    modelo VARCHAR(100) NULL,
    part_number VARCHAR(100) NULL,
    categoria_id INT NOT NULL,
    unidade VARCHAR(10) NOT NULL DEFAULT 'UN',
    localizacao VARCHAR(50) NULL,
    estoque_atual DECIMAL(12,4) NOT NULL DEFAULT 0.0000,
    estoque_minimo DECIMAL(12,4) NOT NULL DEFAULT 0.0000,
    estoque_maximo DECIMAL(12,4) NOT NULL DEFAULT 100.0000,
    valor_unitario DECIMAL(14,4) NOT NULL DEFAULT 0.0000,
    valor_total DECIMAL(14,4) GENERATED ALWAYS AS (estoque_atual * valor_unitario) STORED,
    solicitacao_reposicao VARCHAR(50) NULL,
    em_aberto DECIMAL(12,4) NOT NULL DEFAULT 0.0000,
    observacao TEXT NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_produtos_codbar (codigo_barras),
    INDEX idx_produtos_busca (nome, marca, part_number),
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 6. TABELA DE CODIGOS DE BARRAS POR PRODUTO
CREATE TABLE produto_codigos_barras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    codigo_barras VARCHAR(100) NOT NULL UNIQUE,
    principal TINYINT(1) NOT NULL DEFAULT 0,
    origem ENUM('CADASTRO', 'ASSOCIACAO_RECEBIMENTO', 'IMPORTACAO', 'MIGRACAO') NOT NULL DEFAULT 'ASSOCIACAO_RECEBIMENTO',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE,
    INDEX idx_produto_codigos_produto (produto_id),
    INDEX idx_produto_codigos_barcode (codigo_barras)
) ENGINE=InnoDB;

-- 7. TABELA DE SOLICITAÃ‡Ã•ES DE MATERIAIS (Mesa de Atendimento)
CREATE TABLE solicitacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_solicitacao VARCHAR(20) NOT NULL UNIQUE,
    solicitante VARCHAR(100) NOT NULL,
    setor_id INT NOT NULL,
    equipamento VARCHAR(150) NULL,
    despachante_usuario_id INT NULL,
    prioridade ENUM('ALTA', 'MEDIA', 'BAIXA') NOT NULL DEFAULT 'MEDIA',
    status ENUM('PENDENTE', 'SEPARADO', 'ENTREGUE', 'CANCELADO') NOT NULL DEFAULT 'PENDENTE',
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (setor_id) REFERENCES setores(id) ON DELETE RESTRICT,
    FOREIGN KEY (despachante_usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 8. TABELA DE ITENS DA SOLICITAÃ‡ÃƒO
CREATE TABLE solicitacao_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    solicitacao_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade_solicitada DECIMAL(12,4) NOT NULL,
    quantidade_atendida DECIMAL(12,4) NOT NULL DEFAULT 0.0000,
    FOREIGN KEY (solicitacao_id) REFERENCES solicitacoes(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 9. TABELA ÃšNICA DE MOVIMENTAÃ‡Ã•ES DE ESTOQUE
CREATE TABLE movimentacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    tipo_movimentacao ENUM('ENTRADA', 'SAIDA', 'AJUSTE', 'DEVOLUCAO', 'TRANSFERENCIA', 'INVENTARIO') NOT NULL,
    quantidade DECIMAL(12,4) NOT NULL,
    unidade VARCHAR(10) NOT NULL DEFAULT 'UN',
    saldo_anterior DECIMAL(12,4) NOT NULL,
    saldo_posterior DECIMAL(12,4) NOT NULL,
    usuario_id INT NOT NULL,
    solicitante VARCHAR(100) NULL,
    setor_id INT NULL,
    equipamento VARCHAR(150) NULL,
    despachante_usuario_id INT NULL,
    sessao_recebimento VARCHAR(50) NULL,
    solicitacao_id INT NULL,
    origem ENUM('SCANNER', 'DIGITACAO', 'API') NOT NULL DEFAULT 'DIGITACAO',
    observacao TEXT NULL,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE RESTRICT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE RESTRICT,
    FOREIGN KEY (setor_id) REFERENCES setores(id) ON DELETE SET NULL,
    FOREIGN KEY (despachante_usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    FOREIGN KEY (solicitacao_id) REFERENCES solicitacoes(id) ON DELETE SET NULL,
    INDEX idx_mov_produto (produto_id)
) ENGINE=InnoDB;

-- 10. TABELA DE SOLICITAÃ‡Ã•ES DE COMPRAS
CREATE TABLE solicitacoes_compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_solicitacao DATE NOT NULL,
    produto_id INT NOT NULL,
    texto_breve_material VARCHAR(255) NOT NULL,
    quantidade DECIMAL(12,4) NOT NULL,
    unidade VARCHAR(10) NOT NULL DEFAULT 'UN',
    data_chegada DATE NULL,
    fornecedor VARCHAR(150) NULL,
    nota_fiscal VARCHAR(50) NULL,
    observacao TEXT NULL,
    status ENUM('ABERTA', 'EM_COTACAO', 'PEDIDO_EMITIDO', 'RECEBIDA', 'CANCELADA') NOT NULL DEFAULT 'ABERTA',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE RESTRICT,
    INDEX idx_compra_produto (produto_id),
    INDEX idx_compra_status (status)
) ENGINE=InnoDB;

-- 11. TABELA DE LOCALIZAÃ‡Ã•ES FÃSICAS DO ALMOXARIFADO
CREATE TABLE localizacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    descricao VARCHAR(150) NULL,
    coluna1 VARCHAR(100) NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- 12. TABELA DE SALDO POR LOCALIZAÃ‡ÃƒO E AJUSTES
CREATE TABLE localizacao_saldos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    localizacao_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade DECIMAL(12,4) NOT NULL DEFAULT 0.0000,
    ajuste DECIMAL(12,4) NOT NULL DEFAULT 0.0000,
    observacao TEXT NULL,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uk_local_produto (localizacao_id, produto_id),
    FOREIGN KEY (localizacao_id) REFERENCES localizacoes(id) ON DELETE RESTRICT,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 13. TABELA DE AUDITORIA DE SISTEMA (InalterÃ¡vel)
CREATE TABLE auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    computador_nome VARCHAR(100) NOT NULL,
    tela VARCHAR(50) NOT NULL,
    operacao VARCHAR(100) NOT NULL,
    valor_anterior TEXT NULL,
    valor_novo TEXT NULL,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE RESTRICT
) ENGINE=InnoDB;</pre>
                </div>

                <!-- ESTRUTURA DE DIRETÃ“RIOS PHP PSR-4 -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                        3. Ãrvore de DiretÃ³rios do Projeto em ProduÃ§Ã£o (PadrÃ£o MVC + PSR-4)
                    </h4>
                    <pre class="bg-slate-900 p-4 rounded-lg border border-slate-850 text-slate-300 text-[10.5px] code-font overflow-x-auto">
siga-mnt-erp/
â”œâ”€â”€ config/
â”‚   â”œâ”€â”€ database.php             # Gerenciamento de conexÃµes PDO e Pooling
â”‚   â””â”€â”€ app.php                  # ConfiguraÃ§Ãµes de chaves e variÃ¡veis globais
â”œâ”€â”€ core/
â”‚   â”œâ”€â”€ Controller.php           # AbstraÃ§Ã£o de controle e injeÃ§Ã£o de dependÃªncias
â”‚   â”œâ”€â”€ DatabaseConnection.php   # Wrapper do PDO para Prepared Statements e Transactions
â”‚   â””â”€â”€ DatabaseLookupProvider.php # Interface para lookup externo
â”œâ”€â”€ src/
â”‚   â”œâ”€â”€ Models/
â”‚   â”‚   â”œâ”€â”€ Product.php          # Estrutura atÃ´mica do Produto
â”‚   â”‚   â”œâ”€â”€ Request.php          # Estrutura de SolicitaÃ§Ã£o de PeÃ§a
â”‚   â”‚   â””â”€â”€ Audit.php            # Modelo de Auditoria
â”‚   â”œâ”€â”€ Repositories/
â”‚   â”‚   â”œâ”€â”€ ProductRepository.php  # OperaÃ§Ãµes e filtros SQL de produtos
â”‚   â”‚   â”œâ”€â”€ RequestRepository.php  # PersistÃªncia e controle de fluxo de solicitaÃ§Ãµes
â”‚   â”‚   â””â”€â”€ AuditRepository.php    # InjeÃ§Ã£o passiva de auditoria
â”‚   â”œâ”€â”€ Services/
â”‚   â”‚   â”œâ”€â”€ ReceivingStagingService.php # Gerencia sessÃµes de recebimento pendente (Staging)
â”‚   â”‚   â”œâ”€â”€ StockMovementService.php    # REGRA DE NEGÃ“CIO: LanÃ§amentos atÃ´micos de movimentaÃ§Ãµes
â”‚   â”‚   â””â”€â”€ SheetImporterService.php    # ServiÃ§o de parsing e validaÃ§Ã£o de planilhas de terceiros
â”‚   â””â”€â”€ Providers/
â”‚       â”œâ”€â”€ GoogleMerchantProvider.php  # Provedor externo (Google)
â”‚       â””â”€â”€ BrasilApiProvider.php       # Provedor nacional de APIs
â”œâ”€â”€ views/
â”‚   â”œâ”€â”€ dashboard.php            # View com dados tratados via Controller
â”‚   â”œâ”€â”€ recebimento.php          # Painel de staging
â”‚   â”œâ”€â”€ entrega.php              # Painel de separaÃ§Ã£o e entrega
â”‚   â””â”€â”€ estoque.php              # Painel de consultas de inventÃ¡rio
â””â”€â”€ public/
    â”œâ”€â”€ index.php                # Front Controller (Entrada Ãºnica)
    â””â”€â”€ assets/
        â”œâ”€â”€ css/                 # CSS utilitÃ¡rio compilado
        â””â”€â”€ js/                  # MÃ³dulos JS ES6 (Fetch API)</pre>
                </div>
            </div>
        </section>

