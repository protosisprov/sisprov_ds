<style>
    .huge {
        font-size: 40px;
    }
</style>
<section class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $titulo ?></h1>
    </div>
</section>



<?php

$this->widget('booster.widgets.TbHighCharts', array(

  'options' => array(
   // 'title'=> ',

   'title' => array(
     'text' => $titulo,
     //'x' => -20 //center
      // 'y' => 100,
   ),
   'subtitle' => array(
     'text' => $subtitulo,
     //'x' -20
    'y' => 190,
  ),


  'chart' => array(
      //'type' => 'bar',
      'type' => 'column',
      'marginTop'=>250,
      //'spacingTop'=>200,
      //'marginBottom' => -10,
      /*'options3d' => array(
          'enabled' => true,
          'alpha' => 45,
                'beta' => 0,
                'depth' => 50,
              'viewDistance'=> 25),*/

      'height' => 720
      ),
  'xAxis' => array( 'categories'=> $categorias  ),

      'labels' => array (
        /*'formatter' => "function () {
        return '<a>' + this.value + '</a'>
                }",*/
        'formatter' => "function() {return '<b>'+ this.series.name +'</b>' }",
    'useHTML'  => true
  ),

//  'legend' => array(
//      'layout' => 'vertical',
//      'align' => 'right',
//      'verticalAlign' => 'top',
//      'x' => -40,
//      'y' => 80,
//      'floating' => true,
//      'borderWidth' => 1,
//      /*backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
//      shadow: true*/
//      //'y' =>  120,
//      //'marginBottom' => -320,
//      //'spacingBottom' => 50,
//  ),


  'series' => array( array('name' => $tituloSerie, 'data' => $data )  ),

  'credits' => array( 'enabled' => TRUE, 'text' => 'Generado por Sistema de Protocolización en fecha: '.date("d/m/Y h:m A") ),

  ),
  'options2' => 'setTitle({
            useHTML: true,
            text:  "<img src=\''.Yii::app()->baseUrl.'/images/cintillo.jpg\' class=\'cintillo_responsive\' /><br><center><h3>'.$titulo.'</h3></center>"
            })'  

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
