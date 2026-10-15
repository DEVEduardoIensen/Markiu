# Tarefa de Faculdade - Consumo e Criação de API (Markiu)

Projeto desenvolvido para a atividade acadêmica contendo:
1. **Consumo de API Gratuita** online (AwesomeAPI de cotações de moedas em tempo real).
2. **Criação de API RESTful** simples de Produtos com rotas `GET`, `POST`, `PUT`, `DELETE`.
3. **Resource** para padronizar e formatar a saída dos dados para JSON.
4. **Service** com regras de negócio e o método `update`.
5. **Testes automatizados** verificando a regra de negócio e 2 testes para o método `update`.
6. **Collection do Postman** (`postman_collection.json`) para testes das rotas.
7. **Desafio**: Outro projeto local em outro framework (Node.js / Express) que consome a API criada, além de uma interface visual (`cliente.html`).

---

## 🚀 Como Executar o Projeto

### 1. Iniciar o servidor PHP da API
Abra o terminal na pasta do projeto e rode:
```bash
php -S localhost:8000
```

Pronto! Agora você tem os seguintes acessos no navegador:
- **Página Inicial com Atalhos:** [http://localhost:8000](http://localhost:8000)
- **Painel Web do Cliente:** [http://localhost:8000/cliente.html](http://localhost:8000/cliente.html)
- **API RESTful (JSON):** [http://localhost:8000/api.php](http://localhost:8000/api.php)
- **Consumo de API Externa:** [http://localhost:8000/consumo.php](http://localhost:8000/consumo.php)
- **Executar Testes Unitários:** [http://localhost:8000/testes.php](http://localhost:8000/testes.php)

---

## 📋 Arquivos e Estrutura da Tarefa

| Arquivo | Descrição |
|---|---|
| `service.php` | Camada de serviço contendo a regra de negócio e o **método `update`** solicitado. |
| `resource.php` | Camada **Resource** que formata os dados do produto (valores em R$, tipos numéricos) para a resposta da API. |
| `api.php` | Implementação das rotas **RESTful** (`GET`, `POST`, `PUT`, `DELETE`). |
| `consumo.php` | **Consumo de API externa** gratuita (AwesomeAPI cotações de moedas em tempo real). |
| `testes.php` | **Testes unitários** (1 teste de regra de negócio na criação + 2 testes do método `update` do service). |
| `postman_collection.json` | Arquivo para importar no Postman com todas as requisições configuradas. |
| `cliente.html` | Interface web em HTML/JS com Fetch que consome a API criada. |
| `cliente_node/` | **Desafio**: Projeto local em outro framework (**Express.js / Node.js**) consumindo a API PHP. |

---

## 🧪 Como Rodar os Testes

Você pode rodar os testes direto pelo terminal:
```bash
php testes.php
```
Ou abrindo no navegador:
```
http://localhost:8000/testes.php
```

Os testes cobrem os 3 requisitos exigidos:
1. **Teste 1**: Verifica que o produto **NÃO é criado** se o valor for menor ou igual a zero (regra de negócio).
2. **Teste 2**: Verifica que o método `update` do service atualiza os dados do produto com sucesso.
3. **Teste 3**: Verifica que o método `update` do service bloqueia atualização caso o novo valor viole a regra de negócio.

---

## 📮 Testes no Postman
1. Abra o **Postman**.
2. Clique no botão **Import** e selecione o arquivo `postman_collection.json`.
3. Todas as rotas (GET, POST, PUT, DELETE e Consumo Externo) já estarão configuradas com testes automáticos de status code e retorno!

---

## 🌟 Desafio (Outro Projeto Local em Outro Framework)
O projeto cliente foi criado em **Node.js com Express** na pasta `cliente_node/`:
```bash
cd cliente_node
npm install
node server.js
```
Ele subirá em `http://localhost:3000` consumindo os produtos da API PHP em `http://localhost:8000/api.php`!
