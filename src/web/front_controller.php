<?php
session_start();


//dodawanie niezbędnych plików
require_once '../router.php';
require_once '../controllers.php';
require_once '../dispatcher.php';
require_once '../business.php';
require_once '../view_function.php';
require '../../vendor/autoload.php';


//odczytywanie skąd przyszło rządanie
$action_url=$_GET['action'];
dispatch($router,$action_url);


