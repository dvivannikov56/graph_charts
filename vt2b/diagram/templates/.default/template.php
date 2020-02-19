<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$colors=array("#0f577e","#233d80","#4b87bf","#d8d9d9","#72c4d7","#12628a","#233d80","#4b87bf");
?>
<div class="row">
	<div class="large-12 columns">
      <div class="condition">По состоянию на <?=$arResult['DATE']?></div> 
      <div class="branches">
      		<div class="branch_title">По отраслям</div> 
            <div id="contain" class="diagramm"></div>
      </div>
      <div class="emitents">
      		<div class="top10">ТОП-10 позиций</div>
            <table class="emitent">
            	<? foreach($arResult["ISSUERS"] as $issuer):?>
            	<tr>
                	<td>
                    	<?=$issuer['NAME']?>
                	</td>
                	<td>
                    	<?=$issuer['PROCENT']?> %
                	</td>                    
                </tr>
                	<?endforeach?>
            </table>
      </div>
    </div>
</div>

<div class="row">
	<div class="large-12 columns">
		<div class="instruments">
        		<div class="instrument">
        	<? foreach($arResult["INSTRUMENTS"] as $item):?>
            		
                    <div class="circle"><?=$item['PROCENT']?>%</div>
                    <div class="instrument-title">
                        <?=$item['PROCENT']?>%<br />
                        <?=$item['NAME']?>
                    </div>
            <?endforeach?>
            </div>
        </div>
    </div>
</div>


		<script type="text/javascript">
		if (document.documentElement.clientWidth > 1024) {
		// Radialize the colors
// Radialize the colors
Highcharts.setOptions({
    colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.9,
                cy: 0.9,
                r: 1,
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.7).get('rgb')] // darken
            ]
        };
    })
});

Highcharts.chart('contain', {
    chart: {
		 fillColor: '#c3d6e5',
        plotBorderWidth: 0,
		plotBorderColor:"#000",
        plotShadow: false,
		spacingTop: 0,
		spacingBottom: 0,
		height:'400px'
    },
	    legend: {
        align: 'right',
        verticalAlign: 'top',
        layout: 'vertical',
		itemMarginBottom: 10,
        x: 0,
        y: 70,
		itemWidth: 300,
	 labelFormatter: function () {
            return '<span>'+this.y+"</span>% " + this.name;
        },
		  itemStyle: {
            color: '#000000',
            fontWeight: 'normal',
			fontSize:'15px',
			fontFamily:'Open Sans',
        }
		
    },
    title: {
        text: '',
        align: 'left',
        verticalAlign: 'top',
        y: 0
    },
    tooltip: {
	useHTML: true,
	backgroundColor:"#fff",
	borderColor:"#d3af6b",
	className: "tooltip",
	borderRadius: 10,
	   headerFormat: '',
        pointFormat: '<span style="font-size:23px; font-family: Open Sans; color:#d3af6b">{point.y}%</span><br><span style="color:#4c6878">{point.name}</span>'
    },
	
    credits: {
        enabled: false
    },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: false,
                distance: -100,
               connectorColor: 'silver'
            },
            startAngle: 360,
            endAngle: 30,
            center: ['50%', '50%'],
            size: '100%',
			showInLegend: true,
			
        }
    },
    navigation: {
        buttonOptions: {
            enabled: false
        }
    },
    series: [{
	states: {
                hover: {
                    halo: {
                        size: 9,
						opacity:1,
                        attributes: {
                            fill: "#d3af6b",

                        }
                    }

                }
            },
	
        type: 'pie',
        name: '',
        innerSize: '70%',
        data: [
			<? foreach($arResult["BRANCHES"] as $k=>$branch):?>
            { name: '<?=$branch['NAME']?>',  y: <?=$branch['PROCENT']?>, color: "<?=$colors[$k]?>" },
			<?endforeach?>
        ]
    }]
});

var Circle = function(sel){
    var circles = document.querySelectorAll(sel);
    [].forEach.call(circles,function(el){
        var valEl = parseFloat(el.innerHTML);
        valEl = valEl*408/100;
		valEl=parseFloat(valEl.toFixed(2));
        el.innerHTML = '<svg width="89" height="89"><circle transform="rotate(-90)" r="35" cx="-44" cy="44" /><circle transform="rotate(-90)" style="stroke-dasharray:'+valEl+'px 408px;" r="35" cx="-44" cy="44" /></svg>';
        
    });
};
Circle('.circle');
		}


		</script>