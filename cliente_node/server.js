// DESAFIO: Projeto em outro framework (Express.js / Node.js) que consome a API PHP
const express = require('express');
const app = express();
const PORT = 3000;

// URL da nossa API criada em PHP
const API_PHP_URL = 'http://localhost:8000/api.php';

app.use(express.urlencoded({ extended: true }));
app.use(express.json());

// Rota Principal: Consome a API PHP e exibe os produtos na tela
app.get('/', async (req, res) => {
    try {
        const resposta = await fetch(API_PHP_URL);
        const produtos = await resposta.json();

        let html = `
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <title>Projeto Cliente (Express / Node.js) - Consumindo API PHP</title>
            <style>
                body { font-family: Arial, sans-serif; background: #eef2f5; margin: 30px; }
                .container { max-width: 800px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
                h1 { color: #1e3a8a; font-size: 22px; margin-bottom: 5px; }
                p.sub { color: #666; font-size: 14px; margin-top: 0; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
                th { background: #f8fafc; color: #333; }
                .btn { padding: 6px 12px; border-radius: 4px; border: none; cursor: pointer; text-decoration: none; display: inline-block; }
                .btn-danger { background: #ef4444; color: white; }
                .btn-primary { background: #3b82f6; color: white; }
                .form-box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 6px; margin-top: 25px; }
                input { padding: 8px; margin-right: 10px; border: 1px solid #ccc; border-radius: 4px; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Projeto Cliente em Node.js / Express</h1>
                <p class="sub">Consumindo a API PHP RESTful em: <code>${API_PHP_URL}</code></p>

                <h3>Lista de Produtos Recebidos da API PHP</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Valor Formatado (Resource)</th>
                            <th>Quantidade</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        if (Array.isArray(produtos) && produtos.length > 0) {
            produtos.forEach(p => {
                html += `
                    <tr>
                        <td>${p.id}</td>
                        <td>${p.nome}</td>
                        <td><strong>${p.valor_formatado || 'R$ ' + p.valor}</strong></td>
                        <td>${p.quantidade}</td>
                        <td>
                            <a href="/deletar/${p.id}" class="btn btn-danger" onclick="return confirm('Deseja excluir?')">Excluir</a>
                        </td>
                    </tr>
                `;
            });
        } else {
            html += `<tr><td colspan="5">Nenhum produto cadastrado no momento.</td></tr>`;
        }

        html += `
                    </tbody>
                </table>

                <div class="form-box">
                    <h3>Cadastrar Novo Produto (via POST na API PHP)</h3>
                    <form method="POST" action="/criar">
                        <input type="text" name="nome" placeholder="Nome do Produto" required>
                        <input type="number" step="0.01" name="valor" placeholder="Valor (R$)" required>
                        <input type="number" name="quantidade" placeholder="Qtd" required>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>
        </body>
        </html>
        `;

        res.send(html);
    } catch (erro) {
        res.status(500).send(`
            <h2>Erro ao conectar com a API PHP</h2>
            <p>Verifique se o servidor PHP está rodando em <code>http://localhost:8000</code>.</p>
            <p>Detalhes: ${erro.message}</p>
        `);
    }
});

// Ação de Criar Produto (faz POST na API PHP)
app.post('/criar', async (req, res) => {
    try {
        await fetch(API_PHP_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                nome: req.body.nome,
                valor: parseFloat(req.body.valor),
                quantidade: parseInt(req.body.quantidade)
            })
        });
        res.redirect('/');
    } catch (erro) {
        res.send('Erro ao cadastrar produto: ' + erro.message);
    }
});

// Ação de Deletar Produto (faz DELETE na API PHP)
app.get('/deletar/:id', async (req, res) => {
    try {
        await fetch(`${API_PHP_URL}?id=${req.params.id}`, {
            method: 'DELETE'
        });
        res.redirect('/');
    } catch (erro) {
        res.send('Erro ao deletar produto: ' + erro.message);
    }
});

// Rota que retorna o JSON puro consumido da API PHP
app.get('/api-json', async (req, res) => {
    try {
        const resposta = await fetch(API_PHP_URL);
        const dados = await resposta.json();
        res.json({
            cliente: 'Node.js Express',
            dados_consumidos: dados
        });
    } catch (erro) {
        res.status(500).json({ erro: erro.message });
    }
});

app.listen(PORT, () => {
    console.log(`====================================================`);
    console.log(`Servidor Cliente Express rodando em: http://localhost:${PORT}`);
    console.log(`Consumindo API PHP em: ${API_PHP_URL}`);
    console.log(`====================================================`);
});
