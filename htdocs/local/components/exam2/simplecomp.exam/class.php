<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
    Bitrix\Iblock;

class MySimpleCatalog extends CBitrixComponent {

    protected bool $cFilter = false;

    public function onPrepareComponentParams($arParams) {
        if (!isset($arParams["CACHE_TIME"])) {
            $arParams["CACHE_TIME"] = 36000000;
        }
        if (!isset($arParams["PRODUCTS_IBLOCK_ID"])) {
            $arParams["PRODUCTS_IBLOCK_ID"] = 0;
        }
        if (!isset($arParams["NEWS_IBLOCK_ID"])) {
            $arParams["NEWS_IBLOCK_ID"] = 0;
        }

        return $arParams;
    }

    public function checkErrorInModule() {
        if (!Loader::includeModule("iblock")) {
            ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
        }
    }

    public function executeComponent() {
        global $APPLICATION;
        $this->checkErrorInModule();
        $this->addSubMenuButtons($this->arParams["PRODUCTS_IBLOCK_ID"]);
        $this->render();
        $APPLICATION->SetTitle(GetMessage("COUNT") . $this->arResult["PRODUCT_CNT"]);
    }


    function addSubMenuButtons($iblockId) {
        global $USER;
        if ($USER->IsAuthorized()) {
            $arButtons = CIBlock::GetPanelButtons($iblockId);
            //добавляем массив новых кнопок к кнопкам отображаемых в области компонента в режиме редактирования
            $this->AddIncludeAreaIcons(
                array(
                    array(
                        "ID" => "linklb",
                        "TITLE" => GetMessage("IB_IN_ADMIN"),
                        "URL" => $arButtons["submenu"]["element_list"]["ACTION_URL"],
                        "IN_PARAMS_MENU" => true,// включение визуального отображения кнопки
                    )
                )
            );
        }
    }

    function getNews(): array {
        $arNews = array();
        $arNewsId = array();

        //список активных новостей инфоблока новости
        $obNews = CIBlockElement::GetList(
            array(),
            array(
                "IBLOCK_ID" => $this->arParams["NEWS_IBLOCK_ID"],
                "ACTIVE" => "Y"
            ),
            false,
            array(
                "nPageSize" => $this->arParams["PAGE_NAVIGATION_EL"],
                "bShowAll" => true,
            ),
            //ограничение вывода полей элементов
            array(
                "NAME",
                "ACTIVE_FROM",
                "ID"
            )
        );

        $this->arResult["NAV_STRING"] = $obNews->GetPageNavString(GetMessage("PAGE_TITLE"));

        while ($element = $obNews->Fetch()) {
            $arNewsId[] = $element["ID"];
            $arNews[$element["ID"]] = $element;
        }
        $output["AR_NEWS"] = $arNews;
        $output["AR_NEWS_ID"] = $arNewsId;
        return $output;
    }

    function getResultModifierPrice($arr) {
        $arPrice = array();
        foreach ($arr["NEWS"] as $news) {
            foreach ($news["PRODUCTS"] as $arProduct) {
                if ($arProduct["PROPERTY_PRICE_VALUE"] !== null) {
                    $arPrice[] = $arProduct["PROPERTY_PRICE_VALUE"];
                }
            }
        }
        $this->arResult["MIN_PRICE"] = min($arPrice);
        $this->arResult["MAX_PRICE"] = max($arPrice);
        $this->setResultCacheKeys(array("MIN_PRICE", "MAX_PRICE"));
    }


    function getSections($newsId): array {
        $arSections = array();
        $arSectionsID = array();
        //список активных разделов с привязкой к активным новостям
        $obSection = CIBlockSection::GetList(
            array(),
            array(
                "IBLOCK_ID" => $this->arParams["PRODUCTS_IBLOCK_ID"],
                "ACTIVE" => "Y",
                $this->arParams["PRODUCTS_IBLOCK_ID_PROPERTY"] => $newsId
            ),
            false,
            array(
                "NAME",
                "IBLOCK_ID",
                "ID",
                $this->arParams["PRODUCTS_IBLOCK_ID_PROPERTY"],
            ),
            false
        );

        while ($arSectionCatalog = $obSection->Fetch()) {
            $arSectionsID[] = $arSectionCatalog["ID"];
            $arSections[$arSectionCatalog["ID"]] = $arSectionCatalog;
        }
        $output["AR_SECTION"] = $arSections;
        $output["AR_SECTION_ID"] = $arSectionsID;

        return $output;
    }

