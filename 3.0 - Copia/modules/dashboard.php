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
                        <span class="text-xs text-slate-400 font-medium block">Unidades em Estoque FÃ­sico</span>
                        <span id="dash-stock-sum" class="text-2xl font-black text-emerald-400 code-font">52.0</span>
                        <span class="text-[10px] text-slate-400 block mt-1">Saldo integrado atualizado</span>
                    </div>
                    <div class="bg-emerald-500/10 p-2.5 rounded-lg text-emerald-400 border border-emerald-500/20">
                        <i data-lucide="boxes" class="w-5.5 h-5.5"></i>
                    </div>
                </div>
                <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Estoque Abaixo do MÃ­nimo</span>
                        <span id="dash-low-stock" class="text-2xl font-black text-amber-500 code-font">1</span>
                        <span class="text-[10px] text-amber-400 block mt-1">Requer requisiÃ§Ã£o de compra</span>
                    </div>
                    <div class="bg-amber-500/10 p-2.5 rounded-lg text-amber-500 border border-amber-500/20">
                        <i data-lucide="alert-triangle" class="w-5.5 h-5.5"></i>
                    </div>
                </div>
                <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">SolicitaÃ§Ãµes Pendentes</span>
                        <span id="dash-pending-requests" class="text-2xl font-black text-sky-400 code-font">1</span>
                        <span class="text-[10px] text-sky-400 block mt-1">Aguardando separaÃ§Ã£o / entrega</span>
                    </div>
                    <div class="bg-sky-500/10 p-2.5 rounded-lg text-sky-400 border border-sky-500/20">
                        <i data-lucide="truck" class="w-5.5 h-5.5"></i>
                    </div>
                </div>
            </div>

            <!-- Grids de Acompanhamento em Tempo Real -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Esquerda: Auditoria Unificada de MovimentaÃ§Ãµes -->
                <div class="lg:col-span-8 bg-slate-950 border border-slate-800 p-6 rounded-xl flex flex-col gap-4">
                    <div class="flex justify-between items-center border-b border-slate-900 pb-3">
                        <h3 class="text-xs font-bold tracking-wider text-slate-300 uppercase flex items-center gap-2">
                            <i data-lucide="history" class="w-4 h-4 text-indigo-400"></i>
                            HistÃ³rico Consolidado de MovimentaÃ§Ãµes (RastreÃ¡vel)
                        </h3>
                        <span class="text-[10px] text-slate-500 code-font">Ãšltimos LanÃ§amentos</span>
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
                                <!-- LanÃ§ado dinamicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Direita: Auditoria de SeguranÃ§a e Log de Acessos -->
                <div class="lg:col-span-4 bg-slate-950 border border-slate-800 p-6 rounded-xl flex flex-col gap-4">
                    <div class="border-b border-slate-900 pb-3">
                        <h3 class="text-xs font-bold tracking-wider text-slate-300 uppercase flex items-center gap-2">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                            Trilha de Auditoria Passiva
                        </h3>
                    </div>
                    <div id="dash-audit-container" class="flex-1 overflow-y-auto max-h-[300px] flex flex-col gap-3 text-[10px] code-font">
                        <!--Logs dinÃ¢micos -->
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- MÃ“DULO 2: RECEBIMENTO POR SESSÃ•ES (STAGING) -->
