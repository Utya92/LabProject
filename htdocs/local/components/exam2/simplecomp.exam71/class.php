<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
    Bitrix\Iblock;

class SimpleGoodsCatalog extends CBitrixComponent {

    public function onPrepareComponentParams($arParams) {
        if (empty($arParams["CACHE_TIME"])) {
            $arParams["CACHE_TIME"] = 36000000;
        }
        if (empty($arParams["PROPERTY_CODE"])) {
            $arParams["PROPERTY_CODE"] = 0;
        }
        if (empty($arParams["CLASSIF__IBLOCK_ID"])) {
            $arParams["CLASSIF__IBLOCK_ID"] = 0;
        }

        return $arParams;
    }


    function checkErrorInModule() {
        if (!Loader::includeModule("iblock")) {
            ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));;
        }
    }

    public function executeComponent() {
        global $APPLICATION;
        $this->checkErrorInModule();
        $this->render();
        $this->setResultCacheKeys(array("COUNT"));
        $APPLICATION->SetTitle(GetMessage("COUNT") . $this->arResult["COUNT"]);
    }


    function getFirmsElements() {
        $arClassif = array();
        $arClassifId = array();


        $rsFirmsElements = CIBlockElement::GetList(
            array(),
            array(
                "IBLOCK_ID" => $this->arParams["CLASSIF__IBLOCK_ID"],
                "CHECK_PERMISSIONS" => $this->arParams["CACHE_GROUPS"],
                "ACTIVE" => "Y"
            ),
            false,
            false,
            //список классификаторов
            array(
                "ID",
                "IBLOCK_ID",
                "NAME"
            ),
        );

        while ($arElement = $rsFirmsElements->Fetch()) {
            $arClassif[$arElement["ID"]] = $arElement;
            $arClassifId[] = $arElement["ID"];
        }

        $this->arResult["COUNT"] = count($arClassifId);

        $output['CLASSIF'] = $arClassif;
        $output['CLASSIF_ID'] = $arClassifId;

        return $output;
    }


    function getFirmaProducts($arClassifId, array &$arClassif) {


        $rsProdElements = CIBlockElement::GetList(
            array(),
            array(
                "IBLOCK_ID" => $this->arParams["PRODUCTS_IBLOCK_ID"],
                "CHECK_PERMISSION" => $this->arParams["CACHE_GROUPS"],
                "PROPERTY_" . $this->arParams["PROPERTY_CODE"] => $arClassifId,
                "ACTIVE" => "Y",
            ),
            false,
            false,
            array(
                "NAME",
                "ID",
                "IBLOCK_ID",
                "IBLOCK_SECTION_ID",
                "DETAIL_PAGE_URL"
            ),
        );

        while ($result = $rsProdElements->GetNextElement()) {
            $arField = $result->GetFields();
            $arField["PROPERTY"] = $result->GetProperties();

            foreach ($arField["PROPERTY"]["FIRMA"]["VALUE"] as $value) {
                $arClassif[$value]["ELEMENTS"][$arField["ID"]] = $arField;
            }
        }
        return $arClassif;

    }

    function render() {
        global $USER;
        if ($this->startResultCache(false, array($USER->GetGroups()))) {
            //бренд123
            $arClassif = $this->getFirmsElements()["CLASSIF"];
            //35-36-37
            $arClassifId = $this->getFirmsElements()["CLASSIF_ID"];
            $this->arResult["CLASSIF"] = $this->getFirmaProducts($arClassifId, $arClassif);
            $this->includeComponentTemplate();
        } else {
            $this->abortResultCache();
        }
    }

}