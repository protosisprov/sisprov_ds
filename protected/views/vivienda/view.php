<?php 
$baseUrl = Yii::app()->baseUrl;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');
?>

<center><h1><b>Detalle: </b><?php echo $model->unidadHabitacional->desarrollo->nombre . ' / ' . $model->unidadHabitacional->nombre . ' / ' . $model->nro_vivienda; ?></h1></center>


<?php
$this->widget('booster.widgets.TbPanel', array(
    'context' => 'primary',
    'content' => $this->renderPartial('_view', array('model' => $model), TRUE),
        )
);
?>
<div class="row text-right" style="margin-right: 1em">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'button',
        'context' => 'danger',
        'size' => 'large',
        'label' => 'Regresar',
        'htmlOptions' => array(
            'onclick' => 'javascript:window.history.back();',
        )
    ));
    ?>
</div>
