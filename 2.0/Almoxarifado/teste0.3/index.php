<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almoxarifado de Manutenção - Central de Movimentação & Engenharia</title>
    <!-- Tailwind CSS para Design Premium -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons para interface profissional -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        .code-font {
            font-family: 'JetBrains Mono', monospace;
        }
        /* Custom scrollbar para visual limpo de ERP */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0b1329;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }
    </style>
</head>
<body class="bg-[#0b1120] text-slate-100 min-h-screen flex flex-col overflow-x-hidden">

    <!-- BARRA TOPO / HEADER -->
    <header class="border-b border-slate-800 bg-slate-950 px-6 py-4 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-600 p-2.5 rounded-lg text-white shadow-lg shadow-indigo-500/20">
                    <i data-lucide="package-open" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold tracking-tight text-white flex items-center gap-2">
                        SIGA-MNT <span class="text-xs bg-indigo-500/20 text-indigo-400 font-medium px-2 py-0.5 rounded-full border border-indigo-500/30">Módulo Almoxarifado</span>
                    </h1>
                    <p class="text-xs text-slate-400">Entrada, Saída, Rastreabilidade e Auditoria Sólida</p>
                </div>
            </div>
            
            <!-- Indicadores Rápidos de Sessão -->
            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-300">
                <div class="flex items-center gap-2 bg-slate-900 px-3 py-1.5 rounded-md border border-slate-800">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Pipeline de Identificação: <strong class="text-emerald-400">Ativo</strong></span>
                </div>
                <div class="flex items-center gap-2 bg-slate-900 px-3 py-1.5 rounded-md border border-slate-800">
                    <i data-lucide="user" class="w-3.5 h-3.5 text-indigo-400"></i>
                    <span>Operador: <strong class="text-indigo-300">ENG_SOUZA (ID: 104)</strong></span>
                </div>
                <div class="flex items-center gap-2 bg-slate-900 px-3 py-1.5 rounded-md border border-slate-800">
                    <i data-lucide="shield" class="w-3.5 h-3.5 text-rose-400"></i>
                    <span>Perfil: <strong class="text-rose-400">ADMIN / PCM</strong></span>
                </div>
                <div class="flex items-center gap-2 bg-slate-900 px-3 py-1.5 rounded-md border border-slate-800">
                    <i data-lucide="monitor" class="w-3.5 h-3.5 text-indigo-400"></i>
                    <span>IP Terminal: <strong class="text-indigo-300">192.168.10.45</strong></span>
                </div>
            </div>
        </div>
    </header>

    <!-- MENU DE NAVEGAÇÃO ENTRE ABAS PRINCIPAIS -->
    <nav class="bg-slate-900/60 border-b border-slate-800/80 px-6 py-2 sticky top-[73px] z-40 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex flex-wrap gap-2">
            <button onclick="switchTab('dashboard')" id="tabBtn-dashboard" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all bg-indigo-600 text-white shadow-lg shadow-indigo-500/10">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
            </button>
            <button onclick="switchTab('movimentacao')" id="tabBtn-movimentacao" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800">
                <i data-lucide="arrow-left-right" class="w-4 h-4"></i> Entrada e Saída (Lançamento)
            </button>
            <button onclick="switchTab('consulta')" id="tabBtn-consulta" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800">
                <i data-lucide="search" class="w-4 h-4"></i> Consulta de Estoque
            </button>
            <button onclick="switchTab('ajuste')" id="tabBtn-ajuste" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800">
                <i data-lucide="sliders" class="w-4 h-4"></i> Ajuste Físico
            </button>
            <button onclick="switchTab('arquitetura')" id="tabBtn-arquitetura" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all text-amber-400 hover:bg-amber-500/10 border border-amber-500/20">
                <i data-lucide="git-branch" class="w-4 h-4"></i> Documentação de Engenharia & MER
            </button>
        </div>
    </nav>

    <!-- CONTAINER CONTEÚDO PRINCIPAL -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-4 md:p-6">
        
        <!-- ========================================== -->
        <!-- ABA 1: DASHBOARD DE INDICADORES -->
        <!-- ========================================== -->
        <section id="tab-dashboard" class="tab-content flex flex-col gap-6">
            <!-- Grid de Indicadores Rápidos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl shadow-lg flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Total de Produtos Cadastrados</span>
                        <span id="dash-total-items" class="text-2xl font-black text-white code-font">4</span>
                        <span class="text-[10px] text-indigo-400 block mt-1">Materiais ativos e catalogados</span>
                    </div>
                    <div class="bg-indigo-500/10 p-3 rounded-lg text-indigo-400 border border-indigo-500/20">
                        <i data-lucide="package" class="w-6 h-6"></i>
                    </div>
                </div>
                <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl shadow-lg flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Peças em Estoque Físico</span>
                        <span id="dash-total-stock" class="text-2xl font-black text-emerald-400 code-font">52</span>
                        <span class="text-[10px] text-slate-400 block mt-1">Soma das unidades físicas</span>
                    </div>
                    <div class="bg-emerald-500/10 p-3 rounded-lg text-emerald-400 border border-emerald-500/20">
                        <i data-lucide="boxes" class="w-6 h-6"></i>
                    </div>
                </div>
                <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl shadow-lg flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Estoque Crítico (Abaixo do Mín)</span>
                        <span id="dash-low-stock" class="text-2xl font-black text-amber-500 code-font">1</span>
                        <span class="text-[10px] text-amber-400 block mt-1">Abaixo do limite de segurança</span>
                    </div>
                    <div class="bg-amber-500/10 p-3 rounded-lg text-amber-500 border border-amber-500/20">
                        <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                    </div>
                </div>
                <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl shadow-lg flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Produtos com Estoque Zerado</span>
                        <span id="dash-zero-stock" class="text-2xl font-black text-rose-500 code-font">0</span>
                        <span class="text-[10px] text-rose-400 block mt-1">Ruptura de estoque físico</span>
                    </div>
                    <div class="bg-rose-500/10 p-3 rounded-lg text-rose-500 border border-rose-500/20">
                        <i data-lucide="shield-alert" class="w-6 h-6"></i>
                    </div>
                </div>
            </div>

            <!-- Divisória Visual: Gráficos de barra rápidos e Últimas Movimentações -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Painel Esquerdo: Resumo do Estado do Almoxarifado -->
                <div class="lg:col-span-8 bg-slate-950 border border-slate-800 p-6 rounded-xl flex flex-col gap-4">
                    <h3 class="text-sm font-bold tracking-wider text-slate-300 uppercase flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-indigo-400"></i>
                        Últimas Movimentações Registradas
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="border-b border-slate-850 text-slate-400">
                                    <th class="py-3 px-2">Data/Hora</th>
                                    <th class="py-3 px-2">Tipo</th>
                                    <th class="py-3 px-2">Material</th>
                                    <th class="py-3 px-2 text-right">Qtd</th>
                                    <th class="py-3 px-2 text-right">Saldo Ant.</th>
                                    <th class="py-3 px-2 text-right">Saldo Novo</th>
                                    <th class="py-3 px-2">Origem</th>
                                </tr>
                            </thead>
                            <tbody id="dash-movements-tbody" class="divide-y divide-slate-900 code-font">
                                <!-- Preenchido dinamicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Painel Direito: Links Rápidos & Guia de Chão de Fábrica -->
                <div class="lg:col-span-4 flex flex-col gap-6">
                    <div class="bg-gradient-to-br from-indigo-950/40 to-slate-950 border border-indigo-500/20 p-5 rounded-xl">
                        <h4 class="text-sm font-bold text-indigo-300 flex items-center gap-2">
                            <i data-lucide="terminal" class="w-4 h-4"></i> Operação de Chão de Fábrica
                        </h4>
                        <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                            O sistema foi otimizado para operações consecutivas de entrada e saída de peças de reposição. Use um leitor de códigos USB ou Bluetooth configurado para simular o envio de Enter.
                        </p>
                        <ul class="mt-4 flex flex-col gap-2 text-[11px] text-slate-300">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-indigo-400 rounded-full"></span> <strong>[F2]</strong> Volta foco ao código de barras</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-indigo-400 rounded-full"></span> <strong>[F9]</strong> Confirma lançamento na tela</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-indigo-400 rounded-full"></span> <strong>[F10]</strong> Submete cadastro rápido</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-indigo-400 rounded-full"></span> <strong>[ESC]</strong> Cancela ou limpa a tela atual</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- ABA 2: ENTRADA E SAÍDA (O COFRE DE LANÇAMENTOS) -->
        <!-- ========================================== -->
        <section id="tab-movimentacao" class="tab-content hidden flex-col gap-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- COLUNA ESQUERDA: OPERAÇÃO (8 colunas) -->
                <div class="lg:col-span-8 flex flex-col gap-6">
                    
                    <!-- PIPELINE DE IDENTIFICAÇÃO DE PRODUTO -->
                    <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 shadow-lg relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-500"></div>
                        
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-sm font-semibold tracking-wider text-slate-300 uppercase flex items-center gap-2">
                                <i data-lucide="scan-barcode" class="w-4 h-4 text-indigo-400"></i>
                                Pipeline de Identificação de Produto
                            </h2>
                            <span class="text-[10px] bg-slate-800 text-slate-400 px-2.5 py-1 rounded-md border border-slate-700">
                                Atalhos: [ESC] Limpar | [F2] Foco Código
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                            <!-- Input de Leitura/Código -->
                            <div class="md:col-span-8 relative">
                                <label for="barcodeInput" class="block text-xs font-medium text-slate-400 mb-1.5">
                                    Escaneie o Código de Barras ou Digite o ID/Modelo
                                </label>
                                <div class="relative">
                                    <input type="text" id="barcodeInput" 
                                        class="w-full bg-slate-900 border-2 border-slate-700 rounded-lg pl-10 pr-4 py-3 text-white placeholder-slate-500 font-mono text-base focus:outline-none focus:border-indigo-500 transition-all shadow-inner"
                                        placeholder="Aponte o leitor ou digite o código..." autocomplete="off">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="barcode" class="h-5 w-5 text-slate-400" id="barcodeIcon"></i>
                                    </div>
                                </div>
                                
                                <!-- Painel de Sugestão / Autocomplete Manual -->
                                <div id="autocompleteDropdown" class="hidden absolute left-0 right-0 mt-1 bg-slate-950 border border-slate-800 rounded-lg shadow-2xl z-50 max-h-60 overflow-y-auto">
                                    <!-- Injetado dinamicamente -->
                                </div>
                            </div>

                            <!-- Modo de Leitura Detectado -->
                            <div class="md:col-span-4">
                                <label class="block text-xs font-medium text-slate-400 mb-1.5">Origem da Leitura Detectada</label>
                                <div class="grid grid-cols-2 gap-2 h-[52px]">
                                    <div id="modeScanner" class="flex items-center justify-center gap-2 rounded-lg border border-slate-800 bg-slate-900 text-slate-500 font-medium text-xs transition-all duration-200">
                                        <i data-lucide="zap" class="w-4 h-4"></i>
                                        Scanner
                                    </div>
                                    <div id="modeManual" class="flex items-center justify-center gap-2 rounded-lg border-2 border-indigo-500/50 bg-indigo-950/20 text-indigo-400 font-medium text-xs transition-all duration-200">
                                        <i data-lucide="keyboard" class="w-4 h-4"></i>
                                        Digitação
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status do Pipeline de Busca (Indicadores Visuais de Resolução de APIs) -->
                        <div class="mt-4 pt-4 border-t border-slate-900 flex flex-wrap items-center justify-between gap-3 text-xs">
                            <span class="text-slate-400 font-medium">Cadeia de Resolução:</span>
                            <div class="flex items-center gap-2 flex-wrap text-[11px]">
                                <span id="stepLocal" class="px-2 py-1 rounded bg-slate-900 border border-slate-800 text-slate-500 flex items-center gap-1">
                                    <i data-lucide="database" class="w-3 h-3"></i> 1. Banco Local
                                </span>
                                <i data-lucide="chevron-right" class="w-3 h-3 text-slate-600"></i>
                                <span id="stepMerchant" class="px-2 py-1 rounded bg-slate-900 border border-slate-800 text-slate-500 flex items-center gap-1">
                                    <i data-lucide="globe" class="w-3 h-3"></i> 2. Google Merchant (Ext)
                                </span>
                                <i data-lucide="chevron-right" class="w-3 h-3 text-slate-600"></i>
                                <span id="stepBrasil" class="px-2 py-1 rounded bg-slate-900 border border-slate-800 text-slate-500 flex items-center gap-1">
                                    <i data-lucide="link" class="w-3 h-3"></i> 3. BrasilAPI (Ext)
                                </span>
                                <i data-lucide="chevron-right" class="w-3 h-3 text-slate-600"></i>
                                <span id="stepManual" class="px-2 py-1 rounded bg-slate-900 border border-slate-800 text-slate-500 flex items-center gap-1">
                                    <i data-lucide="user-plus" class="w-3 h-3"></i> 4. Cadastro Manual
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- CARD DINÂMICO DE INTERAÇÃO -->
                    <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 shadow-lg flex-1 flex flex-col justify-between min-h-[400px]">
                        
                        <!-- ESTADO 1: Aguardando identificação de produto -->
                        <div id="statePlaceholder" class="flex-1 flex flex-col items-center justify-center text-center p-8">
                            <div class="w-16 h-16 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center mb-4 text-slate-500 animate-pulse">
                                <i data-lucide="search-code" class="w-8 h-8"></i>
                            </div>
                            <h3 class="text-base font-semibold text-slate-300">Aguardando Identificação</h3>
                            <p class="text-xs text-slate-500 max-w-sm mt-1">
                                Insira um código de barras, código interno, modelo ou part number do material para iniciar a movimentação de estoque.
                            </p>
                        </div>

                        <!-- ESTADO 2: Produto Identificado com Sucesso -->
                        <div id="stateProductFound" class="hidden flex-1 flex flex-col gap-6">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-slate-900/50 p-4 rounded-lg border border-slate-800">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-slate-800 rounded-lg flex items-center justify-center border border-slate-700 text-slate-400 overflow-hidden relative">
                                        <img id="prodImage" src="" class="w-full h-full object-cover hidden" alt="Produto">
                                        <i id="prodFallbackIcon" data-lucide="box" class="w-8 h-8"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span id="prodCategory" class="text-[10px] font-bold tracking-wider text-indigo-400 bg-indigo-500/10 border border-indigo-500/20 px-2 py-0.5 rounded uppercase">Elétrica</span>
                                            <span id="prodID" class="text-[10px] font-mono text-slate-400 bg-slate-800 px-2 py-0.5 rounded">ID: 000</span>
                                        </div>
                                        <h3 id="prodName" class="text-lg font-bold text-white mt-1">Contator Tripolar Siemens 3RT</h3>
                                        <p class="text-xs text-slate-400 flex items-center gap-2 mt-0.5">
                                            <span>Part Number: <strong class="text-slate-200 code-font" id="prodPN">3RT2015</strong></span>
                                            <span class="text-slate-600">|</span>
                                            <span>Marca: <strong class="text-slate-200" id="prodBrand">Siemens</strong></span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Saldo em Tempo Real -->
                                <div class="bg-slate-900 px-4 py-3 rounded-lg border border-slate-700 min-w-[120px] text-center">
                                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Saldo Atual</span>
                                    <span id="prodStock" class="text-2xl font-black text-emerald-400 code-font">42</span>
                                    <span id="prodUnit" class="text-xs text-slate-400 block -mt-1">UN</span>
                                </div>
                            </div>

                            <!-- Formulário de Operação -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Lado Esquerdo: Tipo / Quantidade -->
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">Tipo de Movimentação</label>
                                        <div class="grid grid-cols-2 gap-3">
                                            <button type="button" id="btnTypeEntrada" onclick="setMovementType('ENTRADA')"
                                                class="py-3 px-4 rounded-lg font-bold text-sm border-2 transition-all flex items-center justify-center gap-2 bg-emerald-950/20 border-emerald-500 text-emerald-400 shadow-lg shadow-emerald-500/5">
                                                <i data-lucide="arrow-down-left" class="w-4 h-4"></i> ENTRADA
                                            </button>
                                            <button type="button" id="btnTypeSaida" onclick="setMovementType('SAIDA')"
                                                class="py-3 px-4 rounded-lg font-bold text-sm border-2 transition-all flex items-center justify-center gap-2 bg-slate-900 border-slate-800 text-slate-400 hover:border-rose-500/50 hover:text-rose-400">
                                                <i data-lucide="arrow-up-right" class="w-4 h-4"></i> SAÍDA
                                            </button>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="quantityInput" class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">Quantidade</label>
                                            <input type="number" id="quantityInput" min="1" step="any"
                                                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-lg font-bold text-white code-font focus:outline-none focus:border-indigo-500 text-center" 
                                                value="1">
                                        </div>
                                        <div id="setorContainer" class="hidden">
                                            <label for="setorInput" class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">Setor Destino</label>
                                            <select id="setorInput" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2.5 text-sm font-semibold text-white focus:outline-none focus:border-rose-500">
                                                <!-- Injetado dinamicamente -->
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lado Direito: Justificativa / Metadata -->
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <label for="obsInput" class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">Observação / Justificativa</label>
                                        <textarea id="obsInput" rows="3" 
                                            class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-indigo-500"
                                            placeholder="Ex: Lote recebido via NF-e 10293..."></textarea>
                                    </div>

                                    <div class="bg-slate-900/30 p-3 rounded-lg border border-slate-800/80 text-[11px] text-slate-400 flex flex-col gap-1.5">
                                        <span class="font-bold text-slate-300">Auditoria do Lançamento:</span>
                                        <div class="grid grid-cols-2 gap-x-4 gap-y-1 font-mono">
                                            <div>Operador: <span class="text-slate-300">ID 104</span></div>
                                            <div>Terminal: <span class="text-slate-300">MNT-W10-04</span></div>
                                            <div>Leitor: <span id="auditSource" class="text-slate-300">TECLADO</span></div>
                                            <div>Timestamp: <span id="auditTime" class="text-slate-300">15/07/2026</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botões de Ação -->
                            <div class="flex justify-end gap-3 pt-4 border-t border-slate-900">
                                <button onclick="cancelCurrentOperation()" class="px-6 py-2.5 rounded-lg text-slate-400 hover:bg-slate-900 text-sm font-semibold transition-all">
                                    Cancelar [ESC]
                                </button>
                                <button id="btnConfirmarMovimentacao" onclick="executeMovement()" class="px-8 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm shadow-lg shadow-emerald-600/20 flex items-center gap-2 transition-all">
                                    <i data-lucide="check-circle" class="w-4 h-4"></i> Confirmar Lançamento [F9]
                                </button>
                            </div>
                        </div>

                        <!-- ESTADO 3: Produto Não Encontrado -->
                        <div id="stateNotFound" class="hidden flex-1 flex flex-col items-center justify-center text-center p-6">
                            <div class="w-16 h-16 rounded-full bg-amber-500/10 border border-amber-500/30 flex items-center justify-center mb-4 text-amber-500">
                                <i data-lucide="alert-triangle" class="w-8 h-8"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-200">Material não Localizado na Base</h3>
                            <p class="text-xs text-slate-400 max-w-md mt-1">
                                O código <strong class="text-amber-400 code-font" id="missingCodeSpan">123456</strong> foi processado no banco de dados e APIs integradas, mas nenhum registro foi encontrado.
                            </p>

                            <div class="flex flex-col sm:flex-row gap-3 mt-6">
                                <button onclick="cancelCurrentOperation()" class="px-5 py-2.5 rounded-lg border border-slate-800 text-slate-400 text-xs font-semibold hover:bg-slate-900 transition-all">
                                    Buscar outro Código
                                </button>
                                <button onclick="openCadastroForm()" class="px-6 py-2.5 rounded-lg bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold shadow-lg shadow-amber-500/10 flex items-center justify-center gap-2 transition-all">
                                    <i data-lucide="plus-circle" class="w-4 h-4"></i> Cadastrar Novo Produto Agora [F4]
                                </button>
                            </div>
                        </div>

                        <!-- ESTADO 4: Cadastro Rápido Integrado -->
                        <div id="stateCadastroForm" class="hidden flex-1 flex flex-col gap-5">
                            <div class="flex justify-between items-center pb-3 border-b border-slate-900">
                                <div>
                                    <h3 class="text-md font-bold text-white flex items-center gap-2">
                                        <i data-lucide="file-plus" class="text-amber-500 w-5 h-5"></i>
                                        Cadastro Rápido de Material
                                    </h3>
                                    <p class="text-xs text-slate-400">Após salvar, o produto será automaticamente injetado e selecionado no fluxo.</p>
                                </div>
                                <span class="text-xs font-bold text-amber-500 bg-amber-500/10 border border-amber-500/20 px-2.5 py-1 rounded">
                                    Cadastro via Fluxo de Entrada
                                </span>
                            </div>

                            <!-- Form de Cadastro -->
                            <form id="newProductForm" onsubmit="saveNewProduct(event)" class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                                <div>
                                    <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Código de Barras</label>
                                    <input type="text" id="newProdBarcode" required readonly
                                        class="w-full bg-slate-900 border border-slate-850 text-amber-400 rounded p-2.5 font-mono text-xs focus:outline-none cursor-not-allowed">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Descrição Completa *</label>
                                    <input type="text" id="newProdName" required placeholder="Ex: Sensor Indutivo M18 NPN NA Sn 8mm"
                                        class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2.5 focus:outline-none focus:border-indigo-500 text-xs">
                                </div>

                                <div>
                                    <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Marca *</label>
                                    <input type="text" id="newProdBrand" required placeholder="Ex: Balluff, Siemens, Festo"
                                        class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2.5 focus:outline-none focus:border-indigo-500 text-xs">
                                </div>

                                <div>
                                    <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Part Number</label>
                                    <input type="text" id="newProdPN" placeholder="Ex: BES M18EG-PSC80B-S04K"
                                        class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2.5 focus:outline-none focus:border-indigo-500 text-xs code-font">
                                </div>

                                <div>
                                    <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Categoria *</label>
                                    <select id="newProdCategory" required class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2.5 focus:outline-none focus:border-indigo-500 text-xs">
                                        <option value="Elétrica">Elétrica</option>
                                        <option value="Mecânica">Mecânica</option>
                                        <option value="Pneumática">Pneumática</option>
                                        <option value="Hidráulica">Hidráulica</option>
                                        <option value="EPIs">EPIs</option>
                                        <option value="Ferramentas">Ferramentas</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Unidade Medida</label>
                                    <select id="newProdUnit" class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2.5 text-xs focus:outline-none">
                                        <option value="UN">Unidade (UN)</option>
                                        <option value="PC">Peça (PC)</option>
                                        <option value="MT">Metro (MT)</option>
                                        <option value="JG">Jogo (JG)</option>
                                        <option value="KG">Quilo (KG)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Estoque Inicial</label>
                                    <input type="number" id="newProdStock" min="0" value="0"
                                        class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2.5 focus:outline-none focus:border-indigo-500 text-xs code-font">
                                </div>

                                <div>
                                    <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Estoque Mínimo</label>
                                    <input type="number" id="newProdMinStock" min="0" value="5"
                                        class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2.5 focus:outline-none focus:border-indigo-500 text-xs code-font">
                                </div>

                                <div>
                                    <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Estoque Máximo</label>
                                    <input type="number" id="newProdMaxStock" min="1" value="100"
                                        class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2.5 focus:outline-none focus:border-indigo-500 text-xs code-font">
                                </div>

                                <div>
                                    <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Localização Física</label>
                                    <input type="text" id="newProdLocation" placeholder="Ex: PR-A1"
                                        class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2.5 focus:outline-none focus:border-indigo-500 text-xs code-font">
                                </div>

                                <!-- Upload de Arquivo / Foto (Preparação para Estrutura de Anexos) -->
                                <div class="md:col-span-3">
                                    <label class="block text-slate-400 font-medium mb-1.5 uppercase tracking-wider">Anexos do Material (Ficha Técnica / Manuais / Imagens)</label>
                                    <div class="border-2 border-dashed border-slate-800 bg-slate-900/30 rounded-lg p-4 text-center cursor-pointer hover:border-indigo-500/50 transition-all flex flex-col items-center gap-1">
                                        <i data-lucide="upload-cloud" class="w-6 h-6 text-indigo-400"></i>
                                        <span class="text-slate-300 font-medium">Arraste arquivos ou clique para fazer upload</span>
                                        <span class="text-[10px] text-slate-500">Suporte a PDF, JPG, PNG (Previsão de integração com Bucket AWS S3)</span>
                                        <input type="file" id="newProdFiles" class="hidden" multiple accept=".pdf,.jpg,.png">
                                    </div>
                                </div>

                                <div class="md:col-span-3 flex justify-end gap-3 pt-3 border-t border-slate-900">
                                    <button type="button" onclick="cancelCurrentOperation()" class="px-5 py-2 rounded text-slate-400 hover:bg-slate-900 text-xs font-semibold">
                                        Cancelar
                                    </button>
                                    <button type="submit" class="px-6 py-2 rounded bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center gap-2">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i> Salvar e Selecionar [F10]
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

                <!-- COLUNA DIREITA: AUDITORIA REAL-TIME & INVENTÁRIO (4 colunas) -->
                <div class="lg:col-span-4 flex flex-col gap-6">
                    <!-- Trilha de Auditoria -->
                    <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 shadow-lg flex flex-col h-[320px]">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="text-sm font-semibold tracking-wider text-slate-300 uppercase flex items-center gap-2">
                                <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                                Auditoria de Operações
                            </h2>
                            <span class="text-[9px] bg-emerald-500/10 text-emerald-400 px-2 py-0.5 rounded border border-emerald-500/20 font-bold uppercase">
                                Não Excluível
                            </span>
                        </div>
                        <div id="auditLogContainer" class="flex-1 overflow-y-auto pr-1 flex flex-col gap-2.5 text-[11px] code-font">
                            <!-- Injetado dinamicamente -->
                        </div>
                    </div>

                    <!-- Inventário de Linha -->
                    <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 shadow-lg flex flex-col h-[340px]">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="text-sm font-semibold tracking-wider text-slate-300 uppercase flex items-center gap-2">
                                <i data-lucide="archive" class="w-4 h-4 text-indigo-400"></i>
                                Inventário Local
                            </h2>
                            <span id="inventoryCounter" class="text-xs bg-slate-900 border border-slate-800 text-slate-300 px-2 py-0.5 rounded font-bold">4 itens</span>
                        </div>
                        <div class="flex-1 overflow-y-auto pr-1 flex flex-col gap-2" id="stockListContainer">
                            <!-- Injetado dinamicamente -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- ABA 3: CONSULTA GERAL & HISTÓRICO DE ESTOQUE -->
        <!-- ========================================== -->
        <section id="tab-consulta" class="tab-content hidden flex flex-col gap-6">
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 shadow-lg flex flex-col gap-4">
                
                <!-- Filtros Avançados de Busca -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs text-slate-400 mb-1.5 font-semibold uppercase">Busca Livre (Código, Nome, Marca, Modelo)</label>
                        <div class="relative">
                            <input type="text" id="filterSearch" oninput="filterInventory()"
                                class="w-full bg-slate-900 border border-slate-800 rounded px-3 py-2 text-xs focus:outline-none focus:border-indigo-500 text-white placeholder-slate-600"
                                placeholder="Digite para filtrar instantaneamente...">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1.5 font-semibold uppercase">Filtrar por Categoria</label>
                        <select id="filterCategory" onchange="filterInventory()"
                            class="w-full bg-slate-900 border border-slate-800 rounded px-3 py-2 text-xs focus:outline-none focus:border-indigo-500 text-white">
                            <option value="TODAS">-- Todas as Categorias --</option>
                            <option value="Elétrica">Elétrica</option>
                            <option value="Mecânica">Mecânica</option>
                            <option value="Pneumática">Pneumática</option>
                            <option value="Hidráulica">Hidráulica</option>
                            <option value="EPIs">EPIs</option>
                            <option value="Ferramentas">Ferramentas</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1.5 font-semibold uppercase">Filtrar por Status</label>
                        <select id="filterStatus" onchange="filterInventory()"
                            class="w-full bg-slate-900 border border-slate-800 rounded px-3 py-2 text-xs focus:outline-none focus:border-indigo-500 text-white">
                            <option value="TODOS">-- Todos os Status --</option>
                            <option value="NORMAL">🟢 Estoque Normal</option>
                            <option value="BAIXO">🟡 Estoque Baixo</option>
                            <option value="ZERADO">🔴 Estoque Zerado</option>
                            <option value="EXCESSO">🔵 Acima do Máximo</option>
                        </select>
                    </div>
                </div>

                <!-- Tabela de Cadastro de Estoque Principal -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-850 text-slate-400">
                                <th class="py-3 px-2">ID / Cód. Barras</th>
                                <th class="py-3 px-2">Descrição / Peça</th>
                                <th class="py-3 px-2">Categoria</th>
                                <th class="py-3 px-2">Localização</th>
                                <th class="py-3 px-2 text-right">Saldo Físico</th>
                                <th class="py-3 px-2 text-right">Mín / Máx</th>
                                <th class="py-3 px-2 text-center">Status</th>
                                <th class="py-3 px-2 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="inventory-table-tbody" class="divide-y divide-slate-900">
                            <!-- Preenchido dinamicamente -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MODAL DETALHES DE PRODUTO & HISTÓRICO COMPLETO -->
            <div id="productDetailModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
                <div class="bg-slate-900 border border-slate-800 rounded-xl max-w-4xl w-full max-h-[90vh] overflow-hidden flex flex-col shadow-2xl">
                    <div class="px-6 py-4 border-b border-slate-800 flex justify-between items-center bg-slate-950/50">
                        <h3 class="font-bold text-base text-white flex items-center gap-2">
                            <i data-lucide="info" class="text-indigo-400 w-5 h-5"></i>
                            Ficha Técnica & Rastreabilidade do Material
                        </h3>
                        <button onclick="closeProductModal()" class="text-slate-400 hover:text-white">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <div class="p-6 overflow-y-auto flex-1 flex flex-col gap-6">
                        <!-- Topo: Dados Básicos e Imagem -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-slate-950 p-4 rounded-lg border border-slate-800 flex items-center justify-center relative overflow-hidden h-40">
                                <img id="modalProdImg" src="" class="w-full h-full object-cover hidden" alt="Foto Peça">
                                <i id="modalProdFallbackIcon" data-lucide="box" class="w-12 h-12 text-slate-700"></i>
                            </div>
                            <div class="md:col-span-2 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span id="modalProdCategory" class="text-[10px] font-bold text-indigo-400 bg-indigo-500/10 px-2.5 py-0.5 rounded border border-indigo-500/20 uppercase">ELÉTRICA</span>
                                        <span id="modalProdID" class="text-[10px] font-mono text-slate-400 bg-slate-950 px-2 py-0.5 rounded">ID: 0</span>
                                        <span id="modalProdLocation" class="text-[10px] font-mono text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded">LOC: PR-A1</span>
                                    </div>
                                    <h4 id="modalProdName" class="text-lg font-bold text-white">Nome do Material</h4>
                                    <p class="text-xs text-slate-400 mt-1">Marca: <strong id="modalProdBrand" class="text-slate-200">Siemens</strong> | Part Number: <strong id="modalProdPN" class="text-slate-200">3RT</strong></p>
                                    <p class="text-xs text-slate-400">Código de Barras: <strong id="modalProdBarcode" class="text-slate-200">0000</strong></p>
                                </div>
                                <div class="bg-slate-950/50 p-3 rounded border border-slate-850 flex justify-between text-xs mt-3">
                                    <div>Estoque Atual: <strong id="modalProdStock" class="text-emerald-400 font-mono">10 UN</strong></div>
                                    <div>Mínimo: <strong id="modalProdMin" class="text-slate-300 font-mono">4 UN</strong></div>
                                    <div>Máximo: <strong id="modalProdMax" class="text-slate-300 font-mono">50 UN</strong></div>
                                </div>
                            </div>
                        </div>

                        <!-- Histórico de Movimentações -->
                        <div>
                            <h5 class="text-xs font-bold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-1.5">
                                <i data-lucide="arrow-left-right" class="w-3.5 h-3.5 text-indigo-400"></i>
                                Histórico de Movimentações (Entrada / Saída / Ajuste)
                            </h5>
                            <div class="bg-slate-950 rounded-lg border border-slate-800 max-h-48 overflow-y-auto">
                                <table class="w-full text-left text-[11px] code-font">
                                    <thead>
                                        <tr class="bg-slate-900 text-slate-400 border-b border-slate-850">
                                            <th class="p-2">Data/Hora</th>
                                            <th class="p-2">Operação</th>
                                            <th class="p-2 text-right">Qtd</th>
                                            <th class="p-2 text-right">Anterior</th>
                                            <th class="p-2 text-right">Posterior</th>
                                            <th class="p-2">Destino / Obs</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modalProdMovementsTbody" class="divide-y divide-slate-900">
                                        <!-- Injetado via JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Trilha de Mudanças de Cadastro -->
                        <div>
                            <h5 class="text-xs font-bold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-1.5">
                                <i data-lucide="shield" class="w-3.5 h-3.5 text-rose-400"></i>
                                Auditoria de Alterações Cadastrais
                            </h5>
                            <div class="bg-slate-950 rounded-lg border border-slate-800 max-h-40 overflow-y-auto">
                                <table class="w-full text-left text-[11px] code-font">
                                    <thead>
                                        <tr class="bg-slate-900 text-slate-400 border-b border-slate-850">
                                            <th class="p-2">Data/Hora</th>
                                            <th class="p-2">Alterado Por</th>
                                            <th class="p-2">Campo</th>
                                            <th class="p-2 text-right">De</th>
                                            <th class="p-2 text-right">Para</th>
                                            <th class="p-2">Terminal / Origem</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modalProdAuditTbody" class="divide-y divide-slate-900">
                                        <!-- Injetado via JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- ABA 4: AJUSTE FISICO DE INVENTÁRIO -->
        <!-- ========================================== -->
        <section id="tab-ajuste" class="tab-content hidden flex flex-col gap-6">
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 shadow-lg max-w-3xl mx-auto w-full relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-amber-500"></div>
                <div class="flex items-center gap-3 border-b border-slate-900 pb-4 mb-6">
                    <div class="bg-amber-500/10 p-2 rounded text-amber-500 border border-amber-500/20">
                        <i data-lucide="sliders" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Ajuste de Estoque</h3>
                        <p class="text-xs text-slate-400">Regularização manual de saldo para auditorias internas de inventário.</p>
                    </div>
                </div>

                <form onsubmit="executeInventoryAdjustment(event)" class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                    <div class="md:col-span-2">
                        <label class="block text-slate-400 font-medium mb-1.5 uppercase">Selecione o Material para Ajuste *</label>
                        <select id="adjProductSelect" required onchange="onAdjustmentProductChange()"
                            class="w-full bg-slate-900 border border-slate-700 text-white rounded p-3 focus:outline-none focus:border-amber-500 font-semibold">
                            <option value="">-- Escolha o Material --</option>
                            <!-- Injetado via JS -->
                        </select>
                    </div>

                    <!-- Dados Atuais -->
                    <div class="bg-slate-900 p-4 rounded-lg border border-slate-800">
                        <span class="block text-[10px] uppercase font-bold text-slate-400">Saldo Atual em Sistema</span>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span id="adjCurrentStockVal" class="text-3xl font-black text-indigo-400 code-font">0</span>
                            <span id="adjCurrentUnit" class="text-xs text-slate-400">UN</span>
                        </div>
                        <span class="text-[10px] text-slate-500 block mt-1">Este valor representa a quantidade computada atualmente no banco.</span>
                    </div>

                    <!-- Nova Quantidade -->
                    <div class="flex flex-col justify-between">
                        <div>
                            <label for="adjNewQty" class="block text-slate-400 font-medium mb-1.5 uppercase">Novo Saldo Físico Encontrado *</label>
                            <input type="number" id="adjNewQty" required min="0" step="any"
                                class="w-full bg-slate-900 border border-slate-700 text-white text-lg font-bold code-font rounded p-3 focus:outline-none focus:border-amber-500 text-center"
                                placeholder="0">
                        </div>
                    </div>

                    <!-- Justificativa Obrigatória -->
                    <div class="md:col-span-2">
                        <label for="adjReason" class="block text-slate-400 font-medium mb-1.5 uppercase">Justificativa de Ajuste (Obrigatória para Auditoria) *</label>
                        <textarea id="adjReason" required rows="3"
                            class="w-full bg-slate-900 border border-slate-700 text-white rounded p-3 focus:outline-none focus:border-amber-500"
                            placeholder="Ex: Identificado desvio de contagem no inventário rotativo nº 04..."></textarea>
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-3 pt-4 border-t border-slate-900">
                        <button type="button" onclick="cancelCurrentOperation()" class="px-5 py-2.5 rounded text-slate-400 hover:bg-slate-900 text-xs font-semibold">
                            Limpar campos
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs flex items-center gap-2 shadow-lg shadow-amber-500/10">
                            <i data-lucide="check" class="w-4 h-4"></i> Gravar Ajuste Físico [F9]
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- ABA 5: ENGENHARIA DE SOFTWARE & ARQUITETURA -->
        <!-- ========================================== -->
        <section id="tab-arquitetura" class="tab-content hidden flex flex-col gap-6">
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 shadow-lg flex flex-col gap-8">
                
                <!-- Título da Seção -->
                <div class="flex items-center gap-3 border-b border-slate-900 pb-4">
                    <div class="bg-indigo-600/10 p-2.5 rounded text-indigo-400 border border-indigo-500/20">
                        <i data-lucide="git-branch" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-white">Especificação Técnica de Arquitetura & MER</h2>
                        <p class="text-xs text-slate-400">Estruturação sólida para o Almoxarifado como núcleo do futuro ERP Industrial.</p>
                    </div>
                </div>

                <!-- DIAGRAMA DE ARQUITETURA (SISTEMA DE MÓDULOS) -->
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-300 mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                        1. Diagrama Geral de Arquitetura de Software
                    </h3>
                    <div class="bg-slate-900 p-6 rounded-lg border border-slate-850 flex flex-col gap-4 text-xs">
                        <p class="text-slate-400 mb-2 leading-relaxed">
                            A arquitetura proposta baseia-se no padrão **Clean Architecture / Hexagonal (Ports & Adapters)** acoplada a camadas bem definidas de **Services (Regras de Negócio)** e **Repositories (Acesso a Banco de Dados com PDO)**, permitindo que a infraestrutura externa (Lookup de APIs de Produtos) e o banco MySQL se integrem sem vazamento de escopo.
                        </p>
                        <!-- Diagrama em SVG nativo -->
                        <div class="flex justify-center p-4 bg-slate-950 rounded-xl border border-slate-800">
                            <svg viewBox="0 0 800 350" class="w-full max-w-3xl text-xs text-slate-300">
                                <!-- Camada de Interface -->
                                <rect x="50" y="20" width="160" height="60" rx="6" fill="#1e293b" stroke="#4f46e5" stroke-width="2"/>
                                <text x="130" y="45" font-family="Inter" font-weight="bold" fill="#fff" text-anchor="middle">Camada View</text>
                                <text x="130" y="65" font-family="Inter" fill="#94a3b8" text-anchor="middle">HTML5 / JS ES6 / Tailwind</text>

                                <!-- Controller -->
                                <rect x="290" y="20" width="160" height="60" rx="6" fill="#1e293b" stroke="#4f46e5" stroke-width="2"/>
                                <text x="370" y="45" font-family="Inter" font-weight="bold" fill="#fff" text-anchor="middle">Controllers (API)</text>
                                <text x="370" y="65" font-family="Inter" fill="#94a3b8" text-anchor="middle">PHP Controllers (endpoints)</text>

                                <!-- Services (Camada de Negócio) -->
                                <rect x="290" y="140" width="160" height="70" rx="6" fill="#312e81" stroke="#818cf8" stroke-width="2"/>
                                <text x="370" y="165" font-family="Inter" font-weight="bold" fill="#fff" text-anchor="middle">Service Layer</text>
                                <text x="370" y="185" font-family="Inter" fill="#c7d2fe" text-anchor="middle">StockMovementService</text>
                                <text x="370" y="200" font-family="Inter" fill="#c7d2fe" text-anchor="middle">ProductPipelineService</text>

                                <!-- Repositories -->
                                <rect x="290" y="260" width="160" height="60" rx="6" fill="#1e293b" stroke="#10b981" stroke-width="2"/>
                                <text x="370" y="285" font-family="Inter" font-weight="bold" fill="#fff" text-anchor="middle">Repository Pattern</text>
                                <text x="370" y="305" font-family="Inter" fill="#a7f3d0" text-anchor="middle">PDO / Prepared SQL</text>

                                <!-- Banco Local MySQL -->
                                <rect x="580" y="260" width="170" height="60" rx="6" fill="#064e3b" stroke="#10b981" stroke-width="2"/>
                                <text x="665" y="285" font-family="Inter" font-weight="bold" fill="#fff" text-anchor="middle">MySQL Database</text>
                                <text x="665" y="305" font-family="Inter" fill="#a7f3d0" text-anchor="middle">Integridade Referencial</text>

                                <!-- Lookup Provider Interface -->
                                <rect x="580" y="145" width="170" height="60" rx="6" fill="#581c87" stroke="#a855f7" stroke-width="2"/>
                                <text x="665" y="170" font-family="Inter" font-weight="bold" fill="#fff" text-anchor="middle">ProdutoLookupProvider</text>
                                <text x="665" y="190" font-family="Inter" fill="#f3e8ff" text-anchor="middle">Cadeia de Fornecimento Ext.</text>

                                <!-- Linhas de Ligação -->
                                <line x1="210" y1="50" x2="290" y2="50" stroke="#cbd5e1" stroke-width="1.5" stroke-dasharray="4"/>
                                <line x1="370" y1="80" x2="370" y2="140" stroke="#cbd5e1" stroke-width="1.5"/>
                                <line x1="370" y1="210" x2="370" y2="260" stroke="#cbd5e1" stroke-width="1.5"/>
                                <line x1="450" y1="175" x2="580" y2="175" stroke="#cbd5e1" stroke-width="1.5"/>
                                <line x1="450" y1="290" x2="580" y2="290" stroke="#cbd5e1" stroke-width="1.5"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- MODELO ENTIDADE RELACIONAMENTO (MER) - SCRIPT DDL COMPLETO -->
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-300 mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        2. Modelo Entidade-Relacionamento (MER) & Script DDL SQL (MySQL)
                    </h3>
                    <div class="bg-slate-900 p-5 rounded-lg border border-slate-850 flex flex-col gap-4 text-xs">
                        <p class="text-slate-400">
                            Abaixo está o script SQL DDL estruturado com integridade referencial nativa, triggers para auditoria passiva, índices compostos de alta performance, restrições e transações. Copie para criar o esquema em seu banco MySQL.
                        </p>
                        <!-- Bloco de código DDL -->
                        <pre class="bg-slate-950 p-4 rounded-lg border border-slate-800 text-slate-300 code-font overflow-x-auto select-all max-h-96">
