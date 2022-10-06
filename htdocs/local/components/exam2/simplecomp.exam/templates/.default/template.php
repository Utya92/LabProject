<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<p><b><?= GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE") ?></b></p>
<?php
$url = $APPLICATION->GetCurPage() . "?F=Y";
echo GetMessage("FILTER_TITLE") . "<a href ='$url'>" . $url . "</a>";
?>

<?php if (count($arResult["NEWS"]) > 0) { ?>
    <ul>
        <?php foreach ($arResult["NEWS"] as $new) {
            ; ?>
            <li>
                <b>
                    <?= $new["NAME"]; ?>
                </b>
                <?= $new["ACTIVE_FROM"]; ?>
                (<?= implode(", ", $new["SECTIONS"]); ?>)
            </li>
            <?php if (count($new["PRODUCTS"]) > 0) { ?>
                <?php
                $this->AddEditAction($new["ID"], $arResult['ADD_LINK'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_ADD"));
                ?>
                <ul id="<?= $this->GetEditAreaId($new["ID"]); ?>">
                    <?php foreach ($new["PRODUCTS"] as $arProduct) { ?>
                        <?
                        $this->AddEditAction($new["ID"] . "_" . $arProduct['ID'], $arProduct['EDIT_LINK'], CIBlock::GetArrayByID($arProduct["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($new["ID"] . "_" . $arProduct['ID'], $arProduct['DELETE_LINK'], CIBlock::GetArrayByID($arProduct["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                        ?>
                        <li id="<?= $this->GetEditAreaId($new["ID"] . "_" . $arProduct['ID']); ?>">
                            <?= $arProduct["NAME"]; ?> -
                            <?= $arProduct["PROPERTY_PRICE_VALUE"]; ?> -
                            <?= $arProduct["PROPERTY_MATERIAL_VALUE"]; ?> -
                            <?= $arProduct["PROPERTY_ARTNUMBER_VALUE"]; ?> -
                            (/<?= $arProduct["DETAIL_PAGE_URL"]; ?>.php)
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>
    </ul>
    <br>
    --------
    <p>
        <b>
            Навигация
        </b>
    </p>
    <? echo $arResult["NAV_STRING"]; ?>
<?php } ?>

