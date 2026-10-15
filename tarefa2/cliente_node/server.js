// DESAFIO: Outro projeto local (em Express.js / Node.js) consumindo a API PHP
const express = require('express');
const app = express();
const PORT = 3000;

// URL da API criada em PHP
const API_URL = 'http://localhost:8000/tarefa2/api.php';

app.use(express.urlencoded({ extended: true }));
app.use(express.json());

// Rota inicial: consome a API PHP e exibe a lista de produtos
app.get('/', async (req, res) => {
    try {
        const resposta = await fetch(API_URL);
        const produtos = await resposta.json();

        let itensTabela = '';
        if (Array.isArray(produtos) && produtos.length > 0) {
            produtos.forEach(p => {
                itensTabela += `
                    <tr>
                        <td>${p.id}</td>
                        <td>${p.nome}</td>
                        <td><strong>${p.valor_formatado}</strong></td>
                        <td>${p.quantidade}</td>
                    </tr>
                `;
            });
        } else {
            itensTabela = `<tr><td colspan="4">Nenhum produto cadastrado.</td></tr>`;
        }

        res.send(`
            <!DOCTYPE html>
            <html lang="pt-BR">
            <head>
                <meta charset="UTF-8">
                <title>Desafio - Projeto Node/Express Consumindo API PHP</title>
                <style>
                    body { font-family: Arial, sans-serif; background: #eef2f6; margin: 30px; }
                    .card { background: white; padding: 25px; border-radius: 8px; max-width: 700px; margin: auto; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
                    h1 { color: #1e3a8a; font-size: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background: #f8fafc; }
                    .box-cadastro { margin-top: 25px; background: #f8fafc; padding: 15px; border-radius: 6px; }
                    input { padding: 8px; margin-right: 5px; }
                    button { padding: 8px 15px; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; }
                </style>
            </head>
            <body>
                <div class="card">
                    <h1>Desafio: Cliente Node.js / Express</h1>
                    <p>Consumindo a API PHP RESTful em: <code>${API_URL}</code></p>
                    
                    <h3>Produtos Retornados da API:</h3>
                    <table>
                        <thead>
                            <tr><th>ID</th><th>Nome</th><th>Valor (Resource)</th><th>Qtd</th></tr>
                        </thead>
                        <tbody>${itensTabela}</tbody>
                    </table>

                    <div class="box-cadastro">
                        <h4>Cadastrar Produto via POST na API PHP</h4>
                        <form method="POST" action="/criar">
                            <input type="text" name="nome" placeholder="Nome" required>
                            <input type="number" step="0.01" name="valor" placeholder="Valor (R$)" required>
                            <input type="number" name="quantidade" placeholder="Qtd" required>
                            <button type="submit">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </body>
            </html>
        `);
    } catch (e) {
        res.status(500).send(`
            <h2>Erro ao conectar com a API PHP</h2>
            <p>Certifique-se de que a API PHP está rodando em <code>http://localhost:8000</code>.</p>
            <p>Erro: ${e.message}</p>
        `);
    }
});

app.post('/criar', async (req, res) => {
    try {
        await fetch(API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                nome: req.body.nome,
                valor: parseFloat(req.body.valor),
                quantidade: parseInt(req.body.quantidade)
            })
        });
        res.redirect('/');
    } catch (e) {
        res.send('Erro ao cadastrar: ' + e.message);
    }
});

app.listen(PORT, () => {
    console.log(`Desafio (Node.js Express) rodando em: http://localhost:${PORT}`);
});
