<?php

	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/xml.php");
	CModule::IncludeModule("iblock");
	$IBLOCK_ID=25;

$strQueryText = QueryGetData(
"peramo.dev-vt2b.ru",
80,
"/xml/pai.xml",
"",
$error_number,
$error_text

);
$objXML = new CDataXML();
$objXML->LoadString($strQueryText);
$arData = $objXML->GetArray();
/*
echo "<pre>";
print_r($arData);
echo "</pre>";
*/
$arValue=array();

foreach ($arData['Chart_data']['#']['Data_values'][0]['#']['Data_value'] as $r=>$arValue)
{

$section_name=$arValue['#']['Value_name'][0]['#'];

// проверика есть ли стратегия (раздел)
$arFilter = array(
    "IBLOCK_ID" => $IBLOCK_ID,
	"NAME"=>$section_name,
 
);
$res = CIBlockSection::GetList(Array(), $arFilter);
if  ($res->SelectedRowsCount()==0){

	$bs = new CIBlockSection;
	$arFields = Array(
	  "ACTIVE" => "Y",
	  "IBLOCK_ID" => $IBLOCK_ID,
	  "NAME" => $section_name,
	
	  );
	  if ($arValue['#']['Value_type'][0]['#']=="Стратегия") $arFields['UF_TYPE']=1;
	  	elseif ($arValue['#']['Value_type'][0]['#']=="бенчмарк") $arFields['UF_TYPE']=2;
		$arFields['UF_UNIT']=$arValue['#']['Value_unit'][0]['#'];
	  $section_id = $bs->Add($arFields);
	


  
}  else {
		$arFilter = Array('IBLOCK_ID'=>$IBLOCK_ID,"NAME"=>"%".$section_name."%",);
		$db_list = CIBlockSection::GetList(Array('SORT'=>'ASC'), $arFilter, true, $arSelect);
		
		  while($ar_result = $db_list->GetNext())
		  {
				$section_id=$ar_result['ID'];
	
	
		
		  }
		   
}
  foreach ($arValue['#']['Values']['0']['#']['Date'] as $k=>$item)
	{
		// проверка на изменение элемента
		$price=str_replace(",",".",ltrim($arValue['#']['Values']['0']['#']['Value'][$k]['#']));
		  $arFilter = Array(
		  "IBLOCK_ID" => $IBLOCK_ID,
		  "ACTIVE" => "Y",
		  "NAME" => $item['#'],
		  "SECTION_ID" => $section_id,
		  "INCLUDE_SUBSECTIONS"=>"Y"
	  );
	  $arSelect = array(
			"ID",
			"NAME",
			"IBLOCK_ID",
			"PROPERTY_*",
		);
	  $res      = CIBlockElement::GetList(array('ID' => 'ASC'), $arFilter, false, array('nTopCount' => 1), $arSelect);
	  if (intval($res->SelectedRowsCount())>0){
		  $arItem=array();
		 while($ob = $res->GetNextElement()) {
				$arItem = $ob->GetFields();
				$arItem['PROPERTIES'] = $ob->GetProperties();
				if ($arItem['PROPERTIES']['price']['VALUE']<>$price){
						 CIBlockElement::SetPropertyValueCode($arItem['ID'], "price", $price);
					//	echo "Изменилось $section_name ".$item['#']." $price <br>";
				}
				
			}	  
		  
		
		
	  } else {
		$el = new CIBlockElement;
		$PROP = array();
		$PROP['price']=$price;
		
			$arLoad = Array(
	  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
	  "IBLOCK_SECTION_ID" => $section_id,          
	  "IBLOCK_ID"      => $IBLOCK_ID,
	  "PROPERTY_VALUES"=> $PROP,
	  "NAME"           => $item['#'],
	  "ACTIVE"         => "Y",
	  "DATE_ACTIVE_FROM"=>$item['#'],
	  
	              // активен
	  );
	
			if($PRODUCT_ID = $el->Add($arLoad)) {
		} 
	  }
		
		
	}



}

// бенчмарки

foreach ($arData['Chart_data']['#']['Data_values'][0]['#']['Data_value'] as $r=>$arValue){
	  if ($arValue['#']['Value_type'][0]['#']=="Стратегия"){
	$section_name=$arValue['#']['Value_name'][0]['#'];
		$arFilter = Array('IBLOCK_ID'=>$IBLOCK_ID,"NAME"=>"%".$section_name."%",);
		$db_list = CIBlockSection::GetList(Array('SORT'=>'ASC'), $arFilter, true, $arSelect);
		
		  while($ar_result = $db_list->GetNext())
		  {
				$section_id=$ar_result['ID'];
				 $bench=$ar_result['UF_BENCHMARK'];
	
	
		
		  }

	$benchmark=$arValue['#']['Benchmark'][0]['#'];
	
	
	$arFilter = Array('IBLOCK_ID'=>$IBLOCK_ID,"NAME"=>$benchmark);
	$arSelect=array("ID","NAME","DESCRIPTION","UF_*");
		$db_list = CIBlockSection::GetList(Array('SORT'=>'ASC'), $arFilter, true, $arSelect);
		
		  while($ar_result = $db_list->GetNext())
		  {
			
			if (!in_array($ar_result['ID'], $bench))
				$bench[]=$ar_result['ID'];
				$bs = new CIBlockSection;
				   $arFields = Array(
				 "UF_BENCHMARK" => $bench,
			  );

      		$bs->Update($section_id, $arFields); 
	
		
		  }
	}
	
}


echo "Парсинг успешно завершен";


?>