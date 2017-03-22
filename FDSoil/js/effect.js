function input_focus_blur(){
    $("input").focus(function(){
        $(this).css("background-color","#cccccc");
    });
    $("input").blur(function(){
        $(this).css("background-color","#ffffff");
    });          
}

function toggle(idObj, effectType, time){//effectType can be:'blind','bounce','clip','drop','explode','fold','highlight','puff','pulsate','scale','shake','size' ó 'slide'
    if (effectType=='slow' || IsNumeric(effectType))//The function 'IsNumeric' are in FDSoil/js/numero.js
        $( "#"+idObj ).toggle(effectType);     
    else{
        var options = {};// most effect types need no options passed by default
        if (effectType=='scale')
            options = { percent: 0 };        
        else if (effectType=='size')
            options = { to: { width: 200, height: 60 }};        
        $( "#"+idObj ).toggle( effectType, options, time); 
    }
}

function show(idObj, effectType, time){//effectType can be:'blind','bounce','clip','drop','explode','fold','highlight','puff','pulsate','scale','shake','size' ó 'slide'
    if (effectType=='slow' || IsNumeric(effectType))//The function 'IsNumeric' are in FDSoil/js/numero.js
        $( "#"+idObj ).show(effectType);     
    else{
        var options = {};// most effect types need no options passed by default
        if (effectType=='scale')
            options = { percent: 0 };        
        else if (effectType=='size')
            options = { to: { width: 200, height: 60 }};        
        $( "#"+idObj ).show( effectType, options, time); 
    }
}

function hide(idObj, effectType, time){//effectType can be:'blind','bounce','clip','drop','explode','fold','highlight','puff','pulsate','scale','shake','size' ó 'slide'
    if (effectType=='slow' || IsNumeric(effectType))//The function 'IsNumeric' are in FDSoil/js/numero.js
        $( "#"+idObj ).hide(effectType);     
    else{
        var options = {};// most effect types need no options passed by default
        if (effectType=='scale')
            options = { percent: 0 };        
        else if (effectType=='size')
            options = { to: { width: 200, height: 60 }};        
        $( "#"+idObj ).hide( effectType, options, time); 
    }
}








