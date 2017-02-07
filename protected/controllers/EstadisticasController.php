<?php

class EstadisticasController extends Controller {
    //public $layout = '//layouts/admintui';

    /**
     * @return array action filters
     */
//    public function filters() {
//        return array(
//            'accessControl', // perform access control for CRUD operations
//            'postOnly + delete', // we only allow deletion via POST request
//        );
//    }
//
//    public function accessRules() {
//        return array(
//            array('allow', // allow all users to perform 'index' and 'view' actions
//                'actions' => array('index', 'desarrollosUbicacionGeografica',
//                'desarrollosUbicacionMunicipios', 'desarrollosUbicacionParroquias', 'desarrollosFuenteFinanciamiento',
//                'multifamiliarTipo', 'unidadfamiliarTipo','disponibilidadUnidadHabitacional',
//                'beneficiariosUbicacionGeografica',
//                'beneficiariosUbicacionMunicipios', 'beneficiariosUbicacionParroquias','beneficiarioFuenteIngreso',
//                'beneficiarioCondicionTrabajo','beneficiarioSectorTrabaja','beneficiarioCotizacionFaov'),
//                'users' => array('@'),
//            ),
//            array('deny', // deny all users
//                'users' => array('*'),
//            ),
//        );
//    }

    public function filters() {
        return array(array('CrugeAccessControlFilter'));
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('*'),
                'users' => array('@'),
            ),
        );
    }

    public function actionIndex() {

        $this->render('index');
    }

    public function actionDesarrollosUbicacionGeografica() {

        $titulo1 = "Cantidad de Desarrollos Habitacionales <br> Por Ubicación Geografica";
        $titulo = "Cantidad de Desarrollos Habitacionales por Estado";
        $subtitulo = "Fecha " . date("d/m/Y");

//  $categorias = CHtml::listData(Tblestado::model()->findAll(array("select"=>"strdescripcion", "order" => "strdescripcion ASC")), 'clvcodigo','strdescripcion' );
//  Tblestado::model()->findAll();
//  $estados = Tblestado::model()->findAll(array("select"=>"strdescripcion", "order" => "strdescripcion ASC"));
        //foreach ( $estados as $id => $estado ){ $categorias[$id] = $estado->strdescripcion; }
        //$series = array( "Amazonas" => "20","Anzoategui" => "8","Apure" => "64","Aragua" => "15","Barinas" => "26", );

        $consulta = Yii::app()->db->createCommand('SELECT sec.cod_estado, sec.estado,
            (SELECT COUNT(des.id_desarrollo)
            FROM desarrollo des
            JOIN vsw_sector sec1 ON sec1.cod_parroquia = des.parroquia_id
            WHERE sec.cod_estado = sec1.cod_estado
            AND NOT des.estatus = 196) AS cantidad
            FROM vsw_sector sec
            GROUP BY sec.cod_estado, sec.estado
            ORDER BY sec.estado')->queryAll();
        $total = "0";
        foreach ($consulta as $id => $estado) {
            $categorias[$id] = $estado["estado"];
            $url = Yii::app()->createAbsoluteUrl("estadisticas/desarrollosUbicacionMunicipios/", array("id" => $estado["cod_estado"]));
            $series[$id] = array('y' => (int) $estado["cantidad"], 'url' => $url);
            $total = $total + $estado["cantidad"];
        }//fin foreach resultados consulta

        $event = array('events' => array('click' => 'js:function() {location.href= this.options.url;}'));

        $this->render('ubicacionGeografica', array('titulo1' => $titulo1, 'titulo' => $titulo, 'subtitulo' => $subtitulo,
            'categorias' => $categorias, 'series' => $series, 'total' => $total, 'event' => $event, 'br'=>true));
    }

    public function actionDesarrollosUbicacionMunicipios($id) {

        $titulo1 = "Cantidad de Desarrollos Habitacionales <br> Por Ubicación Geografica";

        $estado = Tblestado::model()->findByPk($id)->strdescripcion;
        $titulo = "Cantidad de Desarrollos Habitacionales <br> por Municipios del Estado $estado";
        $subtitulo = "Fecha " . date("d/m/Y");

        $consulta = Yii::app()->db->createCommand('SELECT sec.cod_estado, sec.estado, sec.cod_municipio, municipio,
                    (SELECT COUNT(des.id_desarrollo)
                    FROM desarrollo des
                    JOIN vsw_sector sec1 ON sec1.cod_parroquia = des.parroquia_id
                    WHERE sec.cod_municipio = sec1.cod_municipio
                    AND NOT des.estatus = 196) AS cantidad
                    FROM vsw_sector sec
                    WHERE sec.cod_estado = ' . $id . '  --CAMBIAR POR LA VARIABLE DEL CODIGO DEL ESTADO
                    GROUP BY sec.cod_estado, sec.estado, sec.cod_municipio, municipio
                    ORDER BY sec.municipio')->queryAll();
        $total = "0";
        foreach ($consulta as $id => $municipio) {
            $categorias[$id] = $municipio["municipio"];
            $url = Yii::app()->createAbsoluteUrl("estadisticas/desarrollosUbicacionParroquias/", array("id" => $municipio["cod_municipio"]));
            $series[$id] = array('y' => (int) $municipio["cantidad"], 'url' => $url);
            $total = $total + $municipio["cantidad"];
        }

        $event = array('events' => array('click' => 'js:function() {location.href= this.options.url;}'));
        $this->render('ubicacionGeografica', array('titulo1' => $titulo1, 'titulo' => $titulo, 'subtitulo' => $subtitulo,
            'categorias' => $categorias, 'series' => $series, 'total' => $total, 'event' => $event, 'br'=>true));
    }

//Fin desarrollosUbicacionMunicipios

    public function actionDesarrollosUbicacionParroquias($id) {

        $municipio = Tblmunicipio::model()->findByPk($id);
        $estado = Tblestado::model()->findByPk($municipio->strid_estado)->strdescripcion;
        $titulo1 = "Cantidad de Desarrollos Habitacionales <br> Por Ubicación Geografica";
        $titulo = "Cantidad de Desarrollos Habitacionales por Parroquias <br> del Municipio $municipio->strdescripcion del Estado $estado";
        $subtitulo = "Fecha " . date("d/m/Y");

        $consulta = Yii::app()->db->createCommand('SELECT sec.cod_estado, sec.estado, sec.cod_municipio, municipio,
                        sec.cod_parroquia, sec.parroquia,
                        (SELECT COUNT(des.id_desarrollo)
                        FROM desarrollo des
                        WHERE des.parroquia_id = sec.cod_parroquia
                        AND NOT des.estatus = 196) AS cantidad
                        FROM vsw_sector sec
                        WHERE sec.cod_municipio = ' . $id . '
                        GROUP BY sec.cod_estado, sec.estado, sec.cod_municipio, municipio,
                        sec.cod_parroquia, sec.parroquia
                        ORDER BY sec.parroquia')->queryAll();
        $total = "0";
        foreach ($consulta as $id => $parroquia) {
            $categorias[$id] = $parroquia["parroquia"];
            $series[$id] = array('y' => (int) $parroquia["cantidad"]);
            $total = $total + $parroquia["cantidad"];
        }

        $event = array('events' => false);

        $this->render('ubicacionGeografica', array('titulo1' => $titulo1, 'titulo' => $titulo, 'subtitulo' => $subtitulo,
            'categorias' => $categorias, 'series' => $series, 'total' => $total, 'event' => $event, 'br'=>true));
    }

//Fin desarrollosUbicacionMunicipios

    public function actionBeneficiariosUbicacionGeografica() {
        $titulo1 = "Cantidad de Beneficiarios Por Ubicación Geografica";
        $titulo = "Cantidad de Beneficiarios por Estado";
        $subtitulo = "Fecha " . date("d/m/Y");

        $consulta = Yii::app()->db->createCommand('SELECT sec.cod_estado, sec.estado,
                        (SELECT COUNT(des.id_beneficiario)
                        FROM beneficiario des
                        JOIN vsw_sector sec1 ON sec1.cod_parroquia = des.parroquia_id
                        WHERE sec.cod_estado = sec1.cod_estado
                       /* AND NOT des.estatus = 222 censado o 223 en proceso*/) AS cantidad
                        FROM vsw_sector sec
                        GROUP BY sec.cod_estado, sec.estado
                        ORDER BY sec.estado')->queryAll();
        $total = "0";
        foreach ($consulta as $id => $estado) {
            $categorias[$id] = $estado["estado"];
            $url = Yii::app()->createAbsoluteUrl("estadisticas/beneficiariosUbicacionMunicipios/", array("id" => $estado["cod_estado"]));
            $series[$id] = array('y' => (int) $estado["cantidad"], 'url' => $url);
            $total = $total + $estado["cantidad"];
        }//fin foreach resultados consulta

        $event = array('events' => array('click' => 'js:function() {location.href= this.options.url;}'));
        $this->render('ubicacionGeografica', array('titulo1' => $titulo1, 'titulo' => $titulo, 'subtitulo' => $subtitulo,
            'categorias' => $categorias, 'series' => $series, 'total' => $total, 'event' => $event, 'br'=>true));
    }

    public function actionBeneficiariosUbicacionMunicipios($id) {

        $estado = Tblestado::model()->findByPk($id)->strdescripcion;

        $titulo1 = "Cantidad de Beneficiarios Por Ubicación Geografica";
        $titulo = "Cantidad de Beneficiarios por Municipios <br> del Estado $estado";
        $subtitulo = "Fecha " . date("d/m/Y");

        $consulta = Yii::app()->db->createCommand('SELECT sec.cod_estado, sec.estado, sec.cod_municipio, municipio,
                        (SELECT COUNT(des.id_beneficiario)
                        FROM beneficiario des
                        JOIN vsw_sector sec1 ON sec1.cod_parroquia = des.parroquia_id
                        WHERE sec.cod_municipio = sec1.cod_municipio
                        /*AND NOT des.estatus = 222 censado o 223 en proceso */) AS cantidad
                        FROM vsw_sector sec
                        WHERE sec.cod_estado = ' . $id . '  --CAMBIAR POR LA VARIABLE DEL CODIGO DEL ESTADO
                        GROUP BY sec.cod_estado, sec.estado, sec.cod_municipio, municipio
                        ORDER BY sec.municipio')->queryAll();
        $total = "0";
        foreach ($consulta as $id => $municipio) {
            $categorias[$id] = $municipio["municipio"];
            $url = Yii::app()->createAbsoluteUrl("estadisticas/beneficiariosUbicacionParroquias/", array("id" => $municipio["cod_municipio"]));
            $series[$id] = array('y' => (int) $municipio["cantidad"], 'url' => $url);
            $total = $total + $municipio["cantidad"];
        }

        $event = array('events' => array('click' => 'js:function() {location.href= this.options.url;}'));
        $this->render('ubicacionGeografica', array('titulo1' => $titulo1, 'titulo' => $titulo, 'subtitulo' => $subtitulo,
            'categorias' => $categorias, 'series' => $series, 'total' => $total, 'event' => $event, 'br'=>true));
    }

//Fin desarrollosUbicacionMunicipios

    public function actionBeneficiariosUbicacionParroquias($id) {

        $municipio = Tblmunicipio::model()->findByPk($id);
        $estado = Tblestado::model()->findByPk($municipio->strid_estado)->strdescripcion;

        $titulo1 = "Cantidad de Beneficiarios Por Ubicación Geografica";
        $titulo = "Cantidad de Beneficiarios por Parroquias <br> del Municipio $municipio->strdescripcion  Estado $estado";
        $subtitulo = "Fecha " . date("d/m/Y");

        $consulta = Yii::app()->db->createCommand('SELECT sec.cod_estado, sec.estado, sec.cod_municipio, municipio,
                    sec.cod_parroquia, sec.parroquia,
                    (SELECT COUNT(des.id_beneficiario)
                    FROM beneficiario des
                    WHERE des.parroquia_id = sec.cod_parroquia
                    /*AND NOT des.estatus = 222 censado o 223 en proceso*/) AS cantidad
                    FROM vsw_sector sec
                    WHERE sec.cod_municipio = ' . $id . '
                    GROUP BY sec.cod_estado, sec.estado, sec.cod_municipio, municipio,
                    sec.cod_parroquia, sec.parroquia
                    ORDER BY sec.parroquia')->queryAll();
        $total = "0";
        foreach ($consulta as $id => $parroquia) {
            $categorias[$id] = $parroquia["parroquia"];
            $series[$id] = array('y' => (int) $parroquia["cantidad"]);
            $total = $total + $parroquia["cantidad"];
        }
        $event = array('events' => false);

        $this->render('ubicacionGeografica', array('titulo1' => $titulo1, 'titulo' => $titulo, 'subtitulo' => $subtitulo,
            'categorias' => $categorias, 'series' => $series, 'total' => $total, 'event' => $event, 'br'=>true));
    }

//Fin desarrollosUbicacionMunicipios

    public function actionDesarrollosFuenteFinanciamiento() {

        $CantFuentesFinanciamientos = FuenteFinanciamiento::model()->count();
        $CantDesarrollos = Desarrollo::model()->count();

        $titulo1 = "Desarrollos Habitacionales por Fuentes de Financiamiento ";
        $titulo = "Cantidad de Desarrollos Habitacionales <br> por Fuentes de Financiamiento. Fecha " . date("d/m/Y");
        $subtitulo = "Total Desarrollos Habitacionales: " . $CantDesarrollos . " Total Fuentes Financiamiento: " . $CantFuentesFinanciamientos;
        $tituloSerie = 'Fuentes de Financiamietos';

        $sql = "select distinct ff.nombre_fuente_financiamiento,
                ( select count(1) from desarrollo de where de.fuente_financiamiento_id = ff.id_fuente_financiamiento  ) as cantidad
                from desarrollo as d
                LEFT JOIN fuente_financiamiento ff ON ff.id_fuente_financiamiento = d.fuente_financiamiento_id
                GROUP BY ff.nombre_fuente_financiamiento, ff.id_fuente_financiamiento
                order by ff.nombre_fuente_financiamiento ASC";

        $consulta = Yii::app()->db->createCommand($sql);
        foreach ($consulta->queryAll() as $registro) {
            $data[] = array('name' => $registro["nombre_fuente_financiamiento"], 'y' => (int) $registro["cantidad"],);
        }

        $this->render('graficoTorta', array('titulo1' => $titulo1, 'titulo' => $titulo, 'subtitulo' => $subtitulo,
            'tituloSerie' => $tituloSerie, 'data' => $data));
    }

    public function actionMultifamiliarTipo() {

        $CantUnidadHabitacional = UnidadHabitacional::model()->count();

        $titulo1 = "Unidades Multifamiliares por Tipo de Inmueble";
        $titulo = "Cantidad de Unidades Multifamiliares por Tipo de Inmueble";
        $subtitulo = "Total Unidades Multifamiliares: " . $CantUnidadHabitacional;
        $tituloSerie = 'Tipo de Inmueble';

        $sql = "select distinct m.descripcion
                , ( select count(1) from unidad_habitacional uh where uh.gen_tipo_inmueble_id = m.id_maestro  ) as cantidad
                from unidad_habitacional as u
                LEFT JOIN maestro m ON m.id_maestro = u.gen_tipo_inmueble_id
                GROUP BY m.descripcion, m.id_maestro
                order by m.descripcion ASC";

        $consulta = Yii::app()->db->createCommand($sql);
        foreach ($consulta->queryAll() as $registro) {
            $data[] = array('name' => $registro["descripcion"], 'y' => (int) $registro["cantidad"],);
        }

        $this->render('graficoTorta', array('titulo1' => $titulo1, 'titulo' => $titulo, 'subtitulo' => $subtitulo,
            'tituloSerie' => $tituloSerie, 'data' => $data));
    }

    public function actionUnidadfamiliarTipo() {

        //$CantFuentesFinanciamientos = UnidadHabitacional::model()->count();
        $CantUnidadHabitacional = Vivienda::model()->count();
        $titulo1 = " Unidades Familiares (Viviendas) por Tipo de Inmueble";
        $titulo = "Cantidad de Unidades Familiares (Viviendas) por Tipo de Inmueble";
        $subtitulo = "Total Unidades Familiares: " . $CantUnidadHabitacional;
        $tituloSerie = 'Tipo de Inmueble';

        $sql = "select distinct m.descripcion
                , ( select count(1) from vivienda vi where vi.tipo_vivienda_id = m.id_maestro  ) as cantidad
                from vivienda as v
                LEFT JOIN maestro m ON m.id_maestro = v.tipo_vivienda_id
                GROUP BY m.descripcion, m.id_maestro
                order by m.descripcion ASC";

        $consulta = Yii::app()->db->createCommand($sql);
        foreach ($consulta->queryAll() as $registro) {
            $data[] = array('name' => $registro["descripcion"], 'y' => (int) $registro["cantidad"],);
        }

        $this->render('graficoTorta', array('titulo1' => $titulo1, 'titulo' => $titulo, 'subtitulo' => $subtitulo,
            'tituloSerie' => $tituloSerie, 'data' => $data));
    }

    public function actionDisponibilidadUnidadHabitacional() {

        $CantUnidadHabitacional = Vivienda::model()->count();

        $titulo = "Cantidad de Unidades Multifamiliares Disponibles (No Adjudicados), <br> con Censo Parciales (No Completos) ó sin realizar";
        $subtitulo = "Total Unidades Familiares: " . $CantUnidadHabitacional;
        $tituloSerie = 'Unidades Multifamiliares';

        $categorias[] = 'Disponibles (No Adjudicados)';
        $categorias[] = 'Censo Parciales (No Completos)';
        $categorias[] = 'Sin Realizar Censo';

        $data[] = (int) Yii::app()->db->createCommand("select sum(total_unidad_disponible) from unidad_habitacional")->queryScalar();
        $data[] = (int) UnidadHabitacional::model()->count('total_unidad_censada < total_unidad_disponible AND total_unidad_censada > 0');
        $data[] = (int) UnidadHabitacional::model()->count('total_unidad_censada = 0');

        $this->render('graficoBarra', array('titulo' => $titulo, 'subtitulo' => $subtitulo,
            'tituloSerie' => $tituloSerie, 'categorias' => $categorias, 'data' => $data));
    }

    public function actionBeneficiarioFuenteIngreso() {

        $CantFuentesFinanciamientos = FuenteFinanciamiento::model()->count();
        $CantDesarrollos = Desarrollo::model()->count();
        $titulo1 = "Adjudicados por Fuentes de Ingreso";
        $titulo = "Cantidad de Adjudicados por Fuentes de Ingreso. Fecha " . date("d/m/Y");
        $subtitulo = "Total Desarrollos Habitacionales: " . $CantDesarrollos . " Total Fuentes Financiamiento: " . $CantFuentesFinanciamientos;
        $tituloSerie = 'Fuentes de Financiamientos';

        $consulta = Yii::app()->db->createCommand('SELECT m.descripcion,
                    COALESCE ((SELECT count( be.fuente_ingreso_id)
                      FROM  beneficiario be WHERE be.fuente_ingreso_id = m.id_maestro ),0) as cantidad
                      FROM maestro m
                      WHERE m.padre = 102 AND m.es_activo
                    GROUP BY  m.id_maestro')->queryAll();

        foreach ($consulta as $registro) {
            $data[] = array('name' => $registro["descripcion"], 'y' => (int) $registro["cantidad"]);
        }

        $this->render('graficoTorta', array('titulo1' => $titulo1, 'titulo' => $titulo, 'subtitulo' => $subtitulo,
            'tituloSerie' => $tituloSerie, 'data' => $data));
    }

    public function actionBeneficiarioCondicionTrabajo() {

        $CantFuentesFinanciamientos = FuenteFinanciamiento::model()->count();
        $CantDesarrollos = Desarrollo::model()->count();

        $titulo1 = "Adjudicados por Condición de Trabajo";
        $titulo = "Cantidad de Adjudicados por Condición de Trabajo. Fecha " . date("d/m/Y");
        $subtitulo = "Total Adjudicados: " . $CantDesarrollos . " Total Fuentes Financiamiento: " . $CantFuentesFinanciamientos;
        $tituloSerie = 'Condición de Trabajo';

        $consulta = Yii::app()->db->createCommand('SELECT m.descripcion,
                    COALESCE ((SELECT count( be.condicion_trabajo_id)
                      FROM  beneficiario be WHERE be.condicion_trabajo_id = m.id_maestro ),0) as cantidad
                      FROM maestro m
                      WHERE m.padre = 109 AND m.es_activo
                    GROUP BY  m.id_maestro')->queryAll();

        foreach ($consulta as $registro) {
            $data[] = array('name' => $registro["descripcion"], 'y' => (int) $registro["cantidad"],);
        }

        $this->render('graficoTorta', array('titulo1' => $titulo1, 'titulo' => $titulo, 'subtitulo' => $subtitulo,
            'tituloSerie' => $tituloSerie, 'data' => $data));
    }

    public function actionBeneficiarioSectorTrabaja() {

        $CantDesarrollos = Beneficiario::model()->count();
        $titulo1 = "Adjudicados por Sector de Trabajo";
        $titulo = "Cantidad de Adjudicados por Sector en el que Trabaja. Fecha " . date("d/m/Y");
        $subtitulo = "Total Adjudicados: " . $CantDesarrollos;
        $tituloSerie = 'Sector de Trabajo';

        $consulta = Yii::app()->db->createCommand('SELECT m.descripcion,
                    COALESCE ( (SELECT count( be.sector_trabajo_id)
                      FROM  beneficiario be WHERE be.sector_trabajo_id = m.id_maestro ),0) as cantidad
                      FROM maestro m
                      WHERE m.padre = 132 AND m.es_activo
                    GROUP BY  m.id_maestro')->queryAll();

        foreach ($consulta as $registro) {
            $data[] = array('name' => $registro["descripcion"], 'y' => (int) $registro["cantidad"],);
        }

        $this->render('graficoTorta', array('titulo1' => $titulo1, 'titulo' => $titulo, 'subtitulo' => $subtitulo,
            'tituloSerie' => $tituloSerie, 'data' => $data));
    }

    public function actionBeneficiarioCotizacionFaov() {

        $CantDesarrollos = Beneficiario::model()->count();
        $titulo1 = "Adjudicados con Cotizaciones en FAOV";
        $titulo = "Cantidad de Adjudicados por Cotización de FAOV";
        $subtitulo = "Total Adjudicados: " . $CantDesarrollos;
        $tituloSerie = 'Sector de Trabajo';

        $consulta = Yii::app()->db->createCommand('select count(1) as Cantidad from beneficiario where cotiza_faov = TRUE
                    UNION select count(1) as Cantidad from beneficiario where cotiza_faov = FALSE')->queryAll();

        $data[] = array('name' => 'Cotiza FAOV', 'y' => (int) $consulta[0]["cantidad"],);
        $data[] = array('name' => 'No Cotiza FAOV', 'y' => (int) $consulta[1]["cantidad"],);


        /*
          foreach ( $consulta as $registro ){
          $data[] = array('name'=> $registro["descripcion"], 'y' => $registro["cantidad"], );
          }
         */
        $this->render('graficoTorta', array('titulo1' => $titulo1, 'titulo' => $titulo, 'subtitulo' => $subtitulo,
            'tituloSerie' => $tituloSerie, 'data' => $data));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
    
    public function actionBeneficiariosUbicacionGeograficaPdf($id)
    {
        $titulo1 = "Cantidad de Beneficiarios Por Ubicación Geografica";
        $titulo = "Cantidad de Beneficiarios por Estado";
        $subtitulo = "Fecha " . date("d/m/Y");

        $consulta = Yii::app()->db->createCommand('SELECT sec.cod_estado, sec.estado,
                        (SELECT COUNT(des.id_beneficiario)
                        FROM beneficiario des
                        JOIN vsw_sector sec1 ON sec1.cod_parroquia = des.parroquia_id
                        WHERE sec.cod_estado = sec1.cod_estado
                       /* AND NOT des.estatus = 222 censado o 223 en proceso*/) AS cantidad
                        FROM vsw_sector sec
                        GROUP BY sec.cod_estado, sec.estado
                        ORDER BY sec.estado')->queryAll();
        $total = "0";
        foreach ($consulta as $id => $estado) {
            $categorias[$id] = $estado["estado"];
            $url = Yii::app()->createAbsoluteUrl("estadisticas/beneficiariosUbicacionMunicipios/", array("id" => $estado["cod_estado"]));
            $series[$id] = array('y' => (int) $estado["cantidad"], 'url' => $url);
            $total = $total + $estado["cantidad"];
        }//fin foreach resultados consulta

        /*$event = array('events' => array('click' => 'js:function() {location.href= this.options.url;}'));
        $this->render('ubicacionGeografica', array('titulo1' => $titulo1, 'titulo' => $titulo, 'subtitulo' => $subtitulo,
            'categorias' => $categorias, 'series' => $series, 'total' => $total, 'event' => $event, 'br'=>true));*/

//        echo '<pre>';
 //var_dump($categorias);
//var_dump($series);
//echo '</pre>';
        //echo count($categorias);
//        foreach($series as $serie){
//            //echo $serie[0]." - ".$serie[1]."<br>";
//            echo $serie['y']."<br>";
//        }
//        die;
        //SE CREA LA IMAGEN CON EL GRAFICO
        Yii::import('application.vendors.pChart.*');
        require_once 'class/pData.class.php';
        require_once 'class/pDraw.class.php';
        require_once 'class/pImage.class.php';

        $fonts = Yii::import('application.vendors.pChart.fonts.*');
        //echo $fonts;die;
         define("FONT_PATH", $fonts);
         
       // $graficos_img = "/var/www/sisprov_ds/images/estadisticas_temp/";
        $graficos_img = "images/estadisticas_temp/";//echo $graficos_img;die;
         //var_dump($categorias);die;
         //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /* Create and populate the pData object */ 
        $MyData = new pData();   
        //$MyData->addPoints(array(13251,4118,3087,1460,1248,156,26,9,8),"Cantidad");
        foreach($series as $serie){
             $MyData->addPoints($serie['y'],"Total"); 
        }
       
        $MyData->setAxisName(0,"Total"); 
        $MyData->addPoints($categorias,"Estados"); 
        $MyData->setSerieDescription("Estados","Estados"); 
        $MyData->setAbscissa("Estados"); 
        $MyData->setAbscissaName("Estados"); 
        //$MyData->addPoints(array("Firefox","Chrome","Internet Explorer","Opera","Safari","Mozilla","SeaMonkey","Camino","Lunascape"),"Browsers"); 
        
        //$MyData->setSerieDescription("Browsers","Browsers");
        
        //$MyData->setAbscissa("Browsers"); 
        //$MyData->setAbscissaName("Browsers"); 
        $MyData->setAxisDisplay(0,AXIS_FORMAT_METRIC,1); 
        
        /* Create the pChart object */ 
        $myPicture = new pImage(500,500,$MyData); 
        $myPicture->drawGradientArea(0,0,500,500,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100)); 
        $myPicture->drawGradientArea(0,0,500,500,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20)); 
        $myPicture->setFontProperties(array("FontName"=>FONT_PATH."/pf_arma_five.ttf","FontSize"=>6)); 

        /* Draw the chart scale */  
        $myPicture->setGraphArea(100,30,480,480);
        $myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM)); //  

        /* Turn on shadow computing */  
        $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 

        /* Draw the chart */  
        $myPicture->drawBarChart(array("DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30)); 

        /* Write the legend */  
        $myPicture->drawLegend(570,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 
        
        $myPicture->render($graficos_img."ubicacionGeograficaBarras.png");
        
        
        //die("Llegue");
        
        
        
        
        
        
        
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //$titulo = ' Desarrollo Habitacional N° '.$model->id_oficina.' - '.$model->nombre.' '.date('h:i:A') .'';
        $titulo = 'Título del reporte';
        $contenido ="<table align='right' width='100%' border='0'>
                        <tr>
                            <td colspan='2' align='center'>
                                <!--<b><img src='images/estadisticas_temp/ubicacionGeografica.png' ></b>-->
                            </td>
                        </tr>
                        <tr>
                            <td colspan='2' align='center'>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='2' align='center'>
                                <b><img src='images/estadisticas_temp/ubicacionGeograficaBarras.png' ></b>
                            </td>
                        </tr>
                    </table>
                    ";
        //die('Llegue');
        $pdfEstadisticas = new PdfEstadisticas();
        //$pdf->imprimirPdf($titulo, $contenido,'horizontal');
        $pdfEstadisticas->imprimirPdf($titulo, $contenido);
         
 
 /*$pdf = Yii::createComponent('application.vendors.mpdf.mpdf');
$cabecera = '<img src="' . Yii::app()->request->baseUrl . '/images/cintillo.jpg"/>';


$html.="<table align='right' width='100%' border='0'>       
    <tr>
        <td colspan='2' align='center'>
            <b><img src='ubicacionGeografica.png' ></b>
        </td>
    </tr>
</table>
";

$mpdf = new mPDF('c', 'LETTER');
$mpdf->SetTitle(' Desarrollo Habitacional N° '.$model->id_oficina.' - '.$model->nombre.' '.date('h:i:A') .'');
$mpdf->SetMargins(5, 50, 30);
$mpdf->SetAuthor('BANAVIH - Banco Nacional de Vivienda y Habitat');
$mpdf->SetCreator('BANAVIH - Banco Nacional de Vivienda y Habitat');
$mpdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$cabecera.'</div>','O', true);
$mpdf->SetFooter('Generado desde el Sistema de Protocolización el ' . date('d-m-Y') . ' a las ' . date('h:i:A') . '' . Yii::app()->user->name . ' |                        Página {PAGENO}/{nbpg}');
$mpdf->WriteHTML($html);
unlink('ubicacionGeografica.png');
$mpdf->Output('Oficina-'.$model->id_oficina. ' .pdf','D');
exit;*/
    }

}