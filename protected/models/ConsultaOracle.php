<?php

/*
 * Modelo que se consulta e inserta en oracle
 */

class ConsultaOracle extends CActiveRecord {
    /*
     * Consulta Tabla Persona de tablas_comunes
     * Consulta que busca por Pk 
     * Return valores solicitados por el select
     * SI return es 1, indica que no existe en tabla Persona
     */

    public function setPersona($select, $id) {
        //$nacional = ($nacionalidad == 97) ? '1' : '0';
        $SLQ = "SELECT " . $select . " FROM PERSONA WHERE ID =" . $id;
        $result = Yii::app()->dbOarcle->createCommand($SLQ)->queryRow();

        if (empty($result)) {
            return 1;
        } else {
            return $result;
        }
    }

        public static function setPersonas() {
        //$nacional = ($nacionalidad == 97) ? '1' : '0';
        //$SLQ = "SELECT " . $select . " FROM PERSONA WHERE ID =" . $id;
        $SLQ = "SELECT * FROM PERSONA";
        $result = Yii::app()->dbOarcle->createCommand($SLQ)->queryRow();

        if (empty($result)) {
            return 1;
        } else {
            return $result;
        }
    }
    /*
     * Consulta Tabla Persona de tablas_comunes
     * Consulta que busca por nacionalidad y cedula
     * Return ID, NACIONALIDAD , CEDULA, PRIMER_NOMBRE, SEGUNDO_NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO
     * SI return es 1, indica que no existe en tabla Persona
     */

    public function getPersonaByPk($select, $id) {
        //$nacional = ($nacionalidad == 97) ? '1' : '0';
        $SLQ = "SELECT " . $select . " FROM PERSONA WHERE ID =" . $id;
        $result = Yii::app()->dbOarcle->createCommand($SLQ)->queryRow();

        if (empty($result)) {
            return 1;
        } else {
            return $result;
        }
    }

    /*
     * Consulta Tabla Persona de tablas_comunes
     * Consulta que busca por nacionalidad y cedula
     * Return NACIONALIDAD , CEDULA
     * SI return es 1, indica que no existe en tabla Persona
     * El primer parámetro debe ser la nacionalidad, de ser 0 se le asignara el valor E, de lo contrario V
     */

    public function getNacionalidadCedulaPersonaByPk($select, $select2, $id) {
        //$nacional = ($nacionalidad == 97) ? '1' : '0';
        $SLQ = "SELECT " . $select . ", " . $select2 . " FROM PERSONA WHERE ID =" . $id;
        $result = Yii::app()->dbOarcle->createCommand($SLQ)->queryRow();

        if (empty($result)) {
            return 1;
        } else {
            if ($result[$select] == 0)
                $result[$select] = 'E';
            else
                $result[$select] = 'V';
            return $result;
        }
    }

    /*
     * Consulta Tabla Persona de tablas_comunes
     * Consulta que busca por nacionalidad y cedula
     * Return ID, NACIONALIDAD , CEDULA, PRIMER_NOMBRE, SEGUNDO_NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO
     * SI return es 1, indica que no existe en tabla Persona
     */

    public function getPersona($nacionalidad, $cedula) {

        $nacional = ($nacionalidad == 97) ? 1 : 0;
        $SLQ = "SELECT ID, NACIONALIDAD , CEDULA, PRIMER_NOMBRE AS PRIMERNOMBRE, SEGUNDO_NOMBRE AS SEGUNDONOMBRE, PRIMER_APELLIDO AS PRIMERAPELLIDO, SEGUNDO_APELLIDO AS SEGUNDOAPELLIDO ,TO_CHAR(FECHA_NACIMIENTO, 'DD-MM-YYYY' ) AS FECHANACIMIENTO FROM TABLAS_COMUNES.PERSONA WHERE NACIONALIDAD ='" . $nacional . "' AND CEDULA = " . $cedula;
        $result = Yii::app()->dbOarcle->createCommand($SLQ)->queryRow();
//        echo '<pre>';var_dump($result);die;
        if (empty($result)) {
            return 1;
        } else {
            return $result;
        }
    }

