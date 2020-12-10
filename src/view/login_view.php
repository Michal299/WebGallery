<!DOCTYPE>
<html lang="pl">
<?php include 'partial/head.php'?>
<body>
<div class="wrapper">
    <?php include 'partial/header.php' ?>
    <div class="page" id="loginPage">
        <div class="message">
            <div class="form">
                <span class="info"><?php echo $message ?></span>
                <form method="post" action="login">
                    <label>
                        LOGIN
                        <br/>
                        <input type="text" name="login" >
                    </label>
                    <label>
                        HASŁO
                        <br/>
                        <input type="password" name="password">
                    </label>
                    <input type="submit" value="Zaloguj">
                </form>
                <br/>
                Nie masz konta? <a href="register">Załóż je!</a>
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