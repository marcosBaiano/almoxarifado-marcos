# Guia Operacional do ERP do Almoxarifado

**Público:** almoxarifes, compradores, encarregados, supervisores, manutenção e solicitantes de materiais.  
**Finalidade:** orientar o uso diário do ERP para que cada movimentação represente corretamente o material físico e sua utilização.

---

## 1. Como pensar o ERP

O ERP é o livro-caixa do almoxarifado. O material continua na prateleira, mas o sistema registra sua identidade, onde está, quanto há e para onde foi. Quando os dois retratos — físico e sistema — são iguais, a empresa consegue comprar no momento certo, separar rapidamente e investigar qualquer diferença.

### O ciclo básico do material

```text
Cadastro e identificação
          ↓
Recebimento e conferência
          ↓
Estoque disponível para consulta
          ↓
Solicitação programada ou saída de balcão
          ↓
Histórico e acompanhamento no painel
```

**Regra de ouro:** primeiro confira o material físico; depois registre o fato correspondente no sistema. Não use um ajuste de estoque para substituir uma entrada, uma saída ou uma solicitação que deveria ter sido registrada pelo processo correto.

### Conceitos usados em todo o sistema

| Conceito | Significado operacional | Exemplos reais |
|---|---|---|
| Material ou produto | Qualquer item que a empresa guarda, compra ou entrega. | Rolamento 6204-2RS SKF; motor WEG 2 cv; luva de proteção nitrílica. |
| Código interno | Identificação própria da empresa para diferenciar um material de outro. | `IT-041` para um sensor; `IT-112` para um cabo; `IT-205` para óleo hidráulico. |
| Código de barras | Número lido pelo leitor para localizar o material com rapidez. Pode haver mais de um código associado ao mesmo item. | Etiqueta de uma caixa de parafusos; EAN de um lubrificante; etiqueta interna de uma ferramenta. |
| Part Number (PN) | Código técnico que o fabricante dá à peça. É especialmente importante em reposições. | `6204-2RS`; `XS118BLPAL2`; `C25-20`. |
| Categoria | Família que organiza materiais parecidos. | Elétrica: contator; Mecânica: rolamento; Hidráulica: mangueira. |
| Marca | Empresa cuja marca aparece no material ou na embalagem. | SKF, WEG, Schneider Electric. |
| Localização | Endereço físico do item no almoxarifado. | `PR-A1` para prateleira A1; `AL-C2` para armário C2; bancada de ferramentas. |
| Saldo atual | Quantidade que o sistema entende como disponível após todos os registros confirmados. | 18 rolamentos; 4 motores; 250 pares de luvas. |
| Estoque mínimo | Quantidade de alerta. Ao alcançar ou ficar abaixo dela, o item precisa de atenção para reposição. | Mínimo de 5 sensores; 2 motores; 20 litros de óleo. |
| Movimentação | Registro de entrada, saída ou correção de saldo. | Recebimento de 10 filtros; retirada de 2 sensores; correção após contagem. |
| Sessão de recebimento | Lista temporária para conferir um lote antes de incorporá-lo ao estoque. | Nota com rolamentos, cabos e EPIs; entrega parcial de válvulas; recebimento semanal de parafusos. |
| Solicitação | Pedido formal de materiais para um setor ou equipamento. | Manutenção solicita uma correia; produção pede luvas; elétrica pede disjuntor para um painel. |
| Auditoria | Histórico de quem registrou uma operação, quando e qual foi a alteração. | Saída para Prensa 05; ajuste por item danificado; confirmação de recebimento. |

### Responsabilidades mais comuns

| Papel | Responsabilidade típica |
|---|---|
| Almoxarife | Confere recebimentos, identifica materiais, registra saídas e mantém a localização correta. |
| Solicitante / manutenção | Informa o material, a quantidade, o setor e a aplicação da necessidade. |
| Encarregado / supervisor | Prioriza atendimentos, acompanha itens críticos e autoriza ajustes conforme a regra interna. |
| Compras | Usa os alertas de mínimo e a identificação correta do material para cotar e repor. |

---

# 2. Cadastro e identificação de materiais

## O que é este módulo?

É a base de identificação do almoxarifado. Um cadastro não é uma entrada de estoque: ele diz **o que é** o material. A entrada, em outro momento, dirá **quanto chegou**. Pense na ficha de cadastro como a etiqueta de uma gaveta; sem uma etiqueta clara, qualquer pessoa pode guardar ou retirar o item errado.

O sistema permite criar rapidamente um material quando um código lido ainda não é reconhecido e também associar um novo código de barras a um material já existente.

## Campos da ficha de identificação

