<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<style>
  #span {
    color: #ccb48e !important;
    letter-spacing: 3px;
    font-weight: bold;
    position: relative;
    top: 5px;
  }
</style>
<main role="main" class="row l-main">
<!-- .l-main region -->
<div class="medium-8 medium-push-4  main columns"> <a id="main-content"></a>
  <article id="node-33" class="node node-page view-mode-full" about="/pif/conservatoriya/card" typeof="foaf:Document"> <span property="dc:title" content="Карточка фонда" class="rdf-meta element-hidden"></span>
    <div class="body field">
    	<div class="pai_top tj">
        <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/pai_top.php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "include_area.php"
								),
								false
							);?>
		</div>
	</div>
   </article>
</div>
<? $APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"company", 
	array(
		"ROOT_MENU_TYPE" => "pif",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_THEME" => "site",
		"CACHE_SELECTED_ITEMS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "company"
	),
	false
);
?>


</main>
<div class="graph_background pais">
  <div class="row">
  	<div class="medium-8 medium-push-4  main columns"> 
   		 <h3 class="graph_title">Динамика <br />доходности пая</h3>
           <?$APPLICATION->IncludeComponent(
	"vt2b:graph", 
	"pai", 
	array(
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"IBLOCK_ID" => "25",
		"IBLOCK_TYPE" => "Pai",
		"SEF_MODE" => "N",
		"COMPONENT_TEMPLATE" => ".default",
		"BENCHMARK" => "Y",
		"GRAPH_TYPE" => array(
			0 => "147",
		),
		"GRAPH_TITLE" => array(
			0 => "0",
			1 => "1",
		)
	),
	false
);?>
 	</div>
  </div>
</div>
</div>
<main role="main" class="row">
    <div class="medium-8 medium-push-4  main columns"> <a id="main-content"></a>
  <article id="node-33" class="node node-page view-mode-full" about="/pif/conservatoriya/card" typeof="foaf:Document"> <span property="dc:title" content="Карточка фонда" class="rdf-meta element-hidden"></span>
    <div class="body field">
       <div id="table-info-peramo">
        <table class="sticky-enabled">
          <caption>
          <div id="caption-2">Изменение стоимости пая на <?=$arResult['NOW_DATE']?> <br><span id="span" style="color: #ccb48e;">( в процентах за период )</span></div>

          </caption>
          <thead>
            <tr>
              <th>Дата</th>
              <th>Расчет стоимости пая, руб.</th>
              <th colspan="2">С начала года</th>
              <th colspan="2">За 1 мес.</th>
              <th colspan="2">За 3 мес.</th>
              <th colspan="2">За 6 мес.</th>
              <th colspan="2">За 1 год</th>
              <th colspan="2">За 3 года</th>
              <th colspan="2">За 5 лет</th>
            </tr>
          </thead>
          <tbody>
            <tr class="odd">
              <td><?=$arResult['NOW_DATE']?></td>
              <td><?=str_replace(".",",",$arResult["NOW_PRICE"])?></td>
              <td><?=str_replace(".",",",$arResult["BEGIN_YEAR_PRICE"])?></td>
              <td class="<?=($arResult["BEGIN_YEAR_PRICE"]>0)?'plus':'minus'?>"></td>              
              <td><?=str_replace(".",",",$arResult["ONE_MONTH_PRICE"])?></td>
              <td class="<?=($arResult["ONE_MONTH_PRICE"]>0)?'plus':'minus'?>"></td>
              <td><?=str_replace(".",",",$arResult["THREE_MONTH_PRICE"])?></td>
              <td class="<?=($arResult["THREE_MONTH_PRICE"]>0)?'plus':'minus'?>"></td>              
              <td><?=str_replace(".",",",$arResult["SIX_MONTH_PRICE"])?></td>
              <td class="<?=($arResult["SIX_MONTH_PRICE"]>0)?'plus':'minus'?>"></td> 
              <td><?=str_replace(".",",",$arResult["ONE_YEAR_PRICE"])?></td>
              <td class="<?=($arResult["ONE_YEAR_PRICE"]>0)?'plus':'minus'?>"></td>                                  
              <td><?=str_replace(".",",",$arResult["THREE_YEARS_PRICE"])?></td>
              <td class="<?=($arResult["THREE_YEARS_PRICE"]>0)?'plus':'minus'?>"></td>  
              <td><?=str_replace(".",",",$arResult["FIVE_YEARS_PRICE"])?></td>
              <td class="<?=($arResult["FIVE_YEARS_PRICE"]>0)?'plus':'minus'?>"></td>  
            </tr>
          </tbody>
        </table>
      </div>
              <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/pai_bottom.php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "include_area.php"
								),
								false
							);?>
                              <br /><br />
                          

    </div>
    <div class="row">
      <div class="large-12 columns"> </div>
    </div>
  </article>
</div>

<!--/.l-main region  --> 
</main>