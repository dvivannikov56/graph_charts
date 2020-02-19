<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arTypes = CIBlockParameters::GetIBlockTypes();

$arIBlocks=Array();
$db_iblock = CIBlock::GetList(Array("SORT"=>"ASC"), Array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];
	
$arSections=Array();
echo $arCurrentValues["IBLOCK_ID"];
$db_section = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID" => ($arCurrentValues["IBLOCK_ID"]!="-"?$arCurrentValues["IBLOCK_ID"]:"")));
while($arRes = $db_section->Fetch())
	$arSections[$arRes["ID"]] = $arRes["NAME"];	

$arSorts = Array(
	"ASC"=>GetMessage("T_IBLOCK_DESC_ASC"),
	"DESC"=>GetMessage("T_IBLOCK_DESC_DESC"),
);

$arSortFields = Array(
		"ID" => GetMessage("T_IBLOCK_DESC_FID"),
		"NAME" => GetMessage("T_IBLOCK_DESC_FNAME"),
		"ACTIVE_FROM" => GetMessage("T_IBLOCK_DESC_FACT"),
		"SORT" => GetMessage("T_IBLOCK_DESC_FSORT"),
		"TIMESTAMP_X" => GetMessage("T_IBLOCK_DESC_FTSAMP")
	);

$arProperty_LNS = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>(isset($arCurrentValues["IBLOCK_ID"])?$arCurrentValues["IBLOCK_ID"]:$arCurrentValues["ID"])));
while ($arr=$rsProp->Fetch())
{
	$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S")))
	{
		$arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	}
}

$arUGroupsEx = Array();
$dbUGroups = CGroup::GetList($by = "c_sort", $order = "asc");
while($arUGroups = $dbUGroups -> Fetch())
{
	$arUGroupsEx[$arUGroups["ID"]] = $arUGroups["NAME"];
}

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"AJAX_MODE" => array(),
		"IBLOCK_TYPE" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CP_BCSL_IBLOCK_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arTypes,
			"DEFAULT" => "news",
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CP_BCSL_IBLOCK_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"SECTION_ID" => Array(
					"PARENT" => "BASE",
					"NAME" => "Раздел",
					"TYPE" => "LIST",
					"VALUES" => $arSections,
					"DEFAULT" => '',
					"ADDITIONAL_VALUES" => "Y",
					"REFRESH" => "Y",
		),		
	
	),
);

unset($arComponentParameters["PARAMETERS"]["PAGER_SHOW_ALWAYS"]);

if($arCurrentValues["USE_PERMISSIONS"]!="Y")
	unset($arComponentParameters["PARAMETERS"]["GROUP_PERMISSIONS"]);
?>
