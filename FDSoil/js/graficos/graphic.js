function graphicCombo(idObj){
    var strArray="01%BASICO DE BARRAS|";
    strArray+="02%BARRAS APILADAS|";
    strArray+="03%BARRAS APILADAS CON NEGATIVO|";    
    strArray+="04%BASICO DE COLUMNAS|";
    strArray+="05%COLUMNAS CON VALORES NEGATIVOS|";    
    strArray+="06%COLUMNAS APILADAS|";
    strArray+="07%PORCENTAJE DE COLUMNAS APILADAS|";    
    strArray+="08%BASICO DE LINEAS|";
    strArray+="09%LINEAS CON ETIQUETAS DE DATOS|"; 
    strArray+="10%AREA CON VALORES NEGATIVOS|";
    strArray+="11%AREAS APILADAS|";
    strArray+="12%PORCENTAJE DE AREA|";
    strArray+="13%ZONA CON PUNTOS DESAPARECIDOS|";
    strArray+="14%LOS EJES INVERTIDOS|";
    strArray+="15%AREAS CURVAS";
    llenarCombo(document.getElementById(idObj),strArray.split('|'),'%','null','Seleccione...'); 
}

function graphicComboTots(idObj){
    var strArray="01%BASICO DE BARRAS|";
    strArray+="02%BARRAS APILADAS|";
    strArray+="03%BARRAS APILADAS CON NEGATIVO|";    
    strArray+="04%BASICO DE COLUMNAS|";
    strArray+="05%COLUMNAS CON VALORES NEGATIVOS|";    
    strArray+="06%COLUMNAS APILADAS|";
    strArray+="07%PORCENTAJE DE COLUMNAS APILADAS|";    
    strArray+="16%TORTA|";
    strArray+="17%TORTA CON LEYENDA";    
    llenarCombo(document.getElementById(idObj),strArray.split('|'),'%','null','Seleccione...'); 
}

function selectGraphic(tipoGrafico, categorias, sucesion, titleX, titleY){    
    if (tipoGrafico=='01')
        graphicBasicBar('resultado_grafico', categorias, sucesion, titleX, titleY);
    else if (tipoGrafico=='02')
        graphicStackedBar('resultado_grafico', categorias, sucesion, titleX, titleY);    
    else if (tipoGrafico=='03')
        graphicBarWithNegativeStack('resultado_grafico', categorias, sucesion, titleX, titleY);
    else if (tipoGrafico=='04')
        graphicBasicColumn('resultado_grafico', categorias, sucesion, titleX, titleY);    
    else if (tipoGrafico=='05')
        graphicColumnWithNegativeValues('resultado_grafico', categorias, sucesion, titleX, titleY);
    else if (tipoGrafico=='06')
        graphicStackedColumn('resultado_grafico', categorias, sucesion, titleX, titleY);
    else if (tipoGrafico=='07')
        graphicStackedPercentageColumn('resultado_grafico', categorias, sucesion, titleX, titleY);
    else if (tipoGrafico=='08')
        graphicBasicLine('resultado_grafico', categorias, sucesion, titleX, titleY);
    else if (tipoGrafico=='09')
        graphicLineWithDataLabels('resultado_grafico', categorias, sucesion, titleX, titleY);
    else if (tipoGrafico=='10')
        graphicAreaWithNegativeValues('resultado_grafico', categorias, sucesion, titleX, titleY);
    else if (tipoGrafico=='11')
        graphicStackedArea('resultado_grafico', categorias, sucesion, titleX, titleY);
    else if (tipoGrafico=='12')
        graphicPercentageArea('resultado_grafico', categorias, sucesion, titleX, titleY);
    else if (tipoGrafico=='13')
        graphicAreaWithMissingPoints('resultado_grafico', categorias, sucesion, titleX, titleY);
    else if (tipoGrafico=='14')
        graphicInvertedAxes('resultado_grafico', categorias, sucesion, titleX, titleY);
    else if (tipoGrafico=='15')
        graphicAreaSpline('resultado_grafico', categorias, sucesion, titleX, titleY);
    else if (tipoGrafico=='16')
        graphicPieChart('resultado_grafico', categorias, sucesion, titleX, titleY);
    else if (tipoGrafico=='17')
        graphicPieWithLegend('resultado_grafico', categorias, sucesion, titleX, titleY);
}

function setAttributeOnChangeReDrawGraphic( idCombo, strArray, titleX, titleY){
    document.getElementById(idCombo).setAttribute("onChange","reDrawGraphic(this, '"+strArray+"', '"+titleX+"', '"+titleY+"')");
}