    /*
     * Consulta Tabla Persona de tablas_comunes
     * Consulta que busca por nacionalidad y cedula, 
     * Return ID, NACIONALIDAD , CEDULA, PRIMER_NOMBRE, SEGUNDO_NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO
     * SI return es 1, indica que no existe en tabla Persona
     */

    public function getInsertMenorEdad($array) {
        if (empty($array)) {
            return false;
        } else {
            $select = array();
            $valor = array();
            foreach ($array as $key => $value) {
                if ($key == 'FECHA_NACIMIENTO') {
                    array_push($select, $key);
                    array_push($valor, "to_date('" . $value . "','DD/MM/RR')");
                } else {
                    array_push($select, $key);
                    if (is_numeric($value)) {
                        array_push($valor, $value);
                    } else {
                        array_push($valor, "'" . $value . "'");
                    }
                }
            }
            $select = implode(',', $select);
            $valor = implode(',', $valor);

            $segundo_nombre = empty($array['SEGUNDO_NOMBRE']) ? 'IS NULL' : " = '" . $array['SEGUNDO_NOMBRE'] . "'";
            $segundo_apellido = empty($array['SEGUNDO_APELLIDO']) ? "IS NULL" : " = '" . $array['SEGUNDO_APELLIDO'] . "'";

            $Existe = "SELECT ID FROM TABLAS_COMUNES.PERSONA WHERE NACIONALIDAD = 'M'  AND "
                    . "PRIMER_NOMBRE = '" . $array['PRIMER_NOMBRE'] . "' "
                    . "AND SEGUNDO_NOMBRE " . $segundo_nombre . ""
                    . " AND  PRIMER_APELLIDO = '" . $array['PRIMER_APELLIDO'] . "'  "
                    . "AND SEGUNDO_APELLIDO " . $segundo_apellido;
            $ExistePersonaNew = Yii::app()->dbOarcle->createCommand($Existe)->queryRow();
            if (!($ExistePersonaNew)) {
                $SQL = "INSERT INTO TABLAS_COMUNES.PERSONA (ID, " . $select . ") VALUES ((SELECT MAX(ID)+1 FROM TABLAS_COMUNES.PERSONA)," . $valor . ")";

                $result = Yii::app()->dbOarcle->createCommand($SQL)->query();

                $SQL1 = "SELECT ID FROM TABLAS_COMUNES.PERSONA WHERE NACIONALIDAD = 'M'  AND "
                        . "PRIMER_NOMBRE = '" . $array['PRIMER_NOMBRE'] . "' "
                        . "AND SEGUNDO_NOMBRE " . $segundo_nombre . ""
                        . " AND  PRIMER_APELLIDO = '" . $array['PRIMER_APELLIDO'] . "'  "
                        . "AND SEGUNDO_APELLIDO " . $segundo_apellido;
                $ExistePersona = Yii::app()->dbOarcle->createCommand($SQL1)->queryRow();
                if (empty($ExistePersona)) {
                    return false;
                } else {
                    return $ExistePersona['ID'];
                }
            } else {
                return $ExistePersonaNew['ID'];
            }
        }
    }

    /*
     * CUNATE LA CANTIDAD DE HIJOS ASOCIADOS AL BENEFICIARIOS
     */

    public function cantHijo($cedula) {

        //$nacional = ($nacionalidad == 97) ? 1 : 0;
        $SLQ = "select count(*)  as CANT from persona where cedula like '" . $cedula . "%' and nacionalidad = 'M'";
        $result = Yii::app()->dbOarcle->createCommand($SLQ)->queryRow();
        return $result['CANT'];
    }

    /*  -------------------------------------------- */

