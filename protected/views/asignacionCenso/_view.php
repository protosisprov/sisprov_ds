<?php

//function nombre($selec, $iD) {
//    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
//    return $saime['PRIMER_NOMBRE'];
//}
//
//function apellido($selec, $iD) {
//    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
//    return $saime['PRIMER_APELLIDO'];
//}
//
//function nacionalidadCedula($selec, $select2, $iD) {
//    $saime = ConsultaOracle::getNacionalidadCedulaPersonaByPk($selec, $select2, (int) $iD);
//    return $saime['NACIONALIDAD'] . " - " . $saime['CEDULA'];
//}

$fecha_asignacion = substr($model->fecha_asignacion, 0, 10);
$invert = explode("-", $fecha_asignacion);

$fecha_invert = $invert[2] . "-" . $invert[1] . "-" . $invert[0];


//$asignacionCenso= AsignacionCenso::model()->findAllByAttributes(array('id_asignacion_censo' => $id));
      //  $persona= Persona::model()->findAllByAttributes(array('id_persona' => $model->persona_id)) ;      investigar
       $persona = Persona::model()->findByAttributes(array('id_persona' => $model->persona_id));
//echo '<pre>';
//var_dump($persona);
//die;

?>

<div class="row">
    <div class="col-md-12">
        <h4><i class="glyphicon glyphicon-globe"></i> Lugar a Censar</h4>
        <div class='col-md-6'> 
            <blockquote>
                <p>
                    <b>Estado:</b> <?php echo $model->desarrollo->fkParroquia->clvmunicipio0->clvestado0->strdescripcion ?><br/>
                </p>
                <p>
                    <b>Municipio:</b> <?php echo $model->desarrollo->fkParroquia->clvmunicipio0->strdescripcion ?><br/>
                </p>
                <p>
                    <b>Parroquia:</b> <?php echo $model->desarrollo->fkParroquia->strdescripcion ?><br/>
                </p>
                <p>
                    <b>Nombre del Desarrollo Habitacional:</b> <?php echo $model->desarrollo->nombre ?><br/>
                </p>
                <p>
                    <b>Nombre de la Oficina:</b> <?php echo $model->oficina->nombre ?><br/>
                </p>
                <p>
                    <b>Censado:</b> <?php echo ($model->censado) ? "SI" : "NO" ?><br/>
                </p>
            </blockquote>
        </div>
        
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h4><i class="glyphicon glyphicon-user"></i> Persona Asignada</h4>
        <div class='col-md-8'> 
            <blockquote>
                <p>
                    <b>  Nombre y Apellido:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo "$persona->primer_nombre" .' '. "$persona->primer_apellido" ; ?><br/>
                    <b>Cédula de Identidad:</b> &nbsp;&nbsp;<?php if($persona->nacionalidad == 97){ $nac= "V"; }else{ $nac= "E"; } echo $nac.'-'.$persona->cedula ?><br>
                    
                </p>
            </blockquote>
        </div>
        <div class='col-md-4'> 
            <blockquote>
                <b>Fecha de Asignación:</b> <?php echo Yii::app()->dateFormatter->format("d/M/y - hh:mm a", strtotime($model->fecha_asignacion)) ?><br/>
                </p>
            </blockquote>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h4><i class="glyphicon glyphicon-user"></i> Observaciones del Analista</h4>
        <div class='col-md-8'> 
            <blockquote>
                <p>
                    <b>  Observaciones:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "$model->observaciones" ?><br/>
                    
                </p>
            </blockquote>
        </div>
    </div>
</div>