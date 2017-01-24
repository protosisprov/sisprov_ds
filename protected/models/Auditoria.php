<?php

/**
 * This is the model class for table "auditoria".
 *
 * The followings are the available columns in table 'auditoria':
 * @property integer $id_auditoria
 * @property string $tabla
 * @property string $usuario_bd
 * @property string $fecha
 * @property string $accion
 * @property string $valores_viejos
 * @property string $valores_nuevos
 * @property string $updated_cols
 * @property string $query
 */
class Auditoria extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'auditoria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tabla, usuario_bd, fecha, accion', 'required'),
			array('tabla, usuario_bd', 'length', 'max'=>128),
			array('accion', 'length', 'max'=>1),
			array('valores_viejos, valores_nuevos, updated_cols, query', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_auditoria, tabla, usuario_bd, fecha, accion, valores_viejos, valores_nuevos, updated_cols, query', 'safe', 'on'=>'search'),
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
			'id_auditoria' => 'Id Auditoria',
			'tabla' => 'Tabla',
			'usuario_bd' => 'Usuario Bd',
			'fecha' => 'Fecha',
			'accion' => 'Accion',
			'valores_viejos' => 'Valores Viejos',
			'valores_nuevos' => 'Valores Nuevos',
			'updated_cols' => 'Updated Cols',
			'query' => 'Query',
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

		$criteria->order = 'id_auditoria DESC';

		$criteria->compare('id_auditoria',$this->id_auditoria);
		$criteria->compare('LOWER(tabla)',strtolower($this->tabla),true);
		$criteria->compare('LOWER(usuario_bd)',strtolower($this->usuario_bd),true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('accion',$this->accion,true);
		$criteria->compare('valores_viejos',$this->valores_viejos,true);
		$criteria->compare('valores_nuevos',$this->valores_nuevos,true);
		$criteria->compare('updated_cols',$this->updated_cols,true);
		$criteria->compare('LOWER(query)',strtolower($this->query),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Auditoria the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
