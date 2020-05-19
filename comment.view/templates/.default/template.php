<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="comments">

<?
	if($arResult["LIST"]){
		foreach($arResult["LIST"] as $comment)
		{
?>
			<div class="__item">
				<div class="__title">Комментарий написал <?=$comment['FIO']?> время создания (<?=$comment["DATE_CREATE"]?>)</div>
					<div class="__text"><?=$comment["PREVIEW_TEXT"]?>
						<?if($comment["DETAIL_TEXT"]):?>
							<div class="__Moder"><?=$comment["DETAIL_TEXT"]?></div>
						<?endif;?>
					</div>
			</div>
<?
		}
?>
	<?echo $arResult["NAV_STRING"];?>
<?
	}
?>
</div>

<script>
	$(document).ready(function(){
		$(".comments").ViewComment();
	});
</script>