<?php

//
//function nombre($selec, $iD) {
//    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
//    return $saime['PRIMER_NOMBRE'];
//}
//
////
//function apellido($selec, $iD) {
//    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
//    return $saime['PRIMER_APELLIDO'];
//}

function nacionalidadCedula($selec, $select2, $iD) {
    $saime = ConsultaOracle::getNacionalidadCedulaPersonaByPk($selec, $select2, (int) $iD);
    return $saime['NACIONALIDAD'] . " - " . $saime['CEDULA'];
}

$persona = (object) ConsultaOracle::getPersonaBeneficiario($model->beneficiarioTemporal->nacionalidad, $model->beneficiarioTemporal->cedula);

//echo '<pre>';var_dump($persona);die;

function fechanacimiento($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['FECHA_NACIMIENTO'];
}

?>

<div class="row">
    <div class="col-md-12">

        <h4><i class="glyphicon glyphicon-user"></i> Beneficiario</h4>
        <div class='col-md-6'> 
            <blockquote>

                <b>Cédula:</b> <?php echo nacionalidadCedula('NACIONALIDAD', 'CEDULA', $model->beneficiarioTemporal->persona_id); ?> <br>
                <b>Nombre Completo:</b> <?php echo $model->beneficiarioTemporal->nombre_completo; ?> <br>
                <b>Fecha de Nacimiento:</b> <?php echo $persona->FECHANACIMIENTO; ?> <br>
                <b>Rif:</b> <?php echo $model->rif; ?> <br>

            </blockquote>
        </div>
        <div class="col-md-6">
            <blockquote>
                <b>Estado Civil:</b> <?php echo strtoupper($persona->EDOCIVIL); ?> <br>
                <b>Condición Unidad Familiar:</b> <?php echo $condUnidadFam->condicionUnidadFamiliar->descripcion; ?> <br>
                <b>Fecha Ultimo Censo:</b> <?php echo $model->fecha_ultimo_censo; ?> <br>
            </blockquote>
        </div>
    </div>


</div>

<div class='row'>
    <div class="col-md-12">

        <h4><i class="glyphicon glyphicon-home"></i>Caracteristica del desarrollo</h4>
        <div class='col-md-6'> 
            <blockquote>

                <b>Estado:</b> <?php echo $model->beneficiarioTemporal->desarrollo->fkParroquia->clvmunicipio0->clvestado0->strdescripcion; ?> <br>
                <b>Municipio:</b> <?php echo $model->beneficiarioTemporal->desarrollo->fkParroquia->clvmunicipio0->strdescripcion; ?> <br>
                <b>Parroquia:</b> <?php echo $model->beneficiarioTemporal->desarrollo->fkParroquia->strdescripcion; ?> <br>

            </blockquote>
        </div>
        <div class='col-md-6'> 
            <blockquote>

                <b>Nombre del Desarrollo:</b> <?php echo $model->beneficiarioTemporal->desarrollo->nombre; ?> <br>
                <b>Urbanización/Barrio:</b> <?php echo $model->beneficiarioTemporal->desarrollo->urban_barrio; ?> <br>
                <b>Avenida/Calle/Esquina/Carretera:</b> <?php echo $model->beneficiarioTemporal->desarrollo->urban_barrio; ?> <br>
                <b>zona:</b> <?php echo $model->beneficiarioTemporal->desarrollo->zona; ?> <br>
                <b>Lote terreno Mt2:</b> <?php echo $model->beneficiarioTemporal->desarrollo->lote_terreno_mt2; ?> <br>

            </blockquote>
        </div>
    </div>
    <div class='col-md-12' > 
        <blockquote>

            <b>Nombre Edificación:</b> <?php echo $model->beneficiarioTemporal->unidadHabitacional->nombre; ?> <br> 
            <b>Tipo de Vivienda:</b> <?php echo $model->beneficiarioTemporal->vivienda->tipoVivienda->descripcion; ?> <br>
            <b>Area Vivienda mt2:</b> <?php echo $model->beneficiarioTemporal->vivienda->construccion_mt2; ?> <br>
            <b>Numero de piso:</b> <?php echo $model->beneficiarioTemporal->vivienda->nro_piso; ?> <br>
            <b>Numero de Vivienda:</b> <?php echo $model->beneficiarioTemporal->vivienda->nro_vivienda; ?> 

        </blockquote>
    </div>

