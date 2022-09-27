<?php
AddEventHandler("main", "OnEpilog", array("Event404Handler", "event404_handler"));

class  Event404Handler {

    function event404_handler() {
        if (defined("ERROR_404") && ERROR_404 == "Y") {
            global $APPLICATION;
            $APPLICATION->RestartBuffer();
            include $_SERVER["DOCUMENT_ROOT"] .SITE_TEMPLATE_PATH . "/header.php";
            include $_SERVER["DOCUMENT_ROOT"] ."/404.php";
            include $_SERVER["DOCUMENT_ROOT"] .SITE_TEMPLATE_PATH . "/footer.php";
            //запись в журнал событий
            CEventLog::Add(
                array(
                    "SEVERRITY" => "INFO",
                    "AUDIT_TYPE_ID" => "ERROR_404",
                    "MODULE_ID" => "main",
                    "DESCRIPTION" => $APPLICATION->GetCurPage()
                )
            );
        }
    }
}