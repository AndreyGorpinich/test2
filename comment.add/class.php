<?
class CommentAdd extends CBitrixComponent
{


var $component_id = 'CommentAdd';

private function USER(){
	global $USER;
	return $USER;
}

private function APPLICATION(){
	global $APPLICATION;
	return $APPLICATION;
}

private function CheckField($arrRequest){

	if(!$arrRequest['VOIT_VALUE'])
	{
		$arError[] = 'VOIT_VALUE';
	}

	if(!$arrRequest['ELEMENT_ID'])
	{
		$arError[] = 'ELEMENT_ID';
	}

	if(!$arrRequest['COMMENT_TEXT'])
	{
		$arError[]  = 'COMMENT_TEXT';
	}

	if($arError)
	{
		return $arError;
	}
	else
	{
		return false;
	}


}

private function actionForm(){

		if($_REQUEST['ACTION_COMPONENT']==$this->component_id)
		{
			$arrRequest['VOIT_VALUE'] = $_REQUEST['VOIT_VALUE'];

			$arrRequest['ELEMENT_ID'] = $_REQUEST['ELEMENT_ID'];

			$arrRequest['COMMENT_TEXT'] = $_REQUEST['COMMENT_TEXT'];

			$checked = $this->CheckField($arrRequest);

			if($checked==false)
			{
				$this->addComment($arrRequest);
			}
			else
			{
				$this->arResult['ERROR'] = $checked;

			}

		}
}



public function addComment(&$arrRequest){




$element = new CIBlockElement;

	$PROP = array();
	$PROP[$this->arParams['PROP_VOIT']] = $arrRequest['VOIT_VALUE'];
	$PROP[$this->arParams['PROP_ELEMENT']] = $arrRequest['ELEMENT_ID'];
	
	$arFields = Array(
					  "MODIFIED_BY"    => $this->USER()->GetID(),
					  "IBLOCK_SECTION_ID" => false,       
					  "IBLOCK_ID"      => $this->arParams['IBLOCK_ID'],
					  "PROPERTY_VALUES"=> $PROP,
					  "NAME"           => "Коментарий оставлен пользователем,".$this->USER()->GetFullName().",(".$this->USER()->GetID().")",
					  "ACTIVE"         => "N",
					  "PREVIEW_TEXT"   => $arrRequest['COMMENT_TEXT'],
					);

	if($PRODUCT_ID = $element->Add($arFields))
	{
	  $this->arResult['success'] = 'Y';
	}
	else
	{
	  $this->arResult['ERROR_ADD'] =  "Error: ".$element->LAST_ERROR;
	}

}


public function executeComponent(){

	if($this->USER()->IsAuthorized()){
		CModule::IncludeModule("iblock");
		$this->actionForm();
		$this->arResult['ELEMENT_ID'] = $this->arParams['ELEMENT_ID'];
		$this->arResult['COMPONENT_ID'] = $this->component_id;
	}
	else
	{
		$this->arResult['AUTH'] = 'N';
	}


	if($_REQUEST['AJAX']=='Y' & $_REQUEST['ACTION_COMPONENT']==$this->component_id){
		$this->APPLICATION()->RestartBuffer();
			echo json_encode($this->arResult);
		die();

	}
	else
	{
		$this->includeComponentTemplate();
	}
}


};

?>