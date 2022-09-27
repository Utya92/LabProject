<?php
if (!empty($arParams["ID_CANONICAL"])) {
    $arSelect = array(
        "ID",
        "IBLOCK_ID",
        "NAME",
        "PROPERTY_NEW"
    );//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше

    $arFilter = array(
        "ID_CANONICAL" => $arParams["ID_CANONICAL"],
        "PROPERTY_NEW" => $arResult["ID"],
        "ACTIVE" => "Y");

    $res = CIBlockElement::GetList(
        array(),
        $arFilter,
        false,
        false,
        $arSelect);

    if ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $arResult["CANONICAL_LINK"] = $arFields['NAME'];
        $this->__component->SetResultCacheKeys(array("CANONICAL_LINK"));
    }
} else {
    echo "variable doesn't found ";
}

