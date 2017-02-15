<section class="row">
    <div class="col-lg-12">
        <h1>Reporte por Documentación (Multifamiliares)</h1>
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
            'htmlOptions' => array(
                'onClick' => 'goBack()'
            )
        ));
        ?>
    </div>
</section>
<div style="padding-top: 20px"></div>
<section>
    <table class="items table table-striped table-bordered table-condensed">
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
            </tr>
        </thead>
    <?php foreach($reporte as $item): ?>
        <tr>
        <?php foreach($item as $value): ?>
            <td><?php echo $value ?></td>
        <?php endforeach ?>
        </tr>
    <?php endforeach ?>
        <tfoot class='tfoot-tabla_reporte'>
            <tr>
                <th>Total Por Estatus</th>
                <th><?=$activo_total?></th>
                <th><?=$inactivo_total?></th>
                <th><?=$borrado_total?></th>
                <th><?=$validado_banavih_multi_total?></th>
                <th><?=$validado_saren_multi_total?></th>
                <!--<th><?//=$validado_banavih_uni_total?></th>-->
                <!--<th><?//=$validado_saren_uni_total?></th>-->
                <th><?=$devuelto_saren_multi_total?></th>
                <!--<th><?//=$devuelto_saren_uni_total?></th>-->
            </tr>
        </tfoot>
    </table>
</section>
