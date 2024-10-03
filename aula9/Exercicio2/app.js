const express = require('express');
const app = express();
const port = 3000;

app.get('/', (req, res) => {
    res.status(200).send("Bem Vindo!");
});

app.get('/sobre', (req, res) => {
    res.status(200).send("Sou o Guilherme");
});

app.get('/contato', (req, res) => {
    res.status(200).send("Minhas informações são segredo irmão.");
});

app.use((req, res) => {
    res.status(404).send("Página não encontrada.");
});

app.listen(port, () => {
    console.log(`Server listening at http://localhost:${port}`);
});
