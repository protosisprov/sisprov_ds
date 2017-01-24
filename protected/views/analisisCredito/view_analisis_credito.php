

      

<?php

function nacionalidadCedula($selec, $select2, $iD) {
    $saime = ConsultaOracle::getNacionalidadCedulaPersonaByPk($selec, $select2, (int) $iD);
    return $saime['NACIONALIDAD'] . " - " . $saime['CEDULA'];
}

$persona = (object) ConsultaOracle::getPersonaBeneficiario($model->beneficiarioTemporal->nacionalidad, $model->beneficiarioTemporal->cedula);

function fechanacimiento($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['FECHA_NACIMIENTO'];
}
?>

<?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); ?>
<div class="panel-group" id="accordion">
    <div class="row">
        <div class="col-md-12">

            <div class="row">
                <div class="col-md-12">
                    <div>
                        <?php // var_dump($unidadUni);die;    ?>
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTress">
                            <h4>&nbsp;&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-credit-card"></i> Análisis de Crédito</h4>
                        </a>
                        <div id="collapseTress" class="panel-collapse collapse in">
                            <div class='col-md-4'> 
                                <?php
                                foreach ($credito AS $analisis) {
                                    
                                }
                                ?> 
                                <blockquote class="bs-callout bs-callout-info"> 
                                    <p>

                                        <b>Ingreso Familiar:</b> <?php echo $analisis->ingreso_total_familiar; ?> <br>
                                        <b>Monto del Credito:</b> <?php echo $analisis->monto_credito; ?> <br>
                                        <b>Monto Inicial:</b> <?php echo $analisis->monto_inicial; ?> <br>
                                        <b>Sub. Directo Habitacional:</b> <?php echo $analisis->sub_directo_habitacional; ?> <br>
                                        <b>Sub.Vivienda Perdida:</b> <?php echo $analisis->sub_vivienda_perdida; ?> <br>
                                        <b>Plazo Credito Año:</b> <?php echo $analisis->plazo_credito_ano; ?> <br>







                                    </p>
                                </blockquote>
                            </div>
                            <!--</div>-->
                            <div class='col-md-4'> 
                                <!--<div id="collapseTress" class="panel-collapse collapse">-->

                                <blockquote class="bs-callout bs-callout-info"> 
                                    <p>

                                        <b>Diferencia de Pago:</b> <?php echo $analisis->diferencia_pago; ?> <br>
                                        <b>Fongar:</b> <?php echo $analisis->alicuota_fondo_garantia; ?> <br>
                                        <b>Tasa Interés:</b> %<?php echo $analisis->tasaInteres->tasa_interes; ?><br/>
                                        <?php $tasainteres = $analisis->tasaInteres->tasa_interes;?>
                                        <b>Tasa Fongar:</b> <?php echo $analisis->tasa_fongar_id; ?> <br>
                                        <b>Fuente de Financiamiento:</b> <?php echo $analisis->fuente_financiamiento_id; ?> <br>
                                        <b>Número de Cuotas:</b> <?php echo $analisis->nro_cuotas; ?> <br>



                                    </p>
                                </blockquote>
                                <!--</div>-->
                            </div>
                            <div class='col-md-4'> 
                                <!--<div id="collapseTress" class="panel-collapse collapse">-->

                                <blockquote class="bs-callout bs-callout-info"> 
                                    <p>



                                        <b>Monto Cuota Financiera:</b> <?php echo $analisis->monto_cuota_financiera; ?> <br>
                                        <b>Monto Cuota_Financiera Total:</b> <?php echo $analisis->monto_cuota_f_total; ?> <br>
                                        <b>Monto Prima Inicial Fongar:</b> <?php echo $analisis->monto_prima_inicial_fg; ?> <br>
                                        <b>Programa:</b> <?php echo $analisis->programa->nombre_programa; ?> <br>
                                        <b>Maxima Capacidad de Pago:</b> <?php echo $analisis->maxima_capacidad_pago; ?> <br>
                                        <b>Monto Cuota Financiera Requerida:</b> <?php echo $analisis->monto_cuota_finan_requerida; ?> <br>




                                    </p>
                                </blockquote>
                                <!--</div>-->
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!--<div>-->
                    <?php // var_dump($unidadUni);die; ?>
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">

                        <h4>&nbsp;&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i> Datos Personales</h4>

                    </a>
                    <div id="collapseOne" class="panel-collapse collapse">
                        <div class='col-md-6'> 
                            <blockquote class="bs-callout bs-callout-warning"> 
                                <p>
                                    <b>Nombre Completo:</b> <?php echo $model->beneficiarioTemporal->nombre_completo; ?> <br>
                                    <?php $cedula =  nacionalidadCedula('NACIONALIDAD', 'CEDULA', $model->beneficiarioTemporal->persona_id);
 
                                    ?>
                                    <b>Cédula:</b> <?php echo nacionalidadCedula('NACIONALIDAD', 'CEDULA', $model->beneficiarioTemporal->persona_id); ?> <br>
                                    <b>Fecha de Nacimiento:</b> <?php echo $persona->FECHANACIMIENTO; ?> <br>
                                    <b>Rif:</b> <?php echo $model->rif; ?> <br>

                                </p>
                            </blockquote>
                        </div>
                        <div class='col-md-6'> 
                            <blockquote class="bs-callout bs-callout-warning"> 
                                <p>

                                    <b>Estado Civil:</b> <?php echo strtoupper($persona->EDOCIVIL); ?> <br>
                                    <b>Condición Unidad Familiar:</b> <?php echo $condUnidadFam->condicionUnidadFamiliar->descripcion; ?> <br>
                                    <?php $condunidadf = $condUnidadFam->condicionUnidadFamiliar->descripcion; ?>
                                    <b>Fecha Ultimo Censo:</b> <?php echo $model->fecha_ultimo_censo; ?> <br>
                                </p>
                            </blockquote>
                        </div>

                        <!--</div>-->


                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-12">
                    <div>
                        <?php // var_dump($unidadUni);die;    ?>
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTres">
                            <h4>&nbsp;&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-home"></i> Conjunto de Desarrollo</h4>
                        </a>
                        <div id="collapseTres" class="panel-collapse collapse">
                            <div class='col-md-6'> 
                                <blockquote class="bs-callout bs-callout-info"> 
                                    <p>

                                        <b>Estado:</b> <?php echo $model->beneficiarioTemporal->desarrollo->fkParroquia->clvmunicipio0->clvestado0->strdescripcion; ?> <br>
                                        <b>Municipio:</b> <?php echo $model->beneficiarioTemporal->desarrollo->fkParroquia->clvmunicipio0->strdescripcion; ?> <br>
                                        <b>Parroquia:</b> <?php echo $model->beneficiarioTemporal->desarrollo->fkParroquia->strdescripcion; ?> <br>
                                        <b>Nombre del Desarrollo:</b> <?php echo $model->beneficiarioTemporal->desarrollo->nombre; ?> <br>
                                        <b>Urbanización/Barrio:</b> <?php echo $model->beneficiarioTemporal->desarrollo->urban_barrio; ?> <br>
                                        <b>Avenida/Calle/Esquina/Carretera:</b> <?php echo $model->beneficiarioTemporal->desarrollo->urban_barrio; ?> <br>
                                        <b>zona:</b> <?php echo $model->beneficiarioTemporal->desarrollo->zona; ?> <br>



                                    </p>
                                </blockquote>
                            </div>
                            <div class='col-md-6'> 
                                <blockquote class="bs-callout bs-callout-info"> 
                                    <p>


                                        <b>Lote terreno Mt2:</b> <?php echo $model->beneficiarioTemporal->desarrollo->lote_terreno_mt2; ?> <br>
                                        <b>Nombre Edificación:</b> <?php echo $model->beneficiarioTemporal->unidadHabitacional->nombre; ?> <br> 
                                        <b>Tipo de Vivienda:</b> <?php echo $model->beneficiarioTemporal->vivienda->tipoVivienda->descripcion; ?> <br>
                                        <b>Area Vivienda mt2:</b> <?php echo $model->beneficiarioTemporal->vivienda->construccion_mt2; ?> <br>
                                        <b>Numero de piso:</b> <?php echo $model->beneficiarioTemporal->vivienda->nro_piso; ?> <br>
                                        <b>Numero de Vivienda:</b> <?php echo $model->beneficiarioTemporal->vivienda->nro_vivienda; ?> <br>
                                        



                                    </p>
                                </blockquote>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


        </div>
    </div>

    <?php $this->endWidget(); ?>

    
      <?php
        $id_credito = $credito[0]['id_analisis_credito'];
        
        $id_beneficiario = $model->id_beneficiario;
        
        ?>


<div class="form-actions text-right">
    <div class="btn-group btn-group-lg">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'button',
            'context' => 'danger',
            'icon' => 'step-backward',
            'label' => 'Regresar',
            'htmlOptions' => array(
                'onclick' => 'document.location.href ="javascript:window.history.back();";'
            ),
        ));
        
        ?>
        </div>
        <div class="btn-group btn-group-lg">
    
            <?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'button',
		'icon' => 'floppy-save',
		'size' => 'large',
		'context'=>'success',
		'label'=>'Generar Excel', 
                'htmlOptions' => array(
                    'onclick' => 'document.location.href ="' . $this->createUrl('/analisisCredito/armandoExcel', array('id_credito'=>$id_credito, 'id_beneficiario' => $id_beneficiario, 'cedula' => $cedula, 'condunidadf'=> $condunidadf, 'tasainteres' => $tasainteres)) . '"',
            ),
	)); ?>
    </div>   
</div>    
