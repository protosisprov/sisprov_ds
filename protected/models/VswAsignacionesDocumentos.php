<?php

/**
 * This is the model class for table "vsw_asignaciones_documentos".
 *
 * The followings are the available columns in table 'vsw_asignaciones_documentos':
 * @property integer $id_asignaciones
 * @property integer $fk_usuario_asignado
 * @property integer $fk_caso_asignado
 * @property string $estatus
 * @property boolean $es_activo
 */
class VswAsignacionesDocumentos extends CActiveRecord
{
    
     public function primaryKey() {
        return 'id_asignaciones';
    }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vsw_asignaciones_documentos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_asignaciones, fk_caso_asignado, fk_usuario_asignado', 'numerical', 'integerOnly'=>true),
			array('estatus, es_activo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_asignaciones, fk_usuario_asignado, estatus, es_activo', 'safe', 'on'=>'search'),
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
			'id_asignaciones' => 'Id Asignaciones',
			'fk_usuario_asignado' => 'Fk Usuario Asignado',
			'fk_caso_asignado' => 'Fk caso Asignado',
			'estatus' => 'Estatus',
			'es_activo' => 'Es Activo',
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

		$criteria->compare('id_asignaciones',$this->id_asignaciones);
		$criteria->compare('fk_usuario_asignado',$this->fk_usuario_asignado);
		$criteria->compare('fk_caso_asignado',$this->fk_caso_asignado);
		$criteria->compare('estatus',$this->estatus,true);
		$criteria->compare('es_activo',$this->es_activo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VswAsignacionesDocumentos the static model class
	 */
        
            public function buscarEstatus($id) {
            $asignacion=  VswAsignacionesDocumentos::model()->findByAttributes(array('fk_caso_asignado'=>$id, 'es_activo'=>TRUE));
            if(!empty($asignacion)){
                $estatus= $asignacion->estatus;
            }else{
                $estatus='PENDIENTE POR ASIGNAR';
                
            } 
            
          //  var_dump($estatus);Die;
            return $estatus;
        }
        
        
            public function buscarUsuAsignado($id) {
        
        
         $asignacion=  VswAsignacionesDocumentos::model()->findByAttributes(array('fk_caso_asignado'=>$id));
            if(!empty($asignacion)){
                $estatus= $asignacion->username;
            }else{
                $estatus='';
                
            } 
            
            //var_dump($estatus);Die;
            return $estatus;
                

                
                
        }
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
