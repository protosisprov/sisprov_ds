<?php

/**
 * This is the model class for table "tabla_subsidio".
 *
 * The followings are the available columns in table 'tabla_subsidio':
 * @property integer $id_tabla_subsidio
 * @property string $ingreso_familiar_sm
 * @property string $subsidio_porcentaje
 * @property string $gaceta_pto
 * @property boolean $es_activo
 * @property integer $usuario_id_creacion
 * @property string $fecha_creacion
 * @property integer $usuario_id_actualizacion
 * @property string $fecha_actualizacion
 */
class TablaSubsidio extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tabla_subsidio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ingreso_familiar_sm, subsidio_porcentaje, usuario_id_creacion, fecha_creacion, fecha_actualizacion', 'required'),
			array('usuario_id_creacion, usuario_id_actualizacion', 'numerical', 'integerOnly'=>true),
			array('gaceta_pto', 'length', 'max'=>50),
			array('es_activo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_tabla_subsidio, ingreso_familiar_sm, subsidio_porcentaje, gaceta_pto, es_activo, usuario_id_creacion, fecha_creacion, usuario_id_actualizacion, fecha_actualizacion', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_tabla_subsidio' => 'Id Tabla Subsidio',
			'ingreso_familiar_sm' => 'Ingreso Familiar Sm',
			'subsidio_porcentaje' => 'Subsidio Porcentaje',
			'gaceta_pto' => 'Gaceta Pto',
			'es_activo' => 'Es Activo',
			'usuario_id_creacion' => 'Usuario Id Creacion',
			'fecha_creacion' => 'Fecha Creacion',
			'usuario_id_actualizacion' => 'Usuario Id Actualizacion',
			'fecha_actualizacion' => 'Fecha Actualizacion',
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

		$criteria->compare('id_tabla_subsidio',$this->id_tabla_subsidio);
		$criteria->compare('ingreso_familiar_sm',$this->ingreso_familiar_sm,true);
		$criteria->compare('subsidio_porcentaje',$this->subsidio_porcentaje,true);
		$criteria->compare('gaceta_pto',$this->gaceta_pto,true);
		$criteria->compare('es_activo',$this->es_activo);
		$criteria->compare('usuario_id_creacion',$this->usuario_id_creacion);
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);
		$criteria->compare('usuario_id_actualizacion',$this->usuario_id_actualizacion);
		$criteria->compare('fecha_actualizacion',$this->fecha_actualizacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TablaSubsidio the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
