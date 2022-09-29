<?php
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