| Campo | O que significa e por que existe | Quem / quando informa | Exemplo de preenchimento | Erros comuns e boa prática |
|---|---|---|---|---|
| Código de barras | Número que o leitor usa para localizar o material. Evita busca manual e reduz troca de itens semelhantes. | Almoxarife no recebimento ou responsável pelo cadastro, ao conferir a embalagem ou etiqueta. | `7891000789012` no rolamento; código da caixa de parafusos; etiqueta interna da furadeira. | Não reutilize o código de outro material. Confira se o código da caixa corresponde ao conteúdo, não apenas ao fornecedor. |
| Descrição completa | Nome claro do material, com características que evitem confusão. | Almoxarifado, compras ou manutenção ao cadastrar. | `Rolamento rígido de esferas 6204-2RS`; `Sensor indutivo M18 PNP`; `Luva nitrílica tamanho G`. | Evite nomes vagos como “rolamento”, “sensor” ou “luva”. Inclua medida, tipo ou aplicação quando distinguir o item. |
| Marca | Marca comercial do item. Ajuda a localizar equivalentes e a conferir o que foi comprado. | Conferente ou responsável pelo cadastro. | SKF; WEG; Schneider Electric. | Não use o nome do distribuidor como marca. Se o fabricante não estiver identificado, confirme a embalagem antes de salvar. |
| Categoria | Família operacional usada para consulta, organização e relatórios. | Almoxarife ou responsável pelo cadastro. | Elétrica: cabo; Mecânica: correia; Hidráulica: conexão. | Não classifique por onde o item será usado. Um sensor usado na prensa continua sendo material elétrico. |
| Código interno | Código próprio da empresa para o material. | Normalmente gerado ou definido no cadastro inicial. | `IT-041`, `IT-112`, `IT-205`. | Não crie outro código para o mesmo item apenas porque mudou o fornecedor. |
| Part Number | Código do fabricante que identifica exatamente uma versão da peça. | Almoxarifado, compras ou manutenção, ao consultar catálogo/embalagem. | `6204-2RS`; `XS118BLPAL2`; `C25-20`. | Não confunda PN com código de barras. O PN costuma ser impresso pelo fabricante e é essencial para peças técnicas. |
| Unidade | Forma em que o saldo é contado. | Responsável pelo cadastro, antes da primeira movimentação. | `UN` para motor; `PAR` para luvas; `M` para cabo. | Não registre “10” sem saber se são 10 unidades, 10 metros ou 10 pares. Mantenha a mesma unidade usada na compra e na entrega. |
| Localização | Endereço físico onde o material deve ser guardado. | Almoxarife, após definir a posição na armazenagem. | `PR-A1`; `AL-C2`; `EST-03`. | Não informe uma localização genérica, como “almoxarifado”. O endereço deve ajudar alguém novo a achar o item. |
| Estoque mínimo | Ponto de atenção para reposição, definido conforme consumo e prazo de compra. | Supervisor, compras ou almoxarife com base no histórico. | 5 sensores; 2 motores; 20 litros de lubrificante. | Não copie o mesmo mínimo para todos. Um parafuso de uso diário e um motor crítico têm necessidades diferentes. |
| Estoque máximo | Limite de referência para evitar excesso e falta de espaço. | Supervisor, compras ou almoxarife. | 50 filtros; 10 rolamentos; 500 pares de EPI. | Não transforme o máximo em uma meta de compra automática. Considere validade, consumo e espaço disponível. |

### Categoria: como decidir

Use a natureza do material, e não o setor que o solicitou.

| Categoria | Três exemplos | Uso da informação |
|---|---|---|
| Elétrica | Sensor fotoelétrico; cabo 2,5 mm²; disjuntor. | Filtros de busca e visualização de itens elétricos. |
| Mecânica | Rolamento; correia; parafuso sextavado. | Separação de itens de manutenção mecânica. |
| Pneumática | Engate rápido; cilindro pneumático; válvula solenoide. | Localização e consulta por família. |
| Hidráulica | Mangueira hidráulica; conexão; óleo hidráulico. | Acompanhamento de materiais do circuito hidráulico. |
| Ferramentas | Alicate; furadeira; chave de impacto. | Identificação de itens de apoio à manutenção. |

## Como a identificação influencia o sistema

A descrição, a marca, o código, o PN e a localização são usados para localizar materiais na consulta, no recebimento, na saída e na criação de solicitações. A categoria organiza filtros e facilita a leitura do estoque. O estoque mínimo acende o alerta no painel quando a reposição merece atenção.

## Exemplo do dia a dia

