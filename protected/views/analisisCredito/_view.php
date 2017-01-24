<?php
$baseUrl = Yii::app()->baseUrl;
//        var_dump($baseUrl);die;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');
//        var_dump($credito);die;
?>
<!--<h1>Detalle de Censo Socioeconomico #<?php // echo $model->id_beneficiario; ?></h1>-->

<?php
$this->widget('booster.widgets.TbPanel', array(
    'context' => 'primary',
    'content' => $this->renderPartial('view_analisis_credito', array('model' => $model,'condUnidadFam'=> $condUnidadFam, 'credito' => $credito), TRUE),
        )
);
?>



