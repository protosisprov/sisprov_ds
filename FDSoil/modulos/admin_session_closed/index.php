<?php

    header ('Content-type: text/html; charset=utf-8');
    	include_once('../../packs/xtpl/xtemplate.class.php');
	$xtpl=new XTemplate('view.html');
        $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
        echo "PASO->".$_GET['carpeta'];
        $xtpl->parse('main');
	$xtpl->out('main');	
?>