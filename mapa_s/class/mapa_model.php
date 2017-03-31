<?php
include_once('../../../FDSoil/class/menu.model.php');

class mapa extends menu {
    
    //LISTAR LAS OFICINAS POR ESTADO
    function mostrar_oficina_estado($id){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id); 
    }
    
    //LISTAR LAS DESARROLLO POR ESTADO
    function mostrar_desarrollo_estado($id){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_desarrollo_estado__.sql', $id); 
    }
    
    //LISTAR LAS DESARROLLO POR PARROQUIA
    function mostrar_desarrollo_parroquia($id){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_desarrollo_parroquia__.sql', $id); 
    }
    
    //LISTAR LAS UNIDADES FAMILIARES
    function mostrar_unidades_familiares($id){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_unidades_familiares__.sql', $id); 
    }
    
        
    //LISTAR LAS FAMILIAS BENEFICIADAS
    function mostrar_familias_beneficiadas($id){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_familias_beneficiadas__.sql', $id); 
    }
    
    //LISTAR LAS PERSONAS BENEFICIADAS
    function mostrar_personas_beneficiadas($id){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_personas_beneficiadas__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_personas_beneficiadas__.sql', $id); 
    }
    //LISTAR LAS PERSONAS BENEFICIADAS
    function mostrar_documentos_protocolizado($id){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_documentos_protocolizado__.sql', $id); 
    }
    //LISTAR EL TOTAL DE DOCUMENTOS PROTOCOLIZADOS A NIVEL NACIONAL
    function mostrar_protocolizado_nacional(){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_protocolizado_nacional__.sql', null); 
    }
    //LISTAR EL TOTAL DE LOS DESARROLLOS HABITACIONALES A NIVEL NACIONAL
    function mostrar_desarrollo_nacional(){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_desarrollo_nacional__.sql', null); 
    }
    //LISTAR EL TOTAL DE LAS UNIDADES HABITACIONALES A NIVEL NACIONAL
    function mostrar_unidad_familiar_nacional(){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_unidad_familiar_nacional__.sql', null); 
    }
    //LISTAR EL TOTAL DE LAS UNIDADES HABITACIONALES A NIVEL NACIONAL
    function mostrar_desarrollo_torres($id){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_desarrollo_torres__.sql', $id); 
    }
    //LISTAR EL TOTAL DE LAS UNIDADES HABITACIONALES A NIVEL NACIONAL
    function mostrar_viviendas_censadas($id){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_viviendas_censadas__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_viviendas_censadas__.sql', $id); 
    }
    
    //LISTAR LAS MUNICIPIO EN EL SELECT
    function mostrar_select_municipio($id){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_select_municipio__.sql', $id); 
    }
    
    function mostrar_select_parroquia($id){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_select_parroquia__.sql', $id); 
    }
    
    function mostrar_conteo_desarrollo_nacional($id){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/conteo_desarrollo_nacional__.sql', $id); 
    }
     //LISTAR Detalle de cada Desarrollo
    function mostrar_desarrollo_resumen($id){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_desarrollo_resumen_estado__.sql', $id); 
    }
    

}