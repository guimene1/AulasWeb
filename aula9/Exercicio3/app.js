const express = require('express');
const app = express();
const port = 3000;
const aleatorio = require('./utils.js');

app.get('/', (req, res) => {
    res.status(200).send("Bem Vindo!");
});

app.get('/numero', (req, res) => {
    const gerarAleatorio = aleatorio();
    res.json({numero : gerarAleatorio});
});

app.use((req, res) => {
    res.status(404).send("Página não encontrada.");
});

app.listen(port, () => {
    console.log(`Server listening at http://localhost:${port}`);
});
