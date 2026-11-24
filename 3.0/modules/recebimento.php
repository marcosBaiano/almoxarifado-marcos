        <section id="tab-recebimento" class="tab-content hidden flex flex-col gap-6">
            <!-- Aviso tÃ©cnico sobre o Scanner -->
            <div class="bg-indigo-950/20 border border-indigo-500/20 rounded-xl p-4 text-xs text-indigo-300 flex items-center gap-3">
                <i data-lucide="info" class="w-5 h-5 text-indigo-400 shrink-0"></i>
                <p>
                    <strong>Leitor Inteligente Ativo:</strong> GraÃ§as ao nosso algoritmo de telemetria de digitaÃ§Ã£o rÃ¡pida, vocÃª pode bipar o cÃ³digo de barras com o scanner **a qualquer momento nesta aba**, mesmo se nÃ£o tiver clicado no campo de texto abaixo! O sistema foca e processa a leitura de forma automÃ¡tica.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Coluna Esquerda: Controle de SessÃ£o e Pipeline de Bipe -->
                <div class="lg:col-span-7 flex flex-col gap-6">
                    <!-- ConfiguraÃ§Ãµes e Abertura de SessÃ£o de Recebimento -->
                    <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-500"></div>
                        <div class="flex justify-between items-center mb-4 border-b border-slate-900 pb-2">
                            <h3 class="text-xs font-bold uppercase text-slate-300 flex items-center gap-2">
                                <i data-lucide="layers" class="w-4 h-4 text-indigo-400"></i>
                                SessÃ£o Ativa de Recebimento
                            </h3>
                            <span id="session-badge-status" class="bg-rose-500/20 text-rose-400 border border-rose-500/30 text-[9px] font-bold px-2.5 py-0.5 rounded">
                                SessÃ£o Fechada
                            </span>
                        </div>

                        <!-- Estado 1: Sem SessÃ£o Ativa -->
                        <div id="recv-no-session-pane" class="py-6 text-center">
                            <p class="text-xs text-slate-400 mb-4">Abra uma nova sessÃ£o de recebimento para iniciar a leitura consecutiva de mercadorias sem impactar imediatamente o saldo ativo de estoque (Ãrea de Staging).</p>
                            <button onclick="startNewReceivingSession()" class="mx-auto px-6 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs flex items-center gap-2 shadow-lg shadow-indigo-600/20 transition-all">
                                <i data-lucide="plus-circle" class="w-4 h-4"></i> Iniciar Nova SessÃ£o de Recebimento
                            </button>
                        </div>

                        <!-- Estado 2: SessÃ£o Ativa Aberta -->
                        <div id="recv-active-session-pane" class="hidden flex flex-col gap-4">
                            <div class="grid grid-cols-2 gap-4 bg-slate-900/50 p-3 rounded-lg border border-slate-800/60 text-xs text-slate-400">
                                <div>ID SessÃ£o: <strong id="recv-session-id" class="text-slate-200 code-font">RECV-2026-001</strong></div>
                                <div>Abertura: <strong id="recv-session-time" class="text-slate-200">15/07/2026</strong></div>
                            </div>

                            <div class="relative">
                                <label for="recvBarcodeInput" class="block text-xs font-medium text-slate-400 mb-1">Escanear CÃ³digo de Barras / DigitaÃ§Ã£o RÃ¡pida</label>
                                <div class="relative">
                                    <input type="text" id="recvBarcodeInput" 
                                        class="w-full bg-slate-900 border-2 border-slate-700 rounded-lg pl-10 pr-4 py-2.5 text-white placeholder-slate-500 font-mono text-sm focus:outline-none focus:border-indigo-500 transition-all"
                                        placeholder="Bipe o cÃ³digo de barras ou digite..." autocomplete="off">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="barcode" class="h-4 w-4 text-slate-400"></i>
                                    </div>
                                </div>
                                <div id="recvAutocomplete" class="hidden absolute left-0 right-0 mt-1 bg-slate-950 border border-slate-800 rounded-lg shadow-2xl z-50 max-h-48 overflow-y-auto"></div>
                            </div>

                            <div class="flex items-center justify-between text-[11px] text-slate-400 border-t border-slate-900 pt-3">
                                <span>SimulaÃ§Ã£o de leitura (clique rÃ¡pido):</span>
                                <div class="flex flex-wrap gap-1.5">
                                    <button onclick="simulateBipe('7891000123456')" class="bg-slate-900 hover:bg-slate-800 border border-slate-800 text-[10px] px-2 py-1 rounded text-slate-300 font-mono">Bipar Sensor</button>
                                    <button onclick="simulateBipe('7891000789012')" class="bg-slate-900 hover:bg-slate-800 border border-slate-800 text-[10px] px-2 py-1 rounded text-slate-300 font-mono">Bipar Rolamento</button>
                                    <button onclick="simulateBipe('7891000333444')" class="bg-slate-900 hover:bg-slate-800 border border-slate-800 text-[10px] px-2 py-1 rounded text-slate-300 font-mono">Bipar Cabo (API)</button>
                                    <button onclick="simulateBipe('999999')" class="bg-slate-900 hover:bg-slate-850 border border-slate-850 text-[10px] px-2 py-1 rounded text-amber-400 font-mono">Bipar Novo</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FormulÃ¡rio de Cadastro RÃ¡pido de Material (Retorna Ã  SessÃ£o de forma AtÃ´mica) -->
                    <div id="recv-associacao-barcode-container" class="hidden bg-slate-950 border border-amber-500/30 p-5 rounded-xl flex flex-col gap-4">
                        <div class="flex justify-between items-center border-b border-slate-900 pb-2">
                            <h4 class="text-xs font-bold text-amber-400 uppercase flex items-center gap-2">
                                <i data-lucide="link" class="w-4 h-4"></i>
                                Associar Codigo de Barras a Material Existente
                            </h4>
                            <span class="text-[9px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 px-1.5 py-0.5 rounded font-bold">Continua a Entrada</span>
                        </div>
                        <form id="recv-associacao-form" onsubmit="saveBarcodeAssociation(event)" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                            <div>
                                <label class="block text-slate-400 mb-1">Codigo de Barras Lido</label>
                                <input type="text" id="assoc-barcode" readonly class="w-full bg-slate-900 border border-slate-800 text-amber-400 font-mono p-2 rounded cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-slate-400 mb-1">Buscar Material Existente</label>
                                <input type="text" id="assoc-product-search" oninput="filterBarcodeAssociationProducts()" placeholder="Digite codigo, descricao, marca ou PN..." class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded focus:outline-none focus:border-amber-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-slate-400 mb-1">Material para Associacao *</label>
                                <select id="assoc-product-select" required class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded focus:outline-none focus:border-amber-500"></select>
                            </div>
                            <div class="md:col-span-2 flex justify-end gap-2 pt-2 border-t border-slate-900">
                                <button type="button" onclick="cancelBarcodeAssociation()" class="px-4 py-2 rounded text-slate-400 hover:bg-slate-900">Cancelar</button>
                                <button type="submit" class="px-5 py-2 rounded bg-emerald-600 hover:bg-emerald-500 text-white font-bold">Associar e Registrar na Lista</button>
                            </div>
                        </form>
                    </div>

                    <div id="recv-cadastro-rapido-container" class="hidden bg-slate-950 border border-slate-800 p-5 rounded-xl flex flex-col gap-4">
                        <div class="flex justify-between items-center border-b border-slate-900 pb-2">
                            <h4 class="text-xs font-bold text-amber-400 uppercase flex items-center gap-2">
                                <i data-lucide="plus-square" class="w-4 h-4"></i>
                                Cadastro de Material NÃ£o Identificado
                            </h4>
                            <span class="text-[9px] bg-amber-500/10 text-amber-400 border border-amber-500/30 px-1.5 py-0.5 rounded font-bold">Auto-Retorno Ativo</span>
                        </div>
                        <form id="recv-rapido-form" onsubmit="saveFastProduct(event)" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                            <div>
                                <label class="block text-slate-400 mb-1">CÃ³digo de Barras</label>
                                <input type="text" id="rf-barcode" readonly class="w-full bg-slate-900 border border-slate-800 text-amber-400 font-mono p-2 rounded cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-slate-400 mb-1">DescriÃ§Ã£o Completa *</label>
                                <input type="text" id="rf-name" required placeholder="Ex: Sensor MagnÃ©tico" class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-slate-400 mb-1">Marca *</label>
                                <input type="text" id="rf-brand" required class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded">
                            </div>
                            <div>
                                <label class="block text-slate-400 mb-1">Categoria *</label>
                                <select id="rf-category" required class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded">
                                    <option value="ElÃ©trica">ElÃ©trica</option>
                                    <option value="MecÃ¢nica">MecÃ¢nica</option>
                                    <option value="PneumÃ¡tica">PneumÃ¡tica</option>
                                    <option value="HidrÃ¡ulica">HidrÃ¡ulica</option>
                                    <option value="Ferramentas">Ferramentas</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 flex justify-end gap-2 pt-2 border-t border-slate-900">
                                <button type="button" onclick="cancelFastCadastro()" class="px-4 py-2 rounded text-slate-400 hover:bg-slate-900">Voltar Ã  SessÃ£o</button>
                                <button type="submit" class="px-5 py-2 rounded bg-emerald-600 hover:bg-emerald-500 text-white font-bold">Salvar e Registrar na Lista</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Coluna Direita: Lista de Staging (ConferÃªncia de Lote) -->
                <div class="lg:col-span-5 bg-slate-950 border border-slate-800 p-5 rounded-xl flex flex-col h-[520px]">
                    <div class="flex justify-between items-center border-b border-slate-900 pb-3 mb-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300 flex items-center gap-2">
                            <i data-lucide="list-checks" class="w-4 h-4 text-emerald-400"></i>
                            Lista de Staging (Lista de ConferÃªncia)
                        </h3>
                        <span id="staging-counter" class="text-xs bg-slate-900 border border-slate-800 text-slate-300 px-2 py-0.5 rounded font-bold">0 itens</span>
                    </div>

                    <!-- Ãrea de Staging de Linhas -->
                    <div id="staging-container" class="flex-1 overflow-y-auto flex flex-col gap-2.5 text-xs">
                        <div class="text-slate-600 text-center py-16 flex flex-col items-center gap-2">
                            <i data-lucide="package" class="w-10 h-10 text-slate-700"></i>
                            <span>Nenhum material adicionado a esta sessÃ£o.</span>
                        </div>
                    </div>

                    <!-- Fechamento / Commit da SessÃ£o de Recebimento -->
                    <div id="recv-actions-container" class="hidden border-t border-slate-900 pt-4 mt-3 flex justify-between gap-3">
                        <button onclick="discardReceivingSession()" class="px-4 py-2.5 rounded-lg border border-slate-800 hover:bg-slate-900 text-slate-400 font-bold text-xs transition-all">
                            Descartar SessÃ£o
                        </button>
                        <button onclick="commitReceivingSession()" class="px-6 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center gap-2 shadow-lg shadow-emerald-600/20 transition-all">
                            <i data-lucide="shield-check" class="w-4 h-4"></i> Confirmar e Atualizar Estoque (Commit)
                        </button>
                    </div>
                </div>
            </div>
        </section>

<!-- ========================================== -->
<!-- MÃ“DULO 3: SAÃDA DIRETA DE MATERIAIS (SCANNER) -->
