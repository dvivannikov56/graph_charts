<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$colors=array("#12628a","#233d80","#4b87bf","#d8d9d9","#72c4d7");
?>
<div class="struktura">Структура активов</div>
<div class="condition1">По состоянию на <?=$arResult['DATE']?></div> 
 <div class="tabs-mobile" id="tabs-mob">
          <ul>
            <li><a href="#tabs-3"><span>Отрасли</span></a></li>
            <li class="tc"><a href="#tabs-4"><span>Инструменты</span></a></li>
            <li><a href="#tabs-5"><span>Топ-10</span></a></li>
          </ul>
          <div id="tabs-3">
          	      <div class="branches">
            			<div id="container-dia" class="diagramm"></div>
     			 </div>
          </div>
          <div id="tabs-4">
          	      <div class="branches">
            			<div id="container-dia2" class="diagramm"></div>
     			 </div>        
          </div>
           <div id="tabs-5">
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


		<script type="text/javascript">
	window.onload = function () {
		
			if (screen.width<400) {
				
		// для мобильных
Highcharts.setOptions({
    colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    })
});
Highcharts.chart('container-dia', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
		plotBorderColor:"#000",
        plotShadow: false,
		spacingTop: 0,
		spacingBottom: 0,
		height:'600',
		 width:'500',
    },
	    legend: {
        layout: 'horizontal',
		itemMarginBottom: 10,
        x: 100,
        y: 170,
		itemWidth: 400,
	 labelFormatter: function () {
            return '<span>'+this.y+"</span>% " + this.name;
        },
		  itemStyle: {
            color: '#000000',
            fontWeight: 'normal',
			fontSize:'12px',
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
            size: '70%',
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


Highcharts.chart('container-dia2', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
		plotBorderColor:"#000",
        plotShadow: false,
		spacingTop: 0,
		spacingBottom: 0,
				height:'600',
		 width:'600',
    },
	    legend: {
        layout: 'horizontal',
		itemMarginBottom: 10,
        x: 100,
        y: 170,
		itemWidth: 400,
	 labelFormatter: function () {
            return '<span>'+this.y+"</span>% " + this.name;
        },
		  itemStyle: {
            color: '#000000',
            fontWeight: 'normal',
			fontSize:'12px',
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
			<? foreach($arResult["INSTRUMENTS"] as $k=>$item):?>
            { name: '<?=$item['NAME']?>',  y: <?=$item['PROCENT']?>, color: "<?=$colors[$k]?>" },
			<?endforeach?>
        ]
    }]
});
	}	 else if  (screen.width <769) {
		// для планшетов
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

Highcharts.chart('container-dia', {
    chart: {
		 fillColor: '#c3d6e5',
        plotBorderWidth: 0,
		plotBorderColor:"#000",
        plotShadow: false,
		spacingTop: 0,
		spacingBottom: 0,
		height:'600px'
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

Highcharts.chart('container-dia2', {
    chart: {
		 fillColor: '#c3d6e5',
        plotBorderWidth: 0,
		plotBorderColor:"#000",
        plotShadow: false,
		spacingTop: 0,
		spacingBottom: 0,
		height:'500px'
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
			<? foreach($arResult["INSTRUMENTS"] as $k=>$item):?>
            { name: '<?=$item['NAME']?>',  y: <?=$item['PROCENT']?>, color: "<?=$colors[$k]?>" },
			<?endforeach?>
        ]
    }]
});
	
		
		
		
	}
			
		
	}
		</script>