    public function getPersonaBeneficiario($nacionalidad, $cedula) {

        $nacional = ($nacionalidad == 97) ? 1 : 0;
        $SLQ = "SELECT P.ID, P.NACIONALIDAD , P.CEDULA, P.PRIMER_NOMBRE AS PRIMERNOMBRE, P.SEGUNDO_NOMBRE AS SEGUNDONOMBRE, P.PRIMER_APELLIDO AS PRIMERAPELLIDO,
                P.SEGUNDO_APELLIDO AS SEGUNDOAPELLIDO ,TO_CHAR(P.FECHA_NACIMIENTO, 'DD-MM-YYYY' ) AS FECHANACIMIENTO, GEN_SEXO.NOMBRE AS SEXO, GEN_EDO_CIVIL.NOMBRE AS EDOCIVIL,
                P.CODIGO_HAB, P.TELEFONO_HAB AS TELEFONOHAB, P.CODIGO_MOVIL, P.TELEFONO_MOVIL AS TELEFONOMOVIL, P.CORREO_PRINCIPAL AS CORREO,1 AS PROCEDENCIA
                FROM TABLAS_COMUNES.PERSONA P 
                LEFT JOIN  GEN_SEXO ON P.GEN_SEXO_ID = GEN_SEXO.ID  
                LEFT JOIN GEN_EDO_CIVIL ON P.GEN_EDO_CIVIL_ID = GEN_EDO_CIVIL.ID WHERE P.NACIONALIDAD = '" . $nacional . "' AND P.CEDULA = " . $cedula;

        $result = Yii::app()->dbOarcle->createCommand($SLQ)->queryRow();
//        var_dump($result); die();
        if (empty($result)) {
            return 1;
        } else {
            return $result;
        }
    }

    /*   ------------------------------------------- */

    /*  ////////Busqueda de Saime para Beneficiario /////////// */

    public function getSaimeBeneficiario($nacionalidad, $cedula) {
        //$valNacionalidad = array('valNacionalidad' => ($nacionalidad == 97) ? '1' : '0');
        $nacional = ($nacionalidad == 97) ? 'V' : 'E';

        $SLQ = "SELECT NAC AS NACIONALIDAD, CEDULA, PRIMERNOMBRE, SEGUNDONOMBRE, PRIMERAPELLIDO, SEGUNDOAPELLIDO, TO_DATE(FECHA, 'RR-MM-DD' ) As FECHANACIMIENTO,2 AS PROCEDENCIA FROM ORGANISMOS_PUBLICOS.ONIDEX WHERE NAC ='" . $nacional . "' AND CEDULA = '" . $cedula . "'";
        $result = Yii::app()->dbOarcle->createCommand($SLQ)->queryRow();

        if (empty($result)) {
            return 1;
        } else {
            return $result;
        }
    }

    /*  //////////////////////////////////////////////////////  */



    /*
     * Consulta Tabla ORGANISMOS_PUBLICOS.ONIDEX de ORGANISMOS_PUBLICOS
     * Consulta que busca por nacionalidad y cedula
     * Return NACIONALIDAD, CEDULA, PRIMERNOMBRE, SEGUNDONOMBRE, PRIMERAPELLIDO, SEGUNDOAPELLIDO, FECHANACIMIENTO
     * SI return es 1, indica que no existe en tabla ONIDEX
     */

    public function getSaime($nacionalidad, $cedula) {
        //$valNacionalidad = array('valNacionalidad' => ($nacionalidad == 97) ? '1' : '0');
        $nacional = ($nacionalidad == 97) ? 'V' : 'E';

        $SLQ = "SELECT NAC AS NACIONALIDAD, CEDULA, PRIMERNOMBRE, SEGUNDONOMBRE, PRIMERAPELLIDO, SEGUNDOAPELLIDO, TO_DATE(FECHA, 'RR-MM-DD') As FECHANACIMIENTO FROM ORGANISMOS_PUBLICOS.ONIDEX WHERE NAC ='" . $nacional . "' AND CEDULA = '" . $cedula . "'";

        $result = Yii::app()->dbOarcle->createCommand($SLQ)->queryRow();

        if (empty($result)) {
            return 1;
        } else {
            return $result;
        }
    }

