<?php

use Bitrix\Main\Loader,
    Bitrix\Iblock;

class NewsByInterests extends CBitrixComponent {

    public function onPrepareComponentParams($arParams) {
        if (empty($arParams["CACHE_TIME"])) {
            $arParams["CACHE_TIME"] = 36000000;
        }
        if (empty($arParams["NEWS_IBLOCK_ID"])) {
            $arParams["NEWS_IBLOCK_ID"] = 0;
        }
        if (empty($arParams["PROPERTY_UF"])) {
            $arParams["PROPERTY_UF"] = trim($arParams["PROPERTY_UF"]);
        }
        return $arParams;
    }

    public function checkErrorInModule() {
        if (!Loader::includeModule("iblock")) {
            ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
        }
    }

    public function executeComponent() {
        $this->checkErrorInModule();
        $this->render();
        $this->includeComponentTemplate();
    }

    function getCurrentUserGroup($currentUserId) {
        global $USER;
        $currentUserGroup = CUser::GetList(
            "id",
            "asc",
            array("ID" => $currentUserId),
            array("SELECT" => array($this->arParams["PROPERTY_UF"])),
        )->fetch()[$this->arParams["PROPERTY_UF"]];
        return $currentUserGroup;
    }

    function render() {
        global $USER;
        global $APPLICATION;

        if ($USER->isAuthorized()) {
            $userId = $USER->GetID();
            $currentUserGroup = $this->getCurrentUserGroup($userId);

            if ($this->StartResultCache(false, array($currentUserGroup, $userId))) {
                $rsUsers = CUser::GetList(
                    "id",
                    "desc",
                    array(
                        $this->arParams["PROPERTY_UF"] => $currentUserGroup,
                    ),
                    array("SELECT" => array("LOGIN", "ID")
                    ),
                );


                while ($arUser = $rsUsers->GetNext()) {
                    $userList[$arUser["ID"]] = array("LOGIN" => $arUser["LOGIN"]);
                    $userListId[] = $arUser["ID"];
                }
                $arNewsAuthor = array();
                $arNewsList = array();

                $rsElements = CIBlockElement::GetList(
                    array(),
                    array(
                        "IBLOCK_ID" => $this->arParams["NEWS_IBLOCK_ID"],
                        "PROPERTY_" . $this->arParams["EXAM2_PROPERTY"] => $userListId,
                    ),
                    false,
                    false,
                    array(
                        "NAME",
                        "ACTIVE_FROM",
                        "ID",
                        "IBLOCK_ID",
                        "PROPERTY_" . $this->arParams["EXAM2_PROPERTY"]
                    )
                );

                while ($arElement = $rsElements->GetNext()) {
                    $arNewsAuthor[$arElement["ID"]][] = $arElement["PROPERTY_" . $this->arParams["EXAM2_PROPERTY"] . "_VALUE"];

                    if (empty($arNewsList[$arElement["ID"]])) {
                        $arNewsList[$arElement["ID"]] = $arElement;
                    }

                    if ($arElement["PROPERTY_" . $this->arParams["EXAM2_PROPERTY"] . "_VALUE"] != $userId) {
                        $arNewsList[$arElement["ID"]]["AUTHORS"][] = $arElement["PROPERTY_" . $this->arParams["EXAM2_PROPERTY"] . "_VALUE"];

                    }
                }

                $count = 0;
                foreach ($arNewsList as $key => $value) {
                    if (in_array($userId, $arNewsAuthor[$value["ID"]])) {
                        continue;
                    }

                    foreach ($value["AUTHORS"] as $authorId) {
                        $userList[$authorId]["NEWS"][] = $value;
                        $count++;

                    }
                }
                unset($userList[$userId]);
                $this->arResult["AUTHORS"] = $userList;
                $this->arResult["COUNT"] = $count;
                $this->setResultCacheKeys(array("COUNT"));
                $APPLICATION->SetTitle(GetMessage("COUNT") . $this->arResult["COUNT"]);

            } else {
                $this->abortResultCache();
            }
        }
    }
}