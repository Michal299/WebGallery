<!DOCTYPE>
<html>
<?php include 'partial/head.php'?>
<body>
<div class="wrapper">
    <?php include 'partial/header.php' ?>
    <div class="page" id="picturePage">
        <div class="message">
            <div class="text">
            <div class="photo">
                <img src="<?=$photo['path']?>" alt="photo"/>
                <br/>
                <span id="author">Autor: <?=$photo['author']?></span>
                <br/>
                <span id="title">Tytuł: <?=$photo['title']?></span>
            </div>
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