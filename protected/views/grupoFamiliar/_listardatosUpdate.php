<?php

function nombre($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['PRIMER_NOMBRE'];
}

function apellido($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['PRIMER_APELLIDO'];
}

function parentesco($valor) {
    switch ($valor) {
        case 'C':
            return 'CONYUGE';
            break;
        case 'M':
            return 'MADRE';
            break;
        case 'P':
            return 'PADRE';
            break;
        case 'H':
            return 'HIJO(A)';
            break;
        case 'E':
            return 'HERMANO(A)';
            break;
        case 'S':
            return 'SUEGRO(A)';
            break;
        case 'A':
            return 'ABUELO(A)';
            break;
        case 'B':
            return 'SOBRINO(A)';
            break;
        case 'I':
            return 'TIO(A)';
            break;
        case 'U':
            return 'TUTELADOR(A)';
            break;
    }
}
?>
<div class="row">
    <div class='col-md-12'>
        <?php
        $this->widget(
                'booster.widgets.TbExtendedGridView', array(
            'type' => 'striped bordered',
            'responsiveTable' => false,
            'id' => 'listado_familiar',
            'dataProvider' => new CActiveDataProvider('GrupoFamiliar', array(
                'criteria' => array(
//                    'with' => array(
//                        'unidadFamiliar' => array(
//                            'condition' => 'beneficiario_id=' . $_GET['id'],
//                        ),
//                    ),
                    'condition' => 't.estatus=41 and unidad_familiar_id=' . $_GET['id'],
                ),
//                'criteria' => array(
//                    'condition' => 'unidad_familiar_id=' . $_GET['id'],
//                ),
                'pagination' => false,
                    )),
//            'template' => "{items}",
            'columns' => array(
                array(
                    'name' => 'persona_id',
                    'header' => 'Nombre',
                    'value' => 'nombre("PRIMER_NOMBRE",$data->persona_id)',
                ),
                array(
                    'name' => 'persona_id',
                    'header' => 'Apellido',
                    'value' => 'apellido("PRIMER_APELLIDO",$data->persona_id)',
                ),
                array(
                    'name' => 'persona_id',
                    'header' => 'Parentesco',
                    'value' => '$data->genParentesco->descripcion',
                ),
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'header' => 'Acciones',
                    'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
                    'template' => '{update}{eliminar}',
                    'buttons' => array(
                        'update' => array(
                            'label' => 'Actualización',
                            'icon' => 'pencil',
                            'size' => 'medium',
                            'url' => 'Yii::app()->createUrl("grupoFamiliar/ActualizarPersona", array("id"=>$data->id_grupo_familiar, "ajax"=>true))',
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
                        ),
                        'eliminar' => array(
                            'label' => 'eliminar',
                            'icon' => 'glyphicon glyphicon-trash',
//                            'size' => 'medium',
//                            'visible' => '((Yii::app()->user->checkAccess("action_grupofamiliar_DeleteGrupoFamiliar")))',
                            'url' => 'Yii::app()->createUrl("grupoFamiliar/deleteGrupoFamiliar", array("id"=>$data->id_grupo_familiar))',
                        ),

                    ),
                ),
            ),
                )
        );
        ?>
    </div>
</div>