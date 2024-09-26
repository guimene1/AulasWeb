const http = require('http');
const fs = require('node:fs');

const requestListener = function (req, res) {
    if (req.url === "/") { // Se o URL da solicitação for "/", retorna "Você está na página inicial"
        res.writeHead(200);
        res.end("Você está na página inicial");
    } else if (req.url === "/sobre") { // Se o URL da solicitação for "/sobre", retorna "Você está na página sobre"
        fs.readFile('/Users/Alunos/Desktop/aula7/sobre.txt', 'utf8', (err, data) => {
            if (err) {
                console.error(err);
                return;
            }
            else (
                res.end(data);
            )
            console.log(data);
        });
    } else { // Para qualquer outro URL, retorna "Página não encontrada"
        res.writeHead(404);
        res.end("Página não encontrada");
    }
};

const server = http.createServer(requestListener); // Cria um novo servidor
server.listen(8000, 'localhost', () => { // Vincula o servidor a uma porta e host, e define uma função de callback a ser chamada quando o servidor começar a escutar
    console.log("Servidor está rodando em http://localhost:8000");
});