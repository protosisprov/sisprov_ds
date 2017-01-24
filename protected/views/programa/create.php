        <?php  Yii::app()->clientScript->registerScript('programa', "
        $('#guardar').click(function(){
           if (confirm('¿Está seguro de los datos suministrados son conrrectos?') == false) {//pido una confirmación
               return false;
        }
        });
        ");
        ?>

<h1>Cargar Nuevo Programa</h1>

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
<br><br>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'Programa-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
        )));

//echo '<pre>';var_dump($model);die;
?>

<div class="row">
    <div class="col-md-12">
        <?php
        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Programa',
            'context' => 'primary',
            'headerIcon' => 'user',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'content' => $this->renderPartial('_form', array('form' => $form, 'model' => $model), TRUE),
                #'content' => $this->renderPartial('_form', array('model'=>$model),TRUE),
                )
        );
        ?>
    </div>
</div>

<div class="form-actions text-center">
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
<?php $this->endWidget(); ?>

<div class="row">
    <div class='col-md-12'>
        <?php
//        $model->estatus=47;
        $this->widget(
                'booster.widgets.TbExtendedGridView', array(
            'type' => 'striped bordered',
            'responsiveTable' => true,
            'id' => 'listado_servicios',
            'dataProvider' => new CActiveDataProvider('Programa', array(
                'criteria' => array(
                    'condition' => 'estatus=47',
                    'order' => 'id_programa DESC',
                ),
                'pagination' => array(
                    'pageSize' => 5,
                ),
                    )),
//            'template' => "{items}",
            'columns' => array(
                array(
                    'name' => 'id_programa',
                    'header' => 'N° de Programas',
                    'value' => '$data->id_programa',
                ),
                array(
                    'name' => 'nombre_programa',
                    'header' => 'Listado de Programas',
                    'value' => '$data->nombre_programa',
                ),
                array(
                    'name' => 'fuente_financiamiento_id',
                    'header' => 'Fuente de Financiamiento',
                    'value' => '$data->fuenteFinanciamiento->nombre_fuente_financiamiento',
                ),
                array(
                    'name' => 'estatus',
                    'header' => 'Estatus',
                    'value' => '$data->estatus0->descripcion',
                ),
                  array(
                    'visible' => (Yii::app()->user->checkAccess("action_programa_cambioestatus") == FALSE) ? FALSE: TRUE,
                    'class' => 'booster.widgets.TbButtonColumn',
                    'header' => 'Acciones',
                    'template' => '{estatus}',
                    'buttons' => array(
                        'estatus' => array(
                            'label' => 'Cambiar Estatus',
                            'icon' => 'glyphicon glyphicon-edit',
                            'size' => 'medium',
                            'url' => 'Yii::app()->createUrl("programa/cambioEstatus", array("id"=>$data->id_programa, "ajax"=>true))',
                            'imageUrl' => false,
                            'click' => 'function(e) {
                                      $("#ajaxModal").remove();
                                      e.preventDefault();
                                      var $this = $(this)
                                        , $remote = $this.data("remote") || $this.attr("href")
                                        , $modal = $("<div class=\'modal\' id=\'ajaxModal\'><div class=\'modal-body\'><h5 align=\'center\'>&nbsp;  Espere por Favor .. </h5></div></div>");
                                      $("body").append($modal);
                                      $modal.modal({backdrop: "static", keyboard: false});
                                      $modal.load($remote);
                                    }',
                            'options' => array('data-toggle' => 'ajaxModal', 'style' => 'padding:4px;'),
                    //'visible' => '((Yii::app()->user->checkAccess("action_programa_cambioestatus")))', 
                        ),
                    ),
                ),
                
            ),
                )
        );
        ?>
    </div>
</div>