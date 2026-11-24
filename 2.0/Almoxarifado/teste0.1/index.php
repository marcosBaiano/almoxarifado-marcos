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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
        .code-font {
            font-family: 'JetBrains Mono', monospace;
        }
        /* Custom scrollbar para visual premium */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
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

    <!-- LOGICA DO SISTEMA EM JAVASCRIPT ES6 (Simula Arquitetura de Produção ERP com In-Memory State) -->
    <script>
        // --- BASE DE DADOS SIMULADA (REPOSITÓRIOS EM MEMÓRIA) ---
        let state = {
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
                    preco_custo_medio: 45.50,
                    lote_control: 'LOT-2026/A',
                    validade_control: '2030-12-31',
                    localizacao: 'LOC-A1-E3',
                    estoque_atual: 8 // Forçando abaixo do mínimo para testar regras de ponto de reposição
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
                    descricao: 'Eletroválvula de Controle Direcional 5/2 vias G1/4',
                    descricao_resumida: 'Eletroválvula 5/2 vias',
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
                    estoque_atual: 3 // Crítico
                },
                {
                    id: 4,
                    codigo_interno: 'PRD1004',
                    part_number: 'PN-ORING-K3',
                    descricao: 'Kit de Juntas O-Ring Nitrílica NBR 70 Shore',
                    descricao_resumida: 'Kit O-Ring Nitrílica',
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
                },

                {
                    id: 5,
                    codigo_interno: 'PRD1004',
                    part_number: 'PN-ORING-K3',
                    descricao: 'Kit de Juntas O-Ring Nitrílica NBR 70 Shore',
                    descricao_resumida: 'Kit O-Ring Nitrílica',
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

        // --- ARQUITETURA SERVICES & REPOSITORIES (Simulando em JS para visualização de boas práticas) ---
        class AuditoriaService {
            static log(evento, anterior, novo) {
                const logItem = {
                    id: state.auditoria.length + 1,
                    timestamp: new Date().toISOString().replace('T', ' ').substring(0, 19),
                    usuario: 'Manuel Silva',
                    evento: evento,
                    dados_anteriores: typeof anterior === 'object' ? JSON.stringify(anterior) : anterior,
                    dados_novos: typeof novo === 'object' ? JSON.stringify(novo) : novo,
                    ip: '192.168.10.45'
                };
                state.auditoria.unshift(logItem);
                renderAuditoria();
            }
        }

        class EstoqueService {
            static registrarMovimentacao(produtoId, tipo, quantidade, documentoRef, destino, operador = 'Manuel Silva') {
                const produto = state.produtos.find(p => p.id === produtoId);
                if (!produto) throw new Error('Artigo não localizado no banco de dados.');

                const saldoAnterior = produto.estoque_atual;
                let saldoPosterior = saldoAnterior;

                if (tipo === 'ENTRADA') {
                    saldoPosterior += quantidade;
                } else if (tipo === 'SAIDA') {
                    if (saldoAnterior < quantidade) {
                        throw new Error(`Rotina transacional abortada: Stock insuficiente de ${produto.descricao_resumida}.`);
                    }
                    saldoPosterior -= quantidade;
                } else if (tipo === 'AJUSTE') {
                    saldoPosterior = quantidade;
                }

                // Simulação de alteração atómica (Transação de BD)
                const copiaSeguraAnterior = { ...produto };
                produto.estoque_atual = saldoPosterior;

                const mov = {
                    id: state.movimentacoes.length + 1,
                    produto_id: produtoId,
                    timestamp: new Date().toISOString().replace('T', ' ').substring(0, 19),
                    tipo: tipo,
                    quantidade: quantidade,
                    saldo_anterior: saldoAnterior,
                    saldo_posterior: saldoPosterior,
                    documento_ref: documentoRef,
                    operador: operador,
                    destino: destino
                };

                state.movimentacoes.unshift(mov);
                
                // Gravação do log imutável de auditoria
                AuditoriaService.log(`MOV_ESTOQUE_${tipo}`, copiaSeguraAnterior, produto);
                
                // Recalcular Dashboards e Views
                refreshDashboard();
                renderProdutosTable();
                renderProdutosSelects();
                
                return true;
            }
        }

        // --- CONTROLO DE INTERFACE DO USUÁRIO (VIEW CONTROLLER) ---
        function switchTab(tabId) {
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

        // --- SISTEMA FLOATING DE MENSARENS (TOASTS) ---
        function showNotification(message, type = 'success') {
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

        // --- MODAL CONTROLLERS ---
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // --- RENDERIZADORES DE VIEW (MVC PATTERN) ---
        function formatEuro(val) {
            return new Intl.NumberFormat('pt-PT', { style: 'currency', currency: 'EUR' }).format(val);
        }

        function refreshDashboard() {
            // KPI Cálculo
            document.getElementById('kpi-total-produtos').textContent = state.produtos.length;
            
            const criticos = state.produtos.filter(p => p.estoque_atual < p.estoque_minimo);
            document.getElementById('kpi-estoque-critico').textContent = criticos.length;

            const pendentes = state.requisicoes.filter(r => r.status === 'Pendente');
            document.getElementById('kpi-req-pendentes').textContent = pendentes.length;

            const valorTotal = state.produtos.reduce((acc, curr) => acc + (curr.estoque_atual * curr.preco_custo_medio), 0);
            document.getElementById('kpi-valor-estoque').textContent = formatEuro(valorTotal);

            // Alertas Críticos (HTML render)
            const alertasContainer = document.getElementById('alertas-criticos-container');
            alertasContainer.innerHTML = '';

            if (criticos.length === 0) {
                alertasContainer.innerHTML = `
                    <div class="bg-emerald-950/20 border border-emerald-900/60 p-4 rounded-lg text-center text-emerald-400 text-xs font-semibold">
                        Nenhum produto em nível crítico de stock.
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
                                <span class="text-xs text-rose-400 font-bold block">${p.estoque_atual} de ${p.estoque_minimo} Mín</span>
                                <span class="text-[9px] text-slate-500 uppercase font-semibold">Reposição Crítica</span>
                            </div>
                        </div>
                    `;
                });
            }

            // Atividades Recentes
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
                            <span class="font-bold text-white block">${produto.descricao_resumida || 'Peça Desconhecida'}</span>
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

        function renderProdutosTable() {
            const tableBody = document.getElementById('produtos-table-body');
            tableBody.innerHTML = '';

            const searchTerm = document.getElementById('filter-search').value.toLowerCase();
            const catFilter = document.getElementById('filter-categoria').value;
            const stockFilter = document.getElementById('filter-estoque').value;

            const filtered = state.produtos.filter(p => {
                const matchesSearch = p.codigo_interno.toLowerCase().includes(searchTerm) || 
                                      p.descricao.toLowerCase().includes(searchTerm) || 
                                      p.part_number.toLowerCase().includes(searchTerm);
                
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
                        <td colspan="8" class="py-12 text-center text-slate-500 italic">Nenhum artigo encontrado com as especificações atuais de busca.</td>
                    </tr>
                `;
                return;
            }

            filtered.forEach(p => {
                const isCritico = p.estoque_atual < p.estoque_minimo;
                const statusStockClass = isCritico ? 'text-rose-400 bg-rose-950/40 border border-rose-900/60' : 'text-emerald-400 bg-emerald-950/40 border border-emerald-900/40';

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

        function renderProdutosSelects() {
            const recSelect = document.getElementById('rec-item-produto');
            const saiSelect = document.getElementById('sai-item-produto');
            const invSelect = document.getElementById('inv-produto');

            const options = state.produtos.map(p => `<option value="${p.id}">${p.codigo_interno} - ${p.descricao_resumida}</option>`).join('');

            recSelect.innerHTML = options;
            saiSelect.innerHTML = options;
            invSelect.innerHTML = options;

            atualizarEstoqueDisponivelSaida();
            atualizarEstoqueAtualInventario();
        }

        function renderAuditoria() {
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

        function applyFilters() {
            renderProdutosTable();
        }

        // --- VISÃO COMPLETA DE DETALHES DE ARTIQO (MODAL DETALHES) ---
        function verDetalhesProduto(id) {
            const p = state.produtos.find(p => p.id === id);
            if (!p) return;

            const container = document.getElementById('modal-detalhes-conteudo');
            const logsRelacionados = state.movimentacoes.filter(m => m.produto_id === p.id);

            let logsHTML = '';
            if (logsRelacionados.length === 0) {
                logsHTML = `<tr><td colspan="4" class="py-3 text-center text-slate-500 text-xs italic">Nenhuma movimentação registada para este artigo.</td></tr>`;
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
                        <span class="text-[10px] text-slate-500 uppercase block">Endereço de Armazenamento</span>
                        <span class="text-emerald-400 font-bold block mt-0.5 code-font">${p.localizacao}</span>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[10px] text-slate-500 uppercase block">Fabricante & Distribuição</span>
                        <span class="text-white block mt-0.5">${p.fabricante}</span>
                    </div>
                    <div class="bg-slate-900 p-3 rounded-lg border border-slate-800">
                        <span class="text-[10px] text-slate-500 uppercase block">Criticidade Mín/Máx</span>
                        <span class="text-white block mt-0.5 code-font">Mínimo: ${p.estoque_minimo} un / Máximo: ${p.estoque_maximo} un</span>
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

        // --- SISTEMA REQUISIÇÕES (FLUXO COMPLETO INDUSTRIAL) ---
        function renderRequisicoes() {
            const container = document.getElementById('requisicoes-container');
            container.innerHTML = '';

            const pendentes = state.requisicoes.filter(r => r.status === 'Pendente');

            if (pendentes.length === 0) {
                container.innerHTML = `
                    <div class="bg-slate-950 border border-slate-800 rounded-xl p-8 text-center text-slate-500 italic">
                        Nenhuma requisição de peças aberta ou pendente de atendimento para hoje.
                    </div>
                `;
                return;
            }

            pendentes.forEach(r => {
                const p = state.produtos.find(prod => prod.id === r.produto_id) || {};
                const estoqueSuficiente = p.estoque_atual >= r.quantidade;
                const statusEstoqueHTML = estoqueSuficiente 
                    ? `<span class="text-xs text-emerald-400 font-bold bg-emerald-950/40 px-2 py-0.5 rounded border border-emerald-900/50">Disponível em Stock (${p.estoque_atual} un)</span>`
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
                                <span>Localização de Recolha: <b class="text-emerald-400 code-font">${p.localizacao}</b></span>
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

        function atenderRequisicao(id) {
            const req = state.requisicoes.find(r => r.id === id);
            if (!req) return;

            const p = state.produtos.find(prod => prod.id === req.produto_id);
            if (!p) return;

            try {
                // Processamento de transação atómica através do Service
                EstoqueService.registrarMovimentacao(p.id, 'SAIDA', req.quantidade, req.os, req.setor, 'Manuel Silva');
                
                // Mudar status de requisição
                req.status = 'Atendida';

                showNotification('Requisição processada e peça baixada com sucesso.');
                renderRequisicoes();
            } catch (err) {
                showNotification(err.message, 'error');
            }
        }

        // --- PROCESSO DE ENTRADA (RECEBIMENTO) ---
        let itensRecebimentoTemporarios = [];

        function adicionarItemRecebimento() {
            const produtoId = parseInt(document.getElementById('rec-item-produto').value);
            const qtd = parseInt(document.getElementById('rec-item-qtd').value);
            const preco = parseFloat(document.getElementById('rec-item-preco').value);

            if (isNaN(qtd) || qtd <= 0 || isNaN(preco) || preco <= 0) {
                showNotification('Informe valores reais e válidos para a entrada do artigo.', 'error');
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

            // Limpar Campos
            document.getElementById('rec-item-qtd').value = '';
            document.getElementById('rec-item-preco').value = '';
        }

        function removerItemRecebimento(idx) {
            itensRecebimentoTemporarios.splice(idx, 1);
            renderTabelaItensRecebimento();
        }

        function renderTabelaItensRecebimento() {
            const tbody = document.getElementById('tabela-itens-recebimento');
            tbody.innerHTML = '';

            if (itensRecebimentoTemporarios.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="py-8 text-center text-slate-500 italic">Nenhum item adicionado ao lançamento.</td></tr>`;
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

        function processarRecebimento(e) {
            e.preventDefault();
            
            if (itensRecebimentoTemporarios.length === 0) {
                showNotification('Adicione pelo menos um artigo à lista antes de salvar.', 'error');
                return;
            }

            const tipo = document.getElementById('rec-tipo').value;
            const doc = document.getElementById('rec-documento').value;

            // Transação segura para cada item da lista
            itensRecebimentoTemporarios.forEach(item => {
                EstoqueService.registrarMovimentacao(item.produto_id, 'ENTRADA', item.quantidade, doc, item.localizacao);
            });

            showNotification('Entrada de stock processada e lotes registados com sucesso.');
            limparFormRecebimento();
        }

        function limparFormRecebimento() {
            itensRecebimentoTemporarios = [];
            document.getElementById('form-recebimento').reset();
            renderTabelaItensRecebimento();
        }

        // --- PROCESSO DE SAÍDA ---
        let itensSaidaTemporarios = [];

        function atualizarEstoqueDisponivelSaida() {
            const produtoId = parseInt(document.getElementById('sai-item-produto').value);
            const p = state.produtos.find(prod => prod.id === produtoId);
            if (p) {
                document.getElementById('sai-estoque-disponivel').textContent = `Stock disponível: ${p.estoque_atual} un`;
            }
        }

        function adicionarItemSaida() {
            const produtoId = parseInt(document.getElementById('sai-item-produto').value);
            const qtd = parseInt(document.getElementById('sai-item-qtd').value);

            if (isNaN(qtd) || qtd <= 0) {
                showNotification('Informe uma quantidade válida para retirada.', 'error');
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

        function removerItemSaida(idx) {
            itensSaidaTemporarios.splice(idx, 1);
            renderTabelaItensSaida();
        }

        function renderTabelaItensSaida() {
            const tbody = document.getElementById('tabela-itens-saida');
            tbody.innerHTML = '';

            if (itensSaidaTemporarios.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" class="py-8 text-center text-slate-500 italic">Nenhuma peça adicionada para saída.</td></tr>`;
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

        function processarSaida(e) {
            e.preventDefault();

            if (itensSaidaTemporarios.length === 0) {
                showNotification('Adicione itens de recolha antes de efetuar a saída de stock.', 'error');
                return;
            }

            const os = document.getElementById('sai-os').value;
            const setor = document.getElementById('sai-setor').value;

            // Execução transacional de baixa
            try {
                itensSaidaTemporarios.forEach(item => {
                    EstoqueService.registrarMovimentacao(item.produto_id, 'SAIDA', item.quantidade, os, setor);
                });
                showNotification('Saída efetuada. Stock atualizado com as respetivas baixas.');
                limparFormSaida();
            } catch (err) {
                showNotification(err.message, 'error');
            }
        }

        function limparFormSaida() {
            itensSaidaTemporarios = [];
            document.getElementById('form-saida').reset();
            renderTabelaItensSaida();
            atualizarEstoqueDisponivelSaida();
        }

        // --- SISTEMA DE CADASTRO DE NOVO PRODUTO ---
        function criarProduto(e) {
            e.preventDefault();
            
            const codigo = document.getElementById('p-codigo').value.toUpperCase();
            const pn = document.getElementById('p-pn').value.toUpperCase();
            const desc = document.getElementById('p-descricao').value;
            const categoria = document.getElementById('p-categoria').value;
            const marca = document.getElementById('p-marca').value;
            const preco = parseFloat(document.getElementById('p-preco').value);
            const min = parseInt(document.getElementById('p-min').value);
            const max = parseInt(document.getElementById('p-max').value);
            const loc = document.getElementById('p-localizacao').value.toUpperCase();

            // Verificação de Unicidade
            if (state.produtos.some(p => p.codigo_interno === codigo)) {
                showNotification('Já existe um produto registado com este código interno!', 'error');
                return;
            }

            const novoPrd = {
                id: state.produtos.length + 1,
                codigo_interno: codigo,
                part_number: pn,
                descricao: desc,
                descricao_resumida: desc.split(' ').slice(0, 3).join(' '),
                categoria: categoria,
                marca: marca,
                fabricante: 'Forn. Homologado SAMA',
                estoque_minimo: min,
                estoque_maximo: max,
                ponto_reposicao: Math.ceil(min * 1.5),
                preco_custo_medio: preco,
                lote_control: 'LOT-REG-' + new Date().getFullYear(),
                validade_control: 'N/A',
                localizacao: loc,
                estoque_atual: 0 // Inicia zerado para entrada posterior via recebimento
            };

            state.produtos.push(novoPrd);
            AuditoriaService.log('PROD_CRIADO', '-', novoPrd);

            showNotification('Novo artigo adicionado ao catálogo com sucesso!');
            closeModal('modal-novo-produto');
            document.getElementById('form-novo-produto').reset();
            
            // Recarregar UI
            renderProdutosTable();
            renderProdutosSelects();
            refreshDashboard();
        }

        // --- INVENTÁRIO ROTATIVO (AJUSTES EM TELA) ---
        function atualizarEstoqueAtualInventario() {
            const produtoId = parseInt(document.getElementById('inv-produto').value);
            const p = state.produtos.find(prod => prod.id === produtoId);
            if (p) {
                document.getElementById('inv-qtd-sistema').value = `${p.estoque_atual} un`;
            }
        }

        function lancarInventario() {
            const produtoId = parseInt(document.getElementById('inv-produto').value);
            const qtdFisica = parseInt(document.getElementById('inv-qtd-fisica').value);

            if (isNaN(qtdFisica) || qtdFisica < 0) {
                showNotification('Informe um valor de contagem física correto.', 'error');
                return;
            }

            const p = state.produtos.find(prod => prod.id === produtoId);
            if (!p) return;

            // Processar transação de auditoria física de stock
            EstoqueService.registrarMovimentacao(p.id, 'AJUSTE', qtdFisica, 'INV-' + new Date().getFullYear(), 'Ajuste Físico de Inventário');
            showNotification('Ajuste de inventário efetuado com registo de auditoria imutável.');
            
            document.getElementById('inv-qtd-fisica').value = '';
            atualizarEstoqueAtualInventario();
        }

        // --- SIMULADOR DE SCANNER AUTOMÁTICO (USB / COLETOR) ---
        // Fluxo avançado "Zero Cliques"
        document.getElementById('scanner-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const code = this.value.toUpperCase().trim();
                this.value = ''; // Limpar imediatamente preparando o próximo bip
                
                if (code.startsWith('LOC-')) {
                    // Simulação de localização bipada
                    showNotification(`Localização identificada: ${code}`, 'success');
                    AuditoriaService.log('SCANNER_BIP_LOC', '-', `Endereço bipado: ${code}`);
                    return;
                }

                // Identificar Produto por Código Interno
                const p = state.produtos.find(prod => prod.codigo_interno === code);
                
                const resultCard = document.getElementById('scanner-result-card');
                
                if (!p) {
                    showNotification(`Nenhum artigo encontrado para o código: ${code}`, 'error');
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
                            <span class="text-[10px] text-slate-400 uppercase block font-semibold">Endereço</span>
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

                    <!-- Lançamento Rápido no Scanner -->
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
            }
        });

        function lancarEstoqueRapidoScanner(produtoId, tipo) {
            const qtyInput = document.getElementById('quick-add-qty');
            const qty = parseInt(qtyInput.value);

            if (isNaN(qty) || qty <= 0) {
                showNotification('Informe uma quantidade válida para movimentar via leitor.', 'error');
                return;
            }

            try {
                EstoqueService.registrarMovimentacao(produtoId, tipo, qty, 'SCANNER-AUTOMATICO', 'Scanner de Balcão');
                showNotification(`Transação processada via scanner: ${tipo} de ${qty} un efetuada.`);
                document.getElementById('scanner-result-card').classList.add('hidden');
            } catch(err) {
                showNotification(err.message, 'error');
            }
        }

        // --- STARTUP DA APLICAÇÃO ---
        window.onload = function() {
            // Inicializar Views e Tabelas
            refreshDashboard();
            renderProdutosTable();
            renderProdutosSelects();
            renderRequisicoes();
            renderAuditoria();
            lucide.createIcons();
        };
    </script>
</body>
</html>