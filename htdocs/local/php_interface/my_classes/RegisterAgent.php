<?php
namespace Local\MyAgent;

use Bitrix\Main\Mail\Event;
use Bitrix\Main\Type\DateTime;
use COption;
use CUser;


class RegisterAgent {

    public static function userCount() {

        $date = new DateTime();
        $date = DateTime::createFromTimestamp($date->getTimestamp());
        $lastDate = COption::GetOptionString("main", "userCount");

        if ($lastDate) {
            $arFilter = array(
                "DATE_REGISTER_1" => $lastDate,
            );
        } else {
            $arFilter = array();
        }

        $arUsers = array();

        $rsUser = CUser::GetList(
            "DATE_REGISTER",
            "ASC",
            $arFilter
        );

        while ($user = $rsUser->Fetch()) {
            $arUsers[] = $user;
        }

        if (!$lastDate) {
            $lastDate = $arUsers[0]["DATE_REGISTER"];
        }

        $differenceDate = intval(abs(strtotime($lastDate) - strtotime($date->toString())));
        $days = round($differenceDate / (3600 * 24));
        $countUsers = count($arUsers);

        $rsAdmin = CUser::GetList(
            "ID",
            "ASC",
            array("GROUPS_ID" => 1)
        );

        while ($admin = $rsAdmin->Fetch()) {

            Event::send(
                [
                    "EVENT_NAME" => "COUNT_REGISTER_USERS",
                    "MASSAGE_ID" => 32,
                    "SID" => "s1",
                    "C_FIELDS" => [
                        "EMAIL" => $admin["EMAIL"],
                        "COUNT" => $countUsers,
                        "DAYS" => $days
                    ]
                ]
            );
        }

        COption::SetOptionString("main", "userCount", $date->toString());

        return "Local\MyAgent\RegisterAgent::userCount();";
    }
}