Chega uma caixa com um **sensor indutivo Schneider**, PN `XS118BLPAL2`. O almoxarife lê o código da embalagem. Se o sistema já reconhecer o material, ele apenas o inclui na sessão de recebimento. Se o código for novo, mas o sensor já existir cadastrado, associa o código à ficha existente. Só deve criar uma nova ficha se confirmar que é realmente outro sensor — por exemplo, mesma aparência, mas conector ou tipo de saída diferente.

## Dicas operacionais

- Antes de criar um cadastro, pesquise por descrição, marca e Part Number. Isso evita duplicidade.
- Dê preferência à descrição técnica completa e padronizada: tipo + característica principal + medida/modelo.
- Ao mudar a etiqueta de uma prateleira, atualize também a localização no sistema.
- Para itens críticos, preserve sempre marca e PN; são a defesa contra compra ou entrega de peça incompatível.

## Perguntas frequentes

**Posso cadastrar dois produtos iguais?** Não. Primeiro procure pelo código, descrição, marca e PN. Dois cadastros dividem o saldo e geram compras e contagens erradas.

**Marca e fabricante são a mesma coisa?** Para o uso diário, informe a marca visível e reconhecida na embalagem. O objetivo é identificar o item de forma consistente; não use o nome do revendedor em seu lugar.

**Posso associar mais de um código de barras?** Sim, quando códigos diferentes representam o mesmo material cadastrado. Isso é comum em embalagens ou etiquetas internas. Cada código deve apontar para um único material.

---

# 3. Painel de acompanhamento (Dashboard)

## O que é este módulo?

É a visão de acompanhamento do almoxarifado. Ele não substitui a conferência física nem registra retiradas: mostra o retrato do que já foi lançado no sistema para apoiar a decisão diária.

## Informações do painel

| Informação | O que significa | Como usar no dia a dia |
|---|---|---|
| Materiais catalogados | Número de materiais ativos identificados no sistema. | Ajuda a perceber a dimensão do catálogo; não é a quantidade de peças guardadas. |
| Unidades em estoque físico | Soma dos saldos registrados de todos os materiais. | Use como visão geral; para conferir um item, abra a consulta. |
| Estoque abaixo do mínimo | Quantidade de materiais cujo saldo exige atenção de reposição. | Revise no início do turno com compras ou supervisão. |
| Solicitações pendentes | Pedidos aguardando separação e entrega. | Organize a fila, observando a prioridade e o setor. |
| Histórico consolidado | Últimas entradas, saídas e ajustes, com saldo antes e depois. | Investigue rapidamente por que um saldo mudou. |
| Trilha de auditoria | Registro das ações realizadas no sistema. | Use em conferências, divergências e passagem de turno. |

### Como ler o histórico de movimentações

| Campo | Significado | Exemplo |
|---|---|---|
| Data/Hora | Momento em que o registro foi confirmado. | `22/07/2026 09:10`. |
| Tipo | Natureza da operação: entrada, saída ou ajuste. | Entrada de 12 filtros; saída de 2 rolamentos; ajuste após inventário. |
| Item | Material afetado. | Motor WEG 2 cv; parafuso M8; óleo ISO 68. |
| Qtd | Quantidade movimentada, na unidade do material. | 3 unidades; 15 metros; 4 pares. |
| Anterior / Posterior | Saldo antes e depois da operação. | De 8 para 5 após retirada de 3. |
| Operador | Pessoa que confirmou a operação. | Almoxarife do turno. |

## Exemplos do dia a dia

1. O painel mostra **estoque abaixo do mínimo: 1**. O encarregado abre a consulta, encontra o óleo hidráulico com 15 litros e mínimo de 20 e comunica compras.
2. A manutenção pergunta por que há apenas 3 correias. No histórico, o almoxarife encontra uma saída de 2 correias para a Prensa 05 e confirma o solicitante.
3. Na troca de turno, a equipe vê duas solicitações pendentes: uma de prioridade alta para máquina parada e outra planejada. A primeira é separada antes.

## Dicas operacionais

- Use o painel para priorizar; use a consulta para decidir sobre um item específico.
- Um alerta de mínimo não significa necessariamente “comprar agora”; confira pedidos em andamento, consumo e criticidade.
- Se uma movimentação parecer estranha, não “conserte” imediatamente com ajuste. Primeiro confirme o fato físico e o processo que gerou o registro.

---

# 4. Recebimento por sessões

## O que é este módulo?

É a área para conferir materiais recebidos antes de disponibilizá-los no saldo. A sessão funciona como uma bancada de conferência: você pode ler vários itens, revisar o conjunto e somente então confirmar a entrada. Enquanto a sessão está aberta, os itens da lista ainda **não** aumentaram o estoque disponível.

## Campos e controles

