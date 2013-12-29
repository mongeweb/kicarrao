//VALIDAÇÃO DE CLIENTES
function valida_tipopessoa()
{
// valida nome - valida apenas se foi preenchido
	var x = document.getElementsByTagName('input');
        for (var i=0; i<x.length; i++)
        {
        	if(x[i].id == "tipoPessoa")
        	{
        		if(x[i].checked == true){
        		var ok = true;
        		break;
        		}
        		else{
        		var ok = false;
				}
        	}
        }
	
	if (ok == false)
	{
		alert("O campo Tipo de Pessoa deve ser preenchido!");
		document.cadastro.tipoPessoa.focus();
		return false;
	}
	return true;
}

function valida_documento()
{
// valida nome - valida apenas se foi preenchido
	DOCUMENTO = document.getElementById("documento");
	if (DOCUMENTO.value == "")
	{
		alert("O campo Documento deve ser preenchido!");
		DOCUMENTO.focus();
		return false;
	}
	return true;
}

function valida_nome()
{
// valida nome - valida apenas se foi preenchido
	NOME = document.getElementById("nome");
	if (NOME.value == "")
	{
		alert("O campo Nome deve ser preenchido!");
		NOME.focus();
		return false;
	}
	return true;
}

function valida_datanasc()
{
// valida nome - valida apenas se foi preenchido
	DATANASC = document.getElementById("dataNascimento");
	if (DATANASC.value == "")
	{
		alert("O campo Data de Nascimento deve ser preenchido!");
		DATANASC.focus();
		return false;
	}
	return true;
}

function valida_endereco()
{
// valida nome - valida apenas se foi preenchido
	ENDERECO = document.getElementById("endereco");
	if (ENDERECO.value == "")
	{
		alert("O campo Endereço deve ser preenchido!");
		ENDERECO.focus();
		return false;
	}
	return true;
}

function valida_numero()
{
// valida nome - valida apenas se foi preenchido
	NUMERO = document.getElementById("numero");
	if (NUMERO.value == "")
	{
		alert("O campo Número deve ser preenchido!");
		NUMERO.focus();
		return false;
	}
	return true;
}

function valida_cep()
{
// valida nome - valida apenas se foi preenchido
	CEP = document.getElementById("cep");
	if (CEP.value == "")
	{
		alert("O campo CEP deve ser preenchido!");
		CEP.focus();
		return false;
	}
	return true;
}

function valida_bairro()
{
// valida nome - valida apenas se foi preenchido
	BAIRRO = document.getElementById("bairro");
	if (BAIRRO.value == "")
	{
		alert("O campo Bairro deve ser preenchido!");
		BAIRRO.focus();
		return false;
	}
	return true;
}

function valida_uf()
{
// valida nome - valida apenas se foi preenchido
	UF = document.getElementById("uf");
	if (UF.value == "")
	{
		alert("O campo UF deve ser selecionado!");
		UF.focus();
		return false;
	}
	return true;
}

function valida_cidade()
{
// valida nome - valida apenas se foi preenchido
	CIDADE = document.getElementById("cidade");
	if (CIDADE.value == "")
	{
		alert("O campo Cidade deve ser selecionado!");
		CIDADE.focus();
		return false;
	}
	return true;
}


function valida_email()
{
	EMAIL = document.getElementById("email");
	if (EMAIL.value == " ") return true;
	erro = new String;
	parte1 = EMAIL.value.indexOf("@");
	if (parte1<1) 
	{	
		alert ("E-mail inválido!");
		EMAIL.value="";
		EMAIL.focus();
		return false;
	}
	parte2 = EMAIL.value.indexOf(".",parte1);
	//alert(parte2);
	if (parte2<1) 
	{	
		alert ("E-mail inválido!");
		EMAIL.value="";
		EMAIL.focus();
		return false;
	}
	parte3 = EMAIL.value.length;
	if (!(parte1 >= 3 && parte2 >= 5 && parte3 >= 8))
	{
		alert ("E-mail inválido!");
		EMAIL.value="";
		EMAIL.focus();
		return false;
	}
	return true;
}

function valida_telres()
{
// valida nome - valida apenas se foi preenchido
	RESIDENCIAL = document.getElementById("telRes");
	if (RESIDENCIAL.value == "")
	{
		alert("O campo Telefone Residencial deve ser preenchido!");
		RESIDENCIAL.focus();
		return false;
	}
	return true;
}

function valida_telcel()
{
// valida nome - valida apenas se foi preenchido
	CELULAR = document.getElementById("telCel");
	if (CELULAR.value == "")
	{
		alert("O campo Telefone Celular deve ser preenchido!");
		CELULAR.focus();
		return false;
	}
	return true;
}

function valida_situacao()
{
// valida nome - valida apenas se foi preenchido
	SITUACAO = document.getElementById("situacao");
	if (SITUACAO.value == "")
	{
		alert("O campo Situação deve ser preenchido!");
		SITUACAO.focus();
		return false;
	}
	return true;
}