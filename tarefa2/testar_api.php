<?php
require_once __DIR__ . '/service.php';
require_once __DIR__ . '/resource.php';

$service = new ProdutoService();
$produtos = ProdutoResource::formatarColecao($service->listar());

$produtoEdicao = null;
if (isset($_GET['editar_id'])) {
    $produtoEdicao = $service->buscarPorId((int)$_GET['editar_id']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Testar API sem Postman</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 20px;">

    <h1>Tarefa 2 - Teste da API sem Postman</h1>
    <p>Aqui você testa todas as rotas da API RESTful clicando diretamente:</p>

    <p>
        <a href="api.php" target="_blank">[ Ver JSON Puro da API: GET /api.php ]</a> | 
        <a href="consumo.php">[ Ver Consumo da API Externa de Cotações ]</a> | 
        <a href="../tarefa1/testes.php">[ Ver Testes Unitários da Tarefa 1 ]</a>
    </p>
    <hr>

    <?php if (isset($_GET['msg'])): ?>
        <p style="color: green; font-weight: bold;">✔ <?= htmlspecialchars($_GET['msg']) ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <p style="color: red; font-weight: bold;">✖ <?= htmlspecialchars($_GET['erro']) ?></p>
    <?php endif; ?>

    <!-- 1. LISTA DE PRODUTOS (GET) -->
    <h3>1. Produtos Cadastrados (Rota GET /api.php)</h3>
    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; max-width: 700px;">
        <thead>
            <tr style="background: #f0f0f0;">
                <th>ID</th>
                <th>Nome</th>
                <th>Valor Formatado (Resource)</th>
                <th>Qtd</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($produtos)): ?>
                <tr><td colspan="5">Nenhum produto cadastrado.</td></tr>
            <?php else: ?>
                <?php foreach ($produtos as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['nome']) ?></td>
                        <td><strong><?= $p['valor_formatado'] ?></strong></td>
                        <td><?= $p['quantidade'] ?></td>
                        <td>
                            <a href="testar_api.php?editar_id=<?= $p['id'] ?>">Editar</a> | 
                            <a href="api.php?id=<?= $p['id'] ?>&_method=DELETE&redirect=1" onclick="return confirm('Deseja excluir este produto?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <hr>

    <?php if ($produtoEdicao): ?>
        <!-- 3. ATUALIZAR PRODUTO (PUT) -->
        <h3>3. Atualizar Produto #<?= $produtoEdicao['id'] ?> (Rota PUT /api.php com método Update do Service)</h3>
        <form method="POST" action="api.php">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="redirect" value="1">
            <input type="hidden" name="id" value="<?= $produtoEdicao['id'] ?>">

            Nome: <input type="text" name="nome" value="<?= htmlspecialchars($produtoEdicao['nome']) ?>" required> &nbsp;
            Valor (R$): <input type="number" step="0.01" name="valor" value="<?= $produtoEdicao['valor'] ?>" required> &nbsp;
            Qtd: <input type="number" name="quantidade" value="<?= $produtoEdicao['quantidade'] ?>" required> &nbsp;
            <button type="submit">Salvar Alterações (PUT)</button>
            <a href="testar_api.php">Cancelar</a>
        </form>
    <?php else: ?>
        <!-- 2. CRIAR PRODUTO (POST) -->
        <h3>2. Cadastrar Novo Produto (Rota POST /api.php)</h3>
        <form method="POST" action="api.php">
            <input type="hidden" name="redirect" value="1">
            Nome: <input type="text" name="nome" placeholder="Ex: Mochila" required> &nbsp;
            Valor (R$): <input type="number" step="0.01" name="valor" placeholder="Ex: 59.90" required> &nbsp;
            Qtd: <input type="number" name="quantidade" placeholder="Ex: 10" required> &nbsp;
            <button type="submit">Cadastrar (POST)</button>
        </form>
    <?php endif; ?>

    <hr>
    <p><a href="../index.php">Voltar para a página inicial</a></p>

</body>
</html>
