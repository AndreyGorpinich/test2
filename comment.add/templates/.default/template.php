<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="component_addComment">
<?
if($arResult['AUTH']!='N')
{

	if(is_array($arResult['ERROR'])){
		foreach($arResult['ERROR'] as $error_code)
		{
	?>
				<div class="error"><?=GetMessage("MESS_ERROR_".$error_code)?></div>
	<?
		}
	}
	?>

	<?
	if($arResult['success']){
	?>
				<div class="success"><?=GetMessage("MESS_SUCCESS_ADD")?></div>
	<?
	}
	?>
	<form id="form_<?=$arResult['COMPONENT_ID']?>" action="" method="post">
		<fieldset class="stars">

				<input id="s1" name="VOIT_VALUE" type="radio" value="5">

				<input id="s2" name="VOIT_VALUE" type="radio" value="4">

				<input id="s3" name="VOIT_VALUE" type="radio" value="3">

				<input id="s4" name="VOIT_VALUE" type="radio" value="2">

				<input id="s5"  name="VOIT_VALUE" type="radio" value="1">
		</fieldset>
		<fieldset>
			<textarea name="COMMENT_TEXT"></textarea>
			<input name="ELEMENT_ID" type="hidden" value="<?=$arResult['ELEMENT_ID']?>">
			<input name="ACTION_COMPONENT" type="hidden" value="<?=$arResult['COMPONENT_ID']?>">
		</fieldset>
		<fieldset>
			<input type="submit" value="<?=GetMessage("MESS_INPUT_SUBMIT_TEXT")?>">
		</fieldset>
	</form>
<script>
	$(document).ready(function(){
		options = new Object();
		options.lang = new Object();
		options.lang["MESS_ERROR_VOIT_VALUE"] = '<?=GetMessage("MESS_ERROR_VOIT_VALUE")?>';
		options.lang["MESS_ERROR_ELEMENT_ID"] = '<?=GetMessage("MESS_ERROR_ELEMENT_ID")?>';
		options.lang["MESS_ERROR_COMMENT_TEXT"] = '<?=GetMessage("MESS_ERROR_COMMENT_TEXT")?>';
		options.lang["MESS_SUCCESS_ADD"] = '<?=GetMessage("MESS_SUCCESS_ADD")?>';

		$("#form_<?=$arResult['COMPONENT_ID']?>").addComment(options);
	});
</script>

<?
}
else
{
echo GetMessage("MESS_AUTH_NO");
}
?>
</div>