function inicio(strArrayMenu,val) {
    var obj=new app();
    id_sistema(obj.name);
    menu(strArrayMenu);
   if(val===0){
        document.getElementById('datos_table').style.display='none';
        document.getElementById('respuesta').style.display='block';
   }else{
        document.getElementById('datos_table').style.display='block';
        document.getElementById('respuesta').style.display='none';
   }
}

function toogle(a,b,c)
{
 // window.location.reload();
  document.getElementById(b).style.display=a;
  document.getElementById(c).style.display=a;
}

function toogle_acciones(a,b,c,d)
{ 
  send_mostrar_unidad(d);   // FUNCION QUE MUESTRA LOS DATOS DE LA UNIDAD
  document.getElementById(b).style.display=a;
  document.getElementById(c).style.display=a;
  
}
//******************************************************************

function toogle_cierre(a,b,c)
{
  window.location.reload();
  document.getElementById(b).style.display=a;
  document.getElementById(c).style.display=a;
}
function toogle_formula(a,b,c,d,e)
{
  document.getElementById(b).style.display=a;
  document.getElementById(c).style.display=a;
  document.getElementById('id_indicador').value=d;
  document.getElementById('tipo_indicador').value=e;
}
function toogle_cierre(a,b,c)
{
  document.getElementById(b).style.display=a;
  document.getElementById(c).style.display=a;
}
function random_string(size){
    var str = "";
    for (var i = 0; i < size; i++){
        str += random_character();
    }
     var info = document.getElementById('idcodigo').value = str;
//     alert(info);
}
function random_character() {
    var chars = "0123456789abcdefghijklmnopqurstuvwxyzABCDEFGHIJKLMNOPQURSTUVWXYZ";
    return chars.substr( Math.floor(Math.random() * 62), 1);
}

function addIt(id) {
    var valor=document.getElementById(id).value;
    var cant_variable=document.getElementById('icant_variable').value;
    if(id==='variable'){
        valor=document.getElementById(id).value+cant_variable;
       
        document.getElementById('capa_var').style.display="none";
    }
    if(id==='id_operar'){
        document.getElementById('orden_var').value= document.getElementById('orden_var').value+valor+";";
    }

    valor=valor.replace(",","."); 
    var formula=document.getElementById('id_formula_generar').value;
    document.getElementById('id_formula_generar').value = formula+valor;
}

function probar_variable(){
    //--------Obtencion de datos basicos-------------------------------
     var valor=document.getElementById('idvaresta').value; //------------------- Valor de prueba-----------------
        for(i=0;i<valor.length;i++){ 
	    switch (valor[i]){ 
	      case ".":
	          valor=valor.replace(".","");
	      break;
	      case ",":
	          valor=valor.replace(",","."); 
	      break;
	   }
	}

     var formula = document.getElementById('id_formula_generar').value.replace("V1",valor); // Formula con valor sustituido del valor de prueba----------------
     var orden_operadores=document.getElementById('orden_var').value.split(";"); //---Contiene el orden de los operadores
     //---------Cambiar la formula sustituyendo los operadores por ";" -----------------------
     var cadena=formula;
     var i;
        for(i=0;i<=formula.length;i++){ 
            switch (formula[i]){ 
               case "+":
                   cadena=cadena.replace("+",";");
               break;
               case "-":
                   cadena=cadena.replace("-",";"); 
               break;
               case "*":
                   cadena=cadena.replace("*",";"); 
               break;
               case "/":
                  cadena=cadena.replace("/",";");
               break;
               case "%":
                  cadena=cadena.replace("%",";");
               break;
               case "(": 
                  cadena=cadena.replace("(",";");
               break;
               case ")":
                  cadena=cadena.replace(")",";");
               break;
           }
        }
        var valores=cadena.split(";"); //cadenas con los numero a operar
        var cantidad_operadores=orden_operadores.length-1;
        var cantidad_valores=valores.length;
        var y=0;
        //---- Iniciamos la operacion para la aplicacion de la formula ---------
         var resultado=valores[0];
         
         for(i=1;i<=cantidad_operadores;i++){  
              switch (orden_operadores[y]){ 
               case "+":
                   resultado=parseFloat(resultado)+parseFloat(valores[i]);
               break;
               case "-":
                   resultado=parseFloat(resultado)-parseFloat(valores[i]);
               break;
               case "*":
                   resultado=parseFloat(resultado)*parseFloat(valores[i]);
               break;
               case "/":
                  resultado=parseFloat(resultado)/parseFloat(valores[i]);
               break;
           }
           y++;
         }
        document.getElementById('resultado').style.display="block";
        document.getElementById('guardar').style.display="block";
        document.getElementById('resultado').innerHTML="Resultado al aplicar la formula: <b> "+resultado+" <b>";
}

function resetear_var(){
    document.getElementById('capa_var').style.display="";
    document.getElementById('id_formula_generar').value='';
    document.getElementById('orde\n\
n_var').value='';
    document.getElementById('cant_variable').value='1';
}

function consultar_valores(a,b){
    var id=document.getElementById('id_indicador_valores').value;
    send_bandas_indicadores(id);
}
function actiInpu(){
    
    document.getElementById('idzverde').readOnly = false;
    document.getElementById('idzvhast').readOnly = false;
    document.getElementById('idzadesd').readOnly = false;
    document.getElementById('idzahast').readOnly = false;
    document.getElementById('idzrdesd').readOnly = false;
    document.getElementById('idzrhast').readOnly = false;

}
