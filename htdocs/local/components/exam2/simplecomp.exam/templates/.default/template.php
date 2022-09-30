<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<p><b><?= GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE") ?></b></p>
<?php
if (count($arResult["NEWS"]) > 0) { ?>
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
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>
    </ul>
<?php } ?>

