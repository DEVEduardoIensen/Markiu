# Tarefa 2: Consumo de API, Criação de API RESTful e Desafio

## Requisitos Implementados:

### 1. CONSUMO DE API
- Consumo de API online gratuita (AwesomeAPI cotações de moedas em tempo real: Dólar, Euro e Bitcoin).
- Arquivo: `consumo.php`.
- Teste via terminal: `php consumo.php`
- Teste via navegador: `http://localhost:8000/tarefa2/consumo.php`

### 2. CRIAÇÃO DE API
- **A. Rotas RESTful**:
  - `GET /tarefa2/api.php` — Listar todos os produtos.
  - `GET /tarefa2/api.php?id=1` — Detalhes do produto por ID.
  - `POST /tarefa2/api.php` — Criar produto.
  - `PUT /tarefa2/api.php?id=1` — Atualizar produto.
  - `DELETE /tarefa2/api.php?id=1` — Deletar produto.
- **B. Resource**:
  - Arquivo: `resource.php` (`ProdutoResource::formatar()` e `formatarColecao()`) para formatar o JSON de resposta (adicionando valor formatado em R$, padronizando tipos).
- **C. Teste com Postman**:
  - Arquivo: `postman_collection.json` pronto para importar no Postman com todas as requisições.

### 3. DESAFIO
- Outro projeto local em outro framework (**Node.js / Express**) que consome a API criada.
- Pasta: `cliente_node/`
- Como rodar o cliente Node:
  ```bash
  cd cliente_node
  npm install
  node server.js
  ```
  Ele subirá em `http://localhost:3000` consumindo a API PHP.
- Interface Web alternativa: `cliente.html` aberta pelo navegador.
