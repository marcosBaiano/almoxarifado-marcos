<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAMA - Sistema de Almoxarifado de Manutenção Avançado</title>
    <!-- Tailwind CSS para estilização moderna e responsiva -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons para interface profissional -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col overflow-x-hidden">

    <!-- Topbar Corporativo -->
    <header class="bg-slate-950 border-b border-slate-800 px-6 py-3 flex items-center justify-between sticky top-0 z-50">
        <div class="flex items-center space-x-3">
            <div class="bg-blue-600 text-white p-2 rounded-lg flex items-center justify-center">
                <i data-lucide="package-2" class="w-6 h-6"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold tracking-wider text-white">SAMA ERP</h1>
                <p class="text-xs text-slate-400">Almoxarifado de Manutenção Industrial v3.2</p>
            </div>
        </div>

        <!-- Indicador de Status do Scanner -->
        <div class="hidden md:flex items-center space-x-3 bg-slate-900 px-3 py-1.5 rounded-full border border-slate-800">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="text-xs font-semibold text-emerald-400 code-font">SCANNER ATIVO (Leitor USB/Coletor)</span>
        </div>

        <div class="flex items-center space-x-4">
            <div class="text-right">
                <span class="text-sm font-medium block text-slate-200">Eng. Manuel Silva</span>
                <span class="text-xs text-blue-400 bg-blue-950/40 px-2 py-0.5 rounded border border-blue-900/50">Supervisor de Manutenção</span>
            </div>
            <div class="w-10 h-10 rounded-full bg-slate-700 border-2 border-blue-500 flex items-center justify-center text-white font-bold">
                MS
            </div>
        </div>
    </header>

    <div class="flex flex-1 flex-col lg:flex-row">
        <!-- Sidebar de Navegação -->
        <aside class="w-full lg:w-64 bg-slate-950 border-r border-slate-800 p-4 flex flex-col justify-between">
            <div class="space-y-6">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3 block mb-2">Visão Geral</span>
                    <nav class="space-y-1">
                        <button onclick="switchTab('dashboard')" class="tab-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150 bg-blue-600 text-white font-medium" id="btn-dashboard">
                            <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                            <span>Painel de Controlo</span>
                        </button>
                        <button onclick="switchTab('produtos')" class="tab-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-slate-200 hover:bg-slate-900 transition-all duration-150" id="btn-produtos">
                            <i data-lucide="boxes" class="w-4 h-4"></i>
                            <span>Catálogo de Artigos</span>
                        </button>
                        <button onclick="switchTab('scanner')" class="tab-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-slate-200 hover:bg-slate-900 transition-all duration-150" id="btn-scanner">
                            <i data-lucide="scan-barcode" class="w-4 h-4"></i>
                            <span>Leitor de Código</span>
                        </button>
                    </nav>
                </div>

                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3 block mb-2">Movimentos</span>
                    <nav class="space-y-1">
                        <button onclick="switchTab('recebimento')" class="tab-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-slate-200 hover:bg-slate-900 transition-all duration-150" id="btn-recebimento">
                            <i data-lucide="log-in" class="w-4 h-4"></i>
                            <span>Entrada de Stock</span>
                        </button>
                        <button onclick="switchTab('saida')" class="tab-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-slate-200 hover:bg-slate-900 transition-all duration-150" id="btn-saida">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            <span>Saída por O.S.</span>
                        </button>
                        <button onclick="switchTab('solicitacoes')" class="tab-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-slate-200 hover:bg-slate-900 transition-all duration-150" id="btn-solicitacoes">
                            <i data-lucide="file-check" class="w-4 h-4"></i>
                            <span>Requisições</span>
                        </button>
                    </nav>
                </div>

                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3 block mb-2">Auditoria e Controlo</span>
                    <nav class="space-y-1">
                        <button onclick="switchTab('inventario')" class="tab-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-slate-200 hover:bg-slate-900 transition-all duration-150" id="btn-inventario">
                            <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                            <span>Inventário Rotativo</span>
                        </button>
                        <button onclick="switchTab('auditoria')" class="tab-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-slate-200 hover:bg-slate-900 transition-all duration-150" id="btn-auditoria">
                            <i data-lucide="shield-alert" class="w-4 h-4"></i>
                            <span>Rastreamento & Logs</span>
                        </button>
                        <button onclick="switchTab('database')" class="tab-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-slate-200 hover:bg-slate-900 transition-all duration-150" id="btn-database">
                            <i data-lucide="database" class="w-4 h-4"></i>
                            <span>Modelo de Dados (DDL)</span>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Rodapé da Sidebar - Integração API e Versão -->
            <div class="border-t border-slate-800 pt-4 mt-6">
                <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="text-slate-400">Endpoint API</span>
                        <span class="text-emerald-400 font-semibold">Online</span>
                    </div>
                    <code class="text-[10px] text-blue-400 block break-all code-font">/api/v1/produtos</code>
                </div>
                <div class="text-[10px] text-slate-500 text-center mt-3">
                    SAMA ERP — Licenciado para Indústria de Moldes S.A.
                </div>
            </div>
        </aside>

        <!-- Área Principal de Conteúdo -->
        <main class="flex-1 p-6 overflow-y-auto space-y-6">

            <!-- TAB 1: PAINEL DE CONTROLO (DASHBOARD) -->
            <section id="tab-dashboard" class="tab-content space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Painel de Controlo Operacional</h2>
                        <p class="text-slate-400">Dados consolidados do almoxarifado de manutenção industrial em tempo real.</p>
                    </div>
                    <div class="bg-slate-800/80 px-4 py-2 rounded-lg border border-slate-700 flex items-center space-x-2">
                        <i data-lucide="refresh-cw" class="w-4 h-4 text-blue-400 animate-spin"></i>
                        <span class="text-xs font-semibold text-slate-300">Atualização automática: Ativa</span>
                    </div>
                </div>

                <!-- Cards de Indicadores Principais (KPIs) -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                    <div class="bg-slate-950 border border-slate-800 p-4 rounded-xl flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-500 font-semibold uppercase">Total de Artigos</span>
                            <h3 class="text-2xl font-bold mt-1 text-white" id="kpi-total-produtos">156</h3>
                            <span class="text-[10px] text-slate-400 block mt-1">Produtos registados</span>
                        </div>
                        <div class="p-3 bg-blue-950/40 border border-blue-900 rounded-lg text-blue-400">
                            <i data-lucide="boxes" class="w-6 h-6"></i>
                        </div>
                    </div>

                    <div class="bg-slate-950 border border-slate-800 p-4 rounded-xl flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-500 font-semibold uppercase">Estoque Crítico</span>
                            <h3 class="text-2xl font-bold mt-1 text-rose-500" id="kpi-estoque-critico">4</h3>
                            <span class="text-[10px] text-rose-400/80 block mt-1">Abaixo do ponto de reposição</span>
                        </div>
                        <div class="p-3 bg-rose-950/40 border border-rose-900 rounded-lg text-rose-500 animate-pulse">
                            <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                        </div>
                    </div>

                    <div class="bg-slate-950 border border-slate-800 p-4 rounded-xl flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-500 font-semibold uppercase">Requisições Pendentes</span>
                            <h3 class="text-2xl font-bold mt-1 text-amber-500" id="kpi-req-pendentes">3</h3>
                            <span class="text-[10px] text-amber-400/80 block mt-1">Aguardando separação/entrega</span>
                        </div>
                        <div class="p-3 bg-amber-950/40 border border-amber-900 rounded-lg text-amber-500">
                            <i data-lucide="hourglass" class="w-6 h-6"></i>
                        </div>
                    </div>

                    <div class="bg-slate-950 border border-slate-800 p-4 rounded-xl flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-500 font-semibold uppercase">Valor Total do Stock</span>
                            <h3 class="text-2xl font-bold mt-1 text-emerald-400 code-font" id="kpi-valor-estoque">€ 42.150,00</h3>
                            <span class="text-[10px] text-emerald-400 block mt-1">Custo médio ponderado</span>
                        </div>
                        <div class="p-3 bg-emerald-950/40 border border-emerald-900 rounded-lg text-emerald-400">
                            <i data-lucide="euro" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                <!-- Gráficos e Alertas Críticos -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Esquerda: Alertas Críticos do Almoxarifado -->
                    <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 lg:col-span-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-4 flex items-center">
                                <i data-lucide="alert-circle" class="w-4 h-4 text-rose-500 mr-2"></i>
                                Alertas Críticos de Stock
                            </h3>
                            <div class="space-y-3" id="alertas-criticos-container">
                                <!-- Preenchido dinamicamente -->
                            </div>
                        </div>
                        <button onclick="switchTab('produtos')" class="mt-4 w-full bg-slate-900 hover:bg-slate-850 text-slate-300 border border-slate-800 rounded-lg py-2 text-xs font-semibold transition-all">
                            Ver catálogo completo
                        </button>
                    </div>

                    <!-- Centro: Curva ABC e Distribuição por Setor -->
                    <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 lg:col-span-2">
                        <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-4 flex items-center">
                            <i data-lucide="trending-up" class="w-4 h-4 text-blue-400 mr-2"></i>
                            Consumo de Peças por Setor e Curva ABC de criticidade
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Gráfico de Setores (CSS Progress Bars) -->
                            <div class="space-y-4">
                                <span class="text-xs text-slate-400 block font-medium">Consumo Mensal por Setor</span>
                                <div class="space-y-3">
                                    <div>
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-slate-300">Linha de Injeção Plástica</span>
                                            <span class="text-slate-400 font-semibold">45% (€ 8.420)</span>
                                        </div>
                                        <div class="w-full bg-slate-900 h-2 rounded-full overflow-hidden">
                                            <div class="bg-blue-500 h-full rounded-full" style="width: 45%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-slate-300">Fresagem CNC e Ferramentaria</span>
                                            <span class="text-slate-400 font-semibold">30% (€ 5.610)</span>
                                        </div>
                                        <div class="w-full bg-slate-900 h-2 rounded-full overflow-hidden">
                                            <div class="bg-purple-500 h-full rounded-full" style="width: 30%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-slate-300">Utilidades & Infraestrutura</span>
                                            <span class="text-slate-400 font-semibold">15% (€ 2.805)</span>
                                        </div>
                                        <div class="w-full bg-slate-900 h-2 rounded-full overflow-hidden">
                                            <div class="bg-amber-500 h-full rounded-full" style="width: 15%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-slate-300">Pintura e Tratamento Térmico</span>
                                            <span class="text-slate-400 font-semibold">10% (€ 1.870)</span>
                                        </div>
                                        <div class="w-full bg-slate-900 h-2 rounded-full overflow-hidden">
                                            <div class="bg-slate-600 h-full rounded-full" style="width: 10%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Distribuição da Curva ABC -->
                            <div class="bg-slate-900/60 border border-slate-800 p-4 rounded-lg flex flex-col justify-between">
                                <div>
                                    <span class="text-xs text-slate-400 block font-medium mb-3">Distribuição Curva ABC</span>
                                    <div class="grid grid-cols-3 gap-2 text-center">
                                        <div class="bg-emerald-950/50 border border-emerald-900 p-2 rounded">
                                            <span class="text-xs font-bold text-emerald-400 block">Classe A</span>
                                            <span class="text-lg font-bold text-white block mt-1">20%</span>
                                            <span class="text-[8px] text-slate-400 uppercase">Artigos (80% Valor)</span>
                                        </div>
                                        <div class="bg-blue-950/50 border border-blue-900 p-2 rounded">
                                            <span class="text-xs font-bold text-blue-400 block">Classe B</span>
                                            <span class="text-lg font-bold text-white block mt-1">30%</span>
                                            <span class="text-[8px] text-slate-400 uppercase">Artigos (15% Valor)</span>
                                        </div>
                                        <div class="bg-slate-850 border border-slate-700 p-2 rounded">
                                            <span class="text-xs font-bold text-slate-400 block">Classe C</span>
                                            <span class="text-lg font-bold text-white block mt-1">50%</span>
                                            <span class="text-[8px] text-slate-400 uppercase">Artigos (5% Valor)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-[11px] text-slate-400 italic mt-3">
                                    *A Classificação ABC é calculada dinamicamente com base nas requisições de manutenção preventiva e corretiva nos últimos 90 dias.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Atividades Recentes do Armazém -->
                <div class="bg-slate-950 border border-slate-800 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider flex items-center">
                            <i data-lucide="history" class="w-4 h-4 text-blue-400 mr-2"></i>
                            Últimas Movimentações Registadas (Rastreabilidade)
                        </h3>
                        <span class="text-xs text-slate-500">Filtrando por data decrescente</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-800 text-slate-400 text-xs uppercase tracking-wider">
                                    <th class="py-3 px-4">Timestamp</th>
                                    <th class="py-3 px-4">Artigo</th>
                                    <th class="py-3 px-4">Tipo</th>
                                    <th class="py-3 px-4">Quantidade</th>
                                    <th class="py-3 px-4">Origem / Destino</th>
                                    <th class="py-3 px-4">Documento / O.S.</th>
                                    <th class="py-3 px-4">Operador</th>
                                </tr>
                            </thead>
                            <tbody id="dashboard-movimentacoes-table" class="text-sm divide-y divide-slate-900">
                                <!-- Conteúdo preenchido dinamicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- TAB 2: CATÁLOGO DE ARTIGOS -->
            <section id="tab-produtos" class="tab-content hidden space-y-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Catálogo de Artigos & Peças</h2>
                        <p class="text-slate-400">Registo de materiais e componentes de manutenção industrial.</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button onclick="openModal('modal-novo-produto')" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold text-sm px-4 py-2.5 rounded-lg flex items-center space-x-2 transition-all">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            <span>Novo Artigo</span>
                        </button>
                    </div>
                </div>

                <!-- Filtros Avançados -->
                <div class="bg-slate-950 border border-slate-800 p-4 rounded-xl grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="col-span-1 md:col-span-2">
                        <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Pesquisar por Código, Nome ou Part Number</label>
                        <div class="relative">
                            <i data-lucide="search" class="w-4 h-4 text-slate-500 absolute left-3 top-3.5"></i>
                            <input type="text" id="filter-search" oninput="applyFilters()" placeholder="Pesquise por: COD001, Rolamento, PN9900..." class="w-full bg-slate-900 border border-slate-800 rounded-lg pl-9 pr-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Categoria</label>
                        <select id="filter-categoria" onchange="applyFilters()" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500">
                            <option value="todos">Todas as categorias</option>
                            <option value="Mecânica">Mecânica</option>
                            <option value="Elétrica">Elétrica</option>
                            <option value="Hidráulica">Hidráulica</option>
                            <option value="Pneumática">Pneumática</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Status de Stock</label>
                        <select id="filter-estoque" onchange="applyFilters()" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500">
                            <option value="todos">Todos</option>
                            <option value="critico">Abaixo do Mínimo</option>
                            <option value="seguro">Stock Seguro</option>
                        </select>
                    </div>
                </div>

                <!-- Tabela de Produtos -->
                <div class="bg-slate-950 border border-slate-800 rounded-xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-900 border-b border-slate-800 text-slate-400 text-xs uppercase tracking-wider">
                                    <th class="py-3 px-4">Código / Part Number</th>
                                    <th class="py-3 px-4">Descrição do Artigo</th>
                                    <th class="py-3 px-4">Categoria</th>
                                    <th class="py-3 px-4 text-center">Localização</th>
                                    <th class="py-3 px-4 text-center">Mín. / Máx.</th>
                                    <th class="py-3 px-4 text-right">Preço Unitário</th>
                                    <th class="py-3 px-4 text-center">Stock Atual</th>
                                    <th class="py-3 px-4 text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="produtos-table-body" class="text-sm divide-y divide-slate-900">
                                <!-- Conteúdo inserido dinamicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- TAB 3: SIMULADOR DE SCANNER -->
            <section id="tab-scanner" class="tab-content hidden space-y-6">
                <div class="max-w-3xl mx-auto space-y-6">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Leitor de Código de Barras / Coletor de Dados</h2>
                        <p class="text-slate-400">Simulador de dispositivo de scanner para fluxos automáticos rápidos de estoque (Zero Cliques de Mouse).</p>
                    </div>

                    <!-- Interface Física de Leitura do Scanner -->
                    <div class="bg-slate-950 border-2 border-dashed border-slate-800 rounded-xl p-8 flex flex-col items-center justify-center text-center space-y-4 relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 text-slate-900 text-9xl font-black pointer-events-none select-none">SCAN</div>
                        
                        <div class="w-16 h-16 rounded-full bg-blue-950/50 border border-blue-900 flex items-center justify-center text-blue-400 mb-2">
                            <i data-lucide="scan" class="w-8 h-8 animate-pulse"></i>
                        </div>

                        <div class="w-full max-w-md space-y-2">
                            <label class="text-xs text-slate-400 font-semibold uppercase block">Simular Entrada Física do Leitor (Bipar com ENTER no final)</label>
                            <input type="text" id="scanner-input" placeholder="Bipar código de barras (Ex: PRD1001, PRD1002, LOC-A1-E3)..." class="w-full bg-slate-900 border-2 border-blue-500 rounded-lg px-4 py-3 text-lg text-slate-200 focus:outline-none focus:ring-4 focus:ring-blue-900/40 text-center code-font">
                            <p class="text-[11px] text-slate-500">
                                Para testar no computador, digite <code class="bg-slate-900 px-1 py-0.5 rounded text-blue-400 font-bold">PRD1001</code> ou <code class="bg-slate-900 px-1 py-0.5 rounded text-blue-400 font-bold">PRD1004</code> e prima <kbd class="bg-slate-800 px-1 py-0.5 rounded border border-slate-700 text-slate-300">ENTER</kbd>.
                            </p>
                        </div>
                    </div>

                    <!-- Output de Resultados do Scanner -->
                    <div id="scanner-result-card" class="bg-slate-950 border border-slate-800 rounded-xl p-6 hidden">
                        <!-- Preenchido dinamicamente ao bipar código -->
                    </div>
                </div>
            </section>

            <!-- TAB 4: ENTRADA DE STOCK (RECEBIMENTO) -->
            <section id="tab-recebimento" class="tab-content hidden space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-white">Recebimento de Materiais (Entrada de Stock)</h2>
                    <p class="text-slate-400">Registo de notas fiscais, doações, devoluções e lançamentos de novos lotes.</p>
                </div>

                <div class="bg-slate-950 border border-slate-800 rounded-xl p-6">
                    <form id="form-recebimento" onsubmit="processarRecebimento(event)" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Tipo de Entrada</label>
                                <select id="rec-tipo" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                                    <option value="Compra">Compra (Ordem de Compra)</option>
                                    <option value="Devolução">Devolução do Campo</option>
                                    <option value="Transferência">Transferência entre Unidades</option>
                                    <option value="Ajuste">Ajuste de Inventário</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Número do Documento / Nota Fiscal</label>
                                <input type="text" id="rec-documento" placeholder="Ex: NF-100234/2026" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Fornecedor</label>
                                <select id="rec-fornecedor" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500">
                                    <option value="Indústria de Rolamentos Alfa S.A.">Indústria de Rolamentos Alfa S.A.</option>
                                    <option value="EletroPeças Distribuidores Lda.">EletroPeças Distribuidores Lda.</option>
                                    <option value="Seringas & Hidráulicos do Norte">Seringas & Hidráulicos do Norte</option>
                                    <option value="Metalurgia do Centro S.A.">Metalurgia do Centro S.A.</option>
                                </select>
                            </div>
                        </div>

                        <div class="border-t border-slate-800 pt-6">
                            <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-4">Leitura por Codigo de Barras (Entrada)</h3>
                            <div class="bg-slate-900/40 border border-dashed border-slate-700 rounded-lg p-4 mb-6">
                                <label class="text-xs text-slate-500 font-semibold uppercase block mb-2">Bipar Codigo do Artigo para Selecao Automatica</label>
                                <input type="text" id="rec-scanner-input" placeholder="Bipar: PRD1001, PRD1002 ou PN-6204-C3 e premir ENTER" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 code-font">
                                <p id="rec-scanner-status" class="text-[11px] text-slate-500 mt-2">Aguardando leitura do scanner para preparar a entrada de stock.</p>
                            </div>

                            <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-4">Itens do Lançamento</h3>
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                                <div class="md:col-span-2">
                                    <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Artigo</label>
                                    <select id="rec-item-produto" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                                        <!-- Carregado via JS -->
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Qtd. Recebida</label>
                                    <input type="number" id="rec-item-qtd" min="1" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                                </div>
                                <div>
                                    <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Preço Unitário (€)</label>
                                    <input type="number" id="rec-item-preco" step="0.01" min="0.01" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                                </div>
                                <div>
                                    <button type="button" onclick="adicionarItemRecebimento()" class="w-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-sm py-2.5 rounded-lg border border-slate-700 flex items-center justify-center space-x-2 transition-all">
                                        <i data-lucide="plus" class="w-4 h-4 text-emerald-400"></i>
                                        <span>Adicionar</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Tabela de Itens Adicionados -->
                        <div class="bg-slate-900/40 border border-slate-800 rounded-lg overflow-hidden">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-900 text-slate-400 text-xs uppercase tracking-wider">
                                        <th class="py-2.5 px-4">Artigo</th>
                                        <th class="py-2.5 px-4 text-center">Lote / Validade</th>
                                        <th class="py-2.5 px-4 text-center">Localização</th>
                                        <th class="py-2.5 px-4 text-center">Qtd.</th>
                                        <th class="py-2.5 px-4 text-right">Preço Unitário</th>
                                        <th class="py-2.5 px-4 text-right">Subtotal</th>
                                        <th class="py-2.5 px-4 text-center">Ação</th>
                                    </tr>
                                </thead>
                                <tbody id="tabela-itens-recebimento" class="text-sm divide-y divide-slate-850">
                                    <tr>
                                        <td colspan="7" class="py-8 text-center text-slate-500 italic">Nenhum item adicionado ao lançamento.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-800">
                            <button type="button" onclick="limparFormRecebimento()" class="bg-slate-900 hover:bg-slate-850 text-slate-400 border border-slate-800 font-semibold text-sm px-5 py-2.5 rounded-lg transition-all">
                                Limpar Dados
                            </button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-sm px-6 py-2.5 rounded-lg flex items-center space-x-2 transition-all">
                                <i data-lucide="check-square" class="w-4 h-4"></i>
                                <span>Concluir e Lançar Entrada</span>
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- TAB 5: SAÍDA POR ORDEM DE SERVIÇO -->
            <section id="tab-saida" class="tab-content hidden space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-white">Saída de Peças por O.S. (Consumo / Baixa)</h2>
                    <p class="text-slate-400">Atendimento de requisições de técnicos no balcão e saídas por ordens de serviço preventivas/corretivas.</p>
                </div>

                <div class="bg-slate-950 border border-slate-800 rounded-xl p-6">
                    <form id="form-saida" onsubmit="processarSaida(event)" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Ordem de Serviço (O.S.)</label>
                                <input type="text" id="sai-os" placeholder="Ex: OS-2026-0043" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Técnico Solicitante</label>
                                <input type="text" id="sai-tecnico" placeholder="Nome do técnico" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Setor Destino</label>
                                <select id="sai-setor" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                                    <option value="Linha de Injeção Plástica">Linha de Injeção Plástica</option>
                                    <option value="Fresagem CNC e Ferramentaria">Fresagem CNC e Ferramentaria</option>
                                    <option value="Utilidades & Infraestrutura">Utilidades & Infraestrutura</option>
                                    <option value="Pintura e Tratamento Térmico">Pintura e Tratamento Térmico</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Equipamento (Tag)</label>
                                <input type="text" id="sai-equipamento" placeholder="Ex: CNC-04, INJ-12" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                            </div>
                        </div>

                        <div class="border-t border-slate-800 pt-6">
                            <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-4">Adicionar Peças à O.S.</h3>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                                <div class="md:col-span-2">
                                    <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Selecionar Artigo em Stock</label>
                                    <select id="sai-item-produto" onchange="atualizarEstoqueDisponivelSaida()" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                                        <!-- Carregado via JS -->
                                    </select>
                                    <span class="text-[10px] text-emerald-400 mt-1 block" id="sai-estoque-disponivel">Stock disponível: 0 un</span>
                                </div>
                                <div>
                                    <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Quantidade Requerida</label>
                                    <input type="number" id="sai-item-qtd" min="1" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                                </div>
                                <div>
                                    <button type="button" onclick="adicionarItemSaida()" class="w-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-sm py-2.5 rounded-lg border border-slate-700 flex items-center justify-center space-x-2 transition-all">
                                        <i data-lucide="plus" class="w-4 h-4 text-rose-400"></i>
                                        <span>Adicionar Peça</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Tabela de Saídas -->
                        <div class="bg-slate-900/40 border border-slate-800 rounded-lg overflow-hidden">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-900 text-slate-400 text-xs uppercase tracking-wider">
                                        <th class="py-2.5 px-4">Artigo</th>
                                        <th class="py-2.5 px-4 text-center">Localização de Recolha</th>
                                        <th class="py-2.5 px-4 text-center">Qtd. Baixada</th>
                                        <th class="py-2.5 px-4 text-center">Ação</th>
                                    </tr>
                                </thead>
                                <tbody id="tabela-itens-saida" class="text-sm divide-y divide-slate-850">
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-slate-500 italic">Nenhuma peça adicionada para saída.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-800">
                            <button type="button" onclick="limparFormSaida()" class="bg-slate-900 hover:bg-slate-850 text-slate-400 border border-slate-800 font-semibold text-sm px-5 py-2.5 rounded-lg transition-all">
                                Cancelar Lançamento
                            </button>
                            <button type="submit" class="bg-rose-600 hover:bg-rose-500 text-white font-semibold text-sm px-6 py-2.5 rounded-lg flex items-center space-x-2 transition-all">
                                <i data-lucide="check-square" class="w-4 h-4"></i>
                                <span>Efetuar Baixa no Stock</span>
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- TAB 6: REQUISIÇÕES DE MATERIAL -->
            <section id="tab-solicitacoes" class="tab-content hidden space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Requisições de Materiais para O.S.</h2>
                        <p class="text-slate-400">Gerir requisições de peças em aberto feitas pelos engenheiros e pessoal do planeamento.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4" id="requisicoes-container">
                    <!-- Preenchido via Javascript -->
                </div>
            </section>

            <!-- TAB 7: INVENTÁRIO ROTATIVO -->
            <section id="tab-inventario" class="tab-content hidden space-y-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Lançamento de Auditoria de Inventário Rotativo</h2>
                        <p class="text-slate-400">Garantir a fidedignidade física do almoxarifado vs sistema.</p>
                    </div>
                </div>

                <div class="bg-slate-950 border border-slate-800 rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-4 flex items-center">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400 mr-2"></i>
                        Ajustar Estoque por Produto (Controle de Auditoria)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div class="md:col-span-2">
                            <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Selecionar Artigo</label>
                            <select id="inv-produto" onchange="atualizarEstoqueAtualInventario()" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500">
                                <!-- Preenchido via JS -->
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Qtd. Sistema</label>
                            <input type="text" id="inv-qtd-sistema" class="w-full bg-slate-900/60 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-400 code-font" readonly>
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Qtd. Física Contada</label>
                            <input type="number" id="inv-qtd-fisica" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500" placeholder="Ex: 12">
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button onclick="lancarInventario()" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold text-sm px-6 py-2.5 rounded-lg flex items-center space-x-2 transition-all">
                            <i data-lucide="check" class="w-4 h-4"></i>
                            <span>Processar Auditoria e Lançar Ajuste</span>
                        </button>
                    </div>
                </div>
            </section>

            <!-- TAB 8: AUDITORIA & LOGS -->
            <section id="tab-auditoria" class="tab-content hidden space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-white">Logs de Auditoria de Sistema (Rastreamento Imutável)</h2>
                    <p class="text-slate-400">Todos os registos e alterações que ocorreram no banco de dados com IP, Equipamento e estado anterior.</p>
                </div>

                <div class="bg-slate-950 border border-slate-800 rounded-xl overflow-hidden">
                    <div class="p-4 border-b border-slate-800 flex justify-between items-center bg-slate-900/40">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Histórico de Eventos</span>
                        <span class="text-xs text-slate-500">Registos persistidos em sessão temporária</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-900/60 border-b border-slate-800 text-slate-400 text-xs uppercase tracking-wider">
                                    <th class="py-3 px-4">Timestamp</th>
                                    <th class="py-3 px-4">Operador</th>
                                    <th class="py-3 px-4">Evento / Operação</th>
                                    <th class="py-3 px-4">Dados Anteriores</th>
                                    <th class="py-3 px-4">Novos Dados</th>
                                    <th class="py-3 px-4">IP Máquina</th>
                                </tr>
                            </thead>
                            <tbody id="auditoria-table-body" class="text-xs divide-y divide-slate-900">
                                <!-- Inserido via Javascript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- TAB 9: MODELO DE DADOS (DDL) -->
            <section id="tab-database" class="tab-content hidden space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-white">Estrutura de Modelagem de Dados MySQL (DDL)</h2>
                    <p class="text-slate-400">Instruções SQL normalizadas prontas para produção industrial.</p>
                </div>

                <div class="bg-slate-950 border border-slate-800 rounded-xl p-5">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Script DDL (MySQL 8)</span>
                        <span class="text-xs text-blue-400 code-font">schema_almoxarifado.sql</span>
                    </div>
                    <pre class="bg-slate-900 text-slate-300 p-4 rounded-lg overflow-x-auto text-xs code-font leading-relaxed border border-slate-800" style="max-height: 450px;">
