<!DOCTYPE>
<html>
<?php include 'partial/head.php'?>
<body>
<div class="wrapper">
    <?php include 'partial/header.php' ?>
    <div class="page" id="clipboardPage">
        <div class="message">
            <div class="gallery">
                <?php
                if($info==='OK') :
                    ?>
                    <form method='post' action="photos_clipboard_delete">
                        <input type="submit" value="Usuń z zapamiętanych">
                        <div class="photos">
                            <?php
                            foreach ($photos as $photo):
                                ?>
                                <div class="photo">
                                    <a href="picture?path=<?=$photo['path']?>"><img src="images/<?=$photo['path']?>" alt="photo"/> </a>
                                    <div>
                                <span>
                                    Autor: <?= $photo['author'] ?>
                                    <br/>
                                    Tytuł: <?= $photo['title'] ?>
                                </span>
                                        <input type="checkbox" name="<?=$photo['id']?>" value="delete_<?=$photo['id']?>">
                                    </div>
                                    <?php
                                    if(!empty($_SESSION['user_id'])):?>
                                        <span id="access">Dostęp:
                                        <?php if($photo['access']==='public') echo 'Publiczny';
                                        else echo 'Prywatny';?>
                                    </span>
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            <?php
                            endforeach;
                            ?>
                        </div>
                    </form>
                <?php
                else:
                    ?>
                    <div class="info"><?= $info ?></div>
                <?php
                endif;
                ?>
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
