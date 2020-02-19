<?php

	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/xml.php");
	CModule::IncludeModule("iblock");

$strQueryText = QueryGetData(
"peramo.dev-vt2b.ru",
80,
"/xml/file_data.xml",
"",
$error_number,
$error_text

);
$objXML = new CDataXML();
$objXML->LoadString($strQueryText);
$arData = $objXML->GetArray();



$arValue=array();
foreach ($arData['Chart_data']['#']['Data_values'][0]['#']['Data_value'] as $arValue)
{




$bs = new CIBlockSection;
$arFields = Array(
  "ACTIVE" => "Y",
  "IBLOCK_ID" => 25,
  "NAME" => $arValue['#']['Value_name'][0]['#'],

  );

  $section_id = $bs->Add($arFields);

  foreach ($arValue['#']['Values']['0']['#']['Date'] as $k=>$item)
	{
		$el = new CIBlockElement;
		$PROP = array();
		$PROP['price']=$arValue['#']['Values']['0']['#']['Value'][$k]['#'];
		
			$arLoad = Array(
	  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
	  "IBLOCK_SECTION_ID" => $section_id,          
	  "IBLOCK_ID"      => 25,
	  "PROPERTY_VALUES"=> $PROP,
	  "NAME"           => $item['#'],
	  "ACTIVE"         => "Y",
	  "DATE_ACTIVE_FROM"=>$item['#'],
	  
	              // активен
	  );
	
	if($PRODUCT_ID = $el->Add($arLoad)) {
   echo 'New ID: '.$PRODUCT_ID;
} else {
   echo 'Error: '.$el->LAST_ERROR;
}
		
		echo $item['#']." ".$arValue['#']['Values']['0']['#']['Value'][$k]['#']."<br>";
		
	}

    //foreach ($arValue['Data_value']['0']['Data_values'] as $arValue)



}


?>