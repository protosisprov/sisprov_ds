function valid_date_range(fecha_previa,fecha_posterior){
    var fecha_prev = new Date(change_date_format_js(fecha_previa,'-'));
    var fecha_post = new Date(change_date_format_js(fecha_posterior,'-'));
    if((fecha_post.getTime()-fecha_prev.getTime()) >=0){
        return true;
    }else{
        return false;
    }
}
function date_range(fecha_previa,fecha_posterior){
    var fecha_prev = new Date(change_date_format_js(fecha_previa,'-'));
    var fecha_post = new Date(change_date_format_js(fecha_posterior,'-'));
    return (fecha_post.getTime()-fecha_prev.getTime())/86400000;
}

function change_date_format_js(fecha,separador) {
    var f = new Array();
    var caracter = ''
    var new_date ='';
    if (separador =='-') {
        caracter = /[/]/;
        if (caracter.test(fecha)) { //si esta en formato DD/MM/AAAA se cambia a AAAA-MM-DD
            f = fecha.split("/");
            new_date =f[2] + separador + f[1] + separador +f[0];
        }
    }else if (separador =='/') {
        caracter = /[-]/;
        if (caracter.test(fecha)) { //si esta en formato AAAA-MM-DD se cambia a DD/MM/AAAA
            f = fecha.split("/");
            new_date = f[2] + separador + f[1] + separador +f[0];
        }
    }else{
        return false;
    }
    return new_date;
}
