<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
	

	

	if(!CModule::IncludeModule("iblock"))
	{
            $this->AbortResultCache();
            ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
            return;
	}
;
			// получаем стоимость и дату текущего пая
		$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y","SECTION_ID"=>$arParams['SECTION'],"<=DATE_ACTIVE_FROM"=>date("d.m.Y"));
        $res = CIBlockElement::GetList(array('ACTIVE_FROM'=>'DESC'), $arFilter,  false, Array ("nTopCount" => 1), $arSelect);
      
        while($ob = $res->GetNextElement()) {
            $arItem = $ob->GetFields();
				$arItem['PROPERTIES'] = $ob->GetProperties();

		    $arResult["NOW_DATE"]=$arItem['ACTIVE_FROM'];
			$arResult["NOW_PRICE"]=$arItem['PROPERTIES']['price']['VALUE'];
        }
		  
		  // На начало года
		  
		  $yer=substr($arResult["NOW_DATE"],6,4);
		  $year=$yer;
		  
		  $items=array();
		  
		$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y","SECTION_ID"=>$arParams['SECTION'], "<=DATE_ACTIVE_FROM"=>"31.12.".($yer-1));
        $res = CIBlockElement::GetList(array('ACTIVE_FROM'=>'DESC'), $arFilter,  false, Array ("nTopCount" => 1), $arSelect);
      
        while($ob = $res->GetNextElement()) {
            $arItem = $ob->GetFields();
				$arItem['PROPERTIES'] = $ob->GetProperties();
				$items[$arItem['ACTIVE_FROM']]=$arItem['PROPERTIES']['price']['VALUE'];

		    $arResult["BEGIN_YEAR_DATE"]=$arItem['ACTIVE_FROM'];
			$arResult["BEGIN_YEAR_PRICE"]=round((($arResult["NOW_PRICE"]-$arItem['PROPERTIES']['price']['VALUE'])/$arItem['PROPERTIES']['price']['VALUE'])*100,2);
        }
	


		  // За 1 месяц
		$month=substr($arResult["NOW_DATE"],3,2);
		
	
		$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y","SECTION_ID"=>$arParams['SECTION'], "<DATE_ACTIVE_FROM"=>$arResult["NOW_DATE"]);
        $res = CIBlockElement::GetList(array('ACTIVE_FROM'=>'DESC'), $arFilter,  false, Array ("nTopCount" => 1), $arSelect);
      
        while($ob = $res->GetNextElement()) {
            $arItem = $ob->GetFields();
				$arItem['PROPERTIES'] = $ob->GetProperties();

		    $arResult["ONE_MONTH_DATE"]=$arItem['ACTIVE_FROM'];
			$arResult["ONE_MONTH_PRICE"]=round((($arResult["NOW_PRICE"]-$arItem['PROPERTIES']['price']['VALUE'])/$arItem['PROPERTIES']['price']['VALUE'])*100,2);
        }
		
		  // За 3 месяца
		  if ($month<3)  {
			$year=$yer-1;
		  }
			 
	
		 if ($month<=2) $mont=10+$month;
		  else $mont=$month-2;
		
		  	
	
		$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y","SECTION_ID"=>$arParams['SECTION'], "<=DATE_ACTIVE_FROM"=>"01.".$mont.".".$year);
        $res = CIBlockElement::GetList(array('ACTIVE_FROM'=>'DESC'), $arFilter,  false, Array ("nTopCount" => 1), $arSelect);
      
        while($ob = $res->GetNextElement()) {
            $arItem = $ob->GetFields();
				$arItem['PROPERTIES'] = $ob->GetProperties();

		    $arResult["THREE_MONTH_DATE"]=$arItem['ACTIVE_FROM'];
			$arResult["THREE_MONTH_PRICE"]=round((($arResult["NOW_PRICE"]-$arItem['PROPERTIES']['price']['VALUE'])/$arItem['PROPERTIES']['price']['VALUE'])*100,2);
        }	
		
		  // За 6 месяцев

			$month=substr($arResult["NOW_DATE"],3,2);
		 		  		  if ($month<6) {
				  	$year=$yer-1;
				
				  }
		  
					 
					  if (intval($month)<6) $mont=7+$month;
		  else   $mont=$month-5;
		   
		
		  
		//$month=date('m')-6;
		
		$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y","SECTION_ID"=>$arParams['SECTION'], "<DATE_ACTIVE_FROM"=>"01.".$mont.".".$year);
        $res = CIBlockElement::GetList(array('ACTIVE_FROM'=>'DESC'), $arFilter,  false, Array ("nTopCount" => 1), $arSelect);
      
        while($ob = $res->GetNextElement()) {
            $arItem = $ob->GetFields();
				$arItem['PROPERTIES'] = $ob->GetProperties();

		    $arResult["SIX_MONTH_DATE"]=$arItem['ACTIVE_FROM'];
			
		
			$arResult["SIX_MONTH_PRICE"]=round((($arResult["NOW_PRICE"]-$arItem['PROPERTIES']['price']['VALUE'])/$arItem['PROPERTIES']['price']['VALUE'])*100,2);
        }	
		
		  // За 1 год
		$year=$yer-1;
		$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y","SECTION_ID"=>$arParams['SECTION'], "<=DATE_ACTIVE_FROM"=>"31.".$month.".".$year);
        $res = CIBlockElement::GetList(array('ACTIVE_FROM'=>'DESC'), $arFilter,  false, Array ("nTopCount" => 1), $arSelect);
      
        while($ob = $res->GetNextElement()) {
            $arItem = $ob->GetFields();
				$arItem['PROPERTIES'] = $ob->GetProperties();

		    $arResult["ONE_YEAR_DATE"]=$arItem['ACTIVE_FROM'];
			$arResult["ONE_YEAR_PRICE"]=round((($arResult["NOW_PRICE"]-$arItem['PROPERTIES']['price']['VALUE'])/$arItem['PROPERTIES']['price']['VALUE'])*100,2);
        }	
		
		  // За 3 года
		$year=$yer-3;
		$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y", "SECTION_ID"=>$arParams['SECTION'],"<=DATE_ACTIVE_FROM"=>"31.".$month.".".$year);
        $res = CIBlockElement::GetList(array('ACTIVE_FROM'=>'DESC'), $arFilter,  false, Array ("nTopCount" => 1), $arSelect);
      
        while($ob = $res->GetNextElement()) {
            $arItem = $ob->GetFields();
				$arItem['PROPERTIES'] = $ob->GetProperties();
		    $arResult["THREE_YEARS_DATE"]=$arItem['ACTIVE_FROM'];
			$arResult["THREE_YEARS_PRICE"]=round((($arResult["NOW_PRICE"]-$arItem['PROPERTIES']['price']['VALUE'])/$arItem['PROPERTIES']['price']['VALUE'])*100,2);
        }	
		
		  // За 5 лет
		$year=$yer-5;
	
		$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y", "SECTION_ID"=>$arParams['SECTION'],"<=DATE_ACTIVE_FROM"=>"31.".$month.".".$year);
        $res = CIBlockElement::GetList(array('ACTIVE_FROM'=>'DESC'), $arFilter,  false, Array ("nTopCount" => 1), $arSelect);
      
        while($ob = $res->GetNextElement()) {
            $arItem = $ob->GetFields();
				$arItem['PROPERTIES'] = $ob->GetProperties();
		    $arResult["FIVE_YEARS_DATE"]=$arItem['ACTIVE_FROM'];
			$arResult["FIVE_YEARS_PRICE"]=round((($arResult["NOW_PRICE"]-$arItem['PROPERTIES']['price']['VALUE'])/$arItem['PROPERTIES']['price']['VALUE'])*100,2);
        }										
								

	$this->IncludeComponentTemplate();




?>
