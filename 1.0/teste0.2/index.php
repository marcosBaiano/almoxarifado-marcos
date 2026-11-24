<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almoxarifado de Manutenção - Módulo de Movimentação</title>
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

    <!-- BARRA TOPO / HEADER -->
    <header class="border-b border-slate-800 bg-slate-950 px-6 py-4 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
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
            
            <!-- Indicadores Rápidos -->
            <div class="flex items-center gap-6 text-xs text-slate-300">
                <div class="flex items-center gap-2 bg-slate-900 px-3 py-1.5 rounded-md border border-slate-800">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Pipeline de Identificação: <strong class="text-emerald-400">Ativo</strong></span>
                </div>
                <div class="flex items-center gap-2 bg-slate-900 px-3 py-1.5 rounded-md border border-slate-800">
                    <i data-lucide="user" class="w-3.5 h-3.5 text-indigo-400"></i>
                    <span>Operador: <strong class="text-indigo-300">ENG_SOUZA (ID: 104)</strong></span>
                </div>
                <div class="flex items-center gap-2 bg-slate-900 px-3 py-1.5 rounded-md border border-slate-800">
                    <i data-lucide="monitor" class="w-3.5 h-3.5 text-indigo-400"></i>
                    <span>IP Terminal: <strong class="text-indigo-300">192.168.10.45</strong></span>
                </div>
            </div>
        </div>
    </header>

    <!-- ÁREA PRINCIPAL -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-4 md:p-6 grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- COLUNA ESQUERDA: OPERAÇÃO DE MOVIMENTAÇÃO (8 colunas) -->
        <section class="lg:col-span-8 flex flex-col gap-6">
            
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
                        <!-- Lado Esquerdo do Form: Dados Quantitativos -->
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

                        <!-- Lado Direito do Form: Auditoria e Observações -->
                        <div class="flex flex-col gap-4">
                            <div>
                                <label for="obsInput" class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">Observação / Justificativa</label>
                                <textarea id="obsInput" rows="3" 
                                    class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-indigo-500"
                                    placeholder="Ex: Utilizado na manutenção preventiva da ponte rolante 02..."></textarea>
                            </div>

                            <div class="bg-slate-900/30 p-3 rounded-lg border border-slate-800/80 text-[11px] text-slate-400 flex flex-col gap-1.5">
                                <span class="font-bold text-slate-300">Metadata de Auditoria Instantânea:</span>
                                <div class="grid grid-cols-2 gap-x-4 gap-y-1 font-mono">
                                    <div>Operador: <span class="text-slate-300">ID 104</span></div>
                                    <div>Terminal: <span class="text-slate-300">MNT-W10-04</span></div>
                                    <div>Leitor: <span id="auditSource" class="text-slate-300">TECLADO</span></div>
                                    <div>Timestamp: <span id="auditTime" class="text-slate-300">15/07/2026</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botão de Ação -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-900">
                        <button onclick="cancelCurrentOperation()" class="px-6 py-2.5 rounded-lg text-slate-400 hover:bg-slate-900 text-sm font-semibold transition-all">
                            Cancelar [ESC]
                        </button>
                        <button id="btnConfirmarMovimentacao" onclick="executeMovement()" class="px-8 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm shadow-lg shadow-emerald-600/20 flex items-center gap-2 transition-all">
                            <i data-lucide="check-circle" class="w-4 h-4"></i> Confirmar Lançamento [F9]
                        </button>
                    </div>
                </div>

                <!-- ESTADO 3: Produto Não Encontrado (Pipeline Solicitando Cadastro) -->
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

                <!-- ESTADO 4: Tela de Cadastro Integrado (Retorna Automático) -->
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
                        <!-- Cód Barras Auto preenchido -->
                        <div class="md:col-span-1">
                            <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Código de Barras</label>
                            <input type="text" id="newProdBarcode" required readonly
                                class="w-full bg-slate-900 border border-slate-800 text-amber-400 rounded p-2 font-mono text-xs focus:outline-none cursor-not-allowed">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Descrição Completa *</label>
                            <input type="text" id="newProdName" required placeholder="Ex: Sensor Indutivo M18 NPN NA Sn 8mm"
                                class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2 focus:outline-none focus:border-indigo-500 text-xs">
                        </div>

                        <div>
                            <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Marca *</label>
                            <input type="text" id="newProdBrand" required placeholder="Ex: Balluff, Siemens, Festo"
                                class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2 focus:outline-none focus:border-indigo-500 text-xs">
                        </div>

                        <div>
                            <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Part Number</label>
                            <input type="text" id="newProdPN" placeholder="Ex: BES M18EG-PSC80B-S04K"
                                class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2 focus:outline-none focus:border-indigo-500 text-xs code-font">
                        </div>

                        <div>
                            <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Categoria *</label>
                            <select id="newProdCategory" required class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2 focus:outline-none focus:border-indigo-500 text-xs">
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
                            <select id="newProdUnit" class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2 text-xs focus:outline-none">
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
                                class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2 focus:outline-none focus:border-indigo-500 text-xs code-font">
                        </div>

                        <div>
                            <label class="block text-slate-400 font-medium mb-1 uppercase tracking-wider">Estoque Mínimo</label>
                            <input type="number" id="newProdMinStock" min="0" value="5"
                                class="w-full bg-slate-900 border border-slate-700 text-white rounded p-2 focus:outline-none focus:border-indigo-500 text-xs code-font">
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
        </section>

        <!-- COLUNA DIREITA: CONSULTAS, LOGS, AUDITORIA (4 colunas) -->
        <section class="lg:col-span-4 flex flex-col gap-6">
            
            <!-- CENTRAL DE NOTIFICAÇÃO DO LOG/AUDITORIA DE SESSÃO -->
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 shadow-lg flex flex-col h-[320px]">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-sm font-semibold tracking-wider text-slate-300 uppercase flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                        Trilha de Auditoria Real-time
                    </h2>
                    <span class="text-[9px] bg-emerald-500/10 text-emerald-400 px-2 py-0.5 rounded border border-emerald-500/20 font-bold uppercase">
                        Não Excluível
                    </span>
                </div>
                
                <!-- Container de Logs -->
                <div id="auditLogContainer" class="flex-1 overflow-y-auto pr-1 flex flex-col gap-2.5 text-[11px] code-font">
                    <!-- Logs populados via JS -->
                </div>
            </div>

            <!-- TABELA COMPACTA DE PRODUTOS NO ESTOQUE (MOCK BANCO LOCAL) -->
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 shadow-lg flex flex-col h-[340px]">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-sm font-semibold tracking-wider text-slate-300 uppercase flex items-center gap-2">
                        <i data-lucide="archive" class="w-4 h-4 text-indigo-400"></i>
                        Inventário Local (Produtos)
                    </h2>
                    <span id="inventoryCounter" class="text-xs bg-slate-900 border border-slate-800 text-slate-300 px-2 py-0.5 rounded font-bold">5 itens</span>
                </div>

                <!-- Lista de Produtos -->
                <div class="flex-1 overflow-y-auto pr-1 flex flex-col gap-2" id="stockListContainer">
                    <!-- Itens inseridos dinamicamente -->
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
                <span class="text-slate-400">Padrão de Arquitetura: Clean-ERP v4.1</span>
            </div>
        </div>
    </footer>

    <!-- NOTIFICAÇÕES TOAST INTEGRADA (Evita alerts e confirmações intrusivas) -->
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

        // Seed inicial da tabela 'produtos' e 'produto_codigos'
        const INITIAL_PRODUCTS_SEED = [
            {
                id: 101,
                codigo_barras: "7891000123456",
                nome: "Sensor Indutivo BES M18",
                marca: "Balluff",
                part_number: "BES001A",
                categoria: "Elétrica",
                unidade: "UN",
                estoque_atual: 15.0,
                estoque_minimo: 4.0,
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
                estoque_atual: 8.0,
                estoque_minimo: 10.0, // Indicará estoque baixo
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
                estoque_atual: 4.0,
                estoque_minimo: 2.0,
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
                estoque_atual: 25.0,
                estoque_minimo: 8.0,
                imagem: ""
            }
        ];

        // Memória do Banco de Dados Virtual (Simulação Real de Storage)
        let localDatabase = {
            produtos: [],
            movimentacoes: [],
            auditoria: []
        };

        // Restaurar ou carregar do LocalStorage do navegador para persistência de teste
        function initLocalDatabase(forceReset = false) {
            if (forceReset || !localStorage.getItem('ALMOXARIFADO_DB')) {
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
                        data_hora: "2026-07-15T10:00:00",
                        origem: "SCANNER",
                        observacao: "Entrada inicial de saldo de lote recebido do fornecedor"
                    }
                ];
                localDatabase.auditoria = [
                    {
                        id: 1,
                        usuario_id: 104,
                        ip: "192.168.10.45",
                        computador: "MNT-W10-04",
                        tipo_operacao: "ENTRADA DE MATERIAL",
                        produto_id: 101,
                        detalhes: "Lançamento inicial de 5 UN do Sensor Indutivo BES M18",
                        data_hora: "2026-07-15T10:00:00",
                        origem: "SCANNER"
                    }
                ];
                saveToLocalStorage();
                addToast("Base de dados resetada com dados de Seed com sucesso!", "success");
            } else {
                localDatabase = JSON.parse(localStorage.getItem('ALMOXARIFADO_DB'));
            }
        }

        function saveToLocalStorage() {
            localStorage.setItem('ALMOXARIFADO_DB', JSON.stringify(localDatabase));
        }

        function mockRestoreSeed() {
            initLocalDatabase(true);
            refreshUI();
        }

        // ==========================================
        // 2. CAMADA REPOSITORY PATTERN (Banco de Dados)
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
                    // Update
                    const index = localDatabase.produtos.findIndex(p => p.id === product.id);
                    if (index !== -1) {
                        localDatabase.produtos[index] = product;
                        saveToLocalStorage();
                        return product;
                    }
                } else {
                    // Insert (Auto-Increment ID simulation)
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

            static getLatestLogs(limit = 15) {
                // Ordenação decrescente por ID
                return [...localDatabase.auditoria]
                    .sort((a, b) => b.id - a.id)
                    .slice(0, limit);
            }
        }

        // ==========================================
        // 3. APIS DE CONSULTA EXTERNA (INTERFACE / PROVIMENTOS)
        // ==========================================
        
        // Simulando a Interface de Consulta Externa (ProdutoLookupProvider)
        // No PHP seria: interface ProdutoLookupProvider { public function lookup(string $barcode): ?ProductModel; }
        class GoogleMerchantProvider {
            static providerName = "Google Merchant API";
            static async lookup(barcode) {
                // Simulação de chamada externa com delay
                await new Promise(resolve => setTimeout(resolve, 500));
                
                // Exemplo de produto simulado que existiria apenas no Google Merchant
                if (barcode === "7891000111222") {
                    return {
                        codigo_barras: "7891000111222",
                        nome: "Motor Trifásico IP55 Weg 2CV",
                        marca: "WEG",
                        part_number: "W22-0.55-4",
                        categoria: "Mecânica",
                        unidade: "UN",
                        estoque_atual: 0,
                        estoque_minimo: 2,
                        imagem: "https://images.unsplash.com/photo-1590986424791-2355385d0442?auto=format&fit=crop&q=80&w=200"
                    };
                }
                return null;
            }
        }

        class BrasilApiProvider {
            static providerName = "BrasilAPI Material Lookup";
            static async lookup(barcode) {
                await new Promise(resolve => setTimeout(resolve, 600));
                
                if (barcode === "7891000333444") {
                    return {
                        codigo_barras: "7891000333444",
                        nome: "Cabo Flexível de Cobre Heptaflex 10mm²",
                        marca: "Prysmian",
                        part_number: "PRY-HEP-10",
                        categoria: "Elétrica",
                        unidade: "MT",
                        estoque_atual: 0,
                        estoque_minimo: 50,
                        imagem: ""
                    };
                }
                return null;
            }
        }

        // ==========================================
        // 4. CAMADA DE NEGÓCIO - SERVICES (PRODUTO & ESTOQUE)
        // ==========================================
        class ProductPipelineService {
            static async identify(code, updateUIPipelineStatus = () => {}) {
                // Fluxo 1: Banco de Dados Local
                updateUIPipelineStatus('LOCAL', 'pending');
                let product = ProductRepository.findByBarcode(code);
                if (!product) {
                    // Tenta busca interna por ID
                    product = ProductRepository.findById(code);
                }

                if (product) {
                    updateUIPipelineStatus('LOCAL', 'success');
                    return { source: 'LOCAL', product };
                }
                updateUIPipelineStatus('LOCAL', 'fail');

                // Fluxo 2: Google Merchant Provider (Consulta Externa 1)
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

                // Fluxo 3: BrasilAPI Provider (Consulta Externa 2)
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

                // Fluxo 4: Não Encontrado -> Solicitar Cadastro Manual
                updateUIPipelineStatus('MANUAL', 'pending');
                return { source: 'NONE', product: null };
            }
        }

        class StockMovementService {
            static process(productId, type, qty, obs, source, sectorId = null) {
                // Validações Básicas
                if (qty <= 0) {
                    throw new Error("A quantidade de movimentação deve ser maior que zero.");
                }

                const product = ProductRepository.findById(productId);
                if (!product) {
                    throw new Error("Produto não localizado para alteração de estoque.");
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
                        throw new Error("O setor de destino é obrigatório para saídas de materiais.");
                    }
                    posteriorStock = previousStock - parseFloat(qty);
                } else {
                    throw new Error("Tipo de movimentação inválida.");
                }

                // Iniciar transação (Simulada pela consistência atômica da gravação)
                product.estoque_atual = posteriorStock;
                ProductRepository.save(product);

                // Gravar Movimentação
                const movement = MovementRepository.insert({
                    produto_id: product.id,
                    tipo_movimentacao: type,
                    quantidade: parseFloat(qty),
                    saldo_anterior: previousStock,
                    saldo_posterior: posteriorStock,
                    usuario_id: 104, // Simulação de usuário autenticado
                    origem: source,
                    observacao: obs,
                    setor_id: type === 'SAIDA' ? sectorId : null
                });

                // Gravar Auditoria
                let detailsStr = `Lançamento de ${qty} ${product.unidade} de ${type}. Anterior: ${previousStock} | Novo: ${posteriorStock}.`;
                if (type === 'SAIDA') {
                    const sectorObj = SECTORES_TABLE.find(s => s.id === parseInt(sectorId));
                    detailsStr += ` Destino: ${sectorObj ? sectorObj.nome : 'N/A'}`;
                }
                
                AuditRepository.log({
                    usuario_id: 104,
                    ip: "192.168.10.45",
                    computador: "MNT-W10-04",
                    tipo_operacao: `${type} DE MATERIAL`,
                    produto_id: product.id,
                    detalhes: detailsStr,
                    origem: source
                });

                return movement;
            }
        }


        // ==========================================
        // 5. CAMADA DE APRESENTAÇÃO & UX CONTROLLER (HTML + JS ES6)
        // ==========================================
        
        // Estado de UI de Sessão Ativo
        let currentActiveProduct = null;
        let currentMovementType = 'ENTRADA'; // ENTRADA ou SAIDA
        let currentReaderSource = 'TECLADO'; // SCANNER ou TECLADO
        let barcodeInputTimer = null;        // Detectador de velocidade de leitura (Scanner USB)

        // Elementos DOM Principais
        const barcodeInput = document.getElementById('barcodeInput');
        const statePlaceholder = document.getElementById('statePlaceholder');
        const stateProductFound = document.getElementById('stateProductFound');
        const stateNotFound = document.getElementById('stateNotFound');
        const stateCadastroForm = document.getElementById('stateCadastroForm');
        
        // Inicialização Geral da Aplicação
        window.addEventListener('DOMContentLoaded', () => {
            initLocalDatabase();
            lucide.createIcons();
            populateSectorDropdown();
            refreshUI();
            
            // Foco inicial no código de barras para digitação/leitura sem mouse
            barcodeInput.focus();

            // Configuração dos Eventos do Teclado no Input de Código (Pipeline Inteligente)
            setupBarcodeReaderListeners();
            setupKeyboardShortcuts();
        });

        // Configuração inteligente de detecção do método de entrada (Scanner vs Digitação)
        function setupBarcodeReaderListeners() {
            let keyTimes = [];
            
            barcodeInput.addEventListener('keydown', (e) => {
                keyTimes.push(performance.now());
                
                // Se a tecla for ENTER, dispara a busca imediatamente
                if (e.key === 'Enter') {
                    e.preventDefault();
                    
                    // Se o intervalo médio entre as teclas for menor que 30ms, é um Scanner Físico
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
                    keyTimes = []; // Limpa tempos
                }
            });

            // Autocomplete para busca rápida enquanto digita devagar
            barcodeInput.addEventListener('input', () => {
                const query = barcodeInput.value;
                if (query.length < 2) {
                    hideAutocomplete();
                    return;
                }

                // Busca Local rápida para preencher Autocomplete
                const suggestions = ProductRepository.findByFreeSearch(query);
                renderAutocomplete(suggestions);
            });
        }

        // Atalhos de Produtividade Industriais
        function setupKeyboardShortcuts() {
            document.addEventListener('keydown', (e) => {
                // ESC cancela e reseta foco
                if (e.key === 'Escape') {
                    cancelCurrentOperation();
                }
                // F2 força o foco no campo de código de barras
                if (e.key === 'F2') {
                    e.preventDefault();
                    barcodeInput.focus();
                    barcodeInput.select();
                }
                // F4 aciona abertura de cadastro se estiver no estado correspondente
                if (e.key === 'F4' && !stateNotFound.classList.contains('hidden')) {
                    e.preventDefault();
                    openCadastroForm();
                }
                // F9 confirma movimentação
                if (e.key === 'F9' && !stateProductFound.classList.contains('hidden')) {
                    e.preventDefault();
                    executeMovement();
                }
                // F10 submete formulário de cadastro de produto
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
                auditSource.innerText = "SCANNER CORR";
            } else {
                modScan.className = "flex items-center justify-center gap-2 rounded-lg border border-slate-800 bg-slate-900 text-slate-500 font-medium text-xs transition-all duration-200";
                modManual.className = "flex items-center justify-center gap-2 rounded-lg border-2 border-indigo-500/50 bg-indigo-950/20 text-indigo-400 font-medium text-xs transition-all duration-200";
                auditSource.innerText = "TECLADO MANUAL";
            }
        }

        // Execução Completa do Pipeline
        async function triggerPipelineSearch(code) {
            const cleanCode = String(code).trim();
            if (!cleanCode) return;

            hideAutocomplete();
            resetPipelineStepsUI();

            // Bloquear input temporariamente
            barcodeInput.disabled = true;
            document.getElementById('barcodeIcon').className = "h-5 w-5 text-indigo-500 animate-spin";

            // Executar o Service Pipeline de forma assíncrona
            const result = await ProductPipelineService.identify(cleanCode, updatePipelineStepUI);

            // Reestabelecer campo
            barcodeInput.disabled = false;
            document.getElementById('barcodeIcon').className = "h-5 w-5 text-slate-400";

            if (result.source !== 'NONE' && result.product) {
                // Encontrado! Se veio de API externa, avisa o usuário
                if (result.source.includes('API')) {
                    addToast(`Material identificado externamente via ${result.source}!`, 'warning');
                }
                selectProductForOperation(result.product);
            } else {
                // Não localizado em nenhuma cadeia de busca do Pipeline
                showState('NOT_FOUND');
                document.getElementById('missingCodeSpan').innerText = cleanCode;
            }
        }

        // Renderizador de Status de Processamento das APIs na tela
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

        // Preenchimento de Opções Autocomplete
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
                        <div class="text-[10px] text-slate-500 font-mono">${p.codigo_barras} | PN: ${p.part_number || 'Sem PN'} | Marca: ${p.marca}</div>
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

        // Fluxo de seleção para Operação Ativa
        function selectProductForOperation(product) {
            currentActiveProduct = product;
            
            // Injeção de Dados do Produto na View de Operação
            document.getElementById('prodID').innerText = `ID: ${product.id}`;
            document.getElementById('prodName').innerText = product.nome;
            document.getElementById('prodPN').innerText = product.part_number || "N/A";
            document.getElementById('prodBrand').innerText = product.marca;
            document.getElementById('prodStock').innerText = product.estoque_atual;
            document.getElementById('prodUnit').innerText = product.unidade;
            document.getElementById('prodCategory').innerText = product.categoria;
            
            // Categoria cor badge
            const catBadge = document.getElementById('prodCategory');
            if (product.categoria === 'Elétrica') catBadge.className = "text-[10px] font-bold tracking-wider text-amber-400 bg-amber-500/10 border border-amber-500/20 px-2 py-0.5 rounded uppercase";
            else if (product.categoria === 'Mecânica') catBadge.className = "text-[10px] font-bold tracking-wider text-indigo-400 bg-indigo-500/10 border border-indigo-500/20 px-2 py-0.5 rounded uppercase";
            else catBadge.className = "text-[10px] font-bold tracking-wider text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2 py-0.5 rounded uppercase";

            // Imagem do Material
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

            // Reset do Form de Lançamento
            document.getElementById('quantityInput').value = 1;
            document.getElementById('obsInput').value = '';
            setMovementType('ENTRADA'); // default ao selecionar novo

            // Metadata Instantânea
            document.getElementById('auditTime').innerText = new Date().toLocaleTimeString('pt-BR');

            showState('PRODUCT_FOUND');
            
            // UX Industrial: Foco automático imediato no campo de quantidade para poupar mouse!
            setTimeout(() => {
                document.getElementById('quantityInput').focus();
                document.getElementById('quantityInput').select();
            }, 50);
        }

        // Define se é Entrada ou Saída com alteração visual
        function setMovementType(type) {
            currentMovementType = type;
            const btnEntrada = document.getElementById('btnTypeEntrada');
            const btnSaida = document.getElementById('btnTypeSaida');
            const btnConfirmar = document.getElementById('btnConfirmarMovimentacao');
            const containerSetor = document.getElementById('setorContainer');

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

        // Executar e registrar a movimentação usando os Services
        function executeMovement() {
            if (!currentActiveProduct) return;

            const qty = parseFloat(document.getElementById('quantityInput').value);
            const obs = document.getElementById('obsInput').value;
            const sectorId = document.getElementById('setorInput').value;

            try {
                // Processamento de Regra de Negócio via Service
                StockMovementService.process(
                    currentActiveProduct.id,
                    currentMovementType,
                    qty,
                    obs,
                    currentReaderSource,
                    sectorId
                );

                addToast(`Sucesso! Lançamento de ${currentMovementType} gravado com sucesso.`, 'success');
                
                // Reset Completo da Interface mantendo agilidade máxima
                cancelCurrentOperation();

            } catch (error) {
                // Erros de Validação (Como saldo insuficiente, etc)
                addToast(error.message, 'error');
            }
        }

        // Trata cancelamento ou reset de fluxos
        function cancelCurrentOperation() {
            currentActiveProduct = null;
            barcodeInput.value = '';
            showState('PLACEHOLDER');
            resetPipelineStepsUI();
            refreshUI();
            
            // Auto-Focus imediato para reinicio de leitura instantânea
            barcodeInput.focus();
        }

        // Fluxo de Cadastro Integrado de Material
        function openCadastroForm() {
            showState('CADASTRO_FORM');
            
            // Auto-preenche o campo de código de barras lido no scanner para manter integridade
            document.getElementById('newProdBarcode').value = barcodeInput.value.trim();
            document.getElementById('newProdName').value = '';
            document.getElementById('newProdBrand').value = '';
            document.getElementById('newProdPN').value = '';
            document.getElementById('newProdStock').value = 0;

            setTimeout(() => {
                document.getElementById('newProdName').focus();
            }, 50);
        }

        // Gravar e continuar automaticamente no fluxo de entrada de estoque
        function saveNewProduct(e) {
            e.preventDefault();

            const newProduct = {
                codigo_barras: document.getElementById('newProdBarcode').value.trim(),
                nome: document.getElementById('newProdName').value.trim(),
                marca: document.getElementById('newProdBrand').value.trim(),
                part_number: document.getElementById('newProdPN').value.trim() || null,
                categoria: document.getElementById('newProdCategory').value,
                unidade: document.getElementById('newProdUnit').value,
                estoque_atual: parseFloat(document.getElementById('newProdStock').value) || 0,
                estoque_minimo: parseFloat(document.getElementById('newProdMinStock').value) || 0,
                imagem: ""
            };

            // Salvar no Banco via Camada de Repository
            const savedProd = ProductRepository.save(newProduct);

            // Logar Auditoria de criação
            AuditRepository.log({
                usuario_id: 104,
                ip: "192.168.10.45",
                computador: "MNT-W10-04",
                tipo_operacao: `CADASTRO DE MATERIAL`,
                produto_id: savedProd.id,
                detalhes: `Material cadastrado via pipeline rápido. Desc: ${savedProd.nome} | PN: ${savedProd.part_number}. Estoque Inicial: ${savedProd.estoque_atual}.`,
                origem: currentReaderSource
            });

            addToast("Produto cadastrado com sucesso! Retornando ao fluxo de lançamento.", "success");

            // UX Exclusivo: Retorna ao fluxo original de forma imperceptível, já com o material selecionado!
            selectProductForOperation(savedProd);
            refreshUI();
        }

        // Atualização Geral da Interface
        function refreshUI() {
            renderInventoryList();
            renderAuditLogs();
        }

        function populateSectorDropdown() {
            const select = document.getElementById('setorInput');
            select.innerHTML = '';
            SECTORES_TABLE.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id;
                opt.innerText = `${s.codigo} - ${s.nome}`;
                select.appendChild(opt);
            });
        }

        // Lista de Inventário Compacto (Painel de Monitoramento da Direita)
        function renderInventoryList() {
            const listContainer = document.getElementById('stockListContainer');
            const counter = document.getElementById('inventoryCounter');
            
            listContainer.innerHTML = '';
            
            const list = localDatabase.produtos;
            counter.innerText = `${list.length} ${list.length === 1 ? 'item' : 'itens'}`;

            list.forEach(p => {
                const isUnderMin = p.estoque_atual < p.estoque_minimo;
                const card = document.createElement('div');
                card.className = `p-3 rounded-lg border text-xs flex justify-between items-center transition-all cursor-pointer ${isUnderMin ? 'bg-amber-950/20 border-amber-500/40 hover:bg-amber-950/30' : 'bg-slate-900 border-slate-800 hover:bg-slate-850'}`;
                
                card.innerHTML = `
                    <div class="flex-1 min-w-0 pr-2">
                        <div class="font-bold text-slate-100 truncate">${p.nome}</div>
                        <div class="text-[10px] text-slate-400 font-mono truncate">
                            PN: ${p.part_number || 'Sem PN'} <span class="text-slate-700">|</span> ${p.marca}
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="text-xs font-bold code-font ${isUnderMin ? 'text-amber-400' : 'text-indigo-400'}">${p.estoque_atual} ${p.unidade}</span>
                        <span class="text-[9px] text-slate-500 block">Min: ${p.estoque_minimo}</span>
                    </div>
                `;
                
                // Se o operador clicar no produto da lista, puxa direto no fluxo
                card.addEventListener('click', () => {
                    currentReaderSource = 'TECLADO';
                    setReaderSourceUI('TECLADO');
                    selectProductForOperation(p);
                });

                listContainer.appendChild(card);
            });
        }

        // Renderizador de Auditoria Real-Time
        function renderAuditLogs() {
            const container = document.getElementById('auditLogContainer');
            container.innerHTML = '';

            const logs = AuditRepository.getLatestLogs(20);

            if (logs.length === 0) {
                container.innerHTML = `<div class="text-slate-600 text-center py-8">Nenhuma auditoria registrada.</div>`;
                return;
            }

            logs.forEach(log => {
                const p = ProductRepository.findById(log.produto_id);
                const pName = p ? p.nome : 'Material';
                
                let badgeColor = "bg-indigo-500/20 text-indigo-400 border border-indigo-500/30";
                if (log.tipo_operacao.includes("ENTRADA")) {
                    badgeColor = "bg-emerald-500/20 text-emerald-400 border border-emerald-500/30";
                } else if (log.tipo_operacao.includes("SAIDA")) {
                    badgeColor = "bg-rose-500/20 text-rose-400 border border-rose-500/30";
                } else if (log.tipo_operacao.includes("CADASTRO")) {
                    badgeColor = "bg-amber-500/20 text-amber-400 border border-amber-500/30";
                }

                const logItem = document.createElement('div');
                logItem.className = "p-2.5 rounded bg-slate-900 border border-slate-800/80 hover:border-slate-700/80 transition-all flex flex-col gap-1";
                logItem.innerHTML = `
                    <div class="flex justify-between items-start gap-2">
                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider ${badgeColor}">${log.tipo_operacao}</span>
                        <span class="text-[9px] text-slate-500 font-mono">${new Date(log.data_hora).toLocaleTimeString('pt-BR')}</span>
                    </div>
                    <p class="text-slate-300 text-[10.5px] font-medium leading-tight">${log.detalhes}</p>
                    <div class="flex justify-between items-center text-[9px] text-slate-500 font-mono border-t border-slate-950 pt-1 mt-0.5">
                        <span>Op: ID ${log.usuario_id} (${log.origem})</span>
                        <span>IP: ${log.ip}</span>
                    </div>
                `;
                container.appendChild(logItem);
            });
        }

        // Utilitários de Gerenciamento de Estado de Tela
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

        // Sistema de Feedback Toast (Não Interruptivo)
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

            // Anima entrada
            setTimeout(() => {
                toast.classList.remove('opacity-0', 'translate-y-2');
            }, 10);

            // Auto-destruição após 4 segundos
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