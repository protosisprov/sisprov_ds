<section class="row">
    <div class="col-lg-12">
        <h1>Reporte Por Documentación (Multifamiliares)</h1>
        <h4 class="text-center" >Generado Al <?php echo date("d/m/Y h:m A") ?></h4>
    </div>
    <div class="pull-right">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'Atras',
            'icon' => 'glyphicon glyphicon-chevron-left',
            'size' => 'btn-lg',
            'context' => 'info',
            'buttonType' => 'link',
            'url' => Yii::app()->createUrl('estadisticas/index'),
            /*'htmlOptions' => array(
                'onClick' => 'goBack()'
            )*/
        ));
        ?>
    </div>
</section>
<div style="padding-top: 20px"></div>
<div style="text-align:center !important;">
    <table class="items table table-striped table-bordered table-condensed text-center" style="width:90%; margin: 0 auto;">
        <thead class='thead-tabla_reporte'>
            <tr>
                <th class="text-center">Estado</th>
                <th class="text-center">Activo</th>
                <th class="text-center">Inactivo</th>
                <th class="text-center">Borrado</th>
                <th class="text-center">Validado Banavih <br> (Multifamiliar)</th>
                <th class="text-center">Validado Saren <br> (Multifamiliar)</th>
                <!--<th class="text-center">Validado Banavih <br> (Unifamiliar)</th>-->
                <!--<th class="text-center">Validado Saren <br> (Unifamiliar)</th>-->
                <th class="text-center">Devuelto Saren <br> (Multifamiliar)</th>
                <!--<th class="text-center">Devuelto Saren <br> (Unifamiliar)</th>-->
                <th class="text-center">Total Por Estado</th>
            </tr>
        </thead>
    <?php foreach($reporte as $item): ?>
        <tr>
        <?php foreach($item as $value): ?>
            <td <?php if(is_int($value)) echo 'class="text-right"' ?>><?php echo $value ?></td>
        <?php endforeach ?>
        </tr>
    <?php endforeach ?>
        <tfoot class='tfoot-tabla_reporte'>
            <tr>
                <th>TOTAL POR ESTATUS</th>
                <th class="text-right"><?=$activo_total?></th>
                <th class="text-right"><?=$inactivo_total?></th>
                <th class="text-right"><?=$borrado_total?></th>
                <th class="text-right"><?=$validado_banavih_multi_total?></th>
                <th class="text-right"><?=$validado_saren_multi_total?></th>
                <!--<th><?//=$validado_banavih_uni_total?></th>-->
                <!--<th><?//=$validado_saren_uni_total?></th>-->
                <th class="text-right"><?=$devuelto_saren_multi_total?></th>
                <!--<th><?//=$devuelto_saren_uni_total?></th>-->
                <th class="text-right"><?=$estados_total?></th>
            </tr>
        </tfoot>
    </table>
</div>

<?php if(file_exists('..'.Yii::app()->request->baseUrl.'/images/estadisticas_temp/reporteDocumentacionMultiFamiliarBarras.png')): ?>
<div style="padding-top: 20px"></div>
<section class="text-center">
    <img src='<?php echo Yii::app()->request->baseUrl; ?>/images/estadisticas_temp/reporteDocumentacionMultiFamiliarBarras.png' >
</section>
<?php endif; ?>

<div style="padding-top: 15px">
    <?php
    $this->widget('booster.widgets.TbButton', array(
                    'label' => 'Generar PDF',
                    'icon' => 'glyphicon glyphicon-file',
                    'size' => 'large',
                    'context' => 'info',
                    'buttonType' => 'link',
                    //'url' => Yii::app()->createUrl('estadisticas/beneficiariosUbicacionGeograficaPdf'),
                    //'url' => Yii::app()->createUrl('estadisticas/beneficiariosUbicacionGeograficaPdf',array('id'=>3)),
                    'url' => Yii::app()->createUrl('estadisticas/reporteDocumentacionMultiPdf'),
    //                'htmlOptions' => array(
    //                    'onClick' => 'goBack()'
    //                )
                ));
    ?>
</div>

