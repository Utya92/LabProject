<?php
AddEventHandler("main", "OnBuildGlobalMenu", array("MenuBuilder", "changeMenu"));

class MenuBuilder {

    function changeMenu(&$aGlobalMenu, &$aModuleMenu) {
        $isAdmin = false;
        $isManager = false;

        global $USER;

        $userGroup = CUser::GetUserGroupList($USER->GetID());

        //получение id группы контент-редактора
        $contentGroupID = CGroup::GetList(
            $by = "c_sort",
            $order = "asc",
            array(
                "STRING_ID" => "content_editor",
            )
        )->Fetch()['ID'];

        //поиск групп юзера
        while ($group = $userGroup->Fetch()) {
            if ($group["GROUP_ID"] == 1) {
                $isAdmin = true;
            }
            if ($group["GROUP_ID"] == $contentGroupID) {
                $isManager = true;
            }
        }

        if (!$isAdmin && $isManager) {
            foreach ($aModuleMenu as $key => $item) {
                if ($item["items_id"] == "menu_iblock_/news") {
                    $aModuleMenu = [$item];
                    foreach ($item["items"] as $childItem) {

                        if ($childItem["items_id"] == "menu_iblock_/news/1") {
                            $aModuleMenu[0]["items"] = [$childItem];
                            break;
                        }
                    }
                    break;
                }
            }
            $aGlobalMenu = ["global_menu_content" => $aGlobalMenu["global_menu_content"]];
        }
    }
}