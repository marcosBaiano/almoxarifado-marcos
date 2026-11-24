<section id="tab-recebimento" class="tab-content hidden flex flex-col gap-6">
    <div class="bg-indigo-950/20 border border-indigo-500/20 rounded-xl p-4 text-xs text-indigo-300">
        Sessão de recebimento com scanner e staging.
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-7 flex flex-col gap-6">
            <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl">
                <div class="flex justify-between items-center mb-4 border-b border-slate-900 pb-2">
                    <h3 class="text-xs font-bold uppercase text-slate-300">Sessão Ativa de Recebimento</h3>
                    <span id="session-badge-status" class="bg-rose-500/20 text-rose-400 border border-rose-500/30 text-[9px] font-bold px-2.5 py-0.5 rounded">Sessão Fechada</span>
                </div>

                <div id="recv-no-session-pane" class="py-6 text-center">
                    <p class="text-xs text-slate-400 mb-4">Inicie uma nova sessão de recebimento.</p>
                    <button onclick="startNewReceivingSession()" class="px-6 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs">Iniciar Nova Sessão</button>
                </div>

                <div id="recv-active-session-pane" class="hidden flex flex-col gap-4">
                    <div class="grid grid-cols-2 gap-4 bg-slate-900/50 p-3 rounded-lg border border-slate-800/60 text-xs text-slate-400">
                        <div>ID Sessão: <strong id="recv-session-id" class="text-slate-200 code-font">-</strong></div>
                        <div>Abertura: <strong id="recv-session-time" class="text-slate-200">-</strong></div>
                    </div>

                    <div class="relative">
                        <label for="recvBarcodeInput" class="block text-xs font-medium text-slate-400 mb-1">Escanear Código</label>
                        <input type="text" id="recvBarcodeInput" class="w-full bg-slate-900 border-2 border-slate-700 rounded-lg px-4 py-2.5 text-white font-mono text-sm" placeholder="Bipe o código..." autocomplete="off">
                        <div id="recvAutocomplete" class="hidden absolute left-0 right-0 mt-1 bg-slate-950 border border-slate-800 rounded-lg z-50 max-h-48 overflow-y-auto"></div>
                    </div>

                    <div class="flex items-center gap-2 flex-wrap text-[11px] text-slate-400 border-t border-slate-900 pt-3">
                        <button onclick="simulateBipe('7891000123456')" class="bg-slate-900 border border-slate-800 text-[10px] px-2 py-1 rounded text-slate-300 font-mono">Bipar Sensor</button>
                        <button onclick="simulateBipe('7891000789012')" class="bg-slate-900 border border-slate-800 text-[10px] px-2 py-1 rounded text-slate-300 font-mono">Bipar Rolamento</button>
                        <button onclick="simulateBipe('7891000333444')" class="bg-slate-900 border border-slate-800 text-[10px] px-2 py-1 rounded text-slate-300 font-mono">Bipar Cabo</button>
                        <button onclick="simulateBipe('999999')" class="bg-slate-900 border border-slate-800 text-[10px] px-2 py-1 rounded text-amber-400 font-mono">Bipar Novo</button>
                    </div>
                </div>
            </div>

            <div id="recv-cadastro-rapido-container" class="hidden bg-slate-950 border border-slate-800 p-5 rounded-xl flex flex-col gap-4">
                <h4 class="text-xs font-bold text-amber-400 uppercase">Cadastro de Material Não Identificado</h4>
                <form id="recv-rapido-form" onsubmit="saveFastProduct(event)" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block text-slate-400 mb-1">Código de Barras</label>
                        <input type="text" id="rf-barcode" readonly class="w-full bg-slate-900 border border-slate-800 text-amber-400 font-mono p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-slate-400 mb-1">Descrição *</label>
                        <input type="text" id="rf-name" required class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded">
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
                        <button type="button" onclick="cancelFastCadastro()" class="px-4 py-2 rounded text-slate-400 hover:bg-slate-900">Voltar</button>
                        <button type="submit" class="px-5 py-2 rounded bg-emerald-600 hover:bg-emerald-500 text-white font-bold">Salvar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-5 bg-slate-950 border border-slate-800 p-5 rounded-xl flex flex-col h-[520px]">
            <div class="flex justify-between items-center border-b border-slate-900 pb-3 mb-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300">Lista de Staging</h3>
                <span id="staging-counter" class="text-xs bg-slate-900 border border-slate-800 text-slate-300 px-2 py-0.5 rounded font-bold">0 itens</span>
            </div>

            <div id="staging-container" class="flex-1 overflow-y-auto flex flex-col gap-2.5 text-xs"></div>

            <div id="recv-actions-container" class="hidden border-t border-slate-900 pt-4 mt-3 flex justify-between gap-3">
                <button onclick="discardReceivingSession()" class="px-4 py-2.5 rounded-lg border border-slate-800 hover:bg-slate-900 text-slate-400 font-bold text-xs">Descartar Sessão</button>
                <button onclick="commitReceivingSession()" class="px-6 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs">Confirmar e Atualizar Estoque</button>
            </div>
        </div>
    </div>
</section>
