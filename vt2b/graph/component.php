<?
CModule::IncludeModule("iblock");
$section = $arParams["GRAPH_TYPE"];//для стратегий
$iblock_id = $arParams["IBLOCK_ID"];
$benchmark = $arParams["BENCHMARK"];
$graph_title = array();
$arResult["LINKS"]= array();

foreach ($section as $key => $value) {
	$res[] = CIBlockSection::GetByID($section[$key]);
	$ar_res[] = $res[$key]->GetNext();
	
}

//$title = $arParams["GRAPH_TYPE"];
//если есть бенчмарки
if ($benchmark == "Y") {
	$arResult["BENCHMARK"] = $benchmark;
	foreach ($section as $key => $value) {
		$arFilter = array('IBLOCK_ID' => $iblock_id, 'ACTIVE' => 'Y',"ID"=>intval($value)); 
		$arSelect = array('ID', 'NAME','UF_*');
		$rsSection = CIBlockSection::GetTreeList($arFilter, $arSelect); 
		while($arSection = $rsSection->Fetch()) {
			// $arr[$i]['title'][] = $arSection["NAME"];
			$uf_data['type'][] = $arSection["UF_TYPE"];
			$uf_data['benchmark'][] = $arSection["UF_BENCHMARK"][0];
			$uf_data['id'][] = $arSection["ID"];
			$graph_title[]=$arSection["UF_NAME"];
			$arResult["LINKS"][]=$arSection["UF_LINK"];
			
			
		}
	}
	$arResult["LINKS"][]='/trust-management/peramo-premium/';
	$arResult['BENCHMARKS']=array();
	foreach ($uf_data['benchmark'] as  $item) {
		$res = CIBlockSection::GetByID($item);
		if($ar_res = $res->GetNext()) $arResult['BENCHMARKS'][]=$ar_res['NAME'];
		
	}
	
		$sect = array_values($uf_data['benchmark']);
		$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_*","ACTIVE_FROM");
		
		for ($i=0; $i < count($uf_data['id']) ; $i++) {
			$arFilter = Array("IBLOCK_ID"=>$iblock_id, "SECTION_ID" => $uf_data['id'][$i]);
			$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
			while($ob = $res->GetNextElement()){ 
				$arFields = $ob->GetFields();
				$arProps = $ob->GetProperties();
				$arrs[$uf_data['id'][$i]]['date'][] = strtotime($arFields["NAME"]);
				$arrs[$uf_data['id'][$i]]['price'][] = $arProps["price"]["VALUE"];
			}
			
					$arFilter1 = Array("IBLOCK_ID"=>$iblock_id, "SECTION_ID" => $uf_data['benchmark'][$i]);
					$res1 = CIBlockElement::GetList(Array(), $arFilter1, false, false, $arSelect);
					while($ob1 = $res1->GetNextElement()){ 
						$arFields1 = $ob1->GetFields();
						$arProps1= $ob1->GetProperties();
						$arrs[$uf_data['id'][$i]]['benchmark'][$i]['date'][]  = strtotime($arFields1["NAME"]);
						$arrs[$uf_data['id'][$i]]['benchmark'][$i]['price'][] = $arProps1["price"]["VALUE"];
					}

				
			
		}
	
		
		/*/
		for ($i=0; $i < count($uf_data['id']); $i++) {
			//$arrs[$uf_data['id'][$i]]['t'] = $uf_data['type'][$i];
			$arrs[$uf_data['id'][$i]]['benchmark'] = $uf_data['benchmark'][$i];
			if ($arrs[$uf_data['id'][$i]]['benchmark']) {
				$arrs[$uf_data['id'][$i]]['benchmark'][] = $arrs[$uf_data['benchmark'][$i][0]];
				unset($arrs[$uf_data['benchmark'][$i][0]]);
			}
			if (!$arrs[$uf_data['id'][$i]]['date']) {
				unset($arrs[$uf_data['id'][$i]]);
			}
		}
		*/
// 	for ($i=0; $i < count($arrs[0]["date"]); $i++) { 
// $arrs[0]['date'][$i] = strtotime($arrs[0]['date'][$i]);
// 	}
	$arrs = array_values($arrs);
	// print_r($arFields["NAME"]);
	//если нет бенчмарков
} else {
	$arFilter = array('IBLOCK_ID' => $iblock_id, 'ACTIVE' => 'Y'); 
	$arSelect = array('ID', 'NAME','UF_*');
	$rsSection = CIBlockSection::GetTreeList($arFilter, $arSelect); 
	while($arSection = $rsSection->Fetch()) {
		// $arr[$i]['title'][] = $arSection["NAME"];
		$uf_data['type'][] = $arSection["UF_TYPE"];
		$uf_data['benchmark'][] = $arSection["UF_BENCHMARK"];
		$uf_data['id'][] = $arSection["ID"];
	}
	$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_*");
	for ($i=0; $i < count($section) ; $i++) {
		$arFilter = Array("IBLOCK_ID"=>$iblock_id, "SECTION_ID"=>$section[$i]);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNextElement()){ 
			$arFields = $ob->GetFields();
			$arProps = $ob->GetProperties();
			$arrs[$i]['date'][]  = strtotime($arFields["NAME"]);
			$arrs[$i]['price'][] = $arProps["price"]["VALUE"];
		}
	}
}
/*
 echo '<pre>';
 print_r($arrs);
  echo '</pre>';
  */
  // меняеем значения у стратегии
  
  
 if  ($APPLICATION->GetCurDir()!='/pif/conservatoriya/card/'){
	   // меняеем значения у стратегии
		$arres=array();
	for ($j=0; $j < count($uf_data['id']) ; $j++) {
	
		$prirost=array(0=>100);
		 $arres[$j]['date']=array();
		$arres[$j]['price'][0]=0;
		$arres[$j]['date'][0]=$arrs[$j]['date'][0];
		for ($i=1; $i < count($arrs[$j]['price']); $i++) {
			  $arres[$j]['date'][$i]=$arrs[$j]['date'][$i];
			  $prirost[$i]=$prirost[$i-1]*$arrs[$j]['price'][$i];
			  $arres[$j]['price'][$i]=$prirost[$i]-100;
		}
		   // меняеем значения у бенчмарка
		$prirost=array(0=>100);
		 $arres[$j]['benchmark'][$j]['date']=array();
		$arres[$j]['benchmark'][$j]['price'][0]=0;
		$arres[$j]['benchmark'][$j]['date'][0]=$arrs[$j]['benchmark'][$j]['date'][0];
		for ($i=1; $i < count($arrs[$j]['benchmark'][$j]['price']); $i++) {
			  $arres[$j]['benchmark'][$j]['date'][$i]=$arrs[$j]['benchmark'][$j]['date'][$i];
			  $prirost[$i]=$prirost[$i-1]*$arrs[$j]['benchmark'][$j]['price'][$i];
			  $arres[$j]['benchmark'][$j]['price'][$i]=$prirost[$i]-100;
		}
	}
 }
