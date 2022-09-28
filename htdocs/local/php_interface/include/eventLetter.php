<?php
AddEventHandler("main", "OnBeforeEventAdd", array("EventLetter", "checkLetter"));

class EventLetter {

    function checkLetter(&$event, &$lid, &$arFields) {
        if ($event == "FEEDBACK_FORM") {
            global $USER;

            if ($USER->isAuthorized()) {
                $arFields["AUTHOR"] = GetMessage("Пользователь авторизован: #ID#(#LOGIN#) #NAME#, данные
                из формы: #NAME_FORM#", array(
                        "#ID#" => $USER->GetID(),
                        "#LOGIN#" => $USER->GetLogin(),
                        "#NAME#" => $USER->GetFullName(),
                        "#NAME_FORM#" => $arFields["AUTHOR"]
                    )
                );
            } else {
                $arFields["AUTHOR"] = GetMessage("Пользователь не авторизованЖ данные из формы: #NAME_FORM#", array(
                        "#NAME_FORM#" => $arFields["AUTHOR"],
                    )
                );
            }

            CEventLog::Add(array(
                "SEVERITY" => "SECURITY",
                "AUDIT_TYPE_ID" => "Замена данных в отсылаемом письме",
                "MODULE_ID" => "main",
                "ITEM_ID" => $event,
                "DESCRIPTION" => "Замена данных в отсылаемом письме {$arFields['AUTHOR']}"
        ));
        }
    }

}