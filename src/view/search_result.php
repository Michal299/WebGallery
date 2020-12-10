<?php
if(count($photos)===0):
?>
<div class="info">Brak zdjęć</div>
<?php
else:
    foreach($photos as $photo):
?>
<div class="photo">
    <a href="picture?path=<?=$photo['path']?>"><img src="images/<?=$photo['path']?>" alt="photo"></a>
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
    endif;
    ?>
