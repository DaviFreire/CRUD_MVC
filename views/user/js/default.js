
function setAction(action){
	$('.form-check-input').prop('checked', false);
	$('#alertgroup').show();
	$('#submitbutton').hide();
	$('#contador').val(0);
	document.getElementById('formAdd').action = 'user/'+action
}

function setUser(id){
	document.getElementById('formAdd').action = 'user/edit/'+id
	
	$.ajax({
	  type:'GET',
	  url: 'user/usersinglelist',
	  data: {id:id},
	  success: function(data) {
	  	data = JSON.parse(data);
	   	$('#nome').val(data['nome']);
	   	$('#sobrenome').val(data['sobrenome']);

	   	var strG = data['group_ids'];
	   	grupos = strG.split(',');
	   	$('.form-check-input').prop('checked', false);
	   	for(var i=0; i<grupos.length; i++) {
		    $('#inlineCheckbox'+(grupos[i])).prop('checked', true);
		}
		$('#contador').val(grupos.length);
		if(grupos.length >= 2){
			$('#alertgroup').hide();
			$('#submitbutton').show();
		}else{
			$('#alertgroup').show();
			$('#submitbutton').hide();
		}
	  }, 
	  fail: function(jqXHR, textStatus, errorThrown) {
	   console.log("" + errorThrown + textStatus); 
	  }
	});
}

function countGroup(check){
	var atual = parseInt($('#contador').val());
	if(check.checked == true){
		atual = atual+1;
		$('#contador').val(atual);
	}else{
		atual = atual-1;
		$('#contador').val(atual);
	}
	console.log(atual);
	if(atual >= 2){
		$('#alertgroup').hide();
		$('#submitbutton').show();
	}else{
		$('#alertgroup').show();
		$('#submitbutton').hide();
	}
}

function validarForm(){
	var alerta = '';

	if($('#nome').val().length > 50){
    	alerta = "Nome não pode ser maior que 50 caracteres\n";
    }

    if($('#nome').val().length < 3){
    	alerta = alerta + "Nome não pode ser menor que 3 caracteres\n";
    }

    if($('#sobrenome').val().length > 50){
    	alerta = alerta + "Sobrenome não pode ser maior que 100 caracteres\n";
    }

    if($('#sobrenome').val().length < 3){
    	alerta = alerta + "Sobrenome não pode ser menor que 3 caracteres\n";
    }

    var checkedGroup = [];
    $('.form-check-input:checkbox:checked').each(function(){
	    checkedGroup.push($(this).val());
	});

	if(checkedGroup.length<2){
		alerta = alerta + "Selecione pelo menos dois grupos\n";
	}

	if(alerta == ''){
		return true;
	}else{
		alert(alerta);
		return false;
	}
}

