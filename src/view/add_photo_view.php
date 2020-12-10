<!DOCTYPE>
<html lang="pl">
<?php include 'partial/head.php'?>
<body>
<div class="wrapper">
    <?php include 'partial/header.php' ?>
    <div class="page" id="add_photo_page">
        <div class="message">
            <div class="form">
                <span class="info"><?php echo $info ?></span>
                <form enctype="multipart/form-data" action="add_photo"
                      method="post" >
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                    <label>
                        Tytuł zdjęcia
                        <br/>
                        <input type="text" name="title" />
                    </label>
                    <label>
                        Autor
                        <br/>
                        <input type="text" name="author" value="<?php if($user!=='quest') echo $user?>"/>
                    </label>
                    <label>
                        Treść znaku wodnego
                        <br/>
                        <input type="text" name="water_mark" />
                    </label>
                    <?php
                    if($user!=='quest'):
                    ?>
                    <label>
                        Tryb:
                        <label>
                            Prywatny
                            <input type="radio" id="private" name="access" value="private" checked>
                        </label>
                        <label>
                            Publiczny
                            <input type="radio" id="public" name="access" value="public">
                        </label>
                    </label>
                    <?php
                    endif;
                    ?>
                    <input type="file" name="photo" />
                    <input type="submit" value="Wyślij" />
                </form>
            </div>
            <div id="dice">
                <a>
                    <img id="clickable" src="static/Pictures/icon.png" alt="icon" />
                </a>
            </div>
        </div>
    </div>
</div>
<script src="static/Scripts/script1.js" defer></script>
</body>
</html>