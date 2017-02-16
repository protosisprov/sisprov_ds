<?php
$titulo = 'Reporte Por Documentación (Multifamiliares)';
        $contenido = "<style> 
                            table thead tr {background:#c3d9ff;}
                            table td{border: 0px solid #fff;}
                            .gris {background: #eee;}
                      </style>";
        $contenido.="<div style='padding-top:5px;'>&nbsp;</div>
                     <table>
                        <thead class='thead-tabla_reporte'>
                            <tr>
                                <th class='text-center'>Estado</th>
                                <th class='text-center'>Activo</th>
                                <th class='text-center'>Inactivo</th>
                                <th class='text-center'>Borrado</th>
                                <th class='text-center'>Validado Banavih <br> (Multifamiliar)</th>
                                <th class='text-center'>Validado Saren <br> (Multifamiliar)</th>
                                <th class='text-center'>Devuelto Saren <br> (Multifamiliar)</th>
                                <th class='text-center'>Total Por Estado</th>
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
                        $contenido.="</table>";
                        
        $contenido.="<table><tr><td><img src='images/estadisticas_temp/reporteDocumentacionMultiFamiliarBarras.png'></td></tr></table>";
        $pdfEstadisticas = new PdfEstadisticas();
        $pdfEstadisticas->subTitulo = 'Generado Al '.date("d/m/Y h:m A");
        $pdfEstadisticas->imprimirPdf($titulo, $contenido);