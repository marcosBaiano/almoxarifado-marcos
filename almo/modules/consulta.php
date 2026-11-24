        <section id="tab-consulta" class="tab-content hidden flex flex-col gap-6">
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 shadow-lg flex flex-col gap-4">
                
                <!-- Barra de Filtros AvanÃ§ados -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5">Busca Inteligente (CÃ³digo, DescriÃ§Ã£o, LocalizaÃ§Ã£o, Marca, Part Number)</label>
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
        <!-- MÃ“DULO 5: IMPORTADOR EXCLUSIVO DA PLANILHA -->
