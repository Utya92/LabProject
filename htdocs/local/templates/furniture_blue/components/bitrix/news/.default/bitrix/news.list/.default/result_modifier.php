<?php

if ($arParams["SPECIALDATE"] == "Y") {
    $arResult["DATE_FIRST_NEWS"] = $arResult['ITEMS'][0]['ACTIVE_FROM'];
    $this->__component->SetResultCacheKeys(array("DATE_FIRST_NEWS"));
}