function graphicBasicBar(container, categorias, sucesion, titleX, titleY){
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {//renderTo: 'container',
                renderTo: container,
                type: 'bar'
            },
            title: {
                text: titleX
            },
            subtitle: {
                text: 'Gráfico Básico de Barras'
            },
            xAxis: {
                categories:categorias
                //categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania']
                ,title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: titleY,
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.series.name +': '+ Highcharts.numberFormat(this.y,0);
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            
                        legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },
            
            /*legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -100,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },*/
            credits: {
                enabled: false
            },
            series:sucesion
            //series: [ {name: 'Year 1800',data: [107, 31, 635, 203, 2]}, 
            //          {name: 'Year 1900',data: [133, 156, 947, 408, 6]},
            //          {name: 'Year 2008',data: [973, 914, 4054, 732, 34]}]
        });
    });
    
});
}

function graphicStackedBar(container, categorias, sucesion , titleX, titleY){
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {//renderTo: 'container',
                renderTo: container,
                type: 'bar'
            },
            title: {
                text: titleX
            },
            subtitle: {
                text: 'Gráfico de Barras Apiladas'
            },            
            xAxis: {
                categories:categorias
                //categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
            },
            yAxis: {
                min: 0,
                title: {
                    text: titleY
                }
            },
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.series.name +': '+ Highcharts.numberFormat(this.y,0);
                }
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
                series:sucesion
                //series: [{name: 'John',data: [5, 3, 4, 7, 2]},
                //         {name: 'Jane',data: [2, 2, 3, 2, 1]},
                //         {name: 'Joe',data: [3, 4, 4, 2, 5]}]
        });
    });
    
});
}

function graphicBarWithNegativeStack(container, categorias, sucesion , titleX, titleY){
$(function () {
    var chart,
        categories=categorias;
        //categories = ['0-4', '5-9', '10-14', '15-19','20-24', '25-29', '30-34', '35-39', '40-44','45-49', '50-54', 
        //    '55-59', '60-64', '65-69','70-74', '75-79', '80-84', '85-89', '90-94','95-99', '100 +'];
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {//renderTo: 'container',
                renderTo: container,
                type: 'bar'
            },
            title: {
                text: titleX
            },
            subtitle: {
                text: 'Gráfico de Barras Apiladas con Negativo'
            },
            xAxis: [{
                categories: categories,
                reversed: false
            }, { // mirror axis on right side
                opposite: true,
                reversed: false,
                categories: categories,
                linkedTo: 0
            }],
            yAxis: {
                title: {
                    text: titleY
                },
                labels: {
                    formatter: function(){
                        return (Math.abs(this.value) / 100000000) + 'M ';
                    }
                }//,min: -90000000000, max: 90000000000
            },
    
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
    
            tooltip: {
                formatter: function(){
                    return '<b>'+ this.series.name +', '+ this.point.category +'</b><br/>'+' '+ Highcharts.numberFormat(Math.abs(this.point.y), 0);
                }
            },
            series:sucesion
            /*series: [{
                name: 'Male',
                data: [-1746181, -1884428, -2089758, -2222362, -2537431, -2507081, -2443179,
                    -2664537, -3556505, -3680231, -3143062, -2721122, -2229181, -2227768,
                    -2176300, -1329968, -836804, -354784, -90569, -28367, -3878]
            }, {
                name: 'Female',
                data: [1656154, 1787564, 1981671, 2108575, 2403438, 2366003, 2301402, 2519874,
                    3360596, 3493473, 3050775, 2759560, 2304444, 2426504, 2568938, 1785638,
                    1447162, 1005011, 330870, 130632, 21208]
            }]*/
        });
    });
    
});
}

function graphicBasicColumn(container, categorias, sucesion, titleX, titleY){
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: container,
                type: 'column'
            },
            title: {
                text:titleX
            },
            subtitle: {
                text: 'Gráfico Básico de Columnas'
            },
            xAxis: {/*categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']*/
                categories:categorias
            },
            yAxis: {
                min: 0,
                title: {
                    text: titleY
                }
            },
            
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },            
            /*legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 900,
                y: 30,
                floating: true,
                shadow: true
            },*/
            tooltip: {
                formatter: function() {
                    return ''+
                        this.x +': '+ Highcharts.numberFormat(this.y,0);
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series:sucesion
            /*series: [{name: 'Tokyo',    data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]},
                       {name: 'New York', data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]},
                       {name: 'London',   data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]},
                       {name: 'Berlin',   data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]}]*/            
        });
    });
    
});
}

