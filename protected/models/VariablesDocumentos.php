<?php

/**
 * This is the model class for table "variables_documentos".
 *
 * The followings are the available columns in table 'variables_documentos':
 * @property integer $id_variable
 * @property string $variable
 * @property string $label
 * @property string $relation
 * @property boolean $variables_obligatorias
 * @property boolean $numero_letras
 * @property boolean $es_cifra_monetaria
 * @property boolean $es_fecha
 */
class VariablesDocumentos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'variables_documentos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('variable, label, relation, variables_obligatorias, numero_letras, es_cifra_monetaria, es_fecha', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_variable, variable, label, relation, variables_obligatorias, numero_letras, es_cifra_monetaria, es_fecha', 'safe', 'on'=>'search'),
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
			'id_variable' => 'Id Variable',
			'variable' => 'Variable',
			'label' => 'Label',
			'relation' => 'Relation',
			'variables_obligatorias' => 'Variables Obligatorias',
			'numero_letras' => 'Numero Letras',
			'es_cifra_monetaria' => 'Es Cifra Monetaria',
			'es_fecha' => 'Es Fecha',
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

		$criteria->compare('id_variable',$this->id_variable);
		$criteria->compare('variable',$this->variable,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('relation',$this->relation,true);
		$criteria->compare('variables_obligatorias',$this->variables_obligatorias);
		$criteria->compare('numero_letras',$this->numero_letras);
		$criteria->compare('es_cifra_monetaria',$this->es_cifra_monetaria);
		$criteria->compare('es_fecha',$this->es_fecha);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VariablesDocumentos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
