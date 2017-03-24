function goToPag(pag){
    (isInt(pag))?window.history.go(-parseInt(pag)):relocate(pag,null);            
}
