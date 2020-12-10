<?php
function find($table,$element){
    foreach($table as $item){
        if($item['id']==$element['id'])
            return true;
    }
    return false;
}