<?php

function home(&$model){
    return 'home_view';
}
function login(&$model)
{
    $model['message']='';
    if(!empty($_SESSION['user_id'])){
        return 'redirect:' . 'home';
    }
    if (isset($_SERVER['REQUEST_METHOD'])) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //mechanizm logowania
            $visitor=[
                'login'=>$_POST['login'],
                'password'=>$_POST['password']
            ];
            $result=log_in($visitor);
            if($result!==false) {
                session_regenerate_id();
                $_SESSION['user_id']=$result;
                return 'redirect:' . 'home';
            }
            else{
                $model['message']='Wpisano niepoprawne dane';
                return 'login_view';
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            //wyswietlenie widoku
            return 'login_view';
        }
        else return 'home';
    } else {
        return 'login_view';
    }
}
function logout(&$model){
    session_destroy();
    return 'redirect:' . 'home';
}
function register(&$model){
    $model['message']='';
    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            return 'register_view';
            break;

        case 'POST':

            $counter=0;
            foreach($_POST as $element){
                if(!empty($element)) $counter++;
            }

            if($counter===count($_POST)){
                $user=[
                    'name'=>$_POST['name'],
                    'surname'=>$_POST['surname'],
                    'login'=>$_POST['login'],
                    'password'=>$_POST['password'],
                    're_password'=>$_POST['re_password'],
                    'email'=>$_POST['email'],
                ];
                $res=registration($user);
                if($res===3){
                    return 'redirect: '.'login';
                }
                elseif($res===2){
                    $model['message']='Hasla nie sa takie same!';
                }
                elseif($res===1){
                    $model['message']='Konto istnieje!';
                }
            }
            else{
                $model['message']='Nie wypełniono wszystkich pól!';
            }
            break;
    }
    return 'register_view';
}
function add_photo(&$model){
    $model['info']='';
    $model['user']='';
    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            if(empty($_SESSION['user_id'])){
                $model['user']='quest';
            }
            else{
                $model['user']=get_login($_SESSION['user_id']);
            }
            return 'add_photo_view';
            break;
        case 'POST':
            $model['user']='quest';
            $counter=0;
            foreach($_POST as $element){
                if(!empty($element)) $counter++;
            }
            if($counter!==count($_POST)){
                $model['info']='Wypełnij wszystkie pola';
                return 'add_photo_view';
            }
            $result=validate($_FILES['photo']);
            //wszystko ok
            if($result===0){
                $data=[
                    'author'=>$_POST['author'],
                    'title'=>$_POST['title'],
                    'watermark'=>$_POST['water_mark'],
                ];
                if(empty($_SESSION['user_id'])){
                    $data['access']='public';
                }
                else{
                    $data['access']=$_POST['access'];
                }
                //dodawnie zdjecia
                //mechanizm dodania
                if(add_pic($_FILES['photo'], $_SERVER['DOCUMENT_ROOT'].'/images',$data)){
                    return 'redirect: '.'home';
                }
                else{
                    $model['info']='Coś poszło nie tak';
                }

            }
            //plik za duzy
            elseif($result===1 || $result=== 2 || $result ===10){
                $model['info']='Dodawanie nie powiodło się przez zbyt duży rozmiar pliku';
            }
            //zly typ pliku
            elseif ($result===9){
                $model['info']='Dodawanie nie powiodło się, próba dodania pliku z błędnym rozszerzeniem';
            }
            //pozostale bledy
            else{
                $model['info']='Dodawanie nie powiodło się';
            }
            return 'add_photo_view';
            break;
    }
}
function gallery(&$model){
    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':{
            (empty($_SESSION['user_id'])) ? $user='quest' : $user=$_SESSION['user_id'];

            if(isset($_GET['page']))
                $page=$_GET['page'];
            else {
                $page = 1;
            }
            if(isset($_SESSION['saved_photos'])){
                $model['saved_photos']=$_SESSION['saved_photos'];
            }
            else{
                $model['saved_photos']=[];
            }
            $photos_limit=5;
            $photos_number=load_pictures($model,$user,$page, $photos_limit);

            $page_number=ceil($photos_number/$photos_limit);
            $photos_on_current_page=$photos_number-($photos_limit*($page-1));
            if($photos_on_current_page<=0 && $photos_number>0){
                return 'redirect: '.'gallery';
            }
            elseif($photos_on_current_page<=0 || $photos_number==0){
                $model['info']='Brak zdjęć';
            }
            else{
                $model['info']='OK';
                $model['pages']=$page_number;
                $model['current_page']=$page;
            }
            if(!empty($_SESSION['user_id'])){
                $model['logged']=true;
            }
            else{
                $model['logged']=false;
            }
            return 'gallery_view';
            break;
        }
    }
    return 'gallery_view';
}
function picture(&$model){
    if(!empty($_GET['path'])){
        $model['photo']=get_picture($_GET['path']);
        return 'picture_view';
    }
    return 'redirect: '.'home';
}
function photos_clipboard(&$model){
    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':{
            if(isset($_SESSION['saved_photos'])) {
                if(count($_SESSION['saved_photos'])!==0) {
                    (empty($_SESSION['user_id'])) ? $user = 'quest' : $user = $_SESSION['user_id'];

                    $model['photos'] = $_SESSION['saved_photos'];
                    $model['info'] = 'OK';
                }
                else{
                    $model['info']='Brak zapamiętanych zdjęć';
                }
            }
            else{
                $model['info']='Brak zapamiętanych zdjęć';
            }
            return 'photos_clipboard_view';
        }
        case 'POST':{
            $index=0;
            if(isset($_SESSION['saved_photos'])){
                $index=count($_SESSION['saved_photos']);
            }else {
                $_SESSION['saved_photos'] = [];
            }
            foreach($_POST as $element){
                if(substr($element,0,5)==='save_'){
                    $id=substr($element,strlen('save_'),strlen($element)-strlen('save_'));
                    if(exist($_SESSION['saved_photos'],$id,'id')==-1) {
                        $_SESSION['saved_photos'][$index] = load_photo_by_id($id);
                        $index++;
                    }
                }
            }
            return 'redirect: '.$_SERVER['HTTP_REFERER'];
        }
    }
}
function photos_clipboard_delete(&$model)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        return 'redirect: ' . 'gallery';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ids = [];
        $index = 0;
        $model['deleted'] = [];
        foreach ($_POST as $element) {
            if (substr($element, 0, strlen('delete_')) === 'delete_') {
                $ids[$index] = substr($element, strlen('delete_'), strlen($element) - strlen('delete_'));
                $index++;
            }
        }
        $_SESSION['saved_photos']=clear_clipboard($_SESSION['saved_photos'], $ids);
        return 'redirect: ' . 'photos_clipboard';
       // return 'photos_clipboard_delete_view';

    }
    return 'redirect: ' . 'home';
}
function my_history(&$model){
    return 'mojahistoria_view';
}
function search(&$model){
    if($_SERVER['REQUEST_METHOD']=='GET'){
        return 'search_view';
    }
    elseif($_SERVER['REQUEST_METHOD']=='POST'){
        $title=$_POST['title'];
        if($title!=='.' && $title!=='') {
            $model['photos'] = find_match_title($title);
        }
        else {
            $model['photos'] =[];
        }
        if(!empty($_SESSION['user_id'])){
            $model['logged']=true;
        }
        else{
            $model['logged']=false;
        }
        if(isset($_SESSION['saved_photos'])){
            $model['saved_photos']=$_SESSION['saved_photos'];
        }
        else{
            $model['saved_photos']=[];
        }

        return 'search_result';
    }
}
function rubiks_history(&$model){
    return 'rubikahistoria_view';
}
function szescienne(&$model){
    return 'szescienne_view';
}
function dwunastoscienne(&$model){
    return 'dwunastoscienne_view';
}
function czworoscienne(&$model){
    return 'czworoscienne_view';
}