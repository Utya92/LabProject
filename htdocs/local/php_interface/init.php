<?php
use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;


$eventManager = EventManager::getInstance();


Loader::registerNamespace("Local\MyAgent",Loader::getLocal('php_interface/my_classes'));

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/agents.php")) {
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/agents.php");
}

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/events.php")){
    include_once $_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/events.php";
}
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/event404.php")) {
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/event404.php");
}

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/eventLetter.php")) {
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/eventLetter.php");
}

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/eventMenuBuilder.php")) {
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/eventMenuBuilder.php");
}

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/toolsSEOEvent.php")) {
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/toolsSEOEvent.php");
}

//if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/agents.php")) {
//    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/agents.php");
//}



