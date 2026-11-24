# Análise do projeto e separação em módulos MVC

## Visão geral
O projeto atual está concentrado em um único arquivo HTML com:
- estrutura visual da interface
- dados em memória
- regras de negócio
- renderização de telas
- interação com o usuário

Isso torna a manutenção mais difícil, porque a camada de apresentação, lógica de negócio e dados estão misturadas.

## Proposta de separação MVC

### Model
Responsável pelos dados e regras de domínio.
- app/models/state.js
- app/models/produtoModel.js

### Service
Responsável pelas operações de negócio e transações de estoque.
- app/services/estoqueService.js

### Controller
Responsável por coordenar eventos e fluxo de tela.
- app/controllers/appController.js
- app/controllers/produtoController.js
- app/controllers/movimentacaoController.js

### View
Responsável pela renderização e montagem de HTML.
- app/views/dashboardView.js
- app/views/produtosView.js
- app/views/recebimentoView.js
- app/views/saidaView.js
- app/views/requisicoesView.js
- app/views/inventarioView.js
- app/views/auditoriaView.js
- app/views/scannerView.js

### Bootstrap
Ponto de entrada para integrar os módulos.
- app/main.js

## Observação
Este trabalho foi realizado sem alterar o código existente em index.php. A separação foi feita em novos arquivos, prontos para integração futura.
