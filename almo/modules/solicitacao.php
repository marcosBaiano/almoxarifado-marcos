        <section id="tab-solicitacao" class="tab-content hidden flex flex-col gap-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Coluna Esquerda: Abertura de Nova SolicitaÃ§Ã£o de PeÃ§a -->
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
                                <i data-lucide="plus" class="w-3.5 h-3.5"></i> Adicionar Item  Lista
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
