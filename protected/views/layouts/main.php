<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <style type="text/css">
            .loader {
                position: fixed;
                left: 0px;
                top: 0px;
                width: 100%;
                height: 100%;
                z-index: 9999;
                /*//background: url('images/loading_prueba.gif') 50% 50% no-repeat rgb(249,249,249);*/
                background:url("<?php echo Yii::app()->baseUrl; ?>/images/loading_prueba.gif") 50% 50% no-repeat;
            }
        </style>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui/jquery-ui-1.10.1.custom.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/administrador/css3clock/css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl; ?>/images/favicon.png" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/menu.css" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <?php if (Yii::app()->user->checkAccess('action_site_indexAdmin')) { ?>
        <body>
            <div class="loader"></div>
            <section id="container">
                <header class="header fixed-top clearfix">
                    <div class="brand" style="height: 60%;">
                        <a href="<?php echo $this->createUrl('/site/indexAdmin'); ?>" class="logo">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banavih_ndice1.png" alt="" width="150px"  style="margin-top: -6%;margin-bottom: 4%;margin-left: 10%;">
                        </a>
                        <div class="sidebar-toggle-box">
                            <div class="fa fa-bars glyphicon glyphicon-list"></div>
                        </div>
                    </div>

                    <div class="nav notify-row" id="top_menu">
                        <!--  notification start -->
                        <!--                    <ul class="nav top-menu">
                                                 settings start
                                                <li class="dropdown">
                                                    <a data-toggle="dropdown" class="dropdown-toggle" href="<?php echo $this->createUrl('site/index'); ?>">
                                                        <span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
                                                    </a>
                                                </li>
                                                 notification dropdown end
                                            </ul>-->
                        <!--  notification end -->
                    </div>
                    <div class="top-nav clearfix">
                        <!--search & user info start-->
                        <ul class="nav pull-right top-menu">
                            <!-- user login dropdown start-->
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="glyphicon glyphicon-user"><?php echo Yii::app()->user->name; ?></span>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu extended logout">
                                    <li>
                                        <a class="glyphicon glyphicon-lock" href="<?php echo $this->createUrl('/cruge/ui/usermanagementupdate', array('id' => Yii::app()->user->id)); ?>">
                                            <i class="fa fa-key"></i>Cambiar Clave
                                        </a>
                                    </li>
                                    <li>
                                        <a class="glyphicon glyphicon-off" href="<?php echo $this->createUrl('/site/logout'); ?>"><i class="fa fa-key"></i>Salir</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- user login dropdown end -->
                        </ul>
                        <!--search & user info end-->
                    </div>
                </header>
                <aside>
                    <div id="sidebar" class="nav-collapse">
                        <div class="leftside-navigation" style ="margin-top: 19%;">
                            <ul class="sidebar-menu" id="nav-accordion">
                                <li>
                                    <a href="<?php echo $this->createUrl('/site/indexAdmin'); ?>">
                                        <i class="glyphicon glyphicon-asterisk"></i>
                                        <span>Inicio</span>
                                    </a>
                                </li>

                                <?php if (Yii::app()->user->checkAccess('administrador')) { ?>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="glyphicon glyphicon-user"></i>
                                            <span>Administrador</span>
                                        </a>
                                        <ul class="sub-menu">
                                            <?php if (Yii::app()->user->checkAccess('action_ui_usermanagementadmin')) { ?>
                                                <li class="sub-menu">
                                                    <a href="<?php echo $this->createUrl('/cruge/ui/usermanagementadmin'); ?>">
                                                        <i class="glyphicon glyphicon-user"></i>
                                                        <span>Usuarios</span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php if (Yii::app()->user->checkAccess('action_auditoria_admin')) { ?>
                                            <li class="sub-menu">
                                                <a href="<?php echo $this->createUrl('/auditoria/admin'); ?>">
                                                    <i class="glyphicon glyphicon-search"></i>
                                                    <span>Auditoria</span>
                                                </a>
                                            </li>
                                            <?php } ?>
                                            <?php if (Yii::app()->user->checkAccess('action_maestro_admin')) { ?>
                                            <li>
                                                <a href="<?php echo $this->createUrl('/maestro/admin'); ?>">
                                                    <i class="glyphicon glyphicon-wrench"></i>
                                                    <span>Tabla Maestro</span>
                                                </a>
                                            </li>
                                            <?php } ?>
                                        </ul>    
                                    </li>
                                <?php } ?>

                                <?php if (Yii::app()->user->checkAccess('controller_oficina')) { ?>
                                    <li class="sub-menu">
                                        <a href="javascript:;">
                                            <i class="glyphicon glyphicon-stats"></i>
                                            <span>Parametros del Sistema</span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu">
                                                <a href="javascript:;">
                                                    <i class="glyphicon glyphicon-book"></i>
                                                    <span>Oficinas</span>
                                                </a>
                                                <ul class="sub">
                                                    <?php if (Yii::app()->user->checkAccess('action_oficina_create')) { ?>
                                                        <li>
                                                            <a href="<?php echo $this->createUrl('/oficina/create'); ?>">Cargar Nueva Oficina</a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if (Yii::app()->user->checkAccess('action_oficina_admin')) { ?>
                                                        <li>
                                                            <a href="<?php echo $this->createUrl('/oficina/admin'); ?>">Gestión de Oficinas</a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>


                                            <?php if (Yii::app()->user->checkAccess('controller_abogados')) { ?>
                                                <li class="sub-menu">
                                                    <a href="javascript:;">
                                                        <i class="glyphicon glyphicon-th-list"></i>
                                                        <span>Agente de Documentación</span>
                                                    </a>
                                                    <ul class="sub">
                                                        <?php if (Yii::app()->user->checkAccess('action_abogados_create')) { ?>
                                                            <li>
                                                                <a href="<?php echo $this->createUrl('/abogados/create'); ?>">Cargar Nuevo Agente de Documentación</a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if (Yii::app()->user->checkAccess('action_abogados_admin')) { ?>
                                                            <li>
                                                                <a href="<?php echo $this->createUrl('/abogados/admin'); ?>">Gestión de Agente de Documentación</a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            <?php if (Yii::app()->user->checkAccess('controller_registropublico')) { ?>
                                                <li class="sub-menu">
                                                    <a href="javascript:;">
                                                        <i class="glyphicon glyphicon-briefcase"></i>
                                                        <span>Registro Público</span>
                                                    </a>
                                                    <ul class="sub">
                                                        <?php if (Yii::app()->user->checkAccess('action_registropublico_create')) { ?>
                                                            <li>
                                                                <a href="<?php echo $this->createUrl('/registroPublico/create'); ?>">Cargar Nuevo Registro Público</a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                                <?php // if (Yii::app()->user->checkAccess('action_fuentefinanciamiento_create')) { ?>
                                                <!--<li>-->
                                                    <!--<a href="<?php // echo $this->createUrl('/fuenteFinanciamiento/create');  ?>">Cargar Fuentes de Financiamiento</a>-->
                                                <!--</li>-->
                                                <?php // } ?>
                                                <?php if (Yii::app()->user->checkAccess('action_fuentefinanciamiento_obra_create')) { ?>
                                                    <li>
                                                        <a href="<?php echo $this->createUrl('/fuenteFinanciamientoObra/create'); ?>">Cargar Fuentes de Financiamiento de la Obra</a>
                                                    </li>
                                                <?php } ?>
                                                <?php if (Yii::app()->user->checkAccess('action_programa_create')) { ?>
                                                    <li>
                                                        <a href="<?php echo $this->createUrl('/programa/create'); ?>">Cargar Nuevo Programa</a>
                                                    </li>
                                                <?php } ?>
                                                <?php if (Yii::app()->user->checkAccess('action_enteejecutor_create')) { ?>
                                                    <li>
                                                        <a href="<?php echo $this->createUrl('/enteEjecutor/create'); ?>">Cargar Ente Ejecutor</a>
                                                    </li>
                                                <?php } ?>
                                            
                                            
                                             <?php if (Yii::app()->user->checkAccess('action_salariominimo_create')) { ?>
                                                    <li>
                                                        <a href="<?php echo $this->createUrl('/salarioMinimo/create'); ?>">Cargar Salario Mínimo</a>
                                                    </li>
                                                <?php } ?>
                                            
                                             <?php if (Yii::app()->user->checkAccess('action_beneficiariotemporal_modificarnombre')) { ?>
                                                    <li>
                                                        <a href="<?php echo $this->createUrl('/beneficiarioTemporal/modificarNombre'); ?>">Modificar Nombres de Adjudicado</a>
                                                    </li>
                                                <?php } ?>
                                            
                                             
                                            
                                            
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>

                                <?php if (Yii::app()->user->checkAccess('controller_desarrollo')) { ?>
                                    <li class="sub-menu">
                                        <a href="javascript:;">
                                            <i class="glyphicon glyphicon-globe"></i>
                                            <span>Desarrollo Habitacional</span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu">
                                                <a href="javascript:;">
                                                    <i class="glyphicon glyphicon-tree-deciduous"></i>
                                                    <span>Desarrollos</span>
                                                </a>

                                                <ul class="sub">
                                                    <?php if (Yii::app()->user->checkAccess('action_desarrollo_create')) { ?>
                                                        <li>
                                                            <a href="<?php echo $this->createUrl('/desarrollo/create'); ?>"> Cargar Nuevo Desarrollo</a>
                                                        </li> <?php } ?>
                                                    <?php if (Yii::app()->user->checkAccess('action_desarrollo_admin')) { ?>
                                                        <li>
                                                            <a href="<?php echo $this->createUrl('/desarrollo/admin'); ?>">Gestión de Desarrollo Habitacional</a>
                                                        </li><?php } ?>
                                                </ul>
                                            </li>

                                            <?php if (Yii::app()->user->checkAccess('controller_unidadhabitacional')) { ?>
                                                <li class="sub-menu">
                                                    <a href="javascript:;">
                                                        <i class="glyphicon glyphicon-map-marker"></i>
                                                        <span>Unidad Multifamiliar</span>
                                                    </a>

                                                    <ul class="sub">
                                                        <?php if (Yii::app()->user->checkAccess('action_unidadhabitacional_create')) { ?>
                                                            <li>
                                                                <a href="<?php echo $this->createUrl('/unidadHabitacional/create'); ?>">Cargar Nueva Unidad Multifamiliar</a>
                                                            </li><?php } ?>
                                                        <?php if (Yii::app()->user->checkAccess('action_vswmultifamiliar_admin')) { ?>
                                                            <li>
                                                                <a href="<?php echo $this->createUrl('/VswMultifamiliar/admin'); ?>">Gestión de Unidades Multifamiliares</a>
                                                            </li><?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            <?php if (Yii::app()->user->checkAccess('controller_unidadhabitacional')) { ?>
                                                <li class="sub-menu">
                                                    <a href="javascript:;">
                                                        <i class="glyphicon glyphicon-home"></i>
                                                        <span>Inmueble Familiar</span>
                                                    </a>
                                                    <ul class="sub">
                                                        <?php if (Yii::app()->user->checkAccess('action_vivienda_create')) { ?>
                                                            <li>
                                                                <a href="<?php echo $this->createUrl('/vivienda/create'); ?>">Cargar Nuevo Inmueble Familiar</a>
                                                            </li><?php } ?>
                                                        <?php if (Yii::app()->user->checkAccess('action_vswunifamiliar_admin')) { ?>
                                                            <li>
                                                                <a href="<?php echo $this->createUrl('/vswUnifamiliar/admin'); ?>">Gestión de Inmueble Familiarr</a>
                                                            </li><?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>

                                        </ul>
                                    </li>
                                <?php } ?>
                                <?php if (Yii::app()->user->checkAccess('controller_beneficiariotemporal')) { ?>
                                    <li class="sub-menu">
                                        <a href="javascript:;">
                                            <i class="glyphicon glyphicon-user"></i>
                                            <span>Gestión de Adjudicados</span>
                                        </a>
                                        <ul class="sub-menu">
                                            <?php if (Yii::app()->user->checkAccess('action_beneficiariotemporal_create')) { ?>
                                                <li>
                                                    <a href="<?php echo $this->createUrl('/beneficiarioTemporal/create'); ?>">
                                                        <i class="glyphicon glyphicon-user"></i><span>Cargar Nuevo Adjudicado</span></a>
                                                </li><?php } ?>
                                            <?php if (Yii::app()->user->checkAccess('action_beneficiariotemporal_admin')) { ?>
                                                <li>
                                                    <a href="<?php echo $this->createUrl('/beneficiarioTemporal/admin'); ?>"><i class="glyphicon glyphicon-user"></i><span>Listado de Adjudicados</span></a>
                                                </li><?php } ?>
                                        </ul>
                                        <!--<ul class="sub-menu">-->
                                        <?php // if (Yii::app()->user->checkAccess('action_cargamasiva_create')) { ?>
                                        <!--<li>-->
                                            <!--<a href="<?php // echo $this->createUrl('/cargaMasiva/create');  ?>"><i class="glyphicon glyphicon-cloud-upload"></i><span>Carga Masiva</span></a>-->
                                        <!--</li>-->
                                        <?php // } ?>
                                        <?php // if (Yii::app()->user->checkAccess('action_cargamasiva_admin')) { ?>
                                        <!--<li>-->
                                            <!--<a href="<?php // echo $this->createUrl('/cargaMasiva/admin');  ?>"><i class="glyphicon glyphicon-cloud-download"></i><span>Listado Carga Masivas</span></a>-->
                                        <!--</li>-->
                                        <?php // } ?>
                                        <!--</ul>-->


                                    </li>
                                <?php } ?>
                                <?php if (Yii::app()->user->checkAccess('controller_asignacioncenso')) { ?>
                                    <li class="sub-menu">
                                        <a href="javascript:;">
                                            <i class="glyphicon glyphicon-briefcase"></i>
                                            <span>Asignación de Censo</span>
                                        </a>
                                        <ul class="sub">
                                            <?php if (Yii::app()->user->checkAccess('action_adjudicado_create')) { ?>
                                                <li>
                                                    <a href="<?php echo $this->createUrl('/asignacionCenso/create'); ?>"><i class="glyphicon glyphicon-home"></i><span>Asignar Censo</span></a>
                                                </li><?php } ?>
                                            <?php if (Yii::app()->user->checkAccess('action_vswasignacioncenso_admin')) { ?>
                                                <li>
                                                    <a href="<?php echo $this->createUrl('/vswAsignacionCenso/admin'); ?>"><i class="glyphicon glyphicon-home"></i><span>Gestión de Asignación</span></a>
                                                </li><?php } ?>

                                        </ul>
                                    </li>
                                <?php } ?>
                                <?php if (Yii::app()->user->checkAccess('controller_empadronadorcenso')) { ?>
                                    <li >
                                        <!--                                        <a href="javascript:;">
                                            <i class="glyphicon glyphicon-tasks"></i>
                                            <span> Gestión Empadronador</span>
                                                                                </a>-->
                                        <!--<ul class="sub">-->
                                            <!--<li><a href="<?php // echo $this->createUrl('/beneficiario/create');                                                                                                                                                                                                                                            ?>"><i class="glyphicon glyphicon-home"></i><span>Censo</span></a></li>-->
                                            <?php if (Yii::app()->user->checkAccess('action_vswempadronadorcensos_admin')) { ?>
                                            <!--<li>-->
                                                    <a href="<?php echo $this->createUrl('/vswEmpadronadorCensos/admin'); ?>">
                                                        <i class="glyphicon glyphicon-home"></i>
                                                        <span>Gestión de Empadronador</span>
                                                    </a>
                                            <!--</li>-->
                                        <?php } ?>
                                        <!--</ul>-->
                                    </li>
                                <?php } ?>




                                <?php if (Yii::app()->user->checkAccess('action_reasignacionvivienda_admin')) { ?>
                                    <li>
                                        <a href="<?php echo $this->createUrl('/reasignacionVivienda/admin'); ?>">
                                            <i class="glyphicon glyphicon-home"></i>
                                            <span>Gestión Reasignación <br> de Vivienda</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (Yii::app()->user->checkAccess('action_vswcensosculminados_admin')) { ?>
                                    <li>
                                        <a href="<?php echo $this->createUrl('/vswCensosCulminados/admin'); ?>">
                                            <i class="glyphicon glyphicon-list-alt"></i>
                                            <span>Gestión Censo <br> Socioeconómico</span>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if (Yii::app()->user->checkAccess('controller_analisiscredito') || Yii::app()->user->checkAccess('documentacion')) { ?>
                                <!--VEO EL MENÚ DE ANALISIS SI SOY EL GERENTE DE ESTA AREA Y SI EL USUARIO TIENE LOS PERMISOS PARA ASIGNAR Y HACER ANALISIS FINANCIEROS-->
                                    <li class="sub-menu">
                                        <a href="javascript:;">
                                            <i class="glyphicon glyphicon-briefcase"></i>
                                            <span> Analisis de Crédito</span>
                                        </a>
                                        <ul class="sub">
                                            <?php if (Yii::app()->user->checkAccess('action_tempCensoValidadoFaovFasp_admin')) { ?>
                                                <li>
                                                     <!--<a href="<?php // echo $this->createUrl('/VswCensoValidadoFaovFasp/admin');   ?>">--> 
                                                    <a href="<?php echo $this->createUrl('/TempCensoValidadoFaovFasp/admin'); ?>">
                                                        <i class="glyphicon glyphicon-asterisk"></i>
                                                        <span>FAOV</span>
                                                    </a>
                                                </li>   
                                            <?php } ?>
                                            <?php if (Yii::app()->user->checkAccess('action_tempcensovalidadofaovfasp_adminfasp')) { ?>
                                                <li>
                                                     <!--<a href="<?php // echo $this->createUrl('/VswCensoValidadoFaovFasp/adminfasp');   ?>">--> 
                                                    <a href="<?php echo $this->createUrl('/TempCensoValidadoFaovFasp/adminfasp'); ?>">
                                                        <i class="glyphicon glyphicon-asterisk"></i>
                                                        <span>FASP</span>
                                                    </a>
                                                </li>   
                                            <?php } ?>
                                        </ul>
                                        <ul class="sub">
                                            <?php if (Yii::app()->user->checkAccess('action_analisicredito_adminanalisiscredito')) { ?>
                                                <li>
                                                    <a href="<?php echo $this->createUrl('/analisisCredito/adminanalisiscredito'); ?>">
                                                        <i class="glyphicon glyphicon-list-alt"></i>
                                                        <span>Tabla de Amortización</span>
                                                    </a>
                                                </li>    
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>

                                <?php if (Yii::app()->user->checkAccess('controller_documentacion')) { ?>
                                    <!-- Documentacion-->
                                    <li class="sub-menu">
                                        <a href="javascript:;">
                                            <i class="glyphicon glyphicon-book"></i>
                                            <span> Documentación</span>
                                        </a>
                                        <ul class="sub">
                                            <!--<li><a href="<?php // echo $this->createUrl('/beneficiario/create');                                                                                                                                                                                                                                            ?>"><i class="glyphicon glyphicon-home"></i><span>Censo</span></a></li>-->
                                            <?php if (Yii::app()->user->checkAccess('action_documentacion_adminmultifamiliar')) { ?>
                                                <li>
                                                    <a href="<?php echo $this->createUrl('/documentacion/adminmultifamiliar'); ?>">
                                                    <!--<a href="<?php //echo $this->createUrl('/documentacion/adminmultifamiliarFiltro'); ?>">-->
                                                        <i class="glyphicon glyphicon-map-marker"></i>
                                                        <span>Unidad Multifamilar</span>
                                                    </a>
                                                </li><?php } ?>
                                        </ul>
                                        <ul class="sub">
                                            <!--<li><a href="<?php // echo $this->createUrl('/beneficiario/create');                                                                                                                                                                                                                                            ?>"><i class="glyphicon glyphicon-home"></i><span>Censo</span></a></li>-->
                                            <?php if (Yii::app()->user->checkAccess('action_documentacion_adminbeneficiario')) { ?>
                                                <li>
                                                    <a href="<?php echo $this->createUrl('/documentacion/adminbeneficiario'); ?>">
                                                        <i class="glyphicon glyphicon-user"></i>
                                                        <span>Beneficiario</span>
                                                    </a>
                                                </li><?php } ?>
                                        </ul>
                                        <ul class="sub">
                                            <!--<li><a href="<?php // echo $this->createUrl('/beneficiario/create');                                                                                                                                                                                                                                            ?>"><i class="glyphicon glyphicon-home"></i><span>Censo</span></a></li>-->
                                            <?php if (Yii::app()->user->checkAccess('action_documentacion_adminbeneficiario')) { ?>
                                                <li>
                                                    <a href="<?php echo $this->createUrl('/documentacion/adminactivacion'); ?>">
                                                        <i class="glyphicon glyphicon-asterisk"></i>
                                                        <span>Activación del Crédito</span>
                                                    </a>
                                                </li><?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                                <!-- Fin de Documentacion-->
                                <?php if (Yii::app()->user->checkAccess('action_vswBusquedaAvanzada_index')) { ?>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="glyphicon glyphicon-user"></i>
                                            <span>Área de Consulta</span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li>
                                                <a href="<?php echo $this->createUrl('/vswBusquedaAvanzada'); ?>">
                                                    <i class="glyphicon glyphicon-list-alt"></i>
                                                    <span>Reporteador</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo $this->createUrl('/reporteAnalisis/RepoExcel'); ?>">
                                                    <i class="glyphicon glyphicon-list-alt"></i>
                                                    <span>Descargar Excel</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo $this->createUrl('/estadisticas'); ?>">
                                                    <i class="glyphicon glyphicon-stats"></i>
                                                    <span>Estadisticas</span>
                                                </a>
                                            </li>
                                        </ul>    
                                    </li>
                                <?php } ?>
                                <?php if (Yii::app()->user->checkAccess('action_vswBusquedaAvanzada_index')) { ?>
                                    <li>
                                        <a href="<?php echo $this->createUrl('vswProtocolizados/admin'); ?>">
                                            <i class="glyphicon glyphicon-user"></i>
                                            <span>Protocolizados</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (Yii::app()->user->checkAccess('saren')) { ?>
                                    <li class="sub-menu">
                                        <a href="javascript:;">
                                            <i class="glyphicon glyphicon-book"></i>
                                            <span> Saren</span>
                                        </a>
                                        <ul class="sub">
                                            <!--<li><a href="<?php // echo $this->createUrl('/beneficiario/create');                                                                                                                                                                                                                                            ?>"><i class="glyphicon glyphicon-home"></i><span>Censo</span></a></li>-->
                                            <?php if (Yii::app()->user->checkAccess('action_documentacion_adminsarenMulti')) { ?>
                                                <li>
                                                    <a href="<?php echo $this->createUrl('/documentacion/adminsarenMulti'); ?>">
                                                        <i class="glyphicon glyphicon-map-marker"></i>
                                                        <span>Unidad Multifamilar</span>
                                                    </a>
                                                </li><?php } ?>
                                        </ul>
                                        <ul class="sub">
                                            <!--<li><a href="<?php // echo $this->createUrl('/beneficiario/create');                                                                                                                                                                                                                                            ?>"><i class="glyphicon glyphicon-home"></i><span>Censo</span></a></li>-->
                                            <?php if (Yii::app()->user->checkAccess('action_documentacion_adminsarenBene')) { ?>
                                                <li>
                                                    <a href="<?php echo $this->createUrl('/documentacion/adminsarenBene'); ?>">
                                                        <i class="glyphicon glyphicon-user"></i>
                                                        <span>Beneficiario</span>
                                                    </a>
                                                </li><?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                            </ul>
                            <!-- sidebar menu end-->
                        </div>
                    </div>
                </aside>
                <section id="main-content">
                    <section class="wrapper" style='margin-top: 8%;'>
                        <!--mini statistics start-->
                        <?php echo $content; ?>
                        <!--mini statistics end-->
                    </section>
                </section>

                <div id="expirado"></div>

                <!--            <footer class='container col-md-12 col-xs-12 text-center'>
                                Copyright &copy; <?php // echo date('Y');                                                                                                                                                                                                                                                                                                                                                             ?> by My Company.<br/>
                                All Rights Reserved.<br/>
                <?php // echo Yii::powered(); ?>
                            </footer>-->
                <!-- footer -->
            </section>
        </body>
    <?php } ?>
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/administrador/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/administrador/jquery.scrollTo.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/administrador/jquery.nicescroll.js"></script>
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/administrador/skycons/skycons.js"></script>
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.scrollTo/jquery.scrollTo.js"></script>
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/administrador/gauge/gauge.js"></script>
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/administrador/css3clock/js/css3clock.js"></script>
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/administrador/scripts.js"></script>
    <!--<script src="<?php // echo Yii::app()->baseUrl;  ?>/js/administrador/jquery-1.10.2.min.js"></script>-->
    <script type="text/javascript">
        $(window).load(function () {
            $(".loader").fadeOut("slow");
        })
    </script>
</html>
<?php
/*$url_redirect = CHtml::normalizeUrl(array('/site/index'));
$url_redirect = CHtml::normalizeUrl(array('/cruge/ui/accessDenied'));
$url_valida_sesion = CHtml::normalizeUrl(array('/cruge/ui/login'));
$url_destroy_session = CHtml::normalizeUrl(array('/site/logout'));
Yii::app()->getClientScript()->registerScript("core_cruge", "
    var t;

    window.onload = resetTimer;
    document.onkeypress = resetTimer;
    document.onmousemove
    function resetTimer(){
        clearTimeout(t);
        t = setTimeout(logout, 1000000) //5 minutos de inactividad, tiempo en ms
    }
    function logout(){

        alert('Su sesión a expirado.');
        var xmlhttp;

        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
        }
        xmlhttp.open('GET', '$url_destroy_session', false);
        xmlhttp.send();

        document.getElementById('expirado').innerHTML = xmlhttp.responseText;
        document.location.href = '$url_valida_sesion';
    }
  ", CClientScript::POS_LOAD);*/
?>

<script type="text/javascript">
    var t;
    window.onload = resetTimer;
    document.onkeypress = resetTimer;
    document.onmousemove
    function resetTimer() {
        clearTimeout(t);
        t = setTimeout(logout, 1000000) //5 minutos de inactividad, tiempo en ms

    }

</script>
