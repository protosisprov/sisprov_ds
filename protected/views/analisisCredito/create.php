<?php
$Validaciones = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/analisisCredito.js');
$Validacion = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/validacion.js');

$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'analisis-credito-form',
    'enableAjaxValidation' => false,
        ));
?>

<h1 class="text-center">Análisis de Crédito</h1>


<div class="row">
    <div class="col-md-12">
        <?php
        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Datos del Beneficiario',
            'context' => 'info',
            'headerIcon' => 'user',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'content' => $this->renderPartial('_beneficiario', array('form' => $form, 'beneficiario' => $beneficiario, 'model' => $model, 'desarrollo' => $desarrollo, 'benetemp'=>$benetemp,'td_benef'=>$td_benef,'grupoFamiliar'=>$grupoFamiliar), TRUE),
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
            'title' => 'Análisis de Crédito',
            'context' => 'info',
            'headerIcon' => 'user',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'content' => $this->renderPartial('_form', array('form' => $form, 'model' => $model,'TableSueldo' => $TableSueldo, 'TableSueldoFaov' => $TableSueldoFaov, 'beneficiario' => $beneficiario,'td_benef'=>$td_benef,'grupoFamiliar'=>$grupoFamiliar), TRUE),
                )
        );
        ?>
    </div>
    
</div>
<div class="row" id="sumilador_id" style="display: none">
    <div class="col-md-12">
        <?php
        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Simulador de Credito Hipotecario',
            'context' => 'info',
            'headerIcon' => 'user',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'htmlOptions' => array('style' => 'background-color: #F5F5F5; !important;color: #FFFFFF !important;'),
            'content' => $this->renderPartial('_simulador', array('form' => $form), TRUE),
                )
        );
        ?>
    </div>
    <div class="col-md-12" id="cuotas_extra" style="display: none">
        <?php
        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Cuotas Extraordinarias',
            'context' => 'info',
            'headerIcon' => 'user',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'htmlOptions' => array('style' => 'background-color: #F5F5F5; !important;color: #FFFFFF !important;'),
            'content' => $this->renderPartial('_cuota_extraordinaria', array('form' => $form), TRUE),
                )
        );
        
        
        ?>
    </div>
</div>
<div class="well">
    <div class="pull-center" style="text-align: right;">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'submit',
                'icon' => 'glyphicon glyphicon-floppy-saved',
                'size' => 'large',
                'id' => 'guardar-analisis',
                'context' => 'primary',
                'label' => 'Guardar',
                'htmlOptions' => array(
                    'style' => 'display:none;'
                )
            ));
            
            
            ?>
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'context' => 'danger',
                'label' => 'Cancelar',
                'size' => 'large',
                'icon' => 'ban-circle',
                'buttonType' => 'link',
                'htmlOptions' => array(
                'onClick' => 'goBack()'
            )
            ));
            ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget(
        'booster.widgets.TbModal', array('id' => 'myModal')
);
?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>TABLA ULTIMAS COTIZACIONES DE FAOV</h4>
</div>
<div class="modal-body"></div>

<div class="modal-footer">
    <?php
    $this->widget(
            'booster.widgets.TbButton', array(
        'context' => 'primary',
        'label' => 'Ok',
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
            )
    );
    ?>
    <?php
    $this->widget(
            'booster.widgets.TbButton', array(
        'label' => 'Cerrar',
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
            )
    );
    ?>
</div>

<?php $this->endWidget(); ?>