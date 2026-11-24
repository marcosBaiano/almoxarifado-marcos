        // Tabelas de Mock e Dados Iniciais (Sincronizado)
        let SECTORES_TABLE = [
            { id: 1, nome: "Usinagem de Grande Porte", codigo: "USI-GP" },
            { id: 2, nome: "Linha de Montagem MecÃ¢nica", codigo: "LMT-MEC" },
            { id: 3, nome: "SubestaÃ§Ã£o Principal ElÃ©trica", codigo: "SUB-ELET" },
            { id: 4, nome: "Utilidades (Caldeiras e Gases)", codigo: "UTI-GASS" },
            { id: 5, nome: "PCM (Planejamento e Controle de Mnt)", codigo: "PCM-GERAL" }
        ];

        const INITIAL_PRODUCTS_SEED = [
            {
                id: 101,
                codigo_interno: "IT-001",
                codigo_barras: "7891000123456",
                nome: "Sensor Indutivo BES M18",
                marca: "Balluff",
                part_number: "BES001A",
                categoria: "ElÃ©trica",
                unidade: "UN",
                localizacao: "PR-A1",
                estoque_atual: 15.0,
                estoque_minimo: 4.0,
                estoque_maximo: 50.0,
                imagem: "https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=200"
            },
            {
                id: 102,
                codigo_interno: "IT-002",
                codigo_barras: "7891000789012",
                nome: "Rolamento de Esferas SKF 6204-2Z",
                marca: "SKF",
                part_number: "6204-2Z",
                categoria: "MecÃ¢nica",
                unidade: "PC",
                localizacao: "PR-B4",
                estoque_atual: 8.0,
                estoque_minimo: 10.0, // Alerta
                estoque_maximo: 80.0,
                imagem: "https://images.unsplash.com/photo-1617791160536-598cf32026fb?auto=format&fit=crop&q=80&w=200"
            },
            {
                id: 103,
                codigo_interno: "IT-003",
                codigo_barras: "7891000456123",
                nome: "VÃ¡lvula Direcional SolenÃ³ide Festo",
                marca: "Festo",
                part_number: "VUVS-L20-M52",
                categoria: "PneumÃ¡tica",
                unidade: "UN",
                localizacao: "PR-A3",
                estoque_atual: 4.0,
                estoque_minimo: 2.0,
                estoque_maximo: 20.0,
                imagem: "https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=200"
            },
            {
                id: 104,
                codigo_interno: "IT-004",
                codigo_barras: "7891000987654",
                nome: "Graxa Alta Temperatura Mobilux EP2",
                marca: "Mobil",
                part_number: "EP2-CARTUCHO",
                categoria: "MecÃ¢nica",
                unidade: "KG",
                localizacao: "AL-C2",
                estoque_atual: 25.0,
                estoque_minimo: 8.0,
                estoque_maximo: 100.0,
                imagem: ""
            }
        ];

        // MemÃ³ria do Banco de Dados Local
        let erpDatabase = {
            produtos: [],
            produtoCodigosBarras: [],
            movimentacoes: [],
            auditoria: [],
            solicitacoes: [],
            sessaoRecebimentoAtiva: null,
            stagingList: []
        };

        // A aba inicial precisa existir antes de qualquer rotina de foco ou atalho.
        let activeTab = 'dashboard';

        async function apiRequest(action, payload = null) {
            const options = payload === null ? {} : {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            };
            const response = await fetch(`api/index.php?action=${encodeURIComponent(action)}`, options);
            const result = await response.json().catch(() => ({}));
            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Não foi possível concluir a operação no servidor.');
            }
            return result;
        }

        async function loadSnapshot() {
            const result = await apiRequest('snapshot');
            const data = result.data;
            erpDatabase.produtos = data.produtos || [];
            erpDatabase.produtoCodigosBarras = data.produtoCodigosBarras || [];
            erpDatabase.movimentacoes = data.movimentacoes || [];
            erpDatabase.auditoria = data.auditoria || [];
            erpDatabase.solicitacoes = data.solicitacoes || [];
            SECTORES_TABLE = data.setores || [];
        }

        async function initErpDatabase() {
            await loadSnapshot();
        }

        // Sessão e staging são apenas estado transitório da tela; o estoque é sempre persistido pela API.
        function saveDatabase() {}

        function normalizeBarcode(barcode) {
            return String(barcode || '').trim();
        }

        function buildInitialProductBarcodes(products) {
            return products
                .filter(p => p.codigo_barras)
                .map((p, index) => ({
                    id: index + 1,
                    produto_id: p.id,
                    codigo_barras: normalizeBarcode(p.codigo_barras),
                    principal: true,
                    origem: 'CADASTRO',
                    criado_em: new Date().toISOString()
                }));
        }

        function migrateProductBarcodes() {
            if (!Array.isArray(erpDatabase.produtoCodigosBarras)) {
                erpDatabase.produtoCodigosBarras = [];
            }

            let changed = false;
            erpDatabase.produtos.forEach(product => {
                const barcode = normalizeBarcode(product.codigo_barras);
                if (!barcode) return;

                const exists = erpDatabase.produtoCodigosBarras.some(item => normalizeBarcode(item.codigo_barras) === barcode);
                if (!exists) {
                    const maxId = erpDatabase.produtoCodigosBarras.reduce((max, item) => item.id > max ? item.id : max, 0);
                    erpDatabase.produtoCodigosBarras.push({
                        id: maxId + 1,
                        produto_id: product.id,
                        codigo_barras: barcode,
                        principal: true,
                        origem: 'MIGRACAO_LOCAL',
                        criado_em: new Date().toISOString()
                    });
                    changed = true;
                }
            });

            if (changed) saveDatabase();
        }

        // ==========================================
        // CAMADA DE REPOSITÃ“RIOS (SQL WRAPPERS)
        // ==========================================
        class ProductRepository {
            static findById(id) {
                return erpDatabase.produtos.find(p => p.id === parseInt(id)) || null;
            }
            static findByBarcode(barcode) {
                const cleanBarcode = normalizeBarcode(barcode);
                if (!cleanBarcode) return null;

                const linkedBarcode = erpDatabase.produtoCodigosBarras.find(item => normalizeBarcode(item.codigo_barras) === cleanBarcode);
                if (linkedBarcode) {
                    return ProductRepository.findById(linkedBarcode.produto_id);
                }

                return erpDatabase.produtos.find(p => normalizeBarcode(p.codigo_barras) === cleanBarcode) || null;
            }
            static getBarcodes(productId) {
                return erpDatabase.produtoCodigosBarras
                    .filter(item => item.produto_id === parseInt(productId))
                    .map(item => item.codigo_barras);
            }
            static addBarcodeAlias(productId, barcode, origem = 'ASSOCIACAO_RECEBIMENTO') {
                const product = ProductRepository.findById(productId);
                const cleanBarcode = normalizeBarcode(barcode);
                if (!product || !cleanBarcode) {
                    return { success: false, message: 'Produto ou codigo de barras invalido.' };
                }

                const existingProduct = ProductRepository.findByBarcode(cleanBarcode);
                if (existingProduct && existingProduct.id !== product.id) {
                    return { success: false, message: `Codigo ja associado ao material ${existingProduct.nome}.` };
                }

                const alreadyLinked = erpDatabase.produtoCodigosBarras.some(item => item.produto_id === product.id && normalizeBarcode(item.codigo_barras) === cleanBarcode);
                if (!alreadyLinked) {
                    const maxId = erpDatabase.produtoCodigosBarras.reduce((max, item) => item.id > max ? item.id : max, 0);
                    erpDatabase.produtoCodigosBarras.push({
                        id: maxId + 1,
                        produto_id: product.id,
                        codigo_barras: cleanBarcode,
                        principal: false,
                        origem,
                        criado_em: new Date().toISOString()
                    });
                    saveDatabase();
                }

                return { success: true, product };
            }
            static findByFreeSearch(query) {
                const q = String(query || '').toLowerCase().trim();
                if (!q) return [];

                return erpDatabase.produtos.filter(p => {
                    const barcodes = ProductRepository.getBarcodes(p.id).join(' ').toLowerCase();
                    return (
                        String(p.nome || '').toLowerCase().includes(q) ||
                        String(p.marca || '').toLowerCase().includes(q) ||
                        String(p.part_number || '').toLowerCase().includes(q) ||
                        String(p.codigo_barras || '').toLowerCase().includes(q) ||
                        String(p.codigo_interno || '').toLowerCase().includes(q) ||
                        barcodes.includes(q)
                    );
                });
            }
            static save(product) {
                if (product.id) {
                    const idx = erpDatabase.produtos.findIndex(p => p.id === product.id);
                    if (idx !== -1) erpDatabase.produtos[idx] = product;
                } else {
                    const maxId = erpDatabase.produtos.reduce((max, p) => p.id > max ? p.id : max, 0);
                    product.id = maxId + 1;
                    product.codigo_interno = `IT-00${product.id}`;
                    erpDatabase.produtos.push(product);
                }
                if (product.codigo_barras) {
                    ProductRepository.addBarcodeAlias(product.id, product.codigo_barras, 'CADASTRO');
                }
                saveDatabase();
                return product;
            }
        }

        class AuditRepository {
            static log(operation, screen, before, after) {
                const maxId = erpDatabase.auditoria.reduce((max, a) => a.id > max ? a.id : max, 0);
                const item = {
                    id: maxId + 1,
                    usuario_id: 104,
                    ip_address: "192.168.10.45",
                    computador_nome: "MNT-W10-04",
                    tela: screen,
                    operacao: operation,
                    valor_anterior: String(before),
                    valor_novo: String(after),
                    data_hora: new Date().toISOString()
                };
                erpDatabase.auditoria.push(item);
                saveDatabase();
            }
            static getLatestLogs(limit = 10) {
                return [...erpDatabase.auditoria].sort((a,b) => b.id - a.id).slice(0, limit);
            }
        }

        // ==========================================
        // APIS EXTERNAS LOOKUP (INTERFACES / PROVIDERS)
        // ==========================================
        class GoogleMerchantProvider {
            static async lookup(barcode) {
                await new Promise(resolve => setTimeout(resolve, 300));
                if (barcode === "7891000111222") {
                    return {
                        codigo_barras: "7891000111222",
                        nome: "Motor Weg TrifÃ¡sico IP55 2CV",
                        marca: "WEG",
                        part_number: "W22-2HP",
                        categoria: "MecÃ¢nica",
                        unidade: "UN",
                        localizacao: "PR-M2"
                    };
                }
                return null;
            }
        }

        class BrasilApiProvider {
            static async lookup(barcode) {
                await new Promise(resolve => setTimeout(resolve, 400));
                if (barcode === "7891000333444") {
                    return {
                        codigo_barras: "7891000333444",
                        nome: "Cabo FlexÃ­vel Prysmian 10mmÂ² PT",
                        marca: "Prysmian",
                        part_number: "PRY-HEP-10",
                        categoria: "ElÃ©trica",
                        unidade: "MT",
                        localizacao: "AL-E1"
                    };
                }
                return null;
            }
        }

        // Service Pipeline lookup
        class ProductPipelineService {
            static async identify(barcode, updateUIStatus = () => {}) {
                updateUIStatus('LOCAL', 'pending');
                let product = ProductRepository.findByBarcode(barcode);
                if (product) {
                    updateUIStatus('LOCAL', 'success');
                    return { source: 'LOCAL', product };
                }
                updateUIStatus('LOCAL', 'fail');

                updateUIStatus('MERCHANT', 'pending');
                product = await GoogleMerchantProvider.lookup(barcode);
                if (product) {
                    updateUIStatus('MERCHANT', 'success');
                    return { source: 'MERCHANT_API', product };
                }
                updateUIStatus('MERCHANT', 'fail');

                updateUIStatus('BRASIL', 'pending');
                product = await BrasilApiProvider.lookup(barcode);
                if (product) {
                    updateUIStatus('BRASIL', 'success');
                    return { source: 'BRASIL_API', product };
                }
                updateUIStatus('BRASIL', 'fail');

                updateUIStatus('MANUAL', 'pending');
                return { source: 'NONE', product: null };
            }
        }

        // ==========================================
        // FLUXO DE RECEBIMENTO POR SESSÃ•ES (STAGING)
        // ==========================================
        function startNewReceivingSession() {
            const id = `RECV-2026-00${erpDatabase.movimentacoes.length + 1}`;
            erpDatabase.sessaoRecebimentoAtiva = id;
            erpDatabase.stagingList = [];
            saveDatabase();

            addToast("SessÃ£o de recebimento iniciada!", "success");
            refreshUI();
            
            setTimeout(() => {
                const input = document.getElementById('recvBarcodeInput');
                if (input) input.focus();
            }, 100);
        }

        let pendingBarcodeAssociation = null;

        async function simulateBipe(barcode) {
            if (!erpDatabase.sessaoRecebimentoAtiva) {
                addToast("Ã‰ necessÃ¡rio abrir uma sessÃ£o de recebimento primeiro.", "warning");
                return;
            }

            const loaderStatus = (step, status) => {
                // EmulaÃ§Ã£o silenciosa de interface
            };

            const result = await ProductPipelineService.identify(barcode, loaderStatus);

            if (result.source !== 'NONE' && result.product) {
                addProdToStagingList(result.product, 1);
            } else {
                openBarcodeAssociation(barcode);
            }
        }

        function addProdToStagingList(product, qty) {
            const existing = erpDatabase.stagingList.find(item => item.product.id === product.id);
            if (existing) {
                existing.quantidade += parseFloat(qty);
            } else {
                erpDatabase.stagingList.push({
                    product: product,
                    quantidade: parseFloat(qty),
                    novo: false
                });
            }
            saveDatabase();
            refreshUI();
            addToast(`Item adicionado: ${product.nome} (Qtd: ${qty})`, "info");
        }

        function openBarcodeAssociation(barcode) {
            pendingBarcodeAssociation = normalizeBarcode(barcode);
            cancelFastCadastro();

            const container = document.getElementById('recv-associacao-barcode-container');
            const barcodeInput = document.getElementById('assoc-barcode');
            const productSelect = document.getElementById('assoc-product-select');
            const searchInput = document.getElementById('assoc-product-search');

            if (!container || !barcodeInput || !productSelect) {
                addToast("Tela de associacao indisponivel para este recebimento.", "error");
                return;
            }

            barcodeInput.value = pendingBarcodeAssociation;
            if (searchInput) searchInput.value = '';
            populateBarcodeAssociationProducts();
            container.classList.remove('hidden');

            setTimeout(() => {
                if (searchInput) searchInput.focus();
            }, 50);
        }

        function populateBarcodeAssociationProducts(query = '') {
            const productSelect = document.getElementById('assoc-product-select');
            if (!productSelect) return;

            const products = query ? ProductRepository.findByFreeSearch(query) : erpDatabase.produtos;
            productSelect.innerHTML = '';

            if (products.length === 0) {
                const opt = document.createElement('option');
                opt.value = '';
                opt.innerText = 'Nenhum produto localizado';
                productSelect.appendChild(opt);
                return;
            }

            products.forEach(product => {
                const opt = document.createElement('option');
                opt.value = product.id;
                opt.innerText = `${product.codigo_interno || `ID ${product.id}`} - ${product.nome} | ${product.marca} | ${product.codigo_barras}`;
                productSelect.appendChild(opt);
            });
        }

        function filterBarcodeAssociationProducts() {
            const searchInput = document.getElementById('assoc-product-search');
            populateBarcodeAssociationProducts(searchInput ? searchInput.value : '');
        }

        function cancelBarcodeAssociation() {
            pendingBarcodeAssociation = null;
            const container = document.getElementById('recv-associacao-barcode-container');
            if (container) container.classList.add('hidden');
            refocusScannerField();
        }

        async function saveBarcodeAssociation(e) {
            e.preventDefault();

            const productId = document.getElementById('assoc-product-select').value;
            const barcode = pendingBarcodeAssociation || document.getElementById('assoc-barcode').value;
            try {
                await apiRequest('barcode_associar', { produto_id: Number(productId), codigo_barras: barcode });
                await loadSnapshot();
                const product = ProductRepository.findById(productId);
                addProdToStagingList(product, 1);
                cancelBarcodeAssociation();
                addToast(`Codigo ${barcode} associado a ${product.nome}. Operacao continuada automaticamente.`, "success");
            } catch (error) {
                addToast(error.message, "error");
            }
        }

        function openFastCadastro(barcode) {
            cancelBarcodeAssociation();
            document.getElementById('recv-cadastro-rapido-container').classList.remove('hidden');
            document.getElementById('rf-barcode').value = barcode;
            document.getElementById('rf-name').value = '';
            document.getElementById('rf-brand').value = '';
            
            setTimeout(() => {
                document.getElementById('rf-name').focus();
            }, 50);
        }

        function cancelFastCadastro() {
            document.getElementById('recv-cadastro-rapido-container').classList.add('hidden');
            // Retorna o foco para o scanner principal apÃ³s cancelar
            refocusScannerField();
        }

        async function saveFastProduct(e) {
            e.preventDefault();
            const bar = document.getElementById('rf-barcode').value;
            const name = document.getElementById('rf-name').value;
            const brand = document.getElementById('rf-brand').value;
            const cat = document.getElementById('rf-category').value;

            const product = {
                codigo_barras: bar,
                nome: name,
                marca: brand,
                categoria: cat,
                unidade: 'UN',
                estoque_atual: 0.0,
                estoque_minimo: 2.0,
                estoque_maximo: 20.0,
                localizacao: 'STAGING-AL'
            };

            try {
                const result = await apiRequest('produto_salvar', product);
                await loadSnapshot();
                const saved = ProductRepository.findById(result.id);
                addProdToStagingList(saved, 1);
                cancelFastCadastro();
                addToast("Material cadastrado de forma Ã¡gil no meio da sessÃ£o!", "success");
            } catch (error) {
                addToast(error.message, "error");
            }
        }

        // Commit da sessÃ£o de recebimento (Efetiva saldo no estoque fÃ­sico real)
        async function commitReceivingSession() {
            if (erpDatabase.stagingList.length === 0) {
                addToast("Ãrea de staging estÃ¡ vazia. NÃ£o hÃ¡ itens para dar commit.", "warning");
                return;
            }

            try {
                await apiRequest('recebimento_commit', {
                    sessao_recebimento: erpDatabase.sessaoRecebimentoAtiva,
                    items: erpDatabase.stagingList.map(item => ({ produto_id: item.product.id, quantidade: item.quantidade }))
                });
                erpDatabase.sessaoRecebimentoAtiva = null;
                erpDatabase.stagingList = [];
                await loadSnapshot();
                refreshUI();
                addToast("Lote conferido e integrado ao estoque com sucesso!", "success");
            } catch (err) {
                addToast(err.message, "error");
            }
        }

        function discardReceivingSession() {
            erpDatabase.sessaoRecebimentoAtiva = null;
            erpDatabase.stagingList = [];
            saveDatabase();
            refreshUI();
            addToast("SessÃ£o descartada sem alteraÃ§Ãµes de estoque.", "info");
        }

        // ==========================================
        // MÃ“DULO 3: SAÃDA DIRETA DE MATERIAIS
        // ==========================================
        let currentSaidaProduct = null;

        async function triggerSaidaPipelineSearch(code) {
            const cleanCode = String(code).trim();
            if (!cleanCode) return;

            document.getElementById('saidaAutocompleteDropdown').classList.add('hidden');
            
            // Simular progresso do pipeline visualmente
            document.getElementById('saidaBarcodeIcon').className = "h-5 w-5 text-rose-500 animate-spin";
            
            // Procura na base local e APIs de simulaÃ§Ã£o
            const result = await ProductPipelineService.identify(cleanCode, () => {});
            
            document.getElementById('saidaBarcodeIcon').className = "h-5 w-5 text-slate-400";

            if (result.product) {
                selectProductForSaida(result.product);
            } else {
                document.getElementById('saidaMissingCodeSpan').innerText = cleanCode;
                showSaidaState('NOT_FOUND');
            }
        }

        function selectProductForSaida(product) {
            currentSaidaProduct = product;
            
            document.getElementById('saidaProdID').innerText = `ID: ${product.id}`;
            document.getElementById('saidaProdName').innerText = product.nome;
            document.getElementById('saidaProdPN').innerText = product.part_number || "N/A";
            document.getElementById('saidaProdBrand').innerText = product.marca;
            document.getElementById('saidaProdStock').innerText = product.estoque_atual;
            document.getElementById('saidaProdUnit').innerText = product.unidade;
            document.getElementById('saidaProdCategory').innerText = product.categoria;

            document.getElementById('saidaQuantityInput').value = 1;
            document.getElementById('saidaSolicitanteInput').value = '';
            document.getElementById('saidaEquipamentoInput').value = '';
            document.getElementById('saidaObsInput').value = '';
            updateSaidaResumoFromMovementData();

            showSaidaState('PRODUCT_FOUND');

            setTimeout(() => {
                document.getElementById('saidaQuantityInput').focus();
                document.getElementById('saidaQuantityInput').select();
            }, 50);
        }

        async function executeSaidaDirect() {
            if (!currentSaidaProduct) return;

            syncSaidaMovementDataFromResumo();

            const qty = parseFloat(document.getElementById('saidaQuantityInput').value) || 0;
            const sectorId = document.getElementById('saidaSetorInput').value;
            const solicitante = document.getElementById('saidaSolicitanteInput').value.trim();
            const equipamento = document.getElementById('saidaEquipamentoInput').value.trim();
            const obs = document.getElementById('saidaObsInput').value.trim();

            if (qty <= 0) {
                addToast("A quantidade de retirada deve ser maior que zero.", "error");
                return;
            }

            if (!sectorId) {
                addToast("Selecione um setor de destino para a baixa.", "error");
                return;
            }

            try {
                await apiRequest('saida_direta', {
                    produto_id: currentSaidaProduct.id,
                    quantidade: qty,
                    setor_id: Number(sectorId),
                    solicitante,
                    equipamento,
                    observacao: obs
                });
                await loadSnapshot();
                addToast(`Sucesso! ${qty} ${currentSaidaProduct.unidade} do material foram retirados do estoque.`, "success");
                cancelSaidaDirect();
            } catch (error) {
                addToast(error.message, "error");
            }
        }

        function cancelSaidaDirect() {
            currentSaidaProduct = null;
            document.getElementById('saidaBarcodeInput').value = '';
            document.getElementById('saidaQuantityInput').value = 1;
            document.getElementById('saidaSolicitanteInput').value = '';
            document.getElementById('saidaEquipamentoInput').value = '';
            document.getElementById('saidaObsInput').value = '';
            updateSaidaResumoFromMovementData();
            showSaidaState('PLACEHOLDER');
            refreshUI();
            
            setTimeout(() => {
                document.getElementById('saidaBarcodeInput').focus();
            }, 50);
        }

        function showSaidaState(state) {
            document.getElementById('saidaStatePlaceholder').classList.add('hidden');
            document.getElementById('saidaStateProductFound').classList.add('hidden');
            document.getElementById('saidaStateNotFound').classList.add('hidden');

            if (state === 'PLACEHOLDER') document.getElementById('saidaStatePlaceholder').classList.remove('hidden');
            if (state === 'PRODUCT_FOUND') document.getElementById('saidaStateProductFound').classList.remove('hidden');
            if (state === 'NOT_FOUND') document.getElementById('saidaStateNotFound').classList.remove('hidden');
        }

        function getSaidaSectorName() {
            const select = document.getElementById('saidaSetorInput');
            if (!select || !select.value) return '';
            const option = select.options[select.selectedIndex];
            return option ? option.innerText : '';
        }

        function setEditableText(id, value) {
            const el = document.getElementById(id);
            if (el) el.innerText = value || '';
        }

        function getEditableText(id) {
            const el = document.getElementById(id);
            return el ? el.innerText.trim() : '';
        }

        function updateSaidaResumoFromMovementData() {
            const product = currentSaidaProduct;
            const qty = document.getElementById('saidaQuantityInput') ? document.getElementById('saidaQuantityInput').value : '';
            const solicitante = document.getElementById('saidaSolicitanteInput') ? document.getElementById('saidaSolicitanteInput').value : '';
            const equipamento = document.getElementById('saidaEquipamentoInput') ? document.getElementById('saidaEquipamentoInput').value : '';
            const stock = product ? parseFloat(product.estoque_atual) : 0;
            const parsedQty = parseFloat(qty) || 0;
            const posterior = Math.max(stock - parsedQty, 0);

            setEditableText('saidaResumoProduto', product ? product.nome : '');
            setEditableText('saidaResumoQuantidade', qty || '1');
            setEditableText('saidaResumoSolicitante', solicitante);
            setEditableText('saidaResumoEquipamento', equipamento);
            setEditableText('saidaResumoSaldoAtual', product ? `${stock} ${product.unidade}` : '-');
            setEditableText('saidaResumoSaldoPosBaixa', product ? `${posterior} ${product.unidade}` : '-');
        }

        function syncSaidaMovementDataFromResumo() {
            const qty = getEditableText('saidaResumoQuantidade').replace(',', '.');
            const parsedQty = parseFloat(qty);
            if (!Number.isNaN(parsedQty) && parsedQty > 0) {
                document.getElementById('saidaQuantityInput').value = parsedQty;
            }

            document.getElementById('saidaSolicitanteInput').value = getEditableText('saidaResumoSolicitante');
            document.getElementById('saidaEquipamentoInput').value = getEditableText('saidaResumoEquipamento');
            updateSaidaResumoFromMovementData();
        }

        function setupSaidaResumoSync() {
            ['saidaQuantityInput', 'saidaSolicitanteInput', 'saidaEquipamentoInput', 'saidaSetorInput'].forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;
                el.addEventListener('input', updateSaidaResumoFromMovementData);
                el.addEventListener('change', updateSaidaResumoFromMovementData);
            });

            ['saidaResumoQuantidade', 'saidaResumoSolicitante', 'saidaResumoEquipamento'].forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;
                el.addEventListener('blur', syncSaidaMovementDataFromResumo);
                el.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        el.blur();
                    }
                });
            });
        }

        function populateSaidaSectors() {
            const select = document.getElementById('saidaSetorInput');
            if (!select) return;
            select.innerHTML = '<option value="">-- Selecione o Setor Requisitante --</option>';
            SECTORES_TABLE.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id;
                opt.innerText = `${s.codigo} - ${s.nome}`;
                select.appendChild(opt);
            });
        }

        function renderSaidaStockList() {
            const container = document.getElementById('saidaStockListContainer');
            if (!container) return;
            container.innerHTML = '';
            
            erpDatabase.produtos.forEach(p => {
                const isUnderMin = p.estoque_atual < p.estoque_minimo;
                const card = document.createElement('div');
                card.className = `p-3 rounded-lg border text-xs flex justify-between items-center transition-all cursor-pointer ${isUnderMin ? 'bg-amber-950/20 border-amber-500/40 hover:bg-amber-950/30' : 'bg-slate-900 border-slate-800 hover:bg-slate-850'}`;
                
                card.innerHTML = `
                    <div class="flex-1 min-w-0 pr-2">
                        <div class="font-bold text-slate-100 truncate">${p.nome}</div>
                        <div class="text-[10px] text-slate-400 font-mono truncate">
                            PN: ${p.part_number || 'Sem PN'} <span class="text-slate-700">|</span> Loc: ${p.localizacao}
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="text-xs font-bold code-font ${isUnderMin ? 'text-amber-400' : 'text-rose-400'}">${p.estoque_atual} ${p.unidade}</span>
                    </div>
                `;
                
                card.addEventListener('click', () => {
                    selectProductForSaida(p);
                });
                container.appendChild(card);
            });
        }

        // ==========================================
        // SOLICITAÃ‡ÃƒO & PAINEL DE SEPARAÃ‡ÃƒO (ESTAÃ‡Ã•ES)
        // ==========================================
        let tempAddedItems = []; // Itens em rascunho na solicitaÃ§Ã£o de balcÃ£o

        function addItemToRequestList() {
            const select = document.getElementById('req-item-select');
            const qtyInput = document.getElementById('req-item-qty');
            const id = select.value;
            const qty = parseFloat(qtyInput.value) || 1;

            if (!id) return;
            const p = ProductRepository.findById(id);
            if (!p) return;

            const existing = tempAddedItems.find(item => item.product_id === p.id);
            if (existing) {
                existing.quantidade_solicitada += qty;
            } else {
                tempAddedItems.push({
                    product_id: p.id,
                    nome: p.nome,
                    quantidade_solicitada: qty
                });
            }

            renderTempRequestItems();
        }

        function renderTempRequestItems() {
            const container = document.getElementById('req-added-items-container');
            container.innerHTML = '';
            if (tempAddedItems.length === 0) {
                container.innerHTML = `<div class="text-[10px] text-slate-500 text-center">Nenhum item adicionado Ã  lista.</div>`;
                return;
            }
            tempAddedItems.forEach((item, idx) => {
                container.innerHTML += `
                    <div class="flex justify-between items-center bg-slate-900 px-2 py-1 rounded border border-slate-800 text-[11px]">
                        <span>${item.nome}</span>
                        <div class="flex items-center gap-2 font-mono font-bold">
                            <span class="text-indigo-400">${item.quantidade_solicitada} UN</span>
                            <button type="button" onclick="removeTempItem(${idx})" class="text-rose-400 hover:text-rose-300"><i data-lucide="trash" class="w-3.5 h-3.5"></i></button>
                        </div>
                    </div>
                `;
            });
            lucide.createIcons();
        }

        function removeTempItem(idx) {
            tempAddedItems.splice(idx, 1);
            renderTempRequestItems();
        }

        async function createMaterialRequest(e) {
            e.preventDefault();
            if (tempAddedItems.length === 0) {
                addToast("Ã‰ necessÃ¡rio adicionar pelo menos um material Ã  requisiÃ§Ã£o.", "warning");
                return;
            }

            const solicitante = document.getElementById('req-solicitante').value;
            const setorId = document.getElementById('req-setor').value;
            const prioridade = document.getElementById('req-prioridade').value;
            const equip = document.getElementById('req-equipamento').value;

            try {
                await apiRequest('solicitacao_criar', {
                    solicitante,
                    setor_id: Number(setorId),
                    equipamento: equip || null,
                    prioridade,
                    itens: tempAddedItems.map(item => ({ produto_id: item.product_id, quantidade_solicitada: item.quantidade_solicitada }))
                });
                document.getElementById('req-solicitante').value = '';
                document.getElementById('req-equipamento').value = '';
                tempAddedItems = [];
                renderTempRequestItems();
                await loadSnapshot();
                refreshUI();
                addToast(`Solicitação registrada com prioridade ${prioridade}!`, "success");
            } catch (error) {
                addToast(error.message, "error");
            }
        }

        // ExecuÃ§Ã£o de SeparaÃ§Ã£o e Entrega (Despacho de BalcÃ£o)
        async function deliverRequest(reqId) {
            const req = erpDatabase.solicitacoes.find(s => s.id === parseInt(reqId));
            if (!req) return;

            try {
                await apiRequest('solicitacao_entregar', { solicitacao_id: req.id });
                await loadSnapshot();
                refreshUI();
                addToast(`SolicitaÃ§Ã£o ${req.numero_solicitacao} entregue com sucesso! Estoque atualizado.`, "success");
            } catch (error) {
                addToast(error.message, "error");
            }
        }

        // ==========================================
        // CONSULTAS, AJUSTES E FILTROS
        // ==========================================
        function filterInventory() {
            const q = document.getElementById('search-query').value.toLowerCase().trim();
            const cat = document.getElementById('search-category').value;
            const status = document.getElementById('search-status').value;

            const list = erpDatabase.produtos;
            const tbody = document.getElementById('inventory-table-tbody');
            if(!tbody) return;
            tbody.innerHTML = '';

            const filtered = list.filter(p => {
                const barcodes = ProductRepository.getBarcodes(p.id).join(' ').toLowerCase();
                const matchesText = !q || p.nome.toLowerCase().includes(q) || p.marca.toLowerCase().includes(q) || p.codigo_barras.includes(q) || barcodes.includes(q) || p.localizacao.toLowerCase().includes(q);
                const matchesCat = cat === 'TODAS' || p.categoria === cat;
                
                let matchesStatus = true;
                if (status === 'NORMAL') matchesStatus = p.estoque_atual >= p.estoque_minimo;
                if (status === 'BAIXO') matchesStatus = p.estoque_atual < p.estoque_minimo && p.estoque_atual > 0;
                if (status === 'ZERADO') matchesStatus = p.estoque_atual <= 0;

                return matchesText && matchesCat && matchesStatus;
            });

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="8" class="py-8 text-center text-slate-500">Nenhum registro localizado nos parÃ¢metros de pesquisa.</td></tr>`;
                return;
            }

            filtered.forEach(p => {
                const barcodes = ProductRepository.getBarcodes(p.id);
                const secondaryBarcodes = barcodes.filter(code => code !== p.codigo_barras);
                let statusBadge = '🟢 Normal';
                let rowBgClass = 'hover:bg-slate-900/30';
                if (p.estoque_atual <= 0) {
                    statusBadge = '🔴 Zerado';
                    rowBgClass = 'bg-rose-950/10 hover:bg-rose-950/20';
                } else if (p.estoque_atual < p.estoque_minimo) {
                    statusBadge = '🟡 Baixo';
                    rowBgClass = 'bg-amber-950/10 hover:bg-amber-950/20';
                }

                tbody.innerHTML += `
                    <tr class="${rowBgClass} transition-all">
                        <td class="py-3 px-2 font-mono text-slate-400">
                            ID: ${p.id}<br>
                            <span class="text-[10px] text-slate-500">${p.codigo_barras}</span>
                            ${secondaryBarcodes.length ? `<br><span class="text-[10px] text-amber-400">+${secondaryBarcodes.length} cod. associado(s)</span>` : ''}
                        </td>
                        <td class="py-3 px-2">
                            <span class="font-bold text-slate-200 block text-xs">${p.nome}</span>
                            <span class="text-[10px] text-slate-500 block">Marca: ${p.marca} | PN: ${p.part_number || 'Sem Part Number'}</span>
                        </td>
                        <td class="py-3 px-2 text-slate-400 font-semibold">${p.categoria}</td>
                        <td class="py-3 px-2 font-mono text-slate-400">${p.localizacao || 'N/A'}</td>
                        <td class="py-3 px-2 text-right font-bold code-font text-white">${p.estoque_atual} <span class="text-[10px] text-slate-500 font-normal">${p.unidade}</span></td>
                        <td class="py-3 px-2 text-right text-slate-500 font-mono">${p.estoque_minimo}</td>
                        <td class="py-3 px-2 text-center font-bold text-[11px]">${statusBadge}</td>
                        <td class="py-3 px-2 text-center">
                            <button onclick="openAjusteModal(${p.id})" title="Ajuste Seguro de InventÃ¡rio" class="p-1.5 rounded bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/20 transition-all">
                                <i data-lucide="sliders" class="w-3.5 h-3.5"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            lucide.createIcons();
        }

        function openAjusteModal(id) {
            const p = ProductRepository.findById(id);
            if (!p) return;

            document.getElementById('ajusteModal').classList.remove('hidden');
            document.getElementById('ajuste-prod-id').value = p.id;
            document.getElementById('ajuste-prod-name').innerText = p.nome;
            document.getElementById('ajuste-prod-stock-current').value = `${p.estoque_atual} ${p.unidade}`;
            document.getElementById('ajuste-prod-stock-new').value = p.estoque_atual;
            document.getElementById('ajuste-prod-reason').value = '';
        }

        function closeAjusteModal() {
            document.getElementById('ajusteModal').classList.add('hidden');
        }

        async function saveAjusteEstoque(e) {
            e.preventDefault();
            const id = document.getElementById('ajuste-prod-id').value;
            const newStock = parseFloat(document.getElementById('ajuste-prod-stock-new').value);
            const reason = document.getElementById('ajuste-prod-reason').value;

            if (newStock < 0) {
                addToast("Saldo de estoque nÃ£o pode ser negativo.", "error");
                return;
            }

            if (ProductRepository.findById(id)) {
                try {
                    await apiRequest('estoque_ajustar', {
                        produto_id: Number(id),
                        estoque_atual: newStock,
                        observacao: reason
                    });
                    await loadSnapshot();
                    closeAjusteModal();
                    refreshUI();
                    addToast("Ajuste fÃ­sico de saldo gravado com auditoria com sucesso!", "success");
                } catch (error) {
                    addToast(error.message, "error");
                }
            }
        }

        // ==========================================
        // MÓDULO 5: IMPORTAÇÃO E EXPORTAÇÃO CSV
        // ==========================================
        let importCsvRows = [];

        function resetImportPreview() {
            importCsvRows = [];
            const input = document.getElementById('import-csv-file');
            if (input) input.value = '';
            const preview = document.getElementById('import-preview-pane');
            const confirm = document.getElementById('import-confirm-button');
            if (preview) preview.classList.add('hidden');
            if (confirm) confirm.disabled = true;
        }

        function downloadDataCsv(kind) {
            const entity = kind === 'relatorio'
                ? document.getElementById('report-entity').value
                : document.getElementById('import-entity').value;
            const mode = kind === 'modelo' ? 'modelo' : 'dados';
            window.location.href = `api/index.php?action=exportar_csv&entidade=${encodeURIComponent(entity)}&modo=${encodeURIComponent(mode)}`;
        }

        function parseCsv(text) {
            const rows = [];
            let row = [], cell = '', quoted = false;
            const source = text.replace(/^\uFEFF/, '');
            const firstLine = source.split(/\r?\n/, 1)[0] || '';
            const separator = firstLine.includes(';') ? ';' : ',';
            for (let i = 0; i < source.length; i++) {
                const char = source[i];
                if (char === '"') {
                    if (quoted && source[i + 1] === '"') { cell += '"'; i++; }
                    else quoted = !quoted;
                } else if (!quoted && char === separator) {
                    row.push(cell.trim()); cell = '';
                } else if (!quoted && (char === '\n' || char === '\r')) {
                    if (char === '\r' && source[i + 1] === '\n') i++;
                    row.push(cell.trim());
                    if (row.some(value => value !== '')) rows.push(row);
                    row = []; cell = '';
                } else cell += char;
            }
            row.push(cell.trim());
            if (row.some(value => value !== '')) rows.push(row);
            return rows;
        }

        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, char => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[char]));
        }

        function readImportFile(event) {
            const file = event.target.files && event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = () => {
                const lines = parseCsv(String(reader.result || ''));
                const report = document.getElementById('import-report-pane');
                const box = document.getElementById('import-report-box');
                if (lines.length < 2) {
                    importCsvRows = [];
                    document.getElementById('import-confirm-button').disabled = true;
                    report.classList.remove('hidden');
                    box.className = 'p-4 rounded-lg text-xs font-mono bg-rose-950/20 border border-rose-500/30 text-rose-300';
                    box.textContent = 'O arquivo deve conter cabeçalho e pelo menos uma linha de dados.';
                    return;
                }
                const headers = lines[0].map(header => header.trim().toLowerCase());
                importCsvRows = lines.slice(1).map((line, index) => {
                    const record = { __linha: index + 2 };
                    headers.forEach((header, column) => { record[header] = line[column] ?? ''; });
                    return record;
                });
                const previewBox = document.getElementById('import-preview-box');
                previewBox.innerHTML = `<table class="w-full text-left"><thead><tr class="border-b border-slate-700 text-slate-400">${headers.map(h => `<th class="p-2">${escapeHtml(h)}</th>`).join('')}</tr></thead><tbody>${importCsvRows.slice(0, 5).map(record => `<tr class="border-b border-slate-800">${headers.map(h => `<td class="p-2 text-slate-300">${escapeHtml(record[h])}</td>`).join('')}</tr>`).join('')}</tbody></table>`;
                document.getElementById('import-preview-pane').classList.remove('hidden');
                document.getElementById('import-confirm-button').disabled = false;
                report.classList.remove('hidden');
                box.className = 'p-4 rounded-lg text-xs font-mono bg-indigo-950/20 border border-indigo-500/30 text-indigo-200';
                box.textContent = `${file.name}: ${importCsvRows.length} linha(s) pronta(s) para validação.`;
            };
            reader.readAsText(file, 'UTF-8');
        }

        async function confirmCsvImport() {
            if (!importCsvRows.length) return;
            const entity = document.getElementById('import-entity').value;
            const button = document.getElementById('import-confirm-button');
            const report = document.getElementById('import-report-pane');
            const box = document.getElementById('import-report-box');
            button.disabled = true;
            button.textContent = 'Importando...';
            try {
                const result = await apiRequest('importar_csv', { entidade: entity, linhas: importCsvRows });
                report.classList.remove('hidden');
                box.className = 'p-4 rounded-lg text-xs font-mono bg-emerald-950/20 border border-emerald-500/30 text-emerald-300';
                box.textContent = result.message;
                addToast(result.message, 'success');
                resetImportPreview();
                await loadSnapshot();
                refreshUI();
            } catch (error) {
                report.classList.remove('hidden');
                box.className = 'p-4 rounded-lg text-xs font-mono bg-rose-950/20 border border-rose-500/30 text-rose-300';
                box.textContent = `Importação cancelada: ${error.message}`;
                addToast(error.message, 'error');
            } finally {
                button.disabled = importCsvRows.length === 0;
                button.textContent = 'Validar e importar arquivo';
            }
        }

        // ==========================================
        // RENDERIZADORES DE TABELAS E SECTIONS
        // ==========================================
        function refreshUI() {
            renderDashboard();
            renderStagingList();
            renderSeparationQueue();
            renderSaidaStockList();
            filterInventory();
            populateSolicitacoesDropdowns();
        }

        function renderDashboard() {
            const list = erpDatabase.produtos;
            const moves = erpDatabase.movimentacoes;

            // Indicadores
            document.getElementById('dash-total-materials').innerText = list.length;
            const totalStock = list.reduce((sum, p) => sum + parseFloat(p.estoque_atual), 0);
            document.getElementById('dash-stock-sum').innerText = totalStock.toFixed(1);

            const lowCount = list.filter(p => p.estoque_atual < p.estoque_minimo && p.estoque_atual > 0).length;
            document.getElementById('dash-low-stock').innerText = lowCount;

            const pendingReqCount = erpDatabase.solicitacoes.filter(s => s.status === 'PENDENTE').length;
            document.getElementById('dash-pending-requests').innerText = pendingReqCount;
            document.getElementById('badge-pedidos-pendentes').innerText = pendingReqCount;

            // HistÃ³rico unificado
            const tbody = document.getElementById('dash-movements-tbody');
            if(tbody) {
                tbody.innerHTML = '';
                const latestMoves = [...moves].sort((a,b) => new Date(b.data_hora) - new Date(a.data_hora)).slice(0, 5);
                
                if (latestMoves.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="7" class="py-4 text-center text-slate-500">Sem lanÃ§amentos na base fÃ­sica.</td></tr>`;
                } else {
                    latestMoves.forEach(m => {
                        const p = ProductRepository.findById(m.produto_id);
                        const isEntrada = m.tipo_movimentacao === 'ENTRADA';
                        const badge = isEntrada ? 'bg-emerald-500/10 text-emerald-400' : (m.tipo_movimentacao === 'SAIDA' ? 'bg-rose-500/10 text-rose-400' : 'bg-amber-500/10 text-amber-400');
                        tbody.innerHTML += `
                            <tr class="hover:bg-slate-900/50">
                                <td class="py-2.5 px-2 text-slate-500">${new Date(m.data_hora).toLocaleDateString('pt-BR')} ${new Date(m.data_hora).toLocaleTimeString('pt-BR')}</td>
                                <td class="py-2.5 px-2"><span class="px-1.5 py-0.5 rounded text-[9px] font-bold ${badge}">${m.tipo_movimentacao}</span></td>
                                <td class="py-2.5 px-2 font-bold text-slate-200">${p ? p.nome : 'N/A'}</td>
                                <td class="py-2.5 px-2 text-right font-mono font-bold ${isEntrada ? 'text-emerald-400' : 'text-rose-400'}">${isEntrada ? '+' : '-'}${m.quantidade}</td>
                                <td class="py-2.5 px-2 text-right text-slate-500 font-mono">${m.saldo_anterior}</td>
                                <td class="py-2.5 px-2 text-right text-slate-300 font-mono">${m.saldo_posterior}</td>
                                <td class="py-2.5 px-2 text-slate-400">ID ${m.usuario_id}</td>
                            </tr>
                        `;
                    });
                }
            }

            // Trilha de auditoria passiva no Dashboard
            const auditContainer = document.getElementById('dash-audit-container');
            if(auditContainer) {
                auditContainer.innerHTML = '';
                const logs = AuditRepository.getLatestLogs(6);
                logs.forEach(log => {
                    auditContainer.innerHTML += `
                        <div class="bg-slate-900/60 p-2.5 rounded border border-slate-800/80 flex flex-col gap-1">
                            <div class="flex justify-between text-[9px] text-slate-500">
                                <span class="font-bold text-indigo-400 uppercase">${log.operacao}</span>
                                <span>${new Date(log.data_hora).toLocaleTimeString('pt-BR')}</span>
                            </div>
                            <p class="text-slate-300">${log.valor_novo}</p>
                            <span class="text-[8px] text-slate-600 block">Terminal: ${log.computador_nome} | IP: ${log.ip_address}</span>
                        </div>
                    `;
                });
            }
        }

        function renderStagingList() {
            const container = document.getElementById('staging-container');
            const counter = document.getElementById('staging-counter');
            const actions = document.getElementById('recv-actions-container');

            if (!container) return;

            if (!erpDatabase.sessaoRecebimentoAtiva) {
                container.innerHTML = `
                    <div class="text-slate-600 text-center py-16 flex flex-col items-center gap-2">
                        <i data-lucide="lock" class="w-10 h-10 text-slate-700"></i>
                        <span>SessÃ£o de recebimento fechada. Inicie uma nova sessÃ£o para habilitar.</span>
                    </div>
                `;
                if(counter) counter.innerText = 'Fechado';
                if(actions) actions.classList.add('hidden');
                return;
            }

            const list = erpDatabase.stagingList;
            if(counter) counter.innerText = `${list.length} material(is)`;
            
            if (list.length > 0) {
                if(actions) actions.classList.remove('hidden');
            } else {
                if(actions) actions.classList.add('hidden');
            }

            if (list.length === 0) {
                container.innerHTML = `
                    <div class="text-slate-600 text-center py-16 flex flex-col items-center gap-2">
                        <i data-lucide="package-search" class="w-10 h-10 text-slate-700"></i>
                        <span>Aguardando o escaneamento do primeiro material...</span>
                    </div>
                `;
                return;
            }

            container.innerHTML = '';
            list.forEach(item => {
                container.innerHTML += `
                    <div class="p-3 bg-slate-900 border border-slate-800 rounded-lg flex justify-between items-center">
                        <div>
                            <span class="font-bold text-slate-200 block">${item.product.nome}</span>
                            <span class="text-[10px] text-slate-400 font-mono">Barcode: ${item.product.codigo_barras} | PN: ${item.product.part_number || 'Sem PN'}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-mono text-indigo-400 font-bold bg-indigo-500/10 px-2 py-1 rounded border border-indigo-500/20">${item.quantidade} UN</span>
                            <button onclick="simulateBipe('${item.product.codigo_barras}')" class="p-1 rounded bg-slate-800 text-slate-300 hover:bg-slate-700 font-bold text-xs">+</button>
                        </div>
                    </div>
                `;
            });
            lucide.createIcons();
        }

        function renderSeparationQueue() {
            const container = document.getElementById('separation-queue-container');
            if (!container) return;
            container.innerHTML = '';

            const reqs = erpDatabase.solicitacoes;
            const pendings = reqs.filter(s => s.status === 'PENDENTE');

            if (pendings.length === 0) {
                container.innerHTML = `
                    <div class="text-slate-600 text-center py-20 flex flex-col items-center gap-2">
                        <i data-lucide="check-circle" class="w-12 h-12 text-slate-700"></i>
                        <span class="text-xs">Fila de BalcÃ£o Vazia. Nenhuma solicitaÃ§Ã£o pendente de despacho.</span>
                    </div>
                `;
                return;
            }

            pendings.forEach(req => {
                const sector = SECTORES_TABLE.find(s => s.id === req.setor_id);
                const isAlta = req.prioridade === 'ALTA';
                const priorBadge = isAlta ? 'bg-rose-500/20 text-rose-400 border border-rose-500/30 font-bold' : 'bg-slate-900 border border-slate-800 text-slate-400';

                let itemsListHtml = '';
                req.itens.forEach(item => {
                    const p = ProductRepository.findById(item.produto_id);
                    itemsListHtml += `
                        <div class="flex justify-between text-[11px] font-mono border-b border-slate-900 py-1">
                            <span class="text-slate-300">${p ? p.nome : 'Material'} <strong class="text-slate-500">(Loc: ${p ? p.localizacao : 'N/A'})</strong></span>
                            <span class="text-slate-300 font-bold">${item.quantidade_solicitada} UN</span>
                        </div>
                    `;
                });

                container.innerHTML += `
                    <div class="p-4 bg-slate-900/40 border border-slate-800 rounded-xl flex flex-col gap-3 relative overflow-hidden">
                        ${isAlta ? '<div class="absolute top-0 left-0 w-full h-1 bg-rose-500"></div>' : ''}
                        
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] bg-slate-800 px-2 py-0.5 rounded font-mono font-bold text-slate-300">${req.numero_solicitacao}</span>
                                    <span class="text-[9px] px-1.5 py-0.5 rounded uppercase tracking-wider ${priorBadge}">${req.prioridade}</span>
                                </div>
                                <h4 class="text-xs font-bold text-white mt-1.5">Solicitante: <span class="text-slate-300 font-medium">${req.solicitante}</span></h4>
                                <span class="text-[10px] text-slate-500 block">Setor: ${sector ? sector.nome : 'N/A'} | Equipamento: ${req.equipamento || 'Geral'}</span>
                            </div>
                            <button onclick="deliverRequest(${req.id})" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-[11px] rounded-lg shadow-lg shadow-emerald-600/15 flex items-center gap-1">
                                <i data-lucide="check" class="w-3.5 h-3.5"></i> Despachar e Entregar
                            </button>
                        </div>

                        <!-- Lista de Itens internos -->
                        <div class="bg-slate-950 p-2.5 rounded-lg border border-slate-900 flex flex-col gap-1">
                            ${itemsListHtml}
                        </div>
                    </div>
                `;
            });
            lucide.createIcons();
        }

        function populateSolicitacoesDropdowns() {
            const itemSelect = document.getElementById('req-item-select');
            const sectorSelect = document.getElementById('req-setor');
            if (!itemSelect || !sectorSelect) return;

            itemSelect.innerHTML = '<option value="">-- Escolha o Material --</option>';
            erpDatabase.produtos.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.innerText = `${p.nome} (${p.marca}) - Saldo: ${p.estoque_atual}`;
                itemSelect.appendChild(opt);
            });

            sectorSelect.innerHTML = '';
            SECTORES_TABLE.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id;
                opt.innerText = s.nome;
                sectorSelect.appendChild(opt);
            });
        }

        // Foco assistido automÃ¡tico de acordo com a Aba Ativa
        function refocusScannerField() {
            if (activeTab === 'recebimento' && erpDatabase.sessaoRecebimentoAtiva) {
                const input = document.getElementById('recvBarcodeInput');
                if (input) input.focus();
            } else if (activeTab === 'saida') {
                const input = document.getElementById('saidaBarcodeInput');
                if (input) input.focus();
            }
        }

        // Setup de Leitores para Staging (Recebimento) - Captura Manual em Input focado
        const recvInputEl = document.getElementById('recvBarcodeInput');
        if (recvInputEl) {
            recvInputEl.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const code = e.target.value.trim();
                    if (code) {
                        simulateBipe(code);
                        e.target.value = '';
                    }
                }
            });
        }

        // Setup de Leitores para SaÃ­da BalcÃ£o
        const saidaInputEl = document.getElementById('saidaBarcodeInput');
        if (saidaInputEl) {
            saidaInputEl.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const code = e.target.value.trim();
                    if (code) {
                        triggerSaidaPipelineSearch(code);
                    }
                }
            });

            // Autocomplete de SaÃ­da
            saidaInputEl.addEventListener('input', () => {
                const query = saidaInputEl.value.toLowerCase().trim();
                const dropdown = document.getElementById('saidaAutocompleteDropdown');
                
                if (query.length < 2) {
                    dropdown.classList.add('hidden');
                    return;
                }

                const suggestions = ProductRepository.findByFreeSearch(query);
                dropdown.innerHTML = '';

                if (suggestions.length === 0) {
                    dropdown.classList.add('hidden');
                    return;
                }

                suggestions.forEach(p => {
                    const item = document.createElement('div');
                    item.className = "px-4 py-3 hover:bg-rose-950/20 border-b border-slate-900 text-xs cursor-pointer flex justify-between items-center transition-all";
                    item.innerHTML = `
                        <div>
                            <div class="font-bold text-slate-200">${p.nome}</div>
                            <div class="text-[10px] text-slate-400 font-mono">${p.codigo_barras} | PN: ${p.part_number || 'Sem PN'}</div>
                        </div>
                        <span class="text-[10px] bg-slate-900 px-2 py-1 rounded text-rose-400 font-mono font-bold">${p.estoque_atual} ${p.unidade}</span>
                    `;
                    item.addEventListener('click', () => {
                        selectProductForSaida(p);
                        dropdown.classList.add('hidden');
                    });
                    dropdown.appendChild(item);
                });
                dropdown.classList.remove('hidden');
            });
        }

        // =========================================================================
        // MOTOR DO INTERCEPTADOR GLOBAL DE SCANNER (SOLUÃ‡ÃƒO DE INFRAESTRUTURA)
        // =========================================================================
        let barcodeAccumulator = '';
        let lastKeyTime = 0;

        document.addEventListener('keydown', (e) => {
            // Se o operador estiver preenchendo um campo de texto manual ou formulÃ¡rio complexo,
            // nÃ£o devemos interceptar os dados da digitaÃ§Ã£o humana.
            const activeEl = document.activeElement;
            const isEditingText = activeEl && (
                activeEl.tagName === 'TEXTAREA' || 
                (activeEl.tagName === 'INPUT' && 
                 activeEl.id !== 'recvBarcodeInput' && 
                 activeEl.id !== 'saidaBarcodeInput' && 
                 activeEl.id !== 'search-query')
            );

            if (isEditingText) {
                return; // Deixa o operador digitar normalmente em campos de formulÃ¡rio
            }

            const currentTime = performance.now();
            const diff = currentTime - lastKeyTime;
            lastKeyTime = currentTime;

            // Scanners de Hardware enviam teclas sequencialmente de forma extremamente veloz (delta < 35ms)
            if (diff < 35 || barcodeAccumulator === '') {
                if (e.key !== 'Enter' && e.key.length === 1) {
                    barcodeAccumulator += e.key;
                } else if (e.key === 'Enter') {
                    const finalCode = barcodeAccumulator.trim();
                    if (finalCode.length >= 3) {
                        e.preventDefault();
                        processGlobalScannerInput(finalCode);
                    }
                    barcodeAccumulator = '';
                }
            } else {
                // DigitaÃ§Ã£o manual muito lenta para ser um leitor de cÃ³digo de barras
                if (e.key.length === 1 && e.key !== 'Enter') {
                    barcodeAccumulator = e.key;
                } else {
                    barcodeAccumulator = '';
                }
            }
        });

        // Efetua o tratamento da leitura global do Scanner de qualquer lugar do software
        function processGlobalScannerInput(code) {
            addToast(`CÃ³digo capturado via Scanner: ${code}`, 'success');
            
            // Se estiver na aba de recebimento com sessÃ£o ativa, executa recebimento.
            // Se nÃ£o, o padrÃ£o ideal para agilidade de balcÃ£o Ã© redirecionar para SaÃ­da Direta!
            if (activeTab === 'recebimento' && erpDatabase.sessaoRecebimentoAtiva) {
                simulateBipe(code);
            } else {
                if (activeTab !== 'saida') {
                    switchTab('saida');
                }
                setTimeout(() => {
                    triggerSaidaPipelineSearch(code);
                }, 100);
            }
        }

        // Se o usuÃ¡rio clicar em qualquer ponto vazio da tela, devolvemos o foco para o leitor de cÃ³digo
        document.addEventListener('click', (e) => {
            const tag = e.target.tagName;
            if (tag !== 'INPUT' && tag !== 'SELECT' && tag !== 'TEXTAREA' && tag !== 'BUTTON' && tag !== 'A') {
                refocusScannerField();
            }
        });

        function setupKeyboardShortcuts() {
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (activeTab === 'saida') {
                        cancelSaidaDirect();
                    } else {
                        cancelFastCadastro();
                    }
                }
                if (e.key === 'F2') {
                    e.preventDefault();
                    refocusScannerField();
                }
                if (e.key === 'F9') {
                    if (activeTab === 'saida' && !document.getElementById('saidaStateProductFound').classList.contains('hidden')) {
                        e.preventDefault();
                        executeSaidaDirect();
                    }
                }
            });
        }

        function switchTab(tabId) {
            activeTab = tabId;
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.getElementById(`tab-${tabId}`).classList.remove('hidden');

            document.querySelectorAll('nav border, nav button').forEach(btn => {
                btn.className = "flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all text-slate-400 hover:text-white hover:bg-slate-800";
            });

            const activeBtn = document.getElementById(`tabBtn-${tabId}`);
            if (tabId === 'engenharia') {
                activeBtn.className = "flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all bg-amber-500 text-slate-950 shadow-lg shadow-amber-500/10";
            } else {
                activeBtn.className = "flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold transition-all bg-indigo-600 text-white shadow-lg shadow-indigo-500/10";
            }

            refreshUI();
            refocusScannerField();
        }

        // InicializaÃ§Ã£o Geral
        window.addEventListener('DOMContentLoaded', async () => {
            try {
                await initErpDatabase();
            } catch (error) {
                addToast(`Falha ao carregar os dados do servidor: ${error.message}`, 'error');
                return;
            }
            lucide.createIcons();
            populateSolicitacoesDropdowns();
            populateSaidaSectors();
            setupSaidaResumoSync();
            setupKeyboardShortcuts();
            refreshUI();
        });

        // Toast de Feedback
        function addToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            
            let bg = 'bg-slate-950 border-slate-800 text-slate-300';
            let icon = 'info';
            
            if (type === 'success') {
                bg = 'bg-emerald-950/90 border-emerald-500/50 text-emerald-300';
                icon = 'check-circle';
            } else if (type === 'error') {
                bg = 'bg-rose-950/90 border-rose-500/50 text-rose-300';
                icon = 'x-circle';
            } else if (type === 'warning') {
                bg = 'bg-amber-950/90 border-amber-500/50 text-amber-300';
                icon = 'alert-triangle';
            }

            toast.className = `p-4 rounded-xl border flex items-start gap-3 shadow-2xl transition-all duration-300 translate-y-2 opacity-0 ${bg}`;
            toast.innerHTML = `
                <i data-lucide="${icon}" class="w-5 h-5 shrink-0 mt-0.5"></i>
                <div class="flex-1 text-xs font-semibold leading-relaxed">${message}</div>
            `;
            
            container.appendChild(toast);
            lucide.createIcons();

            setTimeout(() => {
                toast.classList.remove('opacity-0', 'translate-y-2');
            }, 10);

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 4000);
        }
