<section class="row">
    <h1 class="page-header">Estadisticas de Desarrollos Habitacionales</h1>
</section>

<section class="row" >
    <div class="col-lg-4 col-md-35">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div><?php echo CHtml::link('Cantidad de Desarrollos Habitacionales por Ubicación Geografica', array('estadisticas/desarrollosUbicacionGeografica'));
?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-35">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php //echo $count_unidades_habitacionales;     ?></div>
                        <div><?php echo CHtml::link('Cantidad de Desarrollos Habitacionales por Fuente de Financiamiento', array('estadisticas/desarrollosFuenteFinanciamiento'));
?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-35">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div><?php echo CHtml::link('Cantidad de Unidades MultiFamiliares por Tipo de Inmueble', array('estadisticas/MultifamiliarTipo'));
?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="row">
    <div class="col-lg-6 col-md-40">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div><?php echo CHtml::link('Cantidad de Unidades Familiares (Viviendas) por Tipo de Inmueble', array('estadisticas/UnidadfamiliarTipo'));
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-40">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div><?php echo CHtml::link('Cantidad de Unidades Multifamiliares Disponibles (No Adjudicados), con Censo Parciales (No Completos) ó sin realizar', array('estadisticas/disponibilidadUnidadHabitacional'));
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<hr>

<section class="row">
    <h1 class="page-header">Estadisticas de Adjudicados</h1>
</section>

<section class="row" >
    <div class="col-lg-4 col-md-35">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div><?php echo CHtml::link('Cantidad de Beneficiarios por Ubicación Geografica', array('estadisticas/beneficiariosUbicacionGeografica'));
?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--    <div class="col-lg-4 col-md-35">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php //echo $count_unidades_habitacionales;     ?></div>
                        <div><?php //echo CHtml::link('Cantidad de Adjudicados por Fuente de Ingreso', array('estadisticas/beneficiarioFuenteIngreso'));
?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <div class="col-lg-4 col-md-35">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php //echo $count_unidades_habitacionales;     ?></div>
                        <div><?php echo CHtml::link('Protocolizados por Año', array('estadisticas/ProtocolizadosPorAno'));
?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-4 col-md-35">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div><?php echo CHtml::link('Cantidad de Adjudicados por Condición de Trabajo', array('estadisticas/beneficiarioCondicionTrabajo'));
?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="row">
    <div class="col-lg-6 col-md-40">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div><?php echo CHtml::link('Cantidad de Adjudicados por Sector en el que Trabaja', array('estadisticas/beneficiarioSectorTrabaja'));
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-40">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div><?php echo CHtml::link('Cantidad de Adjudicados por Cotización de FAOV', array('estadisticas/beneficiarioCotizacionFaov'));
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<section class="row">
    <h1 class="page-header">Reportes Sisprov (Consolidados)</h1>
</section>

<section class="row">
    <div class="col-lg-6 col-md-40">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div><?php echo CHtml::link('Reporte Por Documentación (Multifamiliares)', array('reporteDocumentacion'));
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-40">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div><?php echo CHtml::link('Reporte Por Documentación (Unifamiliares)', array('reporteDocumentacionUni'));
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="row">
    <h1 class="page-header">Estadisticas de Analisis Crediticio</h1>
</section>

<section class="row" >
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                        <?php echo 'En Construcción';?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--<section class="row" >
    <div class="col-lg-4 col-md-35">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div><?php
// echo CHtml::link('Cantidad de Beneficiarios por Ubicación Geografica',
//					array('estadisticas/beneficiariosUbicacionGeografica')); 
?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-35">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php //echo $count_unidades_habitacionales;     ?></div>
                        <div><?php
// echo CHtml::link('Cantidad de Adjudicados por Fuente de Ingreso',
//					array('estadisticas/beneficiarioFuenteIngreso')); 
?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-35">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div><?php
// echo CHtml::link('Cantidad de Adjudicados por Condición de Trabajo',
//					array('estadisticas/beneficiarioCondicionTrabajo')); 
?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--
<section class="row">
    <div class="col-lg-6 col-md-40">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div><?php
// echo CHtml::link('Cantidad de Adjudicados por Sector en el que Trabaja',
//                        	     array('estadisticas/beneficiarioSectorTrabaja')); 
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-40">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="glyphicon glyphicon-stats" style=" font-size: 25px;"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div><?php
// echo CHtml::link('Cantidad de Adjudicados por Cotización de FAOV',
//                        	     array('estadisticas/beneficiarioCotizacionFaov')); 
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>-->
