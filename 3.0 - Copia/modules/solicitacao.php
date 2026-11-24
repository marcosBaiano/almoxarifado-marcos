        <section id="tab-solicitacao" class="tab-content hidden flex flex-col gap-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Coluna Esquerda: Abertura de Nova SolicitaÃ§Ã£o de PeÃ§a -->
                <div class="lg:col-span-5 bg-slate-950 border border-slate-800 p-5 rounded-xl flex flex-col gap-4">
                    <div class="border-b border-slate-900 pb-2">
                        <h3 class="text-xs font-bold uppercase text-slate-300 flex items-center gap-2">
                            <i data-lucide="file-text" class="w-4 h-4 text-indigo-400"></i>
                            Nova SolicitaÃ§Ã£o de Material (BalcÃ£o)
                        </h3>
                    </div>
                    
                    <form onsubmit="createMaterialRequest(event)" class="flex flex-col gap-3 text-xs">
                        <div>
                            <label class="block text-slate-400 mb-1">FuncionÃ¡rio Solicitante *</label>
                            <input type="text" id="req-solicitante" required placeholder="Ex: MÃ¡rio Silva (MecÃ¢nica)" class="w-full bg-slate-900 border border-slate-700 text-white p-2.5 rounded focus:outline-none focus:border-indigo-500">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-slate-400 mb-1">Setor Destino *</label>
                                <select id="req-setor" required class="w-full bg-slate-900 border border-slate-700 text-white p-2.5 rounded"></select>
                            </div>
                            <div>
                                <label class="block text-slate-400 mb-1">Prioridade</label>
                                <select id="req-prioridade" class="w-full bg-slate-900 border border-slate-700 text-white p-2.5 rounded">
                                    <option value="ALTA">ðŸš¨ ALTA (MÃ¡quina Parada)</option>
                                    <option value="MEDIA" selected>ðŸŸ¡ MÃ‰DIA (Planejada)</option>
                                    <option value="BAIXA">ðŸŸ¢ BAIXA (Retorno de Lote)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Adicionar item de estoque na solicitaÃ§Ã£o -->
                        <div class="border-t border-slate-900 pt-3 flex flex-col gap-2">
                            <label class="block text-slate-400 font-bold uppercase text-[10px]">PeÃ§as Solicitadas</label>
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
                                <i data-lucide="plus" class="w-3.5 h-3.5"></i> Adicionar Item Ã  Lista
                            </button>
                        </div>

                        <!-- Lista temporÃ¡ria de peÃ§as adicionadas Ã  solicitaÃ§Ã£o -->
                        <div id="req-added-items-container" class="bg-slate-900/50 p-2.5 rounded-lg border border-slate-850 max-h-24 overflow-y-auto flex flex-col gap-1.5">
                            <div class="text-[10px] text-slate-500 text-center">Nenhum item adicionado Ã  lista de requisiÃ§Ã£o.</div>
                        </div>

                        <div>
                            <label class="block text-slate-400 mb-1">Equipamento / AplicaÃ§Ã£o (Opcional)</label>
                            <input type="text" id="req-equipamento" placeholder="Ex: Ponte Rolante 02 - Prensa Weg" class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded">
                        </div>
                        <button type="submit" class="mt-2 w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded shadow-lg shadow-indigo-600/15">
                            Registrar Nova SolicitaÃ§Ã£o
                        </button>
                    </form>
                </div>

                <!-- Coluna Direita: Painel de SeparaÃ§Ã£o & Entrega (EstaÃ§Ãµes de BalcÃ£o) -->
                <div class="lg:col-span-7 bg-slate-950 border border-slate-800 p-5 rounded-xl flex flex-col h-[520px]">
                    <div class="flex justify-between items-center border-b border-slate-900 pb-3 mb-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300 flex items-center gap-2">
                            <i data-lucide="package-check" class="w-4 h-4 text-amber-400"></i>
                            Painel de SeparaÃ§Ã£o, ConferÃªncia & Entrega
                        </h3>
                    </div>

                    <!-- Fila de SolicitaÃ§Ãµes para Despachar -->
                    <div id="separation-queue-container" class="flex-1 overflow-y-auto flex flex-col gap-3">
                        <!-- Injetado dinamicamente via JS -->
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- MÃ“DULO 5: CONSULTA GERAL & AJUSTES FISICOS -->
