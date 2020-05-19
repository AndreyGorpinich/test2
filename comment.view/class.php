<?
class CommentWiew extends CBitrixComponent
{


var $component_id = 'CommentWiew';

private function USER(){
	global $USER;
	return $USER;
}

private function APPLICATION(){
	global $APPLICATION;
	return $APPLICATION;
}


public function CommentGetList(){

	$PROP_ELEMENT = $this->arParams['PROP_ELEMENT'];

	$sort_value = $this->arParams['SORT_VALUE'];
	$sort = $this->arParams['SORT'];
	$arSort[$sort] = $sort_value;
	
	$arNav['nPageSize']= $this->arParams['COMMENTS_COUNT'];

	if($this->arParams['SHOW_UNMODERATED']=="Y"){
		$arFilter["LOGIC"] = "OR";

	$arFilter[0]["CREATED_BY"]=$this->USER()->GetID();
	$arFilter[0]['IBLOCK_ID'] = $this->arParams['IBLOCK_ID'];
	$arFilter[0]['PROPERTY_'.$PROP_ELEMENT.'.ID'] = $this->arParams['ELEMENT_ID'];
	}

	$arFilter[1]['IBLOCK_ID'] = $this->arParams['IBLOCK_ID'];
	$arFilter[1]['PROPERTY_'.$PROP_ELEMENT.'.ID'] = $this->arParams['ELEMENT_ID'];
	$arFilter[1]['ACTIVE']='Y'; 

	$resComments = CIBlockElement::GetList(
											$arSort, 
											$arFilter,
											false,
											$arNav, 
											array(
													"ID",
													"IBLOCK_ID",
													"CREATED_BY",
													"DATE_CREATE",
													"ACTIVE",
													"NAME",
													"PREVIEW_TEXT",
													"DETAIL_TEXT",
													"PROPERTY_".$PROP_ELEMENT
												)
										);

	while($arComment = $resComments->Fetch())
	{

		$GetFIO = explode(",",$arComment['NAME']);
		$arComment['FIO'] = $GetFIO[1];
		$this->arResult['LIST'][] = $arComment;
	}

	$this->arResult["NAV_STRING"] = 	$resComments->GetPageNavString();

}


public function executeComponent(){

	CModule::IncludeModule("iblock");

	if($this->arParams['CACHE_TIME'])
	{
		$cache_time = false;
	}
	else
	{
		$cache_time = 3600;
	}


		$paramCache['request'] = $_REQUEST;
		$paramCache['CompParams'] = $this->arParams;
		$paramCache['user'] = $this->USER()->GetID();
		unset($paramCache['request']['AJAX']);
		unset($paramCache['request']['clear_cache']);

		$key = md5(json_encode($paramCache));
		$cache_id = $this->GetName().$key;
		$obCache = \Bitrix\Main\Data\Cache::createInstance();

		if( $obCache->initCache($cache_time,$cache_id,"/".SITE_ID.$this->GetRelativePath()) )
			{
				$this->arResult = $obCache->GetVars();
				if($_REQUEST['AJAX']=="Y")
					{
						$this->APPLICATION()->RestartBuffer();
						echo json_encode($this->arResult);
						die();
					}
				else
					{
						$this->includeComponentTemplate();
					}


			}
	   		elseif($obCache->startDataCache())
			{

				$this->CommentGetList();
				$this->includeComponentTemplate();
				$obCache->endDataCache($this->arResult);

				if($_REQUEST['AJAX']=="Y")
					{
						$this->APPLICATION()->RestartBuffer();
						echo json_encode($this->arResult);
						die();
					}

			}

}


};

?>