<?php

namespace COMPONENT\NEWS\BITRIX\CONTROLLER;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Type\DateTime;
use CIBlockElement;
use CModule;

class Complain extends Controller {

    public function triggerAjaxAction() {
        if (CModule::IncludeModule("iblock")) {
            global $USER;
            if ($USER->IsAuthorized()) {
                $arUser = $USER->GetID() . " (" . $USER->GetLogin() . ") " . $USER->GetFullName();

                $arFields = array(
                    "IBLOCK_ID" => 7,
                    "NAME" => "Новость " . $_GET["ID"],
                    "ACTIVE_FROM" => DateTime::createFromTimestamp(time()),
                    "PROPERTY_VALUES" => array(
                        "USER" => $arUser ?? '',
                        "NEWS" => $_GET["ID"]
                    ),
                );
                $element = new CIBlockElement();
                if ($userId = $element->Add($arFields)) {
                    $jsonObject["ID"] = $userId;
                    return $jsonObject;
                }
            }
        }

        return "доделать незалогиненого ajax юзера";
    }
}
