<?php

/**
 * This is the model class for table "analisis_credito".
 *
 * The followings are the available columns in table 'analisis_credito':
 * @property integer $id_analisis_credito
 * @property integer $nro_serial_bancario
 * @property integer $vivienda_id
 * @property integer $unidad_familiar_id
 * @property integer $tipo_documento_id
 * @property string $ingreso_total_familiar
 * @property string $monto_credito
 * @property string $monto_inicial
 * @property string $sub_directo_habitacional
 * @property string $sub_vivienda_perdida
 * @property integer $plazo_credito_ano
 * @property integer $nro_cuotas
 * @property string $monto_cuota_financiera
 * @property string $monto_cuota_f_total
 * @property string $monto_prima_inicial_fg
 * @property string $alicuota_fondo_garantia
 * @property string $fecha_protocolizacion
 * @property integer $tasa_interes_id
 * @property integer $tasa_mora_id
 * @property string $tasa_fongar_id
 * @property integer $plazo_gracia
 * @property integer $plazo_diferido
 * @property integer $status_migracion_id
 * @property integer $gen_banco_id
 * @property string $tipo_cuenta
 * @property string $nro_cuenta_bancario
 * @property integer $fuente_datos_entrada_id
 * @property string $fecha_creacion
 * @property string $fecha_actualizacion
 * @property integer $usuario_id_creacion
 * @property integer $usuario_id_actualizacion
 * @property integer $estatus
 * @property integer $fuente_financiamiento_id
 * @property integer $programa_id
 * @property string $maxima_capacidad_pago
 * @property string $monto_cuota_finan_requerida
 * @property string $max_cuota_finan_porct
 * @property string $diferencia_pago
 * @property integer $subsidio_id_fasp
 * @property boolean $cuota_extraordinarias
 * @property string $comision_flat
 * @property string $fecha_analisis
 *
 * The followings are the available model relations:
 * @property RegistroDocumento[] $registroDocumentos
 * @property TablaSubsidio $subsidioIdFasp
 * @property Vivienda $vivienda
 * @property Maestro $estatus0
 * @property FuenteFinanciamiento $fuenteFinanciamiento
 * @property Programa $programa
 * @property TablaSubsidio $subsidioIdFasp
 * @property TasaInteres $tasaInteres
 * @property Maestro $tipoDocumento
 * @property UnidadFamiliar $unidadFamiliar
 * @property Vivienda $vivienda
 */
class AnalisisCredito extends CActiveRecord {

    public $costo_vivienda;
//    public $vivienda;
    public $ultimo_sueldo;
    public $reconocimiento;
    public $cuotaextraordinaria;
    public $desarrollo;
    public $unidad_habitacional;
    public $tipo_vivienda;
    public $nro_vivienda;
    public $nombre_fuente_financiamiento;
    public $nombre_programa;
    public $ingreso_mensual_nuevo;

