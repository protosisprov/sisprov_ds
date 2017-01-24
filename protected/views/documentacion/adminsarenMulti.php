<?php

/*
 * VERIFICA SI EXISTE UN DOCUMENTO CREADO
 */
$baseUrl = Yii::app()->baseUrl;
$validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');

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
    $sql = 'SELECT * FROM documentacion WHERE fk_beneficiario=' . $iD . ' AND (tipo_documento_id='.$tipo_documento.' or  tipo_documento_id=277)  AND registro_documento_id IS NULL';
    $query = Yii::app()->db->createCommand($sql)->queryAll();
    if ($query != null)
        return TRUE;
    else
        return FALSE;
}

function PorcentajeVivienda($iD) {
    $criteria = new CDbCriteria;
    $criteria->select = 't.*';
    $criteria->join = 'JOIN unidad_habitacional ON  t.unidad_habitacional_id = unidad_habitacional.id_unidad_habitacional AND NOT unidad_habitacional.estatus = 212';
    $criteria->condition = 'unidad_habitacional.desarrollo_id= :desarrollo';
    $criteria->params = array(":desarrollo" => $iD);
    $CantVivienda = Vivienda::model()->count($criteria);
    $porcentaje = round((int) $CantVivienda * 0.17);

    if ((int) $porcentaje == '0') {

        $porcentaje = 1;
    }


    return $porcentaje;
}