-- Schema do Banco de Dados - SAMA ERP
CREATE DATABASE IF NOT EXISTS sama_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sama_db;

-- 1. Tabela de Almoxarifados Físicos
CREATE TABLE almoxarifados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    codigo VARCHAR(20) UNIQUE NOT NULL,
    localizacao VARCHAR(150),
    ativo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Tabela de Categorias
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    codigo VARCHAR(10) UNIQUE NOT NULL
);

-- 3. Tabela de Fornecedores
CREATE TABLE fornecedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_fantasia VARCHAR(150) NOT NULL,
    razao_social VARCHAR(150) NOT NULL,
    nif_cnpj VARCHAR(20) UNIQUE NOT NULL,
    contacto VARCHAR(50),
    ativo TINYINT(1) DEFAULT 1
);

-- 4. Tabela Principal de Artigos (Produtos)
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_interno VARCHAR(50) UNIQUE NOT NULL,
    descricao VARCHAR(255) NOT NULL,
    descricao_resumida VARCHAR(100),
    categoria_id INT,
    marca VARCHAR(50),
    fabricante VARCHAR(50),
    part_number VARCHAR(100),
    estoque_minimo DECIMAL(12,4) DEFAULT 0.0000,
    estoque_maximo DECIMAL(12,4) DEFAULT 0.0000,
    ponto_reposicao DECIMAL(12,4) DEFAULT 0.0000,
    preco_custo_medio DECIMAL(12,2) DEFAULT 0.00,
    ativo TINYINT(1) DEFAULT 1,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- 5. Estrutura de Localizações Físicas no Almoxarifado