CREATE DATABASE IF NOT EXISTS erp_almoxarifado CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE erp_almoxarifado;

-- 1. TABELA DE PERFIS/PERMISSÕES
CREATE TABLE permissoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_perfil VARCHAR(50) NOT NULL UNIQUE,
    pode_ajustar TINYINT(1) NOT NULL DEFAULT 0,
    pode_cadastrar TINYINT(1) NOT NULL DEFAULT 1,
    pode_retirar TINYINT(1) NOT NULL DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. TABELA DE USUÁRIOS
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    permissao_id INT NOT NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (permissao_id) REFERENCES permissoes(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 3. TABELA DE CATEGORIAS
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    codigo_fiscal VARCHAR(10) NULL
) ENGINE=InnoDB;

-- 4. TABELA DE SETORES DESTINATÁRIOS
CREATE TABLE setores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    codigo VARCHAR(20) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- 5. TABELA DE PRODUTOS
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_barras VARCHAR(100) NOT NULL UNIQUE,
    nome VARCHAR(255) NOT NULL,
    marca VARCHAR(100) NOT NULL,
    part_number VARCHAR(100) NULL,
    categoria_id INT NOT NULL,
    unidade VARCHAR(10) NOT NULL DEFAULT 'UN',
    localizacao VARCHAR(50) NULL,
    estoque_atual DECIMAL(12,4) NOT NULL DEFAULT 0.0000,
    estoque_minimo DECIMAL(12,4) NOT NULL DEFAULT 0.0000,
    estoque_maximo DECIMAL(12,4) NOT NULL DEFAULT 100.0000,
    imagem_url VARCHAR(255) NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_produtos_codbar (codigo_barras),
    INDEX idx_produtos_busca (nome, marca, part_number),
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 6. TABELA ÚNICA DE MOVIMENTAÇÕES DE ESTOQUE (Entradas, Saídas, Ajustes)
CREATE TABLE movimentacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    tipo_movimentacao ENUM('ENTRADA', 'SAIDA', 'AJUSTE', 'DEVOLUCAO', 'TRANSFERENCIA', 'INVENTARIO') NOT NULL,
    quantidade DECIMAL(12,4) NOT NULL,
    saldo_anterior DECIMAL(12,4) NOT NULL,
    saldo_posterior DECIMAL(12,4) NOT NULL,
    usuario_id INT NOT NULL,
    setor_id INT NULL,
    origem ENUM('SCANNER', 'DIGITACAO', 'API') NOT NULL DEFAULT 'DIGITACAO',
    observacao TEXT NULL,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE RESTRICT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE RESTRICT,
    FOREIGN KEY (setor_id) REFERENCES setores(id) ON DELETE SET NULL,
    INDEX idx_mov_produto_data (produto_id, data_hora)
) ENGINE=InnoDB;

