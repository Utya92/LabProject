<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if (isset($arResult["MIN_PRICE"]) && isset($arResult["MAX_PRICE"])) {
    $css = "<div style='color:red; margin: 34px 15px 35px 15px'>#MOCK#</div>";
    $text1 = "Минимальная цена: " . $arResult["MIN_PRICE"] . "</br>";
    $text2 = "Максимальная цена: " . $arResult["MAX_PRICE"] . "<br>";
    $resText = str_replace("#MOCK#","$text1"."$text2", $css);
    $APPLICATION->AddViewContent("price", $resText);

}