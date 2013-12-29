function valida_nome()
{
// valida nome - valida apenas se foi preenchido

	NOME = document.cadastro.nome;
	if (NOME.value == "")
	{
		alert("O campo NOME deve ser preenchido!");
		NOME.focus();
		return false;
	}
	return true;
}

function valida_login()
{
// valida nome - valida apenas se foi preenchido
	USER = document.cadastro.login;
	if (USER.value == "")
	{
		alert("O campo LOGIN deve ser preenchido!");
		USER.focus();
		return false;
	}
	return true;
}

function valida_senha()
{
// valida nome - valida apenas se foi preenchido
	SEN = document.cadastro.senha;
	if (SEN.value == "")
	{
		alert("O campo SENHA deve ser preenchido!");
		SEN.focus();
		return false;
	}
	return true;
}

function valida_titulo()
{
// valida nome - valida apenas se foi preenchido
	TITULO = document.getElementById("titulo");
	if (TITULO.value == "")
	{
		alert("O campo Título deve ser preenchido!");
		TITULO.focus();
		return false;
	}
	return true;
}
function valida_categoria()
{
// valida nome - valida apenas se foi preenchido
	CATEGORIA = document.getElementById("categoria");
	if (CATEGORIA.value == "")
	{
		alert("O campo Categoria deve ser preenchido!");
		CATEGORIA.focus();
		return false;
	}
	return true;
}
