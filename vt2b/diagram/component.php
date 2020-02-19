<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
	

	

	if(!CModule::IncludeModule("iblock"))
	{
            $this->AbortResultCache();
            ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
            return;
	}
	$arSelect = array(
			"ID",
			"NAME",
			"CODE",
			"ACTIVE_FROM",
			"IBLOCK_ID",
			"IBLOCK_SECTION_ID",
			"PROPERTY_*",
		);
			// получаем дату 
		$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y", "<=DATE_ACTIVE_FROM"=>date("d.m.Y"));
        $res = CIBlockElement::GetList(array('ACTIVE_FROM'=>'DESC'), $arFilter,  false, Array ("nTopCount" => 1), $arSelect);
      
        while($ob = $res->GetNextElement()) {
            $arItem = $ob->GetFields();
				$arItem['PROPERTIES'] = $ob->GetProperties();

		    $arResult["DATE"]=$arItem['ACTIVE_FROM'];
        }
		
		
		// получаем отрасли
		 $arResult["BRANCHES"]=array();
		 
				$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y", "DATE_ACTIVE_FROM"=>$arResult["DATE"],"SECTION_ID"=>$arParams['SECTION_ID'],"PROPERTY_type"=>5);
        $res = CIBlockElement::GetList(array('ID'=>'DESC'), $arFilter,  false,false, $arSelect);
      
        while($ob = $res->GetNextElement()) {
			$branches=array();
            $arItem = $ob->GetFields();
				$arItem['PROPERTIES'] = $ob->GetProperties();
			$branches["NAME"]=$arItem['NAME'];
			$branches["PROCENT"]=$arItem['PROPERTIES']['procent']['VALUE'];
		    $arResult["BRANCHES"][]=$branches;
        }
		

		// получаем эмитентов
		 $arResult["ISSUERS"]=array();
		 
				$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y", "DATE_ACTIVE_FROM"=>$arResult["DATE"],"SECTION_ID"=>$arParams['SECTION_ID'],"PROPERTY_type"=>6);
        $res = CIBlockElement::GetList(array('ID'=>'DESC'), $arFilter,  false,false, $arSelect);
      
        while($ob = $res->GetNextElement()) {
			$issuers=array();
            $arItem = $ob->GetFields();
				$arItem['PROPERTIES'] = $ob->GetProperties();
			$issuers["NAME"]=$arItem['NAME'];
			$issuers["PROCENT"]=$arItem['PROPERTIES']['procent']['VALUE'];
		    $arResult["ISSUERS"][]=$issuers;
        }
		 
	// получаем инструментов
		 $arResult["INSTRUMENTS"]=array();
		 
				$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y", "DATE_ACTIVE_FROM"=>$arResult["DATE"],"SECTION_ID"=>$arParams['SECTION_ID'],"PROPERTY_type"=>7);
        $res = CIBlockElement::GetList(array('ID'=>'DESC'), $arFilter,  false,false, $arSelect);
      
        while($ob = $res->GetNextElement()) {
			$instrument=array();
            $arItem = $ob->GetFields();
				$arItem['PROPERTIES'] = $ob->GetProperties();
			$instrument["NAME"]=$arItem['NAME'];
			$instrument["PROCENT"]=$arItem['PROPERTIES']['procent']['VALUE'];
		    $arResult["INSTRUMENTS"][]=$instrument;
        }		  
								

	$this->IncludeComponentTemplate();




?>
