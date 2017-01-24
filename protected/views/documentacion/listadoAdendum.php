<?php
$criteria = new CDbCriteria;
$criteria->select = 'fk_beneficiario, id_documentacion';
$criteria->condition = 'tipo_documento_id= :tipo_documento_id AND fk_beneficiario=:fk_beneficiario AND estatus=:estatus AND es_multi=:es_multi';
$criteria->params = array(':tipo_documento_id' => 277, ':fk_beneficiario' => $model, ':estatus' => 53, ':es_multi' => TRUE);
$documentoAdendum = Documentacion::model()->findAll($criteria);

?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div style="margin-top:3%"></div>
            <?php
           
            $desarrollo = UnidadHabitacional::model()->findByPk($model);
//            var_dump($desarrollo->nombre);die;
            ?>
            <div class="well-large"><h3 class="text-center">Documentos Adendums del Desarrollo<br/><i> <?= $desarrollo->nombre ?></i></h3></div>
            <div class="well-large">
                <?php
                if (empty($documentoAdendum)) {
                    echo '<div class="text-center" style="margin-top:20%"><h3><em><small>No Pasee Documentos Adendums</small></em></h3></div>';
                } else {
                    ?>
                    <table class="table table-bordered table-responsive">
                        <?php
                        $i = 1;
                        foreach ($documentoAdendum as $value) {

                            echo '<tr>
                                <td  class="col-md-10">Documento Adendum N° ' . $i . '</td>
                                <td  class="col-md-2">
                                    <a target="_blank" title="" data-toggle="tooltip" href="' . $this->createUrl('documentacion/pdfbyid', array('id' => $value->id_documentacion)) . '" data-original-title="Imprimir Documento">
                                        <i class="glyphicon glyphicon-print"></i>
                                    </a>
                                </td>
                            </tr>';
                            $i++;
                        }
                        ?>
                    </table>
<?php } ?>
            </div>
            <div style="margin-bottom:30%"></div>
        </div>
        <div class="modal-footer">
            <!--<button class="btn btn-success" id="btn-estatus" href="#"><i class="glyphicon glyphicon-level-up"></i>Generar Adendum</button>-->
            <?php
//                                var_dump( $desarrollo->id_desarrollo );die;
            $existeUniFam = Yii::app()->db->createCommand("SELECT EXISTS(  SELECT be.id_beneficiario
                                    FROM unidad_familiar unif
                                    JOIN beneficiario be ON unif.beneficiario_id = be.id_beneficiario 
                                    JOIN beneficiario_temporal tmp ON be.beneficiario_temporal_id = tmp.id_beneficiario_temporal AND tmp.estatus = 272
                                    JOIN maestro ma ON tmp.nacionalidad = ma.id_maestro
                                    WHERE unif.fk_tipo_documento_multi IS NULL AND  tmp.desarrollo_id = " . $desarrollo->id_unidad_habitacional . "
                                    ORDER BY unif.nombre ASC) ")->queryScalar();
            if ($existeUniFam) {
                echo '<a class="btn btn-success" href="', $this->createUrl('documentacion/adendum', array('id' => $desarrollo->id_unidad_habitacional)), '" role="button"><i class="glyphicon glyphicon-file"></i>Generar Adendum</a>';
            }
            ?>
            <button class="btn btn-danger" href="#" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cerrar</button>
        </div>
    </div>
</div>