# Markiu - Tarefas de Faculdade

Este repositório contém tarefas acadêmicas separadas em pastas individuais:

---

## Tarefa 1: Service e Testes
Localizada na pasta `tarefa1/`:
- **SERVICE**:
  - `tarefa1/service.php`: Implementação da regra de negócio (`valor > 0`) e do método **`update`**.
- **TESTES**:
  - `tarefa1/testes.php`:
    1. Teste verificando que o produto **não cria** se o valor for inválido (<= 0).
    2. Teste do método **`update`** atualizando dados com sucesso.
    3. Teste do método **`update`** bloqueando a alteração caso o novo valor viole a regra de negócio.
- **Execução:**
  ```bash
  cd tarefa1
  php testes.php
  ```

---

## Tarefa 2: Consumo de API, Criação de API RESTful e Desafio
Localizada na pasta `tarefa2/`:
- **CONSUMO DE API**:
  - `tarefa2/consumo.php`: Consumo de API online gratuita (AwesomeAPI cotações de Dólar, Euro e Bitcoin em tempo real).
- **CRIAÇÃO DE API**:
  - `tarefa2/api.php`: Rotas RESTful (`GET`, `POST`, `PUT`, `DELETE`).
  - `tarefa2/resource.php`: Resource formatando o retorno dos dados (`valor_formatado`).
  - `tarefa2/testar_api.php`: Teste das rotas diretamente no navegador sem necessidade de Postman.
- **DESAFIO**:
  - `tarefa2/cliente.js`: Consumo da API em outro ambiente (**Node.js**), executado com `node cliente.js`.
  - `tarefa2/cliente.html`: Interface web que consome a API PHP via Fetch.
- **Execução:**
  ```bash
  php -S localhost:8000
  ```

---

## Tarefa 3: API de Produtos com Laravel

Localizada na pasta `tarefa3/`.

Projeto em desenvolvimento, importado da versão original de [4B-API-Produtos](https://github.com/Prof-Dionatan-CR/4B-API-Produtos).
