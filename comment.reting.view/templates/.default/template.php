<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//print_r($arResult["RATING"]);?>
<? $procent = $arResult["RATING"]*100/5?>
<div style="background: linear-gradient(to right, #ea9136 <?=$procent?>%, #dcdcdc 0%);" class="stars">

<?
	for($star = 1; $star<=5 ; $star++)
	{
?>
		<div class="star"> </div>
<?
	}
?>

</div>