function graphicColumnWithNegativeValues( container, categorias, sucesion, titleX, titleY){
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: container,
                type: 'column'
            },
            title: {
                text: titleX
            },
            subtitle: {
                text: 'Gráfico de Columnas con Valores Negativos'
            },
            xAxis: {
                //categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
                categories:categorias
            },
            yAxis: {
                title: {
                    text: titleY
                }
            },            
            tooltip: {
                formatter: function() {
                    return ''+
                        this.series.name +': '+ Highcharts.numberFormat(this.y,0);
                }

                
                
            },            
            credits: {
                enabled: false
            },            
            series:sucesion
            /*series: [{name: 'John',data: [5, 3, 4, 7, 2]}, {name: 'Jane',data: [2, -2, -3, 2, 1]}, {name: 'Joe',data: [3, 4, 4, -2, 5]}]*/

            
            
            
            
        });
    });
    
});
}

function graphicStackedColumn(container, categorias, sucesion, titleX, titleY){
   $(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: container,
                type: 'column'
            },
            title: {
                text: titleX
            },
            subtitle: {
                text: 'Gráfico de Columnas Apiladas'
            },
            xAxis: {//categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
                categories: categorias
            },
            yAxis: {
                min: 0,
                title: {
                    text: titleY
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },            
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },            
            /*legend: {
                align: 'right',
                x: -100,
                verticalAlign: 'top',
                y:20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },*/
            tooltip: {
                /*formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;                   
                } */  
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ Highcharts.numberFormat(this.y,0) +' ('+ Math.round(this.percentage) +'%)' +'<br/>'+
                        'Total: '+ this.point.stackTotal;                   
                } 
                
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },//series: [{name: 'John',data: [5, 3, 4, 7, 2]}, {name: 'Jane',data: [2, 2, 3, 2, 1]}, {name: 'Joe',data: [3, 4, 4, 2, 5]}]
            series:sucesion
        });
    });
    
});
}

function graphicStackedPercentageColumn(container, categorias, sucesion, titleX, titleY){
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {//renderTo: 'container',
                renderTo: container,
                type: 'column'
            },
            title: {
                text: titleX
            },
            subtitle: {
                text: 'Gráfico de Porcentaje de Columnas Apiladas'
            },
            xAxis: {//categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
                categories: categorias
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Porcentaje'
                }
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.series.name +': '+ Highcharts.numberFormat(this.y,0) +' ('+ Math.round(this.percentage) +'%)';
                }
            },
            plotOptions: {
                column: {
                    stacking: 'percent'
                }
            },series: sucesion
                //series: [{name: 'John',data: [5, 3, 4, 7, 2]}, 
                //         {name: 'Jane',data: [2, 2, 3, 2, 1]}, 
                //         {name: 'Joe',data: [3, 4, 4, 2, 5]}]
        });
    });
    
});
}



function graphicBasicLine(container, categorias, sucesion, titleX, titleY){
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: container,
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: titleX,
                x: -20 //center
            },
            subtitle: {
                text: 'Gráfico Básico de Líneas',
                x: -20
            },
            xAxis: {
                /*categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']*/
                categories:categorias
            },
            yAxis: {
                title: {
                    text: titleY
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ Highcharts.numberFormat(this.y,0);
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 50,
                borderWidth: 0
            },
            series:sucesion
            /*series: [ {name: 'Tokyo',data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]},
                        {name: 'New York',data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]},
                        {name: 'Berlin',data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]},
                        {name: 'London',data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]}]*/
        });
    });
    
});
}


function graphicLineWithDataLabels(container, categorias, sucesion, titleX, titleY){
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: container,
                type: 'line'
            },
            title: {
                text: titleX
            },
            subtitle: {
                text: 'Gráfico de Líneas con Etiqueta de Datos'
            },
            xAxis: {
                 categories:categorias
                //categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: titleY
                }
            },
            tooltip: {
                enabled: false,
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+ 
                       this.x +': '+ Highcharts.numberFormat(this.y,0);
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series:sucesion
            /*series: [   {name: 'Tokyo', data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]},
                        {name: 'London',data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]}]*/              
        });
    });
    
});


}

