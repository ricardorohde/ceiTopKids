jQuery.validator.addMethod("cpf", function(value, element) {
   value = jQuery.trim(value);
	
	value = value.replace('.','');
	value = value.replace('.','');
	cpf = value.replace('-','');
	while(cpf.length < 11) cpf = "0"+ cpf;
	var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
	var a = [];
	var b = new Number;
	var c = 11;
	for (i=0; i<11; i++){
		a[i] = cpf.charAt(i);
		if (i < 9) b += (a[i] * --c);
	}
	if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
	b = 0;
	c = 11;
	for (y=0; y<10; y++) b += (a[y] * c--);
	if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
	
	var retorno = true;
	if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;
	
	return this.optional(element) || retorno;

}, "Informe um CPF válido."); // Mensagem padrão 

jQuery.validator.addMethod("dateBR", function(value, element) {
	 //contando chars
	if(value.length!=10) return false;
	// verificando data
	var data 		= value;
	var dia 		= data.substr(0,2);
	var barra1		= data.substr(2,1);
	var mes 		= data.substr(3,2);
	var barra2		= data.substr(5,1);
	var ano 		= data.substr(6,4);
	if(data.length!=10||barra1!="/"||barra2!="/"||isNaN(dia)||isNaN(mes)||isNaN(ano)||dia>31||mes>12)return false;
	if((mes==4||mes==6||mes==9||mes==11) && dia==31)return false;
	if(mes==2  &&  (dia>29||(dia==29 && ano%4!=0)))return false;
	if(ano < 1900)return false;
	return true;
}, "Informe uma data válida");  // Mensagem padrão 

jQuery.validator.addMethod("dateTimeBR", function(value, element) {
	 //contando chars
	if(value.length!=16) return false;
	 // dividindo data e hora
	if(value.substr(10,1)!=' ') return false; // verificando se há espaço
	var arrOpcoes = value.split(' ');
	if(arrOpcoes.length!=2) return false; // verificando a divisão de data e hora
	// verificando data
	var data 		= arrOpcoes[0];
	var dia 		= data.substr(0,2);
	var barra1		= data.substr(2,1);
	var mes 		= data.substr(3,2);
	var barra2		= data.substr(5,1);
	var ano 		= data.substr(6,4);
	if(data.length!=10||barra1!="/"||barra2!="/"||isNaN(dia)||isNaN(mes)||isNaN(ano)||dia>31||mes>12)return false;
	if ((mes==4||mes==6||mes==9||mes==11) && dia==31)return false;
	if (mes==2  &&  (dia>29||(dia==29 && ano%4!=0)))return false;
	// verificando hora
	var horario 	= arrOpcoes[1];
	var	hora 		= horario.substr(0,2);
	var doispontos 	= horario.substr(2,1);
	var minuto 		= horario.substr(3,2);
	if(horario.length!=5||isNaN(hora)||isNaN(minuto)||hora>23||minuto>59||doispontos!=":")return false;
	return true;
}, "Informe uma data e uma hora válida");	


jQuery.validator.addMethod("cnpj", function(cnpj, element) {
   cnpj = jQuery.trim(cnpj);
	
	// DEIXA APENAS OS NÚMEROS
   cnpj = cnpj.replace('/','');
   cnpj = cnpj.replace('.','');
   cnpj = cnpj.replace('.','');
   cnpj = cnpj.replace('-','');

   var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
   digitos_iguais = 1;

   if (cnpj.length < 14 && cnpj.length < 15){
      return this.optional(element) || false;
   }
   for (i = 0; i < cnpj.length - 1; i++){
      if (cnpj.charAt(i) != cnpj.charAt(i + 1)){
         digitos_iguais = 0;
         break;
      }
   }

   if (!digitos_iguais){
      tamanho = cnpj.length - 2
      numeros = cnpj.substring(0,tamanho);
      digitos = cnpj.substring(tamanho);
      soma = 0;
      pos = tamanho - 7;

      for (i = tamanho; i >= 1; i--){
         soma += numeros.charAt(tamanho - i) * pos--;
         if (pos < 2){
            pos = 9;
         }
      }
      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
      if (resultado != digitos.charAt(0)){
         return this.optional(element) || false;
      }
      tamanho = tamanho + 1;
      numeros = cnpj.substring(0,tamanho);
      soma = 0;
      pos = tamanho - 7;
      for (i = tamanho; i >= 1; i--){
         soma += numeros.charAt(tamanho - i) * pos--;
         if (pos < 2){
            pos = 9;
         }
      }
      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
      if (resultado != digitos.charAt(1)){
         return this.optional(element) || false;
      }
      return this.optional(element) || true;
   }else{
      return this.optional(element) || false;
   }
}, "Informe um CNPJ válido."); // Mensagem padrão 

