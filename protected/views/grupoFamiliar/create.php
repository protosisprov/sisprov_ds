<?php
$Validacion = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/js_jquery.numeric.js');
Yii::app()->clientScript->registerScript('camara', "
   $(document).ready(function(){
        $('#GrupoFamiliar_tipo_sujeto_atencion').numeric(); 
        $('#GrupoFamiliar_ingreso_mensual').numeric(); 
    });
   
");

$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'desarrollo-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
    ),
        ));


$this->widget('booster.widgets.TbProgress', array(
    'striped' => true,
    'animated' => true,
    'stacked' => array(
        array(
            'context' => 'warning',
            'percent' => 30,
            'htmlOptions' => array(
                'data-toggle' => 'tooltip',
                'data' => 'Paso 1',
                'title' => 'Paso 1'
            )
        ), 
        array('context' => 'info',
            'percent' => 35,
            'htmlOptions' => array(
                'data-toggle' => 'tooltip',
                'title' => 'Paso 2'
            )
        ),
    )
        )
);
?>
<h1>Grupo Familiar del Beneficiario</h1>
<h2><center><?php echo UnidadFamiliar::model()->findByPk($_GET['id'])->beneficiario->beneficiarioTemporal->nombre_completo;?></center></h2>
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
<div class="row">
    <div class="col-md-12">
        <?php
        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Grupo Familiar',
            'context' => 'primary',
            'headerIcon' => 'user',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'content' => $this->renderPartial('_form', array('form' => $form, 'model' => $model), TRUE),
                )
        );
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Listar Grupo Familiar',
            'context' => 'primary',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'headerIcon' => 'user',
            'content' => $this->renderPartial('_listardatos', array('form' => $form,'model' => $model ), TRUE),
                )
        );
        ?>
    </div>
</div>



<?php //echo $this->renderPartial('_form', array('model'=>$model));  ?>

<?php $this->endWidget(); ?>


