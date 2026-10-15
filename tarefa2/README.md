# Tarefa 2: Consumo de API, Criação de API RESTful e Desafio

## Requisitos Implementados:

### 1. CONSUMO DE API
- Consumo de API online gratuita (AwesomeAPI cotações de moedas em tempo real: Dólar, Euro e Bitcoin).
- Arquivo: `consumo.php`.
- Teste via terminal: `php consumo.php`
- Teste via navegador: `http://localhost:8000/tarefa2/consumo.php`

### 2. CRIAÇÃO DE API
- **Rotas RESTful**:
  - `GET /tarefa2/api.php` — Listar todos os produtos.
  - `GET /tarefa2/api.php?id=1` — Detalhes do produto por ID.
  - `POST /tarefa2/api.php` — Criar produto.
  - `PUT /tarefa2/api.php?id=1` — Atualizar produto.
  - `DELETE /tarefa2/api.php?id=1` — Deletar produto.
- **Resource**:
  - Arquivo: `resource.php` (`ProdutoResource::formatar()` e `formatarColecao()`) para formatar os dados (adicionando valor formatado em R$, padronizando tipos).
- **Teste das Rotas na Tela (sem Postman)**:
  - Arquivo: `testar_api.php` para testar todas as rotas (Criar, Listar, Atualizar e Excluir) diretamente no navegador clicando em botões.

### 3. DESAFIO
- Consumo da API criada através de outro ambiente (**Node.js**):
  - Arquivo: `cliente.js`
  - Como rodar no terminal:
    ```bash
    node cliente.js
    ```
- Interface Web alternativa: `cliente.html` aberta pelo navegador.