jQuery.validator.addMethod("notEqual", function(value, element, param) {
   return value == $(param).val() ? false : true;
}, "Este valor não pode ser igual"); // Mensagem padrão 

jQuery.validator.addMethod("diferenteDe", function(value, element, strCompara) {
   return value == strCompara ? false : true;
}, "Este valor não foi alterado"); // Mensagem padrão 

jQuery.validator.addMethod("maiorQue", function(value, element, param) {
   return value <= $(param).val() ? false : true;
}, "Este valor precisa ser maior"); // Mensagem padrão 

jQuery.validator.addMethod("menorQue", function(value, element, param) {
   return value >= $(param).val() ? false : true;
}, "Este valor precisa ser menor"); // Mensagem padrão 
/////////////////////// cadastro de clientes //////////////////////////////
$(document).ready(function(){
	$("#gravacliente").validate({
		 rules:{
			 id_grupo:{required:true},
			 nome:{required:true, minlength: 5},
			 cnpj: {cnpj: false},
			 cpf: {cpf: true},
			 rg: {required:true},
			 endereco: {required:true},
			 numero: {required:true},
			 bairro: {required:true},
			 cidade: {required:true},
			 uf: {required:true},
			 telefone: {required:true},
			 cep: {required:true},
			 email:{required:true, email:true, remote: "php/checaemail.php"},
			 },
		messages:{
			id_grupo:{required: "<br/> Selecione um plano de pagamento"},
			 nome:{required: "<br/>O campo nome deve ser preenchido", minlength:"<br/> Seu nome deve ter no mínimo 5 caracteres"},
			 cnpj: { cnpj: '<br/>CNPJ inválido'},
			 cpf: {cpf: '<br/>Informe um CPF válido'},
			 rg: {required:'<br/>informe um RG'},
			 endereco: {required:'<br/>informe um Endereço.'},
			 numero: {required:'<br/>informe o numero da residência.'},
			 bairro: {required:'<br/>informe o bairro.'},
			 cidade: {required:'<br/>informe a cidade.'},
			 uf: {required:'<br/>informe a sigla do estado.'},
			 telefone: {required:'<br/>informe o telefone.'},
			 cep: {required:'<br/>informe o cep.'},
			 email:{required: "<br/>Digite seu E-mail", email: "<br/>E-mail inválido", remote: "<br/>Este e-mail já foi cadastrado!"},
			},
		
	});
});

    $(function(){
      
      $('table > tbody > tr:odd').addClass('odd');
      
      $('table > tbody > tr').hover(function(){
        $(this).toggleClass('hover');
      });
      
      $('#marcar-todos').click(function(){
        $('table > tbody > tr > td > :checkbox')
          .attr('checked', $(this).is(':checked'))
          .trigger('change');
      });
      
      $('table > tbody > tr > td > :checkbox').bind('click change', function(){
        var tr = $(this).parent().parent();
        if($(this).is(':checked')) $(tr).addClass('selected');
        else $(tr).removeClass('selected');
      });
      
      $('form').submit(function(e){ e.preventDefault(); });
      
      $('#pesquisar').keydown(function(){
        var encontrou = false;
        var termo = $(this).val().toLowerCase();
        $('table > tbody > tr').each(function(){
          $(this).find('td').each(function(){
            if($(this).text().toLowerCase().indexOf(termo) > -1) encontrou = true;
          });
          if(!encontrou) $(this).hide();
          else $(this).show();
          encontrou = false;
        });
      });
      
      $("table") 
        .tablesorter({
          dateFormat: 'uk',
          headers: {
            0: {
              sorter: false
            },
            5: {
              sorter: false
            }
          }
        }) 
        .tablesorterPager({container: $("#pager")})
        .bind('sortEnd', function(){
          $('table > tbody > tr').removeClass('odd');
          $('table > tbody > tr:odd').addClass('odd');
        });
      
    });


