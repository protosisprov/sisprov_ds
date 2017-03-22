function createAjax(){
    var objetoAjax=false;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        objetoAjax = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (!objetoAjax && typeof XMLHttpRequest!='undefined') 
        objetoAjax = new XMLHttpRequest();    
    
return objetoAjax;
}
function send_ajax(metodo, paginaMasArgumento, funcionResponse, valores, capaContenedora) {
    var ajax = createAjax();
    ajax.open(metodo, paginaMasArgumento, true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 1 && capaContenedora != null)
            document.getElementById(capaContenedora).innerHTML = "Cargando...<IMG src='../../../FDSoil/images/loading.gif' border='0'>";
        else if (ajax.readyState == 4) {
            if (capaContenedora != null)
                document.getElementById(capaContenedora).innerHTML = "";
            if (ajax.status == 200 && ajax.responseText != '')
                eval(funcionResponse + '("' + ajax.responseText.replace(/^\s*|\s*$/g, "", "") + '");');
            else
                eval(funcionResponse + '("")');
            if (ajax.status == 404)
                alert("La direccion no existe");
            else
                document.getElementById('ajaxer').innerHTML = ajax.status;
        }
    }
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send(valores);
    return;
}