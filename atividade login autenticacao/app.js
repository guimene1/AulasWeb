const express = require('express');
const session = require('express-session');
const cookieParser = require('cookie-parser');
const bodyParser = require('body-parser');
const app = express();
const PORTA = 8080;

app.set('view engine', 'ejs');
app.set('views', './views');

app.use(cookieParser());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

app.use(session({
    secret: 'gui123',
    resave: false,
    saveUninitialized: true
}));

const usuarios = {
    usuario1: 'senha1',
    usuario2: 'senha2',
};

function isAuthenticated(req, res, next) {
    if (req.session.isAuthenticated) {
        return next();
    }
    res.redirect('/login');
}

app.get('/login', (req, res) => {
    res.render("login");
});

app.post('/login', (req, res) => {
    const { username, password } = req.body;


    if (usuarios[username] && usuarios[username] === password) {
        req.session.isAuthenticated = true;
        req.session.username = username;

        res.cookie('loggedIn', 'true', { maxAge: 900000, httpOnly: true });
        res.redirect('/dashboard');
    } else {
        res.render("login", { error: '' });
    }
});

app.get('/logout', (req, res) => {
    req.session.destroy(err => {
        if (err) {
            return res.redirect('/dashboard');
        }
        res.clearCookie('loggedIn');
        res.redirect('/login');
    });
});

app.get('/dashboard', isAuthenticated, (req, res) => {
    res.render('dashboard', { username: req.session.username });
});

app.listen(PORTA, () => {
    console.log(`Server is running on http://localhost:${PORTA}`);
});
