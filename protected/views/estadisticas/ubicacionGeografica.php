<style type="text/css">
.huge {
    font-size: 40px;
}
</style>
<section class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $titulo1 ?></h1>
    </div>
    <div class="pull-right">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'Atras',
            'icon' => 'glyphicon glyphicon-chevron-left',
            'size' => 'btn-lg',
            'context' => 'info',
            'buttonType' => 'link',
            'htmlOptions' => array(
                'onClick' => 'goBack()'
            )
        ));
        ?>
    </div>
</section>

<?php
if($br)
    $marginTop=225;
else
    $marginTop=200;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/validacion.js');
$this->Widget('ext.highcharts.HighchartsWidget', array(
    'options' => array(
       
        'title' => array(
             //'text' => $titulo,
             'text' => '',
            /*'style' => array(
                'color' => 'red',
                'background' => 'url(/var/www/hola.png)',
                'backgroundImage' => 'url(/var/www/hola.png)'
            )*/
            //'floating'=> true
            //'margin'=>1
            //'y'=>150
            //''=>''
            //''=>''
            //''=>''
        ),
        //'subtitle' => array('text' => "<b>".$titulo." al ".$subtitulo."</b>", 'style'=>array('font-size'=>'24px','height'=>'100px'),'y'=>150),
        'subtitle' => array('text' => $subtitulo, 'style'=>array('font-size'=>'24px','height'=>'100px')),
            'theme' => 'white',
        'chart' => array(
            'type' => 'bar',
            'height' => 700,
            //'plotBackgroundImage' => 'https://www.highcharts.com/samples/graphics/skies.jpg'
            //'plotBackgroundImage' => 'http://localhost/.png',
            //'backgroundColor' => '#000'
            //'spacingTop' => 200,
            'marginTop' => $marginTop,
            //'className' => 'logo-chart'
            'plotBackgroundColor'=>array(
                'linearGradient'=> array(0,0,500,500),
                'stops'=>array(
                    array(0,'rgb(70, 154, 112)'),
                    //array(1,'rgb(213, 245, 229)'),
                    array(1,'rgb(220, 232, 226)'),
                )
            )
            ),
        'xAxis' => array(
            'categories' => $categorias,
        /* 'labels' => array ('formatter' =>
          'js:function() { return "--<a href=\'"+this.value+"hola.com\' ><b>"+this.value+"</b></a>--%"}',
          'useHTML'  => true,
          ), */
        ),
        'tooltip' => array(
            'formatter' => 'js:function(){ return "El valor para <b>" + this.x + "</b> es <b>" + this.y + "</b>, que representa el <b>" + Highcharts.numberFormat((this.y*100/1000), 2) + "%</b> del <b>"+ this.series.name+"</b>"; }'
        ),
        'yAxis' => array(
            'title' => array('text' => "Total: $total")
        ),
        'series' => array(
            array('name' => "Total: $total", 'data' => $series),
        ),
        
        'exporting' => array(
            
            'filename'=>'Reporte'
        ),
        
        'plotOptions' => array(
            'bar' => array('dataLabels' => array('enabled' => true, 'style' => array('fontSize' => '14px'))),
            'series' => array('cursor' => 'pointer',
                'point' => $event
            )
        ),
        
        'credits' => array('enabled' => true, 'text' => 'Generado por Sistema de Protocolización en fecha: ' . date("d/m/Y h:m A")),
        
//        'setTitle'=> array(
//            'useHTML' => true,
//            'text' => "<img src='http://res-1.cloudinary.com/cloudinary/image/asset/dpr_2.0/logo-e0df892053afd966cc0bfe047ba93ca4.png' height='50px' width='100px' alt='' />"
//        ),
    ),
    'scripts' => array(
    'highcharts-more',   // enables supplementary chart types (gauge, arearange, columnrange, etc.)
    'modules/exporting', // adds Exporting button/menu to chart
    'modules/offline-exporting', 
    //'themes/grid'        // applies global 'grid' theme to all charts
 ),
'options2' => 'setTitle({
            useHTML: true,
            text:  "<img src=\''.Yii::app()->baseUrl.'/images/cintillo.jpg\' class=\'cintillo_responsive\' /><br><center><h3>'.$titulo.'</h3></center>"
            //text:  "<img src=\''.Yii::app()->baseUrl.'/images/cintillo.jpg\' style=\'width:1500px;height:100px;\' /><br><center><h3>'.$titulo.'</h3></center>"
            //text:  "<img src=\''.Yii::app()->baseUrl.'/images/cintillo.jpg\' height=\'50px\' width=\'100%\' alt=\'\' />"
            //text:  "<img src=\'http://res-1.cloudinary.com/cloudinary/image/asset/dpr_2.0/logo-e0df892053afd966cc0bfe047ba93ca4.png\' height=\'50px\' width=\'100px\' alt=\'\' />"
            })'
    
));
?>

<script type="text/javascript">

</script>

<div class="form-actions">
    <div class="pull-left">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            //'type'=>'primary',
            'label' => 'Regresar al Indice de Estadisticas',
            'icon' => 'glyphicon glyphicon-chevron-left',
            'size' => 'large',
            'context' => 'danger',
            'buttonType' => 'link',
            'url' => CHtml::normalizeUrl(array('index')),
        ));
        ?>
        
        <?php
        /*if(isset($urlPdf))
        {
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'Generar PDF',
                'icon' => 'glyphicon glyphicon-file',
                'size' => 'large',
                'context' => 'info',
                'buttonType' => 'link',
                //'url' => Yii::app()->createUrl('estadisticas/beneficiariosUbicacionGeograficaPdf'),
                //'url' => Yii::app()->createUrl('estadisticas/beneficiariosUbicacionGeograficaPdf',array('id'=>3)),
                'url' => $urlPdf,
//                'htmlOptions' => array(
//                    'onClick' => 'goBack()'
//                )
            ));
        }
         */   
        ?>
    </div>    
</div>

<?php 
//Yii::app()->createUrl("desarrollo/pdf/", array("id"=>$data->id_desarrollo)) 

?>

