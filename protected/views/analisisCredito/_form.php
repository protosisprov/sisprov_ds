<?php
echo $form->hiddenField($model, 'vivienda_id', array('value' => $beneficiario->beneficiarioTemporal->vivienda->id_vivienda));
echo $form->hiddenField($model, 'unidad_familiar_id');



?>
<div class='row' style="display: none" id='subsidioInfo'>    
    <div class='col-md-12 col-sm-12 col-xs-12'>    
        <div class="alert alert-warning" role="alert" id="sms">
            <span aria-hidden="true"></span>
        </div>
    </div>
</div>
<div class='row'>
    <!--------------- Costo de la vivienda ---------------------->
    <div class='col-md-2'>
        <?php echo $form->textFieldGroup($model, 'costo_vivienda', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'readonly' => 'readonly')))); ?>
    </div>
    <div class='col-md-1'>
        <br>
        <a style="display:none" href="javascript:;" id="editMonto"><i class="glyphicon glyphicon-edit">Editar <br>Costo vivienda</i></a>
    </div>

    <!--------------- Fin del costo de la vivienda ---------------------->

    <div class='col-md-3'>
        <?php echo $form->textFieldGroup($model, 'monto_inicial', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
    </div>
    <!--<div class='col-md-4'>-->
    <!--</div>-->
    <div class='col-md-3 reconocimiento' style="display: none">
        <?php echo CHtml::activeLabel($model, 'reconocimiento'); ?><br>
        <?php
        $this->widget('booster.widgets.TbSwitch', array('name' => 'reconocimiento',
            'model' => $model,
            'options' => array(
                'size' => 'large',
                'onText' => 'SI',
                'offText' => 'NO',
            ),
            'htmlOptions' => array(
        )));
        ?> 
    </div>
    <div class='col-md-3'>





        <?php echo CHtml::activeLabel($model, 'cuota_extraordinarias'); ?><br>
        <?php
        $this->widget('booster.widgets.TbSwitch', array('name' => 'cuota_extraordinarias',
            'model' => $model,
            'options' => array(
                'size' => 'large',
                'onText' => 'SI',
                'offText' => 'NO',
            ),
            'htmlOptions' => array(
        )));
        ?> 
    </div>
</div>
<!--<div class='row' style="margin-bottom: 2%"></div>-->
<br>
<div class='row'>
    <div class='col-md-6' id='ingreso_declarado'> 
        <table class="table table-bordered"><?php echo $TableSueldo ?>


            <tr>

                <?php echo $td_benef;
                ?>




                <td>

                    <?php
                    
                    //var_dump($beneficiario);die;
                    $this->widget('booster.widgets.TbEditableField', array(
                    
                        'type' => 'text',
                        'model' => $beneficiario,
                        'attribute' => 'ingreso_mensual_nuevo',
                        'url' => $this->createUrl('Beneficiario/Actualizar'),
                        'placement' => 'right',
                        'emptytext' => '0.00',
           
                    
                    
                        'onSave' => 'js: function(event, params) {
                            setTimeout("location.reload()", 0);
                         }'
                    ));
                    
                    
                    ?>         
                    <input type="radio" name="opciones_0" id="opciones"   value="<?php echo $beneficiario->ingreso_mensual_nuevo; ?>">

                </td>
                </tr>




            <?php
            $i = 1;
            $conut_id = 1;
            foreach ($grupoFamiliar AS $fila) {



                //$consultafaov = ConsultaOracle::getFaov($fila->persona_id, 1);



                $cant_fam = count($grupoFamiliar);
                $modelGrup = new GrupoFamiliar;
                $nombregrfamiliar = Generico::nombreApellido('PRIMER_NOMBRE, PRIMER_APELLIDO', (int) $fila['persona_id']); //consulta oracle para traerme el nombre y apellido de la persona por persona_id
                echo '<tr><td>' . $nombregrfamiliar . '</td><td> Bs.' . $fila['ingreso_mensual'] .
                '<input class="a"  type="radio" name="opciones_' . $conut_id . '" id="opciones_' . $conut_id . '"   value="' . $fila['ingreso_mensual'] . '"></td>'
                . '<td>';
//                $this->widget("booster.widgets.TbEditableField", array("type" => "text",  "emptytext" => "0.00","model" => $fila, "attribute" => "ingreso_mensual_nuevo", 'url' => $this->createUrl('GrupoFamiliar/Actualizar'),
//                    'placement' => 'right', "pk" => (int) $fila["id_grupo_familiar"], 'onSave' => 'js: function(event, params) {setTimeout("location.reload()", 0);}'));
//
//                echo ' <input type="radio" name="opciones_' . $conut_id . '" id="opciones_0" value="' . $fila['ingreso_mensual_nuevo'] . '"></td></tr>';




                $conut_id++;
            }
            ?>





        </table>

    </div>
    <div class='col-md-6' ><?php echo $TableSueldoFaov ?></div>
