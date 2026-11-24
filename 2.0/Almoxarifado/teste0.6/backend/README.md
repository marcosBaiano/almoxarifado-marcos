# Backend (separado do Front)

Esta pasta isola a camada de backend para evolução do protótipo.

## Estrutura
- api/: endpoints PHP para operações de estoque, solicitações e auditoria.
- data/: persistência local em JSON para ambiente de desenvolvimento.

## Observação
No estado atual, o front ainda opera com mock via localStorage em frontend/assets/js/app.js.
Os endpoints em api/ servem como base para migração gradual para backend real em PHP.
