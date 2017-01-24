<style>
    .huge {
        font-size: 40px;
    }
</style>
<section class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $titulo1 ?></h1>
    </div>
</section>



<?php
$this->widget('booster.widgets.TbHighCharts', array(

  'options' => array(
   'title' => array(
     'text' => $titulo,
     'x' => -20 //center
   ),
   'subtitle' => array(
     'text' => $subtitulo,
     'x' -20
  ),


  'chart' => array(
      //'type' => 'bar',
      'type' => 'pie',
      //'marginBottom' => -10,
      /*'options3d' => array(
          'enabled' => true,
          'alpha' => 45,
                'beta' => 0,
                'depth' => 50,
              'viewDistance'=> 25),*/

      //'height' => 900
      ),
/*  'xAxis' => array(
      'categories'=> $categorias ),
*/
      'labels' => array (
        /*'formatter' => "function () {
        return '<a>' + this.value + '</a'>
                }",*/
        'formatter' => "function() {return '<b>'+ this.series.name +'</b>' }",
    'useHTML'  => true
  ),

  'legend' => array(
      'layout' => 'vertical',
      'align' => 'right',
      'verticalAlign' => 'top',
      'x' => -40,
      'y' => 80,
      'floating' => true,
      'borderWidth' => 1,
      /*backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
      shadow: true*/
      //'y' =>  120,
      //'marginBottom' => -320,
      //'spacingBottom' => 50,
  ),
  'plotOptions' => array(
      'pie' => array(
          'allowPointSelect' => 'true',
          'cursor' => 'pointer',
          'dataLabels' => array(
            'enabled' => true,
            'format' => '<b>{point.name}</b>: {point.y} - {point.percentage:.1f} %',
            'style' => array (
              'fontSize' => '16px',
              'padding-top' => '50px'
              )
            ),
      ),
      'showInLegend' => true,
   ),

  'series' => array( array('name' => $tituloSerie, 'data' => $data,
		'dataLabels' => array('enabled' => 'true',
                    'style' => array('fontSize' => '11px')),)),

  'credits' => array( 'enabled' => true, 'text' => 'Generado por Sistema de Protocolización en fecha: '.date("d/m/Y h:m A") ),

  )

    )
    );

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