| Campo ou controle | O que significa e por que existe | Quem / quando usa | Exemplo | Erros comuns e boa prática |
|---|---|---|---|---|
| Iniciar nova sessão | Abre uma lista de conferência identificada para aquele recebimento. | Almoxarife ao iniciar uma nota, lote ou entrega. | Recebimento da NF com sensores e rolamentos. | Não misture entregas sem relação na mesma sessão se isso prejudicar a conferência. |
| ID da sessão | Identificador de referência do lote em conferência. | Consultado pelo almoxarife e supervisor. | `RECV-2026-001`. | Registre esse identificador nos controles internos se for necessário relacioná-lo a uma nota. |
| Abertura | Data e hora de início da conferência. | Consultado em passagem de turno ou auditoria. | 22/07/2026 às 09h. | Não deixe sessão antiga aberta para outro turno sem comunicação. |
| Escanear código de barras / digitação | Localiza o material que chegou. | Almoxarife durante a conferência. | Bipar caixa de rolamento; digitar código do cabo; ler etiqueta de EPI. | Confira visualmente o item. Um bip identifica a etiqueta lida, não substitui a conferência do conteúdo. |
| Lista de conferência | Relação temporária de materiais lidos e suas quantidades. | Almoxarife antes da confirmação. | 10 sensores, 20 rolamentos, 5 litros de óleo. | Revise quantidades e itens antes de confirmar. |
| Confirmar e atualizar estoque | Torna o recebimento oficial e soma as quantidades ao saldo. | Almoxarife após conferência física. | Saldo de 8 passa para 18 após entrada de 10. | Só confirme quando a conferência estiver concluída. |
| Descartar sessão | Cancela a lista temporária sem alterar o estoque. | Almoxarife quando a conferência foi iniciada por engano ou precisa recomeçar. | Lote misturado antes da contagem. | Descartar não é devolução ao fornecedor; é apenas cancelar uma lista ainda não confirmada. |

### Quando o código não é reconhecido

O sistema oferece dois caminhos. Escolha com cuidado:

| Situação | Ação correta | Exemplo |
|---|---|---|
| O material já existe, mas a embalagem veio com código novo | **Associar código a material existente.** Pesquise por código, descrição, marca ou PN e selecione a ficha correta. | O mesmo rolamento 6204-2RS chega com EAN de outra embalagem. |
| O material realmente ainda não existe no catálogo | **Cadastrar material não identificado.** Preencha descrição, marca e categoria antes de continuar. | Primeiro recebimento de uma válvula pneumática nova. |
| Há dúvida se é o mesmo item | Pare a entrada e confirme embalagem, PN, medida e aplicação. | Sensor M18 PNP parecido com sensor M18 NPN. |

## Como a sessão influencia o sistema

Quando confirmada, cada linha se torna uma **entrada** no histórico e aumenta o saldo do material. O painel passa a refletir a nova quantidade. Se o novo saldo ficar acima do mínimo, o alerta do item pode deixar de aparecer. A sessão também deixa um rastro de conferência para localizar a origem da entrada.

## Exemplos do dia a dia

1. Chegam **12 rolamentos SKF 6204-2RS**. O almoxarife abre a sessão, lê a caixa 12 vezes ou registra a quantidade equivalente na lista, confere com a nota e confirma. O saldo de 8 passa para 20.
2. Chegam **3 motores WEG**, mas apenas 2 têm a potência e a tensão pedidas. O almoxarife não confirma a sessão inteira antes de resolver a divergência; separa o item diferente e confere com compras/fornecedor.
3. Chega uma remessa de **luvas nitrílicas tamanho G** com etiqueta de fornecedor que o sistema não conhece. Como as luvas já estão cadastradas, ele associa o novo código de barras à ficha existente e prossegue com a conferência, sem criar cadastro duplicado.

## Dicas operacionais

- Compare quantidade, modelo e embalagem com o documento de entrega antes de confirmar.
- Guarde materiais recebidos na localização definida antes ou imediatamente após a confirmação.
- Nunca confirme uma sessão “para testar”. Use o descarte se a leitura foi feita por engano.
- Em material técnico, confira o Part Number, não só a aparência.

## Perguntas frequentes

**O saldo mudou ao bipar?** Não. Ele só muda ao confirmar a sessão.

**Posso descartar uma sessão?** Sim, enquanto ela ainda estiver em conferência. O descarte não altera o estoque.

**O que fazer se o código lido não existe?** Primeiro procure o material por descrição, marca ou PN. Associe o código se ele for o mesmo produto; crie novo cadastro apenas quando for outro material.

---

# 5. Saída direta de material

## O que é este módulo?

É a retirada rápida no balcão, sem solicitação prévia. É indicada para uma necessidade imediata, como manutenção que chega para buscar uma peça. Ao confirmar, o saldo é reduzido na hora e o destino fica registrado.

