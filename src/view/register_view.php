<!DOCTYPE>
<html lang="pl">
<?php include 'partial/head.php'?>
<body>
<div class="wrapper">
    <?php include 'partial/header.php' ?>
    <div class="page" id="registerPage">
        <div class="message">
            <div class="form">
                <span class="info"><?php echo $message ?></span>
                <form method="post" action="register">
                    <label>
                        Imie
                        <input type="text" name="name">
                    </label>
                    <label>
                        Nazwisko
                        <input type="text" name="surname">
                    </label>
                    <label>
                        Login
                        <input type="text" name="login">
                    </label>
                    <label>
                        Hasło
                        <input type="password" name="password">
                    </label>
                    <label>
                        Potwierdź hasło
                        <input type="password" name="re_password">
                    </label>
                    <label>
                        E-mail
                        <input type="text" name="email">
                    </label>
                    <input type="submit" name="Zarejestruj">
                </form>
            </div>
        </div>
        <div id="dice">
            <a>
                <img id="clickable" src="static/pictures/icon.png" alt="icon" />
            </a>
        </div>
    </div>
</div>
<script src="static/Scripts/script1.js" defer></script>
</body>
</html>