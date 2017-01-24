<?php

/**
 * This is the model class for table "plantilla_documento".
 *
 * The followings are the available columns in table 'plantilla_documento':
 * @property integer $id_plantilla_documento
 * @property integer $fk_tipo_documento
 * @property string $documento
 * @property string $fecha_creacion
 * @property string $fecha_modificacion
 * @property integer $usuario_id_creacion
 * @property integer $usuario_id_modificacion
 *
 * The followings are the available model relations:
 * @property Maestro $fkTipoDocumento
 */
class PlantillaDocumento extends CActiveRecord
{
	public $agente_documentacion;
	public $apoderado;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'plantilla_documento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario_id_creacion', 'required'),
			array('fk_tipo_documento, usuario_id_creacion, usuario_id_modificacion', 'numerical', 'integerOnly'=>true),
			array('documento, fecha_creacion, fecha_modificacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_plantilla_documento, fk_tipo_documento, documento, fecha_creacion, fecha_modificacion, usuario_id_creacion, usuario_id_modificacion', 'safe', 'on'=>'search'),
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
			'fkTipoDocumento' => array(self::BELONGS_TO, 'Maestro', 'fk_tipo_documento'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_plantilla_documento' => 'Id Plantilla Documento',
			'fk_tipo_documento' => 'Fk Tipo Documento',
			'documento' => 'Documento',
			'fecha_creacion' => 'Fecha Creacion',
			'fecha_modificacion' => 'Fecha Modificacion',
			'usuario_id_creacion' => 'Usuario Id Creacion',
			'usuario_id_modificacion' => '	',
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

		$criteria->compare('id_plantilla_documento',$this->id_plantilla_documento);
		$criteria->compare('fk_tipo_documento',$this->fk_tipo_documento);
		$criteria->compare('documento',$this->documento,true);
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);
		$criteria->compare('fecha_modificacion',$this->fecha_modificacion,true);
		$criteria->compare('usuario_id_creacion',$this->usuario_id_creacion);
		$criteria->compare('usuario_id_modificacion',$this->usuario_id_modificacion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PlantillaDocumento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
