// JavaScript Document
function ValidaNews(form){
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
	if(!(parte1 >= 3 && parte2 >= 2 && parte3 >= 9)) {
		alert(unescape("O campo E-mail deve conter um endereço eletrônico! Exemplo: contato@clarissima.com.br"));
		form.emailNews.focus();
		return false;
	}	
}