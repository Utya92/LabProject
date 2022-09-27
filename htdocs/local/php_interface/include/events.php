<?php

//constants
define("IBLOCK_CATALOG", 2);
define("LIMIT_VIEWS", 2);
// файл /bitrix/php_interface/init.php
// регистрируем обработчик
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", array("Task", "task_function"));


class Task {
    // создаем обработчик события "OnBeforeIBlockElementUpdate"
    function task_function(&$arFields) {

        //если меняем элемент каталога
        if ($arFields["IBLOCK_ID"] == IBLOCK_CATALOG) {

            //выполняется при деактивации
            if ($arFields["ACTIVE"] == "N") {
                $arSelect = array(
                    "ID",
                    "IBLOCK_ID",
                    "NAME",
                    "SHOW_COUNTER"
                );

                $arFilter = array(
                    "IBLOCK_ID" => IBLOCK_CATALOG,
                    "ID" => $arFields["ID"]
                );

                $res = CIBlockElement::GetList(
                    array(),
                    $arFilter,
                    false,
                    false,
                    $arSelect);

                $arItems = $res->Fetch();


                if ($arItems["SHOW_COUNTER"] > LIMIT_VIEWS) {
                    global $APPLICATION;
                    $APPLICATION->throwException("Товар невозможно деактивировать, у него {$arItems["SHOW_COUNTER"]} просмотров»");
                    return false;
                }

            }
        }
    }
}
