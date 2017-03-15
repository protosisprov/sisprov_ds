<?php

/**
 * This is the model class for table "vsw_sector".
 *
 * The followings are the available columns in table 'vsw_sector':
 * @property integer $cod_estado
 * @property string $estado
 * @property integer $cod_municipio
 * @property string $municipio
 * @property integer $cod_parroquia
 * @property string $parroquia
 */
class VswSector extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vsw_sector';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cod_estado, cod_municipio, cod_parroquia', 'numerical', 'integerOnly'=>true),
			array('estado, municipio, parroquia', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cod_estado, estado, cod_municipio, municipio, cod_parroquia, parroquia', 'safe', 'on'=>'search'),
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
			'cod_estado' => 'Cod Estado',
			'estado' => 'Estado',
			'cod_municipio' => 'Cod Municipio',
			'municipio' => 'Municipio',
			'cod_parroquia' => 'Cod Parroquia',
			'parroquia' => 'Parroquia',
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

		$criteria->compare('cod_estado',$this->cod_estado);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('cod_municipio',$this->cod_municipio);
		$criteria->compare('municipio',$this->municipio,true);
		$criteria->compare('cod_parroquia',$this->cod_parroquia);
		$criteria->compare('parroquia',$this->parroquia,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VswSector the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}