<?php
$baseUrl = Yii::app()->baseUrl;
$Validaciones3 = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/analisisCredito.js');
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'AsignacionesMULTI-form',
    'enableAjaxValidation' => false,
        ));
/*
 * VERIFICA SI EXISTE UN DOCUMENTO CREADO
 */
$baseUrl = Yii::app()->baseUrl;
$validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');

//si ya existe el multi en la tabla documentacion no muestra generar documento
function DocumentoExistMulti($iD) {
    $unidadHabitacional = UnidadHabitacional::model()->findByPk($iD);
    $fuente_financiamiento = $unidadHabitacional->desarrollo->fuenteFinanciamiento->id_fuente_financiamiento;
    if ($fuente_financiamiento = 3) { //fasp
        $tipo_documento = 298;
    } else {
        $tipo_documento = 297;
    }

    if (Documentacion::model()->exists('fk_beneficiario=:fk_beneficiario AND tipo_documento_id=:tipo_documento_id', array(':fk_beneficiario' => $iD, ':tipo_documento_id' => $tipo_documento))) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function DocumentoExistMulti2($iD) {
    $sql = 'SELECT * FROM documentacion WHERE fk_beneficiario=' . $iD . ' AND (tipo_documento_id=' . $tipo_documento . ' or  tipo_documento_id=277)  AND registro_documento_id IS NULL';
    $query = Yii::app()->db->createCommand($sql)->queryAll();
    if ($query != null)
        return TRUE;
    else
        return FALSE;
}

function PorcentajeVivienda($iD) {
    $criteria = new CDbCriteria;
    $criteria->select = 't.*';
    // $criteria->join = 'JOIN unidad_habitacional ON  t.unidad_habitacional_id = unidad_habitacional.id_unidad_habitacional AND NOT unidad_habitacional.estatus = 212';
    $criteria->condition = 't.unidad_habitacional_id= :unidad_habitacional';
    $criteria->params = array(":unidad_habitacional" => $iD);
//    var_dump($criteria); die();
    $CantVivienda = Vivienda::model()->count($criteria);
    $porcentaje = round((int) $CantVivienda * 0.17);

    if ((int) $porcentaje == '0') {

        $porcentaje = 1;
    }



    return $porcentaje;
}

function PorcentajeTotalViviendas($cantidad, $censadas)
{
    if($cantidad == 0)
        return 0;
    else{
        $porcentaje = $censadas*100/$cantidad;
//    return ($porcentaje)==0? "0 %": number_format($porcentaje, 2, '.', '')." %";
        return ($porcentaje)==0? 0: round($porcentaje);
    }
}

function Censadas($idUnidadHabitacional) {
    $Asignada = Yii::app()->db->createCommand('SELECT count(vi.*) as result FROM vivienda vi
                    JOIN beneficiario_temporal be ON vi.id_vivienda = be.vivienda_id and be.unidad_habitacional_id = ' . $idUnidadHabitacional . ' and be.estatus = 272 and NOT be.estatus = 193
                    WHERE NOT vi.estatus_vivienda_id = 211')->queryScalar();
    return $Asignada;
}

function GenerarDocumento($idUnidadHabitacional) {
    $criteria = new CDbCriteria;
    $criteria->select = 't.*';
    //$criteria->join = 'JOIN unidad_habitacional ON  t.unidad_habitacional_id = unidad_habitacional.id_unidad_habitacional AND NOT unidad_habitacional.estatus = 212';
    $criteria->condition = 't.unidad_habitacional_id= :unidad_habitacional';
    $criteria->params = array(":unidad_habitacional" => $idUnidadHabitacional);
    $CantVivienda = Vivienda::model()->count($criteria);
    $porcentaje = round((int) $CantVivienda * 0.17);


    /* CANTIDAD DE VIVIENDAS ASIGNADAS Y CON EL CENSO CONFIRMADO PARA ANALISIS DE CREDITO */
    $Asignada = Yii::app()->db->createCommand('SELECT count(vi.*) as result FROM vivienda vi
                    JOIN beneficiario_temporal be ON vi.id_vivienda = be.vivienda_id and be.unidad_habitacional_id = ' . $idUnidadHabitacional . ' and be.estatus = 272 and NOT be.estatus = 193
                    WHERE NOT vi.estatus_vivienda_id = 211')->queryScalar();

    if ((int) $porcentaje == '0') {

        $porcentaje = 1;
    }


    if (((int) $Asignada < $porcentaje)) {
        return FALSE;
    } else {
        return TRUE;
    }
}

function EstatusDocumentoAprobado($idUnidadHabitacional) {
    $sql_documento = 'select uh.id_unidad_habitacional, uh.nombre, uh.estatus as estatus_unidadH, a.estatus as estatus_documentacion from unidad_habitacional uh
                        join documentacion a ON a.fk_beneficiario = ' . $idUnidadHabitacional . ' where a.estatus = 286 ';
//            'select * from desarrollo t join documentacion a ON a.fk_beneficiario =' . $id_desarrollo . 'where a.estatus = 286';
    $queryy = Yii::app()->db->createCommand($sql_documento)->queryScalar();

//    var_dump($queryy);die;

    if ($queryy != null) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function EstatusDocumentoDevuelto($idUnidadHabitacional) {
    $sql_documento = 'select uh.id_unidad_habitacional, uh.nombre, uh.estatus as estatus_unidadH, a.estatus as estatus_documentacion from unidad_habitacional uh
                        join documentacion a ON a.fk_beneficiario = ' . $idUnidadHabitacional . ' where a.estatus = 295 ';
//    $sql_documento = 'select * from desarrollo t join documentacion a ON a.fk_beneficiario =' . $id_desarrollo . 'where a.estatus = 295';
    $queryy = Yii::app()->db->createCommand($sql_documento)->queryScalar();

//    var_dump($queryy);die;

    if ($queryy != null) {
        return TRUE;
    } else {
        return FALSE;
    }
//    var_dump(EstatusDocumentoDevuelto($id_desarrollo));die;
}

function ColorEstatus($color) {


    switch ($color) {
        case "VALIDADO POR SAREN":
            $color = 'aprobado';
            break;
        case "DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)":
            $color = 'devuelto';
            break;
        case "VALIDADO POR BANAVIH (EN ESPERA DE SAREN)":
            $color = 'espera';
            break;
        case 4:
            $color = 'white';
            break;
    }
    return $color;
}
?>

<style>


    .aprobado
    {
        background: #CEF6F5 !important;
    }

    .devuelto {
        background:#F5A9BC !important;
        /*color:#514721 !important;*/
    }
    .espera {
        background:#F5F6CE !important;
        /*color:#514721 !important;*/
    }

</style>

<script>
    $(document).on('ready',function(){
        $(':checkbox:disabled').attr('title', 'No cumple con el porcentaje mínimo de viviendas censadas');
    });
</script>

<!--<h1>Gestión de Unidades Multifamiliares</h1>-->
<h1>Proceso y Gestión de Documentación</h1>
<?php if (Yii::app()->user->checkAccess('administrador_documentacion')) { ?>
    <div class="col-md-3">
        <div class="well">
            <?php
            $criteria = new CDbCriteria;
            $criteria->order = 't.value ASC';
            $criteria->join = 'join cruge_authassignment a ON a.userid = t.iduser';
            $criteria->condition = "a.itemname ='analista_documentacion'";
            echo $form->dropDownListGroup(
                    $asignaciones, 'fk_usuario_asignado', array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-6',
                ),
                'widgetOptions' => array(
                    'data' => CHtml::listData(CrugeFieldValue::model()->findAll($criteria), 'iduser', 'value'),
                    'htmlOptions' => array(
                        //'empty' => 'SELECCIONE',
                        'empty' => 'Selecciones el Analista de Documentación',
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
                                var caso = 309; //caso:309 indica que la asignacion es de un doc_MULTIFAMILIAR
                             
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
<div class="row">

    <div class="col-md-4" >

        <table class="table">
            <!--<tr >-->

            <!--</tr>--> 
            <tr bgcolor="#CEF6F5"><font color="black"><B><center>Leyenda Estatus Documento</center></font></tr>
                <tr>
                    <td bgcolor="#CEF6F5"><font color="black"><center>VALIDADO</center></font></td>
                <td bgcolor="#F5F6CE"><font color="BLACK"><center>EN ESPERA</center></font></td>
                <td bgcolor="#F5A9BC"><font color="BLACK"><center>DEVUELTO</center></font></td>
                </tr> 
        </table>
    </div>
</div>


<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'unidad-habitacional-grid',
    'type' => 'striped bordered condensed',
    'dataProvider' => $modelVswMultifamiliar->search(),
    
    'filter' => $modelVswMultifamiliar,
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn', // Checkboxes
            'selectableRows' => 2, // Allow multiple selections 
            'value' => '$data->id_unidad_habitacional',
            'id' => 'check_analista_doc_multi',
//            'disabled'=>'$data->cantidad==21',
            'disabled'=>'PorcentajeTotalViviendas($data["cantidad"],Censadas($data["id_unidad_habitacional"]))<17',
//            'cssClassExpression'=>'$data->cantidad==21 ? "deshabilitado" : ""',
//            'visible' => '(Yii::app()->user->checkAccess("administrador_documentacion")) && (PorcentajeTotalViviendas($data["cantidad"],Censadas($data["id_unidad_habitacional"])))>=17',
            //'visible' =>'$data->cantidad"==21',
        ),
        //'id_unidad_habitacional',
        'id_unidad_habitacional' => array(
            'header' => 'Unidad Multifamiliar',
            'name' => 'id_unidad_habitacional',
            'value' => '$data->id_unidad_habitacional',
            'htmlOptions' => array('width' => '80', 'style' => 'text-align: center;'),
            //'filter' => false
        ),
        'estado' => array(
            'header' => '<span title="Nombre del Estado">Estado</span>',
            'name' => 'estado',
            'value' => '$data["estado"]',
            'filter' => CHtml::listData(Tblestado::model()->findAll(array('order' => 'strdescripcion ASC')), 'strdescripcion', 'strdescripcion'),
//            'visible'=>'$data->cantidad==21 ? true : false',
//            'visible' =>false,
        ),
        'nombre_desarrollo' => array(
            'header' => '<span title="Nombre del Desarrollo">Desarrollo</span>',
            'name' => 'nombre_desarrollo',
            'value' => '$data["nombre_desarrollo"]',
        //'filter' => CHtml::listData(Desarrollo::model()->findAll(array('order' => 'nombre ASC')), 'nombre', 'nombre')
        ),
        'nombre_unidad_habitacional' => array(
            'header' => '<span title="Nombre de la Unidad Multifamiliar">Unidad Multifamiliar</span>',
            'name' => 'nombre_unidad_habitacional',
            'value' => '$data["nombre_unidad_habitacional"]',
        //'filter' => CHtml::listData(Desarrollo::model()->findAll(array('order' => 'nombre ASC')), 'nombre', 'nombre')
        ),
        'cantidad' => array(
            //'header' => 'Cantidad de viviendas en la Unidad Multifamiliar',
            'header' => '<span title="Cantidad de Viviendas en la Unidad Multifamiliar" style="cursor:pointer">N° Viviendas Registradas</span>',
            'name' => 'cantidad',
            'value' => '$data["cantidad"]',
            'filter' => false
        ),
        'total_para_documentar' => array(
            'header' => '<pan title="Total de viviendas por documentación" style="cursor:pointer">N° Viviendas para Documentar</span>',
            'name' => 'total_para_documentar',
            'value' => ' Censadas($data["id_unidad_habitacional"])',
            'filter' => false
        ),
        'porcentaje_total' => array(
            'header' => '<pan title="Porcentaje de viviendas que cumplen con los requisitos para el Proceso de Documentación" style="cursor:pointer">Porcentaje de Viviendas para Documentar</span>',
            'name' => 'porcentaje',
//            'value' => '($data["cantidad"])==0? (int)0 ." %":PorcentajeTotalViviendas($data["cantidad"],Censadas($data["id_unidad_habitacional"]))." %"',
            'value' => 'PorcentajeTotalViviendas($data["cantidad"],Censadas($data["id_unidad_habitacional"]))." %"',
            'filter' => false
        ),
//        'porcentaje' => array(
//            'header' => '17% de la Unidad Multifamiliar',
//            'name' => 'porcentaje',
//            'value' => 'PorcentajeVivienda($data["id_unidad_habitacional"])',
//            'filter' => false
//        ),
        'estatus_msj' => array(
            'header' => 'Estatus Documento',
            'name' => 'estatus_msj',
            'value' => '$data["estatus_msj"]',
            'cssClassExpression' => 'ColorEstatus($data["estatus_msj"])',
            //'filter' => CHtml::listData(VswMultifamiliar::model()->findall(), 'estatus_msj', 'estatus_msj'),
            'filter' =>  array('VALIDADO POR SAREN'=>"VALIDADO POR SAREN","VALIDADO POR BANAVIH (EN ESPERA DE SAREN)"=>"VALIDADO POR BANAVIH (EN ESPERA DE SAREN)","DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)"=>"DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)"),
        ),
//        'estatus' => array(
//            'header' => 'Estatus de <br/>Asignación',
//            'name' => 'estatus',
//            'value' => 'VswAsignacionesDocumentos::buscarEstatus($data["id_unidad_habitacional"], 3)',
//            //'filter' => false,
//            'filter' => CHtml::listData(VswAsignacionesDocumentos::model()->findall(), 'estatus', 'estatus'),
//            'sortable' => false,
//        ),
        'estatus_asignacion' => array(
            'header' => 'Estatus de <br/>Asignación',
            'name' => 'estatus_asignacion',
            'value' => 'VswAsignacionesDocumentos::buscarEstatus($data["id_unidad_habitacional"], 3)',
            'filter' => false,
            //'filter' => CHtml::listData(VswAsignacionesDocumentos::model()->findall(), 'estatus', 'estatus'),
            //'sortable' => false,
        ),
        'analista' => array(
            'header' => 'Analista Asignado',
            'name' => 'analista',
            'value' => 'VswAsignacionesDocumentos::buscarUsuAsignado($data->id_unidad_habitacional)',
            'filter' => false
        ),
        
        
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'visible' => (Yii::app()->user->checkAccess("analista_documentacion")),
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            'template' => '{documento}{imprimir}{adendum}{editar}',
            'buttons' => array(
                'documento' => array(
                    'label' => 'Generar Documento',
                    'icon' => 'glyphicon glyphicon-file',
                    'size' => 'medium',
                    //'visible' => '((Yii::app()->user->checkAccess("action_unidadhabitacional_pdf") && (GenerarDocumento($data["id_desarrollo"])))',
                    'visible' => '($data["estatus_msj"] == "") && GenerarDocumento($data["id_unidad_habitacional"]) && Yii::app()->user->checkAccess("action_documentacion_multifamiliar")  && !DocumentoExistMulti($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "") && EstatusDocumentoAprobado($data["id_unidad_habitacional"])&& EstatusDocumentoDevuelto($data["id_unidad_habitacional"])',
//                    'visible' => 'GenerarDocumento($data["id_unidad_habitacional"])',
                    'url' => 'Yii::app()->createUrl("Documentacion/generar2", array("id"=>$data["id_unidad_habitacional"]))',
                ),
                'imprimir' => array(
                    'label' => 'Imprimir Documento',
                    'icon' => 'glyphicon glyphicon-print',
                    'size' => 'medium',
                    'url' => 'Yii::app()->createUrl("documentacion/pdf", array("id"=>$data["id_unidad_habitacional"]))',
                    'options' => array("target" => "_blank"),
//                    'visible' => 'DocumentoExistMulti($data["id_unidad_habitacional"]) && EstatusDocumentoAprobado($data["id_unidad_habitacional"])&& !EstatusDocumentoDevuelto($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "VALIDADO POR SAREN")'
                    'visible' => 'DocumentoExistMulti($data["id_unidad_habitacional"]) && EstatusDocumentoAprobado($data["id_unidad_habitacional"]) && !EstatusDocumentoDevuelto($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "VALIDADO POR SAREN") '
                ),
                'adendum' => array(
                    'label' => 'Ver Adendum',
                    'icon' => 'glyphicon glyphicon-share',
                    'size' => 'medium',
                    'url' => 'Yii::app()->createUrl("documentacion/ListarAdendum", array("id"=>$data["id_unidad_habitacional"], "ajax"=>true))',
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
                    'visible' => 'DocumentoExistMulti($data["id_unidad_habitacional"]);'
                ),
                'editar' => array(
                    'label' => 'Ver y Editar Documento',
                    'icon' => 'glyphicon glyphicon-list-alt',
                    'size' => 'medium',
                    'visible' => '($data["estatus_msj"] == "") && DocumentoExistMulti($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "") && !EstatusDocumentoAprobado($data["id_unidad_habitacional"])&& EstatusDocumentoDevuelto($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)") && !EstatusDocumentoAprobado($data["id_unidad_habitacional"])&& EstatusDocumentoDevuelto($data["id_unidad_habitacional"])',
                    'url' => 'Yii::app()->createUrl("Documentacion/multifamiliar", array("id"=>$data["id_unidad_habitacional"]))',
                ),
//                'validar' => array(
//                    'label' => 'Validar',
//                    'icon' => 'ok',
//                    'size' => 'medium',
//                    'options' => array('style' => 'margin-left:28px;',),
//                    'url' => '$data["id_unidad_habitacional"]',
//                    'click' => 'js: function(s){CambiarEstatusDocumento($(this).attr("href"), 1 ,1); return false; }',
//                    'visible' => '($data["estatus_msj"] == "") && DocumentoExistMulti($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "") && !EstatusDocumentoAprobado($data["id_unidad_habitacional"]) && EstatusDocumentoDevuelto($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)") && !EstatusDocumentoAprobado($data["id_unidad_habitacional"])&& EstatusDocumentoDevuelto($data["id_unidad_habitacional"])',
//                    'options' => array(
//                        'style' => 'margin-left:17px;', 'id' => 'cambiarEstatus'
//                    ),
//                ),
                'registral' => array(
                    'label' => 'Datos Magistrales',
                    'icon' => 'glyphicon glyphicon-folder-open',
                    'size' => 'medium',
                    'url' => 'Yii::app()->createUrl("desarrollo/registral", array("id"=>$data["id_desarrollo"]))',
                    //'options' => array("target" => "_blank"),
                    'visible' => 'DocumentoExistMulti2($data["id_desarrollo"]);'
                ),
            ),
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'visible' => (Yii::app()->user->checkAccess("administrador_documentacion")),
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            'template' => '{imprimir} {editar} {validar}',
            'buttons' => array(
                'imprimir' => array(
                    'label' => 'Imprimir Documento',
                    'icon' => 'glyphicon glyphicon-print',
                    'size' => 'medium',
                    'url' => 'Yii::app()->createUrl("documentacion/pdf", array("id"=>$data["id_unidad_habitacional"]))',
                    'options' => array("target" => "_blank"),
//                    'visible' => 'DocumentoExistMulti($data["id_unidad_habitacional"]) && EstatusDocumentoAprobado($data["id_unidad_habitacional"])&& !EstatusDocumentoDevuelto($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "VALIDADO POR SAREN")'
                    'visible' => 'DocumentoExistMulti($data["id_unidad_habitacional"]) && EstatusDocumentoAprobado($data["id_unidad_habitacional"]) && !EstatusDocumentoDevuelto($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "VALIDADO POR SAREN") '
                ),
                'validar' => array(
                    'label' => 'Validar',
                    'icon' => 'ok',
                    'size' => 'medium',
                    'options' => array('style' => 'margin-left:28px;',),
                    'url' => '$data["id_unidad_habitacional"]',
                    'click' => 'js: function(s){CambiarEstatusDocumento($(this).attr("href"), 1 ,1); return false; }',
                    'visible' => '($data["estatus_msj"] == "") && DocumentoExistMulti($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "") && !EstatusDocumentoAprobado($data["id_unidad_habitacional"]) && EstatusDocumentoDevuelto($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)") && !EstatusDocumentoAprobado($data["id_unidad_habitacional"])&& EstatusDocumentoDevuelto($data["id_unidad_habitacional"])',
                    'options' => array(
                        'style' => 'margin-left:17px;', 'id' => 'cambiarEstatus'
                    ),
                ),
                'editar' => array(
                    'label' => 'Ver y Editar Documento',
                    'icon' => 'glyphicon glyphicon-list-alt',
                    'size' => 'medium',
//                    'visible' => '($data["estatus_msj"] == "") && DocumentoExistMulti($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "") && !EstatusDocumentoAprobado($data["id_unidad_habitacional"])&& EstatusDocumentoDevuelto($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)") && !EstatusDocumentoAprobado($data["id_unidad_habitacional"])&& EstatusDocumentoDevuelto($data["id_unidad_habitacional"])',
                    'visible' => '($data["estatus_msj"] == "") && DocumentoExistMulti($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "") && !EstatusDocumentoAprobado($data["id_unidad_habitacional"])&& EstatusDocumentoDevuelto($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)") && !EstatusDocumentoAprobado($data["id_unidad_habitacional"])&& EstatusDocumentoDevuelto($data["id_unidad_habitacional"])',
                    'url' => 'Yii::app()->createUrl("Documentacion/multifamiliar", array("id"=>$data["id_unidad_habitacional"]))',
                ),
//                'registral' => array(
//                    'label' => 'Datos Magistrales',
//                    'icon' => 'glyphicon glyphicon-folder-open',
//                    'size' => 'medium',
//                    'url' => 'Yii::app()->createUrl("desarrollo/registral", array("id"=>$data["id_desarrollo"]))',
//                    //'options' => array("target" => "_blank"),
//                    'visible' => 'DocumentoExistMulti2($data["id_desarrollo"]);'
//                ),
            ),
        ),
    ),
));

//var_dump($data);die;
?>
<?php $this->endWidget(); ?>

<div class="alert" style="color:#000; font-size:13px;">
    <span class="well" style="color: red; padding: 5px">Nota:</span> Sólo se podrán seleccionar aquellas Unidades Multifamiliares que cumplan con los requerimientos mínimos para el proceso de Documentación.
</div>