    function getProducts($arSectionsID, $arSections, &$arNews) {

        $arFilterElements = array(
            "IBLOCK_ID" => $this->arParams["PRODUCTS_IBLOCK_ID"],
            "ACTIVE" => "Y",
            "SECTION_ID" => $arSectionsID
        );

        if ($this->cFilter) {
            $arFilterElements[] = array(
                array("<=PROPERTY_PRICE" => 1700, "PROPERTY_MATERIAL" => "дерево, ткань"),
                array("<=PROPERTY_PRICE" => 1500, "PROPERTY_MATERIAL" => "металл, пластик"),
                "LOGIC" => "OR"
            );
            $this->abortResultCache();
        }

        $obProduct = CIBlockElement::GetList(
            array(
                "NAME" => "asc",
                "SORT" => "asc"
            ),
            $arFilterElements,
            false,
            false,
            //ограничение вывода полей элементов
            array(
                "NAME",
                "IBLOCK_SECTION_ID",
                "ID",
                "CODE",
                "IBLOCK_ID",
                "PROPERTY_ARTNUMBER",
                "PROPERTY_MATERIAL",
                "PROPERTY_PRICE"
            )

        );

        $this->arResult["PRODUCT_CNT"] = 0;

        while ($arProduct = $obProduct->Fetch()) {
            //передаём индетификатор инфоблока каждого элемента!!!
            $arButtons = CIBlock::GetPanelButtons(
                $this->arParams["PRODUCTS_IBLOCK_ID"],
                $arProduct["ID"],
                0,
                array("SECTION_BUTTONS" => false, "SESSID" => false),

            );
//            echo "<pre>";
//            print_r($arButtons);
//            echo "<pre>";
            $arProduct["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
            $arProduct["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

            $this->arResult["ADD_LINK"] = $arButtons["edit"]["add_element"]["ACTION_URL"];
            $this->arResult["IBLOCK_ID"] = $this->arParams["PRODUCTS_IBLOCK_ID"];

            //ссылка на детальный просмотр
            $arProduct["DETAIL_PAGE_URL"] = str_replace(
                array(
                    "#SECTION_ID#",
                    "#ELEMENT_CODE#"
                ),
                array(
                    $arProduct ["IBLOCK_SECTION_ID"],
                    $arProduct ["CODE"],
                ),
                $this->arParams["TEMPLATE_DETAIL_URL"]
            );

            $this->arResult["PRODUCT_CNT"]++;
            foreach ($arSections[$arProduct["IBLOCK_SECTION_ID"]][$this->arParams["PRODUCTS_IBLOCK_ID_PROPERTY"]] as $newsId) {

                if (isset($arNews[$newsId])) {
                    $arNews[$newsId]["PRODUCTS"][] = $arProduct;
                }

            }
        }
        $this->setResultCacheKeys(array("PRODUCT_CNT"));
    }


    function render() {

        //фильтр
        $filter = $this->request->getQuery("F");
        if (isset($filter)) {
            $this->cFilter = true;
        }
        //кнопки навигации
        $arNavigation = CDBResult::GetNavParams();

        //для функции кеширования
        global $CACHE_MANAGER;


        if ($this->startResultCache(false, array($this->cFilter, $arNavigation),"/tagged_getlist")) {
            //отслеживание изменений в инфоблоке услуг
            $CACHE_MANAGER->RegisterTag("iblock_id_3");
            $arNews = $this->getNews()["AR_NEWS"];
            $arNewsId = $this->getNews()["AR_NEWS_ID"];

            $arSection = $this->getSections($arNewsId)["AR_SECTION"];
            $arSectionId = $this->getSections($arNewsId)["AR_SECTION_ID"];

            $this->getProducts($arSectionId, $arSection, $arNews);

            foreach ($arSection as $value) {
                foreach ($value[$this->arParams["PRODUCTS_IBLOCK_ID_PROPERTY"]] as $item) {
                    if (isset($arNews[$item])) {
                        $arNews[$item]["SECTIONS"] [] = $value["NAME"];
                    }
                }
            }

            $this->arResult["NEWS"] = $arNews;
            $this->getResultModifierPrice($this->arResult);
//            echo "<pre>";
//            print_r($this->arResult["NEWS"]);
//            echo "<pre>";
            $this->includeComponentTemplate();
        } else {
            $this->abortResultCache();
        }
    }
}