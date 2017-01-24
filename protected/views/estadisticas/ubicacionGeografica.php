<style>
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
$Validaciones = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/validacion.js');
$this->Widget('ext.highcharts.HighchartsWidget', array(
    'options' => array(
        'title' => array('text' => $titulo),
        'subtitle' => array('text' => $subtitulo),
            'theme' => 'white',
        'chart' => array(
            'type' => 'bar',
            'height' => 700),
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
            array('name' => "Total: $total", 'data' => $series)
        ),
        'plotOptions' => array(
            'bar' => array('dataLabels' => array('enabled' => true, 'style' => array('fontSize' => '14px'))),
            'series' => array('cursor' => 'pointer',
                'point' => $event
            )
        ),
        
        'credits' => array('enabled' => true, 'text' => 'Generado por Sistema de Protocolización en fecha: ' . date("d/m/Y h:m A")),
    )
));
?>

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
    </div>
</div>
