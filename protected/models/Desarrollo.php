<?php

/**
 * This is the model class for table "desarrollo".
 *
 * The followings are the available columns in table 'desarrollo':
 * @property integer $id_desarrollo
 * @property string $nombre
 * @property integer $parroquia_id
 * @property string $descripcion
 * @property string $urban_barrio
 * @property string $av_call_esq_carr
 * @property string $zona
 * @property string $lindero_norte
 * @property string $lindero_sur
 * @property string $lindero_este
 * @property string $lindero_oeste
 * @property string $coordenadas
 * @property string $lote_terreno_mt2
 * @property integer $fuente_financiamiento_id
 * @property integer $ente_ejecutor_id
 * @property boolean $titularidad_del_terreno
 * @property boolean $matricula
 * @property integer $total_viviendas
 * @property integer $total_viviendas_protocolizadas
 * @property string $fecha_transferencia
 * @property integer $fuente_datos_entrada_id
 * @property string $fecha_creacion
 * @property string $fecha_actualizacion
 * @property integer $usuario_id_creacion
 * @property integer $usuario_id_actualizacion
 * @property integer $programa_id
 * @property string $total_unidades
 * @property integer $estatus
 * @property integer $modalidad_documento_id
 * @property integer $propiedad_terreno_id
 * @property integer $ente_titular_terreno_id
 * @property integer $registro_publico_id
 * @property integer $tipo_documento_id
 * @property string $fecha_registro
 * @property string $tomo
 * @property integer $ano
 * @property string $nro_documento
 * @property integer $asiento_registral
 * @property integer $folio_real
 * @property string $num_matricula
 * @property integer $num_protocolo
 
 * * @property integer $estado_rel
 *
 * The followings are the available model relations:
 * @property EnteEjecutor $enteEjecutor
 * @property Maestro $fuenteDatosEntrada
 * @property FuenteFinanciamiento $fuenteFinanciamiento
 * @property FuenteFinanciamientoObra $fuenteFinanciamientoObra
 * @property Programa $programa
 * @property Maestro $estatus0
 * @property CrugeUser $usuarioIdCreacion
 * @property CrugeUser $usuarioIdActualizacion
 * @property BeneficiarioTemporal[] $beneficiarioTemporals
 * @property UnidadHabitacional[] $unidadHabitacionals
 * @property fkParroquia $fkParroquia
 * @property Maestro $modalidad_documento_id
 * @property Maestro $propiedad_terreno_id
 * @property Maestro $ente_titular_terreno_id
 * @property RegistroPublico $registroPublico
 * @property Maestro $tipoDocumento
 * @property Maestro $numProtocolo
 */
class Desarrollo extends CActiveRecord {

