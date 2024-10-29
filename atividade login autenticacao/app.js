const express = require('express');
const session = require('express-session');
const cookieParser = require('cookie-parser');
const app = express();
const PORTA = 8080;

app.use(cookieParser());

app.use(session(
    {
        secret: 'gui123',
        resave: false,
        saveUninitialized: true
    }
));

const usuarios = {
    usuario1: 'senha1',
}

app.post('/login', (req, res) => {
    const { username, password } = req.body;

    if (username === 'admin' && password === 'password123') {
        req.session.isAuthenticated = true;
        req.session.username = username;

        res.cookie('loggedIn', 'true', { maxAge: 900000, httpOnly: true });

        res.redirect('/dashboard');
    } else { res.render("login", { error: 'Credenciais inválidas' }) };
} 

);
app.get('/logout', (req, res) => {
    res.send('');
});



app.listen(8080);