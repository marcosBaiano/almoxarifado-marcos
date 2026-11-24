<section id="tab-saida" class="tab-content hidden flex flex-col gap-6">
    <!-- Alerta operacional de balcÃ£o -->
    <div class="bg-rose-950/20 border border-rose-500/20 rounded-xl p-4 text-xs text-rose-300 flex items-center gap-3">
        <i data-lucide="scan-barcode" class="w-5 h-5 text-rose-400 shrink-0"></i>
        <p>
            <strong>MÃ³dulo de SaÃ­da Direta de PeÃ§a:</strong> Destinado ao despacho Ã¡gil de balcÃ£o sem solicitaÃ§Ã£o prÃ©via. Identifique o item pelo scanner, insira a quantidade e o setor requisitante. O estoque serÃ¡ deduzido em tempo real com auditoria ativa.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Painel de Busca, IdentificaÃ§Ã£o e FormulÃ¡rio -->
        <div class="lg:col-span-8 flex flex-col gap-6">
            
            <!-- SCANNER -->
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 shadow-lg relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-rose-500"></div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-sm font-semibold tracking-wider text-slate-300 uppercase flex items-center gap-2">
                        <i data-lucide="scan" class="w-4 h-4 text-rose-400"></i>
                        IdentificaÃ§Ã£o no BalcÃ£o de SaÃ­da
                    </h2>
                    <span class="text-[10px] bg-slate-800 text-slate-400 px-2.5 py-1 rounded-md border border-slate-700">
                        Atalho: [F2] Foco Campo CÃ³digo
                    </span>
                </div>

                <div class="relative">
                    <label for="saidaBarcodeInput" class="block text-xs font-medium text-slate-400 mb-1.5">
                        Escaneie o CÃ³digo de Barras do Material ou Digite Detalhes
                    </label>
                    <div class="relative">
                        <input type="text" id="saidaBarcodeInput" 
                            class="w-full bg-slate-900 border-2 border-slate-700 rounded-lg pl-10 pr-4 py-3 text-white placeholder-slate-500 font-mono text-base focus:outline-none focus:border-rose-500 transition-all shadow-inner"
                            placeholder="Aponte o leitor de cÃ³digo de barras..." autocomplete="off">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="barcode" class="h-5 w-5 text-slate-400" id="saidaBarcodeIcon"></i>
                        </div>
                    </div>
                    
                    <!-- Autocomplete dropdown da saÃ­da -->
                    <div id="saidaAutocompleteDropdown" class="hidden absolute left-0 right-0 mt-1 bg-slate-950 border border-slate-800 rounded-lg shadow-2xl z-50 max-h-60 overflow-y-auto"></div>
                </div>
            </div>

            <!-- Card DinÃ¢mico de TransaÃ§Ã£o de SaÃ­da -->
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 shadow-lg flex-1 flex flex-col justify-between min-h-[340px]">
                
                <!-- ESTADO 1: Aguardando Bipe -->
                <div id="saidaStatePlaceholder" class="flex-1 flex flex-col items-center justify-center text-center p-8">
                    <div class="w-16 h-16 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center mb-4 text-slate-500">
                        <i data-lucide="search" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-base font-semibold text-slate-300">Aguardando Leitura de SaÃ­da</h3>
                    <p class="text-xs text-slate-500 max-w-sm mt-1">
                        Escaneie uma etiqueta de cÃ³digo de barras ou digite o cÃ³digo do material de reposiÃ§Ã£o para registrar a retirada rÃ¡pida de estoque.
                    </p>
                </div>

                <!-- ESTADO 2: Material Identificado para Despacho -->
                <div id="saidaStateProductFound" class="hidden flex-1 flex flex-col gap-6">
                    
                    <!-- PRODUTO IDENTIFICADO (INFO DO BIPE) -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-slate-900/50 p-4 rounded-lg border border-slate-800">
                        <div class="flex items-center gap-4">
                            <!-- Imagem -->
                            <div class="w-16 h-16 bg-slate-800 rounded-lg flex items-center justify-center border border-slate-700 text-slate-400 overflow-hidden relative shrink-0">
                                <i data-lucide="box" class="w-8 h-8 text-slate-500"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <!-- Categoria -->
                                    <span id="saidaProdCategory" class="text-[10px] font-bold tracking-wider text-indigo-400 bg-indigo-500/10 border border-indigo-500/20 px-2 py-0.5 rounded uppercase">ElÃ©trica</span>
                                    <span id="saidaProdID" class="text-[10px] font-mono text-slate-400 bg-slate-850 px-2 py-0.5 rounded">ID: 000</span>
                                </div>
                                <!-- Nome -->
                                <h3 id="saidaProdName" class="text-base font-bold text-white mt-1">Nome do Item Selecionado</h3>
                                <p class="text-xs text-slate-400 flex items-center gap-2 mt-0.5">
                                    <!-- Part Number e Marca -->
                                    <span>Part Number: <strong class="text-slate-200 code-font" id="saidaProdPN">N/A</strong></span>
                                    <span class="text-slate-600">|</span>
                                    <span>Marca: <strong class="text-slate-200" id="saidaProdBrand">N/A</strong></span>
                                </p>
                            </div>
                        </div>

                        <!-- Saldo DisponÃ­vel -->
                        <div class="bg-slate-900 px-4 py-3 rounded-lg border border-slate-700 min-w-[120px] text-center shrink-0 self-stretch md:self-auto flex flex-col justify-center">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Saldo em Estoque</span>
                            <span id="saidaProdStock" class="text-2xl font-black text-rose-400 code-font">0</span>
                            <span id="saidaProdUnit" class="text-xs text-slate-400 block -mt-1">UN</span>
                        </div>
                    </div>

                    <!-- FORMULÃRIO EM GRID EQUILIBRADA (DADOS DO DESTINO) -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 border-b border-slate-900 pb-1.5">Dados da MovimentaÃ§Ã£o</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                            <!-- Quantidade a Retirar -->
                            <div>
                                <label for="saidaQuantityInput" class="block text-slate-400 font-bold mb-1.5 uppercase tracking-wider">Quantidade a Retirar *</label>
                                <input type="number" id="saidaQuantityInput" min="0.1" step="any" required
                                    class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-lg font-bold text-white code-font focus:outline-none focus:border-rose-500 text-center" 
                                    value="1">
                            </div>

                            <!-- Setor DestinatÃ¡rio -->
                            <div>
                                <label for="saidaSetorInput" class="block text-slate-400 font-bold mb-1.5 uppercase tracking-wider">Setor DestinatÃ¡rio *</label>
                                <select id="saidaSetorInput" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-3 text-sm font-semibold text-white focus:outline-none focus:border-rose-500">
                                    <!-- Preenchido via JS -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- OBSERVAÃ‡ÃƒO -->
                    <div class="text-xs">
                        <label for="saidaObsInput" class="block text-slate-400 font-bold mb-1.5 uppercase tracking-wider">ObservaÃ§Ã£o / Ordem de ServiÃ§o / Justificativa</label>
                        <textarea id="saidaObsInput" rows="3" 
                            class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-slate-200 placeholder-slate-600 focus:outline-none focus:border-rose-500 text-xs"
                            placeholder="Ex: Empregado na troca de cabos da prensa HidrÃ¡ulica 05..."></textarea>
                    </div>

                    <!-- RESUMO DA MOVIMENTAÃ‡ÃƒO DINÃ‚MICO -->
                    <div class="bg-emerald-950/20 border border-emerald-700/30 rounded-lg p-4">
                        <h4 class="text-xs font-bold text-emerald-300 mb-3 uppercase tracking-wider flex items-center gap-1.5">
                            <i data-lucide="file-text" class="w-4 h-4 text-emerald-400"></i>
                            Resumo da MovimentaÃ§Ã£o
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-6 gap-3 text-xs">
                            <!-- Produto (Vem automÃ¡tico da busca/bipe do cÃ³digo de barras) -->
                            <div>
                                <span class="text-[10px] text-slate-400 block uppercase font-semibold mb-1">Produto</span>
                                <div id="saidaResumoProduto" class="text-white font-semibold bg-slate-900/60 border border-slate-800 rounded p-2 min-h-[2.25rem] flex items-center truncate"></div>
                            </div>
                            
                            <!-- Quantidade (Vem do campo Quantidade a Retirar ou editÃ¡vel) -->
                            <div>
                                <span class="text-[10px] text-emerald-400 block uppercase font-bold mb-1 flex items-center gap-1">
                                    Quantidade <i data-lucide="edit-2" class="w-2.5 h-2.5"></i>
                                </span>
                                <div id="saidaResumoQuantidade" contenteditable="true" class="text-white font-semibold bg-slate-900 border border-slate-700 rounded p-2 min-h-[2.25rem] flex items-center focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all cursor-text shadow-inner"></div>
                            </div>
                            
                            <!-- Solicitante (PreenchÃ­vel / EditÃ¡vel) -->
                            <div>
                                <span class="text-[10px] text-emerald-400 block uppercase font-bold mb-1 flex items-center gap-1">
                                    Solicitante <i data-lucide="edit-2" class="w-2.5 h-2.5"></i>
                                </span>
                                <div id="saidaResumoSolicitante" contenteditable="true" class="text-white font-semibold bg-slate-900 border border-slate-700 rounded p-2 min-h-[2.25rem] flex items-center focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all cursor-text shadow-inner truncate"></div>
                            </div>
                            
                            <!-- Equipamento (PreenchÃ­vel / EditÃ¡vel) -->
                            <div>
                                <span class="text-[10px] text-emerald-400 block uppercase font-bold mb-1 flex items-center gap-1">
                                    Equipamento <i data-lucide="edit-2" class="w-2.5 h-2.5"></i>
                                </span>
                                <div id="saidaResumoEquipamento" contenteditable="true" class="text-white font-semibold bg-slate-900 border border-slate-700 rounded p-2 min-h-[2.25rem] flex items-center focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all cursor-text shadow-inner truncate"></div>
                            </div>
                            
                            <!-- Saldo Atual (Vem automÃ¡tico da leitura do bipe) -->
                            <div>
                                <span class="text-[10px] text-slate-400 block uppercase font-semibold mb-1">Saldo Atual</span>
                                <div id="saidaResumoSaldoAtual" class="text-rose-400 font-bold font-mono bg-slate-900/60 border border-slate-800 rounded p-2 min-h-[2.25rem] flex items-center">
                                    -
                                </div>
                            </div>
                            
                            <!-- Saldo PÃ³s Baixa (CÃ¡lculo: Saldo Atual - Quantidade a Retirar) -->
                            <div>
                                <span class="text-[10px] text-slate-400 block uppercase font-semibold mb-1">Saldo PÃ³s Baixa</span>
                                <div id="saidaResumoSaldoPosBaixa" class="text-emerald-400 font-bold font-mono bg-slate-900/60 border border-slate-800 rounded p-2 min-h-[2.25rem] flex items-center">
                                    -
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AUDITORIA HORIZONTAL -->
                    <div class="bg-slate-900/30 p-3 rounded-lg border border-slate-800/85 text-[10px] text-slate-400 font-mono flex flex-wrap items-center justify-between gap-4">
                        <span class="font-bold text-slate-300 uppercase tracking-wider">Auditoria Direta:</span>
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-1">
                            <div>Operador: <span class="text-slate-300 font-semibold">ID 104 - ENG_SOUZA</span></div>
                            <div>Terminal: <span class="text-slate-300 font-semibold">MNT-W10-04</span></div>
                            <div>IP Address: <span class="text-slate-300 font-semibold">192.168.10.45</span></div>
                            <div>Data/Hora: <span class="text-slate-300 font-semibold">20/07/2026 - 17:48</span></div>
                        </div>
                    </div>

                    <!-- BOTÃ•ES DE TRANSAÃ‡ÃƒO (Largura fixa e alinhados Ã  direita) -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-900">
                        <button type="button" onclick="cancelSaidaDirect()" class="w-40 h-10 rounded-lg text-slate-400 hover:bg-slate-900 text-xs font-bold transition-all border border-transparent hover:border-slate-800 flex items-center justify-center">
                            Cancelar [ESC]
                        </button>
                        <button type="button" id="btnConfirmarSaidaDirect" onclick="executeSaidaDirect()" class="w-52 h-10 rounded-lg bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs shadow-lg shadow-rose-600/20 flex items-center justify-center gap-2 transition-all">
                            <i data-lucide="check" class="w-4 h-4"></i> Confirmar Baixa [F9]
                        </button>
                    </div>
                </div>

                <!-- ESTADO 3: Produto NÃ£o Localizado -->
                <div id="saidaStateNotFound" class="hidden flex-1 flex flex-col items-center justify-center text-center p-6">
                    <div class="w-16 h-16 rounded-full bg-amber-500/10 border border-amber-500/30 flex items-center justify-center mb-4 text-amber-500">
                        <i data-lucide="alert-triangle" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-200">Material nÃ£o Localizado na Base</h3>
                    <p class="text-xs text-slate-400 max-w-md mt-1">
                        O cÃ³digo <strong class="text-amber-400 code-font" id="saidaMissingCodeSpan">123456</strong> foi processado, mas nenhum registro de material foi localizado.
                    </p>
                    <button onclick="cancelSaidaDirect()" class="mt-4 px-5 py-2 rounded bg-slate-900 hover:bg-slate-800 text-xs text-slate-300 font-bold border border-slate-800 transition-all">
                        Voltar e Limpar
                    </button>
                </div>

            </div>
        </div>

        <!-- Painel Direita: InventÃ¡rio RÃ¡pido de PeÃ§as CrÃ­ticas -->
        <div class="lg:col-span-4 bg-slate-950 border border-slate-800 p-5 rounded-xl flex flex-col h-[520px]">
            <div class="flex justify-between items-center border-b border-slate-900 pb-3 mb-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300 flex items-center gap-2">
                    <i data-lucide="boxes" class="w-4 h-4 text-rose-400"></i>
                    Controle de Saldo CrÃ­tico
                </h3>
            </div>
            <div class="flex-1 overflow-y-auto pr-1 flex flex-col gap-2" id="saidaStockListContainer">
                <!-- Preenchido via JS -->
            </div>
        </div>
    </div>
</section>

        <!-- ========================================== -->
        <!-- MÃ“DULO 4: SOLICITAÃ‡Ã•ES, SEPARAÃ‡ÃƒO & ENTREGA -->
