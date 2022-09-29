<?php

use Bitrix\Main\Loader;

AddEventHandler("main", "OnBeforeProlog", array("SeoCommander", "func"));

class SeoCommander {

    function func() {

        global $APPLICATION;
        $urlPage = $APPLICATION->GetCurDir();

        if (Loader::includeModule("iblock")) {
            $arFilter = array(
                "IBLOCK_ID" => 5,
                "NAME" => $urlPage,
            );
            $arSelect = array(
                "IBLOCK_ID",
                "ID",
                "PROPERTY_TITLE",
                "PROPERTY_DESCRIPTION"
            );

            $ob = CIBlockElement::GetList(
                array(),
                $arFilter,
                false,
                false,
                $arSelect
            );

            if ($res = $ob->Fetch()) {
                $APPLICATION->SetPageProperty('title', $res["PROPERTY_TITLE_VALUE"]);
                $APPLICATION->SetPageProperty('description', $res["PROPERTY_DESCRIPTION_VALUE"]);
            }
        }
    }
}