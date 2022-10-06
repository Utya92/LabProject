<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentParameters = array(
    "PARAMETERS" => array(
        "PRODUCTS_IBLOCK_ID" => array(
            "NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID_70"),
            "PARENT" => "BASE",
            "TYPE" => "STRING",
        ),
        "NEWS_IBLOCK_ID" => array(
            "NAME" => GetMessage("SIMPLECOMP_EXAM2_NEWS_IBLOCK_ID_70"),
            "PARENT" => "BASE",
            "TYPE" => "STRING",
        ),
        "PRODUCTS_IBLOCK_ID_PROPERTY" => array(
            "NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_PROPERTY_IBLOCK_ID_70"),
            "PARENT" => "BASE",
            "TYPE" => "STRING",
        ),
        "TEMPLATE_DETAIL_URL" => array(
            "NAME" => GetMessage("SIMPLECOMP_EXAM2_TEMPLATE_ID_81"),
            "PARENT" => "BASE",
            "TYPE" => "STRING",
            "DEFAULT"=>"catalog_exam/#SECTION_ID#/#ELEMENT_CODE#"
        ),
        "PAGE_NAVIGATION_EL" => array(
            "NAME" => GetMessage("PAGE_NAVIGATION_EL"),
            "PARENT" => "BASE",
            "TYPE" => "STRING",
            "DEFAULT"=>2
        ),
        "CACHE_TIME" => array(
            "DEFAULT" => 36000000
        ),
    ),
);