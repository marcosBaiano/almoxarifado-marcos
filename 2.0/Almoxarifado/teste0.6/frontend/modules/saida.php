<section id="tab-saida" class="tab-content hidden flex flex-col gap-6">
    <div class="bg-rose-950/20 border border-rose-500/20 rounded-xl p-4 text-xs text-rose-300">
        Módulo de saída direta de materiais.
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-8 flex flex-col gap-6">
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-5">
                <label for="saidaBarcodeInput" class="block text-xs font-medium text-slate-400 mb-1.5">Código de Barras</label>
                <div class="relative">
                    <input type="text" id="saidaBarcodeInput" class="w-full bg-slate-900 border-2 border-slate-700 rounded-lg pl-10 pr-4 py-3 text-white font-mono" placeholder="Aponte o leitor..." autocomplete="off">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="barcode" class="h-5 w-5 text-slate-400" id="saidaBarcodeIcon"></i>
                    </div>
                </div>
                <div id="saidaAutocompleteDropdown" class="hidden absolute left-0 right-0 mt-1 bg-slate-950 border border-slate-800 rounded-lg z-50 max-h-60 overflow-y-auto"></div>
            </div>

            <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 min-h-[340px]">
                <div id="saidaStatePlaceholder" class="flex-1 flex flex-col items-center justify-center text-center p-8">
                    <h3 class="text-base font-semibold text-slate-300">Aguardando Leitura de Saída</h3>
                </div>

                <div id="saidaStateProductFound" class="hidden flex-1 flex flex-col gap-6">
                    <div class="bg-slate-900/50 p-4 rounded-lg border border-slate-800">
                        <div class="flex items-center gap-2">
                            <span id="saidaProdCategory" class="text-[10px] font-bold tracking-wider text-indigo-400 bg-indigo-500/10 border border-indigo-500/20 px-2 py-0.5 rounded uppercase">-</span>
                            <span id="saidaProdID" class="text-[10px] font-mono text-slate-400 bg-slate-900 px-2 py-0.5 rounded">ID: 000</span>
                        </div>
                        <h3 id="saidaProdName" class="text-base font-bold text-white mt-1">Nome do Item</h3>
                        <p class="text-xs text-slate-400 mt-0.5">PN: <strong class="text-slate-200 code-font" id="saidaProdPN">N/A</strong> | Marca: <strong class="text-slate-200" id="saidaProdBrand">N/A</strong></p>
                        <div class="mt-3">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Saldo em Estoque</span>
                            <span id="saidaProdStock" class="text-2xl font-black text-rose-400 code-font">0</span>
                            <span id="saidaProdUnit" class="text-xs text-slate-400 block">UN</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                        <div>
                            <label for="saidaQuantityInput" class="block text-slate-400 font-bold mb-1.5 uppercase tracking-wider">Quantidade *</label>
                            <input type="number" id="saidaQuantityInput" min="0.1" step="any" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-lg font-bold text-white code-font text-center" value="1">
                        </div>
                        <div>
                            <label for="saidaSetorInput" class="block text-slate-400 font-bold mb-1.5 uppercase tracking-wider">Setor *</label>
                            <select id="saidaSetorInput" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-3 text-sm font-semibold text-white"></select>
                        </div>
                        <div class="md:col-span-2">
                            <label for="saidaObsInput" class="block text-slate-400 font-bold mb-1.5 uppercase tracking-wider">Observação</label>
                            <textarea id="saidaObsInput" rows="3" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-slate-200 text-xs"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-900">
                        <button onclick="cancelSaidaDirect()" class="px-6 py-2.5 rounded-lg text-slate-400 hover:bg-slate-900 text-xs font-bold">Cancelar</button>
                        <button id="btnConfirmarSaidaDirect" onclick="executeSaidaDirect()" class="px-8 py-2.5 rounded-lg bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs">Confirmar Baixa</button>
                    </div>
                </div>

                <div id="saidaStateNotFound" class="hidden flex-1 flex flex-col items-center justify-center text-center p-6">
                    <h3 class="text-lg font-bold text-slate-200">Material não localizado</h3>
                    <p class="text-xs text-slate-400 mt-1">Código: <strong class="text-amber-400 code-font" id="saidaMissingCodeSpan">-</strong></p>
                    <button onclick="cancelSaidaDirect()" class="mt-4 px-5 py-2 rounded bg-slate-900 hover:bg-slate-800 text-xs text-slate-300 font-bold border border-slate-800">Voltar e Limpar</button>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 bg-slate-950 border border-slate-800 p-5 rounded-xl flex flex-col h-[520px]">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300 mb-4">Controle de Saldo Crítico</h3>
            <div class="flex-1 overflow-y-auto pr-1 flex flex-col gap-2" id="saidaStockListContainer"></div>
        </div>
    </div>
</section>
