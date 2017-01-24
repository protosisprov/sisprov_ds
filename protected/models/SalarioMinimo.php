<?php

/**
 * This is the model class for table "salario_minimo".
 *
 * The followings are the available columns in table 'salario_minimo':
 * @property integer $id_salario_minimo
 * @property string $gaceta
 * @property string $decreto
 * @property string $fecha_vigencia
 * @property string $valor_salario
 * @property string $observacion
 * @property string $fecha_creacion
 * @property string $fecha_actualizacion
 * @property integer $usuario_id_creacion
 * @property integer $usuario_id_actualizacion
 */
class SalarioMinimo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'salario_minimo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gaceta,decreto,fecha_vigencia,valor_salario', 'required'),
			array('usuario_id_creacion, usuario_id_actualizacion', 'numerical', 'integerOnly'=>true),
			array('gaceta, decreto, fecha_vigencia, valor_salario, observacion, fecha_creacion, fecha_actualizacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_salario_minimo, gaceta, decreto, fecha_vigencia, valor_salario, observacion, fecha_creacion, fecha_actualizacion, usuario_id_creacion, usuario_id_actualizacion', 'safe', 'on'=>'search'),
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
			'id_salario_minimo' => 'Id Salario Minimo',
			'gaceta' => 'Gaceta',
			'decreto' => 'Decreto',
			'fecha_vigencia' => 'Fecha Vigencia',
			'valor_salario' => 'Valor Salario',
			'observacion' => 'Observacion',
			'fecha_creacion' => 'Fecha Creacion',
			'fecha_actualizacion' => 'Fecha Actualizacion',
			'usuario_id_creacion' => 'Usuario Id Creacion',
			'usuario_id_actualizacion' => 'Usuario Id Actualizacion',
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

		$criteria->compare('id_salario_minimo',$this->id_salario_minimo);
		$criteria->compare('gaceta',$this->gaceta,true);
		$criteria->compare('decreto',$this->decreto,true);
		$criteria->compare('fecha_vigencia',$this->fecha_vigencia,true);
		$criteria->compare('valor_salario',$this->valor_salario,true);
		$criteria->compare('observacion',$this->observacion,true);
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);
		$criteria->compare('fecha_actualizacion',$this->fecha_actualizacion,true);
		$criteria->compare('usuario_id_creacion',$this->usuario_id_creacion);
		$criteria->compare('usuario_id_actualizacion',$this->usuario_id_actualizacion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SalarioMinimo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
