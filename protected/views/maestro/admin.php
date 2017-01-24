<?php
$this->breadcrumbs=array(
	'Maestros'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Maestro','url'=>array('index')),
array('label'=>'Create Maestro','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('maestro-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Gestión de Maestros</h1>

<?php
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
    echo '<ul class="flashes" style="list-style-type:none;">';
    foreach($flashMessages as $key => $message) {
    echo '<li><div style="border-radius:4px;border:1px solid #c6d880" class="flash-' . $key . '">' .$message."</div></li>\n";
    }
    echo '</ul>';
}
?>


<?php
$this->widget('booster.widgets.TbButton', array(
		//'type'=>'primary',
		'label' => 'Crear Padre',
		'icon' => 'glyphicon glyphicon-plus',
		'size' => 'medium',
		'context' => 'danger',
		'buttonType' => 'link',
		'url' => CHtml::normalizeUrl(array('crearPadre')),
));
?>

<?php

$this->widget('booster.widgets.TbGridView',array(
'id'=>'maestro-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		array(
			'header'=>'ID',
			'name'=>'id_maestro',
			'value' => '$data->id_maestro' ,
			'htmlOptions'=>array('width'=>'80px',  'style' => 'text-align: center;'),
		),

		'descripcion',
		//'padre',
		array(
			'header'=>'Padre',
			'name'=>'padre',
			//'value' => '$data->padre' ,
			//'value' => 'CHtml::link($data->padre,Yii::app()->createAbsoluteUrl("/user/view",array("id"=>$data->padre)))',
			'value' => 'CHtml::ajaxLink("$data->padre",
   						Yii::app()->createUrl("maestro/admin" ),
							array(
								//"type"=>"POST",
								"data" => "js:{\'padre\': $(\'link-padre-$data->padre\').val() }",
								"success"=>"js:function(string){
									alert($(\'link-padre-$data->padre\').attr(\'href\') + \'hola\');

									$(\'#Maestro_padre\').val($data->id_maestro);

									$( \'.search-form form\' ).submit()


								}"
							),
							array(
								"id"    => "link-padre-$data->padre",
							)
)',


			'type'  => 'raw',
		//	'options' => array('ajax' => array('type' => 'get', 'url'=>'js:$(this).attr("href")',

			'htmlOptions'=>array('width'=>'120px',  'style' => 'text-align: center;'),
		),
		array(
			'header'=>'Cant de Hijos',
			'name'=>'hijo',
			'value' => '$data->hijo' ,
			'htmlOptions'=>array('width'=>'120px',  'style' => 'text-align: center;'),
		),
		array(
			'header'=>'Activo',
			'name'=>'es_activo',
			'value' => '$data->es_activo==\'1\' ? "Si":"No"' ,
			'filter' => array( '' =>'Todos', '1' =>'Si', '0' =>'No'),
			'htmlOptions'=>array('width'=>'120px',  'style' => 'text-align: center;'),
		),
		array(
			'header'=>'Fecha',
			'name'=>'fecha_creacion',
			'value' => 'Yii::app()->dateFormatter->format("d/M/y hh:mm a", strtotime($data->fecha_creacion))' ,
			'htmlOptions'=>array('width'=>'120px',  'style' => 'text-align: center;'),
		),

		array(
			'header'=>'Usuario Creacion',
			'name'=>'usuario_id_creacion',
			'value' => '$data->username($data->usuario_id_creacion)' ,
			'htmlOptions'=>array('width'=>'120px',  'style' => 'text-align: center;'),
		),


		/*
		'fecha_actualizacion',
		'usuario_id_actualizacion',
		*/
array(
'class'=>'booster.widgets.TbButtonColumn',
'header' => 'Acciones',
'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
'template' => '{ver} {modificar} {agregarHijo}',
'buttons' => array(
		'ver' => array(
				'label' => 'Ver',
				'icon' => 'eye-open',
				'size' => 'medium',
				//'visible' => '((Yii::app()->user->checkAccess("action_desarrollo_view")))',
				'url' => 'Yii::app()->createUrl("maestro/view/", array("id"=>$data->id_maestro))',
		),
		'modificar' => array(
				'label' => 'Modificar',
				'icon' => 'glyphicon glyphicon-pencil',
				'size' => 'medium',
				//'visible' => '((Yii::app()->user->checkAccess("action_desarrollo_update")))',
				'url' => 'Yii::app()->createUrl("maestro/update/", array("id"=>$data->id_maestro))',
//                    'visible' => 'Asignar($data->username);'
		),
		'agregarHijo' => array(
				'label' => 'Agregar Hijo',
				'icon' => 'glyphicon glyphicon-plus',
				'size' => 'medium',
				//'visible' => '((Yii::app()->user->checkAccess("action_desarrollo_pdf")))',
				'visible' => '$data->padre == 0',
				'url' => 'Yii::app()->createUrl("maestro/crearHijo/", array("padre"=>$data->id_maestro))',
//                    'visible' => 'Asignar($data->username);'
		),
),


),
),
)); ?>
