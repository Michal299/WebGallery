<!DOCTYPE>
<html lang="pl">
<?php include 'partial/head.php'?>
<body>
<div class="wrapper">
    <?php include 'partial/header.php' ?>
    <div class="page" id="gallery_page">
        <div class="message">
            <div class="gallery">
                    <?php
                    if($info==='OK') :
                    ?>
                    <form method='post' action="photos_clipboard">
                        <input type="submit" value="Zapamiętaj wybór">
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
                                    <?php
                                    if($logged):?>
                                    <br/>
                                    Dostęp:
                                        <?php if($photo['access']==='public') echo 'Publiczny';
                                        else echo 'Prywatny';?>
                                    </span>
                                    <?php
                                    endif;
                                    ?>
                                    <input type="checkbox" name="<?=$photo['id']?>" value="save_<?=$photo['id']?>"
                                        <?php
                                            if(find($saved_photos,$photo))
                                                echo 'checked';
                                        ?>
                                    >
                                </div>
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
        <?php
        if($info==='OK'&&$pages>1):
            ?>
            <div class="paging">
                <?php
                for($i=1; $i<=$pages; $i++):
                    if($current_page==$i):
                        ?>
                        <a class="page_button" id="current_page" href="gallery?page=<?=$i?>"><?=$i?></a>
                    <?php
                    else:
                        ?>
                        <a class="page_button" href="gallery?page=<?=$i?>"><?=$i?></a>
                    <?php
                    endif;
                endfor;
                ?>
            </div>
        <?php
        endif;
        ?>
        <div id="dice">
            <a>
                <img id="clickable" src="static/Pictures/icon.png" alt="icon" />
            </a>
        </div>
    </div>
</div>
<script src="static/Scripts/script1.js" defer></script>
</body>
</html>