CREATE TABLE localizacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_barras VARCHAR(50) UNIQUE NOT NULL,
    corredor VARCHAR(10),
    estante VARCHAR(10),
    prateleira VARCHAR(10),
    nivel VARCHAR(10)
);

-- 6. Tabela de Códigos de Barras Adicionais
CREATE TABLE codigos_barras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    tipo VARCHAR(30) NOT NULL, -- EAN, UPC, QR Code, Fornecedor
    codigo VARCHAR(100) UNIQUE NOT NULL,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);

-- 7. Histórico Unificado de Movimentações (Saldo Nunca é Estático)
CREATE TABLE movimentacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    tipo VARCHAR(20) NOT NULL, -- 'ENTRADA', 'SAIDA', 'AJUSTE'
    origem VARCHAR(100),
    destino VARCHAR(100),
    quantidade DECIMAL(12,4) NOT NULL,
    saldo_anterior DECIMAL(12,4) NOT NULL,
    saldo_posterior DECIMAL(12,4) NOT NULL,
    usuario_id INT,
    data_movimento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    documento_ref VARCHAR(50), -- O.S. ou Nota Fiscal
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

-- 8. Tabela de Logs de Auditoria
CREATE TABLE auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    evento VARCHAR(100) NOT NULL,
    dados_anteriores TEXT,
    dados_novos TEXT,
    ip_endereco VARCHAR(45) NOT NULL,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
                    </pre>
                </div>
            </section>
        </main>
    </div>

    <!-- NOTIFICAÇÃO FLOATING -->
    <div id="toast" class="fixed bottom-5 right-5 bg-emerald-600 text-white px-5 py-3 rounded-xl border border-emerald-500 shadow-2xl flex items-center space-x-3 transition-all duration-350 translate-y-20 opacity-0 pointer-events-none z-50">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <span class="text-sm font-semibold" id="toast-message">Operação concluída com sucesso!</span>
    </div>

    <!-- MODAL: DETALHES DE PRODUTO -->
    <div id="modal-detalhes-produto" class="fixed inset-0 bg-black/70 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-slate-950 border border-slate-800 rounded-xl w-full max-w-2xl p-6 relative">
            <button onclick="closeModal('modal-detalhes-produto')" class="absolute top-4 right-4 text-slate-400 hover:text-white">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
            <div id="modal-detalhes-conteudo">
                <!-- Preenchido via JS -->
            </div>
        </div>
    </div>

    <!-- MODAL: NOVO PRODUTO -->
    <div id="modal-novo-produto" class="fixed inset-0 bg-black/70 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-slate-950 border border-slate-800 rounded-xl w-full max-w-2xl p-6 relative">
            <button onclick="closeModal('modal-novo-produto')" class="absolute top-4 right-4 text-slate-400 hover:text-white">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
            <h2 class="text-xl font-bold text-white mb-4">Criar Novo Artigo / Peça de Manutenção</h2>
            <form id="form-novo-produto" onsubmit="criarProduto(event)" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Código Interno</label>
                        <input type="text" id="p-codigo" placeholder="Ex: PRD1007" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Part Number</label>
                        <input type="text" id="p-pn" placeholder="Ex: PN-RML990" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                    </div>
                </div>
                <div>
                    <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Descrição Completa</label>
                    <input type="text" id="p-descricao" placeholder="Ex: Rolamento Autocompensador de Rolos" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Categoria</label>
                        <select id="p-categoria" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500">
                            <option value="Mecânica">Mecânica</option>
                            <option value="Elétrica">Elétrica</option>
                            <option value="Hidráulica">Hidráulica</option>
                            <option value="Pneumática">Pneumática</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Marca</label>
                        <input type="text" id="p-marca" placeholder="SKF, Bosch..." class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Preço Inicial (€)</label>
                        <input type="number" id="p-preco" step="0.01" placeholder="0.00" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Estoque Mínimo</label>
                        <input type="number" id="p-min" placeholder="5" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Estoque Máximo</label>
                        <input type="number" id="p-max" placeholder="100" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500 font-semibold uppercase block mb-1">Localização Padrão</label>
                        <input type="text" id="p-localizacao" placeholder="LOC-A2-E1" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500" required>
                    </div>
                </div>
                <div class="flex justify-end space-x-2 pt-4">
                    <button type="button" onclick="closeModal('modal-novo-produto')" class="bg-slate-900 hover:bg-slate-850 text-slate-400 border border-slate-800 font-semibold text-sm px-4 py-2 rounded-lg transition-all">Cancelar</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold text-sm px-5 py-2 rounded-lg transition-all">Salvar Artigo</button>
                </div>
            </form>
        </div>
    </div>

    <script type="module" src="assets/js/main.js"></script>
</body>
</html>