-- 7. TABELA DE ARQUIVOS ANEXOS DE PRODUTOS
CREATE TABLE anexos_produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    nome_arquivo VARCHAR(255) NOT NULL,
    tipo_arquivo VARCHAR(50) NOT NULL,
    caminho_url VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 8. TABELA DE AUDITORIA COMPLETA DE TRANSAÇÕES E SEGURANÇA
CREATE TABLE auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    computador_nome VARCHAR(100) NOT NULL,
    tipo_operacao VARCHAR(50) NOT NULL, -- Ex: 'CADASTRO', 'AJUSTE', 'MUDANÇA DE CONFIG'
    detalhes TEXT NOT NULL,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE RESTRICT,
    INDEX idx_audit_usuario (usuario_id),
    INDEX idx_audit_data (data_hora)
) ENGINE=InnoDB;</pre>
                    </div>
                </div>

                <!-- ESTRUTURA DE DIRETÓRIOS PADRÃO PSR-4 (PHP 8 + PDO) -->
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-300 mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        3. Arquitetura de Diretórios do Projeto Backend (PHP 8 Modular)
                    </h3>
                    <div class="bg-slate-900 p-5 rounded-lg border border-slate-850 flex flex-col gap-4 text-xs leading-relaxed text-slate-300">
                        <p class="text-slate-400">
                            Estrutura de pastas profissional do projeto para que seja anexado aos demais módulos do ERP sem gerar acoplamento.
                        </p>
                        <pre class="bg-slate-950 p-4 rounded-lg border border-slate-800 text-slate-300 code-font overflow-x-auto font-medium">