Para necessidades planejadas, com vários itens ou que precisam entrar em fila, prefira o módulo **Solicitações & Entrega**.

## Campos da saída

| Campo | O que significa e por que existe | Quem / quando informa | Exemplo de preenchimento | Erros comuns e boa prática |
|---|---|---|---|---|
| Código de barras ou busca | Identifica o material a retirar por leitura ou pesquisa. | Almoxarife, no balcão. | Bipar filtro; digitar parte do PN; buscar “cabo 2,5”. | Confira descrição, marca e saldo no cartão do item antes de seguir. |
| Quantidade a retirar | Quantidade física que sairá do almoxarifado. | Almoxarife após contar ou medir. | 2 rolamentos; 5 m de cabo; 3 pares de luvas. | Não informe a quantidade de embalagens se a unidade cadastral for outra. |
| Setor destinatário | Área que receberá ou consumirá o material. | Almoxarife ou pessoa que retira. | Manutenção mecânica; Produção; Utilidades. | Não deixe de informar. O setor permite entender o destino do consumo. |
| Solicitante | Nome de quem retirou ou pediu o material. | Pessoa que retira, registrado pelo almoxarife. | `Mário Silva`. | Evite “manutenção” ou “turno”. Registre uma pessoa quando possível. |
| Equipamento / aplicação | Máquina, linha ou finalidade da retirada. | Solicitante ou almoxarife, quando aplicável. | `Prensa 05`; `Ponte Rolante G1`; `Linha A`. | Não use para repetir o setor. Informe a aplicação que ajuda a investigar consumo. |
| Observação / ordem de serviço / justificativa | Complemento que dá contexto à retirada. | Almoxarife quando há informação relevante. | `OS 1842 — troca de cabo da prensa`; `substituição por desgaste`; `uso emergencial`. | Não preencha texto vago como “uso”. Registre a causa ou referência disponível. |

## Como essa informação influencia o sistema

Ao confirmar, o sistema verifica se há saldo suficiente. Depois reduz o saldo, registra uma saída no histórico e mostra o novo saldo no painel e na consulta. Setor, solicitante, equipamento e observação tornam a retirada rastreável.

## Exemplos do dia a dia

1. Um técnico retira **2 rolamentos** para a Prensa 05. O almoxarife lê o código, informa quantidade 2, setor Manutenção Mecânica, solicitante e equipamento. O saldo de 8 passa para 6.
2. A elétrica precisa de **15 metros de cabo 2,5 mm²**. A unidade do item é metro; o almoxarife registra 15, não “uma bobina”, e informa a aplicação no painel elétrico.
3. A produção pede **4 pares de luvas** para reposição imediata. O almoxarife registra o setor Produção e o nome da pessoa que recebeu, permitindo enxergar o consumo de EPI por destino.

## Dicas operacionais

- Conte, meça ou pese antes de digitar a quantidade.
- Se o saldo indicado for insuficiente, não entregue parcialmente sem alinhar com o solicitante e a liderança.
- Use saída direta para atendimento de balcão. Para pedido organizado, use solicitação.
- Após confirmar, confira se o material físico realmente saiu com a pessoa certa.

## Perguntas frequentes

**Posso retirar mais do que o saldo?** Não. O sistema bloqueia a saída sem saldo suficiente.

**O solicitante é obrigatório?** O campo pode ser complementar, mas deve ser informado sempre que possível. Ele é fundamental para rastreabilidade.

**Posso cancelar uma saída confirmada?** Não a corrija com uma nova saída. Avise a liderança e siga o procedimento interno para registrar o retorno ou a correção de forma rastreável.

---

# 6. Solicitações e entrega

## O que é este módulo?

É a mesa de atendimento para materiais que devem ser pedidos, priorizados, separados e entregues como uma solicitação formal. Imagine uma comanda: ela reúne quem pediu, para qual setor, para qual equipamento, quais itens e qual urgência. Assim o almoxarifado não depende apenas de pedidos verbais.

## Campos para criar uma solicitação

