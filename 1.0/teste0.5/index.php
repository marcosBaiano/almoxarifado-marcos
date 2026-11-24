<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP SIGA-MNT - Almoxarifado de Manutenção Industrial</title>
    <!-- Tailwind CSS para Design Premium de Painel Industrial -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons para representação fidedigna -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        .code-font {
            font-family: 'JetBrains Mono', monospace;
        }
        /* Rolagem suave de tabelas industriais */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0f172a;
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
<body class="bg-[#030712] text-slate-100 min-h-screen flex flex-col overflow-x-hidden">

    <!-- CABEÇALHO DO ERP -->
    <header class="border-b border-slate-800 bg-slate-950 px-6 py-4 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-600 p-2.5 rounded-lg text-white shadow-lg shadow-indigo-500/20">
                    <i data-lucide="factory" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold tracking-tight text-white flex items-center gap-2">
                        SIGA-MNT <span class="text-xs bg-indigo-500/20 text-indigo-400 font-medium px-2 py-0.5 rounded-full border border-indigo-500/30">ERP Almoxarifado</span>
                    </h1>
                    <p class="text-xs text-slate-400">Controle Operacional de Materiais, Rastreabilidade e Logística</p>
                </div>
            </div>
            
            <!-- Indicadores e Autenticação Fictícia -->
            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-300">
                <div class="flex items-center gap-2 bg-slate-900 px-3 py-1.5 rounded-md border border-slate-800">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Pipeline Lookup: <strong class="text-emerald-400">Ativo (v2.3)</strong></span>
                </div>
                <div class="flex items-center gap-2 bg-slate-900 px-3 py-1.5 rounded-md border border-slate-800">
                    <i data-lucide="user" class="w-3.5 h-3.5 text-indigo-400"></i>
                    <span>Operador: <strong class="text-indigo-300">ENG_SOUZA (ID: 104)</strong></span>
                </div>
                <div class="flex items-center gap-2 bg-slate-900 px-3 py-1.5 rounded-md border border-slate-800">
                    <i data-lucide="shield" class="w-3.5 h-3.5 text-amber-400"></i>
                    <span>Perfil: <strong class="text-amber-400">ADMIN / PCM</strong></span>
                </div>
            </div>
        </div>
    </header>

    <!-- NAVEGAÇÃO PRINCIPAL (MÓDULOS) -->
    <nav class="bg-slate-900/80 border-b border-slate-800 px-6 py-2 sticky top-[73px] z-40 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex flex-wrap gap-1.5">
            <button onclick="switchTab('dashboard')" id="tabBtn-dashboard" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all bg-indigo-600 text-white shadow-lg shadow-indigo-500/10">
                <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i> Dashboard
            </button>
            <button onclick="switchTab('recebimento')" id="tabBtn-recebimento" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800">
                <i data-lucide="log-in" class="w-3.5 h-3.5"></i> Recebimento (Sessões)
            </button>
            <button onclick="switchTab('saida')" id="tabBtn-saida" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800">
                <i data-lucide="log-out" class="w-3.5 h-3.5"></i> Saída de Material (Scanner)
            </button>
            <button onclick="switchTab('solicitacao')" id="tabBtn-solicitacao" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800">
                <i data-lucide="clipboard-list" class="w-3.5 h-3.5"></i> Solicitações & Entrega
                <span id="badge-pedidos-pendentes" class="bg-amber-500/20 text-amber-400 border border-amber-500/30 text-[10px] px-1.5 rounded-full font-bold">1</span>
            </button>
            <button onclick="switchTab('consulta')" id="tabBtn-consulta" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800">
                <i data-lucide="search" class="w-3.5 h-3.5"></i> Consulta & Ajustes
            </button>
            <button onclick="switchTab('importador')" id="tabBtn-importador" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800">
                <i data-lucide="upload" class="w-3.5 h-3.5"></i> Importador Planilha
            </button>
            <button onclick="switchTab('engenharia')" id="tabBtn-engenharia" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all text-amber-400 hover:bg-amber-500/10 border border-amber-500/20">
                <i data-lucide="book-open" class="w-3.5 h-3.5"></i> Especificações de Engenharia & MER
            </button>
        </div>
    </nav>

    <!-- CONTAINER PRINCIPAL -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-4 md:p-6">

        <!-- ========================================== -->
        <!-- MÓDULO 1: DASHBOARD INDUSTRIAL -->
        <!-- ========================================== -->
        <section id="tab-dashboard" class="tab-content flex flex-col gap-6">
            <!-- Grid de Indicadores Principais -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Materiais Catalogados</span>
                        <span id="dash-total-materials" class="text-2xl font-black text-white code-font">4</span>
                        <span class="text-[10px] text-indigo-400 block mt-1">Sincronizados localmente</span>
                    </div>
                    <div class="bg-indigo-500/10 p-2.5 rounded-lg text-indigo-400 border border-indigo-500/20">
                        <i data-lucide="package" class="w-5.5 h-5.5"></i>
                    </div>
                </div>
                <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Unidades em Estoque Físico</span>
                        <span id="dash-stock-sum" class="text-2xl font-black text-emerald-400 code-font">52.0</span>
                        <span class="text-[10px] text-slate-400 block mt-1">Saldo integrado atualizado</span>
                    </div>
                    <div class="bg-emerald-500/10 p-2.5 rounded-lg text-emerald-400 border border-emerald-500/20">
                        <i data-lucide="boxes" class="w-5.5 h-5.5"></i>
                    </div>
                </div>
                <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Estoque Abaixo do Mínimo</span>
                        <span id="dash-low-stock" class="text-2xl font-black text-amber-500 code-font">1</span>
                        <span class="text-[10px] text-amber-400 block mt-1">Requer requisição de compra</span>
                    </div>
                    <div class="bg-amber-500/10 p-2.5 rounded-lg text-amber-500 border border-amber-500/20">
                        <i data-lucide="alert-triangle" class="w-5.5 h-5.5"></i>
                    </div>
                </div>
                <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Solicitações Pendentes</span>
                        <span id="dash-pending-requests" class="text-2xl font-black text-sky-400 code-font">1</span>
                        <span class="text-[10px] text-sky-400 block mt-1">Aguardando separação / entrega</span>
                    </div>
                    <div class="bg-sky-500/10 p-2.5 rounded-lg text-sky-400 border border-sky-500/20">
                        <i data-lucide="truck" class="w-5.5 h-5.5"></i>
                    </div>
                </div>
            </div>

            <!-- Grids de Acompanhamento em Tempo Real -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Esquerda: Auditoria Unificada de Movimentações -->
                <div class="lg:col-span-8 bg-slate-950 border border-slate-800 p-6 rounded-xl flex flex-col gap-4">
                    <div class="flex justify-between items-center border-b border-slate-900 pb-3">
                        <h3 class="text-xs font-bold tracking-wider text-slate-300 uppercase flex items-center gap-2">
                            <i data-lucide="history" class="w-4 h-4 text-indigo-400"></i>
                            Histórico Consolidado de Movimentações (Rastreável)
                        </h3>
                        <span class="text-[10px] text-slate-500 code-font">Últimos Lançamentos</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="border-b border-slate-900 text-slate-400">
                                    <th class="py-2.5 px-2">Data/Hora</th>
                                    <th class="py-2.5 px-2">Tipo</th>
                                    <th class="py-2.5 px-2">Item</th>
                                    <th class="py-2.5 px-2 text-right">Qtd</th>
                                    <th class="py-2.5 px-2 text-right">Anterior</th>
                                    <th class="py-2.5 px-2 text-right">Posterior</th>
                                    <th class="py-2.5 px-2">Operador</th>
                                </tr>
                            </thead>
                            <tbody id="dash-movements-tbody" class="divide-y divide-slate-900 code-font">
                                <!-- Lançado dinamicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Direita: Auditoria de Segurança e Log de Acessos -->
                <div class="lg:col-span-4 bg-slate-950 border border-slate-800 p-6 rounded-xl flex flex-col gap-4">
                    <div class="border-b border-slate-900 pb-3">
                        <h3 class="text-xs font-bold tracking-wider text-slate-300 uppercase flex items-center gap-2">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                            Trilha de Auditoria Passiva
                        </h3>
                    </div>
                    <div id="dash-audit-container" class="flex-1 overflow-y-auto max-h-[300px] flex flex-col gap-3 text-[10px] code-font">
                        <!--Logs dinâmicos -->
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- MÓDULO 2: RECEBIMENTO POR SESSÕES (STAGING) -->
        <!-- ========================================== -->
        <section id="tab-recebimento" class="tab-content hidden flex flex-col gap-6">
            <!-- Aviso técnico sobre o Scanner -->
            <div class="bg-indigo-950/20 border border-indigo-500/20 rounded-xl p-4 text-xs text-indigo-300 flex items-center gap-3">
                <i data-lucide="info" class="w-5 h-5 text-indigo-400 shrink-0"></i>
                <p>
                    <strong>Leitor Inteligente Ativo:</strong> Graças ao nosso algoritmo de telemetria de digitação rápida, você pode bipar o código de barras com o scanner **a qualquer momento nesta aba**, mesmo se não tiver clicado no campo de texto abaixo! O sistema foca e processa a leitura de forma automática.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Coluna Esquerda: Controle de Sessão e Pipeline de Bipe -->
                <div class="lg:col-span-7 flex flex-col gap-6">
                    <!-- Configurações e Abertura de Sessão de Recebimento -->
                    <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-500"></div>
                        <div class="flex justify-between items-center mb-4 border-b border-slate-900 pb-2">
                            <h3 class="text-xs font-bold uppercase text-slate-300 flex items-center gap-2">
                                <i data-lucide="layers" class="w-4 h-4 text-indigo-400"></i>
                                Sessão Ativa de Recebimento
                            </h3>
                            <span id="session-badge-status" class="bg-rose-500/20 text-rose-400 border border-rose-500/30 text-[9px] font-bold px-2.5 py-0.5 rounded">
                                Sessão Fechada
                            </span>
                        </div>

                        <!-- Estado 1: Sem Sessão Ativa -->
                        <div id="recv-no-session-pane" class="py-6 text-center">
                            <p class="text-xs text-slate-400 mb-4">Abra uma nova sessão de recebimento para iniciar a leitura consecutiva de mercadorias sem impactar imediatamente o saldo ativo de estoque (Área de Staging).</p>
                            <button onclick="startNewReceivingSession()" class="mx-auto px-6 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs flex items-center gap-2 shadow-lg shadow-indigo-600/20 transition-all">
                                <i data-lucide="plus-circle" class="w-4 h-4"></i> Iniciar Nova Sessão de Recebimento
                            </button>
                        </div>

                        <!-- Estado 2: Sessão Ativa Aberta -->
                        <div id="recv-active-session-pane" class="hidden flex flex-col gap-4">
                            <div class="grid grid-cols-2 gap-4 bg-slate-900/50 p-3 rounded-lg border border-slate-800/60 text-xs text-slate-400">
                                <div>ID Sessão: <strong id="recv-session-id" class="text-slate-200 code-font">RECV-2026-001</strong></div>
                                <div>Abertura: <strong id="recv-session-time" class="text-slate-200">15/07/2026</strong></div>
                            </div>

                            <div class="relative">
                                <label for="recvBarcodeInput" class="block text-xs font-medium text-slate-400 mb-1">Escanear Código de Barras / Digitação Rápida</label>
                                <div class="relative">
                                    <input type="text" id="recvBarcodeInput" 
                                        class="w-full bg-slate-900 border-2 border-slate-700 rounded-lg pl-10 pr-4 py-2.5 text-white placeholder-slate-500 font-mono text-sm focus:outline-none focus:border-indigo-500 transition-all"
                                        placeholder="Bipe o código de barras ou digite..." autocomplete="off">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="barcode" class="h-4 w-4 text-slate-400"></i>
                                    </div>
                                </div>
                                <div id="recvAutocomplete" class="hidden absolute left-0 right-0 mt-1 bg-slate-950 border border-slate-800 rounded-lg shadow-2xl z-50 max-h-48 overflow-y-auto"></div>
                            </div>

                            <div class="flex items-center justify-between text-[11px] text-slate-400 border-t border-slate-900 pt-3">
                                <span>Simulação de leitura (clique rápido):</span>
                                <div class="flex flex-wrap gap-1.5">
                                    <button onclick="simulateBipe('7891000123456')" class="bg-slate-900 hover:bg-slate-800 border border-slate-800 text-[10px] px-2 py-1 rounded text-slate-300 font-mono">Bipar Sensor</button>
                                    <button onclick="simulateBipe('7891000789012')" class="bg-slate-900 hover:bg-slate-800 border border-slate-800 text-[10px] px-2 py-1 rounded text-slate-300 font-mono">Bipar Rolamento</button>
                                    <button onclick="simulateBipe('7891000333444')" class="bg-slate-900 hover:bg-slate-800 border border-slate-800 text-[10px] px-2 py-1 rounded text-slate-300 font-mono">Bipar Cabo (API)</button>
                                    <button onclick="simulateBipe('999999')" class="bg-slate-900 hover:bg-slate-850 border border-slate-850 text-[10px] px-2 py-1 rounded text-amber-400 font-mono">Bipar Novo</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulário de Cadastro Rápido de Material (Retorna à Sessão de forma Atômica) -->
                    <div id="recv-cadastro-rapido-container" class="hidden bg-slate-950 border border-slate-800 p-5 rounded-xl flex flex-col gap-4">
                        <div class="flex justify-between items-center border-b border-slate-900 pb-2">
                            <h4 class="text-xs font-bold text-amber-400 uppercase flex items-center gap-2">
                                <i data-lucide="plus-square" class="w-4 h-4"></i>
                                Cadastro de Material Não Identificado
                            </h4>
                            <span class="text-[9px] bg-amber-500/10 text-amber-400 border border-amber-500/30 px-1.5 py-0.5 rounded font-bold">Auto-Retorno Ativo</span>
                        </div>
                        <form id="recv-rapido-form" onsubmit="saveFastProduct(event)" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                            <div>
                                <label class="block text-slate-400 mb-1">Código de Barras</label>
                                <input type="text" id="rf-barcode" readonly class="w-full bg-slate-900 border border-slate-800 text-amber-400 font-mono p-2 rounded cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-slate-400 mb-1">Descrição Completa *</label>
                                <input type="text" id="rf-name" required placeholder="Ex: Sensor Magnético" class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-slate-400 mb-1">Marca *</label>
                                <input type="text" id="rf-brand" required class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded">
                            </div>
                            <div>
                                <label class="block text-slate-400 mb-1">Categoria *</label>
                                <select id="rf-category" required class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded">
                                    <option value="Elétrica">Elétrica</option>
                                    <option value="Mecânica">Mecânica</option>
                                    <option value="Pneumática">Pneumática</option>
                                    <option value="Hidráulica">Hidráulica</option>
                                    <option value="Ferramentas">Ferramentas</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 flex justify-end gap-2 pt-2 border-t border-slate-900">
                                <button type="button" onclick="cancelFastCadastro()" class="px-4 py-2 rounded text-slate-400 hover:bg-slate-900">Voltar à Sessão</button>
                                <button type="submit" class="px-5 py-2 rounded bg-emerald-600 hover:bg-emerald-500 text-white font-bold">Salvar e Registrar na Lista</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Coluna Direita: Lista de Staging (Conferência de Lote) -->
                <div class="lg:col-span-5 bg-slate-950 border border-slate-800 p-5 rounded-xl flex flex-col h-[520px]">
                    <div class="flex justify-between items-center border-b border-slate-900 pb-3 mb-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300 flex items-center gap-2">
                            <i data-lucide="list-checks" class="w-4 h-4 text-emerald-400"></i>
                            Lista de Staging (Lista de Conferência)
                        </h3>
                        <span id="staging-counter" class="text-xs bg-slate-900 border border-slate-800 text-slate-300 px-2 py-0.5 rounded font-bold">0 itens</span>
                    </div>

                    <!-- Área de Staging de Linhas -->
                    <div id="staging-container" class="flex-1 overflow-y-auto flex flex-col gap-2.5 text-xs">
                        <div class="text-slate-600 text-center py-16 flex flex-col items-center gap-2">
                            <i data-lucide="package" class="w-10 h-10 text-slate-700"></i>
                            <span>Nenhum material adicionado a esta sessão.</span>
                        </div>
                    </div>

                    <!-- Fechamento / Commit da Sessão de Recebimento -->
                    <div id="recv-actions-container" class="hidden border-t border-slate-900 pt-4 mt-3 flex justify-between gap-3">
                        <button onclick="discardReceivingSession()" class="px-4 py-2.5 rounded-lg border border-slate-800 hover:bg-slate-900 text-slate-400 font-bold text-xs transition-all">
                            Descartar Sessão
                        </button>
                        <button onclick="commitReceivingSession()" class="px-6 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center gap-2 shadow-lg shadow-emerald-600/20 transition-all">
                            <i data-lucide="shield-check" class="w-4 h-4"></i> Confirmar e Atualizar Estoque (Commit)
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- MÓDULO 3: SAÍDA DIRETA DE MATERIAIS (SCANNER) -->
        <!-- ========================================== -->
        <section id="tab-saida" class="tab-content hidden flex flex-col gap-6">
            <!-- Alerta operacional de balcão -->
            <div class="bg-rose-950/20 border border-rose-500/20 rounded-xl p-4 text-xs text-rose-300 flex items-center gap-3">
                <i data-lucide="scan-barcode" class="w-5 h-5 text-rose-400 shrink-0"></i>
                <p>
                    <strong>Módulo de Saída Direta de Peça:</strong> Destinado ao despacho ágil de balcão sem solicitação prévia. Identifique o item pelo scanner, insira a quantidade e o setor requisitante. O estoque será deduzido em tempo real com auditoria ativa.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Painel de Busca e Identificação -->
                <div class="lg:col-span-8 flex flex-col gap-6">
                    <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 shadow-lg relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-rose-500"></div>
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-sm font-semibold tracking-wider text-slate-300 uppercase flex items-center gap-2">
                                <i data-lucide="scan" class="w-4 h-4 text-rose-400"></i>
                                Identificação no Balcão de Saída
                            </h2>
                            <span class="text-[10px] bg-slate-800 text-slate-400 px-2.5 py-1 rounded-md border border-slate-700">
                                Atalho: [F2] Foco Campo Código
                            </span>
                        </div>

                        <div class="relative">
                            <label for="saidaBarcodeInput" class="block text-xs font-medium text-slate-400 mb-1.5">
                                Escaneie o Código de Barras do Material ou Digite Detalhes
                            </label>
                            <div class="relative">
                                <input type="text" id="saidaBarcodeInput" 
                                    class="w-full bg-slate-900 border-2 border-slate-700 rounded-lg pl-10 pr-4 py-3 text-white placeholder-slate-500 font-mono text-base focus:outline-none focus:border-rose-500 transition-all shadow-inner"
                                    placeholder="Aponte o leitor de código de barras..." autocomplete="off">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="barcode" class="h-5 w-5 text-slate-400" id="saidaBarcodeIcon"></i>
                                </div>
                            </div>
                            
                            <!-- Autocomplete dropdown da saída -->
                            <div id="saidaAutocompleteDropdown" class="hidden absolute left-0 right-0 mt-1 bg-slate-950 border border-slate-800 rounded-lg shadow-2xl z-50 max-h-60 overflow-y-auto"></div>
                        </div>
                    </div>

                    <!-- Card Dinâmico de Transação de Saída -->
                    <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 shadow-lg flex-1 flex flex-col justify-between min-h-[340px]">
                        
                        <!-- ESTADO 1: Aguardando Bipe -->
                        <div id="saidaStatePlaceholder" class="flex-1 flex flex-col items-center justify-center text-center p-8">
                            <div class="w-16 h-16 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center mb-4 text-slate-500">
                                <i data-lucide="search" class="w-8 h-8"></i>
                            </div>
                            <h3 class="text-base font-semibold text-slate-300">Aguardando Leitura de Saída</h3>
                            <p class="text-xs text-slate-500 max-w-sm mt-1">
                                Escaneie uma etiqueta de código de barras ou digite o código do material de reposição para registrar a retirada rápida de estoque.
                            </p>
                        </div>

                        <!-- ESTADO 2: Material Identificado para Despacho -->
                        <div id="saidaStateProductFound" class="hidden flex-1 flex flex-col gap-6">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-slate-900/50 p-4 rounded-lg border border-slate-800">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-slate-800 rounded-lg flex items-center justify-center border border-slate-700 text-slate-400 overflow-hidden relative">
                                        <i data-lucide="box" class="w-8 h-8 text-slate-500"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span id="saidaProdCategory" class="text-[10px] font-bold tracking-wider text-indigo-400 bg-indigo-500/10 border border-indigo-500/20 px-2 py-0.5 rounded uppercase">Elétrica</span>
                                            <span id="saidaProdID" class="text-[10px] font-mono text-slate-400 bg-slate-850 px-2 py-0.5 rounded">ID: 000</span>
                                        </div>
                                        <h3 id="saidaProdName" class="text-base font-bold text-white mt-1">Nome do Item Selecionado</h3>
                                        <p class="text-xs text-slate-400 flex items-center gap-2 mt-0.5">
                                            <span>Part Number: <strong class="text-slate-200 code-font" id="saidaProdPN">N/A</strong></span>
                                            <span class="text-slate-600">|</span>
                                            <span>Marca: <strong class="text-slate-200" id="saidaProdBrand">N/A</strong></span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Saldo Disponível -->
                                <div class="bg-slate-900 px-4 py-3 rounded-lg border border-slate-700 min-w-[120px] text-center">
                                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Saldo em Estoque</span>
                                    <span id="saidaProdStock" class="text-2xl font-black text-rose-400 code-font">0</span>
                                    <span id="saidaProdUnit" class="text-xs text-slate-400 block -mt-1">UN</span>
                                </div>
                            </div>

                            <!-- Formulário de Baixa de Balcão -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <label for="saidaQuantityInput" class="block text-slate-400 font-bold mb-1.5 uppercase tracking-wider">Quantidade a Retirar *</label>
                                        <input type="number" id="saidaQuantityInput" min="0.1" step="any" required
                                            class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-lg font-bold text-white code-font focus:outline-none focus:border-rose-500 text-center" 
                                            value="1">
                                    </div>
                                    <div>
                                        <label for="saidaSetorInput" class="block text-slate-400 font-bold mb-1.5 uppercase tracking-wider">Setor Destinatário *</label>
                                        <select id="saidaSetorInput" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-3 text-sm font-semibold text-white focus:outline-none focus:border-rose-500">
                                            <!-- Preenchido via JS -->
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-4">
                                    <div>
                                        <label for="saidaObsInput" class="block text-slate-400 font-bold mb-1.5 uppercase tracking-wider">Observação / Ordem de Serviço / Justificativa</label>
                                        <textarea id="saidaObsInput" rows="3" 
                                            class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-slate-200 placeholder-slate-600 focus:outline-none focus:border-rose-500 text-xs"
                                            placeholder="Ex: Empregado na troca de cabos da prensa Hidráulica 05..."></textarea>
                                    </div>

                                    <div class="bg-slate-900/30 p-2.5 rounded-lg border border-slate-800/85 text-[10px] text-slate-400 flex flex-col gap-1 font-mono">
                                        <span class="font-bold text-slate-300">Auditoria Direta de Saída:</span>
                                        <div>Operador: <span class="text-slate-300">ID 104 - ENG_SOUZA</span></div>
                                        <div>Terminal: <span class="text-slate-300">MNT-W10-04</span></div>
                                        <div>IP Address: <span class="text-slate-300">192.168.10.45</span></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botões de Transação -->
                            <div class="flex justify-end gap-3 pt-4 border-t border-slate-900">
                                <button onclick="cancelSaidaDirect()" class="px-6 py-2.5 rounded-lg text-slate-400 hover:bg-slate-900 text-xs font-bold transition-all">
                                    Cancelar [ESC]
                                </button>
                                <button id="btnConfirmarSaidaDirect" onclick="executeSaidaDirect()" class="px-8 py-2.5 rounded-lg bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs shadow-lg shadow-rose-600/20 flex items-center gap-2 transition-all">
                                    <i data-lucide="check" class="w-4 h-4"></i> Confirmar Baixa [F9]
                                </button>
                            </div>
                        </div>

                        <!-- ESTADO 3: Produto Não Localizado -->
                        <div id="saidaStateNotFound" class="hidden flex-1 flex flex-col items-center justify-center text-center p-6">
                            <div class="w-16 h-16 rounded-full bg-amber-500/10 border border-amber-500/30 flex items-center justify-center mb-4 text-amber-500">
                                <i data-lucide="alert-triangle" class="w-8 h-8"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-200">Material não Localizado na Base</h3>
                            <p class="text-xs text-slate-400 max-w-md mt-1">
                                O código <strong class="text-amber-400 code-font" id="saidaMissingCodeSpan">123456</strong> foi processado, mas nenhum registro de material foi localizado.
                            </p>
                            <button onclick="cancelSaidaDirect()" class="mt-4 px-5 py-2 rounded bg-slate-900 hover:bg-slate-800 text-xs text-slate-300 font-bold border border-slate-800 transition-all">
                                Voltar e Limpar
                            </button>
                        </div>

                    </div>
                </div>

                <!-- Painel Direita: Inventário Rápido de Peças Críticas -->
                <div class="lg:col-span-4 bg-slate-950 border border-slate-800 p-5 rounded-xl flex flex-col h-[520px]">
                    <div class="flex justify-between items-center border-b border-slate-900 pb-3 mb-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300 flex items-center gap-2">
                            <i data-lucide="boxes" class="w-4 h-4 text-rose-400"></i>
                            Controle de Saldo Crítico
                        </h3>
                    </div>
                    <div class="flex-1 overflow-y-auto pr-1 flex flex-col gap-2" id="saidaStockListContainer">
                        <!-- Preenchido via JS -->
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- MÓDULO 4: SOLICITAÇÕES, SEPARAÇÃO & ENTREGA -->
        <!-- ========================================== -->
        <section id="tab-solicitacao" class="tab-content hidden flex flex-col gap-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Coluna Esquerda: Abertura de Nova Solicitação de Peça -->
                <div class="lg:col-span-5 bg-slate-950 border border-slate-800 p-5 rounded-xl flex flex-col gap-4">
                    <div class="border-b border-slate-900 pb-2">
                        <h3 class="text-xs font-bold uppercase text-slate-300 flex items-center gap-2">
                            <i data-lucide="file-text" class="w-4 h-4 text-indigo-400"></i>
                            Nova Solicitação de Material (Balcão)
                        </h3>
                    </div>
                    
                    <form onsubmit="createMaterialRequest(event)" class="flex flex-col gap-3 text-xs">
                        <div>
                            <label class="block text-slate-400 mb-1">Funcionário Solicitante *</label>
                            <input type="text" id="req-solicitante" required placeholder="Ex: Mário Silva (Mecânica)" class="w-full bg-slate-900 border border-slate-700 text-white p-2.5 rounded focus:outline-none focus:border-indigo-500">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-slate-400 mb-1">Setor Destino *</label>
                                <select id="req-setor" required class="w-full bg-slate-900 border border-slate-700 text-white p-2.5 rounded"></select>
                            </div>
                            <div>
                                <label class="block text-slate-400 mb-1">Prioridade</label>
                                <select id="req-prioridade" class="w-full bg-slate-900 border border-slate-700 text-white p-2.5 rounded">
                                    <option value="ALTA">🚨 ALTA (Máquina Parada)</option>
                                    <option value="MEDIA" selected>🟡 MÉDIA (Planejada)</option>
                                    <option value="BAIXA">🟢 BAIXA (Retorno de Lote)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Adicionar item de estoque na solicitação -->
                        <div class="border-t border-slate-900 pt-3 flex flex-col gap-2">
                            <label class="block text-slate-400 font-bold uppercase text-[10px]">Peças Solicitadas</label>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="col-span-2">
                                    <select id="req-item-select" class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded">
                                        <!-- Injetado via JS -->
                                    </select>
                                </div>
                                <div>
                                    <input type="number" id="req-item-qty" min="1" value="1" placeholder="Qtd" class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded code-font text-center">
                                </div>
                            </div>
                            <button type="button" onclick="addItemToRequestList()" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 border border-slate-800 text-[10px] text-slate-300 font-bold rounded flex items-center justify-center gap-1">
                                <i data-lucide="plus" class="w-3.5 h-3.5"></i> Adicionar Item à Lista
                            </button>
                        </div>

                        <!-- Lista temporária de peças adicionadas à solicitação -->
                        <div id="req-added-items-container" class="bg-slate-900/50 p-2.5 rounded-lg border border-slate-850 max-h-24 overflow-y-auto flex flex-col gap-1.5">
                            <div class="text-[10px] text-slate-500 text-center">Nenhum item adicionado à lista de requisição.</div>
                        </div>

                        <div>
                            <label class="block text-slate-400 mb-1">Equipamento / Aplicação (Opcional)</label>
                            <input type="text" id="req-equipamento" placeholder="Ex: Ponte Rolante 02 - Prensa Weg" class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded">
                        </div>
                        <button type="submit" class="mt-2 w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded shadow-lg shadow-indigo-600/15">
                            Registrar Nova Solicitação
                        </button>
                    </form>
                </div>

                <!-- Coluna Direita: Painel de Separação & Entrega (Estações de Balcão) -->
                <div class="lg:col-span-7 bg-slate-950 border border-slate-800 p-5 rounded-xl flex flex-col h-[520px]">
                    <div class="flex justify-between items-center border-b border-slate-900 pb-3 mb-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300 flex items-center gap-2">
                            <i data-lucide="package-check" class="w-4 h-4 text-amber-400"></i>
                            Painel de Separação, Conferência & Entrega
                        </h3>
                    </div>

                    <!-- Fila de Solicitações para Despachar -->
                    <div id="separation-queue-container" class="flex-1 overflow-y-auto flex flex-col gap-3">
                        <!-- Injetado dinamicamente via JS -->
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- MÓDULO 5: CONSULTA GERAL & AJUSTES FISICOS -->
        <!-- ========================================== -->
        <section id="tab-consulta" class="tab-content hidden flex flex-col gap-6">
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 shadow-lg flex flex-col gap-4">
                
                <!-- Barra de Filtros Avançados -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5">Busca Inteligente (Código, Descrição, Localização, Marca, Part Number)</label>
                        <input type="text" id="search-query" oninput="filterInventory()" class="w-full bg-slate-900 border border-slate-800 p-2 rounded text-xs text-white focus:outline-none focus:border-indigo-500" placeholder="Digite para filtrar instantaneamente...">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5">Filtrar por Categoria</label>
                        <select id="search-category" onchange="filterInventory()" class="w-full bg-slate-900 border border-slate-800 p-2 rounded text-xs text-white">
                            <option value="TODAS">-- Todas as Categorias --</option>
                            <option value="Elétrica">Elétrica</option>
                            <option value="Mecânica">Mecânica</option>
                            <option value="Pneumática">Pneumática</option>
                            <option value="Hidráulica">Hidráulica</option>
                            <option value="Ferramentas">Ferramentas</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5">Status Crítico</label>
                        <select id="search-status" onchange="filterInventory()" class="w-full bg-slate-900 border border-slate-800 p-2 rounded text-xs text-white">
                            <option value="TODOS">-- Todos os Status --</option>
                            <option value="NORMAL">🟢 Estoque Normal</option>
                            <option value="BAIXO">🟡 Estoque Baixo</option>
                            <option value="ZERADO">🔴 Estoque Zerado</option>
                        </select>
                    </div>
                </div>

                <!-- Tabela de Inventário Ativo -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-850 text-slate-400">
                                <th class="py-3 px-2">ID / Código Barras</th>
                                <th class="py-3 px-2">Descrição / Detalhes</th>
                                <th class="py-3 px-2">Categoria</th>
                                <th class="py-3 px-2">Localização</th>
                                <th class="py-3 px-2 text-right">Estoque Atual</th>
                                <th class="py-3 px-2 text-right">Estoque Mínimo</th>
                                <th class="py-3 px-2 text-center">Status</th>
                                <th class="py-3 px-2 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="inventory-table-tbody" class="divide-y divide-slate-900">
                            <!-- Injetado dinamicamente -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MODAL DE AJUSTE MANUAL DE INVENTÁRIO (SÓ PERFIS AUTORIZADOS) -->
            <div id="ajusteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
                <div class="bg-slate-900 border border-slate-800 rounded-xl max-w-md w-full overflow-hidden flex flex-col shadow-2xl">
                    <div class="px-6 py-4 border-b border-slate-800 flex justify-between items-center bg-slate-950/50">
                        <h3 class="font-bold text-sm text-white flex items-center gap-2">
                            <i data-lucide="sliders" class="text-amber-500 w-4 h-4"></i>
                            Ajuste Físico de Inventário (Seguro)
                        </h3>
                        <button onclick="closeAjusteModal()" class="text-slate-400 hover:text-white">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                    <form onsubmit="saveAjusteEstoque(event)" class="p-6 flex flex-col gap-4 text-xs">
                        <input type="hidden" id="ajuste-prod-id">
                        <div>
                            <span class="text-slate-400 block font-semibold">Material Selecionado:</span>
                            <span id="ajuste-prod-name" class="font-bold text-white text-sm block mt-1">Nome do item</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-slate-400 mb-1">Saldo Atual</label>
                                <input type="text" id="ajuste-prod-stock-current" readonly class="w-full bg-slate-950 border border-slate-800 p-2 rounded text-slate-400 font-mono focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-slate-400 mb-1">Novo Saldo Real *</label>
                                <input type="number" id="ajuste-prod-stock-new" required min="0" step="any" class="w-full bg-slate-900 border border-slate-700 text-white font-mono p-2 rounded focus:outline-none focus:border-amber-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-slate-400 mb-1">Justificativa / Motivo de Ajuste *</label>
                            <textarea id="ajuste-prod-reason" required rows="3" class="w-full bg-slate-900 border border-slate-700 text-white p-2.5 rounded focus:outline-none focus:border-amber-500" placeholder="Ex: Correção de inventário rotativo ou lote danificado..."></textarea>
                        </div>
                        <div class="flex justify-end gap-2 pt-2 border-t border-slate-800">
                            <button type="button" onclick="closeAjusteModal()" class="px-4 py-2 rounded text-slate-400 hover:bg-slate-950">Cancelar</button>
                            <button type="submit" class="px-5 py-2 rounded bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold">Confirmar Ajuste [F9]</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- MÓDULO 5: IMPORTADOR EXCLUSIVO DA PLANILHA -->
        <!-- ========================================== -->
        <section id="tab-importador" class="tab-content hidden flex flex-col gap-6">
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 shadow-lg max-w-4xl mx-auto w-full relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-indigo-500"></div>
                <div class="flex items-center gap-3 border-b border-slate-900 pb-4 mb-6">
                    <div class="bg-indigo-500/10 p-2.5 rounded text-indigo-400 border border-indigo-500/20">
                        <i data-lucide="upload" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Importador e Migrador de Planilhas</h3>
                        <p class="text-xs text-slate-400">Migre de forma controlada a planilha existente de almoxarifado direto para o banco de dados.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
                    <!-- Painel de Upload Simulador -->
                    <div class="md:col-span-2 border-2 border-dashed border-slate-800 bg-slate-900/30 rounded-xl p-6 flex flex-col items-center justify-center text-center gap-3">
                        <i data-lucide="file-spreadsheet" class="w-12 h-12 text-indigo-400"></i>
                        <h4 class="font-bold text-slate-200">Arraste ou Selecione o Arquivo da Planilha</h4>
                        <p class="text-[11px] text-slate-400 max-w-sm">O sistema valida automaticamente duplicidades de códigos, categorias sem vínculo fiscal e formatação de localização antes da injeção.</p>
                        
                        <div class="flex gap-2">
                            <button onclick="simulateSheetImport('valid')" class="px-4 py-2 rounded bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-[11px] transition-all">
                                Simular Importação Válida
                            </button>
                            <button onclick="simulateSheetImport('invalid')" class="px-4 py-2 rounded bg-rose-950/40 border border-rose-500/30 hover:bg-rose-950/60 text-rose-400 font-bold text-[11px] transition-all">
                                Simular Importação com Inconsistências
                            </button>
                        </div>
                    </div>

                    <!-- Explicação das Restrições e Validação -->
                    <div class="bg-slate-900/40 border border-slate-850 p-5 rounded-xl flex flex-col gap-3">
                        <span class="font-bold text-slate-300 block">Regras de Validação do Importador:</span>
                        <ul class="flex flex-col gap-2 text-[11px] text-slate-400">
                            <li class="flex items-start gap-1.5"><i data-lucide="check-circle" class="w-3.5 h-3.5 text-indigo-400 shrink-0"></i> Código ITEM deve ser único.</li>
                            <li class="flex items-start gap-1.5"><i data-lucide="check-circle" class="w-3.5 h-3.5 text-indigo-400 shrink-0"></i> Categoria deve ser pré-validada na tabela mapeada.</li>
                            <li class="flex items-start gap-1.5"><i data-lucide="check-circle" class="w-3.5 h-3.5 text-indigo-400 shrink-0"></i> Localização deve obedecer à sintaxe [PR-A1 ou AL-C2].</li>
                        </ul>
                    </div>
                </div>

                <!-- Relatório de Validação e Inconsistências (Apenas aparece após simular) -->
                <div id="import-report-pane" class="hidden mt-6 pt-5 border-t border-slate-900 flex flex-col gap-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-300 flex items-center gap-1.5">
                        <i data-lucide="file-warning" class="w-4 h-4 text-amber-500"></i>
                        Relatório Técnico de Inconsistências da Planilha
                    </h4>
                    <div id="import-report-box" class="p-4 rounded-lg text-xs font-mono max-h-40 overflow-y-auto">
                        <!-- Relatório injetado pelo JS -->
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- MÓDULO 6: DOCUMENTAÇÃO DE ENGENHARIA DE SOFTWARE -->
        <!-- ========================================== -->
        <section id="tab-engenharia" class="tab-content hidden flex flex-col gap-6">
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 shadow-lg flex flex-col gap-8">
                
                <div class="flex items-center gap-3 border-b border-slate-900 pb-4">
                    <div class="bg-indigo-600/10 p-2.5 rounded text-indigo-400 border border-indigo-500/20">
                        <i data-lucide="book-open" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-white">Especificação Técnica de Arquitetura & MER</h2>
                        <p class="text-xs text-slate-400">Modelagem do SIGA-MNT desenvolvida para escalabilidade horizontal do ERP.</p>
                    </div>
                </div>

                <!-- ARQUITETURA DE MICROSERVIÇOS / EXPANSÃO -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-slate-900 p-5 rounded-lg border border-slate-850 flex flex-col gap-2">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-indigo-400">1. Requisitos do Sistema</h4>
                        <p class="text-[11px] text-slate-400 leading-relaxed">
                            <strong>Funcionais:</strong> Sessões de staging para bipagem consecutiva, pipeline de busca de fornecedores em multi-nível, requisição de entrega com baixa atômica pós-separação e bloqueio de saldo negativo.<br>
                            <strong>Não Funcionais:</strong> Latência de bipe &lt; 50ms (In-Memory Staging), segurança contra injeção SQL via Prepared Statements nativos (PDO) e integridade referencial estrita contra deleções acidentais (Cascade restrito).
                        </p>
                    </div>
                    <div class="bg-slate-900 p-5 rounded-lg border border-slate-850 flex flex-col gap-2">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-indigo-400">2. Mapa de Expansão de Módulos</h4>
                        <p class="text-[11px] text-slate-400 leading-relaxed">
                            <strong>Módulo Compras:</strong> Acoplado ao gatilho de saldo abaixo do mínimo do almoxarifado via fila de compras automática.<br>
                            <strong>Módulo Patrimônio & Ferramentas:</strong> Estende a tabela de produtos unificada, tipando materiais de consumo rápido vs. ativos de controle de calibração periódica (rastreáveis).
                        </p>
                    </div>
                    <div class="bg-slate-900 p-5 rounded-lg border border-slate-850 flex flex-col gap-2">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-indigo-400">3. Estratégia de Identificação</h4>
                        <p class="text-[11px] text-slate-400 leading-relaxed">
                            <strong>ProdutoLookupProvider:</strong> Mecanismo de resolução estruturado em fila de provedores de API (Google Merchant $\rightarrow$ BrasilAPI $\rightarrow$ Cadastro Manual), isolado do domínio das regras de negócio.
                        </p>
                    </div>
                </div>

                <!-- SCRIPT SQL DE ENGENHARIA -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Modelo Entidade-Relacionamento e Script DDL MySQL (Preparado para Expansão)
                    </h4>
                    <pre class="bg-slate-900 p-4 rounded-lg border border-slate-850 text-slate-300 text-[10.5px] code-font overflow-x-auto select-all max-h-80">
