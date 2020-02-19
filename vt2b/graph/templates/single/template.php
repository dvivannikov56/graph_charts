<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
//Для одиночных графиков
$APPLICATION->SetAdditionalCSS("<?=SITE_TEMPLATE_PATH?>/main.css");
?>

<!--  Бенчмарк графики ,начало -->

<script>
//Создаем объект 'user', который будет содержать информацию Detect.js
//Вызываем detect.parse() с navigator.userAgent в качестве аргумента


      function renderGraphBench() {
        $(function() {
    $.datepicker.regional['ru'] = {
    closeText: 'Закрыть',
    prevText: 'Предыдущий',
    nextText: 'Следующий',
    currentText: 'Сегодня',
	 changeMonth: true,
    changeYear: true,
    monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
    monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
    dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
    dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
    dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
    weekHeader: 'Не',
	  dateFormat: 'dd.mm.yy',
     onSelect: function(dateText) {
        chart.xAxis[0].setExtremes($('input.highcharts-range-selector:eq(0)').datepicker("getDate").getTime()+36000000, 
            $('input.highcharts-range-selector:eq(1)').datepicker("getDate").getTime()+36000000);

var min = chart.yAxis[0].dataMin;
var max = chart.yAxis[0].dataMax;
 var dohod=(max-min).toFixed(2);
  if (dohod>0) dohod="+"+dohod;
  $(".dohod").remove();
  $('<span class="dohod">'+ dohod+' %<span>').appendTo(".highcharts-title");
},
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};
var data = Object.values(<?=$arResult["GRAPH"]?>).map(v => Object.values(v));

var ohlc = [],
            dataLength = data[0][0].length,
            ohlc2 = [],
            i = 0;
        for (i; i < dataLength; i += 1) {
// data[0][0][i] = new Date(data[0][0][i]);

        //data[0][0][i].toLocaleDateString();
            // data[0][0][i] = data[0][0][i].valueOf();
// data[0][0][i] = data[0][0][i].toLocaleDateString();
            ohlc.push([
                data[0][0][i]*1000, // the date
                parseFloat(data[0][1][i]), // open
            ]);
            }
            i = 0;
            var benchLng = data[0][2][0]['date'].length;
            if (data[0][2]) {
                 for (i; i < benchLng; i += 1) {
//data[0]['benchmark'][0]['date'][i] = new Date(data[0]['benchmark'][0]['date'][i] );
    
            //data[0]['benchmark'][0]['date'][i]  = data[0]['benchmark'][0]['date'][i].valueOf();
            ohlc2.push([
                data[0][2][0]['date'][i]*1000 ,// the date
                parseFloat(data[0][2][0]['price'][i]), // open
            ]);
        }
            }

    Highcharts.setOptions({
        lang:{
            rangeSelectorZoom: 'Период: ',
            rangeSelectorFrom:'',
			rangeSelectorTo:'-',

shortMonths:["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"]
        }
		
});
Highcharts.setOptions().colors.push('#dcc291');
Highcharts.setOptions().colors.push('#efe9d9');
Highcharts.setOptions().colors.push('#f5f9fa');
// Create the chart
window.chart = new Highcharts.stockChart('container', {
   chart: {
        marginBottom:10,
		styledMode: true
		
		
    },
    rangeSelector:{
        selected: 5,
        inputDateFormat: '%d.%m.%Y',
        inputEditDateFormat: '%d.%m.%Y',
        buttonTheme: { // styles for the buttons
            fill: 'none',
            stroke: 'none',
            //stroke-width: 0,
            r:  0,
            style: {
                color: '#516b7ac7',
                fontWeight: 500,
                fontSize: '16px',
            },
            states: {
                hover: {
                },
                select: {
                    // fill: '#039',
                    style: {
                        fontWeight: 500,
                        color: '#d4b171'
                    }
                }
                // disabled: { ... }
            }
        },
            labelStyle: {
                color: '#516b7a',
                fontWeight: 500,
                fontSize: '16px'
            },
            inputBoxBorderColor: '#516b7ae6',
            inputBoxWidth: 100,
            inputBoxHeight: 16,
			floating: true,
   			y:0,
            inputStyle: {
                color: '#516b7ae6',
                fontWeight: 500,
                fontSize: '16px'
            },
        buttonSpacing: 35,
         buttonPosition:{
            x: 0,
            y: 0,
            align:'right',

},
        buttons: [{
    text: 'с начала года'

},
        {
    type: 'month',
    count: 1,
    text: '1 мес.'
}, {
    type: 'month',
    count: 3,
    text: '3 мес.'
}, {
    type: 'month',
    count: 6,
    text: '6 мес.'
}, {
    type: 'year',
    count: 1,
    text: '1 год'
},
{
    type: 'year',
    count: 3,
    text: '3 года'
},
{
    type: 'year',
    count: 5,
    text: '5 лет'
},
{
    type: 'all',
    text: 'за весь период'
}]
    },
    colors: ['#d3af6b', '#92d2f1'],
		chart : {
    backgroundColor:'#f5f9fc',
	marginTop: 120,
    renderTo: 'container',
    style: {
        fontFamily: 'OpenSans, Helvetica, Clean, sans-serif'
    }
},
scrollbar:  {
    enabled:false
},
legend:{
    enabled:true,
    itemStyle: {"color": "#516b7ae6", "cursor": "pointer", "fontSize": "16px", "fontWeight": "500", "textOverflow": "ellipsis"},
    itemHoverStyle:{"color": "#ccc"},
},
credits:{
enabled:false
},
    title: {
        text: 'Доходность: ',
		useHTML: true,
        style: { "color": "#516b7a", "fontSize": "14px" ,"font-weight":"300"},
    },
    xAxis: { 
		 ceiling: 1,
        crosshair:{

color:"#516b7ac7",
snap:true,
width:1
},
        gridLineWidth: 1,
        gridLineColor:'#d2d3d5',
        gridLineDashStyle:'Dash',
  lineColor: '#516b7a',
    labels: {
      style: {
        color: '#516b7a'
      }
    }
      },
      yAxis: {
		 opposite: false,
     floor: -100,
        ceiling: 100,
  lineColor: '#516b7a',
  gridLineColor: '#d2d3d5',
  labels: {
	   align: 'left',
     x: 3,
     y: -65,
	  formatter: function() {
       return this.value+"%";
    },	
    style: {
      color: '#516b7a'
    },
 }
},
exporting:{
    enabled:false,
    buttons:{
        contextButton:{
            x:-50,
y:0
        }

    }
},
navigator:{
    outlineColor:'#99a3ad',
    outlineWidth:1,
	height:70,
	 style:  { "stroke-width": "1px" },
    xAxis:{
        gridLineWidth:0,
        labels: {
           align: 'left',
        style: {
            color: '#516b7a'
        },
        x: 3,
        y: -4
    }
    },
    series: {
    type: 'area',
    color:'#c3d6e5',
    fillOpacity: 0.05,
    fillColor: '#c3d6e5',
    dataGrouping: {
        smoothed: true
    },
    lineWidth: 1,
    marker: {
        enabled: false
    },

}
},
 plotOptions: {
        series: {
            lineWidth: 1,
			 radius: 6,
			 symbol: 'square',
			  states: {
                hover: {
                    halo: {
                        size: 1,
                    }

                }
            }
			
			
        }
		
    },

series: [{
                name: 'Стратегия',
                type:'area',
                data: ohlc,
				 pointPlacement: 'on',
					linewidth:1,
                threshold: null,
       fillColor: {
			linearGradient: {
                x1: 0,
                y1: 0,
                x2: 0,
                y2: 1
            },
            stops: [
     						[0, "rgba(255, 241, 216, 0.5)"],
                            [1,  "rgba(255, 255, 255, 0.5)"]
                        ]
                      }
		

            }],

            tooltip: {
                useHTML:true,
                shadow:true,
                borderColor:'#93a5af',
                borderWidth:1,
					borderRadius:15,
    xDateFormat: '%d.%m.%Y',
    backgroundColor: '#ffffff',
    headerFormat:'<span class="date">{point.x:%d.%m.%Y}</span>',
	 pointFormatter: function () {
		    var point=Highcharts.numberFormat(this.y, 2);
			if (point>0) point="+"+point;
            return '<span class="series-name'+this.series.index+'">'+this.series.name+'</span><b class="point'+this.series.index+'">'+point+'%</b>';
        },
	shared: true,
    split: false,
    enabled: true,
    valueDecimals:7

  },
},
 function(chart) {

var user = navigator.userAgent;
let edge = user.match(/Edge/) || 0;
let ie  = user.match(/Trident/) || 0;
let fx = user.match(/rv/) || 0;
if (edge != 0 || ie != 0 ) {
 //Для range-selector
 var txt = $('g.highcharts-range-selector-group > g.highcharts-input-group > g:nth-child(2) > text');
  $('g.highcharts-range-selector-group > g.highcharts-input-group > g:nth-child(2)')
  .html('<rect xmlns="http://www.w3.org/2000/svg" class="highcharts-label-box" fill="none" stroke="#d3af6b" stroke-width="1" x="14" y="20" width="7%" height="0.2%"></rect>');
$('g.highcharts-range-selector-group > g.highcharts-input-group > g:nth-child(2)').append(txt);

 var txt2 = $('g.highcharts-range-selector-group > g.highcharts-input-group > g:nth-child(4) > text');
  $('g.highcharts-range-selector-group > g.highcharts-input-group > g:nth-child(4)')
  .html('<rect xmlns="http://www.w3.org/2000/svg" class="highcharts-label-box" fill="none" stroke="#d3af6b" stroke-width="1" x="14" y="20" width="7%" height="0.2%"></rect>');
$('g.highcharts-range-selector-group > g.highcharts-input-group > g:nth-child(4)').append(txt2);

// Для периодов

var text = $('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(2) > text');
var text2 = $('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(3) > text');
var text3 = $('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(4) > text');
var text4 = $('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(5) > text');
var text5 = $('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(6) > text');
var text6 = $('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(7) > text');
var text7 = $('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(8) > text');
var text8 = $('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(9) > text');

$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(2)').html('<g class = "highcharts-button-box" fill="none" stroke="black" stroke-width="4"><path stroke-dasharray="5,5" d="M 20 20 l 110 0" /></g>');
$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(3)').html('<g class = "highcharts-button-box" fill="none" stroke="black" stroke-width="4"><path stroke-dasharray="5,5" d="M 20 20 l 50 0" /></g>');
$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(4)').html('<g class = "highcharts-button-box" fill="none" stroke="black" stroke-width="4"><path stroke-dasharray="5,5" d="M 20 20 l 50 0" /></g>');
$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(5)').html('<g class = "highcharts-button-box" fill="none" stroke="black" stroke-width="4"><path stroke-dasharray="5,5" d="M 20 20 l 50 0" /></g>');
$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(6)').html('<g class = "highcharts-button-box" fill="none" stroke="black" stroke-width="4"><path stroke-dasharray="5,5" d="M 20 20 l 42 0" /></g>');
$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(7)').html('<g class = "highcharts-button-box" fill="none" stroke="black" stroke-width="4"><path stroke-dasharray="5,5" d="M 20 20 l 50 0" /></g>');
$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(8)').html('<g class = "highcharts-button-box" fill="none" stroke="black" stroke-width="4"><path stroke-dasharray="5,5" d="M 20 20 l 41 0" /></g>');
$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(9)').html('<g class = "highcharts-button-box" fill="none" stroke="black" stroke-width="4"><path stroke-dasharray="5,5" d="M 80 20 l 120 0" /></g>');


$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(2)').append(text);
$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(3)').append(text2);
$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(4)').append(text3);
$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(5)').append(text4);
$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(6)').append(text5);
$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(7)').append(text6);
$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(8)').append(text7);
$('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(9)').append(text8);
//('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(1n)');
// var sel_but = $('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(1n)');

// $(sel_but).each(function(indx, element){
//   element[indx].append(text);
// })
// console.log($('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(1n)'));
}

	 
	 //------------------------скрыть не нужные даты начало------------------------------------

var enabled_date = [];
// if (edge.length == 1 || ie.length == 1) {
// for (var i = 0; i < ohlc2.length; i++) {
//   enabled_date[i] = ohlc2[i][0];
// }
// for (var i = 0; i < ohlc2.length; i++) {
// 	enabled_date[i] = new Date(enabled_date[i]);
// 	enabled_date[i] = enabled_date[i].toLocaleDateString();
// 	//enabled_date[i] = enabled_date[i].replace(/[.]/g, "-");
// }
// var disabledDates = enabled_date;
// } else 
// {
	for (var i = 0; i < ohlc2.length; i++) {
		enabled_date[i] = ohlc2[i][0];
	}
	for (var i = 0; i < ohlc2.length; i++) {
		enabled_date[i] = new Date(enabled_date[i]);
		enabled_date[i] = enabled_date[i].toLocaleDateString();
	}	
var disabledDates = enabled_date;
	 // }
//var disabledDates = enabled_date;
//------------------------скрыть не нужные даты конец------------------------------------


//---------------Изменить доходность начало---------------------------------------------------------------------------
var min = chart.yAxis[0].dataMin;
var max = chart.yAxis[0].dataMax;
 var dohod=(max-min).toFixed(2);
  if (dohod>0) dohod="+"+dohod;
  $(".dohod").remove();
  $('<span class="dohod">'+ dohod+' %<span>').appendTo(".highcharts-title");
 //alert(dohod);
//---------------Конец Изменить доходность---------------------------------------------------------------------------

if (edge == 0 || ie.length == 0) {
$('input.highcharts-range-selector:eq(0)').datepicker({
    beforeShowDay: function(date){
        var string = $.datepicker.formatDate('dd.mm.yy', date);
        return [ disabledDates.indexOf(string) !== -1 ]
    }
});

$('input.highcharts-range-selector:eq(1)').datepicker({
    beforeShowDay: function(date){
        var string = $.datepicker.formatDate('dd.mm.yy', date);
        return [ disabledDates.indexOf(string) !== -1 ]
    }
});
}
//------------------------скрыть не нужные даты конец------------------------------------

setTimeout(function() {
    $('input.highcharts-range-selector', $('#' + chart.options.chart.renderTo)).datepicker()
}, 0)
	 $('.period').click(function(e) {
		 e.preventDefault();
		 $(this).next('ul').slideToggle();
		 $(this).toggleClass('trio');

	 });
	 if (edge.length == 1 || ie.length == 1) {
	 	var last_date = enabled_date.pop();
	 	var last_date = last_date.replace(/[.]/g, "-");
	 	last_date = new Date(last_date);
	 	var year=last_date.getFullYear(new Date(last_date));
	 } else if (fx.length == 1){
	 	var last_date = enabled_date.pop();
        var last_date = last_date.replace(/[.]/g, "/");
        last_date = new Date(last_date);
        var year=last_date.getFullYear(new Date(last_date));
	 } else {
      var last_date = new Date(enabled_date.pop());
        var year=last_date.getFullYear(new Date(last_date));  
     }
	 	 //---------------Изменить  начало года---------------------------------------------------------------------------
	   $('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(2) > text').click(function(e) {

     $(this).css('font-weight','600');
      $(this).css('fill','#d3af6b');
    });
	for (var i = 3; i < 15; i++) {
	 $('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child('+i+')').click(function(e) {
		        $('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(2) > text').css('font-weight','300');
       $('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(2) > text').css('fill','#516b7ac7');


	});
	}
	
    $('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g:nth-child(2)').click(function(e) {
			 e.preventDefault();
			var year=last_date.getFullYear(last_date);
					chart.xAxis[0].options.startOnTick = true;
       chart.xAxis[0].options.endOnTick = true;
			chart.xAxis[0].setExtremes(Date.UTC(year, 0, 01),last_date);

  });
    $('g.highcharts-range-selector-group > g.highcharts-range-selector-buttons > g').click(function(e) {
	 			var min = chart.yAxis[0].dataMin;
var max = chart.yAxis[0].dataMax;
 var dohod=(max-min).toFixed(2);
  if (dohod>0) dohod="+"+dohod;
  $(".dohod").remove();
  $('<span class="dohod">'+ dohod+' %<span>').appendTo(".highcharts-title");

	});
 $('.periods > ul > li > a').click(function(e) {
	 			var min = chart.yAxis[0].dataMin;
var max = chart.yAxis[0].dataMax;
 var dohod=(max-min).toFixed(2);
  if (dohod>0) dohod="+"+dohod;
  $(".dohod").remove();
  $('<span class="dohod">'+ dohod+' %<span>').appendTo(".highcharts-title");

	});

//---------------Конец начало года---------------------------------------------------------------------------

   if (data[0][2]) {
    chart.addSeries({ 
  type:'area',
  linewidth:1,                      
    name: "<?=$arResult['BENCHMARKS'][0]?>",
    data: ohlc2,
  pointFormat: '<span class="bench">{series.name}:</span><br><span class="bench-point">{point.y:.2f}</span><br/>',
   threshold: 7,
     fillColor: {
           
            stops: [
                [0, Highcharts.getOptions().colors[0]],
                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
            ]
        },
    color:'#92d2f1'
  
}, false);
}

	    $('#begin-year').click(function(e) {
			e.preventDefault();
					$("li").find('a').not(this).removeClass('active');
		
			$(this).addClass('active');
			e.preventDefault();
		
		
						 chart.xAxis[0].options.startOnTick = false;
       chart.xAxis[0].options.endOnTick = false;
	   
			chart.xAxis[0].setExtremes(
		        Date.UTC(year, 0, 01),
      		last_date
		);
		var min = chart.yAxis[0].dataMin;
var max = chart.yAxis[0].dataMax;
 var bdohod=(max-min).toFixed(2);
 var dohod=((max-min)/min*100).toFixed(2);
			$(".dohod").remove();
  $('<span class="dohod">'+ bdohod+' руб ('+dohod+'%)<span>').appendTo(".highcharts-title");
		  });
	    $('#month1').click(function(e) {
			e.preventDefault();
			$("li").find('a').not(this).removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
			 chart.xAxis[0].options.startOnTick = false;
       chart.xAxis[0].options.endOnTick = false;
			chart.xAxis[0].setExtremes(
      		Date.UTC(year, last_date.getMonth()-1, last_date.getDate()),
      last_date
			);

			
		  });	
	    $('#month3').click(function(e) {
			e.preventDefault();
			$("li").find('a').not(this).removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
			 chart.xAxis[0].options.startOnTick = false;
       chart.xAxis[0].options.endOnTick = false;
			chart.xAxis[0].setExtremes(
      		Date.UTC(year, last_date.getMonth()-3, last_date.getDate()),
      last_date
			);
		
		  });		
    $('#month6').click(function(e) {
			e.preventDefault();
			$("li").find('a').not(this).removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
			 chart.xAxis[0].options.startOnTick = false;
       chart.xAxis[0].options.endOnTick = false;
			chart.xAxis[0].setExtremes(
      		Date.UTC(year, last_date.getMonth()-6, last_date.getDate()),
      last_date
			);
				
		  });	
    $('#year1').click(function(e) {
			e.preventDefault();
			$("li").find('a').not(this).removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
			 chart.xAxis[0].options.startOnTick = false;
       chart.xAxis[0].options.endOnTick = false;
			chart.xAxis[0].setExtremes(
      		Date.UTC(year-1, last_date.getMonth(), last_date.getDate()),
      last_date
			);
		  });
    $('#year3').click(function(e) {
			e.preventDefault();
			$("li").find('a').not(this).removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
			 chart.xAxis[0].options.startOnTick = false;
       chart.xAxis[0].options.endOnTick = false;
			chart.xAxis[0].setExtremes(
      		Date.UTC(year-3, last_date.getMonth(), last_date.getDate()),
      last_date
			);
	
		  });
   $('#year5').click(function(e) {
			e.preventDefault();
			$("li").find('a').not(this).removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
			 chart.xAxis[0].options.startOnTick = false;
       chart.xAxis[0].options.endOnTick = false;
			chart.xAxis[0].setExtremes(
      		Date.UTC(year-5, last_date.getMonth(), last_date.getDate()),
      last_date
			);


		  });
		  
		   $('#container').click(function(e) {
			   $('.periods ul').hide();
		   });
		  			  			  			  	  	  
// apply the date pickers
setTimeout(function() {
    $('input.highcharts-range-selector', $('#' + chart.options.chart.renderTo)).datepicker()
}, 0);

var buttons = chart.rangeSelector.buttons;

  buttons.forEach(btn => {
    let value = parseFloat(btn.text.element.attributes.x.value),
      labelWidth = btn.text.element.getBBox().width;

    btn.text.element.attributes.x.value = 20;
  });
  let value = parseFloat(chart.rangeSelector.buttons[7].text.element.attributes.x.value);
chart.rangeSelector.buttons[7].text.element.attributes.x.value = 80;

    document.querySelector('g.highcharts-legend-item.highcharts-area-series').insertAdjacentHTML('afterend','<g class="highcharts-button-bench" id="bench" data-z-index="7" style="[object Object]" transform="translate(670,0)"><svg x="-90" y="0" width="32" height="32" viewBox="-5 -5 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path id="svpath" d="M8.00415 28.1355H23.9958C26.7644 28.1355 28.1355 26.7644 28.1355 24.0486V7.95142C28.1355 5.2356 26.7644 3.8645 23.9958 3.8645H8.00415C5.24878 3.8645 3.8645 5.22241 3.8645 7.95142V24.0486C3.8645 26.7776 5.24878 28.1355 8.00415 28.1355ZM8.03052 26.0129C6.71216 26.0129 5.98706 25.3142 5.98706 23.9431V8.05688C5.98706 6.68579 6.71216 5.98706 8.03052 5.98706H23.9695C25.2747 5.98706 26.0129 6.68579 26.0129 8.05688V23.9431C26.0129 25.3142 25.2747 26.0129 23.9695 26.0129H8.03052ZM14.3586 22.572C14.7937 22.572 15.1497 22.3611 15.4265 21.9392L21.926 11.6956C22.0974 11.4451 22.2556 11.1418 22.2556 10.8518C22.2556 10.2454 21.7151 9.86304 21.1614 9.86304C20.8186 9.86304 20.489 10.074 20.2517 10.4695L14.2927 20.0012L11.2341 16.033C10.9309 15.6506 10.6277 15.5056 10.2585 15.5056C9.69165 15.5056 9.23022 15.967 9.23022 16.5603C9.23022 16.8503 9.34888 17.1404 9.53345 17.3909L13.2249 21.9524C13.5808 22.3743 13.9104 22.572 14.3586 22.572Z" fill="#dcc18f"/></svg><rect fill="#f5f9fc" x="0" y="0" width="32" height="22" rx="2" ry="2"></rect><text x="-50" data-z-index="2"  class="bench" y="21">Сравнить </text><text x="-50" data-z-index="2"  class="benchs" y="21">с бенчмарком</text></g>');
  document.querySelector('g.highcharts-legend-item.highcharts-area-series').insertAdjacentHTML('afterend','<g class="highcharts-button-print" id="print" data-z-index="7" style="[object Object]" transform="translate(500,0)"><svg  x="-80" y="5" width="20" height="20" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.02466 26.2502H6.42212V27.7136C6.42212 29.467 7.26587 30.2317 8.94019 30.2317H23.0598C24.7209 30.2317 25.5779 29.467 25.5779 27.7136V26.2502H26.9622C29.533 26.2502 30.8909 24.9583 30.8909 22.3875V10.0476C30.8909 7.48999 29.533 6.18481 26.9622 6.18481H25.6702V5.48608C25.6702 2.91528 24.3782 1.76831 21.9392 1.76831H10.0608C7.74048 1.76831 6.32983 2.91528 6.32983 5.48608V6.18481H5.02466C2.59888 6.18481 1.10913 7.48999 1.10913 10.0476V22.3875C1.10913 24.9583 2.46704 26.2502 5.02466 26.2502ZM8.37329 5.34106C8.37329 4.23364 8.927 3.69312 10.0344 3.69312H21.9656C23.0598 3.69312 23.6267 4.23364 23.6267 5.34106V6.18481H8.37329V5.34106ZM4.99829 24.2727C3.83813 24.2727 3.23169 23.6531 3.23169 22.4929V9.94214C3.23169 8.78198 3.83813 8.16235 4.99829 8.16235H26.9885C28.1619 8.16235 28.7683 8.78198 28.7683 9.94214V22.4929C28.7683 23.6531 28.1619 24.2727 26.9885 24.2727H25.5779V16.3625C25.5779 14.6091 24.7209 13.8445 23.0598 13.8445H8.94019C7.34497 13.8445 6.42212 14.6091 6.42212 16.3625V24.2727H4.99829ZM9.59937 28.2542C8.88745 28.2542 8.54468 27.9114 8.54468 27.1863V16.8767C8.54468 16.1648 8.88745 15.8352 9.59937 15.8352H22.4138C23.1125 15.8352 23.4553 16.1648 23.4553 16.8767V27.1863C23.4553 27.9114 23.1125 28.2542 22.4138 28.2542H9.59937ZM11.4319 20.5813H20.5945C21.0559 20.5813 21.4119 20.2253 21.4119 19.7507C21.4119 19.3025 21.0559 18.9597 20.5945 18.9597H11.4319C10.9441 18.9597 10.6013 19.3025 10.6013 19.7507C10.6013 20.2253 10.9441 20.5813 11.4319 20.5813ZM11.4319 25.1824H20.5945C21.0559 25.1824 21.4119 24.8264 21.4119 24.3782C21.4119 23.9167 21.0559 23.5608 20.5945 23.5608H11.4319C10.9441 23.5608 10.6013 23.9167 10.6013 24.3782C10.6013 24.8264 10.9441 25.1824 11.4319 25.1824Z" fill="#cda254"/></svg><rect fill="#f5f9fc" x="0" y="0" width="32" height="22" rx="2" ry="2"></rect><text x="-50" data-z-index="1" class="print" y="21">Распечатать</text></g>');
   document.querySelector('g.highcharts-legend-item.highcharts-area-series').insertAdjacentHTML('afterend','<g class="highcharts-button-xls" id="exp_xls" data-z-index="7" style="[object Object]" transform="translate(610,0)"><svg x="-112" y="5" width="20" height="20" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.09448 25.2615C6.42212 25.2615 5.96069 25.7493 5.96069 26.4348C5.96069 27.1204 6.42212 27.6213 7.09448 27.6213H24.8792C25.5647 27.6213 26.0393 27.1204 26.0393 26.4348C26.0393 25.7493 25.5647 25.2615 24.8792 25.2615H16.2703C16.4944 25.1956 16.7053 25.0769 16.8899 24.8792L25.6042 16.1516C25.8679 15.8748 25.9998 15.5847 25.9998 15.2683C25.9998 14.6091 25.512 14.1082 24.8528 14.1082C24.5364 14.1082 24.22 14.2268 24.009 14.4377L21.0559 17.3513L17.0876 21.6887L17.1799 18.8674V5.552C17.1799 4.86646 16.6921 4.37866 16.0066 4.37866C15.3079 4.37866 14.8201 4.86646 14.8201 5.552V18.8674L14.9255 21.7019L10.9573 17.3513L8.00415 14.4377C7.78003 14.2268 7.47681 14.1082 7.1604 14.1082C6.48804 14.1082 6.01343 14.6091 6.01343 15.2683C6.01343 15.5847 6.14526 15.8748 6.39575 16.1516L15.1233 24.8792C15.2947 25.0769 15.5056 25.1956 15.7297 25.2615H7.09448Z" fill="#cda254"/></svg><rect fill="#f5f9fc"  x="0" y="0" width="32" height="22" rx="2" ry="2"></rect><text x="-90" data-z-index="1" class="xls" y="21">Загрузить в xls</text></g>');
      document.querySelector('g.highcharts-input-group').insertAdjacentHTML('beforeBegin','<g class="highcharts-button-icon" id="icon" data-z-index="7" style="[object Object]""><svg width="20" height="20" viewBox="0 0 32 32" fill="none" mlns="http://www.w3.org/2000/svg"><path d="M7.0022 28.1355H25.011C27.7664 28.1355 29.1375 26.7644 29.1375 24.0486V7.95142C29.1375 5.2356 27.7664 3.8645 25.011 3.8645H7.0022C4.24683 3.8645 2.86255 5.22241 2.86255 7.95142V24.0486C2.86255 26.7776 4.24683 28.1355 7.0022 28.1355ZM6.80444 26.0129C5.6311 26.0129 4.98511 25.3933 4.98511 24.1672V11.7351C4.98511 10.5222 5.6311 9.8894 6.80444 9.8894H25.1824C26.3557 9.8894 27.0149 10.5222 27.0149 11.7351V24.1672C27.0149 25.3933 26.3557 26.0129 25.1824 26.0129H6.80444ZM13.4226 14.6223H14.2004C14.6619 14.6223 14.8201 14.4905 14.8201 14.0291V13.2512C14.8201 12.7898 14.6619 12.6448 14.2004 12.6448H13.4226C12.9612 12.6448 12.803 12.7898 12.803 13.2512V14.0291C12.803 14.4905 12.9612 14.6223 13.4226 14.6223ZM17.8127 14.6223H18.5774C19.0388 14.6223 19.197 14.4905 19.197 14.0291V13.2512C19.197 12.7898 19.0388 12.6448 18.5774 12.6448H17.8127C17.3381 12.6448 17.1931 12.7898 17.1931 13.2512V14.0291C17.1931 14.4905 17.3381 14.6223 17.8127 14.6223ZM22.1897 14.6223H22.9675C23.429 14.6223 23.574 14.4905 23.574 14.0291V13.2512C23.574 12.7898 23.429 12.6448 22.9675 12.6448H22.1897C21.7283 12.6448 21.5701 12.7898 21.5701 13.2512V14.0291C21.5701 14.4905 21.7283 14.6223 22.1897 14.6223ZM9.04565 18.9333H9.82349C10.2849 18.9333 10.4299 18.8015 10.4299 18.3401V17.5623C10.4299 17.1008 10.2849 16.969 9.82349 16.969H9.04565C8.58423 16.969 8.42603 17.1008 8.42603 17.5623V18.3401C8.42603 18.8015 8.58423 18.9333 9.04565 18.9333ZM13.4226 18.9333H14.2004C14.6619 18.9333 14.8201 18.8015 14.8201 18.3401V17.5623C14.8201 17.1008 14.6619 16.969 14.2004 16.969H13.4226C12.9612 16.969 12.803 17.1008 12.803 17.5623V18.3401C12.803 18.8015 12.9612 18.9333 13.4226 18.9333ZM17.8127 18.9333H18.5774C19.0388 18.9333 19.197 18.8015 19.197 18.3401V17.5623C19.197 17.1008 19.0388 16.969 18.5774 16.969H17.8127C17.3381 16.969 17.1931 17.1008 17.1931 17.5623V18.3401C17.1931 18.8015 17.3381 18.9333 17.8127 18.9333ZM22.1897 18.9333H22.9675C23.429 18.9333 23.574 18.8015 23.574 18.3401V17.5623C23.574 17.1008 23.429 16.969 22.9675 16.969H22.1897C21.7283 16.969 21.5701 17.1008 21.5701 17.5623V18.3401C21.5701 18.8015 21.7283 18.9333 22.1897 18.9333ZM9.04565 23.2576H9.82349C10.2849 23.2576 10.4299 23.1125 10.4299 22.6511V21.8733C10.4299 21.4119 10.2849 21.28 9.82349 21.28H9.04565C8.58423 21.28 8.42603 21.4119 8.42603 21.8733V22.6511C8.42603 23.1125 8.58423 23.2576 9.04565 23.2576ZM13.4226 23.2576H14.2004C14.6619 23.2576 14.8201 23.1125 14.8201 22.6511V21.8733C14.8201 21.4119 14.6619 21.28 14.2004 21.28H13.4226C12.9612 21.28 12.803 21.4119 12.803 21.8733V22.6511C12.803 23.1125 12.9612 23.2576 13.4226 23.2576ZM17.8127 23.2576H18.5774C19.0388 23.2576 19.197 23.1125 19.197 22.6511V21.8733C19.197 21.4119 19.0388 21.28 18.5774 21.28H17.8127C17.3381 21.28 17.1931 21.4119 17.1931 21.8733V22.6511C17.1931 23.1125 17.3381 23.2576 17.8127 23.2576Z" fill="#cda254"/></svg><g>');

  chart.redraw();
  var legend = chart.legend; 
  legend.group.translate(17,457);
  var print = document.querySelector("#print");
  var xls_export = document.querySelector("#exp_xls");
  print.setAttribute("transform", "translate(925,0)");
  xls_export.setAttribute("transform", "translate(1105,0)");
  chart.series[1].hide();
  $('#bench').click(function () {
    if (chart.series[1].visible == false) {
        chart.series[1].show();
} else {
    chart.series[1].hide(); 
}
 if( $('#svpath').css('fill') == "rgb(119, 198, 237)"){
  	$('#svpath').css({ fill: "#dcc18f" });
  }else{
  	$('#svpath').css({ fill: "#77c6ed" });
  }    

    });
	$('.highcharts-legend-item:eq(1)').click(function () {
		  if( $('#svpath').css('fill') == "rgb(119, 198, 237)"){
  	$('#svpath').css({ fill: "#dcc18f" });
  }else{
  	$('#svpath').css({ fill: "#77c6ed" });
  }    

     });
// 	$('input.highcharts-range-selector').change(function() {
// 			var extreme = this.yAxis[0].getExtremes();
// // console.log(extreme.dataMin + ' ' + extreme.dataMax);
// });
	
    // Печать

    $('#print').click(function () {
      const minP = $('g.highcharts-range-selector-group > g.highcharts-input-group > g:nth-child(2) > text').text();
      const maxP = $('g.highcharts-range-selector-group > g.highcharts-input-group > g:nth-child(4) > text').text();

      // minP = ("" + (new Date(minP)).toISOString())
      //   this.replace(/^([^T]+)T(.+)$/,'$1')
      //   .replace(/^(\d+)-(\d+)-(\d+)$/,'$3.$2.$1');
      // maxP = ("" + (new Date(maxP)).toISOString())
      //   .replace(/^([^T]+)T(.+)$/,'$1')
      //   .replace(/^(\d+)-(\d+)-(\d+)$/,'$3.$2.$1');
    	// var originalContents = document.body.innerHTML;
        $('.highcharts-legend').hide();
        $('.highcharts-range-selector-group').hide();
        // $('.highcharts-title').hide();
        $('.highcharts-title').css('left','320px');
		$('.periods').hide();
       $(".cnt_one").before('<img src="/local/templates/peramo/sites/default/files/logo.png" width="200"><br><p style="font-size:25px;color:#ddd;text-align:center;">Динамика доходности пая с ' + minP + ' по ' + maxP +'</p>');
         $(".cnt_one").after('<p class="print_text" style="padding-top:25px;text-align:justify;font-size: 12px;line-height: 20px;"><?=$arResult['PRINT_TEXT']?></p>');
        $('.graph_background').css('height', '1020px');
        var divToPrint=document.querySelector(".single");
    newWin= window.open(' ');
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
   window.location.reload();
  //document.body.innerHTML = originalContents;
//   $.ajax({  
//     url: "index.php",  
//     cache: false,  
//     success: function(html){  
//         $("#body").html(html);  
//     }
// }); 
//   return false; 
  //        var originalContents = document.body.innerHTML;
  // // newWin= window.open('', 'my div', 'height=400,width=600');
  //  //newWin.document.write(divToPrint.outerHTML);
  //  windows.print();
  //  windows.close();
  //   document.body.innerHTML = originalContents;
   // window.location.reload();
        //chart.print();
    });

     // Export TO XLS ??
    $('#exp_xls').click(function (e) {
		 chart.setTitle({text: "Доходность"});
        chart.downloadXLS();
       setTimeout(function (){
        //.e.preventDefault();
        chart.setTitle({text: 'Доходность:<br>'});
        $('<span class="dohod">'+dohod +' руб ('+bdohod.toFixed(2) +'%)<span>').appendTo(".highcharts-title");
         chart.redraw(), 3000});
    });
    });
// Set the datepicker's date format
$.datepicker.setDefaults(
    $.datepicker.regional['ru']);
});
}
</script>


<?if ($arResult["BENCHMARK"] == "Y") {?>
<script>
    document.addEventListener("DOMContentLoaded", () => {
    renderGraphBench();
  });
    </script>
<?}?>
<div class="pr single">

    <div id="container" class="graph-container cnt_one"></div>
    <div class="periods">
    <a href="#" class="period">Период</a>
    <ul>
        <li><a id="begin-year" href="#">С начала года</a></li>
        <li><a id="month1" href="#">1 мес</a></li>
        <li><a id="month3" href="#">3 мес</a></li>
        <li><a id="month6" href="#">6 мес</a></li>
        <li><a id="year1" href="#">1 год</a></li>
        <li><a id="year3" href="#">3 года</a></li>
        <li><a id="year5" href="#">5 лет</a></li>
    </ul>
	</div>
  
</div>
   <div class="dinamika">
                     	Приведенная динамика доходности стратегии динамику стоимости совокупного портфеля всех клиентов,  доверительное управление которыми осуществляется согласно 
                        данной стратегии, в связи с чем она может отличаться от динамики доходности портфеля каждого конкретного клиента. Расчет доходности произведен с учетом всех расходов, 
                        включая вознаграждение УК и налогов.
                     </div>  
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<!-- 2. Подключим jQuery UI -->

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

