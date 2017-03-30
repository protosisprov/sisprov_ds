//function inicio(strArrayMenu) {
//    menu(strArrayMenu);
//    var obj=new app();
//    id_sistema(obj.name);
//    alert(obj.name);
//}
function goToPag(pag){
    (isInt(pag))?window.history.go(-parseInt(pag)):relocate(pag,null);            
}
