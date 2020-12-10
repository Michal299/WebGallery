<?php
use MongoDB\BSON\ObjectID;
function get_db()
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);

    $db = $mongo->wai;
    return $db;
}
function log_in($visitor){
    $db=get_db();
    $user=$db->users->findOne(['login'=>$visitor['login']]);
    if($user!==null && password_verify($visitor['password'],$user['password'])){
        return $user['_id'];
    }
    else{
        return false;
    }
}
function registration($user){
 $db=get_db();
 $login=$db->users->findOne(['login'=>$user['login']]);
 $email=$db->users->findOne(['email'=>$user['email']]);
 if($login!==null){
     return 1;
 }
 elseif($email!==null){
    return 1;
 }
 elseif($login==='quest'){
     return 1;
 }
 else{
     if($user['password']!==$user['re_password']) return 2;
     else{
         $data =[
             'login'=>$user['login'],
             'password'=>password_hash($user['password'],PASSWORD_DEFAULT),
             'name'=>$user['name'],
             'surname'=>$user['surname'],
             'email'=>$user['email']
         ];
         $db->users->insertOne($data);
         return 3;
     }
 }
}
function validate($photo_data){
    //bledy od 1 do 8
    if($photo_data['error']>0){
        return $photo_data['error'];
    }
    //blad typu pliku
    if($photo_data['type']!='image/jpeg' && $photo_data['type']!='image/png'){
        return 9;
    }
    //blad rozmiaru pliku
    if($photo_data['size']>1000000){
        return 10;
    }

    return 0;
}
function photo_exist($photo){
    $db=get_db();
    if(empty($_SESSION['user_id'])) {
        $current_user = 'quest';
    }
    else {
        $current_user = $_SESSION['user_id'];
        $r=$db->users->findOne(['_id'=>$current_user]);
        $current_user=$r['login'];
    }
    $query=[
        'owner'=>$current_user,
        'name'=>$photo['name']
    ];
    $result=$db->photos->findOne($query);
    if($result!==null){
        return true;
    }
    else{
        return false;
    }

}
function add_watermark($name,$text,$ext)
{
    $im = imagecreatetruecolor(300, 100);
    $text_color = imagecolorallocatealpha($im, 255, 255, 250, 50);
    $background = imagecolorallocate($im, 0, 0, 0);
    imagesavealpha($im, false);

    imagestring($im, 5, 0, 0, $text, $text_color);
    imagecolortransparent($im, $background);

    ($ext==='png') ? $photo=imagecreatefrompng('images/'.$name) : $photo=imagecreatefromjpeg('images/'.$name);

    imagecopymerge($photo, $im, imagesx($photo)/4, imagesy($photo)/4, 0, 0, imagesx($photo), imagesy($photo), 100);

    imagepng($photo, 'images/watermarked/'.$name);
    imagedestroy($photo);
}
function add_miniature($name,$ext){
    ($ext==='png') ? $src=imagecreatefrompng('images/'.$name) : $src=imagecreatefromjpeg('images/'.$name);
    $min=imagecreatetruecolor(200, 125);
    imagecopyresampled($min,$src,0,0,0,0,200,125,imagesx($src),imagesy($src));
    ($ext==='png') ? imagepng($min,'images/miniatures/'.$name,100) : imagejpeg($min,'images/miniatures/'.$name,100);
    imagedestroy($src);
    imagedestroy($min);
}
function add_pic(&$photo,$path,$data){
    if(photo_exist($photo)){
        return false;
    }
    $db=get_db();
    $day=date('d-m-Y');
    $hour=date('H-i-s');
    $photo_name=explode(".",$photo['name']);
    $photo_data=[
        'name'=>$photo['name'],
        'name_on_server'=>$photo_name[0].$day.$hour.'.'.$photo_name[1],
        'access'=>$data['access'],
        'title'=>$data['title'],
        'author'=>$data['author']
    ];
    if(empty($_SESSION['user_id'])){
        $photo_data['owner']='quest';
    }
    else{
        $user=$db->users->findOne(['_id'=>$_SESSION['user_id']]);
        $photo_data['owner']=$user['login'];
    }
    if(is_uploaded_file($photo['tmp_name'])){
        if(!move_uploaded_file($photo['tmp_name'],$path.'/'.$photo_data['name_on_server'])){
            return false;
        }
    }
    else{
        return false;
    }
    add_watermark($photo_data['name_on_server'],$data['watermark'],$photo_name[1]);
    add_miniature($photo_data['name_on_server'],$photo_name[1]);
    $db->photos->insertOne($photo_data);
    return true;
}
function load_pictures(&$model,$user,$page,$pageSize){
    $db=get_db();
    $opts=[
        'skip'=>($page-1)*$pageSize,
        'limit'=>$pageSize
    ];
    $user_name=($db->users->findOne(['_id'=>$user]))['login'];
    $photos=$db->photos->find([
       '$or' => [
           ['access'=>'public'],
           ['owner'=>$user_name]
       ]
    ],$opts);
    $model['photos']=[];
    $index=0;

    foreach($photos as $element){
        $model['photos'][$index]=[];
        $model['photos'][$index]['path']='miniatures/'.$element['name_on_server'];
        $model['photos'][$index]['author']=$element['author'];
        $model['photos'][$index]['title']=$element['title'];
        $model['photos'][$index]['access']=$element['access'];
        $model['photos'][$index]['id']=$element['_id'];
        $index++;
    }

    $photos2=$db->photos->find([
        '$or' => [
            ['access'=>'public'],
            ['owner'=>$user_name]
        ]
    ]);
    $counter=0;
    foreach($photos2 as $element){
        $counter++;
    }

    return $counter;
}
function get_picture($path){
    $divide=explode('/',$path);
    $pic_name=$divide[count($divide)-1];
    $db=get_db();
    $pic=$db->photos->findOne(['name_on_server'=>$pic_name]);
    $photo=[
        'author'=>$pic['author'],
        'title'=>$pic['title'],
        'path'=>'images/watermarked/'.$pic_name
    ];
    return $photo;
}
function get_login($user_id){
    $db=get_db();
    $user=$db->users->findOne(['_id'=>$user_id]);
    if($user!==null) {
        return $user['login'];
    }
    else{
        return '';
    }
}
function load_photo_by_id($id){
    $db=get_db();
    $base_id=new ObjectId($id);
    $photo=$db->photos->findOne(['_id'=>$base_id]);
    return [
        'id'=>$photo['_id'],
        'path'=>'miniatures/'.$photo['name_on_server'],
        'title'=>$photo['title'],
        'author'=>$photo['author'],
        'access'=>$photo['access']
    ];

}
function exist($table,$value,$index)
{
    $i=0;
    foreach ($table as $element) {
        if ($element[$index] == $value) {
            return $i;
        }
        $i++;
    }
    return -1;
}
function clear_clipboard($main,$elements)
{
    $to_deleted=[];
    $i=0;
    foreach($main as $item) {
        $to_deleted[$i]=$item;
        $i++;
    }

    $i=0;
    foreach ($main as $item) {
        foreach($elements as $value){
            if($item['id']==$value){
                unset($to_deleted[$i]);
            }
        }
        $i++;
    }

    $result=[];
    $i=0;
    foreach($to_deleted as $item){
        $result[$i]=$item;
        $i++;
    }
    return $result;
}
function find_match_title($title){
    $db=get_db();
    $query=['title'=>
        ['$regex'=>$title,'$options'=>'i']
        ];
    $response=$db->photos->find($query);
    $result=[];
    $i=0;
    foreach($response as $photo){
        $result[$i]=[
            'id'=>$photo['_id'],
            'path'=>'miniatures/'.$photo['name_on_server'],
            'title'=>$photo['title'],
            'author'=>$photo['author'],
            'access'=>$photo['access']
        ];
        $i++;
    }
    return $result;
}
