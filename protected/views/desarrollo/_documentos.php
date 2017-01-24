<?php
function maestro($id_documentacion){
    $nombre = Maestro::model()->findByPk($id_documentacion);
    return $nombre['descripcion']." - ".substr($nombre['fecha_creacion'], 0,10);
}
?>
<div class='row fecha' style="display: block">
    <table class="table table-striped">
<!--         <thead>
            <tr>
                <th>Documento</th>
            </tr>
        </thead> -->
        <?php foreach($docs as $doc): ?>
            <tr>
                <td>
                    <?php 
                        echo CHtml::radioButton('id_doc', false, array(
                            'value'=>$doc['id_documentacion'],
                            'name'=>'id_doc'.$doc['id_documentacion'],
                            'uncheckValue'=>null
                    ));
                    ?>
                    <?php echo maestro($doc['tipo_documento_id']); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>