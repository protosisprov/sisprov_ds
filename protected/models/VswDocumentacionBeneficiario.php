<?php

/**
 * This is the model class for table "vsw_documentacion_beneficiario".
 *
 * The followings are the available columns in table 'vsw_documentacion_beneficiario':
 * @property integer $id_beneficiario
 * @property integer $persona_id
 * @property string $estatus_documento
 * @property integer $estatus_beneficiario_id
 * @property integer $cedula_beneficiario
 * @property integer $id_desarrollo
 * @property string $nombre_desarrollo
 * @property integer $id_unidad_habitacional
 * @property string $nombre_unidad_habitacional
 * @property string $numero_piso
 * @property string $numero_vivienda
 * @property integer $cod_estado
 * @property string $estado_desarrollo
 */
class VswDocumentacionBeneficiario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vsw_documentacion_beneficiario';
	}
        
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_beneficiario, persona_id, estatus_beneficiario_id, cedula_beneficiario, id_desarrollo, id_unidad_habitacional, cod_estado', 'numerical', 'integerOnly'=>true),
			array('estatus_documento', 'length', 'max'=>60),
			array('nombre_desarrollo', 'length', 'max'=>200),
			array('nombre_unidad_habitacional', 'length', 'max'=>100),
			array('numero_piso, numero_vivienda', 'length', 'max'=>10),
			array('estado_desarrollo', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_beneficiario, persona_id, estatus_documento, estatus_beneficiario_id, cedula_beneficiario, id_desarrollo, nombre_desarrollo, id_unidad_habitacional, nombre_unidad_habitacional, numero_piso, numero_vivienda, cod_estado, estado_desarrollo', 'safe', 'on'=>'search'),
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
                    'vsw_asignaciones_documentos' => array(self::BELONGS_TO, 'VswAsignacionesDocumentos', '','on'=>'vsw_asignaciones_documentos.fk_caso_asignado = t.id_unidad_habitacional'),
		);
	}
        
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_beneficiario' => 'Id Beneficiario',
			'persona_id' => 'Persona',
			'estatus_documento' => 'Estatus Documento',
			'estatus_beneficiario_id' => 'Estatus Beneficiario',
			'cedula_beneficiario' => 'Cedula Beneficiario',
			'id_desarrollo' => 'Id Desarrollo',
			'nombre_desarrollo' => 'Nombre Desarrollo',
			'id_unidad_habitacional' => 'Id Unidad Habitacional',
			'nombre_unidad_habitacional' => 'Nombre Unidad Habitacional',
			'numero_piso' => 'Numero Piso',
			'numero_vivienda' => 'Numero Vivienda',
			'cod_estado' => 'Cod Estado',
			'estado_desarrollo' => 'Estado Desarrollo',
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
                
		$criteria->compare('id_beneficiario',$this->id_beneficiario);
		$criteria->compare('persona_id',$this->persona_id);
		$criteria->compare('estatus_documento',$this->estatus_documento,true);
		$criteria->compare('estatus_beneficiario_id',$this->estatus_beneficiario_id);
		$criteria->compare('cedula_beneficiario',$this->cedula_beneficiario);
		$criteria->compare('id_desarrollo',$this->id_desarrollo);
		$criteria->compare('nombre_desarrollo',$this->nombre_desarrollo,true);
		$criteria->compare('id_unidad_habitacional',$this->id_unidad_habitacional);
		$criteria->compare('nombre_unidad_habitacional',$this->nombre_unidad_habitacional,true);
		$criteria->compare('numero_piso',$this->numero_piso,true);
		$criteria->compare('numero_vivienda',$this->numero_vivienda,true);
		$criteria->compare('cod_estado',$this->cod_estado);
		$criteria->compare('estado_desarrollo',$this->estado_desarrollo,true);
                
                
                if(Yii::app()->user->checkAccess("analista_documentacion"))
                {
                    $criteria->join = 'JOIN vsw_asignaciones_documentos ON vsw_asignaciones_documentos.fk_caso_asignado = t.id_unidad_habitacional and vsw_asignaciones_documentos.es_activo=true and vsw_asignaciones_documentos.fk_usuario_asignado='.Yii::app()->user->id;
                }
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VswDocumentacionBeneficiario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}