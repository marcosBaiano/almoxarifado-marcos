<section id="tab-dashboard" class="tab-content flex flex-col gap-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl">
            <span class="text-xs text-slate-400">Materiais Catalogados</span>
            <div id="dash-total-materials" class="text-2xl font-black code-font">0</div>
        </div>
        <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl">
            <span class="text-xs text-slate-400">Unidades em Estoque</span>
            <div id="dash-stock-sum" class="text-2xl font-black code-font text-emerald-400">0.0</div>
        </div>
        <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl">
            <span class="text-xs text-slate-400">Abaixo do Mínimo</span>
            <div id="dash-low-stock" class="text-2xl font-black code-font text-amber-400">0</div>
        </div>
        <div class="bg-slate-950 border border-slate-800 p-5 rounded-xl">
            <span class="text-xs text-slate-400">Solicitações Pendentes</span>
            <div id="dash-pending-requests" class="text-2xl font-black code-font text-sky-400">0</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-8 bg-slate-950 border border-slate-800 p-6 rounded-xl">
            <h3 class="text-xs uppercase text-slate-300 font-bold mb-4">Histórico de Movimentações</h3>
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
                    <tbody id="dash-movements-tbody" class="divide-y divide-slate-900 code-font"></tbody>
                </table>
            </div>
        </div>

        <div class="lg:col-span-4 bg-slate-950 border border-slate-800 p-6 rounded-xl">
            <h3 class="text-xs uppercase text-slate-300 font-bold mb-4">Trilha de Auditoria</h3>
            <div id="dash-audit-container" class="flex flex-col gap-3 text-[10px] code-font"></div>
        </div>
    </div>
</section>
