<section id="tab-importador" class="tab-content hidden flex flex-col gap-6">
    <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 shadow-lg max-w-4xl mx-auto w-full">
        <h3 class="text-base font-bold text-white mb-4">Importador de Planilhas</h3>
        <p class="text-xs text-slate-400 mb-4">Simulação de validação e importação.</p>

        <div class="flex gap-2">
            <button onclick="simulateSheetImport('valid')" class="px-4 py-2 rounded bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-[11px]">Simular Importação Válida</button>
            <button onclick="simulateSheetImport('invalid')" class="px-4 py-2 rounded bg-rose-950/40 border border-rose-500/30 hover:bg-rose-950/60 text-rose-400 font-bold text-[11px]">Simular Importação com Inconsistências</button>
        </div>

        <div id="import-report-pane" class="hidden mt-6 pt-5 border-t border-slate-900 flex flex-col gap-4">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-300">Relatório Técnico de Importação</h4>
            <div id="import-report-box" class="p-4 rounded-lg text-xs font-mono max-h-40 overflow-y-auto"></div>
        </div>
    </div>
</section>
