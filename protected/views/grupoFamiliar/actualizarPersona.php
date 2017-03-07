<?php
$familiar = GrupoFamiliar::model()->findByPk($model);

function nombre($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['PRIMER_NOMBRE'];
}

function apellido($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['PRIMER_APELLIDO'];
}

$Validacion = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/validacion.js');
Yii::app()->clientScript->registerScript('anulacion', "
//    $('#ingreso_mensual').change(function(){
//        $('#gen_parentesco_id').val('');
//        $('#tipo_persona_faov').val('');
//    }),
    $(document).ready(function(){
        var sueldo = '" . $familiar->ingreso_mensual . "';
        var parentesco= '" . $familiar->gen_parentesco_id . "';
        var tipoSujeto = '" . $familiar->tipo_sujeto_atencion . "';
        var TipoPersona = '" . $familiar->tipo_persona_faov . "';
        var TipoDiscapacidad = '".$familiar->tipo_discapacidad."';
            
        $('#ingreso_mensual').val(sueldo);
        $('#gen_parentesco_id').val(parentesco);
        $('#tipo_persona_faov').val(TipoPersona);
        $('#tipo_sujeto_atencion').val(tipoSujeto);
        $('#tipo_discapacidad').val(TipoDiscapacidad);
        
        if(tipoSujeto=='231')
        {
            $('#div_tipo_discapacidad').show('fade');
        }
        

    });
    

    $('#btn-estatus').click(function(){
        ingreso = $('#ingreso_mensual').val();
        parentesco = $('#gen_parentesco_id').val();
        personaFaov = $('#tipo_persona_faov').val();
        sujetoAtencion = $('#tipo_sujeto_atencion').val();
        TipoDiscapacidad = $('#tipo_discapacidad').val();
        id = '" . $model . "';
            
        if(parentesco == ''){
            bootbox.alert('Indique un parentesco.');
            return false;
        }
        if(personaFaov == ''){
            bootbox.alert('Indique el tipo de Persona.');
            return false;
        }
        if(ingreso == ''){
            bootbox.alert('Sumistre un ingreso mensual.');
            return false;
        }
        
        if(sujetoAtencion == '231')
        {
            if(TipoDiscapacidad == '')
            {
                bootbox.alert('Seleccione Tipo de Discapacidad.');
                return false;
            }
        }
        
        $.ajax({
            url: '" . Yii::app()->createAbsoluteUrl('ValidacionJs/UpdateFamiliar') . "',
            async: true,
            type: 'POST',
            data: 'ingreso='+ingreso+ '&parentesco=' + parentesco+ '&personaFaov=' + personaFaov+ '&sujetoAtencion=' + sujetoAtencion+ '&id=' + id + '&TipoDiscapacidad=' + TipoDiscapacidad,
            success: function(data){
                if(data == 1){
                    $(location).attr('href', '" . $this->createUrl('/grupoFamiliar/update/', array('id' => $familiar->unidad_familiar_id)) . "');
                }
            },
        });
            
    });
");
?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-center"><?= nombre("PRIMER_NOMBRE", $familiar->persona_id) . ' ' . apellido("PRIMER_APELLIDO", $familiar->persona_id) ?></h4>
        </div>
        <div class="modal-body">
            <div class="row well-large">
                <div class="col-sm-6">
                    <label>Parentesco</label>
                    <select id="gen_parentesco_id" class="form-control" name="GrupoFamiliar[gen_parentesco_id]" placeholder="Parentesco" onchange="aceptanteupdate($(this).val())">
                        <?php
                        $estatus = Maestro::FindMaestrosByPadreSelect(149);
                        echo '<option value="">SELECCIÓN</option>';
                        foreach ($estatus as $data => $value):
                            echo '<option value="' . $data . '">' . $value . '</option>';
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label>Tipo de Persona</label>
                    <select id="tipo_persona_faov" class="form-control" name="GrupoFamiliar[tipo_persona_faov]" placeholder="Tipo de persona" disabled="disabled">
                        <?php
                        $estatush = Maestro::FindMaestrosByPadreSelect(234);
                        echo '<option value="">SELECCIÓN</option>';
                        foreach ($estatush as $datah => $valueh):
                            echo '<option value="' . $datah . '">' . $valueh . '</option>';
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="well-small row">
                <div class="col-sm-6">
                    <label>¿Posee Discapacidad?</label>
                    <select id="tipo_sujeto_atencion" class="form-control" name="GrupoFamiliar[tipo_sujeto_atencion]" placeholder="Tipo Sujeto Atencion" onChange="Tipo_discapacidad_update()">
                        <option value="231">SI</option>
                        <option value="">NO</option>
                    </select>
                </div>
                
                <div class="col-sm-6">
                    <label>Ingreso Mensual</label>
                    
                    <input id="ingreso_mensual" class="span5 form-control" type="text" name="GrupoFamiliar[ingreso_mensual]" placeholder="Ingreso Mensual" maxlength="16">
                </div>
            </div>    
                
            <div class="well-small row">
                <div class="col-md-6" style="display: none" id="div_tipo_discapacidad">
                    <label>Tipo de Discapacidad</label>
                    
                    <?php echo CHtml::dropDownList('tipo_discapacidad', '', CHtml::listData(Maestro::model()->findAll("padre=231"),'id_maestro', 'descripcion'),
                            array('empty' => 'SELECCIONE','class'=>'form-control')
                        ); ?>
                </div>
                
                <div class="col-md-6"></div>
            </div>
            
            <div style="margin-bottom:5%"></div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" id="btn-estatus" href="#" data-dismiss="modal">Aceptar</button>
            <button class="btn btn-danger" href="#" data-dismiss="modal">Cancelar</button>
        </div>
    </div>
</div>