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
    //LISTAR LAS PERSONAS BENEFICIADAS
    function mostrar_protocolizado_nacional(){ 
//        echo $this->printQryFile('../../class/sql/mostrar/mostrar_oficinas_estado__.sql', $id);die();
        return $this->exeQryFile('../../class/sql/mostrar/mostrar_protocolizado_nacional__.sql', null); 
    }

}