</div>
<br>
<div class='row'>
    <div class='col-md-4'>
        <label>Total Ingresos </label>
        <!--<input type="number" step="any" step="5"  max="35" min="2" class="span5 form-control" placeholder="Plazo Credito Ano" name="AnalisisCredito[plazo_credito_ano]" id="AnalisisCredito_plazo_credito_ano">-->
        <input type="text" class="span5 form-control" placeholder="Total Ingreso" name="AnalisisCredito[total]" id="total" maxlength="2" readonly="readonly">
    </div>
    
    
    <div class='col-md-3' id="flat1">





        <?php echo CHtml::activeLabel($model, 'flat'); ?><br>
        <?php
        $this->widget('booster.widgets.TbSwitch', array('name' => 'flat',
            'model' => $model,
            'options' => array(
                'size' => 'large',
                'onText' => 'SI',
                'offText' => 'NO',
             
                           
                       
            ),
            'htmlOptions' => array(
                'class' => 'flat',
                'onChange' => 'MostrarFlat()',
        )));
        ?> 
    </div>
    
</div>
    
 
<div class='row'>
    <div class='col-md-4'>
        <br>
        <?php
        $criteria = new CDbCriteria;
        $criteria->order = 'id_tasa_interes ASC';
        echo $form->dropDownListGroup($model, 'tasa_interes_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-4',),
            'widgetOptions' => array(
                'data' => CHtml::listData(TasaInteres::model()->findAll($criteria), 'id_tasa_interes', 'tasa_interes'),
                'htmlOptions' => array(
                    'empty' => 'SELECCIONE',
                    'readonly' => 'true'
                ),
            )
                )
        );
        ?>
    </div>
    <div class='col-md-4'>
        <br>
        <?php
        echo $form->dropDownListGroup($model, 'plazo_credito_ano', array('wrapperHtmlOptions' => array('class' => 'col-sm-4',),
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'empty' => 'SELECCIONE',
                ),
            )
                )
        );
        ?>
    </div>
    <div class='col-md-4'>
        <br>
        <?php
        echo $form->datePickerGroup($model, 'fecha_protocolizacion', array('widgetOptions' =>
            array(
                'options' => array(
                    'language' => 'es',
                    'format' => 'dd/mm/yyyy',
                    'startView' => 0,
                    'minViewMode' => 0,
                    'todayBtn' => 'linked',
                    'weekStart' => 0,
                    'endDate' => 'now()',
                    'autoclose' => true,
                ),
                'htmlOptions' => array('readonly'=>'readonly',
                /* 'class' => 'span5 limpiar', */
                ),
            ),
            'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
            'beforeShowDay' => 'DisableDays',
                )
        );
        ?>
    </div>
</div>



<div class="row text-center">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'context' => 'success',
        'label' => 'Generar Cálculo',
        //'size' => 'large',
        'id' => 'CalcCalculo',
        'icon' => 'search',
        'htmlOptions' => array(
            'onclick' => 'CalcularAnalisis()'
        )
    ));
    ?>

</div>


<?php $Validacion = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/js_jquery.numeric.js'); ?>
<?php
$id = $beneficiario->id_beneficiario;
$condicionFamiliar = UnidadFamiliar::model()->findByAttributes(array('beneficiario_id' => $id));

