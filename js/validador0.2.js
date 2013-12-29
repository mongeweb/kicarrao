function ValidaContato(form) {
	if(form.nome.value == "" || form.nome.value == "Nome") {
		alert("O campo Nome é de preenchimento obrigatório!");
		form.nome.focus();
		return false;
	}
	if(form.email.value == "" || form.email.value == "E-mail") {
		alert("O campo E-mail é de preenchimento obrigatório!");
		form.email.focus();
		return false;
	}
    var parte1 = form.email.value.indexOf("@");	
	var parte2 = form.email.value.indexOf(".");
	var parte3 = form.email.value.length;
	if(!(parte1 >= 3 && parte2 >= 2 && parte3 >= 9))
    {
		alert(unescape("O campo E-mail deve conter um endereço eletrônico! Exemplo: contato@clarissima.com.br"));
		form.email.focus();
		return false;
	}
	if(form.telefone.value.length != 14) {
		alert("O campo Telefone é de preenchimento obrigatório!");
		form.telefone.focus();
		return false;
	}
	if(form.celular.value.length != 14) {
		alert("O campo Celular é de preenchimento obrigatório!");
		form.telefone.focus();
		return false;
	}
	
	if(form.assunto.value == "" || form.assunto.value == "Assunto") {
		alert("O campo Assunto é de preenchimento obrigatório!");
		form.assunto.focus();
		return false;
	}
	if(form.mensagem.value == "" || form.mensagem.value == "Mensagem") {
		alert("O campo Mensagem é de preenchimento obrigatório!");
		form.mensagem.focus();
		return false;
	}
	
}

function ValidaNews(form)
{
	if(form.nomeNews.value == "" || form.nomeNews.value == "Nome") {
		alert("O campo Nome é de preenchimento obrigatório!");
		form.nomeNews.focus();
		return false;
	}
	if(form.emailNews.value == "" || form.emailNews.value == "E-mail") {
		alert("O campo E-mail é de preenchimento obrigatório!");
		form.emailNews.focus();
		return false;
	}	
	var parte1 = form.emailNews.value.indexOf("@");	
	var parte2 = form.emailNews.value.indexOf(".");
	var parte3 = form.emailNews.value.length;
	if(!(parte1 >= 3 && parte2 >= 2 && parte3 >= 9))
	{
		alert(unescape("O campo E-mail deve conter um endereço eletrônico! Exemplo: contato@coivara.com.br"));
		form.emailNews.focus();
		return false;
	}	
}

