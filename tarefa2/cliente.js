// DESAFIO: Consumindo a API PHP criada através de outro ambiente (Node.js)
// Para executar no terminal: node cliente.js

const API_URL = 'http://localhost:8000/tarefa2/api.php';

async function consumirApi() {
    console.log("==========================================");
    console.log("DESAFIO: Consumindo a API PHP via Node.js");
    console.log("Endpoint:", API_URL);
    console.log("==========================================");

    try {
        const resposta = await fetch(API_URL);
        const produtos = await resposta.json();

        console.log("Produtos recebidos da API com sucesso:\n");
        produtos.forEach(p => {
            console.log(`[ID ${p.id}] ${p.nome} - ${p.valor_formatado} (Qtd: ${p.quantidade})`);
        });
        console.log("\n==========================================");
    } catch (erro) {
        console.log("Erro ao conectar com a API PHP:", erro.message);
        console.log("Lembre-se de rodar 'php -S localhost:8000' antes.");
    }
}

consumirApi();