///////////////////////// validacao campo cpf/cnpj //////////////////.
function aplica_mascara_cpfcnpj(campo,tammax,teclapres) {
	var tecla = teclapres.keyCode;

	if ((tecla < 48 || tecla > 57) && (tecla < 96 || tecla > 105) && tecla != 46 && tecla != 8) {
		return false;
	}

	var vr = campo.value;
	vr = vr.replace( /\//g, "" );
	vr = vr.replace( /-/g, "" );
	vr = vr.replace( /\./g, "" );
	var tam = vr.length;

	if ( tam <= 2 ) {
		campo.value = vr;
	}
	if ( (tam > 2) && (tam <= 5) ) {
		campo.value = vr.substr( 0, tam - 2 ) + '-' + vr.substr( tam - 2, tam );
	}
	if ( (tam >= 6) && (tam <= 8) ) {
		campo.value = vr.substr( 0, tam - 5 ) + '.' + vr.substr( tam - 5, 3 ) + '-' + vr.substr( tam - 2, tam );
	}
	if ( (tam >= 9) && (tam <= 11) ) {
		campo.value = vr.substr( 0, tam - 8 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + '-' + vr.substr( tam - 2, tam );
	}
	if ( (tam == 12) ) {
		campo.value = vr.substr( tam - 12, 3 ) + '.' + vr.substr( tam - 9, 3 ) + '/' + vr.substr( tam - 6, 4 ) + '-' + vr.substr( tam - 2, tam );
	}
	if ( (tam > 12) && (tam <= 14) ) {
		campo.value = vr.substr( 0, tam - 12 ) + '.' + vr.substr( tam - 12, 3 ) + '.' + vr.substr( tam - 9, 3 ) + '/' + vr.substr( tam - 6, 4 ) + '-' + vr.substr( tam - 2, tam );
	}
}

//Verifica se CPF ou CGC e encaminha para a devida função, no caso do cpf/cgc estar digitado sem mascara
function verifica_cpf_cnpj(cpf_cnpj) {
	if (cpf_cnpj.length == 11) {
		return(verifica_cpf(cpf_cnpj));
	} else if (cpf_cnpj.length == 14) {
		return(verifica_cnpj(cpf_cnpj));
	} else { 
		return false;
	}
	return true;
}

//Verifica se o número de CPF informado é válido
function verifica_cpf(sequencia) {
	if ( Procura_Str(1,sequencia,'00000000000,11111111111,22222222222,33333333333,44444444444,55555555555,66666666666,77777777777,88888888888,99999999999,00000000191,19100000000') > 0 ) {
		return false;
	}
	seq = sequencia;
	soma = 0;
	multiplicador = 2;
	for (f = seq.length - 3;f >= 0;f--) {
		soma += seq.substring(f,f + 1) * multiplicador;
		multiplicador++;
	}
	resto = soma % 11;
	if (resto == 1 || resto == 0) {
		digito = 0;
	} else {
		digito = 11 - resto;
	}
	if (digito != seq.substring(seq.length - 2,seq.length - 1)) {
		return false;
	}
	soma = 0;
	multiplicador = 2;
	for (f = seq.length - 2;f >= 0;f--) {
		soma += seq.substring(f,f + 1) * multiplicador;
		multiplicador++;
	}
	resto = soma % 11;
	if (resto == 1 || resto == 0) {
		digito = 0;
	} else {
		digito = 11 - resto;
	}
	if (digito != seq.substring(seq.length - 1,seq.length)) {
		return false;
	}
	return true;
}

//Verifica se o número de CNPJ informado é válido
function verifica_cnpj(sequencia) {
	seq = sequencia;
	soma = 0;
	multiplicador = 2;
	for (f = seq.length - 3;f >= 0;f-- ) {
		soma += seq.substring(f,f + 1) * multiplicador;
		if ( multiplicador < 9 ) {
			multiplicador++;
		} else {
			multiplicador = 2;
		}
	}
	resto = soma % 11;
	if (resto == 1 || resto == 0) {
		digito = 0;
	} else {
		digito = 11 - resto;
	}
	if (digito != seq.substring(seq.length - 2,seq.length - 1)) {
		return false;
	}

	soma = 0;
	multiplicador = 2;
	for (f = seq.length - 2;f >= 0;f--) {
		soma += seq.substring(f,f + 1) * multiplicador;
		if (multiplicador < 9) {
			multiplicador++;
		} else {
			multiplicador = 2;
		}
	}
	resto = soma % 11;
	if (resto == 1 || resto == 0) {
		digito = 0;
	} else {
		digito = 11 - resto;
	}
	if (digito != seq.substring(seq.length - 1,seq.length)) {
		return false;
	}
	return true;
}

//Procura uma string dentro de outra string
function Procura_Str(param0,param1,param2) {
	for (a = param0 - 1;a < param1.length;a++) {
		for (b = 1;b < param1.length;b++) {
			if (param2 == param1.substring(b - 1,b + param2.length - 1)) {
				return a;
			}
		}
	}
	return 0;
}

//Retira a máscara do valor de cpf_cnpj
function retira_mascara(cpf_cnpj) {
	return cpf_cnpj.replace(/\./g,'').replace(/-/g,'').replace(/\//g,'')	
}