</div>
<div class='row'>
    <div class="col-md-12">

        <h4><i class="glyphicon glyphicon-user"></i>Grupo Familiar</h4>
        <div class='col-md-12'>    
            <blockquote>
                <table class="table-bordered table table-responsive table-hover">

                    <thead class="tab-pane">
                    <td>Cédula</td>
                    <td>Nombre y Apellido</td>
                    <td>Fecha de Nacimiento</td>
                    <td>Parentesco</td>
                    <td>Tipo de Persona</td>
                    <?php
                    $idUnidad = UnidadFamiliar::model()->findByAttributes(array('beneficiario_id' => $model->id_beneficiario))->id_unidad_familiar;

                    $criteria = new CDbCriteria;
                    $criteria->addCondition('t.unidad_familiar_id = :unidad_familiar_id');
                    $criteria->params = array(':unidad_familiar_id' => $idUnidad);
                    $grupoFami = GrupoFamiliar::model()->findAll($criteria);
                    foreach ($grupoFami as $fila) {
                        
                        
                        $dia=substr(fechanacimiento('FECHA_NACIMIENTO', $fila->persona_id),0,2);
                        $mes=substr(fechanacimiento('FECHA_NACIMIENTO', $fila->persona_id),3,3);
                        $anio=substr(fechanacimiento('FECHA_NACIMIENTO', $fila->persona_id),7,2 );
                        
                        switch ($mes) {
                            
                            case 'JAN':
                               $mes='ENE';
                            break;
                        
                            case 'APR':
                               $mes='ABR';
                            break;
                             
                            case 'AUG':
                               $mes='AGO';
                            break;
                            
                        }
                    
                       //var_dump(fechanacimiento('FECHA_NACIMIENTO', $fila->persona_id));die;
                        
                        echo "<tr>"
                        . "<td>" . nacionalidadCedula('NACIONALIDAD', 'CEDULA', $fila->persona_id) . "</td>"
                        . "<td>" . Generico::nombreApellido('PRIMER_NOMBRE, PRIMER_APELLIDO', (int) $fila->persona_id) . "</td>"
                        . "<td>" . $dia.'-'.$mes.'-'.$anio . "</td>"
                        . "<td>" . $fila->genParentesco->descripcion . "</td>"
                        . "<td>" . (isset($fila->tipoPersonaFaov->descripcion) ? $fila->tipoPersonaFaov->descripcion : 'NO APLICA') . "</td>"
                        . "</tr>";
                    }
                    ?>
                </table>

            </blockquote>
        </div>
    </div>


</div>
<div class='row'>
    <div class="col-md-12">

        <h4><i class="glyphicon glyphicon-home"></i>Dirección Anterior del Beneficiario</h4>
        <div class='col-md-6'> 
            <blockquote>

                <b> Estado:</b> <?php echo $model->fkParroquia->clvmunicipio0->clvestado0->strdescripcion ?><br/>
                <b> Municipio:</b> <?php echo $model->fkParroquia->clvmunicipio0->strdescripcion ?><br/>
                <b> Parroquia:</b> <?php echo $model->fkParroquia->strdescripcion ?>

            </blockquote>
        </div>
        <div class='col-md-6'> 
            <blockquote>

                <b>Urbanización/Barrio:</b> <?php echo $model->urban_barrio; ?> <br>
                <b>Avenida/Calle/Esquina/Carretera:</b> <?php echo $model->av_call_esq_carr; ?> <br>
                <b>Zona:</b> <?php echo $model->zona; ?> <br>


            </blockquote>
        </div>
    </div>
</div>
<div class='row'>
    <div class="col-md-12">

        <h4><i class="glyphicon glyphicon-home"></i>Datos Laborales</h4>
        <div class='col-md-6'> 
            <blockquote>

                <b>Condicion Trabajo:</b> <?php echo $model->condicionTrabajo->descripcion; ?> <br>
                <b>Fuente de Ingreso:</b> <?php echo $model->fuenteIngreso->descripcion; ?> <br>
                <b>Sector de trabajo:</b> <?php echo $model->sectorTrabajo->descripcion; ?> <br>
                <?php if ($model->relacionTrabajo == '') { ?>
                    <b>Relación Laboral:</b><?php echo 'NO INDICA'; ?> <br>    
                <?php } else { ?>
                    <b>Relación Laboral:</b><?php echo $model->relacionTrabajo->descripcion; ?> <br>    
                <?php } ?>

                <?php if ($model->condicionLaboral == '') { ?>
                    <b>Condición Laboral:</b> <?php echo 'NO INDICA'; ?> <br>
                <?php } else { ?>
                    <b>Condición Laboral:</b> <?php echo $model->condicionLaboral->descripcion; ?> <br>
<?php } ?>

            </blockquote>
        </div>
        <div class='col-md-6'> 
            <blockquote>

                <b>Nombre de la empresa:</b> <?php echo $model->nombre_empresa; ?> <br>
                <b>Dirección de la empresa:</b> <?php echo $model->direccion_empresa; ?> <br>
                <b>Telefono Trabajo:</b> <?php echo $model->telefono_trabajo; ?> <br>
                <b>Ingreso mensual del beneficiario:</b> <?php echo $model->ingreso_declarado; ?> <br>
                <?php if (isset($model->gen_cargo_id)) { ?>
                    <b>Cargo:</b> <?php echo $model->genCargo->descripcion; ?> <br>
<?php } ?>
                <b>Ingreso Integral familiar:</b> <?php echo $model->ingreso_mensual; ?> <br>


            </blockquote>
        </div>
    </div>
</div>

