var selecionado;
function seleciona(nro,anterior){
	var celula= document.getElementById('ordem'+nro);
//	tabela = celula.parentElement.parentElement.parentElement;
//	alert(celula);
	$i=0;
	if(anterior!=null){
		var celula2= document.getElementById('ordem'+anterior);
		celula2.className='conteudo';		
	}
	selecionado=nro;
	celula.className='conteudodestaque';
	return true;
}

function move(nro,pos){
	if ((nro+pos>0) && (nro+pos<=total)){
		var celula= document.getElementById('ordem'+nro);
		var celula2= document.getElementById('ordem'+(nro + pos));
		var temp;
		temp = celula.innerHTML;
		celula.innerHTML=celula2.innerHTML;
		celula2.innerHTML=temp;

		var lol= document.getElementById('c'+nro);
		var lol2= document.getElementById('c'+(nro + pos));
		var loltemp;
		loltemp = lol.value;
		lol.value=lol2.value;
		lol2.value=loltemp;
		
		seleciona(nro + pos,nro);
	}
}