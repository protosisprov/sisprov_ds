        <?php  Yii::app()->clientScript->registerScript('FuenteFinanciamientoObra', "
        $('#guardar').click(function(){
           if (confirm('¿Está seguro de los datos suministrados son conrrectos?') == false) {//pido una confirmación
               return false;
        }
        });
        ");
        ?>
<h1 class="text-center">Cargar Fuente de Financiamiento de la Obra</h1>

<?php
if (isset($error) && !empty($error)) {
    $user = Yii::app()->getComponent('user');
    switch ($error) {
        case 1:
            $type = 'warning';
            $sms = "<strong>Ya existe un registro con este nombre.</strong>.";
            break;
        case 2:
            $type = 'info';
            $sms = "<strong>Por Favor Ingrese un nombre.</strong>.";
            break;
    }
    $user->setFlash(
            $type, $sms
    );
    $this->widget('booster.widgets.TbAlert', array(
        'fade' => true,
        'closeText' => '&times;', // false equals no close link
        'events' => array(),
        'htmlOptions' => array(),
        'userComponentId' => 'user',
        'alerts' => array(// configurations per alert type
            $type => array('closeText' => false),
        ),
    ));
}
?>

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
<br>
<br>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'fuente-financiamiento-obra-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
    ),
        ));
?>

<div>
    <?php
    $this->widget(
            'booster.widgets.TbPanel', array(
        'title' => 'Fuente de Financiamiento de la Obra',
        'context' => 'primary',
        'headerIcon' => 'user',
        'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
        'content' => $this->renderPartial('_form', array('form' => $form, 'model' => $model), TRUE),
            )
    );
    ?>
</div>
<div class="form-actions text-center">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'size' => 'large',
        'label' => 'Registrar',
        'id' => 'guardar',
    ));
    ?>
</div>
<?php
$this->endWidget();
?>
<div class="row">
    <div class='col-md-12'>
        <?php
        $this->widget(
                'booster.widgets.TbExtendedGridView', array(
            'type' => 'striped bordered',
            'responsiveTable' => true,
            'id' => 'listado_servicios',
            'dataProvider' => new CActiveDataProvider('FuenteFinanciamientoObra', array(
                'criteria' => array(
                    'order' => 'id_fuente_financiamiento_obra DESC',
                ),
                'pagination' => array(
                    'pageSize' => 5,
                ),
                    )),
//            'template' => "{items}",
            'columns' => array(
              'nombre_fuente_financiamiento_obra',
                /*array(
                    'name' => 'nombre_fuente_financiamiento',
                    'header' => 'Listado de Fuente de Financiamiento',
                    'value' => '$data->nombre_fuente_financiamiento',
                ),*/

              /*  array(
                 'class' => 'booster.widgets.TbEditableColumn',
                 'name' => 'nombre_fuente_financiamiento',
                 //'htmlOptions' => array('style' => 'text-align:center', 'title' => 'Indique nombre del financiamiento'),
                 'headerHtmlOptions' => array('style' => 'width: 110px; text-align: center'),
                 'editable' => array(
                     'type' => 'text',
                     'emptytext' => 'Indique nombre del financiamiento',
                     'inputclass' => 'input-large',
                     'url' => $this->createUrl('FuenteFinanciamiento/Actualizar'),
                     'placement' => 'right',
                     'validate' => 'function(value) {
                 if(!value) return "Disculpe, no puede estar vacio"
             }'
                 )
             ),*/
            )
                )
        );
        ?>
    </div>
</div>

