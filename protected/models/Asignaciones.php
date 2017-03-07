<?php

/**
 * This is the model class for table "asignaciones".
 *
 * The followings are the available columns in table 'asignaciones':
 * @property integer $id_asignaciones
 * @property integer $fk_entidad
 * @property integer $fk_usuario_asignado
 * @property integer $fk_usuario_q_asigna
 * @property integer $fk_caso_asignado
 * @property string $fecha_creacion
 * @property string $fecha_actualizacion
 * @property integer $usuario_id_creacion
 * @property integer $usuario_id_actualizacion
 * @property boolean $es_activo
 * @property integer $fk_estatus
 *
 * The followings are the available model relations:
 * @property CrugeUser $fkUsuarioAsignado
 * @property CrugeUser $fkUsuarioQAsigna
 */
class Asignaciones extends CActiveRecord
{
    public $asignar_label;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'asignaciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha_creacion', 'required'),
			array('fk_entidad, fk_usuario_asignado, fk_usuario_q_asigna, fk_caso_asignado, usuario_id_creacion, usuario_id_actualizacion, fk_estatus', 'numerical', 'integerOnly'=>true),
			array('fecha_actualizacion, es_activo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_asignaciones, fk_entidad, fk_usuario_asignado, fk_usuario_q_asigna, fk_caso_asignado, fecha_creacion, fecha_actualizacion, usuario_id_creacion, usuario_id_actualizacion, es_activo, fk_estatus', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'fkUsuarioAsignado' => array(self::BELONGS_TO, 'CrugeUser', 'fk_usuario_asignado'),
			'fkUsuarioQAsigna' => array(self::BELONGS_TO, 'CrugeUser', 'fk_usuario_q_asigna'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            
		return array(
			'id_asignaciones' => 'Id Asignaciones',
			'fk_entidad' => 'Fk Entidad',
			'fk_usuario_asignado' => 'Asignar a:',
			'fk_usuario_q_asigna' => 'Asignado por:',
			'fk_caso_asignado' => 'Fk Caso Asignado',
			'fecha_creacion' => 'Fecha del proceso',
			'fecha_actualizacion' => 'Fecha Actualizacion',
			'usuario_id_creacion' => 'Usuario Id Creacion',
			'usuario_id_actualizacion' => 'Usuario Id Actualizacion',
			'es_activo' => 'Es Activo',
			'fk_estatus' => 'Fk Estatus',
			'asignar_label' => 'Asignación de Analista para el Proceso de Documentación',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_asignaciones',$this->id_asignaciones);
		$criteria->compare('fk_entidad',$this->fk_entidad);
		$criteria->compare('fk_usuario_asignado',$this->fk_usuario_asignado);
		$criteria->compare('fk_usuario_q_asigna',$this->fk_usuario_q_asigna);
		$criteria->compare('fk_caso_asignado',$this->fk_caso_asignado);
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);
		$criteria->compare('fecha_actualizacion',$this->fecha_actualizacion,true);
		$criteria->compare('usuario_id_creacion',$this->usuario_id_creacion);
		$criteria->compare('usuario_id_actualizacion',$this->usuario_id_actualizacion);
		$criteria->compare('es_activo',$this->es_activo);
		$criteria->compare('fk_estatus',$this->fk_estatus);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Asignaciones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
