<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'vivienda-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
    ),
        ));
?>

<h3><center>Seleccion de Abogado/Apoderado </center></h3>

<?php
// $this->widget(
//         'booster.widgets.TbLabel', array(
//     'context' => 'warning',
//     'htmlOptions' => array('style' => 'padding:3px;text-aling:center; font-size:13px; span{color:red;}'),
//     // 'success', 'warning', 'important', 'info' or 'inverse'
//     'label' => 'Los campos marcados con * son requeridos',
//         )
// );
?>


<div style="margin-top:5%"></div>

<div class="well">
    <div class="pull-center" style="text-align: right;">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'icon' => 'glyphicon glyphicon-floppy-saved',
            'size' => 'medium',
            'id' => 'guardarVivienda',
            'context' => 'success',
            'label' => 'Guardar',
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'url' => '#',
            'context' => 'danger',
            'label' => 'Cancelar',
            'size' => 'medium',
            'id' => 'CancelarForm',
            'icon' => 'ban-circle',
            'htmlOptions' => array('data-dismiss' => 'modal')
        ));
        ?>
    </div>
</div>

<?php //echo $this->renderPartial('_form', array('model'=>$model));  ?>

<?php $this->endWidget(); ?>