function graphicAreaWithNegativeValues(container, categorias, sucesion, titleX, titleY){
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {//renderTo: 'container',
                renderTo: container,
                type: 'area'
            },
            title: {
                text: titleX
            },
            subtitle: {
                text: 'Gráfico de Area con Valores Negativos'
            },
            xAxis: {
                categories:categorias
                //categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
            },
            
            
            
            
            
            
            
            
            
            yAxis: {
                title: {
                    text: titleY
                }
            },
            
            
            
            
            
            
            tooltip: {
                formatter: function() {
                    return ''+
                        this.series.name +': '+ Highcharts.numberFormat(this.y,0);
                }
            },
            credits: {
                enabled: false
            },
            series:sucesion
            //series: [{name: 'John',data: [5, 3, 4, 7, 2]}, {name: 'Jane',data: [2, -2, -3, 2, 1]}, {name: 'Joe', data: [3, 4, 4, -2, 5]}]
        });
    });
    
});
}

function graphicStackedArea(container, categorias, sucesion, titleX, titleY){
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {//renderTo: 'container',
                renderTo: container,
                type: 'area'
            },
            title: {
                text: titleX
            },
            subtitle: {
                text: 'Gráfico de Areas Apiladas'
            },
            xAxis: {
                
                //categories: ['1750', '1800', '1850', '1900', '1950', '1999', '2050'],
                categories:categorias,
                tickmarkPlacement: 'on',
                title: {
                    enabled: false
                }
            },
            yAxis: {
                title: {
                    text: titleY
                },
                labels: {
                    formatter: function() {
                        return this.value / 1000;
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.x +': '+ Highcharts.numberFormat(this.y, 0 );
                }
            },
            plotOptions: {
                area: {
                    stacking: 'normal',
                    lineColor: '#666666',
                    lineWidth: 1,
                    marker: {
                        lineWidth: 1,
                        lineColor: '#666666'
                    }
                }
            },            
            series:sucesion
            //series: [{name: 'Asia',data: [502, 635, 809, 947, 1402, 3634, 5268]}, {name: 'Africa',data: [106, 107, 111, 133, 221, 767, 1766]},
            //         {name: 'Europe',data: [163, 203, 276, 408, 547, 729, 628]}, {name: 'America',data: [18, 31, 54, 156, 339, 818, 1201]},
            //         {name: 'Oceania',data: [2, 2, 2, 6, 13, 30, 46]}]
        });
    });
    
});
}


function graphicPercentageArea(container, categorias, sucesion, titleX, titleY){
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {//renderTo: 'container',
                renderTo: container,
                type: 'area'
            },
            title: {
                text: titleX
            },
            subtitle: {
                text: 'Gráfico de Porcentaje de Area'
            },
            xAxis: {
                categories:categorias,
                //categories: ['1750', '1800', '1850', '1900', '1950', '1999', '2050'],
                tickmarkPlacement: 'on',
                title: {
                    enabled: false
                }
            },
            yAxis: {
                title: {
                    text: 'Porcentaje'
                }
            },
            tooltip: {
                formatter: function() {
                        return ''+
                        this.x +': '+ Highcharts.numberFormat(this.percentage, 1) +'% ('+
                        Highcharts.numberFormat(this.y, 0)+')';
                }
            },
            plotOptions: {
                area: {
                    stacking: 'percent',
                    lineColor: '#ffffff',
                    lineWidth: 1,
                    marker: {
                        lineWidth: 1,
                        lineColor: '#ffffff'
                    }
                }
            },
            series:sucesion
            //series: [ {name: 'Asia',data: [502, 635, 809, 947, 1402, 3634, 5268]}, {name: 'Africa',data: [106, 107, 111, 133, 221, 767, 1766]},
            //          {name: 'Europe',data: [163, 203, 276, 408, 547, 729, 628]}, {name: 'America',data: [18, 31, 54, 156, 339, 818, 1201]},
            //          {name: 'Oceania',data: [2, 2, 2, 6, 13, 30, 46]}]
        });
    });
    
});
}