| Campo | O que significa e por que existe | Quem / quando informa | Exemplo | Erros comuns e boa prática |
|---|---|---|---|---|
| Funcionário solicitante | Pessoa responsável pela necessidade. | Solicitante ao criar o pedido, ou almoxarife ao registrar. | `Mário Silva (Mecânica)`. | Não use apenas o nome do setor. Isso dificulta esclarecimentos. |
| Setor destino | Área que receberá os itens. | Solicitante. | Manutenção; Produção; Elétrica. | Escolha o setor que consumirá, não necessariamente o setor de quem está digitando. |
| Prioridade | Ordem de atendimento operacional. | Solicitante com validação da liderança quando necessário. | Alta: máquina parada; Média: manutenção planejada; Baixa: reposição de rotina. | Não marque tudo como alta. Prioridade alta deve representar impacto real e imediato. |
| Peças solicitadas | Materiais e respectivas quantidades desejadas. | Solicitante ou almoxarife. | 1 correia, 2 rolamentos, 1 sensor. | Confira o saldo e a unidade. Não misture produtos parecidos sem confirmar PN/modelo. |
| Quantidade | Quanto de cada peça é necessário. | Solicitante. | 1 motor; 20 parafusos; 10 m de mangueira. | Informe valor maior que zero e compatível com a unidade. |
| Equipamento / aplicação | Onde o material será usado; é opcional, mas muito valioso. | Solicitante. | `Ponte Rolante 02`; `Prensa WEG`; `Linha de envase`. | Preencha em manutenção corretiva, preventiva ou quando houver ativo identificado. |

### Prioridade: escolha responsável

| Prioridade | Quando usar | Três exemplos |
|---|---|---|
| Alta | Parada ou risco imediato para operação/segurança. | Sensor que parou a esteira; correia rompida em máquina crítica; EPI necessário para atividade segura. |
| Média | Trabalho planejado para o turno ou próximo período. | Troca preventiva de rolamento; reposição de disjuntor em manutenção programada; mangueira para ordem de serviço aberta. |
| Baixa | Necessidade sem impacto urgente. | Reposição de parafusos; estoque de ferramentas auxiliares; material para retorno de lote. |

## Entrega da solicitação

Na fila, o almoxarife vê o número da solicitação, prioridade, solicitante, setor, equipamento, itens, quantidades e localização. Ao selecionar **Despachar e Entregar**, o sistema baixa os materiais solicitados, marca o pedido como entregue e registra o responsável pela entrega.

Antes de despachar:

1. Compare os itens separados com a solicitação.
2. Localize cada material pelo endereço exibido.
3. Confira quantidade, modelo e condição física.
4. Confirme que há saldo para todos os itens.
5. Entregue ao solicitante ou responsável do setor e então confirme.

## Como essa informação influencia o sistema

A solicitação pendente aparece no painel. A prioridade orienta a fila de separação. Quando a entrega é confirmada, cada item gera uma saída, o saldo é reduzido e a solicitação deixa de aparecer como pendente. O histórico vincula a retirada ao pedido formal.

## Exemplos do dia a dia

1. A manutenção abre uma solicitação de prioridade alta para **1 sensor indutivo** da esteira. O almoxarife a vê no topo da fila, localiza o sensor, confere PN e entrega. O pedido muda para entregue.
2. Para uma preventiva da Ponte Rolante 02, são solicitados **2 rolamentos e 1 litro de lubrificante** como prioridade média. O pedido permite separar tudo junto e evitar várias saídas isoladas.
3. A produção pede **100 pares de luvas** para reposição mensal, prioridade baixa. O supervisor pode organizar a entrega no momento apropriado sem competir com uma máquina parada.

## Dicas operacionais

- Uma solicitação deve representar uma necessidade real e bem descrita, não uma lista genérica “para depois”.
- Reavalie a prioridade se o contexto mudar; não deixe pedido de máquina parada tratado como rotina.
- Não despache antes de separar todos os itens e conferir a quantidade.
- Ao existir solicitação, evite registrar a mesma entrega também como saída direta: isso duplicaria a baixa.

## Perguntas frequentes

**Quando usar solicitação e quando usar saída direta?** Solicitação para pedido formal, planejado ou com vários itens; saída direta para atendimento imediato de balcão sem pedido prévio.

**O que ocorre se faltar saldo de um item?** A entrega não deve ser confirmada como se estivesse completa. Informe o solicitante e trate a reposição conforme a rotina da empresa.

**Quem define prioridade alta?** Quem conhece o impacto da necessidade, com alinhamento da liderança. “Alta” deve ser reservada para urgência real.

---

# 7. Consulta de estoque e ajustes

## O que é este módulo?

É a área para encontrar materiais, conferir seu endereço e acompanhar saldos. Também concentra o ajuste físico, que deve ser usado somente para corrigir uma diferença comprovada entre a contagem e o sistema.

## Filtros e informações de consulta

