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
                        <p class="text-[11px] text-slate-400 max-w-sm">O sistema valida automaticamente duplicidades de cÃ³digos, categorias sem vÃ­nculo fiscal e formataÃ§Ã£o de localizaÃ§Ã£o antes da injeÃ§Ã£o.</p>
                        
                        <div class="flex gap-2">
                            <button onclick="simulateSheetImport('valid')" class="px-4 py-2 rounded bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-[11px] transition-all">
                                Simular ImportaÃ§Ã£o VÃ¡lida
                            </button>
                            <button onclick="simulateSheetImport('invalid')" class="px-4 py-2 rounded bg-rose-950/40 border border-rose-500/30 hover:bg-rose-950/60 text-rose-400 font-bold text-[11px] transition-all">
                                Simular ImportaÃ§Ã£o com InconsistÃªncias
                            </button>
                        </div>
                    </div>

                    <!-- ExplicaÃ§Ã£o das RestriÃ§Ãµes e ValidaÃ§Ã£o -->
                    <div class="bg-slate-900/40 border border-slate-850 p-5 rounded-xl flex flex-col gap-3">
                        <span class="font-bold text-slate-300 block">Regras de ValidaÃ§Ã£o do Importador:</span>
                        <ul class="flex flex-col gap-2 text-[11px] text-slate-400">
                            <li class="flex items-start gap-1.5"><i data-lucide="check-circle" class="w-3.5 h-3.5 text-indigo-400 shrink-0"></i> CÃ³digo ITEM deve ser Ãºnico.</li>
                            <li class="flex items-start gap-1.5"><i data-lucide="check-circle" class="w-3.5 h-3.5 text-indigo-400 shrink-0"></i> Categoria deve ser prÃ©-validada na tabela mapeada.</li>
                            <li class="flex items-start gap-1.5"><i data-lucide="check-circle" class="w-3.5 h-3.5 text-indigo-400 shrink-0"></i> LocalizaÃ§Ã£o deve obedecer Ã  sintaxe [PR-A1 ou AL-C2].</li>
                        </ul>
                    </div>
                </div>

                <!-- RelatÃ³rio de ValidaÃ§Ã£o e InconsistÃªncias (Apenas aparece apÃ³s simular) -->
                <div id="import-report-pane" class="hidden mt-6 pt-5 border-t border-slate-900 flex flex-col gap-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-300 flex items-center gap-1.5">
                        <i data-lucide="file-warning" class="w-4 h-4 text-amber-500"></i>
                        RelatÃ³rio TÃ©cnico de InconsistÃªncias da Planilha
                    </h4>
                    <div id="import-report-box" class="p-4 rounded-lg text-xs font-mono max-h-40 overflow-y-auto">
                        <!-- RelatÃ³rio injetado pelo JS -->
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- MÃ“DULO 6: DOCUMENTAÃ‡ÃƒO DE ENGENHARIA DE SOFTWARE -->