function Valida3(form){
	if(form.nome.value == "" || form.nome.value == "Seu Nome") {
		alert("O campo Nome é de preenchimento obrigatório!");
		form.nome.focus();
		return false;
	}
	if(form.crmv.value == "" || form.crmv.value == "CRMV") {
		alert("O campo CRMV é de preenchimento obrigatório!");
		form.crmv.focus();
		return false;
	}
	if(form.especialidade.value == "" || form.especialidade.value == "Especialidade") {
		alert("O campo Especialidade é de preenchimento obrigatório!");
		form.especialidade.focus();
		return false;
	}
	if(form.endereco.value == "" || form.endereco.value == "Endereço") {
		alert("O campo Endereço é de preenchimento obrigatório!");
		form.endereco.focus();
		return false;
	}	
	if(form.cidade.value == "" || form.cidade.value == "Cidade") {
		alert("O campo Cidade é de preenchimento obrigatório!");
		form.cidade.focus();
		return false;
	}
	if(form.estado.value == "" || form.estado.value == "Estado") {
		alert("O campo Estado é de preenchimento obrigatório!");
		form.estado.focus();
		return false;
	}
	if(form.telefone.value.length != 14) {
		alert("O campo Telefone é de preenchimento obrigatório!");
		form.telefone.focus();
		return false;
	}
	if(form.email.value == "" || form.email.value == "E-mail") {
		alert("O campo E-mail é de preenchimento obrigatório!");
		form.email.focus();
		return false;
	}	
	var parte1 = form.email.value.indexOf("@");	
	var parte2 = form.email.value.indexOf(".");
	var parte3 = form.email.value.length;
	if(!(parte1 >= 3 && parte2 >= 2 && parte3 >= 9)) {
		alert(unescape("O campo " + form.email.name + " deve conter um endereço eletrônico! Exemplo: contato@vidaanimal.com.br"));
		form.email.focus();
		return false;
	}	
}
function Valida4(form) {
	
	if(form.nome.value == "" || form.nome.value == "Nome Completo:") {
		alert("O campo Nome é de preenchimento obrigatório!");
		form.nome.focus();
		return false;
	}	
	if(form.datanasc.value.length != 10 || form.datanasc.value == "Data de Nascimento:") {
		alert("A Data de Nascimento é de preenchimento obrigatório!");
		form.datanasc.focus();
		return false;
	}	
	if(form.cpf.value == "CPF:" || form.cpf.value == "") {
		alert("O campo CPF é de preenchimento obrigatório!");
		form.cpf.focus();
		return false;
	}	
	if(form.endereco.value == "Endereço:" || form.endereco.value == "") {
		alert("O campo Endereço é de preenchimento obrigatório!");
		form.endereco.focus();
		return false;
	}	
	if(form.bairro.value == "Bairro:" || form.bairro.value == "") {
		alert("O campo Bairro é de preenchimento obrigatório!");
		form.bairro.focus();
		return false;
	}
	if(form.cep.value == "CEP:" || form.cep.value == "") {
		alert("O campo CEP é de preenchimento obrigatório!");
		form.cep.focus();
		return false;
	}
	if(form.cidade.value == "Cidade:" || form.cidade.value == "") {
		alert("O campo Cidade é de preenchimento obrigatório!");
		form.cidade.focus();
		return false;
	}	
	if(form.estado.value == "Estado:" || form.estado.value == "") {
		alert("O campo Estado é de preenchimento obrigatório!");
		form.estado.focus();
		return false;
	}
	/*if(form.telres.value.length != 14) {
		alert("O campo Telefone Residencial é de preenchimento obrigatório!");
		form.telres.focus();
		return false;
	}*/
	if(form.telcom.value.length != 14) {
		alert("O campo Telefone Comercial é de preenchimento obrigatório!");
		form.telcom.focus();
		return false;
	}
	var parte1 = form.email.value.indexOf("@");	
	var parte2 = form.email.value.indexOf(".");
	var parte3 = form.email.value.length;
	if(!(parte1 >= 3 && parte2 >= 2 && parte3 >= 9)) {
		alert(unescape("O campo " + form.email.name + " deve conter um endereço eletrônico! Exemplo: contato@vidaanimal.com.br"));
		form.email.focus();
		return false;
	}	
	if(form.profissao.value == "Profissão:" || form.profissao.value == "") {
		alert("O campo Profissão é de preenchimento obrigatório!");
		form.profissao.focus();
		return false;
	}
	if(form.local.value == "Local em que pretende abrir a Franquia:" || form.local.value == "") {
		alert("O campo Local é de preenchimento obrigatório!");
		form.local.focus();
		return false;
	}
	if(form.estadofranq.value == "" || form.estadofranq.value == "Estado:") {
		alert("O campo Estado da franquia é de preenchimento obrigatório!");
		form.estadofranq.focus();
		return false;
	}
	if(form.cidadefranq.value == "Cidade:" || form.cidadefranq.value == "") {
		alert("O campo Cidade da franquia é de preenchimento obrigatório!");
		form.cidadefranq.focus();
		return false;
	}
	if(form.bairrofranq.value == "Bairro:" || form.bairrofranq.value == "") {
		alert("O campo Bairro da franquia é de preenchimento obrigatório!");
		form.bairrofranq.focus();
		return false;
	}

}
function validaN(form){
		if(form.email.value == "") {
		alert("O campo de E-mail é de preenchimento obrigatório!");
		form.email.focus();
		return false;
	}
	var parte1 = form.email.value.indexOf("@");	
	var parte2 = form.email.value.indexOf(".");
	var parte3 = form.email.value.length;
	if(!(parte1 >= 3 && parte2 >= 2 && parte3 >= 9)) {
		alert(unescape("O campo E-mail deve conter um endereço eletrônico! Exemplo: contato@vidaanimal.com.br"));
		form.email.focus();
		return false;
	}
}

function validaVet(form){
	if(form.registro.value == "" || form.registro.value == "Registro Profissional:") {
		alert("O campo Registro Profissional é de preenchimento obrigatório!");
		form.registro.focus();
		return false;
	}
	if(form.usuario.value == "Usuário:" || form.usuario.value == "") {
		alert("O campo Usuário é de preenchimento obrigatório!");
		form.usuario.focus();
		return false;
	}
	if(form.senha.value == "Senha:" || form.senha.value == "") {
		alert("O campo Senha é de preenchimento obrigatório!");
		form.senha.focus();
		return false;
	}
}