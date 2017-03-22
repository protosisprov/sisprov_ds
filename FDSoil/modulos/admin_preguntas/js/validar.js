function inicio(strArrayMenu) {
    menu(strArrayMenu);
    var obj=new app();
    id_sistema(obj.name);
}
function toogle_pr(a,b,c)
{
 // window.location.reload();
  document.getElementById(b).style.display=a;
  document.getElementById(c).style.display=a;
}
function toogle_cierre_pr(a,b,c)
{
//  window.location.reload();
  document.getElementById(b).style.display=a;
  document.getElementById(c).style.display=a;
}