$(function () {
	$('#id_clave1').keypad({showOn: 'both',randomiseAlphabetic:true, randomiseNumeric: true, randomiseOther: true, layout: $.keypad.qwertyLayout}); 
	$('.randomise').click(function() { 
					    $('#id_clave1').keypad('option', { 
        					randomiseAlphabetic: $('#alphabetic').is(':checked'), 
					        randomiseNumeric: $('#numeric').is(':checked'), 
					        randomiseOther: $('#other').is(':checked'), 
					        randomiseAll: $('#all').is(':checked')}); 
});
});

$(function () {
	$('#id_clave2').keypad({showOn: 'both',randomiseAlphabetic:true, randomiseNumeric: true, randomiseOther: true, layout: $.keypad.qwertyLayout}); 
	$('.randomise').click(function() { 
					    $('#id_clave2').keypad('option', { 
        					randomiseAlphabetic: $('#alphabetic').is(':checked'), 
					        randomiseNumeric: $('#numeric').is(':checked'), 
					        randomiseOther: $('#other').is(':checked'), 
					        randomiseAll: $('#all').is(':checked')}); 
});
});

$(function () {
	$('#id_clave3').keypad({showOn: 'both',randomiseAlphabetic:true, randomiseNumeric: true, randomiseOther: true, layout: $.keypad.qwertyLayout}); 
	$('.randomise').click(function() { 
					    $('#id_clave3').keypad('option', { 
        					randomiseAlphabetic: $('#alphabetic').is(':checked'), 
					        randomiseNumeric: $('#numeric').is(':checked'), 
					        randomiseOther: $('#other').is(':checked'), 
					        randomiseAll: $('#all').is(':checked')}); 
});
});
