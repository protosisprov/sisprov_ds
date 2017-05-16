<?php

/**
 * This is the model class for table "vsw_persona_vivienda".
 *
 * The followings are the available columns in table 'vsw_persona_vivienda':
 * @property string $nombre_completo
 * @property integer $nacionalidad
 * @property integer $cedula
 * @property string $desarrollo
 * @property string $ubicacion_desarrollo
 * @property string $unidad_habitacional
 * @property string $nro_vivienda
 * @property string $nro_piso
 */
class VswPersonaVivienda extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vsw_persona_vivienda';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nacionalidad, cedula', 'numerical', 'integerOnly'=>true),
			array('nombre_completo', 'length', 'max'=>200),
			array('desarrollo', 'length', 'max'=>300),
			array('ubicacion_desarrollo', 'length', 'max'=>250),
			array('unidad_habitacional', 'length', 'max'=>100),
			array('nro_vivienda, nro_piso', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('nombre_completo, nacionalidad, cedula, desarrollo, ubicacion_desarrollo, unidad_habitacional, nro_vivienda, nro_piso', 'safe', 'on'=>'search'),
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
			'nombre_completo' => 'Nombre Completo',
			'nacionalidad' => 'Nacionalidad',
			'cedula' => 'Cedula',
			'desarrollo' => 'Desarrollo',
			'ubicacion_desarrollo' => 'Ubicacion Desarrollo',
			'unidad_habitacional' => 'Unidad Habitacional',
			'nro_vivienda' => 'Nro Vivienda',
			'nro_piso' => 'Nro Piso',
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

		$criteria->compare('nombre_completo',$this->nombre_completo,true);
		$criteria->compare('nacionalidad',$this->nacionalidad);
		$criteria->compare('cedula',$this->cedula);
		$criteria->compare('desarrollo',$this->desarrollo,true);
		$criteria->compare('ubicacion_desarrollo',$this->ubicacion_desarrollo,true);
		$criteria->compare('unidad_habitacional',$this->unidad_habitacional,true);
		$criteria->compare('nro_vivienda',$this->nro_vivienda,true);
		$criteria->compare('nro_piso',$this->nro_piso,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VswPersonaVivienda the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
