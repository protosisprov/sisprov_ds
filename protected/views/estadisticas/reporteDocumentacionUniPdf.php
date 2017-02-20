<?php
$titulo = 'Reporte Por Documentación (Unifamiliares)';
        $contenido = "<style> 
                            table thead tr {background:#c3d9ff;}
                            table td{border: 0px solid #fff;}
                            table tfoot tr {background:#c1c1c1;}
                            .gris {background: #eee;}
                            .tabla-reporte{ padding:5px;}
                      </style>";
        $contenido.="<div style='padding-top:5px;'>&nbsp;</div>
                     <table>
                        <thead class='thead-tabla_reporte'>
                            <tr>
                                <th class='text-center tabla-reporte'>Estado</th>
                                <th class='text-center tabla-reporte'>Activo</th>
                                <th class='text-center tabla-reporte'>Inactivo</th>
                                <th class='text-center tabla-reporte'>Borrado</th>
                                <th class='text-center tabla-reporte'>Validado Banavih <br> (Unifamiliar)</th>
                                <th class='text-center tabla-reporte'>Validado Saren <br> (Unifamiliar)</th>
                                <th class='text-center tabla-reporte'>Devuelto Saren <br> (Unifamiliar)</th>
                                <th class='text-center tabla-reporte'>Total Por Estado</th>
                            </tr>
                        </thead>";
                    $count = 0;
                    foreach($reporte as $item):
                        if($count%2==0)
                            $contenido.="<tr>";
                        else
                            $contenido.="<tr class='gris'>";
                         foreach($item as $value):
                             if(is_int($value))
                                $contenido.="<td align='right'>$value</td>";
                             else
                                $contenido.="<td>$value</td>";
                         endforeach;
                        $contenido.="</tr>";
                        $count++;
                    endforeach;
                    $contenido.="<tfoot>
                        <tr>
                            <th align='left' class='tabla-reporte'>Total por Estatus</th>
                            <th align='right' class='tabla-reporte'>$activo_total</th>
                            <th align='right' class='tabla-reporte'>$inactivo_total</th>
                            <th align='right' class='tabla-reporte'>$borrado_total</th>
                            <th align='right' class='tabla-reporte'>$validado_banavih_uni_total</th>
                            <th align='right' class='tabla-reporte'>$validado_saren_uni_total</th>
                            <th align='right' class='tabla-reporte'>$devuelto_saren_uni_total</th>
                            <th align='right' class='tabla-reporte'>$estados_total</th>
                        </tr>
                    </tfoot>
                        </table>";
                        $contenido.="</table>";
        
        if(file_exists('..'.Yii::app()->request->baseUrl."/images/estadisticas_temp/reporteDocumentacionUniFamiliarBarras.png"))
            $contenido.="<table><tr><td><img src='images/estadisticas_temp/reporteDocumentacionUniFamiliarBarras.png'></td></tr></table>";
        $pdfEstadisticas = new PdfEstadisticas();
        $pdfEstadisticas->subTitulo = 'Generado Al '.date("d/m/Y h:m A");
        $pdfEstadisticas->imprimirPdf($titulo, $contenido);