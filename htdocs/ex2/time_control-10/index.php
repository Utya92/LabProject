<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оценка производительности 10");
?>
    Доля нагрузки самой ресурсоёмкой страницы: /products/index.php  17.80%
    <br>
    Компонент с максимально долгим уровнем выполнения: bitrix:catalog: 0.3921 с
    <br>
    Работа компонента c параметром  $resultCacheKeys = array("ID"): 12 КБ
    <br>
    Разница 8кб
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>