<?php
$Validaciones = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/analisisCredito.js');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'Asignacionesfaov-form',
    'enableAjaxValidation' => false,
        ));
?> 
<?php
//$msj = (isset($_GET['msj'])) ? $_GET['msj'] : '';
//if (isset($msj) && !empty($msj)):
//    
?>
<!--<div class="alertaExito">-->
<?php
//        switch ($msj) {
//            case 1:
//                Yii::app()->user->setFlash('info', '<strong><center>¡Enviado a documentacion!</center></strong>');
//                $this->widget('booster.widgets.TbAlert', array(
//                    'closeText' => '',
//                ));
//                break;
//            case 2:
//                Yii::app()->user->setFlash('info', '<strong><center>¡No existe analisis!</center></strong>');
//                $this->widget('booster.widgets.TbAlert', array(
//                    'closeText' => '',
//                ));
//                break;
//        }
?>
<!--</div>-->
<?php // endif;  ?>

<?php if (Yii::app()->user->checkAccess('jefe_analisis_credito_faov')) { ?>
    <div class="col-md-3">
        <div class="well">
            <?php
            $criteria = new CDbCriteria;
            $criteria->order = 't.value ASC';
            $criteria->join = 'join cruge_authassignment a ON a.userid = t.iduser';
            $criteria->condition = "a.itemname ='analista_analisis_financiero_faov'";
            echo $form->dropDownListGroup(
                    $asignaciones, 'fk_usuario_asignado', array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-6',
                ),
                'widgetOptions' => array(
                    'data' => CHtml::listData(CrugeFieldValue::model()->findAll($criteria), 'iduser', 'value'),
                    'htmlOptions' => array(
                        'empty' => 'SELECCIONE',
                    ),
                )
                    )
            );
            ?>


            <br>              
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'context' => 'success',
                'buttonType' => 'button',
                'label' => 'Asignar',
                'size' => 'Small',
                'htmlOptions' => array(
                    'onClick' => '
                                var asignado =$("#Asignaciones_fk_usuario_asignado").val();
                                var caso = 308; //caso:308 indica que la asignacion es de un ANALISIS FINANCIERO
                             
                                  AsignacionAnalista(asignado, caso);'
                ),
                'icon' => 'user',
                'id' => 'fech',
                'block' => false,
            ));
            ?>

        </div>
    </div>

<?php } ?>


<h1>Gestión Análisis de Crédito FAOV</h1>
<?php // $model->id_fuente_financiamiento = 2; ?>
<?php
if (Yii::app()->user->checkAccess('jefe_analisis_credito_faov')) {

    $DataProviderGrid = $model->search();
    $filtro = $model;
} else if (Yii::app()->user->checkAccess('analista_analisis_financiero_faov')) {
    $DataProviderGrid = $vswAsignaciones->search();
    $filtro = $vswAsignaciones;
}
?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'tempcensovalidadofaovfaspGrid',
    'dataProvider' => $DataProviderGrid,
    'type' => 'striped bordered condensed',
    'filter' => $filtro,
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn', // Checkboxes
            'selectableRows' => 2, // Allow multiple selections 
            'value' => '$data->id_beneficiario',
            'id' => 'check_analista',
            'visible' => (Yii::app()->user->checkAccess("jefe_analisis_credito_faov"))
        ),
        array(
            'name' => 'id_beneficiario',
            'header' => 'Beneficiario',
            'value' => '$data->id_beneficiario',
        ),
        array(
            'name' => 'cedula',
            'header' => 'Cédula',
            'value' => '$data->cedula',
        ),
        array(
            'name' => 'nombre_completo',
            'header' => 'Nombre del Beneficiario',
            'value' => '$data->nombre_completo',
        ),
        'estado' => array(
            'header' => 'Estado',
            'name' => 'cod_estado',
            'value' => '$data->estado',
            'filter' => CHtml::listData(VswCensoValidadoFaovFasp::model()->findall(), 'cod_estado', 'estado'),
        ),
        'nombre' => array(
            'header' => 'Desarrollo Habitacional',
            'name' => 'id_desarrollo',
            'value' => '$data->nombre',
            'filter' => CHtml::listData(VswCensoValidadoFaovFasp::model()->findall(), 'id_desarrollo', 'nombre'),
        ),
        'estatus' => array(
            'header' => 'Estatus',
            'name' => 'estatus',
            'value' => 'VswAsignacionesCasos::buscarEstatus($data->id_beneficiario)',
        //'filter' => CHtml::listData(TempCensoValidadoFaovFasp::model()->findall(), 'id_desarrollo', 'nombre'),
        ),
  
        
         'analista' => array(
            'header' => 'Analista Asignado',
            'name' => 'estatus',
            'value' => 'VswAsignacionesCasos::buscarUsuAsignado($data->id_beneficiario)',
        //'filter' => CHtml::listData(TempCensoValidadoFaovFasp::model()->findall(), 'id_desarrollo', 'nombre'),
        ),
        

        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            'template' => '{ver} {ver_credito}{acreditacion}{alterfuentefinan}',
            'buttons' => array(
                'ver' => array(
                    'label' => 'Ver censo',
                    'icon' => 'eye-open',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_beneficiario_view")))',
                    'url' => 'Yii::app()->createUrl("beneficiario/view/", array("id"=>$data->id_beneficiario))',
                ),
                'ver_credito' => array(
                    'label' => 'Ver Crédito',
                    'icon' => 'glyphicon glyphicon-link',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_analisiscredito_create")))',
                    'url' => 'Yii::app()->createUrl("/analisisCredito/ViewAnalisisCredito", array("id"=>$data->id_beneficiario))',
//                    'visible' => 'traza($data->id_beneficiario)==100'
                ),
                'acreditacion' => array(
                    'label' => 'Análisis Financiero/Crédito',
                    'icon' => 'glyphicon glyphicon-euro',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_analisiscredito_create")) && $data->estatus == "ASIGNADO"  || $data->estatus == "DEVUELTO")',
                    'url' => 'Yii::app()->createUrl("/analisisCredito/create", array("id"=>$data->id_beneficiario))',
//                    'visible' => 'traza($data->id_beneficiario)==100'
                ),
                'alterfuentefinan' => array(
                    'label' => 'Cambiar Fuente de Financiamiento',
                    'icon' => 'glyphicon glyphicon-transfer',
                    'size' => 'medium',
                    //'visible' => '((Yii::app()->user->checkAccess("action_analisiscredito_create")))',
                    'url' => 'Yii::app()->createUrl("/TempCensoValidadoFaovFasp/changeFaovFasp", array("id"=>$data->id_beneficiario))',
//                    'visible' => 'traza($data->id_beneficiario)==100'
                ),
            ),
        ),
    ),
));
?>
<?php $this->endWidget(); ?>