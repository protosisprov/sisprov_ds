        <?php  Yii::app()->clientScript->registerScript('SalarioMinimo', "
        $('#guardar').click(function(){
           if (confirm('¿Está seguro de los datos suministrados son conrrectos?') == false) {//pido una confirmación
               return false;
        }
        });
        ");
        ?>


<h1>Cargar Salario Mínimo</h1>
<?php
$this->widget(
        'booster.widgets.TbLabel', array(
    'context' => 'warning',
    'htmlOptions' => array('style' => 'padding:3px;text-aling:center; font-size:13px; span{color:red;}'),
    // 'success', 'warning', 'important', 'info' or 'inverse'
    'label' => 'Los campos marcados con * son requeridos',
        )
);
?>
<br><br>


<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'SalarioMinimo-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
    ),
        ));
?>




<div class="row">
    <div class="col-md-12">
        <?php
        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Salario Mínimo',
            'context' => 'info',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'headerIcon' => 'home',
            'content' => $this->renderPartial('_form', array('form' => $form, 'model' => $model), TRUE),
                )
        );
        ?>
    </div>
</div>
<div class="well">
    <div class="pull-center" style="text-align: center;">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'icon' => 'glyphicon glyphicon-floppy-saved',
            'size' => 'large',
            'id' => 'guardar',
            'context' => 'primary',
            'label' => 'Registrar',
        ));
        ?>
    </div>
</div>

<?php //echo $this->renderPartial('_form', array('model'=>$model));  ?>

<?php $this->endWidget(); ?>

<div class="row">
    <div class='col-md-12'>
        <?php
        $this->widget(
                'booster.widgets.TbExtendedGridView', array(
            'type' => 'striped bordered',
            'responsiveTable' => true,
            'id' => 'listado_servicios',
            'dataProvider' => new CActiveDataProvider('SalarioMinimo', array(
                'criteria' => array(
                    'order' => 'id_salario_minimo DESC',
                ),
                'pagination' => array(
                    'pageSize' => 5,
                ),
                    )),
//            'template' => "{items}",
            'columns' => array(
                 array(
                    'name' => 'gaceta',
                    'header' => 'Gaceta',
                    'value' => '$data->gaceta',
                ),
                 array(
                    'name' => 'decreto',
                    'header' => 'Decreto',
                    'value' => '$data->decreto',
                ),
                 array(
                    'name' => 'valor_salario',
                    'header' => 'Salario Mínimo',
                    'value' => '$data->valor_salario',
                ),
                array(
                    'name' => 'fecha_vigencia',
                    'header' => 'Fecha de Vigencia',
                    'value' => 'substr($data->fecha_vigencia,0,10)',
                ),
                array(
                    'name' => 'observacion',
                    'header' => 'Observaciones',
                    'value' => '$data->observacion',
                    
                    
                ),
            )
                )
        );
        ?>
    </div>
</div>