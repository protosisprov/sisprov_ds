
<?php
$Validaciones = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/analisisCredito.js');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'Asignaciones-form',
    'enableAjaxValidation' => false,
        ));
?>    
<?php if (Yii::app()->user->checkAccess('administrador_analisis_financiero_fasp')) { ?>
    <div class="col-md-3">
        <div class="well">
            <?php
            $criteria = new CDbCriteria;
            $criteria->order = 't.value ASC';
            $criteria->join = 'join cruge_authassignment a ON a.userid = t.iduser';
            $criteria->condition = "a.itemname ='analista_analisis_financiero_fasp'";
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

<h1>Gestión Análisis de Crédito FASP</h1>

<?php
if (Yii::app()->user->checkAccess('administrador_analisis_financiero_fasp') || Yii::app()->user->checkAccess('documentacion')) {

    $DataProviderGrid = $model->search();
    $filtro = $model;
} else if (Yii::app()->user->checkAccess('analista_analisis_financiero_fasp')) {
    $DataProviderGrid = $vswAsignaciones->search();
    $filtro = $vswAsignaciones;
}
?>
<?php $model->id_fuente_financiamiento = 3; ?>
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
            'visible' => (Yii::app()->user->checkAccess("administrador_analisis_financiero_fasp"))
        ),
        array(
            'name' => 'id_beneficiario',
            'header' => 'N° Beneficiario',
            'value' => '$data->id_beneficiario',
             'htmlOptions' => array('width' => '95px'),
        ),
        array(
            'name' => 'cedula',
            'header' => 'Cédula',
            'value' => '$data->cedula',
             'htmlOptions' => array('width' => '100'),
        ),
        array(
            'name' => 'nombre_completo',
            'header' => 'Nombre del Beneficiario',
            'value' => '$data->nombre_completo',
            'htmlOptions' => array('width' => '400'),
        ),
        'estado' => array(
            'header' => 'Estado',
            'name' => 'cod_estado',
            'value' => '$data->estado',
            'filter' => CHtml::listData(TempCensoValidadoFaovFasp::model()->findall(), 'cod_estado', 'estado'),
             'htmlOptions' => array('width' => '200'),
        ),
        'nombre' => array(
            'header' => 'Desarrollo Habitacional',
            'name' => 'id_desarrollo',
            'value' => '$data->nombre',
            'filter' => CHtml::listData(TempCensoValidadoFaovFasp::model()->findall(), 'id_desarrollo', 'nombre'),
        ),
        'estatus' => array(
            'header' => 'Estatus',
            'name' => 'estatus',
            'value' => 'VswAsignacionesCasos::buscarEstatus($data->id_beneficiario)',
             'htmlOptions' => array('width' => '110px'),
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
            'htmlOptions' => array('width' => '150', 'style' => 'text-align: center;'),
            'template' => '{ver} {ver_credito}{acreditacion}{enviardocumentacion}{alterfuentefinan}',
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
                    'options' => array('style' => 'margin-left:17px;'),
                    'visible' => '((Yii::app()->user->checkAccess("action_analisiscredito_ViewAnalisisCredito")) && (VswAsignacionesCasos::buscarEstatus($data->id_beneficiario) == "ANALIZADO") || (VswAsignacionesCasos::buscarEstatus($data->id_beneficiario) == "ENVIADO A DOCUMENTACION") || $data->estatus == "ANALIZADO"  || $data->estatus == "ENVIADO A DOCUMENTACION" )',
                    'url' => 'Yii::app()->createUrl("/analisisCredito/ViewAnalisisCredito", array("id"=>$data->id_beneficiario))',
//                    'visible' => 'traza($data->id_beneficiario)==100'
                ),
                'acreditacion' => array(
                    'label' => 'Análisis Financiero/Crédito',
                    'icon' => 'glyphicon glyphicon-euro',
                    'size' => 'medium',
                    'options' => array('style' => 'margin-left:17px;'),
                    'visible' => '((Yii::app()->user->checkAccess("action_analisiscredito_create")) && $data->estatus == "ASIGNADO"  || $data->estatus == "DEVUELTO")',
                    'url' => 'Yii::app()->createUrl("/analisisCredito/create", array("id"=>$data->id_beneficiario))',
                ),
                'alterfuentefinan' => array(
                    'label' => 'Cambiar Fuente de Financiamiento',
                    'icon' => 'glyphicon glyphicon-transfer',
                    'size' => 'medium',
                    'options' => array('style' => 'margin-left:17px;'),
                    'visible' => '((Yii::app()->user->checkAccess("action_tempCensoValidadoFaovFasp_changeFaspFaov")))',
                    'url' => 'Yii::app()->createUrl("/TempCensoValidadoFaovFasp/changeFaspFaov", array("id"=>$data->id_beneficiario))',
                ),
                'enviardocumentacion' => array(
                    'label' => 'Enviar a Documentacion',
                    'icon' => 'glyphicon glyphicon-ok',
                    'size' => 'medium',
                    'options' => array('style' => 'margin-left:17px;'),
                    'url' => '$data->id_beneficiario',
                    'click' => 'js: function(s){EnviarDocumentacion($(this).attr("href")); return false; }',
                    'visible' => '((Yii::app()->user->checkAccess("action_analisiscredito_enviardocumentacion")) && VswAsignacionesCasos::buscarEstatus($data->id_beneficiario) == "ANALIZADO")',
                ),
            ),
        ),
    ),
));
?>
<?php $this->endWidget(); ?>
