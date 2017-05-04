<?php

/**
 * This is the model class for table "persona".
 *
 * The followings are the available columns in table 'persona':
 * @property integer $id_persona
 * @property integer $persona_id_faov
 * @property integer $nacionalidad
 * @property integer $cedula
 * @property string $primer_nombre
 * @property string $segundo_nombre
 * @property string $primer_apellido
 * @property string $segundo_apellido
 * @property string $fecha_nacimiento
 * @property integer $fk_sexo
 * @property integer $fk_estado_civil
 * @property string $telf_habitacion
 * @property string $telf_celular
 * @property string $correo_electronico
 * @property string $fecha_creacion
 * @property string $fecha_actualizacion
 * @property integer $usuario_id_creacion
 * @property integer $usuario_id_actualizacion
 *
 * The followings are the available model relations:
 * @property Maestro $nacionalidad0
 */
class Persona extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'persona';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('persona_id_faov, nacionalidad, cedula, primer_nombre, primer_apellido, fecha_creacion, fecha_actualizacion, usuario_id_creacion', 'required'),
			array('persona_id_faov, nacionalidad, cedula, fk_sexo, fk_estado_civil, usuario_id_creacion, usuario_id_actualizacion', 'numerical', 'integerOnly'=>true),
			array('primer_nombre, segundo_nombre, primer_apellido, segundo_apellido', 'length', 'max'=>20),
			array('telf_habitacion, telf_celular', 'length', 'max'=>12),
			array('correo_electronico', 'length', 'max'=>50),
			array('fecha_nacimiento', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_persona, persona_id_faov, nacionalidad, cedula, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, fecha_nacimiento, fk_sexo, fk_estado_civil, telf_habitacion, telf_celular, correo_electronico, fecha_creacion, fecha_actualizacion, usuario_id_creacion, usuario_id_actualizacion', 'safe', 'on'=>'search'),
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
			'nacionalidad0' => array(self::BELONGS_TO, 'Maestro', 'nacionalidad'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_persona' => 'Id Persona',
			'persona_id_faov' => 'Persona Id Faov',
			'nacionalidad' => 'Nacionalidad',
			'cedula' => 'Cedula',
			'primer_nombre' => 'Primer Nombre',
			'segundo_nombre' => 'Segundo Nombre',
			'primer_apellido' => 'Primer Apellido',
			'segundo_apellido' => 'Segundo Apellido',
			'fecha_nacimiento' => 'Fecha Nacimiento',
			'fk_sexo' => 'Fk Sexo',
			'fk_estado_civil' => 'Fk Estado Civil',
			'telf_habitacion' => 'Telf Habitacion',
			'telf_celular' => 'Telf Celular',
			'correo_electronico' => 'Correo Electronico',
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

		$criteria->compare('id_persona',$this->id_persona);
		$criteria->compare('persona_id_faov',$this->persona_id_faov);
		$criteria->compare('nacionalidad',$this->nacionalidad);
		$criteria->compare('cedula',$this->cedula);
		$criteria->compare('primer_nombre',$this->primer_nombre,true);
		$criteria->compare('segundo_nombre',$this->segundo_nombre,true);
		$criteria->compare('primer_apellido',$this->primer_apellido,true);
		$criteria->compare('segundo_apellido',$this->segundo_apellido,true);
		$criteria->compare('fecha_nacimiento',$this->fecha_nacimiento,true);
		$criteria->compare('fk_sexo',$this->fk_sexo);
		$criteria->compare('fk_estado_civil',$this->fk_estado_civil);
		$criteria->compare('telf_habitacion',$this->telf_habitacion,true);
		$criteria->compare('telf_celular',$this->telf_celular,true);
		$criteria->compare('correo_electronico',$this->correo_electronico,true);
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
	 * @return Persona the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
