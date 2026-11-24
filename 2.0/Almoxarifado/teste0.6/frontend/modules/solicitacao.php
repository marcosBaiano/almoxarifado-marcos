<section id="tab-solicitacao" class="tab-content hidden flex flex-col gap-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-5 bg-slate-950 border border-slate-800 p-5 rounded-xl flex flex-col gap-4">
            <div class="border-b border-slate-900 pb-2">
                <h3 class="text-xs font-bold uppercase text-slate-300">Nova Solicitação de Material</h3>
            </div>

            <form onsubmit="createMaterialRequest(event)" class="flex flex-col gap-3 text-xs">
                <div>
                    <label class="block text-slate-400 mb-1">Funcionário Solicitante *</label>
                    <input type="text" id="req-solicitante" required class="w-full bg-slate-900 border border-slate-700 text-white p-2.5 rounded">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-400 mb-1">Setor Destino *</label>
                        <select id="req-setor" required class="w-full bg-slate-900 border border-slate-700 text-white p-2.5 rounded"></select>
                    </div>
                    <div>
                        <label class="block text-slate-400 mb-1">Prioridade</label>
                        <select id="req-prioridade" class="w-full bg-slate-900 border border-slate-700 text-white p-2.5 rounded">
                            <option value="ALTA">ALTA</option>
                            <option value="MEDIA" selected>MEDIA</option>
                            <option value="BAIXA">BAIXA</option>
                        </select>
                    </div>
                </div>

                <div class="border-t border-slate-900 pt-3 flex flex-col gap-2">
                    <label class="block text-slate-400 font-bold uppercase text-[10px]">Peças Solicitadas</label>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-2">
                            <select id="req-item-select" class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded"></select>
                        </div>
                        <div>
                            <input type="number" id="req-item-qty" min="1" value="1" class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded code-font text-center">
                        </div>
                    </div>
                    <button type="button" onclick="addItemToRequestList()" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 border border-slate-800 text-[10px] text-slate-300 font-bold rounded">Adicionar Item</button>
                </div>

                <div id="req-added-items-container" class="bg-slate-900/50 p-2.5 rounded-lg border border-slate-800 max-h-24 overflow-y-auto flex flex-col gap-1.5">
                    <div class="text-[10px] text-slate-500 text-center">Nenhum item adicionado.</div>
                </div>

                <div>
                    <label class="block text-slate-400 mb-1">Equipamento / Aplicação</label>
                    <input type="text" id="req-equipamento" class="w-full bg-slate-900 border border-slate-700 text-white p-2 rounded">
                </div>

                <button type="submit" class="mt-2 w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded">Registrar Solicitação</button>
            </form>
        </div>

        <div class="lg:col-span-7 bg-slate-950 border border-slate-800 p-5 rounded-xl flex flex-col h-[520px]">
            <div class="border-b border-slate-900 pb-3 mb-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300">Painel de Separação e Entrega</h3>
            </div>
            <div id="separation-queue-container" class="flex-1 overflow-y-auto flex flex-col gap-3"></div>
        </div>
    </div>
</section>
