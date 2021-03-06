<?php

/**
 * This is the model class for table "vsw_censo_validado_faov_fasp".
 *
 * The followings are the available columns in table 'vsw_censo_validado_faov_fasp':
 * @property integer $id_beneficiario
 * @property integer $id_beneficiario_temporal
 * @property integer $cedula
 * @property string $nombre_completo
 * @property integer $cod_estado
 * @property string $estado
 * @property integer $id_desarrollo
 * @property string $nombre
 * @property integer $id_fuente_financiamiento
 * @property string $nombre_fuente_financiamiento
 * @property integer $iduser
 * @property string $empadronador_usuario
 */
class VswCensoValidadoFaovFasp extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function primaryKey() {
        return 'id_beneficiario';
    }

    public function tableName() {
        return 'vsw_censo_validado_faov_fasp';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_beneficiario, id_beneficiario_temporal, cedula, cod_estado, id_desarrollo, id_fuente_financiamiento, iduser', 'numerical', 'integerOnly' => true),
            array('nombre_completo, nombre, nombre_fuente_financiamiento', 'length', 'max' => 200),
            array('estado', 'length', 'max' => 250),
            array('empadronador_usuario', 'length', 'max' => 64),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_beneficiario, id_beneficiario_temporal, cedula, nombre_completo, cod_estado, estado, id_desarrollo, nombre, id_fuente_financiamiento, nombre_fuente_financiamiento, iduser, empadronador_usuario', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_beneficiario' => 'Id Beneficiario',
            'id_beneficiario_temporal' => 'Id Beneficiario Temporal',
            'cedula' => 'Cedula',
            'nombre_completo' => 'Nombre Completo',
            'cod_estado' => 'Cod Estado',
            'estado' => 'Estado',
            'id_desarrollo' => 'Id Desarrollo',
            'nombre' => 'Nombre',
            'id_fuente_financiamiento' => 'Id Fuente Financiamiento',
            'nombre_fuente_financiamiento' => 'Nombre Fuente Financiamiento',
            'iduser' => 'Iduser',
            'empadronador_usuario' => 'Empadronador Usuario',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_beneficiario', $this->id_beneficiario);
        $criteria->compare('id_beneficiario_temporal', $this->id_beneficiario_temporal);
        $criteria->compare('cedula', $this->cedula);
        $criteria->compare('nombre_completo', $this->nombre_completo, true);
        $criteria->compare('cod_estado', $this->cod_estado);
        $criteria->compare('estado', $this->estado, true);
        $criteria->compare('id_desarrollo', $this->id_desarrollo);
        $criteria->compare('nombre', $this->nombre, true);
        $criteria->compare('id_fuente_financiamiento', $this->id_fuente_financiamiento);
        $criteria->compare('nombre_fuente_financiamiento', $this->nombre_fuente_financiamiento, true);
        $criteria->compare('iduser', $this->iduser);
        $criteria->compare('empadronador_usuario', $this->empadronador_usuario, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return VswCensoValidadoFaovFasp the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