	/**
	 * @return string the associated database table name
	 */
    public function tableName() {
		return 'analisis_credito';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vivienda_id, unidad_familiar_id, tipo_documento_id, ingreso_total_familiar, monto_credito, plazo_credito_ano, nro_cuotas, monto_cuota_financiera, monto_prima_inicial_fg, fecha_protocolizacion, tasa_interes_id, tasa_fongar_id, fuente_datos_entrada_id, fecha_creacion, fecha_actualizacion, usuario_id_creacion, estatus, fuente_financiamiento_id, programa_id', 'required'),
			array('nro_serial_bancario, vivienda_id, unidad_familiar_id, tipo_documento_id, plazo_credito_ano, nro_cuotas, tasa_interes_id, tasa_mora_id, plazo_gracia, plazo_diferido, status_migracion_id, gen_banco_id, fuente_datos_entrada_id, usuario_id_creacion, usuario_id_actualizacion, estatus, fuente_financiamiento_id, programa_id, subsidio_id_fasp', 'numerical', 'integerOnly'=>true),
			array('tipo_cuenta', 'length', 'max'=>10),
			array('nro_cuenta_bancario', 'length', 'max'=>20),
			array('monto_inicial, sub_directo_habitacional, sub_vivienda_perdida, monto_cuota_f_total, alicuota_fondo_garantia, maxima_capacidad_pago, monto_cuota_finan_requerida, max_cuota_finan_porct, diferencia_pago, cuota_extraordinarias, comision_flat,flat, fecha_analisis', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_analisis_credito, nro_serial_bancario, vivienda_id, unidad_familiar_id, tipo_documento_id, ingreso_total_familiar, monto_credito, monto_inicial, sub_directo_habitacional, sub_vivienda_perdida, plazo_credito_ano, nro_cuotas, monto_cuota_financiera, monto_cuota_f_total, monto_prima_inicial_fg, alicuota_fondo_garantia, fecha_protocolizacion, tasa_interes_id, tasa_mora_id, tasa_fongar_id, plazo_gracia, plazo_diferido, status_migracion_id, gen_banco_id, tipo_cuenta, nro_cuenta_bancario, fuente_datos_entrada_id, fecha_creacion, fecha_actualizacion, usuario_id_creacion, usuario_id_actualizacion, estatus, fuente_financiamiento_id, programa_id, maxima_capacidad_pago, monto_cuota_finan_requerida, max_cuota_finan_porct, diferencia_pago, subsidio_id_fasp, cuota_extraordinarias, comision_flat, fecha_analisis', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
    public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'registroDocumentos' => array(self::HAS_MANY, 'RegistroDocumento', 'analisis_credito_id'),
            'subsidioIdFasp' => array(self::BELONGS_TO, 'TablaSubsidio', 'subsidio_id_fasp'),
            'vivienda' => array(self::BELONGS_TO, 'Vivienda', 'vivienda_id'),
			'estatus0' => array(self::BELONGS_TO, 'Maestro', 'estatus'),
			'fuenteFinanciamiento' => array(self::BELONGS_TO, 'FuenteFinanciamiento', 'fuente_financiamiento_id'),
			'programa' => array(self::BELONGS_TO, 'Programa', 'programa_id'),
          //            'tasaFongar' => array(self::BELONGS_TO, 'TasaFongar', 'tasa_fongar_id'),
			'tasaInteres' => array(self::BELONGS_TO, 'TasaInteres', 'tasa_interes_id'),
			'tipoDocumento' => array(self::BELONGS_TO, 'Maestro', 'tipo_documento_id'),
			'unidadFamiliar' => array(self::BELONGS_TO, 'UnidadFamiliar', 'unidad_familiar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels() {
		return array(
			'id_analisis_credito' => 'Id Analisis Credito',
			'nro_serial_bancario' => 'Nro Serial Bancario',
			'vivienda_id' => 'Vivienda',
			'unidad_familiar_id' => 'Unidad Familiar',
			'tipo_documento_id' => 'Tipo Documento',
			'ingreso_total_familiar' => 'Ingreso Total Familiar',
			'monto_credito' => 'Monto Credito',
			'monto_inicial' => 'Monto Inicial',
			'sub_directo_habitacional' => 'Sub Directo Habitacional',
			'sub_vivienda_perdida' => 'Sub Vivienda Perdida',
            'plazo_credito_ano' => 'Plazo Credito Año',
			'nro_cuotas' => 'Nro Cuotas',
			'monto_cuota_financiera' => 'Monto Cuota Financiera',
			'monto_cuota_f_total' => 'Monto Cuota F Total',
			'monto_prima_inicial_fg' => 'Monto Prima Inicial Fg',
			'alicuota_fondo_garantia' => 'Alicuota Fondo Garantia',
                        'fecha_protocolizacion' => 'Fecha de Analisis',
			'tasa_interes_id' => 'Tasa Interes',
			'tasa_mora_id' => 'Tasa Mora',
			'tasa_fongar_id' => 'Tasa Fongar',
			'plazo_gracia' => 'Plazo Gracia',
			'plazo_diferido' => 'Plazo Diferido',
			'status_migracion_id' => 'Status Migracion',
			'gen_banco_id' => 'Gen Banco',
			'tipo_cuenta' => 'Tipo Cuenta',
			'nro_cuenta_bancario' => 'Nro Cuenta Bancario',
			'fuente_datos_entrada_id' => 'Fuente Datos Entrada',
			'fecha_creacion' => 'Fecha Creacion',
			'fecha_actualizacion' => 'Fecha Actualizacion',
			'usuario_id_creacion' => 'Usuario Id Creacion',
			'usuario_id_actualizacion' => 'Usuario Id Actualizacion',
			'estatus' => 'Estatus',
			'fuente_financiamiento_id' => 'Fuente Financiamiento',
			'programa_id' => 'Programa',
            'reconocimiento' => 'Reconocimiento de Vivienda Perdida',
			'maxima_capacidad_pago' => 'Maxima Capacidad Pago',
			'monto_cuota_finan_requerida' => 'Monto Cuota Finan Requerida',
			'max_cuota_finan_porct' => 'Max Cuota Finan Porct',
			'diferencia_pago' => 'Diferencia Pago',
			'subsidio_id_fasp' => 'Subsidio Id Fasp',
			'cuota_extraordinarias' => 'Cuota Extraordinarias',
            'comision_flat' => 'Comision Flat faov',
            'flat' => 'Comision Flat',
            'desarrollo' => 'Desarrollo Habitacional',
            'unidad_habitacional' => 'Unidad Multifamiliar',
            'tipo_vivienda' => 'Tipo de Vivienda',
            'costo_vivienda' => 'Costo de la Vivienda',
            'ultimo_sueldo' => 'Último Sueldo',
            'nro_vivienda' => 'Número de la Vivienda',
            'nombre_programa' => 'Programa',
            'nombre_fuente_financiamiento' => 'Fuente de Financiamiento',
                    'fecha_analisis' => 'Fecha Analisis',
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

		$criteria=new CDbCriteria;

        $criteria->compare('id_analisis_credito', $this->id_analisis_credito);
        $criteria->compare('nro_serial_bancario', $this->nro_serial_bancario);
        $criteria->compare('vivienda_id', $this->vivienda_id);
        $criteria->compare('unidad_familiar_id', $this->unidad_familiar_id);
        $criteria->compare('tipo_documento_id', $this->tipo_documento_id);
        $criteria->compare('ingreso_total_familiar', $this->ingreso_total_familiar, true);
        $criteria->compare('monto_credito', $this->monto_credito, true);
        $criteria->compare('monto_inicial', $this->monto_inicial, true);
        $criteria->compare('sub_directo_habitacional', $this->sub_directo_habitacional, true);
        $criteria->compare('sub_vivienda_perdida', $this->sub_vivienda_perdida, true);
        $criteria->compare('plazo_credito_ano', $this->plazo_credito_ano);
        $criteria->compare('nro_cuotas', $this->nro_cuotas);
        $criteria->compare('monto_cuota_financiera', $this->monto_cuota_financiera, true);
        $criteria->compare('monto_cuota_f_total', $this->monto_cuota_f_total, true);
        $criteria->compare('monto_prima_inicial_fg', $this->monto_prima_inicial_fg, true);
        $criteria->compare('alicuota_fondo_garantia', $this->alicuota_fondo_garantia, true);
        $criteria->compare('fecha_protocolizacion', $this->fecha_protocolizacion, true);
        $criteria->compare('tasa_interes_id', $this->tasa_interes_id);
        $criteria->compare('tasa_mora_id', $this->tasa_mora_id);
//        $criteria->compare('tasa_fongar_id', $this->tasa_fongar_id);
        $criteria->compare('plazo_gracia', $this->plazo_gracia);
        $criteria->compare('plazo_diferido', $this->plazo_diferido);
        $criteria->compare('status_migracion_id', $this->status_migracion_id);
        $criteria->compare('gen_banco_id', $this->gen_banco_id);
        $criteria->compare('tipo_cuenta', $this->tipo_cuenta, true);
        $criteria->compare('nro_cuenta_bancario', $this->nro_cuenta_bancario, true);
        $criteria->compare('fuente_datos_entrada_id', $this->fuente_datos_entrada_id);
        $criteria->compare('fecha_creacion', $this->fecha_creacion, true);
        $criteria->compare('fecha_actualizacion', $this->fecha_actualizacion, true);
        $criteria->compare('usuario_id_creacion', $this->usuario_id_creacion);
        $criteria->compare('usuario_id_actualizacion', $this->usuario_id_actualizacion);
        $criteria->compare('estatus', $this->estatus);
        $criteria->compare('fuente_financiamiento_id', $this->fuente_financiamiento_id);
        $criteria->compare('programa_id', $this->programa_id);
        $criteria->compare('maxima_capacidad_pago', $this->maxima_capacidad_pago, true);
        $criteria->compare('monto_cuota_finan_requerida', $this->monto_cuota_finan_requerida, true);
        $criteria->compare('max_cuota_finan_porct', $this->max_cuota_finan_porct, true);
        $criteria->compare('diferencia_pago', $this->diferencia_pago, true);
        $criteria->compare('subsidio_id_fasp', $this->subsidio_id_fasp);
        $criteria->compare('cuota_extraordinarias', $this->cuota_extraordinarias);
        $criteria->compare('fecha_analisis',$this->fecha_analisis,true);

		return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AnalisisCredito the static model class
	 */
    public static function model($className = __CLASS__) {
		return parent::model($className);
	}

}
