<?php

$baseUrl = Yii::app()->baseUrl;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');

	$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
		'action'=>Yii::app()->createUrl($this->route), 'method'=>'get',)); ?>


<h1 class="text-center">Reporteador de Protocolizacion </h1>

<?php if ( Yii::app()->user->hasFlash('success') ) { ?>
		<div style="border-radius:4px;" class="flash-success">
				<?php echo Yii::app()->user->getFlash('success'); ?>
		</div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <?php
        $this->widget(
            'booster.widgets.TbPanel', array(
            'title' => 'Filtros para realizar la consulta',
            'context' => 'info',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'headerIcon' => 'globe',
             'content' => $this->renderPartial('_filtros', array('form' => $form, 'model' => $model ), TRUE),
                )
        );
        ?>
    </div>
</div>



<div class="well">
    <div class="pull-center" style="text-align: right;">
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'reset',
		'context'=>'primary',
		'size' => 'large',
		'label'=>'Limpiar',
	)); ?>
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'submit',
		'icon' => 'floppy-save',
		'size' => 'large',
		'context'=>'success',
		'label'=>'Generar Excel',
	)); ?>
	</div>
</div>



<?php $this->endWidget(); ?>
