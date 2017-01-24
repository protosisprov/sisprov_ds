
<?php echo $form->errorSummary($model); ?>



<div class="row">
    <div class="col-md-3">
			<?php	echo $form->dropDownListGroup($model, 'id_nacionalidad', array(
					'widgetOptions' => array( 'data' => Maestro::FindMaestrosByPadreSelect(96, 'descripcion DESC'),
						'htmlOptions' => array('empty' => 'SELECCIONE'),	) 	)		); ?>
    </div>
    <div class="col-md-3">
			<?php echo $form->textFieldGroup($model,'nombre_completo',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>200)))); ?>
    </div>
    <div class="col-md-3">
			<?php	echo $form->dropDownListGroup($model, 'id_estatus_adjudicado', array(
								'widgetOptions' => array( 'data' => Maestro::FindMaestrosByPadreSelect(19, 'descripcion DESC'),
										'htmlOptions' => array('empty' => 'SELECCIONE'),	) 	)		); ?>
    </div>
		<div class="col-md-3">
			<?php echo $form->textFieldGroup($model,'nombre_desarrollo',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>200)))); ?>
		</div>
</div>


<div class="row">
    <div class="col-md-4">
			<?php
			$criteria = new CDbCriteria;
			$criteria->order = 'strdescripcion ASC';
			echo $form->dropDownListGroup($model, 'cod_estado',  array('wrapperHtmlOptions' => array('class' => 'col-sm-4',),
					'widgetOptions' => array(
							'data' => CHtml::listData(Tblestado::model()->findAll($criteria), 'clvcodigo', 'strdescripcion'),
							'htmlOptions' => array(
									'empty' => 'SELECCIONE',
									'ajax' => array(
											'type' => 'POST',
											'url' => CController::createUrl('VswBusquedaAvanzada/BuscarMunicipios'),
											'update' => '#' . CHtml::activeId($model, 'cod_municipio'),
									),
							// 'title' => 'Por favor, Seleccione el estado de procedencia',
							// 'data-toggle' => 'tooltip', 'data-placement' => 'right',
							),
					)
							)
			);
			?>
		</div>
    <div class="col-md-4">
			<?php
			echo $form->dropDownListGroup($model, 'cod_municipio', array('wrapperHtmlOptions' => array('class' => 'col-sm-12',),
					'widgetOptions' => array(
							'htmlOptions' => array(
									'ajax' => array(
											'type' => 'POST',
											'url' => CController::createUrl('VswBusquedaAvanzada/BuscarParroquias'),
											'update' => '#' . CHtml::activeId($model, 'cod_parroquia'),
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
			echo $form->dropDownListGroup($model, 'cod_parroquia', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar',),
					'widgetOptions' => array(
							'htmlOptions' => array( 'empty' => 'SELECCIONE' ),
					)
							)
			);
			?>
    </div>
</div>


<div class="row">
    <div class="col-md-3">
			<?php echo $form->textFieldGroup($model,'nombre_unidad_habitacional',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
    </div>
    <div class="col-md-3">
			<?php	echo $form->dropDownListGroup($model, 'id_tipo_inmueble', array(
					'widgetOptions' => array( 'data' => Maestro::FindMaestrosByPadreSelect(81, 'descripcion DESC'),
						'htmlOptions' => array('empty' => 'SELECCIONE'),	) 	)		); ?>
    </div>
    <div class="col-md-3">
			<?php	echo $form->dropDownListGroup($model, 'tipo_vivienda_id', array(
					'widgetOptions' => array( 'data' => Maestro::FindMaestrosByPadreSelect(92, 'descripcion DESC'),
						'htmlOptions' => array('empty' => 'SELECCIONE'),	) 	)		); ?>
    </div>
		<div class="col-md-3">
			<?php	echo $form->dropDownListGroup($model, 'id_fuente_financiamiento', array(
					'widgetOptions' => array( 'data' => CHtml::listData(FuenteFinanciamiento::model()->findAll(), 'id_fuente_financiamiento', 'nombre_fuente_financiamiento'),
						'htmlOptions' => array('empty' => 'SELECCIONE'),	) 	)		); ?>
		</div>
</div>


<div class="row">
    <div class="col-md-2">
			<?php echo $form->textFieldGroup($model,'nro_piso',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>
    </div>
    <div class="col-md-2">
			<?php echo $form->textFieldGroup($model,'nro_banos',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
    </div>
    <div class="col-md-2">
			<?php echo $form->textFieldGroup($model,'nro_habitaciones',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
    </div>
		<div class="col-md-2">
			<?php echo $form->textFieldGroup($model,'nro_banos_auxiliar',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
		</div>
		<div class="col-md-2">
			<?php echo $form->textFieldGroup($model,'construccion_mt2',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>
		</div>
</div>



<div class="row">
    <div class="col-md-3">
			<?php	echo $form->dropDownListGroup($model, 'id_programa', array(
					'widgetOptions' => array( 'data' => CHtml::listData(Programa::model()->findAll(), 'id_programa', 'nombre_programa'),
						'htmlOptions' => array('empty' => 'SELECCIONE'),	) 	)		); ?>    </div>
    <div class="col-md-3">
			<?php	echo $form->dropDownListGroup($model, 'id_ente_ejecutor', array(
					'widgetOptions' => array( 'data' => CHtml::listData(EnteEjecutor::model()->findAll(), 'id_ente_ejecutor', 'nombre_ente_ejecutor'),
						'htmlOptions' => array('empty' => 'SELECCIONE'),	) 	)		); ?>
    </div>
    <div class="col-md-3">
			<?php	echo $form->dropDownListGroup($model, 'condicion_trabajo_id', array(
					'widgetOptions' => array( 'data' => Maestro::FindMaestrosByPadreSelect(109, 'descripcion DESC'),
						'htmlOptions' => array('empty' => 'SELECCIONE'),	) 	)		); ?>
    </div>
		<div class="col-md-3">
			<?php	echo $form->dropDownListGroup($model, 'condicion_laboral_id', array(
					'widgetOptions' => array( 'data' => Maestro::FindMaestrosByPadreSelect(126, 'descripcion DESC'),
						'htmlOptions' => array('empty' => 'SELECCIONE'),	) 	)		); ?>
		</div>
</div>


<div class="row">
    <div class="col-md-3">
			<?php	echo $form->dropDownListGroup($model, 'fuente_ingreso_id', array(
					'widgetOptions' => array( 'data' => Maestro::FindMaestrosByPadreSelect(102, 'descripcion DESC'),
						'htmlOptions' => array('empty' => 'SELECCIONE'),	) 	)		); ?>    </div>
    <div class="col-md-3">
			<?php	echo $form->dropDownListGroup($model, 'relacion_trabajo_id', array(
					'widgetOptions' => array( 'data' => Maestro::FindMaestrosByPadreSelect(117, 'descripcion DESC'),
						'htmlOptions' => array('empty' => 'SELECCIONE'),	) 	)		); ?>
    </div>
    <div class="col-md-3">
			<?php	echo $form->dropDownListGroup($model, 'sector_trabajo_id', array(
					'widgetOptions' => array( 'data' => Maestro::FindMaestrosByPadreSelect(132, 'descripcion DESC'),
						'htmlOptions' => array('empty' => 'SELECCIONE'),	) 	)		); ?>
    </div>
		<div class="col-md-3">
			<?php echo $form->textFieldGroup($model,'nombre_empresa',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>200)))); ?>
		</div>
</div>

<div class="row">
    <div class="col-md-3">
			<?php //echo $form->textFieldGroup($model,'ingreso_mensual',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
		</div>
    <div class="col-md-3">
			<?php //echo $form->textFieldGroup($model,'ingreso_declarado',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
    </div>
    <div class="col-md-3">
			<?php //echo $form->textFieldGroup($model,'ingreso_promedio_faov',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
    </div>
		<div class="col-md-3">
			<?php	//echo $form->textFieldGroup($model,'ingreso_total_familiar',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>16)))); ?>
		</div>
</div>

<div class="row">
    <div class="col-md-3">
			<?php	echo $form->dropDownListGroup($model, 'condicion_unidad_familiar_id', array(
					'widgetOptions' => array( 'data' => Maestro::FindMaestrosByPadreSelect(139, 'descripcion DESC'),
						'htmlOptions' => array('empty' => 'SELECCIONE'),	) 	)		); ?>
		</div>
    <div class="col-md-3">
			<?php echo $form->textFieldGroup($model,'total_personas_cotizando',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
    </div>
    <div class="col-md-3">
			<?php echo $form->dropDownListGroup($model, 'cotiza_faov', array(
					'widgetOptions' => array( 'data' =>  array("SI", "NO") ,
						'htmlOptions' => array('empty' => 'SELECCIONE'),	) 	)		); ?>
    </div>
		<div class="col-md-3">
			<?php //echo $form->textFieldGroup($model,'ingreso_total_familiar_suma_faov',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
		</div>
</div>

