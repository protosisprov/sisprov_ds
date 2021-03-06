<?php
$baseUrl = Yii::app()->baseUrl;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');
?>
<div class="row">
    <div class="col-md-4">

        <?php
        $criteria = new CDbCriteria;
        $criteria->order = 'strdescripcion ASC';
        echo $form->dropDownListGroup($estado, 'clvcodigo', array('wrapperHtmlOptions' => array('class' => 'col-sm-4',),
            'widgetOptions' => array('data' => CHtml::listData(Tblestado::model()->findAll($criteria), 'clvcodigo', 'strdescripcion'),
                'htmlOptions' => array(
                    'empty' => 'SELECCIONE',
                    'ajax' => array(
                        'type' => 'POST', 'url' => CController::createUrl('ValidacionJs/BuscarMunicipios'),
                        'update' => '#' . CHtml::activeId($municipio, 'clvcodigo'),
                    ),
                ),
            )
                )
        );
        ?>
    </div>
    <div class="col-md-4">
        <?php
        echo $form->dropDownListGroup($municipio, 'clvcodigo', array('wrapperHtmlOptions' => array('class' => 'col-sm-12',),
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ValidacionJs/BuscarParroquias'),
                        'update' => '#' . CHtml::activeId($parroquia, 'clvcodigo'),
                    ),
                    'empty' => 'SELECCIONE',
                ),
            )
                )
        );
        ?>
    </div>
    <div class="col-md-4">

        <?php
        echo $form->dropDownListGroup($parroquia, 'clvcodigo', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar',),
            'widgetOptions' => array('htmlOptions' => array(
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ValidacionJs/BuscarDesarrollo'),
                        'update' => '#' . CHtml::activeId($model, 'desarrollo_id'),
                    ),
                    'empty' => 'SELECCIONE',
                ),
            )
                )
        );
        ?>
    </div>

</div>
<div class="row">
    <div class="col-md-4">

        <?php echo $form->labelEx($model, 'desarrollo_id'); ?>
        <?php
        $this->widget(
                'booster.widgets.TbSelect2', array(
            'name' => CHtml::activeId($model, 'desarrollo_id'),
            'attribute' => 'desarrollo_id',
            'data' => CHtml::listData(Desarrollo::model()->findAll(), 'id_desarrollo', 'nombre'),
            'htmlOptions' => array(
                'style' => 'width: 100%',
                'placeholder' => 'Este campo es de autocompletar',
                'multiple' => false,
                'id' => CHtml::activeId($model, 'desarrollo_id'),
            ),
                )
        );
        ?>
    </div>

    <div class="col-md-4">

        <?php echo $form->labelEx($model, 'oficina_id'); ?>
        <?php
        $this->widget(
                'booster.widgets.TbSelect2', array(
            'name' => CHtml::activeId($model, 'oficina_id'),
            'attribute' => 'oficina_id',
            'data' => CHtml::listData(Oficina::model()->findAll(), 'id_oficina', 'nombre'),
            'htmlOptions' => array(
                'style' => 'width: 100%',
                'placeholder' => 'Este campo es de autocompletar',
                'multiple' => false,
                'id' => CHtml::activeId($model, 'oficina_id'),
            ),
                )
        );
        ?>
    </div>

    <div class="col-md-4">
        <?php
        echo $form->datePickerGroup($model, 'fecha_asignacion', array('widgetOptions' =>
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
                'htmlOptions' => array(
                    'class' => 'span5 limpiar',
                    'readonly' => true,
                ),
            ),
            'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
            'beforeShowDay' => 'DisableDays',
                )
        );
        ?>
    </div>
    <!--<div class="col-md-3">-->
        <?php // echo CHtml::activeLabel($model, 'censado'); ?><br>
        <?php
//        $this->widget('booster.widgets.TbSwitch', array('name' => 'censado',
//            'options' => array(
//                'size' => 'large',
//                'onText' => 'SI',
//                'offText' => 'NO',
//            ),
//            'htmlOptions' => array(
//        )));
        ?> 
    <!--</div>-->

</div>




