<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if (count($arResult["NEWS"]) > 0) { ?>
    <p><b><?= GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE") ?></b></p>
    <?php
    $url = $APPLICATION->GetCurPage() . "?F=Y";
    echo GetMessage("FILTER_TITLE") . "<a href ='$url'>" . $url . "</a>";
    ?>
    <ul>
        <?php foreach ($arResult["NEWS"] as $new) { ?>
            <li>
                <b>
                    <?= $new["NAME"]; ?>
                </b>
                <?= $new["ACTIVE_FROM"]; ?>
                (<?= implode(", ", $new["SECTIONS"]); ?>)
            </li>
            <?php if (count($new["PRODUCTS"]) > 0) {
                ?>
                <ul>
                    <?php foreach ($new["PRODUCTS"] as $arProduct) {
                        ?>
                        <li>
                            <?= $arProduct["NAME"]; ?>
                            <?= $arProduct["PROPERTY_PRICE_VALUE"]; ?>
                            <?= $arProduct["PROPERTY_MATERIAL_VALUE"]; ?>
                            <?= $arProduct["PROPERTY_ARTNUMBER_VALUE"]; ?>
                            (/<?= $arProduct["DETAIL_PAGE_URL"]; ?>.php)
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>
    </ul>
<?php } ?>