| Campo ou informação | O que significa e por que existe | Exemplo de uso | Boa prática |
|---|---|---|---|
| Busca inteligente | Pesquisa por código, descrição, localização, marca ou PN. | Buscar `6204-2RS`, `SKF`, `PR-A1`, “sensor” ou código lido. | Comece pelo PN ou código quando a peça for técnica; é mais preciso que nome genérico. |
| Categoria | Mostra somente uma família de materiais. | Exibir hidráulica para contar mangueiras e conexões. | Use junto à busca para reduzir resultados. |
| Status crítico | Filtra estoque normal, baixo ou zerado. | Encontrar EPIs abaixo do mínimo antes do turno. | Revise baixo e zerado com compras; confirme o físico em caso de dúvida. |
| ID / código de barras | Identificadores do material. | Distinguir dois sensores semelhantes. | Leia o código e a descrição juntos. |
| Descrição / detalhes | Nome e características que identificam o item. | Diferenciar rolamento blindado de rolamento aberto. | Não escolha somente pelo primeiro termo da descrição. |
| Localização | Endereço para encontrar o item físico. | `AL-C2`. | Se o item não estiver lá, investigue antes de alterar o saldo. |
| Estoque atual | Saldo registrado no sistema. | 6 unidades. | É a referência operacional até que a contagem física justifique uma correção. |
| Estoque mínimo | Faixa de alerta definida para reposição. | Mínimo 10; saldo 6. | Não confunda mínimo com saldo desejado ou máximo. |
| Status | Situação visual do saldo: normal, baixo ou zerado. | Baixo para 6/10; zerado para 0. | Use como sinal de ação, não como substituto da análise de consumo. |

## Ajuste físico de inventário

O ajuste altera o saldo para o valor contado de verdade. É como acertar o odômetro de uma história que precisa continuar confiável: por isso deve haver uma contagem, uma justificativa clara e autorização conforme a regra da empresa.

| Campo | O que significa | Quem / quando informa | Exemplo | Erros comuns e boa prática |
|---|---|---|---|---|
| Saldo atual | Quantidade registrada antes do ajuste; é apenas para consulta. | Sistema apresenta ao responsável autorizado. | 12 unidades. | Não presuma que ele está errado sem contar o físico. |
| Novo saldo real | Quantidade efetivamente contada no endereço do item. | Almoxarife autorizado durante inventário ou apuração. | 10 unidades. | Digite o total contado, não a diferença. Se havia 12 e foram contadas 10, informe 10. |
| Justificativa / motivo | Explicação do porquê da divergência. | Responsável pelo ajuste. | `Inventário rotativo: duas unidades danificadas segregadas`; `contagem corrigida após localização em prateleira vizinha`. | Nunca escreva apenas “ajuste” ou “erro”. Descreva o fato, local e motivo quando possível. |

### Ajuste não substitui movimentação

| Situação encontrada | Registro correto |
|---|---|
| Chegaram 10 filtros e foram conferidos | Recebimento por sessão. |
| Técnico levou 2 sensores para uma máquina | Saída direta ou entrega de solicitação. |
| Foram encontrados 3 itens a menos na contagem após investigação | Ajuste, com justificativa. |
| Material retornou em condições de uso | Siga a rotina interna de devolução; não trate como “ajuste” sem registrar o motivo. |

## Exemplos do dia a dia

1. No inventário rotativo, o sistema mostra **12 chaves de impacto**, mas a contagem física encontra 10. O responsável verifica saídas pendentes e prateleiras próximas. Confirmada a diferença, informa novo saldo 10 e explica o motivo.
2. Um técnico pede “um sensor”. O almoxarife usa a busca por **PN**, confere o saldo e a localização e evita entregar um sensor parecido, porém incompatível.
3. Compras filtra a categoria Hidráulica com status baixo e encontra óleo ISO 68 e conexões abaixo do mínimo, preparando a reposição com base em itens concretos.

## Dicas operacionais

- Conte por localização e por unidade de medida; metros, litros, pares e unidades não podem ser tratados da mesma forma.
- Antes de ajustar, procure material em devolução, bancada, separação, endereço vizinho e solicitações em andamento.
- Guarde evidências internas da contagem quando a regra da empresa exigir.
- Ajustes frequentes para o mesmo item são sinal para revisar o processo de recebimento, saída ou endereçamento.

## Perguntas frequentes

**Posso usar ajuste para registrar uma entrada esquecida?** Não. Use o processo de recebimento quando a origem for uma chegada de material.

**O que quer dizer estoque zerado?** Que o sistema não registra nenhuma unidade disponível. Antes de prometer atendimento, confirme também a área física e eventuais recebimentos ainda em conferência.

**Quem pode ajustar?** Somente o perfil autorizado pela empresa, após contagem e justificativa.

---

# 8. Importação de planilha

## O que é este módulo?

É a porta de entrada controlada para migrar uma lista já existente para o ERP, por exemplo na implantação inicial ou na atualização autorizada de um acervo. Não é a rotina para lançar uma entrega diária: entradas do dia a dia continuam sendo feitas pelo recebimento por sessões.

