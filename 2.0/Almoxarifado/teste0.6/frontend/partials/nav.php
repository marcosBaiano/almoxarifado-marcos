<nav class="bg-slate-900/80 border-b border-slate-800 px-6 py-2 sticky top-[73px] z-40 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex flex-wrap gap-1.5">
            <button onclick="switchTab('dashboard')" id="tabBtn-dashboard" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all bg-indigo-600 text-white shadow-lg shadow-indigo-500/10">
                <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i> Dashboard
            </button>
            <button onclick="switchTab('recebimento')" id="tabBtn-recebimento" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800">
                <i data-lucide="log-in" class="w-3.5 h-3.5"></i> Recebimento (SessÃµes)
            </button>
            <button onclick="switchTab('saida')" id="tabBtn-saida" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800">
                <i data-lucide="log-out" class="w-3.5 h-3.5"></i> SaÃ­da de Material (Scanner)
            </button>
            <button onclick="switchTab('solicitacao')" id="tabBtn-solicitacao" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800">
                <i data-lucide="clipboard-list" class="w-3.5 h-3.5"></i> SolicitaÃ§Ãµes & Entrega
                <span id="badge-pedidos-pendentes" class="bg-amber-500/20 text-amber-400 border border-amber-500/30 text-[10px] px-1.5 rounded-full font-bold">1</span>
            </button>
            <button onclick="switchTab('consulta')" id="tabBtn-consulta" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800">
                <i data-lucide="search" class="w-3.5 h-3.5"></i> Consulta & Ajustes
            </button>
            <button onclick="switchTab('importador')" id="tabBtn-importador" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800">
                <i data-lucide="upload" class="w-3.5 h-3.5"></i> Importador Planilha
            </button>
            <button onclick="switchTab('engenharia')" id="tabBtn-engenharia" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all text-amber-400 hover:bg-amber-500/10 border border-amber-500/20">
                <i data-lucide="book-open" class="w-3.5 h-3.5"></i> EspecificaÃ§Ãµes de Engenharia & MER
            </button>
        </div>
    </nav>