    /*
     * Consulta la Funcion de F_BUSCA_DATOS_AHORRISTA del schema faoveel
     * @param $idPersona , $caso ( 1:promedio, 2:ingreso) 
     * Return false is null, decimal si existe
     */

    public function getFaov($idPersona, $caso) {
        $SLQ = "SELECT a.cedula, faoveel.F_BUSCA_DATOS_AHORRISTA(a.id) FROM tablas_comunes.persona a WHERE a.id in (" . $idPersona . ")";
        $result = Yii::app()->dbOarcle->createCommand($SLQ)->queryRow();
        if (empty($result)) {
            return false;
        } else {
            $result = explode(';', $result['FAOVEEL.F_BUSCA_DATOS_AHORRISTA(A.ID)']);
            switch ($result[0]) {
                case 1: //FAOV
                    if ($caso == 1) {
                        $salida = ($result[4] / (0.03) );
                    } else {
                        $salida = $result[9];
                    }
                    break;
                case 2: //FAVV
                    if ($caso == 1) {
                        $salida = ( $result[8] / (0.03) );
                    } else {
                        $salida = $result[10];
                    }
                    break;
                case 3 : //FAOV-FAVV
                    if ($caso == 1) {
                        $salida = ( $result[4] / (0.03) ) + ($result[8] / (0.03) );
                    } else {
                        $salida = $result[9] + $result[10];
                    }
                    break;
            }
            return empty($salida) ? '0.00' : number_format($salida, 2, '.', '');
        }
    }

    /*
     * Funcion que inserta datos en table PERSONA
     * @param $array, key => value, (donde key es el la columna y el value es el valos que va a tomar la columna)
     * Return true si se hizo con éxito
     */

    public function insertPersona($array) {
        if (empty($array)) {
            return false;
        } else {
            $select = array();
            $valor = array();
            foreach ($array as $key => $value) {
                if ($key == 'FECHA_NACIMIENTO') {
                    array_push($select, $key);
                    array_push($valor, "to_date('" . $value . "','DD/MM/RR')");
                } else {
                    array_push($select, $key);
                    if (is_numeric($value)) {
                        array_push($valor, $value);
                    } else {
                        array_push($valor, "'" . $value . "'");
                    }
                }
            }
            $select = implode(',', $select);
            $valor = implode(',', $valor);

            $Existe = "SELECT ID FROM TABLAS_COMUNES.PERSONA WHERE NACIONALIDAD = " . (int) $array['NACIONALIDAD'] . " AND CEDULA = " . (int) $array['CEDULA'];
            $ExistePersonaNew = Yii::app()->dbOarcle->createCommand($Existe)->queryRow();
            if (!($ExistePersonaNew)) {
//                $SQL = " SELECT PERSONA_ID_SEQ.NEXTVAL INTO ID_PERSONA FROM DUAL;"
//                        . "INSERT INTO TABLAS_COMUNES.PERSONA (ID, " . $select . ") VALUES (ID_PERSONA," . $valor . ")";
                $SQL = "INSERT INTO TABLAS_COMUNES.PERSONA (ID, " . $select . ") VALUES ((SELECT MAX(ID)+1 FROM TABLAS_COMUNES.PERSONA)," . $valor . ")";

                $result = Yii::app()->dbOarcle->createCommand($SQL)->query();

                $SQL1 = "SELECT ID FROM TABLAS_COMUNES.PERSONA WHERE NACIONALIDAD = " . (int) $array['NACIONALIDAD'] . " AND CEDULA = " . (int) $array['CEDULA'];
                $ExistePersona = Yii::app()->dbOarcle->createCommand($SQL1)->queryRow();

                if (empty($ExistePersona)) {
                    return false;
                } else {
                    return $ExistePersona['ID'];
                }
            } else {
                return false;
            }
        }
    }

    /* Buscar a las personas en Oracle para que no inserte solo consulta===== */
    
