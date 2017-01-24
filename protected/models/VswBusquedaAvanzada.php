<?php

/**
 * This is the model class for table "vsw_busqueda_avanzada".
 *
 * The followings are the available columns in table 'vsw_busqueda_avanzada':
 * @property integer $id_beneficiario_temporal
 * @property string $rif
 * @property integer $id_nacionalidad
 * @property string $nacionalidad
 * @property string $nombre_completo
 * @property integer $id_estatus_adjudicado
 * @property string $estatus_adjudicado
 * @property integer $id_desarrollo
 * @property string $nombre_desarrollo
 * @property integer $cod_estado
 * @property string $estado
 * @property integer $cod_municipio
 * @property string $municipio
 * @property integer $cod_parroquia
 * @property string $parroquia
 * @property string $urban_barrio
 * @property string $av_call_esq_carr
 * @property string $zona
 * @property string $lindero_norte_desarrollo
 * @property string $lindero_sur_desarrollo
 * @property string $lindero_este_desarrollo
 * @property string $lindero_oeste_desarrollo
 * @property integer $id_parcela
 * @property string $nombre_parcela
 * @property integer $id_unidad_habitacional
 * @property string $nombre_unidad_habitacional
 * @property string $lindero_norte_unidad_habitacional
 * @property string $lindero_sur_unidad_habitacional
 * @property string $lindero_este_unidad_habitacional
 * @property string $lindero_oeste_unidad_habitacional
 * @property integer $id_tipo_inmueble
 * @property string $tipo_inmueble
 * @property integer $id_vivienda
 * @property string $nro_piso
 * @property string $nro_vivienda
 * @property string $lindero_norte_vivienda
 * @property string $lindero_sur_vivienda
 * @property string $lindero_este_vivienda
 * @property string $lindero_oeste_vivienda
 * @property integer $nro_banos
 * @property integer $nro_habitaciones
 * @property integer $nro_banos_auxiliar
 * @property string $construccion_mt2
 * @property integer $tipo_vivienda_id
 * @property string $tipo_vivienda
 * @property integer $id_fuente_financiamiento
 * @property string $nombre_fuente_financiamiento
 * @property integer $id_programa
 * @property string $nombre_programa
 * @property integer $id_ente_ejecutor
 * @property string $nombre_ente_ejecutor
 * @property integer $id_beneficiario
 * @property integer $condicion_trabajo_id
 * @property string $condicion_trabajo
 * @property integer $condicion_laboral_id
 * @property string $condicion_laboral
 * @property integer $fuente_ingreso_id
 * @property string $fuente_ingreso
 * @property integer $relacion_trabajo_id
 * @property string $relacion_trabajo
 * @property integer $sector_trabajo_id
 * @property string $sector_trabajo
 * @property string $nombre_empresa
 * @property string $direccion_empresa
 * @property string $telefono_trabajo
 * @property integer $gen_cargo_id
 * @property string $cargo
 * @property string $ingreso_mensual
 * @property string $ingreso_declarado
 * @property string $ingreso_promedio_faov
 * @property string $cotiza_faov
 * @property string $direccion_anterior
 * @property string $urban_barrio_anterior
 * @property string $av_call_esq_carr_anterior
 * @property string $zona_anterior
 * @property integer $cod_estado_anterior
 * @property string $estado_anetrior
 * @property integer $cod_municipio_anterior
 * @property string $municipio_anterior
 * @property integer $cod_parroquia_anterior
 * @property string $parroquia_anterior
 * @property string $nombre_unidad_familiar
 * @property integer $condicion_unidad_familiar_id
 * @property string $condicion_unidad_familiar
 * @property integer $total_personas_cotizando
 * @property string $ingreso_total_familiar
 * @property string $ingreso_total_familiar_suma_faov
 * @property string $observacion
 */
class VswBusquedaAvanzada extends CActiveRecord
{


