<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock'))
	return;

$catalogIncluded = Loader::includeModule('catalog');
$iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);

$arIBlockType = CIBlockParameters::GetIBlockTypes();
$arIBlock = array();
$iblockFilter = (
	!empty($arCurrentValues['IBLOCK_TYPE'])
	? array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE' => 'Y')
	: array('ACTIVE' => 'Y')
);
$rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), $iblockFilter);
while ($arr = $rsIBlock->Fetch())
	$arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
unset($arr, $rsIBlock, $iblockFilter);

//Получаем разделы (только стратегии)
$arFilter         = array(
 'ACTIVE'        => 'Y',
 'IBLOCK_ID'     => 25,
 'GLOBAL_ACTIVE' => 'Y',
 'UF_TYPE' => 1
);
$arSelect         = array('IBLOCK_ID', 'ID', 'NAME', 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID','UF_*');
$arOrder          = array('DEPTH_LEVEL' => 'ASC', 'SORT' => 'ASC');
$rsSections       = CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);
$sectionLinc      = array();
$arResult['ROOT'] = array();
$sectionLinc[0]   = &$arResult['ROOT'];
while ($arSection = $rsSections->GetNext()) {
 $sectionLinc[(int)$arSection['IBLOCK_SECTION_ID']]['CHILD'][$arSection['ID']] = $arSection;
 $sectionLinc[$arSection['ID']] = &$sectionLinc[(int)$arSection['IBLOCK_SECTION_ID']]['CHILD'][$arSection['ID']];
}
unset( $sectionLinc );
$arResult['ROOT'] = $arResult['ROOT']['CHILD'];
foreach ($arResult['ROOT'] as $key => $value) {
$sect_name[$key] = $arResult['ROOT'][$key]['NAME'];
}
//Поля для параметров
$arComponentParameters = array(
	"PARAMETERS" => array(
		"IBLOCK_TYPE" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("CP_BCSF_IBLOCK_TYPE"),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arIBlockType,
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("CP_BCSF_IBLOCK_ID"),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
		),	
		"GRAPH_TYPE" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "Тип графика",
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $sect_name,	
			"DEFAULT" => "0",
		),
			"BENCHMARK" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "Бенчмарк",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		
		"CACHE_TIME" => array(
			"DEFAULT" => 36000000,
		),
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("CP_BCSF_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
	),
);