/*
  echo '<pre>';
 print_r($arres);
  echo '</pre>';
*/
function array2json($arr)
{
	if (function_exists('json_encode')) {
        return json_encode($arr);
    }
    //Старшие версии php уже имеют данный функционал.
    $parts = array();
    $is_list = false;

    //Проверяем, является ли массив индексным
    $keys = array_keys($arr);
    $max_length = count($arr) - 1;
    if (($keys[0] == 0) and ($keys[$max_length] == $max_length)) { //Проверяем что первый ключ 0, а последний length - 1
        $is_list = true;
        for ($i = 0; $i < count($keys); $i++) { //Проверяем чтобы каждый ключ соответствовал своей позиции
            if ($i != $keys[$i]) { //Ключ не соответствует позиции.
                $is_list = false; //это ассоциативный массив.
                break;
            }
        }
    }

    foreach ($arr as $key => $value) {
        if (is_array($value)) { //пользовательская обработка массивов
            if ($is_list) {
                $parts[] = array2json($value);
            }
            /* :рекурсия: */
            else {
                $parts[] = '"' . $key . '":' . array2json($value);
            }
            /* :рекурсия: */
        } else {
            $str = '';
            if (!$is_list) {
                $str = '"' . $key . '":';
            }

            //Custom handling for multiple data types
            if (is_numeric($value)) {
                $str .= $value;
            }
            //числа
            elseif ($value === false) {
                $str .= 'false';
            }
            //условные
            elseif ($value === true) {
                $str .= 'true';
            } else {
                $str .= '"' . addslashes($value) . '"';
            }
            //все остальное

            $parts[] = $str;
        }
    }
    $json = implode(',', $parts);

    if ($is_list) {
        return '[' . $json . ']';
    }
//возвращает индексный JSON
    return '{' . $json . '}'; //возвращает ассоциативный JSON
}


$count=count($arrs[0][date])-1;


//результирующий массив переdодим в json
// $mindate = DateTime::createFromFormat('m.d.Y', $arrs[0][date][0]);

// $arResult["MINDATE"]=$mindate->format('Y.m.d');

// $maxdate=DateTime::createFromFormat('m.d.Y', $arrs[0][date][$count]);
// $arResult["MAXDATE"]=$maxdate->format('Y.m.d');

 if  ($APPLICATION->GetCurDir()=='/pif/conservatoriya/card/') $arResult["GRAPH"] = array2json($arrs);
else $arResult["GRAPH"] = array2json($arres);
$arResult["GRAPH_TITLE"] = array2json($graph_title);



 $res = CIBlockElement::GetByID(25398);
		if($text = $res->GetNext()) if ($text['ACTIVE']=="Y") $arResult['PRINT_TEXT']=preg_replace('/\s+/', ' ', $text['~DETAIL_TEXT']);


	$this->IncludeComponentTemplate();
?>