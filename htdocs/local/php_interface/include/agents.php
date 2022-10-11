<?php

//function checkUserCount() {
//    $date = new DateTime();
//
//    $date = \Bitrix\Main\Type\DateTime::createFromTimestamp($date->getTimestamp());
//    $lastDate = COption::SetOptionString("main", "last_date_agent_check_user_count");
//
//    //формируем фильтр если свойство не пустое
//    if ($lastDate) {
//        $arFilter = array(">=DATE_REGISTER" => $lastDate);
//    } else {
//        $arFilter = array();
//    }
//
//    $arUsers = array();
//    //плучение зарегенных юзеров по фильтру
//    $by = "DATE_REGISTER_1";
//    $order = "ASC";
//    $rsUser = CUser::GetList(
//        $by,
//        $order,
//        $arFilter
//    );
//
//    while ($user = $rsUser->Fetch()) {
//        $arUsers[] = $user;
//    }
//
//    echo "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
//
//
//    if (!$lastDate) {
//        $lastDate = $arUsers[0]["DATE_REGISTER"];
//    }
//
//    //получение количества дней между текущей датой и датой послдней работы скрипта
//    $difference = intval(abs(strtotime($lastDate) - strtotime($date->toString())));
//    //секунды в дни
//    $days = round($difference / (3600 * 24));
//
//    //получаем количество пользвоателей
//    $countUsers = count($arUsers);
//
//
//    //получаем всех администраторов
//    $by = "ID";
//    $order = "ASC";
//    $rsAdmin = CUser::GetList(
//        $by,
//        $order,
//        array("GROUPS_ID" => 1)
//    );
//    while ($admin = $rsAdmin->Fetch()) {
//        //каждому администратору отпраялем письмо
//        CEvent::Send(
//            "COUNT_REGISTRED_USERS",
//            "s1",
//            array(
//                "EMAIL_ID" => $admin["EMAIL"],
//                "COUNT_USERS" => $countUsers,
//                "COUNT_DAYS" => $days,
//            ),
//            "Y",
//            "32"
//        );
//
//    }
//
//    //запись в систему даты отработки скрипта
//    COption::SetOptionString("main", "last_date_agent_check_user_count", $date->toString());
//
//
//    return "checkUserCount();";
//}

