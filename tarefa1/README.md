# Tarefa 1: Service e Testes

## Requisitos Implementados:
- **SERVICE**:
  1. Criação do método `update` dentro do service (`ProdutoService::update($id, $dados)`).
  2. Implementação da regra de negócio (o valor do produto deve ser maior que zero: `valor > 0`).

- **TESTES**:
  1. Teste para verificar se o produto **não cria** se o valor não segue a regra de negócio (valor <= 0).
  2. Teste 1 do método `update`: Verifica atualização do produto com sucesso com valores válidos.
  3. Teste 2 do método `update`: Verifica que o método `update` bloqueia se o novo valor for inválido (<= 0).

## Como Executar os Testes:
No terminal, entre na pasta `tarefa1` e execute:
```bash
php testes.php
```
