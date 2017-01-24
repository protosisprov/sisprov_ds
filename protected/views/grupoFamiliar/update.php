<?php
Yii::app()->clientScript->registerScript('camara', "
   $(document).ready(function(){
        $('#siguiente').remove(); 
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
?>
<h1>Modificar Grupo Familiar del Beneficiario</h1>
<h2><center><?php echo UnidadFamiliar::model()->findByPk($_GET['id'])->beneficiario->beneficiarioTemporal->nombre_completo;?></center></h2> 
<div style="margin-bottom: 4%"></div>
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
            'content' => $this->renderPartial('_listardatosUpdate', array('form' => $form), TRUE),
                )
        );
        ?>
    </div>
</div>
<div class="pull-center text-right col-md-6">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'button',
        'icon' => 'glyphicon glyphicon-log-in',
        'context' => 'primary',
        'label' => 'Regresar',
        'htmlOptions' => array(
            'onclick' => 'document.location.href ="' . $this->createUrl('vswCensosCulminados/admin') . '";'
        )
    ));
    ?>
</div>

<?php $this->endWidget(); ?>