CREATE DATABASE IF NOT EXISTS erp_almoxarifado CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE erp_almoxarifado;

-- 1. TABELA DE PERFIS DE PERMISSÃO
CREATE TABLE permissoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_perfil VARCHAR(50) NOT NULL UNIQUE,
    pode_ajustar TINYINT(1) NOT NULL DEFAULT 0,
    pode_cadastrar TINYINT(1) NOT NULL DEFAULT 1,
    pode_retirar TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- 2. TABELA DE USUÁRIOS DO ERP
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    permissao_id INT NOT NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (permissao_id) REFERENCES permissoes(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 3. TABELA DE CATEGORIAS (Mapeamento das Classes da Planilha de Referência)
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
    marca VARCHAR(100) NOT NULL,
    modelo VARCHAR(100) NULL,
    part_number VARCHAR(100) NULL,
    categoria_id INT NOT NULL,
    unidade VARCHAR(10) NOT NULL DEFAULT 'UN',
    localizacao VARCHAR(50) NULL,
    estoque_atual DECIMAL(12,4) NOT NULL DEFAULT 0.0000,
    estoque_minimo DECIMAL(12,4) NOT NULL DEFAULT 0.0000,
    estoque_maximo DECIMAL(12,4) NOT NULL DEFAULT 100.0000,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_produtos_codbar (codigo_barras),
    INDEX idx_produtos_busca (nome, marca, part_number),
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 6. TABELA DE SOLICITAÇÕES DE MATERIAIS (Mesa de Atendimento)
CREATE TABLE solicitacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_solicitacao VARCHAR(20) NOT NULL UNIQUE,
    solicitante VARCHAR(100) NOT NULL,
    setor_id INT NOT NULL,
    equipamento VARCHAR(150) NULL,
    prioridade ENUM('ALTA', 'MEDIA', 'BAIXA') NOT NULL DEFAULT 'MEDIA',
    status ENUM('PENDENTE', 'SEPARADO', 'ENTREGUE', 'CANCELADO') NOT NULL DEFAULT 'PENDENTE',
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (setor_id) REFERENCES setores(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 7. TABELA DE ITENS DA SOLICITAÇÃO
CREATE TABLE solicitacao_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    solicitacao_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade_solicitada DECIMAL(12,4) NOT NULL,
    quantidade_atendida DECIMAL(12,4) NOT NULL DEFAULT 0.0000,
    FOREIGN KEY (solicitacao_id) REFERENCES solicitacoes(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 8. TABELA ÚNICA DE MOVIMENTAÇÕES DE ESTOQUE
CREATE TABLE movimentacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    tipo_movimentacao ENUM('ENTRADA', 'SAIDA', 'AJUSTE', 'DEVOLUCAO', 'TRANSFERENCIA', 'INVENTARIO') NOT NULL,
    quantidade DECIMAL(12,4) NOT NULL,
    saldo_anterior DECIMAL(12,4) NOT NULL,
    saldo_posterior DECIMAL(12,4) NOT NULL,
    usuario_id INT NOT NULL,
    sessao_recebimento VARCHAR(50) NULL,
    solicitacao_id INT NULL,
    origem ENUM('SCANNER', 'DIGITACAO', 'API') NOT NULL DEFAULT 'DIGITACAO',
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE RESTRICT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE RESTRICT,
    FOREIGN KEY (solicitacao_id) REFERENCES solicitacoes(id) ON DELETE SET NULL,
    INDEX idx_mov_produto (produto_id)
) ENGINE=InnoDB;

-- 9. TABELA DE AUDITORIA DE SISTEMA (Inalterável)
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

                <!-- ESTRUTURA DE DIRETÓRIOS PHP PSR-4 -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                        3. Árvore de Diretórios do Projeto em Produção (Padrão MVC + PSR-4)
                    </h4>
                    <pre class="bg-slate-900 p-4 rounded-lg border border-slate-850 text-slate-300 text-[10.5px] code-font overflow-x-auto">
siga-mnt-erp/
├── config/
│   ├── database.php             # Gerenciamento de conexões PDO e Pooling
│   └── app.php                  # Configurações de chaves e variáveis globais
├── core/
│   ├── Controller.php           # Abstração de controle e injeção de dependências
│   ├── DatabaseConnection.php   # Wrapper do PDO para Prepared Statements e Transactions
│   └── DatabaseLookupProvider.php # Interface para lookup externo
├── src/
│   ├── Models/
│   │   ├── Product.php          # Estrutura atômica do Produto
│   │   ├── Request.php          # Estrutura de Solicitação de Peça
│   │   └── Audit.php            # Modelo de Auditoria
│   ├── Repositories/
│   │   ├── ProductRepository.php  # Operações e filtros SQL de produtos
│   │   ├── RequestRepository.php  # Persistência e controle de fluxo de solicitações
│   │   └── AuditRepository.php    # Injeção passiva de auditoria
│   ├── Services/
│   │   ├── ReceivingStagingService.php # Gerencia sessões de recebimento pendente (Staging)
│   │   ├── StockMovementService.php    # REGRA DE NEGÓCIO: Lançamentos atômicos de movimentações
│   │   └── SheetImporterService.php    # Serviço de parsing e validação de planilhas de terceiros
│   └── Providers/
│       ├── GoogleMerchantProvider.php  # Provedor externo (Google)
│       └── BrasilApiProvider.php       # Provedor nacional de APIs
├── views/
│   ├── dashboard.php            # View com dados tratados via Controller
│   ├── recebimento.php          # Painel de staging
│   ├── entrega.php              # Painel de separação e entrega
│   └── estoque.php              # Painel de consultas de inventário
└── public/
    ├── index.php                # Front Controller (Entrada única)
    └── assets/
        ├── css/                 # CSS utilitário compilado
        └── js/                  # Módulos JS ES6 (Fetch API)</pre>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER DA SESSÃO -->
    <footer class="bg-slate-950 border-t border-slate-800 py-4 px-6 text-center text-xs text-slate-500 mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <p>© 2026 ERP SIGA-MNT - Sistema de Controle Integrado de Peças de Reposição Industrial. Licenciado para PetroIndústria.</p>
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
    <!-- MOTOR EM EMBED (SIMULAÇÃO REALISTA PHP/MYSQL) -->
    <!-- ========================================== -->
    <script>
        // Tabelas de Mock e Dados Iniciais (Sincronizado)
        const SECTORES_TABLE = [
            { id: 1, nome: "Usinagem de Grande Porte", codigo: "USI-GP" },
            { id: 2, nome: "Linha de Montagem Mecânica", codigo: "LMT-MEC" },
            { id: 3, nome: "Subestação Principal Elétrica", codigo: "SUB-ELET" },
            { id: 4, nome: "Utilidades (Caldeiras e Gases)", codigo: "UTI-GASS" },
            { id: 5, nome: "PCM (Planejamento e Controle de Mnt)", codigo: "PCM-GERAL" }
        ];

        const INITIAL_PRODUCTS_SEED = [
            {
                id: 101,
                codigo_interno: "IT-001",
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
                codigo_interno: "IT-002",
                codigo_barras: "7891000789012",
                nome: "Rolamento de Esferas SKF 6204-2Z",
                marca: "SKF",
                part_number: "6204-2Z",
                categoria: "Mecânica",
                unidade: "PC",
                localizacao: "PR-B4",
                estoque_atual: 8.0,
                estoque_minimo: 10.0, // Alerta
                estoque_maximo: 80.0,
                imagem: "https://images.unsplash.com/photo-1617791160536-598cf32026fb?auto=format&fit=crop&q=80&w=200"
            },
            {
                id: 103,
                codigo_interno: "IT-003",
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
                codigo_interno: "IT-004",
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

        // Memória do Banco de Dados Local
        let erpDatabase = {
            produtos: [],
            movimentacoes: [],
            auditoria: [],
            solicitacoes: [],
            sessaoRecebimentoAtiva: null,
            stagingList: []
        };

        // Inicialização da Estrutura de Storage Local
        function initErpDatabase(forceReset = false) {
            if (forceReset || !localStorage.getItem('SIGAMNT_DB_V3')) {
                erpDatabase.produtos = JSON.parse(JSON.stringify(INITIAL_PRODUCTS_SEED));
                erpDatabase.movimentacoes = [
                    {
                        id: 1,
                        produto_id: 101,
                        tipo_movimentacao: "ENTRADA",
                        quantidade: 15.0,
                        saldo_anterior: 0.0,
                        saldo_posterior: 15.0,
                        usuario_id: 104,
                        origem: "DIGITACAO",
                        data_hora: "2026-07-15T08:30:00Z",
                        sessao: null
                    }
                ];
                erpDatabase.auditoria = [
                    {
                        id: 1,
                        usuario_id: 104,
                        ip_address: "192.168.10.45",
                        computador_nome: "MNT-W10-04",
                        tela: "Módulo Recebimento",
                        operacao: "CADASTRO INICIAL",
                        valor_anterior: "NULL",
                        valor_novo: "Produtos semeados no banco local",
                        data_hora: "2026-07-15T08:30:00Z"
                    }
                ];
                erpDatabase.solicitacoes = [
                    {
                        id: 1,
                        numero_solicitacao: "REQ-2026-001",
                        solicitante: "Mário Silva (Mecânica)",
                        setor_id: 2,
                        equipamento: "Ponte Rolante de Carga G1",
                        prioridade: "ALTA",
                        status: "PENDENTE",
                        data_registro: "2026-07-15T15:30:00Z",
                        itens: [
                            { produto_id: 102, quantidade_solicitada: 2.0, quantidade_atendida: 0.0 }
                        ]
                    }
                ];
                erpDatabase.sessaoRecebimentoAtiva = null;
                erpDatabase.stagingList = [];
                saveDatabase();
                addToast("Base de Dados do ERP Re-semeada com Sucesso!", "success");
            } else {
                erpDatabase = JSON.parse(localStorage.getItem('SIGAMNT_DB_V3'));
            }
        }

        function saveDatabase() {
            localStorage.setItem('SIGAMNT_DB_V3', JSON.stringify(erpDatabase));
        }

        function mockRestoreSeed() {
            initErpDatabase(true);
            refreshUI();
        }

        // ==========================================
        // CAMADA DE REPOSITÓRIOS (SQL WRAPPERS)
        // ==========================================
        class ProductRepository {
            static findById(id) {
                return erpDatabase.produtos.find(p => p.id === parseInt(id)) || null;
            }
            static findByBarcode(barcode) {
                return erpDatabase.produtos.find(p => p.codigo_barras === String(barcode).trim()) || null;
            }
            static save(product) {
                if (product.id) {
                    const idx = erpDatabase.produtos.findIndex(p => p.id === product.id);
                    if (idx !== -1) erpDatabase.produtos[idx] = product;
                } else {
                    const maxId = erpDatabase.produtos.reduce((max, p) => p.id > max ? p.id : max, 0);
                    product.id = maxId + 1;
                    product.codigo_interno = `IT-00${product.id}`;
                    erpDatabase.produtos.push(product);
                }
                saveDatabase();
                return product;
            }
        }

        class AuditRepository {
            static log(operation, screen, before, after) {
                const maxId = erpDatabase.auditoria.reduce((max, a) => a.id > max ? a.id : max, 0);
                const item = {
                    id: maxId + 1,
                    usuario_id: 104,
                    ip_address: "192.168.10.45",
                    computador_nome: "MNT-W10-04",
                    tela: screen,
                    operacao: operation,
                    valor_anterior: String(before),
                    valor_novo: String(after),
                    data_hora: new Date().toISOString()
                };
                erpDatabase.auditoria.push(item);
                saveDatabase();
            }
            static getLatestLogs(limit = 10) {
                return [...erpDatabase.auditoria].sort((a,b) => b.id - a.id).slice(0, limit);
            }
        }

        // ==========================================
        // APIS EXTERNAS LOOKUP (INTERFACES / PROVIDERS)
        // ==========================================
        class GoogleMerchantProvider {
            static async lookup(barcode) {
                await new Promise(resolve => setTimeout(resolve, 300));
                if (barcode === "7891000111222") {
                    return {
                        codigo_barras: "7891000111222",
                        nome: "Motor Weg Trifásico IP55 2CV",
                        marca: "WEG",
                        part_number: "W22-2HP",
                        categoria: "Mecânica",
                        unidade: "UN",
                        localizacao: "PR-M2"
                    };
                }
                return null;
            }
        }

        class BrasilApiProvider {
            static async lookup(barcode) {
                await new Promise(resolve => setTimeout(resolve, 400));
                if (barcode === "7891000333444") {
                    return {
                        codigo_barras: "7891000333444",
                        nome: "Cabo Flexível Prysmian 10mm² PT",
                        marca: "Prysmian",
                        part_number: "PRY-HEP-10",
                        categoria: "Elétrica",
                        unidade: "MT",
                        localizacao: "AL-E1"
                    };
                }
                return null;
            }
        }

        // Service Pipeline lookup
        class ProductPipelineService {
            static async identify(barcode, updateUIStatus = () => {}) {
                updateUIStatus('LOCAL', 'pending');
                let product = ProductRepository.findByBarcode(barcode);
                if (product) {
                    updateUIStatus('LOCAL', 'success');
                    return { source: 'LOCAL', product };
                }
                updateUIStatus('LOCAL', 'fail');

                updateUIStatus('MERCHANT', 'pending');
                product = await GoogleMerchantProvider.lookup(barcode);
                if (product) {
                    updateUIStatus('MERCHANT', 'success');
                    return { source: 'MERCHANT_API', product };
                }
                updateUIStatus('MERCHANT', 'fail');

                updateUIStatus('BRASIL', 'pending');
                product = await BrasilApiProvider.lookup(barcode);
                if (product) {
                    updateUIStatus('BRASIL', 'success');
                    return { source: 'BRASIL_API', product };
                }
                updateUIStatus('BRASIL', 'fail');

                updateUIStatus('MANUAL', 'pending');
                return { source: 'NONE', product: null };
            }
        }

        // ==========================================
        // FLUXO DE RECEBIMENTO POR SESSÕES (STAGING)
        // ==========================================
        function startNewReceivingSession() {
            const id = `RECV-2026-00${erpDatabase.movimentacoes.length + 1}`;
            erpDatabase.sessaoRecebimentoAtiva = id;
            erpDatabase.stagingList = [];
            saveDatabase();

            addToast("Sessão de recebimento iniciada!", "success");
            refreshUI();
            
            setTimeout(() => {
                const input = document.getElementById('recvBarcodeInput');
                if (input) input.focus();
            }, 100);
        }

        async function simulateBipe(barcode) {
            if (!erpDatabase.sessaoRecebimentoAtiva) {
                addToast("É necessário abrir uma sessão de recebimento primeiro.", "warning");
                return;
            }

            const loaderStatus = (step, status) => {
                // Emulação silenciosa de interface
            };

            const result = await ProductPipelineService.identify(barcode, loaderStatus);

            if (result.source !== 'NONE' && result.product) {
                addProdToStagingList(result.product, 1);
            } else {
                openFastCadastro(barcode);
            }
        }

        function addProdToStagingList(product, qty) {
            const existing = erpDatabase.stagingList.find(item => item.product.codigo_barras === product.codigo_barras);
            if (existing) {
                existing.quantidade += parseFloat(qty);
            } else {
                erpDatabase.stagingList.push({
                    product: product,
                    quantidade: parseFloat(qty),
                    novo: false
                });
            }
            saveDatabase();
            refreshUI();
            addToast(`Item adicionado: ${product.nome} (Qtd: ${qty})`, "info");
        }

        function openFastCadastro(barcode) {
            document.getElementById('recv-cadastro-rapido-container').classList.remove('hidden');
            document.getElementById('rf-barcode').value = barcode;
            document.getElementById('rf-name').value = '';
            document.getElementById('rf-brand').value = '';
            
            setTimeout(() => {
                document.getElementById('rf-name').focus();
            }, 50);
        }

        function cancelFastCadastro() {
            document.getElementById('recv-cadastro-rapido-container').classList.add('hidden');
            // Retorna o foco para o scanner principal após cancelar
            refocusScannerField();
        }

        function saveFastProduct(e) {
            e.preventDefault();
            const bar = document.getElementById('rf-barcode').value;
            const name = document.getElementById('rf-name').value;
            const brand = document.getElementById('rf-brand').value;
            const cat = document.getElementById('rf-category').value;

            const product = {
                codigo_barras: bar,
                nome: name,
                marca: brand,
                categoria: cat,
                unidade: 'UN',
                estoque_atual: 0.0,
                estoque_minimo: 2.0,
                estoque_maximo: 20.0,
                localizacao: 'STAGING-AL'
            };

            const saved = ProductRepository.save(product);
            addProdToStagingList(saved, 1);
            cancelFastCadastro();
            addToast("Material cadastrado de forma ágil no meio da sessão!", "success");
        }

        // Commit da sessão de recebimento (Efetiva saldo no estoque físico real)
        function commitReceivingSession() {
            if (erpDatabase.stagingList.length === 0) {
                addToast("Área de staging está vazia. Não há itens para dar commit.", "warning");
                return;
            }

            // Inicia transação atômica
            try {
                erpDatabase.stagingList.forEach(item => {
                    const dbProd = ProductRepository.findById(item.product.id) || ProductRepository.findByBarcode(item.product.codigo_barras);
                    if (dbProd) {
                        const previous = parseFloat(dbProd.estoque_atual);
                        const added = parseFloat(item.quantidade);
                        const posterior = previous + added;

                        dbProd.estoque_atual = posterior;
                        ProductRepository.save(dbProd);

                        // Grava movimentação unificada
                        const maxIdMov = erpDatabase.movimentacoes.reduce((max, m) => m.id > max ? m.id : max, 0);
                        erpDatabase.movimentacoes.push({
                            id: maxIdMov + 1,
                            produto_id: dbProd.id,
                            tipo_movimentacao: "ENTRADA",
                            quantidade: added,
                            saldo_anterior: previous,
                            saldo_posterior: posterior,
                            usuario_id: 104,
                            sessao: erpDatabase.sessaoRecebimentoAtiva,
                            origem: "SCANNER",
                            data_hora: new Date().toISOString()
                        });
                    }
                });

                AuditRepository.log(
                    `CONFERENCIA RECEBIMENTO`, 
                    'Recebimento Lotes', 
                    'Staging Pendente', 
                    `Lote confirmado na sessão ${erpDatabase.sessaoRecebimentoAtiva}`
                );

                erpDatabase.sessaoRecebimentoAtiva = null;
                erpDatabase.stagingList = [];
                saveDatabase();
                refreshUI();
                addToast("Lote conferido e integrado ao estoque com sucesso!", "success");

            } catch (err) {
                addToast("Erro crítico na transação de Commit. Rollback executado.", "error");
            }
        }

        function discardReceivingSession() {
            erpDatabase.sessaoRecebimentoAtiva = null;
            erpDatabase.stagingList = [];
            saveDatabase();
            refreshUI();
            addToast("Sessão descartada sem alterações de estoque.", "info");
        }

        // ==========================================
        // MÓDULO 3: SAÍDA DIRETA DE MATERIAIS
        // ==========================================
        let currentSaidaProduct = null;

        async function triggerSaidaPipelineSearch(code) {
            const cleanCode = String(code).trim();
            if (!cleanCode) return;

            document.getElementById('saidaAutocompleteDropdown').classList.add('hidden');
            
            // Simular progresso do pipeline visualmente
            document.getElementById('saidaBarcodeIcon').className = "h-5 w-5 text-rose-500 animate-spin";
            
            // Procura na base local e APIs de simulação
            const result = await ProductPipelineService.identify(cleanCode, () => {});
            
            document.getElementById('saidaBarcodeIcon').className = "h-5 w-5 text-slate-400";

            if (result.product) {
                selectProductForSaida(result.product);
            } else {
                document.getElementById('saidaMissingCodeSpan').innerText = cleanCode;
                showSaidaState('NOT_FOUND');
            }
        }

        function selectProductForSaida(product) {
            currentSaidaProduct = product;
            
            document.getElementById('saidaProdID').innerText = `ID: ${product.id}`;
            document.getElementById('saidaProdName').innerText = product.nome;
            document.getElementById('saidaProdPN').innerText = product.part_number || "N/A";
            document.getElementById('saidaProdBrand').innerText = product.marca;
            document.getElementById('saidaProdStock').innerText = product.estoque_atual;
            document.getElementById('saidaProdUnit').innerText = product.unidade;
            document.getElementById('saidaProdCategory').innerText = product.categoria;

            document.getElementById('saidaQuantityInput').value = 1;
            document.getElementById('saidaObsInput').value = '';

            showSaidaState('PRODUCT_FOUND');

            setTimeout(() => {
                document.getElementById('saidaQuantityInput').focus();
                document.getElementById('saidaQuantityInput').select();
            }, 50);
        }

        function executeSaidaDirect() {
            if (!currentSaidaProduct) return;

            const qty = parseFloat(document.getElementById('saidaQuantityInput').value) || 0;
            const sectorId = document.getElementById('saidaSetorInput').value;
            const obs = document.getElementById('saidaObsInput').value.trim();

            if (qty <= 0) {
                addToast("A quantidade de retirada deve ser maior que zero.", "error");
                return;
            }

            if (!sectorId) {
                addToast("Selecione um setor de destino para a baixa.", "error");
                return;
            }

            const p = ProductRepository.findById(currentSaidaProduct.id);
            if (!p) return;

            const previous = parseFloat(p.estoque_atual);
            if (previous < qty) {
                addToast(`Saldo insuficiente! Estoque atual é de apenas ${previous} ${p.unidade}.`, "error");
                return;
            }

            // Efetua a baixa atômica
            try {
                const posterior = previous - qty;
                p.estoque_atual = posterior;
                ProductRepository.save(p);

                // Grava transação de movimentação
                const maxIdMov = erpDatabase.movimentacoes.reduce((max, m) => m.id > max ? m.id : max, 0);
                erpDatabase.movimentacoes.push({
                    id: maxIdMov + 1,
                    produto_id: p.id,
                    tipo_movimentacao: "SAIDA",
                    quantidade: qty,
                    saldo_anterior: previous,
                    saldo_posterior: posterior,
                    usuario_id: 104,
                    origem: "SCANNER",
                    observacao: `Saída balcão scanner para o setor ID: ${sectorId}. Justificativa: ${obs}`,
                    data_hora: new Date().toISOString()
                });

                // Registrar auditoria
                AuditRepository.log(
                    `SAIDA DIRETA`,
                    'Saída de Material',
                    `${previous} ${p.unidade}`,
                    `${posterior} ${p.unidade} (Despacho Scanner para setor ${sectorId})`
                );

                addToast(`Sucesso! ${qty} ${p.unidade} do material foram retirados do estoque.`, "success");
                cancelSaidaDirect();

            } catch (error) {
                addToast("Erro na gravação atômica da saída.", "error");
            }
        }

        function cancelSaidaDirect() {
            currentSaidaProduct = null;
            document.getElementById('saidaBarcodeInput').value = '';
            showSaidaState('PLACEHOLDER');
            refreshUI();
            
            setTimeout(() => {
                document.getElementById('saidaBarcodeInput').focus();
            }, 50);
        }

        function showSaidaState(state) {
            document.getElementById('saidaStatePlaceholder').classList.add('hidden');
            document.getElementById('saidaStateProductFound').classList.add('hidden');
            document.getElementById('saidaStateNotFound').classList.add('hidden');

            if (state === 'PLACEHOLDER') document.getElementById('saidaStatePlaceholder').classList.remove('hidden');
            if (state === 'PRODUCT_FOUND') document.getElementById('saidaStateProductFound').classList.remove('hidden');
            if (state === 'NOT_FOUND') document.getElementById('saidaStateNotFound').classList.remove('hidden');
        }

        function populateSaidaSectors() {
            const select = document.getElementById('saidaSetorInput');
            if (!select) return;
            select.innerHTML = '<option value="">-- Selecione o Setor Requisitante --</option>';
            SECTORES_TABLE.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id;
                opt.innerText = `${s.codigo} - ${s.nome}`;
                select.appendChild(opt);
            });
        }

        function renderSaidaStockList() {
            const container = document.getElementById('saidaStockListContainer');
            if (!container) return;
            container.innerHTML = '';
            
            erpDatabase.produtos.forEach(p => {
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
                        <span class="text-xs font-bold code-font ${isUnderMin ? 'text-amber-400' : 'text-rose-400'}">${p.estoque_atual} ${p.unidade}</span>
                    </div>
                `;
                
                card.addEventListener('click', () => {
                    selectProductForSaida(p);
                });
                container.appendChild(card);
            });
        }

        // ==========================================
        // SOLICITAÇÃO & PAINEL DE SEPARAÇÃO (ESTAÇÕES)
        // ==========================================
        let tempAddedItems = []; // Itens em rascunho na solicitação de balcão

        function addItemToRequestList() {
            const select = document.getElementById('req-item-select');
            const qtyInput = document.getElementById('req-item-qty');
            const id = select.value;
            const qty = parseFloat(qtyInput.value) || 1;

            if (!id) return;
            const p = ProductRepository.findById(id);
            if (!p) return;

            const existing = tempAddedItems.find(item => item.product_id === p.id);
            if (existing) {
                existing.quantidade_solicitada += qty;
            } else {
                tempAddedItems.push({
                    product_id: p.id,
                    nome: p.nome,
                    quantidade_solicitada: qty
                });
            }

            renderTempRequestItems();
        }

        function renderTempRequestItems() {
            const container = document.getElementById('req-added-items-container');
            container.innerHTML = '';
            if (tempAddedItems.length === 0) {
                container.innerHTML = `<div class="text-[10px] text-slate-500 text-center">Nenhum item adicionado à lista.</div>`;
                return;
            }
            tempAddedItems.forEach((item, idx) => {
                container.innerHTML += `
                    <div class="flex justify-between items-center bg-slate-900 px-2 py-1 rounded border border-slate-800 text-[11px]">
                        <span>${item.nome}</span>
                        <div class="flex items-center gap-2 font-mono font-bold">
                            <span class="text-indigo-400">${item.quantidade_solicitada} UN</span>
                            <button type="button" onclick="removeTempItem(${idx})" class="text-rose-400 hover:text-rose-300"><i data-lucide="trash" class="w-3.5 h-3.5"></i></button>
                        </div>
                    </div>
                `;
            });
            lucide.createIcons();
        }

        function removeTempItem(idx) {
            tempAddedItems.splice(idx, 1);
            renderTempRequestItems();
        }

        function createMaterialRequest(e) {
            e.preventDefault();
            if (tempAddedItems.length === 0) {
                addToast("É necessário adicionar pelo menos um material à requisição.", "warning");
                return;
            }

            const solicitante = document.getElementById('req-solicitante').value;
            const setorId = document.getElementById('req-setor').value;
            const prioridade = document.getElementById('req-prioridade').value;
            const equip = document.getElementById('req-equipamento').value;

            const maxId = erpDatabase.solicitacoes.reduce((max, s) => s.id > max ? s.id : max, 0);
            const num = `REQ-2026-00${maxId + 1}`;

            const solicitacao = {
                id: maxId + 1,
                numero_solicitacao: num,
                solicitante: solicitante,
                setor_id: parseInt(setorId),
                equipamento: equip || null,
                prioridade: prioridade,
                status: 'PENDENTE',
                data_registro: new Date().toISOString(),
                itens: tempAddedItems.map(item => ({
                    produto_id: item.product_id,
                    quantidade_solicitada: item.quantidade_solicitada,
                    quantidade_atendida: 0.0
                }))
            };

            erpDatabase.solicitacoes.push(solicitacao);
            saveDatabase();

            AuditRepository.log(
                "CRIACAO REQUISICAO", 
                "Solicitação de Material", 
                "Inexistente", 
                `Criado pedido ${solicitacao.numero_solicitacao} por ${solicitante}`
            );

            // Reseta campos
            document.getElementById('req-solicitante').value = '';
            document.getElementById('req-equipamento').value = '';
            tempAddedItems = [];
            renderTempRequestItems();

            refreshUI();
            addToast(`Solicitação ${num} registrada com prioridade ${prioridade}!`, "success");
        }

        // Execução de Separação e Entrega (Despacho de Balcão)
        function deliverRequest(reqId) {
            const req = erpDatabase.solicitacoes.find(s => s.id === parseInt(reqId));
            if (!req) return;

            // Validação atômica de todos os saldos antes de baixar
            try {
                // Validação de saldo disponível
                req.itens.forEach(item => {
                    const p = ProductRepository.findById(item.produto_id);
                    if (!p || parseFloat(p.estoque_atual) < parseFloat(item.quantidade_solicitada)) {
                        throw new Error(`Saldo insuficiente no estoque para o item: ${p ? p.nome : 'Material'}`);
                    }
                });

                // Baixa atômica de estoque e gravação de movimentações
                req.itens.forEach(item => {
                    const p = ProductRepository.findById(item.produto_id);
                    const previous = parseFloat(p.estoque_atual);
                    const qtyDelivered = parseFloat(item.quantidade_solicitada);
                    const posterior = previous - qtyDelivered;

                    p.estoque_atual = posterior;
                    ProductRepository.save(p);

                    // Registro na movimentação unificada
                    const maxIdMov = erpDatabase.movimentacoes.reduce((max, m) => m.id > max ? m.id : max, 0);
                    erpDatabase.movimentacoes.push({
                        id: maxIdMov + 1,
                        produto_id: p.id,
                        tipo_movimentacao: "SAIDA",
                        quantidade: qtyDelivered,
                        saldo_anterior: previous,
                        saldo_posterior: posterior,
                        usuario_id: 104,
                        solicitacao_id: req.id,
                        origem: "DIGITACAO",
                        data_hora: new Date().toISOString()
                    });

                    item.quantidade_atendida = qtyDelivered;
                });

                req.status = 'ENTREGUE';
                saveDatabase();

                AuditRepository.log(
                    "DESPACHO REQUISICAO", 
                    "Painel Separação", 
                    "Pendente", 
                    `Despachado pedido ${req.numero_solicitacao}`
                );

                refreshUI();
                addToast(`Solicitação ${req.numero_solicitacao} entregue com sucesso! Estoque atualizado.`, "success");

            } catch (error) {
                addToast(error.message, "error");
            }
        }

        // ==========================================
        // CONSULTAS, AJUSTES E FILTROS
        // ==========================================
        function filterInventory() {
            const q = document.getElementById('search-query').value.toLowerCase().trim();
            const cat = document.getElementById('search-category').value;
            const status = document.getElementById('search-status').value;

            const list = erpDatabase.produtos;
            const tbody = document.getElementById('inventory-table-tbody');
            if(!tbody) return;
            tbody.innerHTML = '';

            const filtered = list.filter(p => {
                const matchesText = !q || p.nome.toLowerCase().includes(q) || p.marca.toLowerCase().includes(q) || p.codigo_barras.includes(q) || p.localizacao.toLowerCase().includes(q);
                const matchesCat = cat === 'TODAS' || p.categoria === cat;
                
                let matchesStatus = true;
                if (status === 'NORMAL') matchesStatus = p.estoque_atual >= p.estoque_minimo;
                if (status === 'BAIXO') matchesStatus = p.estoque_atual < p.estoque_minimo && p.estoque_atual > 0;
                if (status === 'ZERADO') matchesStatus = p.estoque_atual <= 0;

                return matchesText && matchesCat && matchesStatus;
            });

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="8" class="py-8 text-center text-slate-500">Nenhum registro localizado nos parâmetros de pesquisa.</td></tr>`;
                return;
            }

            filtered.forEach(p => {
                let statusBadge = '🟢 Normal';
                let rowBgClass = 'hover:bg-slate-900/30';
                if (p.estoque_atual <= 0) {
                    statusBadge = '🔴 Zerado';
                    rowBgClass = 'bg-rose-950/10 hover:bg-rose-950/20';
                } else if (p.estoque_atual < p.estoque_minimo) {
                    statusBadge = '🟡 Baixo';
                    rowBgClass = 'bg-amber-950/10 hover:bg-amber-950/20';
                }

                tbody.innerHTML += `
                    <tr class="${rowBgClass} transition-all">
                        <td class="py-3 px-2 font-mono text-slate-400">
                            ID: ${p.id}<br><span class="text-[10px] text-slate-500">${p.codigo_barras}</span>
                        </td>
                        <td class="py-3 px-2">
                            <span class="font-bold text-slate-200 block text-xs">${p.nome}</span>
                            <span class="text-[10px] text-slate-500 block">Marca: ${p.marca} | PN: ${p.part_number || 'Sem Part Number'}</span>
                        </td>
                        <td class="py-3 px-2 text-slate-400 font-semibold">${p.categoria}</td>
                        <td class="py-3 px-2 font-mono text-slate-400">${p.localizacao || 'N/A'}</td>
                        <td class="py-3 px-2 text-right font-bold code-font text-white">${p.estoque_atual} <span class="text-[10px] text-slate-500 font-normal">${p.unidade}</span></td>
                        <td class="py-3 px-2 text-right text-slate-500 font-mono">${p.estoque_minimo}</td>
                        <td class="py-3 px-2 text-center font-bold text-[11px]">${statusBadge}</td>
                        <td class="py-3 px-2 text-center">
                            <button onclick="openAjusteModal(${p.id})" title="Ajuste Seguro de Inventário" class="p-1.5 rounded bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/20 transition-all">
                                <i data-lucide="sliders" class="w-3.5 h-3.5"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            lucide.createIcons();
        }

        function openAjusteModal(id) {
            const p = ProductRepository.findById(id);
            if (!p) return;

            document.getElementById('ajusteModal').classList.remove('hidden');
            document.getElementById('ajuste-prod-id').value = p.id;
            document.getElementById('ajuste-prod-name').innerText = p.nome;
            document.getElementById('ajuste-prod-stock-current').value = `${p.estoque_atual} ${p.unidade}`;
            document.getElementById('ajuste-prod-stock-new').value = p.estoque_atual;
            document.getElementById('ajuste-prod-reason').value = '';
        }

        function closeAjusteModal() {
            document.getElementById('ajusteModal').classList.add('hidden');
        }

        function saveAjusteEstoque(e) {
            e.preventDefault();
            const id = document.getElementById('ajuste-prod-id').value;
            const newStock = parseFloat(document.getElementById('ajuste-prod-stock-new').value);
            const reason = document.getElementById('ajuste-prod-reason').value;

            if (newStock < 0) {
                addToast("Saldo de estoque não pode ser negativo.", "error");
                return;
            }

            const p = ProductRepository.findById(id);
            if (p) {
                const previous = parseFloat(p.estoque_atual);
                p.estoque_atual = newStock;
                ProductRepository.save(p);

                // Grava movimentação de ajuste
                const maxIdMov = erpDatabase.movimentacoes.reduce((max, m) => m.id > max ? m.id : max, 0);
                erpDatabase.movimentacoes.push({
                    id: maxIdMov + 1,
                    produto_id: p.id,
                    tipo_movimentacao: "AJUSTE",
                    quantidade: Math.abs(newStock - previous),
                    saldo_anterior: previous,
                    saldo_posterior: newStock,
                    usuario_id: 104,
                    origem: "DIGITACAO",
                    observacao: `Ajuste manual: ${reason}`,
                    data_hora: new Date().toISOString()
                });

                AuditRepository.log(
                    "AJUSTE ESTOQUE", 
                    "Consulta & Ajustes", 
                    `${previous} ${p.unidade}`, 
                    `${newStock} ${p.unidade} motivo: ${reason}`
                );

                closeAjusteModal();
                refreshUI();
                addToast("Ajuste físico de saldo gravado com auditoria com sucesso!", "success");
            }
        }

        // ==========================================
        // MÓDULO 5: IMPORTADOR EXCLUSIVO DA PLANILHA
        // ==========================================
        function simulateSheetImport(type) {
            const container = document.getElementById('import-report-pane');
            const box = document.getElementById('import-report-box');
            container.classList.remove('hidden');

            if (type === 'valid') {
                box.className = "p-4 rounded-lg text-xs font-mono max-h-40 overflow-y-auto bg-emerald-950/20 border border-emerald-500/30 text-emerald-300";
                box.innerHTML = `
[SUCCESS - 16:07:00] Arquivo 'carga_almoxarifado_siga.xlsx' carregado.
[VALIDATING...] Analisando 48 registros de materiais...
[OK] Todos os códigos ITEM são únicos e consistentes.
[OK] Classes mapeadas com sucesso (ABRASIVOS, EPIs, FERRAMENTAS).
[OK] Sintaxe de localização [PR-A1 a AL-D4] validada em 100% das linhas.
[IMPORT FINISHED] 48 materiais injetados com sucesso sem perdas!
                `;
                addToast("Injeção simulada concluída com integridade total!", "success");
            } else {
                box.className = "p-4 rounded-lg text-xs font-mono max-h-40 overflow-y-auto bg-rose-950/20 border border-rose-500/30 text-rose-300";
                box.innerHTML = `
[ERROR - 16:07:04] Falha ao processar arquivo 'antigo_almoxarifado.xlsx'.
[VALIDATING...] Analisando registros...
[INCONSISTENCY] Linha 12: Código ITEM duplicado para 'Rolamento SKF' e 'Rolamento FAG'.
[INCONSISTENCY] Linha 24: Categoria 'MANGUEIRAS' não cadastrada na tabela fiscal.
[INCONSISTENCY] Linha 37: Localização 'NENHUMA' viola a restrição [PR-X9 / AL-X9].
[IMPORT HALTED] A transação de importação foi cancelada (Rollback executado). Nenhuma linha foi injetada para evitar corrupção da base.
                `;
                addToast("Importação suspensa por inconsistência de dados!", "error");
            }
        }

        // ==========================================
        // RENDERIZADORES DE TABELAS E SECTIONS
        // ==========================================
        function refreshUI() {
            renderDashboard();
            renderStagingList();
            renderSeparationQueue();
            renderSaidaStockList();
            filterInventory();
            populateSolicitacoesDropdowns();
        }

        function renderDashboard() {
            const list = erpDatabase.produtos;
            const moves = erpDatabase.movimentacoes;

            // Indicadores
            document.getElementById('dash-total-materials').innerText = list.length;
            const totalStock = list.reduce((sum, p) => sum + parseFloat(p.estoque_atual), 0);
            document.getElementById('dash-stock-sum').innerText = totalStock.toFixed(1);

            const lowCount = list.filter(p => p.estoque_atual < p.estoque_minimo && p.estoque_atual > 0).length;
            document.getElementById('dash-low-stock').innerText = lowCount;

            const pendingReqCount = erpDatabase.solicitacoes.filter(s => s.status === 'PENDENTE').length;
            document.getElementById('dash-pending-requests').innerText = pendingReqCount;
            document.getElementById('badge-pedidos-pendentes').innerText = pendingReqCount;

            // Histórico unificado
            const tbody = document.getElementById('dash-movements-tbody');
            if(tbody) {
                tbody.innerHTML = '';
                const latestMoves = [...moves].sort((a,b) => new Date(b.data_hora) - new Date(a.data_hora)).slice(0, 5);
                
                if (latestMoves.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="7" class="py-4 text-center text-slate-500">Sem lançamentos na base física.</td></tr>`;
                } else {
                    latestMoves.forEach(m => {
                        const p = ProductRepository.findById(m.produto_id);
                        const isEntrada = m.tipo_movimentacao === 'ENTRADA';
                        const badge = isEntrada ? 'bg-emerald-500/10 text-emerald-400' : (m.tipo_movimentacao === 'SAIDA' ? 'bg-rose-500/10 text-rose-400' : 'bg-amber-500/10 text-amber-400');
                        tbody.innerHTML += `
                            <tr class="hover:bg-slate-900/50">
                                <td class="py-2.5 px-2 text-slate-500">${new Date(m.data_hora).toLocaleDateString('pt-BR')} ${new Date(m.data_hora).toLocaleTimeString('pt-BR')}</td>
                                <td class="py-2.5 px-2"><span class="px-1.5 py-0.5 rounded text-[9px] font-bold ${badge}">${m.tipo_movimentacao}</span></td>
                                <td class="py-2.5 px-2 font-bold text-slate-200">${p ? p.nome : 'N/A'}</td>
                                <td class="py-2.5 px-2 text-right font-mono font-bold ${isEntrada ? 'text-emerald-400' : 'text-rose-400'}">${isEntrada ? '+' : '-'}${m.quantidade}</td>
                                <td class="py-2.5 px-2 text-right text-slate-500 font-mono">${m.saldo_anterior}</td>
                                <td class="py-2.5 px-2 text-right text-slate-300 font-mono">${m.saldo_posterior}</td>
                                <td class="py-2.5 px-2 text-slate-400">ID ${m.usuario_id}</td>
                            </tr>
                        `;
                    });
                }
            }

            // Trilha de auditoria passiva no Dashboard
            const auditContainer = document.getElementById('dash-audit-container');
            if(auditContainer) {
                auditContainer.innerHTML = '';
                const logs = AuditRepository.getLatestLogs(6);
                logs.forEach(log => {
                    auditContainer.innerHTML += `
                        <div class="bg-slate-900/60 p-2.5 rounded border border-slate-800/80 flex flex-col gap-1">
                            <div class="flex justify-between text-[9px] text-slate-500">
                                <span class="font-bold text-indigo-400 uppercase">${log.operacao}</span>
                                <span>${new Date(log.data_hora).toLocaleTimeString('pt-BR')}</span>
                            </div>
                            <p class="text-slate-300">${log.valor_novo}</p>
                            <span class="text-[8px] text-slate-600 block">Terminal: ${log.computador_nome} | IP: ${log.ip_address}</span>
                        </div>
                    `;
                });
            }
        }

        function renderStagingList() {
            const container = document.getElementById('staging-container');
            const counter = document.getElementById('staging-counter');
            const actions = document.getElementById('recv-actions-container');

            if (!container) return;

            if (!erpDatabase.sessaoRecebimentoAtiva) {
                container.innerHTML = `
                    <div class="text-slate-600 text-center py-16 flex flex-col items-center gap-2">
                        <i data-lucide="lock" class="w-10 h-10 text-slate-700"></i>
                        <span>Sessão de recebimento fechada. Inicie uma nova sessão para habilitar.</span>
                    </div>
                `;
                if(counter) counter.innerText = 'Fechado';
                if(actions) actions.classList.add('hidden');
                return;
            }

            const list = erpDatabase.stagingList;
            if(counter) counter.innerText = `${list.length} material(is)`;
            
            if (list.length > 0) {
                if(actions) actions.classList.remove('hidden');
            } else {
                if(actions) actions.classList.add('hidden');
            }

            if (list.length === 0) {
                container.innerHTML = `
                    <div class="text-slate-600 text-center py-16 flex flex-col items-center gap-2">
                        <i data-lucide="package-search" class="w-10 h-10 text-slate-700"></i>
                        <span>Aguardando o escaneamento do primeiro material...</span>
                    </div>
                `;
                return;
            }

            container.innerHTML = '';
            list.forEach(item => {
                container.innerHTML += `
                    <div class="p-3 bg-slate-900 border border-slate-800 rounded-lg flex justify-between items-center">
                        <div>
                            <span class="font-bold text-slate-200 block">${item.product.nome}</span>
                            <span class="text-[10px] text-slate-400 font-mono">Barcode: ${item.product.codigo_barras} | PN: ${item.product.part_number || 'Sem PN'}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-mono text-indigo-400 font-bold bg-indigo-500/10 px-2 py-1 rounded border border-indigo-500/20">${item.quantidade} UN</span>
                            <button onclick="simulateBipe('${item.product.codigo_barras}')" class="p-1 rounded bg-slate-800 text-slate-300 hover:bg-slate-700 font-bold text-xs">+</button>
                        </div>
                    </div>
                `;
            });
            lucide.createIcons();
        }

        function renderSeparationQueue() {
            const container = document.getElementById('separation-queue-container');
            if (!container) return;
            container.innerHTML = '';

            const reqs = erpDatabase.solicitacoes;
            const pendings = reqs.filter(s => s.status === 'PENDENTE');

            if (pendings.length === 0) {
                container.innerHTML = `
                    <div class="text-slate-600 text-center py-20 flex flex-col items-center gap-2">
                        <i data-lucide="check-circle" class="w-12 h-12 text-slate-700"></i>
                        <span class="text-xs">Fila de Balcão Vazia. Nenhuma solicitação pendente de despacho.</span>
                    </div>
                `;
                return;
            }

            pendings.forEach(req => {
                const sector = SECTORES_TABLE.find(s => s.id === req.setor_id);
                const isAlta = req.prioridade === 'ALTA';
                const priorBadge = isAlta ? 'bg-rose-500/20 text-rose-400 border border-rose-500/30 font-bold' : 'bg-slate-900 border border-slate-800 text-slate-400';

                let itemsListHtml = '';
                req.itens.forEach(item => {
                    const p = ProductRepository.findById(item.produto_id);
                    itemsListHtml += `
                        <div class="flex justify-between text-[11px] font-mono border-b border-slate-900 py-1">
                            <span class="text-slate-300">${p ? p.nome : 'Material'} <strong class="text-slate-500">(Loc: ${p ? p.localizacao : 'N/A'})</strong></span>
                            <span class="text-slate-300 font-bold">${item.quantidade_solicitada} UN</span>
                        </div>
                    `;
                });

                container.innerHTML += `
                    <div class="p-4 bg-slate-900/40 border border-slate-800 rounded-xl flex flex-col gap-3 relative overflow-hidden">
                        ${isAlta ? '<div class="absolute top-0 left-0 w-full h-1 bg-rose-500"></div>' : ''}
                        
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] bg-slate-800 px-2 py-0.5 rounded font-mono font-bold text-slate-300">${req.numero_solicitacao}</span>
                                    <span class="text-[9px] px-1.5 py-0.5 rounded uppercase tracking-wider ${priorBadge}">${req.prioridade}</span>
                                </div>
                                <h4 class="text-xs font-bold text-white mt-1.5">Solicitante: <span class="text-slate-300 font-medium">${req.solicitante}</span></h4>
                                <span class="text-[10px] text-slate-500 block">Setor: ${sector ? sector.nome : 'N/A'} | Equipamento: ${req.equipamento || 'Geral'}</span>
                            </div>
                            <button onclick="deliverRequest(${req.id})" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-[11px] rounded-lg shadow-lg shadow-emerald-600/15 flex items-center gap-1">
                                <i data-lucide="check" class="w-3.5 h-3.5"></i> Despachar e Entregar
                            </button>
                        </div>

                        <!-- Lista de Itens internos -->
                        <div class="bg-slate-950 p-2.5 rounded-lg border border-slate-900 flex flex-col gap-1">
                            ${itemsListHtml}
                        </div>
                    </div>
                `;
            });
            lucide.createIcons();
        }

        function populateSolicitacoesDropdowns() {
            const itemSelect = document.getElementById('req-item-select');
            const sectorSelect = document.getElementById('req-setor');
            if (!itemSelect || !sectorSelect) return;

            itemSelect.innerHTML = '<option value="">-- Escolha o Material --</option>';
            erpDatabase.produtos.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.innerText = `${p.nome} (${p.marca}) - Saldo: ${p.estoque_atual}`;
                itemSelect.appendChild(opt);
            });

            sectorSelect.innerHTML = '';
            SECTORES_TABLE.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id;
                opt.innerText = s.nome;
                sectorSelect.appendChild(opt);
            });
        }

        // Foco assistido automático de acordo com a Aba Ativa
        function refocusScannerField() {
            if (activeTab === 'recebimento' && erpDatabase.sessaoRecebimentoAtiva) {
                const input = document.getElementById('recvBarcodeInput');
                if (input) input.focus();
            } else if (activeTab === 'saida') {
                const input = document.getElementById('saidaBarcodeInput');
                if (input) input.focus();
            }
        }

        // Setup de Leitores para Staging (Recebimento) - Captura Manual em Input focado
        const recvInputEl = document.getElementById('recvBarcodeInput');
        if (recvInputEl) {
            recvInputEl.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const code = e.target.value.trim();
                    if (code) {
                        simulateBipe(code);
                        e.target.value = '';
                    }
                }
            });
        }

        // Setup de Leitores para Saída Balcão
        const saidaInputEl = document.getElementById('saidaBarcodeInput');
        if (saidaInputEl) {
            saidaInputEl.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const code = e.target.value.trim();
                    if (code) {
                        triggerSaidaPipelineSearch(code);
                    }
                }
            });

            // Autocomplete de Saída
            saidaInputEl.addEventListener('input', () => {
                const query = saidaInputEl.value.toLowerCase().trim();
                const dropdown = document.getElementById('saidaAutocompleteDropdown');
                
                if (query.length < 2) {
                    dropdown.classList.add('hidden');
                    return;
                }

                const suggestions = ProductRepository.findByFreeSearch(query);
                dropdown.innerHTML = '';

                if (suggestions.length === 0) {
                    dropdown.classList.add('hidden');
                    return;
                }

                suggestions.forEach(p => {
                    const item = document.createElement('div');
                    item.className = "px-4 py-3 hover:bg-rose-950/20 border-b border-slate-900 text-xs cursor-pointer flex justify-between items-center transition-all";
                    item.innerHTML = `
                        <div>
                            <div class="font-bold text-slate-200">${p.nome}</div>
                            <div class="text-[10px] text-slate-400 font-mono">${p.codigo_barras} | PN: ${p.part_number || 'Sem PN'}</div>
                        </div>
                        <span class="text-[10px] bg-slate-900 px-2 py-1 rounded text-rose-400 font-mono font-bold">${p.estoque_atual} ${p.unidade}</span>
                    `;
                    item.addEventListener('click', () => {
                        selectProductForSaida(p);
                        dropdown.classList.add('hidden');
                    });
                    dropdown.appendChild(item);
                });
                dropdown.classList.remove('hidden');
            });
        }

        // =========================================================================
        // MOTOR DO INTERCEPTADOR GLOBAL DE SCANNER (SOLUÇÃO DE INFRAESTRUTURA)
        // =========================================================================
        let barcodeAccumulator = '';
        let lastKeyTime = 0;

        document.addEventListener('keydown', (e) => {
            // Se o operador estiver preenchendo um campo de texto manual ou formulário complexo,
            // não devemos interceptar os dados da digitação humana.
            const activeEl = document.activeElement;
            const isEditingText = activeEl && (
                activeEl.tagName === 'TEXTAREA' || 
                (activeEl.tagName === 'INPUT' && 
                 activeEl.id !== 'recvBarcodeInput' && 
                 activeEl.id !== 'saidaBarcodeInput' && 
                 activeEl.id !== 'search-query')
            );

            if (isEditingText) {
                return; // Deixa o operador digitar normalmente em campos de formulário
            }

            const currentTime = performance.now();
            const diff = currentTime - lastKeyTime;
            lastKeyTime = currentTime;

            // Scanners de Hardware enviam teclas sequencialmente de forma extremamente veloz (delta < 35ms)
            if (diff < 35 || barcodeAccumulator === '') {
                if (e.key !== 'Enter' && e.key.length === 1) {
                    barcodeAccumulator += e.key;
                } else if (e.key === 'Enter') {
                    const finalCode = barcodeAccumulator.trim();
                    if (finalCode.length >= 3) {
                        e.preventDefault();
                        processGlobalScannerInput(finalCode);
                    }
                    barcodeAccumulator = '';
                }
            } else {
                // Digitação manual muito lenta para ser um leitor de código de barras
                if (e.key.length === 1 && e.key !== 'Enter') {
                    barcodeAccumulator = e.key;
                } else {
                    barcodeAccumulator = '';
                }
            }
        });

        // Efetua o tratamento da leitura global do Scanner de qualquer lugar do software
        function processGlobalScannerInput(code) {
            addToast(`Código capturado via Scanner: ${code}`, 'success');
            
            // Se estiver na aba de recebimento com sessão ativa, executa recebimento.
            // Se não, o padrão ideal para agilidade de balcão é redirecionar para Saída Direta!
            if (activeTab === 'recebimento' && erpDatabase.sessaoRecebimentoAtiva) {
                simulateBipe(code);
            } else {
                if (activeTab !== 'saida') {
                    switchTab('saida');
                }
                setTimeout(() => {
                    triggerSaidaPipelineSearch(code);
                }, 100);
            }
        }

        // Se o usuário clicar em qualquer ponto vazio da tela, devolvemos o foco para o leitor de código
        document.addEventListener('click', (e) => {
            const tag = e.target.tagName;
            if (tag !== 'INPUT' && tag !== 'SELECT' && tag !== 'TEXTAREA' && tag !== 'BUTTON' && tag !== 'A') {
                refocusScannerField();
            }
        });

        function setupKeyboardShortcuts() {
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (activeTab === 'saida') {
                        cancelSaidaDirect();
                    } else {
                        cancelFastCadastro();
                    }
                }
                if (e.key === 'F2') {
                    e.preventDefault();
                    refocusScannerField();
                }
                if (e.key === 'F9') {
                    if (activeTab === 'saida' && !document.getElementById('saidaStateProductFound').classList.contains('hidden')) {
                        e.preventDefault();
                        executeSaidaDirect();
                    }
                }
            });
        }

        function switchTab(tabId) {
            activeTab = tabId;
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.getElementById(`tab-${tabId}`).classList.remove('hidden');

            document.querySelectorAll('nav border, nav button').forEach(btn => {
                btn.className = "flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800";
            });

            const activeBtn = document.getElementById(`tabBtn-${tabId}`);
            if (tabId === 'engenharia') {
                activeBtn.className = "flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all bg-amber-500 text-slate-950 shadow-lg shadow-amber-500/10";
            } else {
                activeBtn.className = "flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all bg-indigo-600 text-white shadow-lg shadow-indigo-500/10";
            }

            refreshUI();
            refocusScannerField();
        }

        // Inicialização Geral
        window.addEventListener('DOMContentLoaded', () => {
            initErpDatabase();
            lucide.createIcons();
            populateSolicitacoesDropdowns();
            populateSaidaSectors();
            setupKeyboardShortcuts();
            refreshUI();
        });

        // Toast de Feedback
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