<?php
global $USER;
global $APPLICATION;
if (isset($arResult["CANONICAL_LINK"])) {
    $APPLICATION->SetPageProperty('canonical', $arResult["CANONICAL_LINK"]);
}
if ($arParams["REPORT_AJAX"] == "N") {
    if (isset($_GET["ID"])) {
        $jsonObject = array();
        if (CModule::IncludeModule("iblock")) {
            if ($USER->IsAuthorized()) {
                $arUser = $USER->GetID() . " (" . $USER->GetLogin() . ") " . $USER->GetFullName();
                $arFields = array(
                    "IBLOCK_ID" => 7,
                    "NAME" => "Новость " . $_GET["ID"],
                    "ACTIVE_FROM" => Bitrix\Main\Type\DateTime::createFromTimestamp(time()),
                    "PROPERTY_VALUES" => array(
                        "USER" => $arUser,
                        "NEWS" => $_GET["ID"],
                    ),
                );
                $element = new CIBlockElement();
                if ($userID = $element->Add($arFields)) {
                    echo '
                    <script>
                        let textElem = document.getElementById("ajax-report-text");
                       let res = textElem.innerText = "Ваше мнение учтено! #N" + ' . $userID . ';
                        window.history.pushState(null,null,"' . $APPLICATION->GetCurPage() . '");
                    </script>
                ';
                }
            } else {
                echo '
                    <script>
                        let textElem = document.getElementById("ajax-report-text");
                        textElem.innerText = "Юзер не авторизован!";
                        window.history.pushState(null,null,"' . $APPLICATION->GetCurPage() . '");
                    </script>
                ';
            }


        }
    }
}