    public function primaryKey() {
        return 'id_beneficiario_temporal';
    }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vsw_busqueda_avanzada';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_beneficiario_temporal, id_nacionalidad, id_estatus_adjudicado, id_desarrollo, cod_estado, cod_municipio, cod_parroquia, id_parcela, id_unidad_habitacional, id_tipo_inmueble, id_vivienda, nro_banos, nro_habitaciones, nro_banos_auxiliar, tipo_vivienda_id, id_fuente_financiamiento, id_programa, id_ente_ejecutor, id_beneficiario, condicion_trabajo_id, condicion_laboral_id, fuente_ingreso_id, relacion_trabajo_id, sector_trabajo_id, gen_cargo_id, cod_estado_anterior, cod_municipio_anterior, cod_parroquia_anterior, condicion_unidad_familiar_id, total_personas_cotizando', 'numerical', 'integerOnly'=>true),
			array('rif', 'length', 'max'=>12),
			array('nombre_completo, nombre_desarrollo, urban_barrio, av_call_esq_carr, zona, lindero_norte_desarrollo, lindero_sur_desarrollo, lindero_este_desarrollo, lindero_oeste_desarrollo, lindero_norte_unidad_habitacional, lindero_sur_unidad_habitacional, lindero_este_unidad_habitacional, lindero_oeste_unidad_habitacional, lindero_norte_vivienda, lindero_sur_vivienda, lindero_este_vivienda, lindero_oeste_vivienda, nombre_fuente_financiamiento, nombre_ente_ejecutor, nombre_empresa, direccion_empresa, direccion_anterior, urban_barrio_anterior, av_call_esq_carr_anterior, zona_anterior', 'length', 'max'=>200),
			array('estado, municipio, parroquia, estado_anetrior, municipio_anterior, parroquia_anterior', 'length', 'max'=>250),
			array('nombre_unidad_habitacional, nombre_programa, nombre_unidad_familiar', 'length', 'max'=>100),
			array('nro_piso, nro_vivienda, construccion_mt2', 'length', 'max'=>10),
			array('telefono_trabajo', 'length', 'max'=>11),
			array('ingreso_total_familiar', 'length', 'max'=>16),
			array('observacion', 'length', 'max'=>800),
			array('nacionalidad, estatus_adjudicado, nombre_parcela, tipo_inmueble, tipo_vivienda, condicion_trabajo, condicion_laboral, fuente_ingreso, relacion_trabajo, sector_trabajo, cargo, ingreso_mensual, ingreso_declarado, ingreso_promedio_faov, cotiza_faov, condicion_unidad_familiar, ingreso_total_familiar_suma_faov', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_beneficiario_temporal, rif, id_nacionalidad, nacionalidad, nombre_completo, id_estatus_adjudicado, estatus_adjudicado, id_desarrollo, nombre_desarrollo, cod_estado, estado, cod_municipio, municipio, cod_parroquia, parroquia, urban_barrio, av_call_esq_carr, zona, lindero_norte_desarrollo, lindero_sur_desarrollo, lindero_este_desarrollo, lindero_oeste_desarrollo, id_parcela, nombre_parcela, id_unidad_habitacional, nombre_unidad_habitacional, lindero_norte_unidad_habitacional, lindero_sur_unidad_habitacional, lindero_este_unidad_habitacional, lindero_oeste_unidad_habitacional, id_tipo_inmueble, tipo_inmueble, id_vivienda, nro_piso, nro_vivienda, lindero_norte_vivienda, lindero_sur_vivienda, lindero_este_vivienda, lindero_oeste_vivienda, nro_banos, nro_habitaciones, nro_banos_auxiliar, construccion_mt2, tipo_vivienda_id, tipo_vivienda, id_fuente_financiamiento, nombre_fuente_financiamiento, id_programa, nombre_programa, id_ente_ejecutor, nombre_ente_ejecutor, id_beneficiario, condicion_trabajo_id, condicion_trabajo, condicion_laboral_id, condicion_laboral, fuente_ingreso_id, fuente_ingreso, relacion_trabajo_id, relacion_trabajo, sector_trabajo_id, sector_trabajo, nombre_empresa, direccion_empresa, telefono_trabajo, gen_cargo_id, cargo, ingreso_mensual, ingreso_declarado, ingreso_promedio_faov, cotiza_faov, direccion_anterior, urban_barrio_anterior, av_call_esq_carr_anterior, zona_anterior, cod_estado_anterior, estado_anetrior, cod_municipio_anterior, municipio_anterior, cod_parroquia_anterior, parroquia_anterior, nombre_unidad_familiar, condicion_unidad_familiar_id, condicion_unidad_familiar, total_personas_cotizando, ingreso_total_familiar, ingreso_total_familiar_suma_faov, observacion', 'safe', 'on'=>'search'),
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
			'id_beneficiario_temporal' => 'Id Beneficiario Temporal',
			'rif' => 'Rif',
			'id_nacionalidad' => 'Nacionalidad',
			'nacionalidad' => 'Nacionalidad',
			'nombre_completo' => 'Nombre Completo',
			'id_estatus_adjudicado' => 'Estatus Adjudicado',
			'estatus_adjudicado' => 'Estatus Adjudicado',
			'id_desarrollo' => 'Id Desarrollo',
			'nombre_desarrollo' => 'Nombre Desarrollo',
			'cod_estado' => 'Estado',
			'estado' => 'Estado',
			'cod_municipio' => 'Municipio',
			'municipio' => 'Municipio',
			'cod_parroquia' => 'Parroquia',
			'parroquia' => 'Parroquia',
			'urban_barrio' => 'Urban Barrio',
			'av_call_esq_carr' => 'Av Call Esq Carr',
			'zona' => 'Zona',
			'lindero_norte_desarrollo' => 'Lindero Norte Desarrollo',
			'lindero_sur_desarrollo' => 'Lindero Sur Desarrollo',
			'lindero_este_desarrollo' => 'Lindero Este Desarrollo',
			'lindero_oeste_desarrollo' => 'Lindero Oeste Desarrollo',
			'id_parcela' => 'Id Parcela',
			'nombre_parcela' => 'Nombre Parcela',
			'id_unidad_habitacional' => 'Id Unidad Habitacional',
			'nombre_unidad_habitacional' => 'Nombre Unidad Habitacional',
			'lindero_norte_unidad_habitacional' => 'Lindero Norte Unidad Habitacional',
			'lindero_sur_unidad_habitacional' => 'Lindero Sur Unidad Habitacional',
			'lindero_este_unidad_habitacional' => 'Lindero Este Unidad Habitacional',
			'lindero_oeste_unidad_habitacional' => 'Lindero Oeste Unidad Habitacional',
			'id_tipo_inmueble' => 'Tipo Inmueble',
			'tipo_inmueble' => 'Tipo Inmueble',
			'id_vivienda' => 'Id Vivienda',
			'nro_piso' => 'Nro Piso',
			'nro_vivienda' => 'Nro Vivienda',
			'lindero_norte_vivienda' => 'Lindero Norte Vivienda',
			'lindero_sur_vivienda' => 'Lindero Sur Vivienda',
			'lindero_este_vivienda' => 'Lindero Este Vivienda',
			'lindero_oeste_vivienda' => 'Lindero Oeste Vivienda',
			'nro_banos' => 'Nro Banos',
			'nro_habitaciones' => 'Nro Habitaciones',
			'nro_banos_auxiliar' => 'Nro Banos Auxiliar',
			'construccion_mt2' => 'Construccion Mt2',
			'tipo_vivienda_id' => 'Tipo Vivienda',
			'tipo_vivienda' => 'Tipo Vivienda',
			'id_fuente_financiamiento' => 'Fuente Financiamiento',
			'nombre_fuente_financiamiento' => 'Nombre Fuente Financiamiento',
			'id_programa' => 'Programa',
			'nombre_programa' => 'Nombre Programa',
			'id_ente_ejecutor' => 'Ente Ejecutor',
			'nombre_ente_ejecutor' => 'Nombre Ente Ejecutor',
			'id_beneficiario' => 'Id Beneficiario',
			'condicion_trabajo_id' => 'Condicion Trabajo',
			'condicion_trabajo' => 'Condicion Trabajo',
			'condicion_laboral_id' => 'Condicion Laboral',
			'condicion_laboral' => 'Condicion Laboral',
			'fuente_ingreso_id' => 'Fuente Ingreso',
			'fuente_ingreso' => 'Fuente Ingreso',
			'relacion_trabajo_id' => 'Relacion Trabajo',
			'relacion_trabajo' => 'Relacion Trabajo',
			'sector_trabajo_id' => 'Sector Trabajo',
			'sector_trabajo' => 'Sector Trabajo',
			'nombre_empresa' => 'Nombre Empresa',
			'direccion_empresa' => 'Direccion Empresa',
			'telefono_trabajo' => 'Telefono Trabajo',
			'gen_cargo_id' => 'Gen Cargo',
			'cargo' => 'Cargo',
			'ingreso_mensual' => 'Ingreso Mensual',
			'ingreso_declarado' => 'Ingreso Declarado',
			'ingreso_promedio_faov' => 'Ingreso Promedio Faov',
			'cotiza_faov' => 'Cotiza Faov',
			'direccion_anterior' => 'Direccion Anterior',
			'urban_barrio_anterior' => 'Urban Barrio Anterior',
			'av_call_esq_carr_anterior' => 'Av Call Esq Carr Anterior',
			'zona_anterior' => 'Zona Anterior',
			'cod_estado_anterior' => 'Cod Estado Anterior',
			'estado_anetrior' => 'Estado Anetrior',
			'cod_municipio_anterior' => 'Cod Municipio Anterior',
			'municipio_anterior' => 'Municipio Anterior',
			'cod_parroquia_anterior' => 'Cod Parroquia Anterior',
			'parroquia_anterior' => 'Parroquia Anterior',
			'nombre_unidad_familiar' => 'Nombre Unidad Familiar',
			'condicion_unidad_familiar_id' => 'Condicion Unidad Familiar',
			'condicion_unidad_familiar' => 'Condicion Unidad Familiar',
			'total_personas_cotizando' => 'Total Personas Cotizando',
			'ingreso_total_familiar' => 'Ingreso Total Familiar',
			'ingreso_total_familiar_suma_faov' => 'Ingreso Total Familiar Suma Faov',
			'observacion' => 'Observacion',
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

		$criteria->compare('id_beneficiario_temporal',$this->id_beneficiario_temporal);
		$criteria->compare('rif',$this->rif,true);
		$criteria->compare('id_nacionalidad',$this->id_nacionalidad);
		$criteria->compare('nacionalidad',$this->nacionalidad,true);
		$criteria->compare('LOWER(nombre_completo)',strtolower($this->nombre_completo),true);
		$criteria->compare('id_estatus_adjudicado',$this->id_estatus_adjudicado);
		$criteria->compare('estatus_adjudicado',$this->estatus_adjudicado,true);
		$criteria->compare('id_desarrollo',$this->id_desarrollo);
		$criteria->compare('LOWER(nombre_desarrollo)', strtolower($this->nombre_desarrollo), true);
		$criteria->compare('cod_estado',$this->cod_estado);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('cod_municipio',$this->cod_municipio);
		$criteria->compare('municipio',$this->municipio,true);
		$criteria->compare('cod_parroquia',$this->cod_parroquia);
		$criteria->compare('parroquia',$this->parroquia,true);
		$criteria->compare('urban_barrio',$this->urban_barrio,true);
		$criteria->compare('av_call_esq_carr',$this->av_call_esq_carr,true);
		$criteria->compare('zona',$this->zona,true);
		$criteria->compare('lindero_norte_desarrollo',$this->lindero_norte_desarrollo,true);
		$criteria->compare('lindero_sur_desarrollo',$this->lindero_sur_desarrollo,true);
		$criteria->compare('lindero_este_desarrollo',$this->lindero_este_desarrollo,true);
		$criteria->compare('lindero_oeste_desarrollo',$this->lindero_oeste_desarrollo,true);
		$criteria->compare('id_parcela',$this->id_parcela);
		$criteria->compare('nombre_parcela',$this->nombre_parcela,true);
		$criteria->compare('id_unidad_habitacional',$this->id_unidad_habitacional);
		$criteria->compare('nombre_unidad_habitacional',$this->nombre_unidad_habitacional,true);
		$criteria->compare('lindero_norte_unidad_habitacional',$this->lindero_norte_unidad_habitacional,true);
		$criteria->compare('lindero_sur_unidad_habitacional',$this->lindero_sur_unidad_habitacional,true);
		$criteria->compare('lindero_este_unidad_habitacional',$this->lindero_este_unidad_habitacional,true);
		$criteria->compare('lindero_oeste_unidad_habitacional',$this->lindero_oeste_unidad_habitacional,true);
		$criteria->compare('id_tipo_inmueble',$this->id_tipo_inmueble);
		$criteria->compare('tipo_inmueble',$this->tipo_inmueble,true);
		$criteria->compare('id_vivienda',$this->id_vivienda);
		$criteria->compare('nro_piso',$this->nro_piso,true);
		$criteria->compare('nro_vivienda',$this->nro_vivienda,true);
		$criteria->compare('lindero_norte_vivienda',$this->lindero_norte_vivienda,true);
		$criteria->compare('lindero_sur_vivienda',$this->lindero_sur_vivienda,true);
		$criteria->compare('lindero_este_vivienda',$this->lindero_este_vivienda,true);
		$criteria->compare('lindero_oeste_vivienda',$this->lindero_oeste_vivienda,true);
		$criteria->compare('nro_banos',$this->nro_banos);
		$criteria->compare('nro_habitaciones',$this->nro_habitaciones);
		$criteria->compare('nro_banos_auxiliar',$this->nro_banos_auxiliar);
		$criteria->compare('construccion_mt2',$this->construccion_mt2,true);
		$criteria->compare('tipo_vivienda_id',$this->tipo_vivienda_id);
		$criteria->compare('tipo_vivienda',$this->tipo_vivienda,true);
		$criteria->compare('id_fuente_financiamiento',$this->id_fuente_financiamiento);
		$criteria->compare('nombre_fuente_financiamiento',$this->nombre_fuente_financiamiento,true);
		$criteria->compare('id_programa',$this->id_programa);
		$criteria->compare('nombre_programa',$this->nombre_programa,true);
		$criteria->compare('id_ente_ejecutor',$this->id_ente_ejecutor);
		$criteria->compare('nombre_ente_ejecutor',$this->nombre_ente_ejecutor,true);
		$criteria->compare('id_beneficiario',$this->id_beneficiario);
		$criteria->compare('condicion_trabajo_id',$this->condicion_trabajo_id);
		$criteria->compare('condicion_trabajo',$this->condicion_trabajo,true);
		$criteria->compare('condicion_laboral_id',$this->condicion_laboral_id);
		$criteria->compare('condicion_laboral',$this->condicion_laboral,true);
		$criteria->compare('fuente_ingreso_id',$this->fuente_ingreso_id);
		$criteria->compare('fuente_ingreso',$this->fuente_ingreso,true);
		$criteria->compare('relacion_trabajo_id',$this->relacion_trabajo_id);
		$criteria->compare('relacion_trabajo',$this->relacion_trabajo,true);
		$criteria->compare('sector_trabajo_id',$this->sector_trabajo_id);
		$criteria->compare('sector_trabajo',$this->sector_trabajo,true);
		$criteria->compare('nombre_empresa',$this->nombre_empresa,true);
		$criteria->compare('direccion_empresa',$this->direccion_empresa,true);
		$criteria->compare('telefono_trabajo',$this->telefono_trabajo,true);
		$criteria->compare('gen_cargo_id',$this->gen_cargo_id);
		$criteria->compare('cargo',$this->cargo,true);
		$criteria->compare('ingreso_mensual',$this->ingreso_mensual,true);
		$criteria->compare('ingreso_declarado',$this->ingreso_declarado,true);
		$criteria->compare('ingreso_promedio_faov',$this->ingreso_promedio_faov,true);
		$criteria->compare('cotiza_faov',$this->cotiza_faov,true);
		$criteria->compare('direccion_anterior',$this->direccion_anterior,true);
		$criteria->compare('urban_barrio_anterior',$this->urban_barrio_anterior,true);
		$criteria->compare('av_call_esq_carr_anterior',$this->av_call_esq_carr_anterior,true);
		$criteria->compare('zona_anterior',$this->zona_anterior,true);
		$criteria->compare('cod_estado_anterior',$this->cod_estado_anterior);
		$criteria->compare('estado_anetrior',$this->estado_anetrior,true);
		$criteria->compare('cod_municipio_anterior',$this->cod_municipio_anterior);
		$criteria->compare('municipio_anterior',$this->municipio_anterior,true);
		$criteria->compare('cod_parroquia_anterior',$this->cod_parroquia_anterior);
		$criteria->compare('parroquia_anterior',$this->parroquia_anterior,true);
		$criteria->compare('nombre_unidad_familiar',$this->nombre_unidad_familiar,true);
		$criteria->compare('condicion_unidad_familiar_id',$this->condicion_unidad_familiar_id);
		$criteria->compare('condicion_unidad_familiar',$this->condicion_unidad_familiar,true);
		$criteria->compare('total_personas_cotizando',$this->total_personas_cotizando);
		$criteria->compare('ingreso_total_familiar',$this->ingreso_total_familiar,true);
		$criteria->compare('ingreso_total_familiar_suma_faov',$this->ingreso_total_familiar_suma_faov,true);
		$criteria->compare('observacion',$this->observacion,true);

	/*	return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));*/

    return($this->findAll($criteria));

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VswBusquedaAvanzada the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
