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

//$x = array();
//$x[0] == 'Enero';
//$x[01] == 'Febrero';
//$x[02] == 'Marzo';
//$x[03] == 'Abril';
//$x[04] == 'Mayo';
//$x[05] == 'Junio';
//$x[06] == 'Julio';
//$x[07] == 'Agosto';
//$x[08] == 'Septiembre';
//$x[09] == 'Octubre';
//$x[10] == 'Noviembre';
//$x[11] == 'Diciembre';





if($br)
    $marginTop=225;
else
    $marginTop=200;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/validacion.js');
$this->Widget('ext.highcharts.HighchartsWidget', array(
    'options' => array(
       
        'title' => array(

             'text' => '',

        ),
        'subtitle' => array('text' => $subtitulo, 'style'=>array('font-size'=>'20px','height'=>'80px')),
            'theme' => 'white',
        'chart' => array(
            'type' => 'column',
            'height' => 600,
            'marginTop' => $marginTop,
            'plotBackgroundColor'=>array(
                'linearGradient'=> array(0,0,450,450),
                'stops'=>array(

                )
            )
            ),
        'xAxis' => array(
                        'categories' => array(
                                'Enero',
                                'Febrero',
                                'Marzo',
                                'Abril',
                                'Mayo',
                                'Junio',
                                'Julio',
                                'Agosto',
                                'Septiembre',
                                'Octubre',
                                'Noviembre',
                                'Diciembre'
                            ),
            'labels' => array('rotation' => '-45')

        ),

            
        'tooltip' => array(
            'formatter' => 'js:function(){'
            . ' return "El valor para <b>" + this.x + "</b> es <b>" + this.y + "</b>, '
            . 'que representa el <b>" + Highcharts.numberFormat((this.y*100/1000), 2) + "%</b> del <b>"+ this.series.name+"</b>" ; }'
        ),
        'yAxis' => array(
            'title' => array('text' => "Cantidad de ".$tipo),
            'min' => 0
        ),
        'series' => array(
           $s_minima,$s_intermedio,$s_maxima,
        ),
        
        'exporting' => array(
            
            'filename'=>'Reporte'
        ),
        
                
        'plotOptions' => array(
            'bar' => array('dataLabels' => array('enabled' => true, 'style' => array('fontSize' => '12px'))),
            'series' => array('cursor' => 'pointer'
                
            )
        ),
        
        'credits' => array('enabled' => true, 'text' => 'Generado por Sistema de Protocolización en fecha: ' . date("d/m/Y h:m A")),
        
        'dataLabels' => array(
            'enabled'=> true,
            'rotation'=> '-90',
            'color'=>'#FFFFFF',
            'align'=>'right',         
            'y'=> '10', // 10 pixels down from the top
            'style' => array(
                'fontSize'=> '13px',
                'fontFamily'=> 'Verdana, sans-serif'
                )
            ),
    ),
    'scripts' => array(
    'highcharts-more',   // enables supplementary chart types (gauge, arearange, columnrange, etc.)
    'modules/exporting', // adds Exporting button/menu to chart
    'modules/offline-exporting', 
    //'themes/grid'        // applies global 'grid' theme to all charts
 ),
'options2' => 'setTitle({
            useHTML: true,
            text:  "<img src=\''.Yii::app()->baseUrl.'/images/cintillo.jpg\' height=\'20px\' width=\'100%\'class=\'cintillo_responsive\' /><br><center><h3>'.$titulo.'</h3></center>"
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
//print_r($s_minima);


        ?>

        
    </div>    
</div>

<?php ?>

