
<div class="rows" id="error1" style="display:none">
    <div class="col-md-12">
        <div class="rows">
            <?php
            echo '<div class="alert alert-warning" role="alert" id="sms1">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only" >Error:</span>
            </div>';
            ?>
        </div>
    </div>
</div>

<div class="row">
    <div class='col-md-12'>
        <div class="row">
            <div class='col-md-4'>
                <blockquote style="border-left: 5px solid #1fb5ad !important;font-size: 15px;">
                    <p>
                        <b>Máxima Cuota Financiera:</b> <input type="text" id="coutafinancieramaxima" name="AnalisisCredito[monto_cuota_financiera]" readonly="readonly">
                    </p>
                    <p>
                        <b>Plazo en Meses:    </b>   <input type="text" id="plazomeses" name="AnalisisCredito[nro_cuotas ]" readonly="readonly">                
                    </p>
                    <p>
                        <b>Máxima Capacidad de Pago:</b> <input type="text" id="capacidadpago" name="AnalisisCredito[maxima_capacidad_pago]" readonly="readonly">
                    </p>
                    <p class="subsidiocorre" style="display: none">
                        <b>% Subsidio que le Corresponde:</b> <input type="text" id="subsidiocorrespond" name="AnalisisCredito[subsidio_correponde]" readonly="readonly">
                    </p>
                    <p class="subsidiomax" style="display: none">
                        <b>Subsidio Maximo:</b> <input type="text" id="subsidiomaximo" name="AnalisisCredito[sub_directo_habitacional]" readonly="readonly">
                    </p>
                </blockquote>
            </div>
            <div class='col-md-4'>
                <blockquote style="border-left: 5px solid #1fb5ad !important;font-size: 15px;">
                    <p class="diferenciapago" style="display: none">
                        <b>Capacidad de Pago-PVP de la Vivienda:</b> <input type="text" id="diferenciapago" name="AnalisisCredito[diferencia_pago]" readonly="readonly">
                    </p>
                    <p class="montorestante" style="display: none">
                        <b>Monto restante del Pvp y Sdh:</b> <input type="text" id="montorestante" name="AnalisisCredito[restaCostoAsudsidiar]" readonly="readonly">
                    </p>
                    <p class="reconocimiento" style="display: none">
                        <b>Reconocimiento Vivienda Perdida:</b> <input type="text" id="reconocimientoviperdida" name="AnalisisCredito[sub_vivienda_perdida]" readonly="readonly">
                    </p>
                    <p>
                        <b>Monto del Crédito Requerido:</b>  <input type="text" id="creditorequerido" name="AnalisisCredito[monto_credito]" readonly="readonly">
                    </p>
                    <p>
                        <b>Cuota Inicial del FONGAR:</b>  <input type="text" id="coutainicialfongar" name="AnalisisCredito[monto_prima_inicial_fg]" readonly="readonly">
                    </p>
                </blockquote>
            </div>
            <div class='col-md-4'>
                <blockquote style="border-left: 5px solid #1fb5ad !important;font-size: 15px;">
                    <p>
                        <b>Monto Cuota Financiera Requerida:</b> <input type="text" id="coutafinancrequerida" name="AnalisisCredito[monto_cuota_finan_requerida]" readonly="readonly">
                    </p>
                    <p>
                        <b>% Tasa Fongar:</b> <input type="text" id="tasafongar" name="AnalisisCredito[tasaFongar]" readonly="readonly">
                    </p>
                    <p>
                        <b>Fondo de Garantía Mensual:</b> <input type="text" id="fondogarantia" name="AnalisisCredito[alicuota_fondo_garantia]" readonly="readonly">
                    </p>
                    <p>
                        <b>Cuota Total a  pagar Mensual:</b> <input type="text" id="cuotatotalmensual" name="AnalisisCredito[monto_cuota_f_total]" readonly="readonly">
                    </p>
                    <p>
                        <b>% Máximo de la Cuota Financiera:</b> <input type="text" id="maximacoutafinanciera" name="AnalisisCredito[max_cuota_finan_porct]" readonly="readonly">
                    </p>
                    
                
                    
                    
                    <div style="display:none" id="flatt">
                    <p class="comision"  >
                        <b>% Comision Flat:</b> <input type="text" id="comisionFlat" name="AnalisisCredito[comisionFlat]" readonly="readonly" >
                    </p>
                    </div>
                </blockquote>
            </div>
        </div>
    </div>

</div>