function graphicAreaWithMissingPoints(container, categorias, sucesion , titleX, titleY){
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {//renderTo: 'container',
                renderTo: container,
                type: 'area',
                spacingBottom: 30
            },
            title: {
                text: titleX
            },
            subtitle: {
                text: 'Gráfico de Zona con Puntos Desaparecidos',
                floating: true,
                align: 'right',
                verticalAlign: 'bottom',
                y: 15
            },
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            }, 
            /*            
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 150,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF'
            },*/
            xAxis: {//categories: ['Apples', 'Pears', 'Oranges', 'Bananas', 'Grapes', 'Plums', 'Strawberries', 'Raspberries']
                categories:categorias
            },
            yAxis: {
                title: {
                    text: titleY
                },
                labels: {
                    formatter: function() {
                        return this.value;
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                    this.x +': '+ Highcharts.numberFormat(this.y,0);
                }
            },
            plotOptions: {
                area: {
                    fillOpacity: 0.5
                }
            },
            credits: {
                enabled: false
            },
            series:sucesion
            //series: [{name: 'John',data: [0, 1, 4, 4, 5, 2, 3, 7]}, {name: 'Jane',data: [1, 0, 3, null, 3, 1, 2, 1]}]            
            });
    });
    
});
}

function graphicInvertedAxes(container, categorias, sucesion, titleX, titleY){
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {//renderTo: 'container',
                renderTo: container,
                type: 'area',
                inverted: true
            },
            title: {
                text: titleX
            },
            subtitle: {
                text: 'Gráfico con los Ejez Invertidos',
                style: {
                    position: 'absolute',
                    right: '0px',
                    bottom: '10px'
                }
            },
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            }, 
            /*legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -150,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF'
            },*/
            xAxis: {//categories: ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']
                categories:categorias
            },
            yAxis: {
                title: {
                    text: titleY
                },
                labels: {
                    formatter: function() {
                        //return this.value;
                         return (Math.abs(this.value) / 100000000) + 'M';
                    }
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                    return ''+
                    this.x +': '+ Highcharts.numberFormat(this.y,0);
                }
            },
            plotOptions: {
                area: {
                    fillOpacity: 0.5
                }
            },
            series:sucesion
            //series: [{name: 'John',data: [3, 4, 3, 5, 4, 10, 12]}, {name: 'Jane',data: [1, 3, 4, 3, 3, 5, 4]}]
        });
    });
    
});
}

function graphicAreaSpline(container, categorias, sucesion , titleX, titleY){
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {//renderTo: 'container',
                renderTo: container,
                type: 'areaspline'
            },
            title: {
                text: titleX
            }, 
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            }, 
            /*legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 150,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF'
            },*/
            xAxis: {
                categories:categorias
                //categories: ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']
                ,
                plotBands: [{ // visualize the weekend
                    from: 4.5,
                    to: 6.5,
                    color: 'rgba(68, 170, 213, .2)'
                }]
            },
            yAxis: {
                title: {
                    text: titleY
                },                
                subtitle: {
                text: 'Gráfico de Areas Curvas'
            }
                
            },
            tooltip: {
                formatter: function() {
                    return ''+
                    this.x +': '+ Highcharts.numberFormat(this.y,0);
                }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.5
                }
            },
            series:sucesion
            //series: [{name: 'John',data: [3, 4, 3, 5, 4, 10, 12]}, {name: 'Jane',data: [1, 3, 4, 3, 3, 5, 4]}]
        });
    });
    
});
}

function graphicPieChart(container, nombre, datos , titleX, titleY){
$(function () {
    var chart;
    $(document).ready(function() {
        
        chart = new Highcharts.Chart({
            chart: {
                renderTo: container,
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: titleX
            },
            subtitle: {
                text: 'Gráfico de Torta'
            },
            tooltip: {                    
        	    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ roundNumber(this.percentage,2) +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: nombre,
                data: datos
                /*data: [
                    ['Firefox',   45.0],
                    ['IE',       26.8],
                    { name: 'Chrome', y: 12.8, sliced: true, selected: true },
                    ['Safari',    8.5],
                    ['Opera',     6.2],
                    ['Others',   0.7]
                ]*/
            }]
        });
    });
    
});
}

function graphicPieWithLegend(container, nombre, datos , titleX, titleY){
$(function () {
    var chart;    
    $(document).ready(function () {
    	
    	// Build the chart
        chart = new Highcharts.Chart({
            chart: {
                renderTo: container,
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: titleX
            },
            subtitle: {
                text: 'Gráfico de Torta con Leyenda'
            },            
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
           
            series: [{type: 'pie',
                      name: nombre,
                      data: datos
                      /*name: 'Browser share',
                      //data: sucesion
                      data: [
                                ['Firefox',   45.0], 
                                ['IE',       26.8],
                                {name: 'Chrome', y: 12.8, sliced: true, selected: true }, 
                                ['Chrome',    12.8],
                                ['Safari',    8.5], 
                                ['Opera',     6.2], 
                                ['Others',   0.7]
                            ]*/
            }]
        });
    });
    
});
}