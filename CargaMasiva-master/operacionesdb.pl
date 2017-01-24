# En este archivo se realizan todas las operaciones sobre las bases de datos
#
#

use Switch;

#### inicio unidad multifamiliar
sub unidadMultifamiliar($) {
      my ($args) = @_;
      my $tipo_inmueble;

      if    ($args->{tipo_inmueble} eq 'EDIFICIO DE APARTAMENTOS' )  { $tipo_inmueble = 82 }
      elsif ($args->{tipo_inmueble} eq 'CASA' )                      { $tipo_inmueble = 83 }
      elsif ($args->{tipo_inmueble} eq 'PARCELA' )                   { $tipo_inmueble = 84 }
      elsif ($args->{tipo_inmueble} eq 'TERRENO' )                   { $tipo_inmueble = 85 }

      $sth = $pgdb->prepare("SELECT id_unidad_habitacional FROM unidad_habitacional WHERE nombre = '".$args->{unidad_multifamiliar} ."' AND desarrollo_id = $id_desarrollo" );
      $sth->execute();
      if ($rows = $sth->execute) {
          if ($rows==0) {
            $multifamiliar = $pgdb->prepare("INSERT INTO unidad_habitacional(nombre,desarrollo_id,gen_tipo_inmueble_id,fuente_datos_entrada_id, estatus,lindero_norte, lindero_sur, lindero_este, lindero_oeste, usuario_id_creacion )
                   VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
            $multifamiliar->execute( $args->{unidad_multifamiliar}, $id_desarrollo, $tipo_inmueble, 91, 77, $args->{campos}{lindero_norte_multifamiliar}, $args->{campos}{lindero_sur_multifamiliar},$args->{campos}{lindero_este_multifamiliar},$args->{campos}{lindero_oeste_multifamiliar},$usuario_id_creacion);
            $id_unidad_multifamiliar = $pgdb->last_insert_id("null", "public", unidad_habitacional, id_unidad_habitacional);
          }
          else {@unidad_multifamiliar = $sth->fetchrow_array();
              $id_unidad_multifamiliar=$unidad_multifamiliar[0];
          }
      }

        return $id_unidad_multifamiliar;

}### fin unidad multifamiliar


sub unidadFamiliar($) {
      my ($args) = @_;
      my $tipo_inmueble;

      $sala = ($args->{campos}{sala} eq 'SI') ? TRUE : ( ($args->{campos}{sala} eq 'NO') ? FALSE
                      : mensajesCarga( "sala-$linea", "Valor para sala incorrecto en linea $linea" ));

      $comedor = ($args->{campos}{comedor} eq 'SI') ? TRUE : ( ($args->{campos}{comedor} eq 'NO') ? FALSE
                      : mensajesCarga( "comedor-$linea", "Valor para comedor incorrecto en linea $linea" ));

      $lavandero = ($args->{campos}{lavandero} eq 'SI') ? TRUE : ( ($args->{campos}{lavandero} eq 'NO') ? FALSE
                      : mensajesCarga( "lavandero-$linea", "Valor para lavandero incorrecto en linea $linea" ));

      $cocina = ($args->{campos}{cocina} eq 'SI') ? TRUE : ( ($args->{campos}{cocina} eq 'NO') ? FALSE
                      : mensajesCarga( "cocina-$linea", "Valor para cocina incorrecto en linea $linea" ));

      $args->{campos}{area_mt2}            =~ s/\,/./g;
      $args->{campos}{porcentaje_vivienda} =~ s/\,/./g;
      $args->{campos}{precio_de_vivienda}  =~ s/\,/./g;
      my $num_estacionamiento = ($args->{campos}{numero_estacionamiento} eq '') ? 0 : $args->{campos}{numero_estacionamiento} ;

      $sth = $pgdb->prepare("SELECT id_vivienda FROM vivienda WHERE unidad_habitacional_id = '".$args->{id_unidad_multifamiliar} ."' AND nro_vivienda = '$args->{campos}{numero_de_vivienda}'" );
      $sth->execute();
      if ($rows = $sth->execute) {
          if ($rows==0) {
            $multifamiliar = $pgdb->prepare("INSERT INTO vivienda(tipo_vivienda_id,unidad_habitacional_id,construccion_mt2,nro_piso, nro_vivienda, sala, comedor,lavandero,lindero_norte,lindero_sur,lindero_este,lindero_oeste,coordenadas,precio_vivienda,nro_estacionamientos,descripcion_estac,nro_habitaciones,nro_banos,fuente_datos_entrada_id,estatus_vivienda_id,cocina,porcentaje_vivienda, nro_banos_auxiliar,asignada, usuario_id_creacion )
                   VALUES ( ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? )") or die( $DBI::errstr . "\n" );

if($args->{campos}{porcentaje_vivienda} eq ''){
	$porcentaje = 0;
}else{
	$porcentaje = $args->{campos}{porcentaje_vivienda};
}
    $multifamiliar->execute( 94, $args->{id_unidad_multifamiliar}, ($args->{campos}{area_mt2} eq '') ? 0: $args->{campos}{area_mt2}, $args->{campos}{numero_de_piso},
        $args->{campos}{numero_de_vivienda}, $sala, $comedor, $lavandero, $args->{campos}{lindero_norte_vivienda},$args->{campos}{lindero_sur_vivienda},$args->{campos}{lindero_este_vivienda},$args->{campos}{lindero_oeste_vivienda},$args->{campos}{coordenadas},                                 $args->{campos}{precio_de_vivienda},$num_estacionamiento ,$args->{campos}{puesto_estacionamiento},
        $args->{campos}{numero_de_habitaciones},$args->{campos}{numero_de_banos},91,75, $cocina,$porcentaje,
        $args->{campos}{nro_banos_auxiliar}, TRUE,  $usuario_id_creacion) or die( $DBI::errstr . "\n" );

            $id_vivienda = $pgdb->last_insert_id("null", "public", "vivienda", "id_vivienda");

          }
          else {@unidad_familiar = $sth->fetchrow_array();
          $id_vivienda=$unidad_familiar[0];
          }
      }

        return $id_vivienda;

}### fin unidad multifamiliar


sub beneficiarioTemporal($) {
      my ($args) = @_;

      ### Consultamos cedula TABLAS_COMUNES.PERSONA en oracle
        my $cedula = $args->{campos}{cedula};
        $nacionalidad = ($args->{campos}{nacionalidad} eq 'V') ? 1 : ( ($args->{campos}{nacionalidad} eq 'E') ? 0
                        : mensajesCarga( "nacionalidad-$linea", "nacionalidad incorrecta en linea $linea" ));

        my $sth = $oradb->prepare("SELECT ID, NACIONALIDAD , CEDULA, PRIMER_NOMBRE AS PRIMERNOMBRE
                                FROM TABLAS_COMUNES.PERSONA WHERE NACIONALIDAD = '$nacionalidad' AND CEDULA = $cedula ");
        $sth->execute();
        @persona  = $sth->fetchrow_array();
        $sth->finish();

      ### Fin consulta TABLAS_COMUNES.PERSONA oracle

      my $ID = $persona[0];
      if( $ID eq ''){

        $sth = $oradb->prepare("SELECT ID, NAC, CEDULA, PRIMERNOMBRE, SEGUNDONOMBRE, PRIMERAPELLIDO, SEGUNDOAPELLIDO, TO_DATE(FECHA, 'YYYY-MM-DD' ) As FECHANACIMIENTO,2 AS PROCEDENCIA
                                FROM ORGANISMOS_PUBLICOS.ONIDEX
                                WHERE NAC ='$args->{campos}{nacionalidad}' AND CEDULA = '$cedula' ");
        $sth->execute();
        #my ($ID,$nacionalidad,$cedula, $primernombre)  = $sth->fetchrow_array();
        @saime  = $sth->fetchrow_array();

        ### Sacar ultimo ID en PERSONA
        $sth = $oradb->prepare("SELECT MAX(ID)+1 FROM TABLAS_COMUNES.PERSONA");
        $sth->execute();
        #my ($ID,$nacionalidad,$cedula, $primernombre)  = $sth->fetchrow_array();
        @id_persona  = $sth->fetchrow_array();

        $sexo = ($args->{campos}{sexo} eq 'MASCULINO') ? 2 : 1;


        if    ($args->{campos}{edo_civil} eq 'CASADO(A)'     )  { $edo_civil = 2 }
        elsif ($args->{campos}{edo_civil} eq 'DIVORCIADO(A)' )  { $edo_civil = 4 }
        elsif ($args->{campos}{edo_civil} eq 'SOLTERO(A)' )     { $edo_civil = 1 }
        elsif ($args->{campos}{edo_civil} eq 'VIUDO(A)' )       { $edo_civil = 3 }


        my $cod_tlf_habitacion = "0".substr( $args->{campos}{telefono_habitacion} , 0, 3);
        my $tlf_habitacion     = substr( $args->{campos}{telefono_habitacion} , 3, 10);

        my $cod_tlf_celular = "0".substr( $args->{campos}{telefono_celular} , 0, 3);
        my $tlf_celular     = substr( $args->{campos}{telefono_celular} , 3, 10);

        $persona_oracle = $oradb->prepare("INSERT INTO TABLAS_COMUNES.PERSONA(ID, CEDULA, NACIONALIDAD, PRIMER_NOMBRE, SEGUNDO_NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO, FECHA_NACIMIENTO, GEN_SEXO_ID, GEN_EDO_CIVIL_ID, CODIGO_HAB, TELEFONO_HAB, CODIGO_MOVIL, TELEFONO_MOVIL, CORREO_PRINCIPAL )
               VALUES (?,?, ?, ?, ?, ?, ?, TO_DATE(?,'DD/MM/RR'), ?, ?, ?, ?, ?, ?, ? )");
        #my @persona = Funciones::picapersona( $consulta[8] );
        #$persona_oracle->execute( 9625808,17845965,1,'KARINA','LISBETH','NIEVES','PARRA',TO_DATE('27/05/85','DD/MM/RR'),1,'0212','6544565','0416','4565434','karinitanieves@gmail.com');
        $persona_oracle->execute( $id_persona[0],"$saime[2]",$nacionalidad,"$saime[3]","$saime[4]","$saime[5]","$saime[6]","$saime[7]",$sexo,$edo_civil,$cod_tlf_habitacion,$tlf_habitacion,$cod_tlf_celular,$tlf_celular, "$args->{campos}{correo_electronico}");
        my $id_oracle = $oradb->last_insert_id("null", "TABLAS_COMUNES", PERSONA, ID);
        print "ULTIMO ID ORACLE: ".$id_persona[0]."\n";
        #@persona  = $sth->fetchrow_array();

        $persona_oracle->finish();
        $persona_id = $id_persona[0];
      }else{
        $persona_id = $persona[0];
      }

      if( defined( $persona_id ) && $persona_id ne '' ){

      print "PRINT ID PERSONA TABLAS_COMUNES: ".Dumper($persona_id );

      $nacionalidad = ($args->{campos}{nacionalidad} eq 'V') ? 97 : ( ($args->{campos}{nacionalidad} eq 'E') ? 98
                      : mensajesCarga( "nacionalidad-$linea", "nacionalidad incorrecta en linea $linea" ));

      $nombre_completo = $args->{campos}{primer_nombre}." ".$args->{campos}{segundo_nombre}." ".$args->{campos}{primer_apellido}." ".$args->{campos}{segundo_apellido};

      my $beneficiariotemp = $pgdb->prepare("INSERT INTO beneficiario_temporal(persona_id, desarrollo_id, unidad_habitacional_id, vivienda_id, nacionalidad, cedula, nombre_completo, estatus, usuario_id_creacion, carga_masiva_id )
               VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
        #my @persona = Funciones::picapersona( $consulta[8] );
        $beneficiariotemp->execute( $persona_id , $id_desarrollo, $id_unidad_multifamiliar, $id_vivienda, $nacionalidad, $args->{campos}{cedula},$nombre_completo,221, $usuario_id_creacion, $id_carga_masiva);
        $id_beneficiario_temporal = $pgdb->last_insert_id("null", "public", beneficiario_temporal, id_beneficiario_temporal);


      }

      return $id_beneficiario_temporal;

}### fin beneficiario temporal



sub validarExistenciaBeneficiario {
  my ($args) = @_;

  $sth = $pgdb->prepare("SELECT cedula FROM beneficiario_temporal WHERE cedula = '".$args->{campos}{cedula} ."'" );
  $sth->execute();
  if ($rows = $sth->execute) {
      if ($rows>0) {
        print "repetido \n";
        mensajesCarga( "Linea $linea", "Beneficiario ya existe. cedula: $args->{campos}{cedula} $args->{campos}{primer_nombre} $args->{campos}{primer_apellido} " );
        return "repetido"
        }

  }

}


sub mensajesCarga {
  my ($clave, $valor) = @_;

  $addinfo->{$clave} = $valor;

  #UPDATE carga_masiva SET mensajes_carga = mensajes_carga || hstore('miclave','mivalor') where id_carga_masiva=73

  my $update_carga_masiva = $pgdb->prepare("UPDATE carga_masiva SET mensajes_carga = mensajes_carga || ? where id_carga_masiva=?");
   $update_carga_masiva->execute( Pg::hstore::encode($addinfo), $id_carga_masiva );
  # $pgdb->commit;
print "por aqui paso";
}### fin mensajes Carga


  sub logger {
    my ($level, $msg) = @_;

    if (open my $out, '>>', 'log.txt') {
        chomp $msg;
        print $out "$level - $msg - $id_carga_masiva \n";
  my $update_observacion = $pgdb->prepare("UPDATE carga_masiva SET observaciones = observaciones || ? where id_carga_masiva=?");
  $update_observacion->execute( $msg, $id_carga_masiva );
print "Por aqui donde el log";

 # my $update_observacion = "UPDATE carga_masiva SET observaciones = '$msg' where id_carga_masiva=$id_carga_masiva;";
 #  $pgdb->do($update_observacion);
#$pgdb->commit;
#	my $update_observacion = "UPDATE some_table SET som_col = ? WHERE id = ?";
#	$rv  = $pgdb->do($update_observacion, undef, "$level - $msg </br> \n" , $id_carga_masiva);
    }
  }### fin log en campo observacion de tabla carga_masiva



1;
