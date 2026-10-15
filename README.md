# Markiu - Tarefas de Faculdade

Este repositório contém as duas tarefas acadêmicas separadas em pastas individuais:

---

## 📁 [Tarefa 1: Service e Testes](./tarefa1)
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
  *(Ou dê duplo clique em `tarefa1/rodar_testes.bat`)*

---

## 📁 [Tarefa 2: Consumo de API, Criação de API RESTful e Desafio](./tarefa2)
Localizada na pasta `tarefa2/`:
- **CONSUMO DE API**:
  - `tarefa2/consumo.php`: Consumo de API online gratuita (AwesomeAPI cotações de Dólar, Euro e Bitcoin em tempo real).
- **CRIAÇÃO DE API**:
  - `tarefa2/api.php`: Rotas RESTful (`GET`, `POST`, `PUT`, `DELETE`).
  - `tarefa2/resource.php`: Resource formatando o JSON de resposta (`valor_formatado`).
  - `tarefa2/postman_collection.json`: Collection exportada para testes no Postman.
- **DESAFIO**:
  - `tarefa2/cliente_node/`: Projeto local em outro framework (**Node.js / Express**) que consome a API PHP.
  - `tarefa2/cliente.html`: Interface web que consome a API PHP via Fetch.
- **Execução:**
  ```bash
  php -S localhost:8000
  ```
  *(Ou dê duplo clique em `iniciar_servidor.bat`)*

---

## ⚡ Solução rápida para o erro: "O termo 'php' não é reconhecido"
O PHP foi instalado e configurado em `C:\php`. Se o seu terminal foi aberto antes da instalação, basta:
1. Fechar o terminal atual e abrir um novo PowerShell; OU
2. No terminal aberto, rodar o comando:
   ```powershell
   $env:Path = "C:\php;" + $env:Path
   ```
3. Ou simplesmente dar um duplo clique no arquivo **`iniciar_servidor.bat`** ou **`rodar_testes.bat`**!
