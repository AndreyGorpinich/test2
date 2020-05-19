<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

CModule::IncludeModule('iblock');



$dbIBlockType = CIBlockType::GetList(
   array("sort" => "asc"),
   array("ACTIVE" => "Y")
);

while ($arIBlockType = $dbIBlockType->Fetch())
{
	if($arIBlockTypeLang = CIBlockType::GetByIDLang($arIBlockType["ID"], LANGUAGE_ID))
	{
      $arIblockType[$arIBlockType["ID"]] = "[".$arIBlockType["ID"]."] ".$arIBlockTypeLang["NAME"];
	}
}


if($arCurrentValues["IBLOCK_TYPE"])
{

		$dbIBlockId = CIBlock::GetList(
			array("SORT" => "ASC"), 
			array(
				'TYPE'=>$arCurrentValues["IBLOCK_TYPE"],  
				'ACTIVE'=>'Y'
			)
		);
		while($arIBlockId = $dbIBlockId->Fetch())
		{
		
			$arIBlock[$arIBlockId["ID"]] = "[".$arIBlockId["ID"]."] ".$arIBlockId["NAME"];
		}
}
else
{
	$arIBlock = array();
}


$arSortField = array(
				'ID'=>"По ID",
				'DATE_CREATE'=>"По дате создания"
				);
$arSortValue = array(
				'ASC'=>"По возрастанию",
				'DESC'=>"По убыванию"
				);


$arComponentParameters = array(
   "GROUPS" => array(
      "SETTINGS" => array(
         "NAME" => 'Настройки',
      ),
   ),
   "PARAMETERS" => array(
      "IBLOCK_TYPE" => array(
         "PARENT" => "SETTINGS",
         "NAME" => 'Выберете тип инфоблока',
         "TYPE" => "LIST",
         "VALUES" => $arIblockType,
         "REFRESH" => "Y"
      ),
      "IBLOCK_ID" => array(
         "PARENT" => "SETTINGS",
         "NAME" => 'Выберете инфоблок',
         "TYPE" => "LIST",
         "ADDITIONAL_VALUES" => "Y",
         "VALUES" => $arIBlock,
      ),
      "ELEMENT_ID" => array(
         "PARENT" => "SETTINGS",
         "NAME" => 'ID элемента',
         "TYPE" => "STRING",
         "MULTIPLE" => "N",
         "DEFAULT" => '={$_REQUEST["ELEMENT_ID"]}',
         "COLS" => 25,
      ),
      "PROP_VOIT" => array(
         "PARENT" => "SETTINGS",
         "NAME" => 'Код свойства для рейтинга',
         "TYPE" => "STRING",
         "MULTIPLE" => "N",
         "DEFAULT" => 'PROP_VOIT',
         "COLS" => 25,
      ),
      "PROP_ELEMENT" => array(
         "PARENT" => "SETTINGS",
         "NAME" => 'Код свойства для привязки',
         "TYPE" => "STRING",
         "MULTIPLE" => "N",
         "DEFAULT" => 'PROP_ELEMENT',
         "COLS" => 25,
      ),
      "SORT" => array(
         "PARENT" => "SETTINGS",
         "NAME" => 'Поле для сортировка',
         "TYPE" => "LIST",
         "MULTIPLE" => "N",
         "VALUES" =>$arSortField,
      ),
      "SORT_VALUE" => array(
         "PARENT" => "SETTINGS",
         "NAME" => 'Сортировка',
         "TYPE" => "LIST",
         "MULTIPLE" => "N",
         "VALUES" =>$arSortValue,
      ),
      "COMMENTS_COUNT" => array(
         "PARENT" => "SETTINGS",
         "NAME" => 'Количество коментариев',
         "TYPE" => "STRING",
         "MULTIPLE" => "N",
         "DEFAULT" => "5",
         "COLS" => 25
      ),
      "SHOW_UNMODERATED" => array(
         "PARENT" => "SETTINGS",
         "NAME" => 'отображать не отмодерированные комментарии для текущего пользователя.',
         "TYPE" => "CHECKBOX",
         "MULTIPLE" => "N",
         "DEFAULT" => "",
         "COLS" => 25
      )
	)
);