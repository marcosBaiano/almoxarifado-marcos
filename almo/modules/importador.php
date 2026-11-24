<section id="tab-importador" class="tab-content hidden flex flex-col gap-6">
    <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 shadow-lg max-w-6xl mx-auto w-full relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-indigo-500"></div>
        <div class="flex items-center gap-3 border-b border-slate-900 pb-4 mb-6">
            <div class="bg-indigo-500/10 p-2.5 rounded text-indigo-400 border border-indigo-500/20"><i data-lucide="file-spreadsheet" class="w-5 h-5"></i></div>
            <div>
                <h3 class="text-base font-bold text-white">Importação e Exportação de Dados</h3>
                <p class="text-xs text-slate-400">Use arquivos CSV: eles podem ser abertos e preenchidos no Excel, LibreOffice ou Google Planilhas.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 text-xs">
            <div class="bg-slate-900/40 border border-slate-800 rounded-xl p-5 flex flex-col gap-4">
                <div>
                    <h4 class="font-bold text-slate-200">Importar tabelas base</h4>
                    <p class="text-[11px] text-slate-400 mt-1">Baixe o modelo, preencha-o e importe. Linhas com a mesma chave são atualizadas; linhas novas são incluídas.</p>
                </div>
                <div>
                    <label class="block text-slate-400 mb-1">Tabela para importação</label>
                    <select id="import-entity" onchange="resetImportPreview()" class="w-full bg-slate-950 border border-slate-700 text-white p-2.5 rounded">
                        <option value="categorias">Categorias</option>
                        <option value="setores">Setores</option>
                        <option value="localizacoes">Localizações</option>
                        <option value="produtos">Produtos</option>
                        <option value="produto_codigos_barras">Códigos de barras adicionais</option>
                    </select>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="downloadDataCsv('modelo')" class="px-3 py-2 rounded bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold">Baixar modelo</button>
                    <button type="button" onclick="downloadDataCsv('dados')" class="px-3 py-2 rounded bg-indigo-600 hover:bg-indigo-500 text-white font-bold">Exportar dados atuais</button>
                </div>
                <label class="border-2 border-dashed border-slate-700 hover:border-indigo-500 bg-slate-950/50 rounded-lg p-5 text-center cursor-pointer transition-colors">
                    <i data-lucide="upload" class="w-7 h-7 text-indigo-400 mx-auto mb-2"></i>
                    <span class="block font-semibold text-slate-200">Selecionar arquivo CSV</span>
                    <span class="block text-[10px] text-slate-500 mt-1">A primeira linha deve conter os nomes das colunas do modelo.</span>
                    <input id="import-csv-file" type="file" accept=".csv,text/csv" class="hidden" onchange="readImportFile(event)">
                </label>
                <button id="import-confirm-button" type="button" onclick="confirmCsvImport()" disabled class="px-4 py-2.5 rounded bg-emerald-700 text-white font-bold disabled:opacity-40 disabled:cursor-not-allowed">Validar e importar arquivo</button>
                <p class="text-[10px] text-amber-400">Ordem recomendada: Categorias → Setores/Localizações → Produtos → Códigos de barras adicionais.</p>
            </div>

            <div class="bg-slate-900/40 border border-slate-800 rounded-xl p-5 flex flex-col gap-4">
                <div>
                    <h4 class="font-bold text-slate-200">Exportar relatórios</h4>
                    <p class="text-[11px] text-slate-400 mt-1">Gere arquivos CSV para análise, conferência ou arquivamento. Nenhum dado é alterado.</p>
                </div>
                <div>
                    <label class="block text-slate-400 mb-1">Relatório</label>
                    <select id="report-entity" class="w-full bg-slate-950 border border-slate-700 text-white p-2.5 rounded">
                        <option value="produtos">Inventário de produtos</option>
                        <option value="movimentacoes">Histórico de movimentações</option>
                        <option value="solicitacoes">Solicitações de materiais</option>
                        <option value="solicitacoes_compra">Solicitações de compra</option>
                        <option value="localizacao_saldos">Saldo por localização</option>
                        <option value="auditoria">Trilha de auditoria</option>
                    </select>
                </div>
                <button type="button" onclick="downloadDataCsv('relatorio')" class="px-4 py-2.5 rounded bg-indigo-600 hover:bg-indigo-500 text-white font-bold">Exportar relatório CSV</button>
                <div class="bg-slate-950 border border-slate-800 rounded-lg p-4 text-[11px] text-slate-400 leading-relaxed">
                    <p class="font-bold text-slate-300 mb-2">Como usar com segurança</p>
                    <ul class="list-disc pl-4 space-y-1">
                        <li>Não altere os títulos das colunas do modelo.</li>
                        <li>Use vírgula ou ponto para decimais; o sistema aceita ambos.</li>
                        <li>Em produtos, a categoria deve já existir e ser escrita exatamente como cadastrada.</li>
                        <li>Confira a prévia antes de confirmar a importação.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="import-report-pane" class="hidden mt-6 pt-5 border-t border-slate-900 flex flex-col gap-3">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-300 flex items-center gap-1.5"><i data-lucide="clipboard-check" class="w-4 h-4 text-amber-500"></i> Resultado da importação</h4>
            <div id="import-report-box" class="p-4 rounded-lg text-xs font-mono max-h-48 overflow-y-auto"></div>
        </div>
        <div id="import-preview-pane" class="hidden mt-5 pt-5 border-t border-slate-900">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-300 mb-3">Prévia do arquivo (primeiras 5 linhas)</h4>
            <div id="import-preview-box" class="overflow-x-auto text-[11px]"></div>
        </div>
    </div>
</section>