    public $estado_rel;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'desarrollo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre, parroquia_id, fuente_financiamiento_id, id_fuente_financiamiento_obra, ente_ejecutor_id,programa_id,  fuente_datos_entrada_id, fecha_creacion, fecha_actualizacion, usuario_id_creacion, estatus, descripcion, urban_barrio, av_call_esq_carr', 'required'),
            array('parroquia_id, fuente_financiamiento_id, ente_ejecutor_id, total_viviendas, total_viviendas_protocolizadas, fuente_datos_entrada_id, usuario_id_creacion, usuario_id_actualizacion, programa_id, estatus, modalidad_documento_id, propiedad_terreno_id, ente_titular_terreno_id, registro_publico_id, tipo_documento_id, ano, asiento_registral, folio_real, num_protocolo', 'numerical', 'integerOnly' => true),
            array('nombre, urban_barrio, av_call_esq_carr, zona, coordenadas', 'length', 'max' => 200),
            array('lindero_norte, lindero_sur, lindero_este, lindero_oeste', 'length', 'max' => 2000),
            array('descripcion', 'length', 'max' => 300),
            array('lote_terreno_mt2', 'length', 'max' => 8),
            
            //array('lote_terreno_mt2', 'type', 'type'=>'float'),
            array('coordenadas', 'length', 'max' => 7),
            array('tomo, nro_documento', 'length', 'max' => 30),
            array('num_matricula', 'length', 'max' => 50),
            array('lote_terreno_mt2, titularidad_del_terreno, matricula, fecha_transferencia,fecha_registro, total_unidades', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_desarrollo, nombre, parroquia_id, descripcion, urban_barrio, av_call_esq_carr, zona, lindero_norte, lindero_sur, lindero_este, lindero_oeste, coordenadas, lote_terreno_mt2, fuente_financiamiento_id, id_fuente_financiamiento_obra, ente_ejecutor_id, titularidad_del_terreno, matricula, total_viviendas, total_viviendas_protocolizadas, fecha_transferencia, fuente_datos_entrada_id, fecha_creacion, fecha_actualizacion, usuario_id_creacion, usuario_id_actualizacion, programa_id, total_unidades, estatus, modalidad_documento_id, propiedad_terreno_id, ente_titular_terreno_id, 
                 registro_publico_id, tipo_documento_id, fecha_registro, tomo, ano, nro_documento, asiento_registral,folio_real, num_matricula, num_protocolo, estado_rel', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'enteEjecutor' => array(self::BELONGS_TO, 'EnteEjecutor', 'ente_ejecutor_id'),
            'fuenteDatosEntrada' => array(self::BELONGS_TO, 'Maestro', 'fuente_datos_entrada_id'),
            'fuenteFinanciamiento' => array(self::BELONGS_TO, 'FuenteFinanciamiento', 'fuente_financiamiento_id'),
            'fuenteFinanciamientoObra' => array(self::BELONGS_TO, 'FuenteFinanciamientoObra', 'id_fuente_financiamiento_obra'),
            'programa' => array(self::BELONGS_TO, 'Programa', 'programa_id'),
            'estatus0' => array(self::BELONGS_TO, 'Maestro', 'estatus'),
            'usuarioIdCreacion' => array(self::BELONGS_TO, 'CrugeUser', 'usuario_id_creacion'),
            'usuarioIdActualizacion' => array(self::BELONGS_TO, 'CrugeUser', 'usuario_id_actualizacion'),
            'beneficiarioTemporals' => array(self::HAS_MANY, 'BeneficiarioTemporal', 'desarrollo_id'),
            'unidadHabitacionals' => array(self::HAS_MANY, 'UnidadHabitacional', 'desarrollo_id'),
            'fkParroquia' => array(self::BELONGS_TO, 'Tblparroquia', 'parroquia_id'),
            'fkModalidadDocumento' => array(self::BELONGS_TO, 'Maestro', 'modalidad_documento_id'),
            'fkPropiedadTerreno' => array(self::BELONGS_TO, 'Maestro', 'propiedad_terreno_id'),
            'fkEnteTitularTerreno' => array(self::BELONGS_TO, 'Maestro', 'ente_titular_terreno_id'),
            'fknumProtocolo' => array(self::BELONGS_TO, 'Maestro', 'num_protocolo'),
            'fktipoDocumentoId' => array(self::BELONGS_TO, 'Maestro', 'tipo_documento_id'),
            'fkregistroPublico' => array(self::BELONGS_TO, 'RegistroPublico', 'registro_publico_id'),
            'vsw_sector' => array(self::BELONGS_TO, 'VswSector', '','on'=>'t.parroquia_id=vsw_sector.cod_parroquia'),
        );
    }

    
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_desarrollo' => 'Nombre del Desarrollo <span  class="required">*<span>',
            'nombre' => 'Nombre del Desarrollo',
            'parroquia_id' => 'Parroquia',
            'descripcion' => 'Descripción del desarrollo',
            'urban_barrio' => 'Indique Urbanización/Barrio',
            'av_call_esq_carr' => 'Indique Avenida/Calle/Esquina/Carretera',
            'zona' => 'Zona',
            'lindero_norte' => 'Lindero Norte',
            'lindero_sur' => 'Lindero Sur',
            'lindero_este' => 'Lindero Este',
            'lindero_oeste' => 'Lindero Oeste',
            'coordenadas' => 'Coordenadas',
            'lote_terreno_mt2' => 'Lote Terreno Mt2',
            'fuente_financiamiento_id' => 'Fuente Financiamiento del Crédito',
            'id_fuente_financiamiento_obra' => 'Fuente Financiamiento de la Obra',
            'ente_ejecutor_id' => 'Ente Ejecutor',
            'titularidad_del_terreno' => 'Titularidad Del Terreno',
            'matricula' => 'Posee Matricula',
            'total_viviendas' => 'Total Viviendas',
            'total_viviendas_protocolizadas' => 'Total Viviendas Protocolizadas',
            'fecha_transferencia' => 'Fecha Transferencia <span  class="required">*<span>',
            'fuente_datos_entrada_id' => 'Fuente Datos Entrada',
            'fecha_creacion' => 'Fecha Creacion',
            'fecha_actualizacion' => 'Fecha Actualizacion',
            'usuario_id_creacion' => 'Usuario Id Creacion',
            'usuario_id_actualizacion' => 'Usuario Id Actualizacion',
            'programa_id' => 'Programa',
            'total_unidades' => 'Total Unidades',
            'estatus' => 'Estatus',
            'modalidad_documento_id' => 'Modalidad del Documento',
            'propiedad_terreno_id' => 'Propiedad del Terreno',
            'ente_titular_terreno_id' => 'Ente Titular del Terreno',
            'registro_publico_id' => 'Registro Público <span  class="required">*<span>',
            'tipo_documento_id' => 'Tipo de Documento',
            'fecha_registro' => 'Fecha Registro <span  class="required">*<span>',
            'tomo' => 'Tomo',
            'ano' => 'Año',
            'nro_documento' => 'Número de Documento <span  class="required">*<span>',
            'asiento_registral' => 'Asiento Registral ',
            'folio_real' => 'Folio Real ',
            'num_matricula' => 'Número de Matricula',
            'num_protocolo' => 'Número de Protocolo',
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
        $criteria->order = 'id_desarrollo DESC';


        $criteria->compare('id_desarrollo', $this->id_desarrollo);
        $criteria->compare('LOWER(nombre)', strtolower($this->nombre), true);
        $criteria->compare('parroquia_id', $this->parroquia_id);
        $criteria->compare('descripcion', $this->descripcion, true);
        $criteria->compare('urban_barrio', $this->urban_barrio, true);
        $criteria->compare('av_call_esq_carr', $this->av_call_esq_carr, true);
        $criteria->compare('zona', $this->zona, true);
        $criteria->compare('lindero_norte', $this->lindero_norte, true);
        $criteria->compare('lindero_sur', $this->lindero_sur, true);
        $criteria->compare('lindero_este', $this->lindero_este, true);
        $criteria->compare('lindero_oeste', $this->lindero_oeste, true);
        $criteria->compare('coordenadas', $this->coordenadas, true);
        $criteria->compare('lote_terreno_mt2', $this->lote_terreno_mt2, true);
        $criteria->compare('fuente_financiamiento_id', $this->fuente_financiamiento_id);
        $criteria->compare('id_fuente_financiamiento_obra', $this->id_fuente_financiamiento_obra);
        $criteria->compare('ente_ejecutor_id', $this->ente_ejecutor_id);
        $criteria->compare('titularidad_del_terreno', $this->titularidad_del_terreno);
        $criteria->compare('matricula', $this->matricula);
        $criteria->compare('total_viviendas', $this->total_viviendas);
        $criteria->compare('total_viviendas_protocolizadas', $this->total_viviendas_protocolizadas);
        $criteria->compare('fecha_transferencia', $this->fecha_transferencia, true);
        $criteria->compare('fuente_datos_entrada_id', $this->fuente_datos_entrada_id);
        $criteria->compare('fecha_creacion', $this->fecha_creacion, true);
        $criteria->compare('fecha_actualizacion', $this->fecha_actualizacion, true);
        $criteria->compare('usuario_id_creacion', $this->usuario_id_creacion);
        $criteria->compare('usuario_id_actualizacion', $this->usuario_id_actualizacion);
        $criteria->compare('programa_id', $this->programa_id);
        $criteria->compare('total_unidades', $this->total_unidades, true);
        $criteria->compare('estatus', $this->estatus);
        $criteria->compare('modalidad_documento_id', $this->modalidad_documento_id);
        $criteria->compare('propiedad_terreno_id', $this->propiedad_terreno_id);
        $criteria->compare('ente_titular_terreno_id', $this->ente_titular_terreno_id);
        $criteria->compare('registro_publico_id', $this->registro_publico_id);
        $criteria->compare('tipo_documento_id', $this->tipo_documento_id);
        $criteria->compare('fecha_registro', $this->fecha_registro, true);
        $criteria->compare('tomo', $this->tomo, true);
        $criteria->compare('ano', $this->ano);
        $criteria->compare('nro_documento', $this->nro_documento, true);
        $criteria->compare('asiento_registral', $this->asiento_registral);
        $criteria->compare('folio_real', $this->folio_real);
        $criteria->compare('num_matricula', $this->num_matricula);
        $criteria->compare('num_protocolo', $this->num_protocolo);
        
        $criteria->with = array('vsw_sector'=>array('select'=>''));
        $criteria->compare('cod_estado', $this->estado_rel);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Desarrollo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
