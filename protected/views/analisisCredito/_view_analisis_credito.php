<?php
$baseUrl = Yii::app()->baseUrl;
//        var_dump($baseUrl);die;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');
?>
<!--<h1>Detalle de Censo Socioeconomico #<?php // echo $model->id_beneficiario; ?></h1>-->

<?php
$this->widget('booster.widgets.TbPanel', array(
    'context' => 'primary',
    'content' => $this->renderPartial('view_analisis_credito', array('model' => $model,'condUnidadFam'=> $condUnidadFam), TRUE),
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
            'onclick' => 'goBack()',
        )
    ));
    ?>
</div>

