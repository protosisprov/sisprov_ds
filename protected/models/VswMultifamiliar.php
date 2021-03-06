<?php

/**
 * This is the model class for table "vsw_multifamiliar".
 *
 * The followings are the available columns in table 'vsw_multifamiliar':
 * @property integer $id_desarrollo
 * @property string $nombre_desarrollo
 * @property integer $id_unidad_habitacional
 * @property string $nombre_unidad_habitacional
 * @property integer $cod_estado
 * @property string $estado
 * @property integer $cantidad_vivienda
 * @property integer $id_estatus
 * @property string $estatus
 * @property integer $cantidad
 * @property integer $porcentaje
 * @property integer $total_para_documentar
 */
class VswMultifamiliar extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function primaryKey() {
        return 'id_desarrollo';
    }

    public function tableName() {
        return 'vsw_multifamiliar';
    }
    
    public $cantidad;
    public $porcentaje;
    public $total_para_documentar;
    public $analista;
    public $estatus_asignacion;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_desarrollo, id_unidad_habitacional, cod_estado, cantidad_vivienda, id_estatus', 'numerical', 'integerOnly' => true),
            array('nombre_desarrollo', 'length', 'max' => 200),
            array('nombre_unidad_habitacional', 'length', 'max' => 100),
            array('estado', 'length', 'max' => 250),
            array('estatus', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_desarrollo, nombre_desarrollo, id_unidad_habitacional, nombre_unidad_habitacional, cod_estado, estado, cantidad_vivienda, id_estatus, estatus, cantidad, total_para_documentar, estatus_msj, estatus_asignacion', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'vsw_asignaciones_documentos' => array(self::BELONGS_TO, 'VswAsignacionesDocumentos','','on'=>'t.id_unidad_habitacional=vsw_asignaciones_documentos.fk_caso_asignado and es_activo=true'),
//            'vsw_asignaciones_documentos' => array(self::HAS_MANY, 'VswAsignacionesDocumentos','','on'=>'t.id_unidad_habitacional=vsw_asignaciones_documentos.fk_caso_asignado'),
//            'vsw_multifamiliar_relation' => array(self::MANY_MANY, 'VswAsignacionesDocumentos','','on'=>'t.id_unidad_habitacional=vsw_asignaciones_documentos.fk_caso_asignado'),
            //'asignaciones' => array(self::BELONGS_TO, 'Asignaciones','','on'=>'t.id_unidad_habitacional=asignaciones.fk_caso_asignado'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_desarrollo' => 'Id Desarrollo',
            'nombre_desarrollo' => 'Nombre Desarrollo',
            'id_unidad_habitacional' => 'Id Unidad Habitacional',
            'nombre_unidad_habitacional' => 'Nombre Unidad Habitacional',
            'cod_estado' => 'Cod Estado',
            'estado' => 'Estado',
            'cantidad_vivienda' => 'Cantidad Vivienda',
            'id_estatus' => 'Id Estatus',
            'estatus' => 'Estatus',
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
//    public function search() {
//        // @todo Please modify the following code to remove attributes that should not be searched.
//
//        $criteria = new CDbCriteria;
//        $criteria->order = 'id_unidad_habitacional DESC';
//        $criteria->compare('id_desarrollo', $this->id_desarrollo);
//        $criteria->compare('nombre_desarrollo', $this->nombre_desarrollo, true);
//        $criteria->compare('id_unidad_habitacional', $this->id_unidad_habitacional);
//        $criteria->compare('nombre_unidad_habitacional', $this->nombre_unidad_habitacional, true);
//        $criteria->compare('cod_estado', $this->cod_estado);
//        $criteria->compare('estado', $this->estado, true);
//        $criteria->compare('cantidad_vivienda', $this->cantidad_vivienda);
//        $criteria->compare('id_estatus', $this->id_estatus);
//        $criteria->compare('estatus', $this->estatus, true);
//
//        return new CActiveDataProvider($this, array(
//            'criteria' => $criteria,
//        ));
//    }
    
    
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.


        $criteria = new CDbCriteria;
//        $criteria->order = 'id_unidad_habitacional DESC';
        $criteria->select = ''
                . 't.nombre_desarrollo, '
                . 't.id_unidad_habitacional, '
                . 't.nombre_unidad_habitacional , '
                . 't.estado , '
                . 'sum(t.cantidad_vivienda) as cantidad , '
                . 'sum(t.cantidad_vivienda) as porcentaje, '
                . 'sum(t.cantidad_vivienda) as total_para_documentar, '
                . 't.estatus_msj, '
                . 't.observaciones';
            
        
        $criteria->compare('t.id_desarrollo', $this->id_desarrollo);
        $criteria->compare('t.nombre_desarrollo', $this->nombre_desarrollo, true);
        $criteria->compare('t.id_unidad_habitacional', $this->id_unidad_habitacional);
        $criteria->compare('t.nombre_unidad_habitacional', $this->nombre_unidad_habitacional, true);
        $criteria->compare('t.cod_estado', $this->cod_estado);
        $criteria->compare('t.estado', $this->estado, true);
        $criteria->compare('t.cantidad_vivienda', $this->cantidad_vivienda);
        $criteria->compare('t.id_estatus', $this->id_estatus);
        $criteria->compare('t.estatus', $this->estatus, true);
        $criteria->compare('t.estatus_msj', $this->estatus_msj, true);
         
        
        if (Yii::app()->user->checkAccess("administrador_documentacion")){
            $criteria->group = 't.nombre_desarrollo, t.id_unidad_habitacional, t.nombre_unidad_habitacional , t.estado, t.estatus_msj, t.observaciones';
        }elseif (Yii::app()->user->checkAccess("analista_documentacion")){
            $criteria->with = array('vsw_asignaciones_documentos'=>array('select'=>''));
            $criteria->compare('vsw_asignaciones_documentos.fk_usuario_asignado', Yii::app()->user->id);
            $criteria->group = 't.nombre_desarrollo, t.id_unidad_habitacional, t.nombre_unidad_habitacional , t.estado, t.estatus_msj, t.observaciones, t.id_desarrollo';
        }
            

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));

    }

    public function searchGroupBy()
    {
        // die('hola');
        $criteria = new CDbCriteria;
        //$criteria->order = 'id_unidad_habitacional DESC';
        $criteria->compare('id_desarrollo', $this->id_desarrollo);
        $criteria->compare('nombre_desarrollo', $this->nombre_desarrollo, true);
        //$criteria->compare('id_unidad_habitacional', $this->id_unidad_habitacional);
        //$criteria->compare('nombre_unidad_habitacional', $this->nombre_unidad_habitacional, true);
        $criteria->compare('cod_estado', $this->cod_estado);
        $criteria->compare('estado', $this->estado, true);
        //$criteria->compare('cantidad_vivienda', $this->cantidad_vivienda);
        //$criteria->compare('id_estatus', $this->id_estatus);
        //$criteria->compare('estatus', $this->estatus, true);
        $criteria->select = 'nombre_desarrollo, id_desarrollo, estado, cod_estado';
        $criteria->group = 'nombre_desarrollo, id_desarrollo, estado, cod_estado';
        $criteria->order = 'estado asc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return VswMultifamiliar the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