siga-mnt-almoxarifado/
├── config/
│   ├── database.php             # Conexão com PDO e Singleton de transações
│   └── app_config.php           # Configurações de sistema e tokens
├── core/
│   ├── Controller.php           # Classe mãe abstrata do ecossistema
│   ├── DatabaseConnection.php   # Wrapper do PDO para Prepared Statements e Transactions
│   └── DatabaseLookupProvider.php # Interface para lookup externo
├── src/
│   ├── Models/
│   │   ├── Product.php          # Representação atômica do Produto
│   │   ├── Movement.php         # Registro atômico de Movimentação
│   │   └── Audit.php            # Linha de Auditoria
│   ├── Repositories/
│   │   ├── ProductRepository.php  # Operações SQL (SELECT/INSERT/UPDATE) de Produtos
│   │   ├── MovementRepository.php # Gravação de movimentações com PDO
│   │   └── AuditRepository.php    # Registro inalterável de trilha
│   ├── Services/
│   │   ├── StockMovementService.php # REGRA DE NEGÓCIO: Valida saldo, tipo, efetua transação
│   │   └── ProductPipelineService.php # REGRA: Pipeline de busca (Local -> Google -> BrasilAPI)
│   └── Providers/
│       ├── GoogleMerchantProvider.php # Provedor de API externa (Google)
│       └── BrasilApiProvider.php      # Provedor nacional de API de Códigos de Barra
├── views/
│   ├── dashboard.php            # HTML com dados tratados via Controller
│   ├── movimentacao.php         # Painel de operações
│   ├── estoque.php              # Tabela e filtros
│   └── partials/
│       ├── header.php
│       └── footer.php
├── public/
│   ├── index.php                # Front Controller (Rotas)
│   ├── assets/
│   │   ├── css/                 # Tailwind nativo compilado
│   │   └── js/                  # Scripts ES6 (Fetch API)
│   └── uploads/                 # Arquivos de imagem e fichas técnicas
└── logs/
    └── system_errors.log        # Registro rigoroso de falhas de banco e transações</pre>
                    </div>
                </div>

                <!-- JUSTIFICATIVA TÉCNICA DAS DECISÕES -->
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-300 mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                        4. Justificativa Técnica de Engenharia e Princípios S.O.L.I.D.
                    </h3>
                    <div class="bg-slate-900 p-5 rounded-lg border border-slate-850 text-xs text-slate-300 flex flex-col gap-4 leading-relaxed">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-slate-950 p-4 rounded-lg border border-slate-850">
                                <h4 class="font-bold text-white mb-2 text-xs uppercase text-indigo-400">Single Responsibility (SRP)</h4>
                                <p class="text-slate-400">
                                    Nenhuma View possui consultas SQL. Os arquivos da pasta `src/Services` contém estritamente regras operacionais. Toda e qualquer ação de leitura/escrita de banco reside unicamente nos `Repositories`.
                                </p>
                            </div>
                            <div class="bg-slate-950 p-4 rounded-lg border border-slate-850">
                                <h4 class="font-bold text-white mb-2 text-xs uppercase text-indigo-400">Open/Closed & Dependency Inversion</h4>
                                <p class="text-slate-400">
                                    A camada de APIs de lookup de materiais utiliza a interface `ProdutoLookupProvider`. Para introduzir novos portais de consulta ou fornecedores no futuro, basta criar uma classe no diretório `Providers` que implemente a interface, sem modificar o núcleo.
                                </p>
                            </div>
                            <div class="bg-slate-950 p-4 rounded-lg border border-slate-850">
                                <h4 class="font-bold text-white mb-2 text-xs uppercase text-indigo-400">Transação Atômica do Banco</h4>
                                <p class="text-slate-400">
                                    O `StockMovementService` abre uma transação via `$pdo->beginTransaction()`. Se a alteração de estoque, gravação da movimentação ou inserção da auditoria falhar por qualquer motivo, um `$pdo->rollBack()` anula todas as operações para garantir integridade.
                                </p>
                            </div>
                            <div class="bg-slate-950 p-4 rounded-lg border border-slate-850">
                                <h4 class="font-bold text-white mb-2 text-xs uppercase text-indigo-400">Trilha de Auditoria Rigorosa</h4>
                                <p class="text-slate-400">
                                    Segurança industrial estrita: o banco de dados não disponibiliza permissão física de DELETE nas tabelas críticas. Mudanças manuais de contagem física são rotuladas como `AJUSTE` obrigatório com justificativa, preservando o saldo anterior para fins fiscais.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <!-- FOOTER DA SESSÃO -->
    <footer class="bg-slate-950 border-t border-slate-800 py-4 px-6 text-center text-xs text-slate-500 mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <p>© 2026 ERP SIGA-MNT - Módulo Almoxarifado de Peças Críticas de Manutenção. Licenciado para PetroIndústria Brasil.</p>
            <div class="flex gap-4">
                <a href="#" onclick="mockRestoreSeed()" class="text-indigo-400 hover:underline">Reiniciar Base de Demonstração (Seed)</a>
                <span class="text-slate-700">|</span>
                <span class="text-slate-400">Padrão de Arquitetura: Clean-ERP v5.0</span>
            </div>
        </div>
    </footer>

    <!-- NOTIFICAÇÕES TOAST INTEGRADA -->
    <div id="toastContainer" class="fixed bottom-6 right-6 z-50 flex flex-col gap-2 max-w-sm w-full"></div>


    <!-- ========================================== -->
    <!-- ARQUITETURA JS (EMULAÇÃO DOS PADRÕES PHP) -->
    <!-- ========================================== -->
    <script>
        // ==========================================
        // 1. DATA MODELS & SEED DATA (Simulando o MySQL)
        // ==========================================
        
        // Mock da Tabela 'setores'
        const SECTORES_TABLE = [
            { id: 1, nome: "Usinagem de Grande Porte", codigo: "USI-GP" },
            { id: 2, nome: "Linha de Montagem Mecânica", codigo: "LMT-MEC" },
            { id: 3, nome: "Subestação Principal Elétrica", codigo: "SUB-ELET" },
            { id: 4, nome: "Utilidades (Caldeiras e Gases)", codigo: "UTI-GASS" },
            { id: 5, nome: "PCM (Planejamento e Controle de Mnt)", codigo: "PCM-GERAL" }
        ];

        // Seed inicial de produtos
        const INITIAL_PRODUCTS_SEED = [
            {
                id: 101,
                codigo_barras: "7891000123456",
                nome: "Sensor Indutivo BES M18",
                marca: "Balluff",
                part_number: "BES001A",
                categoria: "Elétrica",
                unidade: "UN",
                localizacao: "PR-A1",
                estoque_atual: 15.0,
                estoque_minimo: 4.0,
                estoque_maximo: 50.0,
                imagem: "https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=200"
            },
            {
                id: 102,
                codigo_barras: "7891000789012",
                nome: "Rolamento de Esferas SKF 6204-2Z",
                marca: "SKF",
                part_number: "6204-2Z",
                categoria: "Mecânica",
                unidade: "PC",
                localizacao: "PR-B4",
                estoque_atual: 8.0,
                estoque_minimo: 10.0, // Alerta de baixo estoque
                estoque_maximo: 80.0,
                imagem: "https://images.unsplash.com/photo-1617791160536-598cf32026fb?auto=format&fit=crop&q=80&w=200"
            },
            {
                id: 103,
                codigo_barras: "7891000456123",
                nome: "Válvula Direcional Solenóide Festo",
                marca: "Festo",
                part_number: "VUVS-L20-M52",
                categoria: "Pneumática",
                unidade: "UN",
                localizacao: "PR-A3",
                estoque_atual: 4.0,
                estoque_minimo: 2.0,
                estoque_maximo: 20.0,
                imagem: "https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=200"
            },
            {
                id: 104,
                codigo_barras: "7891000987654",
                nome: "Graxa Alta Temperatura Mobilux EP2",
                marca: "Mobil",
                part_number: "EP2-CARTUCHO",
                categoria: "Mecânica",
                unidade: "KG",
                localizacao: "AL-C2",
                estoque_atual: 25.0,
                estoque_minimo: 8.0,
                estoque_maximo: 100.0,
                imagem: ""
            }
        ];

        // Memória do Banco de Dados Virtual (Simulação Real de Storage)
        let localDatabase = {
            produtos: [],
            movimentacoes: [],
            auditoria: []
        };

        // Carregar do LocalStorage
        function initLocalDatabase(forceReset = false) {
            if (forceReset || !localStorage.getItem('ALMOXARIFADO_DB_V2')) {
                localDatabase.produtos = JSON.parse(JSON.stringify(INITIAL_PRODUCTS_SEED));
                localDatabase.movimentacoes = [
                    {
                        id: 1,
                        produto_id: 101,
                        tipo_movimentacao: "ENTRADA",
                        quantidade: 5.0,
                        saldo_anterior: 10.0,
                        saldo_posterior: 15.0,
                        usuario_id: 104,
                        data_hora: "2026-07-15T10:00:00Z",
                        origem: "SCANNER",
                        observacao: "Lote inicial importado do almoxarifado central"
                    }
                ];
                localDatabase.auditoria = [
                    {
                        id: 1,
                        usuario_id: 104,
                        ip: "192.168.10.45",
                        computador: "MNT-W10-04",
                        tipo_operacao: "ENTRADA DE MATERIAL",
                        tabela: "produtos",
                        registro_id: 101,
                        campo: "estoque_atual",
                        valor_anterior: "10.0",
                        valor_novo: "15.0",
                        data_hora: "2026-07-15T10:00:00Z",
                        origem: "SCANNER"
                    }
                ];
                saveToLocalStorage();
                addToast("Base de dados limpa e sincronizada!", "success");
            } else {
                localDatabase = JSON.parse(localStorage.getItem('ALMOXARIFADO_DB_V2'));
            }
        }

        function saveToLocalStorage() {
            localStorage.setItem('ALMOXARIFADO_DB_V2', JSON.stringify(localDatabase));
        }

        function mockRestoreSeed() {
            initLocalDatabase(true);
            refreshUI();
        }

        // ==========================================
        // 2. CAMADA REPOSITORY PATTERN
        // ==========================================
        class ProductRepository {
            static findById(id) {
                return localDatabase.produtos.find(p => p.id === parseInt(id)) || null;
            }

            static findByBarcode(barcode) {
                return localDatabase.produtos.find(p => p.codigo_barras === String(barcode).trim()) || null;
            }

            static findByFreeSearch(query) {
                const q = query.toLowerCase().trim();
                if (!q) return [];
                return localDatabase.produtos.filter(p => 
                    p.codigo_barras.includes(q) ||
                    String(p.id).includes(q) ||
                    p.nome.toLowerCase().includes(q) ||
                    p.marca.toLowerCase().includes(q) ||
                    (p.part_number && p.part_number.toLowerCase().includes(q)) ||
                    p.categoria.toLowerCase().includes(q)
                );
            }

            static save(product) {
                if (product.id) {
                    const index = localDatabase.produtos.findIndex(p => p.id === product.id);
                    if (index !== -1) {
                        localDatabase.produtos[index] = product;
                        saveToLocalStorage();
                        return product;
                    }
                } else {
                    const maxId = localDatabase.produtos.reduce((max, p) => p.id > max ? p.id : max, 0);
                    product.id = maxId + 1;
                    localDatabase.produtos.push(product);
                    saveToLocalStorage();
                    return product;
                }
                return null;
            }
        }

        class MovementRepository {
            static insert(movement) {
                const maxId = localDatabase.movimentacoes.reduce((max, m) => m.id > max ? m.id : max, 0);
                movement.id = maxId + 1;
                movement.data_hora = new Date().toISOString();
                localDatabase.movimentacoes.push(movement);
                saveToLocalStorage();
                return movement;
            }

            static findByProduct(productId) {
                return localDatabase.movimentacoes
                    .filter(m => m.produto_id === parseInt(productId))
                    .sort((a, b) => new Date(b.data_hora) - new Date(a.data_hora));
            }
        }

        class AuditRepository {
            static log(audit) {
                const maxId = localDatabase.auditoria.reduce((max, a) => a.id > max ? a.id : max, 0);
                audit.id = maxId + 1;
                audit.data_hora = new Date().toISOString();
                localDatabase.auditoria.push(audit);
                saveToLocalStorage();
                return audit;
            }

            static findByProduct(productId) {
                return localDatabase.auditoria
                    .filter(a => a.registro_id === parseInt(productId))
                    .sort((a, b) => new Date(b.data_hora) - new Date(a.data_hora));
            }

            static getLatestLogs(limit = 15) {
                return [...localDatabase.auditoria]
                    .sort((a, b) => b.id - a.id)
                    .slice(0, limit);
            }
        }

        // ==========================================
        // 3. APIS DE CONSULTA EXTERNA (INTERFACES)
        // ==========================================
        class GoogleMerchantProvider {
            static async lookup(barcode) {
                await new Promise(resolve => setTimeout(resolve, 400));
                if (barcode === "7891000111222") {
                    return {
                        codigo_barras: "7891000111222",
                        nome: "Motor Trifásico IP55 Weg 2CV",
                        marca: "WEG",
                        part_number: "W22-0.55-4",
                        categoria: "Mecânica",
                        unidade: "UN",
                        localizacao: "PR-M2",
                        estoque_atual: 0,
                        estoque_minimo: 2,
                        estoque_maximo: 10,
                        imagem: "https://images.unsplash.com/photo-1590986424791-2355385d0442?auto=format&fit=crop&q=80&w=200"
                    };
                }
                return null;
            }
        }

        class BrasilApiProvider {
            static async lookup(barcode) {
                await new Promise(resolve => setTimeout(resolve, 500));
                if (barcode === "7891000333444") {
                    return {
                        codigo_barras: "7891000333444",
                        nome: "Cabo Flexível de Cobre Heptaflex 10mm²",
                        marca: "Prysmian",
                        part_number: "PRY-HEP-10",
                        categoria: "Elétrica",
                        unidade: "MT",
                        localizacao: "AL-E1",
                        estoque_atual: 0,
                        estoque_minimo: 50,
                        estoque_maximo: 500,
                        imagem: ""
                    };
                }
                return null;
            }
        }

        // ==========================================
        // 4. CAMADA DE NEGÓCIO - SERVICES
        // ==========================================
        class ProductPipelineService {
            static async identify(code, updateUIPipelineStatus = () => {}) {
                updateUIPipelineStatus('LOCAL', 'pending');
                let product = ProductRepository.findByBarcode(code) || ProductRepository.findById(code);

                if (product) {
                    updateUIPipelineStatus('LOCAL', 'success');
                    return { source: 'LOCAL', product };
                }
                updateUIPipelineStatus('LOCAL', 'fail');

                updateUIPipelineStatus('MERCHANT', 'pending');
                try {
                    product = await GoogleMerchantProvider.lookup(code);
                    if (product) {
                        updateUIPipelineStatus('MERCHANT', 'success');
                        return { source: 'MERCHANT_API', product };
                    }
                    updateUIPipelineStatus('MERCHANT', 'fail');
                } catch (e) {
                    updateUIPipelineStatus('MERCHANT', 'error');
                }

                updateUIPipelineStatus('BRASIL', 'pending');
                try {
                    product = await BrasilApiProvider.lookup(code);
                    if (product) {
                        updateUIPipelineStatus('BRASIL', 'success');
                        return { source: 'BRASIL_API', product };
                    }
                    updateUIPipelineStatus('BRASIL', 'fail');
                } catch (e) {
                    updateUIPipelineStatus('BRASIL', 'error');
                }

                updateUIPipelineStatus('MANUAL', 'pending');
                return { source: 'NONE', product: null };
            }
        }

        class StockMovementService {
            static process(productId, type, qty, obs, source, sectorId = null) {
                if (qty <= 0) {
                    throw new Error("A quantidade deve ser maior que zero.");
                }

                const product = ProductRepository.findById(productId);
                if (!product) {
                    throw new Error("Material não localizado.");
                }

                const previousStock = parseFloat(product.estoque_atual);
                let posteriorStock = previousStock;

                if (type === 'ENTRADA') {
                    posteriorStock = previousStock + parseFloat(qty);
                } else if (type === 'SAIDA') {
                    if (previousStock < parseFloat(qty)) {
                        throw new Error(`Saldo insuficiente! Estoque disponível: ${previousStock} ${product.unidade}.`);
                    }
                    if (!sectorId) {
                        throw new Error("O setor de destino é obrigatório para saídas.");
                    }
                    posteriorStock = previousStock - parseFloat(qty);
                } else if (type === 'AJUSTE') {
                    posteriorStock = parseFloat(qty);
                } else {
                    throw new Error("Tipo de movimentação inválida.");
                }

                // Iniciar persistência atômica simulando PDO Transaction Commit
                product.estoque_atual = posteriorStock;
                ProductRepository.save(product);

                MovementRepository.insert({
                    produto_id: product.id,
                    tipo_movimentacao: type,
                    quantidade: parseFloat(qty),
                    saldo_anterior: previousStock,
                    saldo_posterior: posteriorStock,
                    usuario_id: 104,
                    origem: source,
                    observacao: obs,
                    setor_id: type === 'SAIDA' ? sectorId : null
                });

                let detailsStr = `${type} de ${qty} ${product.unidade} (Anterior: ${previousStock} | Atual: ${posteriorStock}).`;
                if (type === 'SAIDA') {
                    const sectorObj = SECTORES_TABLE.find(s => s.id === parseInt(sectorId));
                    detailsStr += ` Destino: ${sectorObj ? sectorObj.nome : 'N/A'}`;
                }
                if (obs) detailsStr += ` Justificativa: ${obs}`;

                AuditRepository.log({
                    usuario_id: 104,
                    ip: "192.168.10.45",
                    computador: "MNT-W10-04",
                    tipo_operacao: `${type} DE MATERIAL`,
                    tabela: "produtos",
                    registro_id: product.id,
                    campo: "estoque_atual",
                    valor_anterior: String(previousStock),
                    valor_novo: String(posteriorStock),
                    origem: source,
                    detalhes: detailsStr
                });

                return product;
            }
        }

        // ==========================================
        // 5. INTERFACE & CONTROLLER (TAB SWITCH, RENDERS)
        // ==========================================
        let currentActiveProduct = null;
        let currentMovementType = 'ENTRADA';
        let currentReaderSource = 'TECLADO';
        let activeTab = 'dashboard';

        const barcodeInput = document.getElementById('barcodeInput');
        const statePlaceholder = document.getElementById('statePlaceholder');
        const stateProductFound = document.getElementById('stateProductFound');
        const stateNotFound = document.getElementById('stateNotFound');
        const stateCadastroForm = document.getElementById('stateCadastroForm');

        window.addEventListener('DOMContentLoaded', () => {
            initLocalDatabase();
            lucide.createIcons();
            populateSectorDropdown();
            populateAdjustmentDropdown();
            refreshUI();
            
            barcodeInput.focus();

            setupBarcodeReaderListeners();
            setupKeyboardShortcuts();
        });

        function switchTab(tabId) {
            activeTab = tabId;
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.getElementById(`tab-${tabId}`).classList.remove('hidden');

            document.querySelectorAll('nav button').forEach(btn => {
                btn.className = "flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800";
            });

            const activeBtn = document.getElementById(`tabBtn-${tabId}`);
            if (tabId === 'arquitetura') {
                activeBtn.className = "flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all bg-amber-500 text-slate-950 shadow-lg shadow-amber-500/10";
            } else {
                activeBtn.className = "flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all bg-indigo-600 text-white shadow-lg shadow-indigo-500/10";
            }

            if (tabId === 'movimentacao') {
                barcodeInput.focus();
            }

            refreshUI();
        }

        function setupBarcodeReaderListeners() {
            let keyTimes = [];
            barcodeInput.addEventListener('keydown', (e) => {
                keyTimes.push(performance.now());
                if (e.key === 'Enter') {
                    e.preventDefault();
                    let averageTime = 0;
                    if (keyTimes.length > 1) {
                        let diffs = [];
                        for(let i = 1; i < keyTimes.length; i++) {
                            diffs.push(keyTimes[i] - keyTimes[i-1]);
                        }
                        averageTime = diffs.reduce((a,b) => a+b, 0) / diffs.length;
                    }

                    if (averageTime > 0 && averageTime < 35) {
                        currentReaderSource = 'SCANNER';
                        setReaderSourceUI('SCANNER');
                    } else {
                        currentReaderSource = 'TECLADO';
                        setReaderSourceUI('TECLADO');
                    }

                    triggerPipelineSearch(barcodeInput.value);
                    keyTimes = [];
                }
            });

            barcodeInput.addEventListener('input', () => {
                const query = barcodeInput.value;
                if (query.length < 2) {
                    hideAutocomplete();
                    return;
                }
                const suggestions = ProductRepository.findByFreeSearch(query);
                renderAutocomplete(suggestions);
            });
        }

        function setupKeyboardShortcuts() {
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    cancelCurrentOperation();
                }
                if (e.key === 'F2') {
                    e.preventDefault();
                    switchTab('movimentacao');
                    barcodeInput.focus();
                    barcodeInput.select();
                }
                if (e.key === 'F4' && !stateNotFound.classList.contains('hidden')) {
                    e.preventDefault();
                    openCadastroForm();
                }
                if (e.key === 'F9') {
                    if (activeTab === 'movimentacao' && !stateProductFound.classList.contains('hidden')) {
                        e.preventDefault();
                        executeMovement();
                    } else if (activeTab === 'ajuste') {
                        e.preventDefault();
                        document.querySelector('#tab-ajuste form').requestSubmit();
                    }
                }
                if (e.key === 'F10' && !stateCadastroForm.classList.contains('hidden')) {
                    e.preventDefault();
                    document.getElementById('newProductForm').requestSubmit();
                }
            });
        }

        function setReaderSourceUI(source) {
            const modScan = document.getElementById('modeScanner');
            const modManual = document.getElementById('modeManual');
            const auditSource = document.getElementById('auditSource');
            
            if (source === 'SCANNER') {
                modScan.className = "flex items-center justify-center gap-2 rounded-lg border-2 border-emerald-500/50 bg-emerald-950/20 text-emerald-400 font-medium text-xs transition-all duration-200";
                modManual.className = "flex items-center justify-center gap-2 rounded-lg border border-slate-800 bg-slate-900 text-slate-500 font-medium text-xs transition-all duration-200";
                if (auditSource) auditSource.innerText = "SCANNER CORR";
            } else {
                modScan.className = "flex items-center justify-center gap-2 rounded-lg border border-slate-800 bg-slate-900 text-slate-500 font-medium text-xs transition-all duration-200";
                modManual.className = "flex items-center justify-center gap-2 rounded-lg border-2 border-indigo-500/50 bg-indigo-950/20 text-indigo-400 font-medium text-xs transition-all duration-200";
                if (auditSource) auditSource.innerText = "TECLADO MANUAL";
            }
        }

        async function triggerPipelineSearch(code) {
            const cleanCode = String(code).trim();
            if (!cleanCode) return;

            hideAutocomplete();
            resetPipelineStepsUI();

            barcodeInput.disabled = true;
            document.getElementById('barcodeIcon').className = "h-5 w-5 text-indigo-500 animate-spin";

            const result = await ProductPipelineService.identify(cleanCode, updatePipelineStepUI);

            barcodeInput.disabled = false;
            document.getElementById('barcodeIcon').className = "h-5 w-5 text-slate-400";

            if (result.source !== 'NONE' && result.product) {
                if (result.source.includes('API')) {
                    addToast(`Material identificado externamente via ${result.source}!`, 'warning');
                }
                selectProductForOperation(result.product);
            } else {
                showState('NOT_FOUND');
                document.getElementById('missingCodeSpan').innerText = cleanCode;
            }
        }

        function updatePipelineStepUI(step, status) {
            const stepEl = document.getElementById(`step${step.charAt(0).toUpperCase() + step.slice(1).toLowerCase()}`);
            if (!stepEl) return;

            if (status === 'pending') {
                stepEl.className = "px-2 py-1 rounded bg-indigo-500/20 border border-indigo-500/40 text-indigo-400 flex items-center gap-1 animate-pulse";
            } else if (status === 'success') {
                stepEl.className = "px-2 py-1 rounded bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 flex items-center gap-1 font-bold";
            } else if (status === 'fail') {
                stepEl.className = "px-2 py-1 rounded bg-slate-900 border border-slate-800 text-slate-600 flex items-center gap-1";
            } else if (status === 'error') {
                stepEl.className = "px-2 py-1 rounded bg-rose-500/10 border border-rose-500/30 text-rose-400 flex items-center gap-1";
            }
        }

        function resetPipelineStepsUI() {
            ['Local', 'Merchant', 'Brasil', 'Manual'].forEach(step => {
                const el = document.getElementById(`step${step}`);
                if (el) el.className = "px-2 py-1 rounded bg-slate-900 border border-slate-800 text-slate-500 flex items-center gap-1";
            });
        }

        function renderAutocomplete(list) {
            const wrapper = document.getElementById('autocompleteDropdown');
            if (list.length === 0) {
                hideAutocomplete();
                return;
            }

            wrapper.innerHTML = '';
            list.forEach(p => {
                const item = document.createElement('div');
                item.className = "px-4 py-3 hover:bg-indigo-950/40 border-b border-slate-900 text-xs cursor-pointer flex justify-between items-center transition-all";
                item.innerHTML = `
                    <div>
                        <div class="font-bold text-slate-200">${p.nome}</div>
                        <div class="text-[10px] text-slate-400 font-mono">${p.codigo_barras} | PN: ${p.part_number || 'Sem PN'}</div>
                    </div>
                    <span class="text-[10px] bg-slate-900 px-2 py-1 rounded text-emerald-400 font-mono font-bold">${p.estoque_atual} ${p.unidade}</span>
                `;
                item.addEventListener('click', () => {
                    currentReaderSource = 'TECLADO';
                    setReaderSourceUI('TECLADO');
                    selectProductForOperation(p);
                    hideAutocomplete();
                });
                wrapper.appendChild(item);
            });
            wrapper.classList.remove('hidden');
        }

        function hideAutocomplete() {
            document.getElementById('autocompleteDropdown').classList.add('hidden');
        }

        function selectProductForOperation(product) {
            currentActiveProduct = product;
            
            document.getElementById('prodID').innerText = `ID: ${product.id}`;
            document.getElementById('prodName').innerText = product.nome;
            document.getElementById('prodPN').innerText = product.part_number || "N/A";
            document.getElementById('prodBrand').innerText = product.marca;
            document.getElementById('prodStock').innerText = product.estoque_atual;
            document.getElementById('prodUnit').innerText = product.unidade;
            document.getElementById('prodCategory').innerText = product.categoria;
            
            const catBadge = document.getElementById('prodCategory');
            if (product.categoria === 'Elétrica') catBadge.className = "text-[10px] font-bold tracking-wider text-amber-400 bg-amber-500/10 border border-amber-500/20 px-2 py-0.5 rounded uppercase";
            else if (product.categoria === 'Mecânica') catBadge.className = "text-[10px] font-bold tracking-wider text-indigo-400 bg-indigo-500/10 border border-indigo-500/20 px-2 py-0.5 rounded uppercase";
            else catBadge.className = "text-[10px] font-bold tracking-wider text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2 py-0.5 rounded uppercase";

            const imgEl = document.getElementById('prodImage');
            const fallbackEl = document.getElementById('prodFallbackIcon');
            if (product.imagem) {
                imgEl.src = product.imagem;
                imgEl.classList.remove('hidden');
                fallbackEl.classList.add('hidden');
            } else {
                imgEl.classList.add('hidden');
                fallbackEl.classList.remove('hidden');
            }

            document.getElementById('quantityInput').value = 1;
            document.getElementById('obsInput').value = '';
            setMovementType('ENTRADA');

            const auditTimeEl = document.getElementById('auditTime');
            if (auditTimeEl) auditTimeEl.innerText = new Date().toLocaleTimeString('pt-BR');

            showState('PRODUCT_FOUND');
            
            setTimeout(() => {
                document.getElementById('quantityInput').focus();
                document.getElementById('quantityInput').select();
            }, 50);
        }

        function setMovementType(type) {
            currentMovementType = type;
            const btnEntrada = document.getElementById('btnTypeEntrada');
            const btnSaida = document.getElementById('btnTypeSaida');
            const btnConfirmar = document.getElementById('btnConfirmarMovimentacao');
            const containerSetor = document.getElementById('setorContainer');

            if (!btnEntrada || !btnSaida) return;

            if (type === 'ENTRADA') {
                btnEntrada.className = "py-3 px-4 rounded-lg font-bold text-sm border-2 transition-all flex items-center justify-center gap-2 bg-emerald-950/20 border-emerald-500 text-emerald-400 shadow-lg shadow-emerald-500/5";
                btnSaida.className = "py-3 px-4 rounded-lg font-bold text-sm border border-slate-800 bg-slate-900 text-slate-500 hover:border-rose-500/30 hover:text-rose-400";
                btnConfirmar.className = "px-8 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm shadow-lg shadow-emerald-600/20 flex items-center gap-2 transition-all";
                containerSetor.classList.add('hidden');
            } else {
                btnEntrada.className = "py-3 px-4 rounded-lg font-bold text-sm border border-slate-800 bg-slate-900 text-slate-500 hover:border-emerald-500/30 hover:text-emerald-400";
                btnSaida.className = "py-3 px-4 rounded-lg font-bold text-sm border-2 transition-all flex items-center justify-center gap-2 bg-rose-950/20 border-rose-500 text-rose-400 shadow-lg shadow-rose-500/5";
                btnConfirmar.className = "px-8 py-2.5 rounded-lg bg-rose-600 hover:bg-rose-500 text-white font-bold text-sm shadow-lg shadow-rose-600/20 flex items-center gap-2 transition-all";
                containerSetor.classList.remove('hidden');
            }
        }

        function executeMovement() {
            if (!currentActiveProduct) return;

            const qty = parseFloat(document.getElementById('quantityInput').value);
            const obs = document.getElementById('obsInput').value;
            const sectorId = document.getElementById('setorInput').value;

            try {
                StockMovementService.process(
                    currentActiveProduct.id,
                    currentMovementType,
                    qty,
                    obs,
                    currentReaderSource,
                    sectorId
                );

                addToast(`Sucesso! Lançamento de ${currentMovementType} concluído com sucesso.`, 'success');
                cancelCurrentOperation();
            } catch (error) {
                addToast(error.message, 'error');
            }
        }

        function executeInventoryAdjustment(e) {
            e.preventDefault();
            const productId = document.getElementById('adjProductSelect').value;
            const newQty = parseFloat(document.getElementById('adjNewQty').value);
            const reason = document.getElementById('adjReason').value;

            if (!productId) {
                addToast("Selecione um produto para ajustar.", "error");
                return;
            }

            try {
                StockMovementService.process(
                    productId,
                    'AJUSTE',
                    newQty,
                    reason,
                    'DIGITACAO',
                    null
                );

                addToast("Ajuste físico de inventário gravado com sucesso!", "success");
                
                // Limpa campos de ajuste
                document.getElementById('adjProductSelect').value = '';
                document.getElementById('adjNewQty').value = '';
                document.getElementById('adjReason').value = '';
                document.getElementById('adjCurrentStockVal').innerText = '0';

                refreshUI();
            } catch (error) {
                addToast(error.message, "error");
            }
        }

        function cancelCurrentOperation() {
            currentActiveProduct = null;
            barcodeInput.value = '';
            showState('PLACEHOLDER');
            resetPipelineStepsUI();
            refreshUI();
            
            barcodeInput.focus();
        }

        function openCadastroForm() {
            showState('CADASTRO_FORM');
            document.getElementById('newProdBarcode').value = barcodeInput.value.trim();
            document.getElementById('newProdName').value = '';
            document.getElementById('newProdBrand').value = '';
            document.getElementById('newProdPN').value = '';
            document.getElementById('newProdStock').value = 0;

            setTimeout(() => {
                document.getElementById('newProdName').focus();
            }, 50);
        }

        function saveNewProduct(e) {
            e.preventDefault();

            const newProduct = {
                codigo_barras: document.getElementById('newProdBarcode').value.trim(),
                nome: document.getElementById('newProdName').value.trim(),
                marca: document.getElementById('newProdBrand').value.trim(),
                part_number: document.getElementById('newProdPN').value.trim() || null,
                categoria: document.getElementById('newProdCategory').value,
                unidade: document.getElementById('newProdUnit').value,
                localizacao: document.getElementById('newProdLocation').value.trim() || 'Geral',
                estoque_atual: parseFloat(document.getElementById('newProdStock').value) || 0,
                estoque_minimo: parseFloat(document.getElementById('newProdMinStock').value) || 0,
                estoque_maximo: parseFloat(document.getElementById('newProdMaxStock').value) || 100,
                imagem: ""
            };

            const savedProd = ProductRepository.save(newProduct);

            AuditRepository.log({
                usuario_id: 104,
                ip: "192.168.10.45",
                computador: "MNT-W10-04",
                tipo_operacao: `CADASTRO DE MATERIAL`,
                tabela: "produtos",
                registro_id: savedProd.id,
                campo: "estoque_atual",
                valor_anterior: "0.0",
                valor_novo: String(savedProd.estoque_atual),
                origem: currentReaderSource,
                detalhes: `Material cadastrado via pipeline rápido. Desc: ${savedProd.nome} | Estoque Inicial: ${savedProd.estoque_atual}.`
            });

            addToast("Produto cadastrado com sucesso! Retornando ao fluxo de lançamento.", "success");
            selectProductForOperation(savedProd);
            refreshUI();
        }

        function refreshUI() {
            renderDashboard();
            renderInventoryList();
            renderAuditLogs();
            renderInventoryTable();
            populateAdjustmentDropdown();
        }

        function populateSectorDropdown() {
            const select = document.getElementById('setorInput');
            if (!select) return;
            select.innerHTML = '';
            SECTORES_TABLE.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id;
                opt.innerText = `${s.codigo} - ${s.nome}`;
                select.appendChild(opt);
            });
        }

        function populateAdjustmentDropdown() {
            const select = document.getElementById('adjProductSelect');
            if (!select) return;
            
            const prevVal = select.value;
            select.innerHTML = '<option value="">-- Escolha o Material --</option>';
            localDatabase.produtos.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.innerText = `[${p.codigo_barras}] ${p.nome} (${p.marca})`;
                select.appendChild(opt);
            });
            select.value = prevVal;
        }

        function onAdjustmentProductChange() {
            const productId = document.getElementById('adjProductSelect').value;
            const p = ProductRepository.findById(productId);
            if (p) {
                document.getElementById('adjCurrentStockVal').innerText = p.estoque_atual;
                document.getElementById('adjCurrentUnit').innerText = p.unidade;
                document.getElementById('adjNewQty').value = p.estoque_atual;
            } else {
                document.getElementById('adjCurrentStockVal').innerText = '0';
                document.getElementById('adjNewQty').value = '';
            }
        }

        function renderDashboard() {
            const list = localDatabase.produtos;
            const moves = localDatabase.movimentacoes;

            document.getElementById('dash-total-items').innerText = list.length;
            
            const totalStock = list.reduce((sum, p) => sum + parseFloat(p.estoque_atual), 0);
            document.getElementById('dash-total-stock').innerText = totalStock;

            const lowStockCount = list.filter(p => p.estoque_atual < p.estoque_minimo && p.estoque_atual > 0).length;
            document.getElementById('dash-low-stock').innerText = lowStockCount;

            const zeroStockCount = list.filter(p => p.estoque_atual <= 0).length;
            document.getElementById('dash-zero-stock').innerText = zeroStockCount;

            // Últimas movimentações no Dashboard
            const tbody = document.getElementById('dash-movements-tbody');
            if (tbody) {
                tbody.innerHTML = '';
                const latestMoves = [...moves].sort((a,b) => new Date(b.data_hora) - new Date(a.data_hora)).slice(0, 5);
                
                if (latestMoves.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="7" class="py-4 text-center text-slate-500">Nenhuma movimentação registrada.</td></tr>`;
                    return;
                }

                latestMoves.forEach(m => {
                    const p = ProductRepository.findById(m.produto_id);
                    const isEntrada = m.tipo_movimentacao === 'ENTRADA';
                    const badgeClass = isEntrada ? 'text-emerald-400 bg-emerald-500/10' : (m.tipo_movimentacao === 'SAIDA' ? 'text-rose-400 bg-rose-500/10' : 'text-amber-400 bg-amber-500/10');
                    
                    tbody.innerHTML += `
                        <tr class="hover:bg-slate-900/40">
                            <td class="py-2.5 px-2 text-slate-400">${new Date(m.data_hora).toLocaleDateString('pt-BR')} ${new Date(m.data_hora).toLocaleTimeString('pt-BR')}</td>
                            <td class="py-2.5 px-2"><span class="px-1.5 py-0.5 rounded text-[10px] font-bold ${badgeClass}">${m.tipo_movimentacao}</span></td>
                            <td class="py-2.5 px-2 text-slate-200 font-semibold truncate max-w-xs">${p ? p.nome : 'N/A'}</td>
                            <td class="py-2.5 px-2 text-right font-bold ${isEntrada ? 'text-emerald-400' : 'text-rose-400'}">${isEntrada ? '+' : '-'}${m.quantidade}</td>
                            <td class="py-2.5 px-2 text-right text-slate-500">${m.saldo_anterior}</td>
                            <td class="py-2.5 px-2 text-right text-slate-300">${m.saldo_posterior}</td>
                            <td class="py-2.5 px-2 text-slate-500">${m.origem}</td>
                        </tr>
                    `;
                });
            }
        }

        function renderInventoryList() {
            const listContainer = document.getElementById('stockListContainer');
            const counter = document.getElementById('inventoryCounter');
            if (!listContainer) return;
            
            listContainer.innerHTML = '';
            const list = localDatabase.produtos;
            if (counter) counter.innerText = `${list.length} ${list.length === 1 ? 'item' : 'itens'}`;

            list.forEach(p => {
                const isUnderMin = p.estoque_atual < p.estoque_minimo;
                const card = document.createElement('div');
                card.className = `p-3 rounded-lg border text-xs flex justify-between items-center transition-all cursor-pointer ${isUnderMin ? 'bg-amber-950/20 border-amber-500/40 hover:bg-amber-950/30' : 'bg-slate-900 border-slate-800 hover:bg-slate-850'}`;
                
                card.innerHTML = `
                    <div class="flex-1 min-w-0 pr-2">
                        <div class="font-bold text-slate-100 truncate">${p.nome}</div>
                        <div class="text-[10px] text-slate-400 font-mono truncate">
                            PN: ${p.part_number || 'Sem PN'} <span class="text-slate-700">|</span> Loc: ${p.localizacao}
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="text-xs font-bold code-font ${isUnderMin ? 'text-amber-400' : 'text-indigo-400'}">${p.estoque_atual} ${p.unidade}</span>
                        <span class="text-[9px] text-slate-500 block">Min: ${p.estoque_minimo}</span>
                    </div>
                `;
                
                card.addEventListener('click', () => {
                    switchTab('movimentacao');
                    currentReaderSource = 'TECLADO';
                    setReaderSourceUI('TECLADO');
                    selectProductForOperation(p);
                });

                listContainer.appendChild(card);
            });
        }

        function renderAuditLogs() {
            const container = document.getElementById('auditLogContainer');
            if (!container) return;
            container.innerHTML = '';

            const logs = AuditRepository.getLatestLogs(15);

            if (logs.length === 0) {
                container.innerHTML = `<div class="text-slate-600 text-center py-8">Nenhuma auditoria registrada.</div>`;
                return;
            }

            logs.forEach(log => {
                let badgeColor = "bg-indigo-500/20 text-indigo-400 border border-indigo-500/30";
                if (log.tipo_operacao.includes("ENTRADA")) {
                    badgeColor = "bg-emerald-500/20 text-emerald-400 border border-emerald-500/30";
                } else if (log.tipo_operacao.includes("SAIDA")) {
                    badgeColor = "bg-rose-500/20 text-rose-400 border border-rose-500/30";
                } else if (log.tipo_operacao.includes("AJUSTE")) {
                    badgeColor = "bg-amber-500/20 text-amber-400 border border-amber-500/30";
                } else if (log.tipo_operacao.includes("CADASTRO")) {
                    badgeColor = "bg-indigo-500/20 text-indigo-400 border border-indigo-500/30";
                }

                const logItem = document.createElement('div');
                logItem.className = "p-2.5 rounded bg-slate-900 border border-slate-800/80 hover:border-slate-700/80 transition-all flex flex-col gap-1";
                logItem.innerHTML = `
                    <div class="flex justify-between items-start gap-2">
                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider ${badgeColor}">${log.tipo_operacao}</span>
                        <span class="text-[9px] text-slate-500 font-mono">${new Date(log.data_hora).toLocaleTimeString('pt-BR')}</span>
                    </div>
                    <p class="text-slate-300 text-[10px] font-medium leading-tight">${log.detalhes}</p>
                    <div class="flex justify-between items-center text-[9px] text-slate-500 font-mono border-t border-slate-950 pt-1 mt-0.5">
                        <span>Op: ID ${log.usuario_id} (${log.origem})</span>
                        <span>IP: ${log.ip}</span>
                    </div>
                `;
                container.appendChild(logItem);
            });
        }

        // Tabela completa de Consulta de Estoque com filtros multi-eixo
        function renderInventoryTable() {
            const tbody = document.getElementById('inventory-table-tbody');
            if (!tbody) return;
            tbody.innerHTML = '';

            const list = localDatabase.produtos;

            if (list.length === 0) {
                tbody.innerHTML = `<tr><td colspan="8" class="py-8 text-center text-slate-500">Nenhum material cadastrado na base.</td></tr>`;
                return;
            }

            list.forEach(p => {
                // Cálculo de status visual
                let statusBadge = '🟢 Normal';
                let rowBgClass = 'hover:bg-slate-900/40';
                
                if (parseFloat(p.estoque_atual) <= 0) {
                    statusBadge = '🔴 Zerado';
                    rowBgClass = 'bg-rose-950/10 hover:bg-rose-950/20';
                } else if (parseFloat(p.estoque_atual) < parseFloat(p.estoque_minimo)) {
                    statusBadge = '🟡 Baixo';
                    rowBgClass = 'bg-amber-950/10 hover:bg-amber-950/20';
                } else if (parseFloat(p.estoque_atual) > parseFloat(p.estoque_maximo)) {
                    statusBadge = '🔵 Excesso';
                }

                tbody.innerHTML += `
                    <tr class="${rowBgClass} transition-all">
                        <td class="py-3 px-2 font-mono text-slate-400">
                            ID: ${p.id}<br><span class="text-[10px] text-slate-500">${p.codigo_barras}</span>
                        </td>
                        <td class="py-3 px-2">
                            <span class="font-bold text-slate-200 block text-xs">${p.nome}</span>
                            <span class="text-[10px] text-slate-400 block">Marca: ${p.marca} | PN: ${p.part_number || 'N/A'}</span>
                        </td>
                        <td class="py-3 px-2 text-slate-400 font-semibold">${p.categoria}</td>
                        <td class="py-3 px-2 font-mono text-slate-400">${p.localizacao || 'N/A'}</td>
                        <td class="py-3 px-2 text-right font-bold code-font text-white">${p.estoque_atual} <span class="text-[10px] text-slate-500 font-normal">${p.unidade}</span></td>
                        <td class="py-3 px-2 text-right text-slate-500 font-mono">${p.estoque_minimo} / ${p.estoque_maximo}</td>
                        <td class="py-3 px-2 text-center font-bold text-[11px]">${statusBadge}</td>
                        <td class="py-3 px-2 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <button onclick="openProductModal(${p.id})" title="Ver ficha e auditoria" class="p-1.5 rounded bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 transition-all">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                </button>
                                <button onclick="openAjusteDireto(${p.id})" title="Ajuste de inventário" class="p-1.5 rounded bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/20 transition-all">
                                    <i data-lucide="sliders" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
            lucide.createIcons();
        }

        function filterInventory() {
            const query = document.getElementById('filterSearch').value.toLowerCase().trim();
            const category = document.getElementById('filterCategory').value;
            const status = document.getElementById('filterStatus').value;

            const tbody = document.getElementById('inventory-table-tbody');
            if (!tbody) return;
            tbody.innerHTML = '';

            const filtered = localDatabase.produtos.filter(p => {
                // Filtro de busca livre
                const matchesSearch = !query || 
                    p.nome.toLowerCase().includes(query) ||
                    p.marca.toLowerCase().includes(query) ||
                    p.codigo_barras.includes(query) ||
                    (p.part_number && p.part_number.toLowerCase().includes(query)) ||
                    p.localizacao.toLowerCase().includes(query);

                // Filtro de Categoria
                const matchesCategory = category === 'TODAS' || p.categoria === category;

                // Filtro de Status
                let matchesStatus = true;
                if (status === 'NORMAL') {
                    matchesStatus = p.estoque_atual >= p.estoque_minimo && p.estoque_atual <= p.estoque_maximo && p.estoque_atual > 0;
                } else if (status === 'BAIXO') {
                    matchesStatus = p.estoque_atual < p.estoque_minimo && p.estoque_atual > 0;
                } else if (status === 'ZERADO') {
                    matchesStatus = p.estoque_atual <= 0;
                } else if (status === 'EXCESSO') {
                    matchesStatus = p.estoque_atual > p.estoque_maximo;
                }

                return matchesSearch && matchesCategory && matchesStatus;
            });

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="8" class="py-8 text-center text-slate-500">Nenhum material atende aos filtros aplicados.</td></tr>`;
                return;
            }

            filtered.forEach(p => {
                let statusBadge = '🟢 Normal';
                let rowBgClass = 'hover:bg-slate-900/40';
                
                if (parseFloat(p.estoque_atual) <= 0) {
                    statusBadge = '🔴 Zerado';
                    rowBgClass = 'bg-rose-950/10 hover:bg-rose-950/20';
                } else if (parseFloat(p.estoque_atual) < parseFloat(p.estoque_minimo)) {
                    statusBadge = '🟡 Baixo';
                    rowBgClass = 'bg-amber-950/10 hover:bg-amber-950/20';
                } else if (parseFloat(p.estoque_atual) > parseFloat(p.estoque_maximo)) {
                    statusBadge = '🔵 Excesso';
                }

                tbody.innerHTML += `
                    <tr class="${rowBgClass} transition-all">
                        <td class="py-3 px-2 font-mono text-slate-400">
                            ID: ${p.id}<br><span class="text-[10px] text-slate-500">${p.codigo_barras}</span>
                        </td>
                        <td class="py-3 px-2">
                            <span class="font-bold text-slate-200 block text-xs">${p.nome}</span>
                            <span class="text-[10px] text-slate-400 block">Marca: ${p.marca} | PN: ${p.part_number || 'N/A'}</span>
                        </td>
                        <td class="py-3 px-2 text-slate-400 font-semibold">${p.categoria}</td>
                        <td class="py-3 px-2 font-mono text-slate-400">${p.localizacao || 'N/A'}</td>
                        <td class="py-3 px-2 text-right font-bold code-font text-white">${p.estoque_atual} <span class="text-[10px] text-slate-500 font-normal">${p.unidade}</span></td>
                        <td class="py-3 px-2 text-right text-slate-500 font-mono">${p.estoque_minimo} / ${p.estoque_maximo}</td>
                        <td class="py-3 px-2 text-center font-bold text-[11px]">${statusBadge}</td>
                        <td class="py-3 px-2 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <button onclick="openProductModal(${p.id})" title="Ver ficha e auditoria" class="p-1.5 rounded bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 transition-all">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                </button>
                                <button onclick="openAjusteDireto(${p.id})" title="Ajuste de inventário" class="p-1.5 rounded bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/20 transition-all">
                                    <i data-lucide="sliders" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
            lucide.createIcons();
        }

        // Abre o modal de detalhamento completo
        function openProductModal(productId) {
            const p = ProductRepository.findById(productId);
            if (!p) return;

            document.getElementById('modalProdID').innerText = `ID: ${p.id}`;
            document.getElementById('modalProdName').innerText = p.nome;
            document.getElementById('modalProdBrand').innerText = p.marca;
            document.getElementById('modalProdPN').innerText = p.part_number || 'N/A';
            document.getElementById('modalProdBarcode').innerText = p.codigo_barras;
            document.getElementById('modalProdCategory').innerText = p.categoria;
            document.getElementById('modalProdLocation').innerText = `LOC: ${p.localizacao}`;
            document.getElementById('modalProdStock').innerText = `${p.estoque_atual} ${p.unidade}`;
            document.getElementById('modalProdMin').innerText = `${p.estoque_minimo} ${p.unidade}`;
            document.getElementById('modalProdMax').innerText = `${p.estoque_maximo} ${p.unidade}`;

            // Imagem do modal
            const imgEl = document.getElementById('modalProdImg');
            const fallbackEl = document.getElementById('modalProdFallbackIcon');
            if (p.imagem) {
                imgEl.src = p.imagem;
                imgEl.classList.remove('hidden');
                fallbackEl.classList.add('hidden');
            } else {
                imgEl.classList.add('hidden');
                fallbackEl.classList.remove('hidden');
            }

            // Histórico de Movimentações
            const movesTbody = document.getElementById('modalProdMovementsTbody');
            movesTbody.innerHTML = '';
            const pMoves = MovementRepository.findByProduct(p.id);
            if (pMoves.length === 0) {
                movesTbody.innerHTML = `<tr><td colspan="6" class="p-3 text-center text-slate-600">Nenhum histórico físico localizado.</td></tr>`;
            } else {
                pMoves.forEach(m => {
                    const isEntrada = m.tipo_movimentacao === 'ENTRADA';
                    movesTbody.innerHTML += `
                        <tr class="hover:bg-slate-900/60">
                            <td class="p-2 text-slate-500">${new Date(m.data_hora).toLocaleDateString('pt-BR')} ${new Date(m.data_hora).toLocaleTimeString('pt-BR')}</td>
                            <td class="p-2"><span class="px-1.5 py-0.5 rounded text-[9px] font-bold ${isEntrada ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400'}">${m.tipo_movimentacao}</span></td>
                            <td class="p-2 text-right font-bold ${isEntrada ? 'text-emerald-400' : 'text-rose-400'}">${isEntrada ? '+' : '-'}${m.quantidade}</td>
                            <td class="p-2 text-right text-slate-500">${m.saldo_anterior}</td>
                            <td class="p-2 text-right text-slate-300">${m.saldo_posterior}</td>
                            <td class="p-2 text-slate-400 truncate max-w-xs" title="${m.observacao || ''}">${m.observacao || '-'}</td>
                        </tr>
                    `;
                });
            }

            // Trilha de Auditoria do material
            const auditTbody = document.getElementById('modalProdAuditTbody');
            auditTbody.innerHTML = '';
            const pAudits = AuditRepository.findByProduct(p.id);
            if (pAudits.length === 0) {
                auditTbody.innerHTML = `<tr><td colspan="6" class="p-3 text-center text-slate-600">Nenhuma trilha cadastral encontrada.</td></tr>`;
            } else {
                pAudits.forEach(a => {
                    auditTbody.innerHTML += `
                        <tr class="hover:bg-slate-900/60">
                            <td class="p-2 text-slate-500">${new Date(a.data_hora).toLocaleDateString('pt-BR')} ${new Date(a.data_hora).toLocaleTimeString('pt-BR')}</td>
                            <td class="p-2 text-slate-300">ID ${a.usuario_id}</td>
                            <td class="p-2 text-indigo-400 font-bold">${a.campo}</td>
                            <td class="p-2 text-right text-rose-400">${a.valor_anterior}</td>
                            <td class="p-2 text-right text-emerald-400">${a.valor_novo}</td>
                            <td class="p-2 text-slate-500">${a.computador} (${a.origem})</td>
                        </tr>
                    `;
                });
            }

            document.getElementById('productDetailModal').classList.remove('hidden');
            lucide.createIcons();
        }

        function closeProductModal() {
            document.getElementById('productDetailModal').classList.add('hidden');
        }

        function openAjusteDireto(productId) {
            switchTab('ajuste');
            document.getElementById('adjProductSelect').value = productId;
            onAdjustmentProductChange();
        }

        // Utilitários de Gerenciamento de Estado
        function showState(state) {
            statePlaceholder.classList.add('hidden');
            stateProductFound.classList.add('hidden');
            stateNotFound.classList.add('hidden');
            stateCadastroForm.classList.add('hidden');

            if (state === 'PLACEHOLDER') statePlaceholder.classList.remove('hidden');
            if (state === 'PRODUCT_FOUND') stateProductFound.classList.remove('hidden');
            if (state === 'NOT_FOUND') stateNotFound.classList.remove('hidden');
            if (state === 'CADASTRO_FORM') stateCadastroForm.classList.remove('hidden');
        }

        function addToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            
            let bg = 'bg-slate-950 border-slate-800 text-slate-300';
            let icon = 'info';
            
            if (type === 'success') {
                bg = 'bg-emerald-950/90 border-emerald-500/50 text-emerald-300';
                icon = 'check-circle';
            } else if (type === 'error') {
                bg = 'bg-rose-950/90 border-rose-500/50 text-rose-300';
                icon = 'x-circle';
            } else if (type === 'warning') {
                bg = 'bg-amber-950/90 border-amber-500/50 text-amber-300';
                icon = 'alert-triangle';
            }

            toast.className = `p-4 rounded-xl border flex items-start gap-3 shadow-2xl transition-all duration-300 translate-y-2 opacity-0 ${bg}`;
            toast.innerHTML = `
                <i data-lucide="${icon}" class="w-5 h-5 shrink-0 mt-0.5"></i>
                <div class="flex-1 text-xs font-semibold leading-relaxed">${message}</div>
            `;
            
            container.appendChild(toast);
            lucide.createIcons();

            setTimeout(() => {
                toast.classList.remove('opacity-0', 'translate-y-2');
            }, 10);

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 4000);
        }
    </script>
</body>
</html>