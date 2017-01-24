<?php

/**
 * This is the model class for table "registro_documento".
 *
 * The followings are the available columns in table 'registro_documento':
 * @property integer $id_registro_documento
 * @property integer $registro_publico_id
 * @property string $fecha_registro
 * @property string $tomo
 * @property integer $ano
 * @property integer $asiento_registral
 * @property integer $folio_real
 * @property string $nro_protocolo
 * @property string $nro_matricula
 * @property integer $estatus
 * @property string $fecha_creacion
 * @property string $fecha_actualizacion
 * @property integer $usuario_id_creacion
 * @property integer $usuario_id_actualizacion
 * @property string $nro_documento
 *
 * The followings are the available model relations:
 * @property Maestro $estatus0
 * @property RegistroPublico $registroPublico
 * @property Documentacion[] $documentacions
 */
class RegistroDocumento extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'registro_documento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('registro_publico_id, fecha_registro, estatus, fecha_creacion, fecha_actualizacion, usuario_id_creacion, ano, asiento_registral, folio_real, nro_protocolo, nro_matricula, estatus', 'required'),
			array('registro_publico_id, ano, asiento_registral, folio_real, estatus, usuario_id_creacion, usuario_id_actualizacion', 'numerical', 'integerOnly'=>true),
			array('tomo, nro_protocolo', 'length', 'max'=>50),
			array('nro_matricula', 'length', 'max'=>100),
			array('nro_documento', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_registro_documento, registro_publico_id, fecha_registro, tomo, ano, asiento_registral, folio_real, nro_protocolo, nro_matricula, estatus, fecha_creacion, fecha_actualizacion, usuario_id_creacion, usuario_id_actualizacion, nro_documento', 'safe', 'on'=>'search'),
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
			'estatus0' => array(self::BELONGS_TO, 'Maestro', 'estatus'),
			'registroPublico' => array(self::BELONGS_TO, 'RegistroPublico', 'registro_publico_id'),
			'documentacions' => array(self::HAS_MANY, 'Documentacion', 'registro_documento_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_registro_documento' => 'Id Registro Documento',
			'registro_publico_id' => 'Registro Publico',
			'fecha_registro' => 'Fecha Registro',
			'tomo' => 'Tomo',
			'ano' => 'Año',
			'asiento_registral' => 'Asiento Registral',
			'folio_real' => 'Folio Real',
			'nro_protocolo' => 'Nro Protocolo',
			'nro_matricula' => 'Nro Matricula',
			'estatus' => 'Estatus',
			'fecha_creacion' => 'Fecha Creacion',
			'fecha_actualizacion' => 'Fecha Actualizacion',
			'usuario_id_creacion' => 'Usuario Id Creacion',
			'usuario_id_actualizacion' => 'Usuario Id Actualizacion',
			'nro_documento' => 'Nro Documento',
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

		$criteria->compare('id_registro_documento',$this->id_registro_documento);
		$criteria->compare('registro_publico_id',$this->registro_publico_id);
		$criteria->compare('fecha_registro',$this->fecha_registro,true);
		$criteria->compare('tomo',$this->tomo,true);
		$criteria->compare('ano',$this->ano);
		$criteria->compare('asiento_registral',$this->asiento_registral);
		$criteria->compare('folio_real',$this->folio_real);
		$criteria->compare('nro_protocolo',$this->nro_protocolo,true);
		$criteria->compare('nro_matricula',$this->nro_matricula,true);
		$criteria->compare('estatus',$this->estatus);
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);
		$criteria->compare('fecha_actualizacion',$this->fecha_actualizacion,true);
		$criteria->compare('usuario_id_creacion',$this->usuario_id_creacion);
		$criteria->compare('usuario_id_actualizacion',$this->usuario_id_actualizacion);
		$criteria->compare('nro_documento',$this->nro_documento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RegistroDocumento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