O importador verifica se as informações básicas são coerentes antes de incluí-las, ajudando a impedir que uma planilha leve duplicidades ou endereços confusos para o estoque.

## Informações verificadas na planilha

| Informação | Por que é verificada | Exemplos corretos | Cuidados |
|---|---|---|---|
| Código do item | Garante que cada ficha tenha uma identidade própria. | `IT-041`, `IT-112`, `IT-205`. | Não repita o mesmo código em linhas de materiais diferentes. |
| Categoria | Mantém cada item na família operacional correta. | Elétrica para cabo; Mecânica para rolamento; Ferramentas para alicate. | Padronize os nomes antes da importação; não invente variações como “Elétricos” se a categoria adotada é “Elétrica”. |
| Localização | Permite localizar o material fisicamente desde o início. | `PR-A1`, `AL-C2`, `EST-03`. | Use o padrão adotado pela empresa e confira se a etiqueta física existe. |

## Preparação antes de importar

1. Faça uma cópia preservada da planilha original.
2. Remova linhas duplicadas e confirme qual delas representa o saldo correto.
3. Padronize descrições, marcas, unidades e categorias.
4. Confira os endereços físicos no almoxarifado.
5. Revise os itens críticos com manutenção e compras, principalmente PN, unidade e mínimo.
6. Analise o relatório de inconsistências e corrija a fonte antes de tentar novamente.

## Exemplos do dia a dia

1. A planilha traz três linhas de **rolamento 6204-2RS SKF** com o mesmo código interno. Antes de importar, a equipe unifica a informação e confirma se os saldos devem ser somados ou se representam endereços distintos a serem organizados.
2. Uma linha indica o cabo como categoria “Mecânica”. O responsável corrige para **Elétrica** antes de importar, permitindo que o item apareça nas consultas corretas.
3. Um motor aparece localizado como “Prateleira”. A equipe transforma a informação em endereço padronizado, como `PR-B3`, e coloca a etiqueta na posição física.

## Dicas operacionais

- Trate o relatório de inconsistências como uma lista de conferência, não como algo a ignorar.
- A planilha só é confiável após ser confrontada com a organização física do almoxarifado.
- Para novos recebimentos após a migração, use a sessão de recebimento; não reimporte a planilha inteira para acrescentar uma nota.

## Perguntas frequentes

**Posso importar a mesma planilha duas vezes?** Não sem revisão. Isso pode criar duplicidades ou repetir saldos.

**O que faço quando há inconsistência?** Corrija o dado na origem, valide novamente e só então prossiga.

---

# 9. Situações comuns e decisão rápida

| Situação | O que fazer | O que evitar |
|---|---|---|
| Chegou material de fornecedor | Abrir sessão, conferir e confirmar a entrada ao final. | Aumentar saldo por ajuste. |
| Código de embalagem é novo, mas o produto já existe | Associar o código à ficha correta após comparar PN/descrição. | Criar outro cadastro para o mesmo item. |
| Técnico precisa de uma peça agora | Usar saída direta e registrar destino, quantidade e solicitante. | Entregar sem baixa “para lançar depois”. |
| Manutenção planeja vários materiais | Criar solicitação, priorizar e despachar após separação. | Fazer várias saídas diretas duplicando o atendimento. |
| Saldo do sistema diverge da contagem | Investigar e, se confirmado, fazer ajuste justificado por pessoa autorizada. | Ajustar sem contagem ou sem motivo. |
| Item está abaixo do mínimo | Confirmar saldo, consumo e pedidos em andamento; acionar reposição conforme rotina. | Comprar automaticamente sem análise. |
| Não encontro o material na localização | Procurar em endereços próximos, separação e devoluções; informar a divergência. | Alterar o saldo para zero sem investigação. |

---

# 10. Checklist de qualidade do almoxarifado

Antes de encerrar o turno, confira:

- [ ] Há sessão de recebimento aberta? Ela foi conferida, confirmada ou comunicada ao próximo turno?
- [ ] Saídas de balcão foram registradas com quantidade, setor e solicitante?
- [ ] Solicitações de prioridade alta foram avaliadas?
- [ ] Itens abaixo do mínimo foram verificados para ação de reposição?
- [ ] Ajustes realizados possuem uma justificativa que outra pessoa consegue entender?
- [ ] Materiais recebidos e separados estão na localização indicada no sistema?

## Mensagem final

Um ERP confiável não depende apenas do sistema: depende de cada conferência, cada descrição clara e cada saída registrada no momento certo. Quando o cadastro identifica bem, o recebimento confirma bem e a saída informa o destino, o almoxarifado deixa de ser apenas um local de guarda e passa a apoiar a operação com segurança, agilidade e previsibilidade.