function Censadas($idDesarrollo) {
    $Asignada = Yii::app()->db->createCommand('SELECT count(vi.*) as result FROM vivienda vi
                    JOIN beneficiario_temporal be ON vi.id_vivienda = be.vivienda_id and be.desarrollo_id = ' . $idDesarrollo . ' and be.estatus = 272 and NOT be.estatus = 193
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

?>


<h1>Gestión de Unidades Multifamiliares Saren</h1>



<?php



//var_dump($estado);die;


$this->widget('booster.widgets.TbGridView', array(
    'id' => 'unidad-habitacional-grid-2',
    'type' => 'striped bordered condensed',
    'dataProvider' => new CSqlDataProvider("SELECT id_unidad_habitacional, nombre_unidad_habitacional , estado , sum(cantidad_vivienda) as cantidad , sum(cantidad_vivienda) as porcentaje,
                                            sum(cantidad_vivienda) as total_para_documentar, estatus_msj, observaciones
                FROM vsw_multifamiliar, documentacion a where estado = '".$estado."' and id_unidad_habitacional = a.fk_beneficiario and a.estatus = 285 and a.es_activo = true
                GROUP BY id_unidad_habitacional, nombre_unidad_habitacional , estado, estatus_msj, observaciones", array(
        'keyField' => 'id_unidad_habitacional',
        'sort' => array(
            'attributes' => array(
                'id_unidad_habitacional,nombre_unidad_habitacional', 'estado', 'estatus_msj' // Attributes has to be row name of my sql query result
            ),
        ),
        'pagination' => array(
            'pageSize' => 50,
        ),
            )),
//    'filter' => true,
    
    'columns' => array(
        'id_desarrollo' => array(
            'header' => 'N°',
            'name' => 'id_unidad_habitacional',
            'value' => '$data["id_unidad_habitacional"]',
//            'filter' => CHtml::listData(Desarrollo::model()->findAll(array('order' => 'nombre ASC')), 'nombre', 'nombre')
        ),
        'nombre_desarrollo' => array(
            'header' => 'Nombre de Desarrollo',
            'name' => 'nombre_unidad_habitacional',
            'value' => '$data["nombre_unidad_habitacional"]',
            'filter' => CHtml::listData(Desarrollo::model()->findAll(array('order' => 'nombre ASC')), 'nombre', 'nombre')
        ),
        'estado' => array(
            'header' => 'Estado',
            'name' => 'estado',
            'value' => '$data["estado"]',
            'filter' => CHtml::listData(Tblestado::model()->findAll(array('order' => 'strdescripcion ASC')), 'strdescripcion', 'strdescripcion')
        ),
//        'observaciones' => array(
//            'class' => 'booster.widgets.TbEditableColumn',
//            'name' => 'observaciones',
//            'header' => 'Observaciones',
//            'htmlOptions' => array('style' => 'text-align:center', 'title' => 'Indique alguna observación', 'id' => 'editable'),
//            'headerHtmlOptions' => array('style' => 'width: 110px; text-align: center'),
//            'editable' => array(
//                'type' => 'textarea',
//                'emptytext' => 'indique observaciones',
//                //   'inputclass' => 'input-large',
//                'url' => $this->createUrl('Desarrollo/Actualizar'),
//                'placement' => 'left',
////                'validate' => 'function(value) {
////                             if(!value) return "Disculpe, debe indicar la observación"
////                            }'
//            )
//        ),
        'estatus_msj' => array(
            'header' => 'Estatus Documento',
            'name' => 'estatus_msj',
            'value' => '$data["estatus_msj"]',
            
//            'filter' => CHtml::listData(Desarrollo::model()->findall(), 'id_desarrollo', 'nombre'),
        ),
//        'cantidad' => array(
//            'header' => 'Cantidad de viviendas en el desarrollo',
//            'name' => 'cantidad',
//            'value' => '$data["cantidad"]',
////            'filter' => CHtml::listData(Tblestado::model()->findAll(array('order' => 'strdescripcion ASC')), 'strdescripcion', 'strdescripcion')
//        ),
//        'porcentaje' => array(
//            'header' => '17% del desarrollo',
//            'name' => 'porcentaje',
//            'value' => 'PorcentajeVivienda($data["id_desarrollo"])',
////            'filter' => CHtml::listData(Tblestado::model()->findAll(array('order' => 'strdescripcion ASC')), 'strdescripcion', 'strdescripcion')
//        ),
//        'total_para_documentar' => array(
//            'header' => 'Total de viviendas por documentación',
//            'name' => 'total_para_documentar',
//            'value' => ' Censadas($data["id_desarrollo"])',
////            'filter' => CHtml::listData(Tblestado::model()->findAll(array('order' => 'strdescripcion ASC')), 'strdescripcion', 'strdescripcion')
//        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            'template' => '{editar}{devolver} {validar}',
//            . '{adendum}{editar}',
            'buttons' => array(
//                'documento' => array(
//                    'label' => 'Generar Documento',
//                    'icon' => 'glyphicon glyphicon-file',
//                    'size' => 'medium',
//                    //'visible' => '((Yii::app()->user->checkAccess("action_unidadhabitacional_pdf") && (GenerarDocumento($data["id_desarrollo"])))',
//                    'visible' => 'GenerarDocumento($data["id_unidad_habitacional"]) && Yii::app()->user->checkAccess("action_documentacion_multifamilia")  && !DocumentoExistMulti($data["id_unidad_habitacional"])',
//                    'url' => 'Yii::app()->createUrl("Documentacion/multifamiliar", array("id"=>$data["id_unidad_habitacional"]))',
//                ),
//                'imprimir' => array(
//                    'label' => 'Imprimir Documento',
//                    'icon' => 'glyphicon glyphicon-print',
//                    'size' => 'medium',
//                    'url' => 'Yii::app()->createUrl("documentacion/pdf", array("id"=>$data["id_unidad_habitacional"]))',
//                    'options' => array("target" => "_blank"),
//                    'visible' => 'DocumentoExistMulti($data["id_unidad_habitacional"]);'
//                ),
//                'adendum' => array(
//                    'label' => 'Ver Adendum',
//                    'icon' => 'glyphicon glyphicon-share',
//                    'size' => 'medium',
//                    'url' => 'Yii::app()->createUrl("documentacion/ListarAdendum", array("id"=>$data["id_desarrollo"], "ajax"=>true))',
//                    'imageUrl' => false,
//                    'click' => 'function(e) {
//                                      $("#ajaxModal").remove();
//                                      e.preventDefault();
//                                      var $this = $(this)
//                                        , $remote = $this.data("remote") || $this.attr("href")
//                                        , $modal = $("<div class=\'modal\' id=\'ajaxModal\'><div class=\'modal-body\'><h5 align=\'center\'>&nbsp;  Espere por Favor .. </h5></div></div>");
//                                      $("body").append($modal);
//                                      $modal.modal({backdrop: "static", keyboard: false});
//                                      $modal.load($remote);
//                                    }',
//                    'options' => array('data-toggle' => 'ajaxModal', 'style' => 'padding:4px;'),
//                    'visible' => 'DocumentoExistMulti($data["id_desarrollo"]);'
//                ),
                'editar' => array(
                    'label' => 'Ver',
                    'icon' => 'glyphicon glyphicon-list-alt',
                    'size' => 'medium',
                    'visible' => 'DocumentoExistMulti($data["id_unidad_habitacional"]);',
                    'url' => 'Yii::app()->createUrl("Documentacion/multifamiliar", array("id"=>$data["id_unidad_habitacional"]))',
                ),
                'validar' => array(
                    'label' => 'Conforme',
                    'icon' => 'ok',
                    'size' => 'medium',
                    'options' => array('style' => 'margin-left:28px;',),
                    'url' => '$data["id_unidad_habitacional"]',
                    'click' => 'js: function(s){CambiarEstatusDocumento($(this).attr("href"), 1 ,2); return false; }',
                    'visible' => 'DocumentoExistMulti($data["id_unidad_habitacional"]);',
                    'options' => array(
                        'style' => 'margin-left:17px;', 'id' => 'cambiarEstatus'
                    ),
                ),
                'devolver' => array(
                    'label' => 'Devolver',
                    'icon' => 'remove',
                    'size' => 'medium',
                    'options' => array('style' => 'margin-left:28px;',),
                    'url' => '$data["id_unidad_habitacional"]',
                    'click' => 'js: function(s){CambiarEstatusDocumento($(this).attr("href"), 1 ,6); return false; }',
                    'visible' => 'DocumentoExistMulti($data["id_unidad_habitacional"]);',
                    'options' => array(
                        'style' => 'margin-left:17px;', 'id' => 'cambiarEstatus'
                    ),
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
?>