     public function BuscarPersona($array) {
//         echo '888';die;
        if (empty($array)) {
            return false;
        } else {
            $select = array();
            $valor = array();
            foreach ($array as $key => $value) {
                if ($key == 'FECHA_NACIMIENTO') {
                    array_push($select, $key);
                    array_push($valor, "to_date('" . $value . "','DD/MM/RR')");
                } else {
                    array_push($select, $key);
                    if (is_numeric($value)) {
                        array_push($valor, $value);
                    } else {
                        array_push($valor, "'" . $value . "'");
                    }
                }
            }
            $select = implode(',', $select);
            $valor = implode(',', $valor);
            
            
            $SQL1 = "SELECT ID FROM TABLAS_COMUNES.PERSONA WHERE NACIONALIDAD = " . (int) $array['NACIONALIDAD'] . " AND CEDULA = " . (int) $array['CEDULA'];
            $ExistePersona = Yii::app()->dbOarcle->createCommand($SQL1)->queryRow();

                if (empty($ExistePersona)) {
                    return false;
                } else {
                    return $ExistePersona['ID'];
                }

        }
    }  
    
    /*  =========================================== */    
    

    public function updatePersona($array, $id_persona) {

        if (empty($array)) {
            return false;
        } else {
            $select = array();
            $campos = ' ';
            $cont = 1;

            foreach ($array as $key => $value) {

                /*  --------------------------- */

                switch ($key) {
                    case 'FECHA_NACIMIENTO':
                        if ($cont != 1)
                            $campos .= ',';
                        $campos .= $key . " = to_date('$value','DD/MM/RR') ";
                        break;
                    case 'CODIGO_HAB':
                    case 'TELEFONO_HAB':
                    case 'CODIGO_MOVIL':
                    case 'TELEFONO_MOVIL':
                        if ($cont != 1)
                            $campos .= ',';
                        $campos .= $key . "='" . $value . "' ";
                        break;

                    default:
                        if ($cont != 1)
                            $campos .= ',';
                        if (is_numeric($value)) {

                            $campos .= $key . "=" . $value;
                        } else {
                            $campos .= $key . "='" . $value . "' ";
                        }
                }
                $cont++;
            }

            /*  ------------------------------ */

            /* if ($key == 'FECHA_NACIMIENTO') {
              if($cont != 1) $campos .= ',';
              $campos .= $key." = to_date('$value','DD/MM/RR') ";
              } else {
              if($cont != 1) $campos .= ',';
              if (is_numeric($value)) {

              $campos .= $key."=".$value;
              } else {
              $campos .= $key."='".$value."' ";
              }
              }

              $cont++;
              } */

            // var_dump($campos); die();

            $SQL = "UPDATE TABLAS_COMUNES.PERSONA SET " . $campos . " WHERE ID = " . $id_persona;



//             var_dump($SQL); die();
            $result = Yii::app()->dbOarcle->createCommand($SQL)->query();


            return $id_persona;
        }
    }

    /*  ===========================================  */

    /*
     * FUNCTION QUE CONSULTA LOS ULTIMOA MOVIMIENTOS DE FAOV
     */

    public function ultimoPagoFaov($idPersona) {
        $SQL = 'SELECT faoveel.F_ULT_PAGOS_AHORRISTA(' . $idPersona . ') FROM dual';
        $result = Yii::app()->dbOarcle->createCommand($SQL)->queryRow();

        if ($result["FAOVEEL.F_ULT_PAGOS_AHORRISTA(" . $idPersona . ")"] == 0) {
            return false;
        } else {
            $con = str_replace(',', '.', $result["FAOVEEL.F_ULT_PAGOS_AHORRISTA(" . $idPersona . ")"]);
            $separador = explode(';', $con);

            $i = 1;
            $inicio = 0;
            $valor = array();
            foreach ($separador AS $contenedor) {
                $r = implode(',', array_slice($separador, $inicio, 4));
                $inicio+=4; //INCREMENTA DE 4 EN 4
                if ($r != '') {
                    array_push($valor, $r);
                }
            }
            return $valor;
            
        }
    }
}
