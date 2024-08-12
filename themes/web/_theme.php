<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>BeesMap</title>
    <link rel="shortcut icon" type="image/png" href="<?= url("themes/_assets/imgs/bee-white.png") ?>"/>
    <link rel="stylesheet" href="<?= url("themes/web/assets/css/style-theme.css") ?>">
    <script src="<?= url("themes/web/assets/js/script-_theme.js") ?>" async></script>
</head>

<body>
    <nav id="navBar">
        <label id="lblLogo">
            <a href="<?= url("") ?>">
                <h1>BeesMap</h1>
                <img src="<?= url("themes/_assets/imgs/bee-white.png") ?>" alt="bee">
            </a>
        </label>
        <h1>|</h1>
        <label>
            <a href="<?= url("login") ?>">Login</a>
        </label>
        <h1>|</h1>
        <label>
            <a href="<?= url("") ?>">Inicio</a>
        </label>
        <h1>|</h1>
        <label>
            <a href="<?= url("faqs") ?>">Perguntas frequentes</a>
        </label>
        <h1>|</h1>
        <label>
            <a href="<?= url("contato") ?>">Contato</a>
        </label>
        <h1>|</h1>
        <label>
            <a href="<?= url("sobre") ?>">Sobre</a>
        </label>
    </nav>
    <?php
    echo $this->section("content");
    ?>
    <footer>
        <h1>2024 - João Pedro Anjolim Soares</h1>
    </footer>
</body>

</html>