Yii::app()->clientScript->registerScript('desarrolloVal', "
         $(document).ready(function(){
         

            if($('#Desarrollo_fuente_financiamiento_id').val()==3){ //FASP
               $('#flat1').hide();
                $('#ingreso_faov').show();
               
                }else{
                $('#flat1').show();
                $('#ingreso_faov').hide();
                }
         
            var select = '<select id=\'myselect3\'>';
            select+='<option value=\'\'>SELECCIONE</option>';
            if($('#Desarrollo_fuente_financiamiento_id').val()==3){ //FASP
                for(var i = 11; i<=35;i++){
                    select+='<option value='+i+'>'+i+'</option>';
                }
                

                
                /******************************* BUSCA DE LAS CONDICIONES DEL GRUPO FAMILIAR DEL BENEFICIARIO  **************************************/
                $.ajax({
                    url: '" . Yii::app()->createAbsoluteUrl('AnalisisCredito/Condiciones') . "',
                    async: true,
                    type: 'POST',
                    data: 'idUnidadFamiliar=' + $('#AnalisisCredito_unidad_familiar_id').val() ,
                    dataType: 'json',
                    success: function(data) {
                    $('#subsidioInfo').show();
                        $('#sms').html(data);
                    },
                    error: function(data) {
                        $('.loader').fadeOut('slow');
                        bootbox.alert('Ha Ocurrido un error en el momento de cargar la informaciÃƒÂ³n.');
                    }
                });
                /******************************************************** FIN  ***********************************************************************/
            }else{ //FAOV AND OTHER
                for(var i = 11; i<=35;i++){
                    select+='<option value='+i+'>'+i+'</option>';
                }
            }
            $('#AnalisisCredito_plazo_credito_ano').html(select);
            
            var condicion ='" . $condicionFamiliar->condicion_unidad_familiar_id . "';
                if(condicion == 140){
                    $('#reconocimiento').bootstrapSwitch('state', true);
                    $('#reconocimiento').bootstrapSwitch('disabled', true);
                }   else {
                    $('#reconocimiento').bootstrapSwitch('state', false);
                }
            $('#AnalisisCredito_plazo_credito_ano').numeric(); 
            $('#AnalisisCredito_monto_inicial').numeric();
            $('#AnalisisCredito_monto_inicial').val('0.00'); 
            $('#ingreso_mensual_nuevo').numeric();
            $('#ingreso').val('0.00'); 
            $('#AnalisisCredito_costo_vivienda').numeric();
            $('#AnalisisCredito_costo_vivienda').val('" . $beneficiario->beneficiarioTemporal->vivienda->precio_vivienda . "');
            if($('#Desarrollo_fuente_financiamiento_id').val()== 3){
                $('.reconocimiento').show();
            }else{
                $('.reconocimiento').hide();
            }
            /*** ********************/
            if($('#AnalisisCredito_costo_vivienda').val()=='0.00'){
                $('#editMonto').show();
                $('#CalcCalculo').hide();
                $('#AnalisisCredito_costo_vivienda').attr('readonly', false);
            }else{
                $('#editMonto').hide();
                $('#CalcCalculo').show();
            }
            
          
            

        }); // FIN DEL DOCUMENT READY
        
        /************ Update de costo de la vivienda ***************/

        
        $('#editMonto').click(function(){
            var costoVivienda = $('#AnalisisCredito_costo_vivienda').val() ;
            if( costoVivienda =='0.00' || costoVivienda == '' || costoVivienda =='0'){
                bootbox.alert('Debe indicar el costo de la vivienda');
                return false;
            }else{
                $.ajax({
                    url: '" . Yii::app()->createAbsoluteUrl('Vivienda/UpdateMontoVivienda') . "',
                    async: true,
                    type: 'POST',
                    data: 'costoVivienda=' +costoVivienda + '&idVivienda=' +" . $beneficiario->beneficiarioTemporal->vivienda->id_vivienda . " ,
                    dataType: 'json',
                    error: function(data) {
                        $('#editMonto').hide();
                        $('#CalcCalculo').show();
                        $('#AnalisisCredito_costo_vivienda').attr('readonly', true);
                        bootbox.alert('Precio de la vivienda actualizado');
                       
                    }
                    
                });


            }
        });
        /************ Fin Update de costo de la vivienda ***************/
        

        $('#Desarrollo_fuente_financiamiento_id').change(function(){
            var select = '<select id=\'myselect3\'>';
            select+='<option value=\'\'>SELECCIONE</option>';
            if($(this).val()==3){ //FASP
                $('.reconocimiento').show();
                
                for(var i = 11; i<=35;i++){
                    select+='<option value='+i+'>'+i+'</option>';
                }

            }else{ //FAOV AND OTHER
                $('.reconocimiento').hide();
                for(var i = 11; i<=30;i++){
                    select+='<option value='+i+'>'+i+'</option>';
                }
            }
            $('#AnalisisCredito_plazo_credito_ano').html(select);
        });
        
");
?>


<script>

    $(document).ready(function (e) {
        var $inRadio = $("#analisis-credito-form").find("input[type='radio']");
        var $inResultado = $("#analisis-credito-form").find("#total");
        var $valores = {};
        
        $inRadio.on("change", function () {

            var $valor = +$(this).val();
            var $nombre = $(this).attr("name");

            $valores["" + $nombre + ""] = $valor;

            var $suma = 0;

            $.each($valores, function (indice, $valorArray) {
                $suma = +$suma + $valorArray;

            });
 
        $inResultado.val($suma);
        });
       
              //if ($suma) == '' ) {
//        alert('Indique los Ingresos');
//        return false;
        
    });


</script>
