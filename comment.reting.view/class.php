<?
class RatingView extends CBitrixComponent
{


var $component_id = 'RatingView';

private function USER(){
	global $USER;
	return $USER;
}

private function APPLICATION(){
	global $APPLICATION;
	return $APPLICATION;
}



public function GetRating(){

	$PROP_VOIT = $this->arParams['PROP_VOIT'];
	$PROP_ELEMENT = $this->arParams['PROP_ELEMENT'];
	$arFilter['IBLOCK_ID'] = $this->arParams['IBLOCK_ID'];
	$arFilter['PROPERTY_'.$PROP_ELEMENT.'.ID'] = $this->arParams['ELEMENT_ID'];
	$arFilter['ACTIVE']='Y'; 
	$resComments = CIBlockElement::GetList(
											array(), 
											$arFilter,
											false,
											false, 
											array(
													"ID",
													"IBLOCK_ID",
													"ACTIVE",
													"PROPERTY_".$PROP_VOIT,
													"PROPERTY_".$PROP_ELEMENT
												)
										);
	$rating_summ = 0;
	$count_comment = $resComments->SelectedRowsCount();
	while($arComment = $resComments->Fetch())
	{
		$rating_summ += $arComment["PROPERTY_PROP_VOIT_VALUE"];
	}

	$this->arResult["RATING"] = $rating_summ/$count_comment; 
}


public function executeComponent(){

		CModule::IncludeModule("iblock");
		$this->GetRating();
		$this->arResult['ELEMENT_ID'] = $this->arParams['ELEMENT_ID'];
		$this->arResult['COMPONENT_ID'] = $this->component_id;
		$this->includeComponentTemplate();

}


};

?>