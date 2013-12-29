function arruma(abox) 
{
	for(var i = 0; i < abox.options.length; i++) 
	{
		if(abox.options[i].value == "")  
		{
			for(var j = i; j < abox.options.length - 1; j++)  
			{
				abox.options[j].value = abox.options[j + 1].value;
				abox.options[j].text = abox.options[j + 1].text;
			}			
			var ln = i;
			break;
   		}
	}
	
	if(ln < abox.options.length)  
	{
		abox.options.length -= 1;
		arruma(abox);
	}
/////////////////////////////////////////////////////////////////////////////////
	var tamanho = document.cadastro_selecao.destino.options.length;
	document.cadastro_selecao.tabelas.value = "";
	var temp = "";
	for(i=0;i<tamanho; i++)
	{
		//alert(tamanho)
		temp = temp +" "+ document.cadastro_selecao.destino.options[i].value;
	}
	document.cadastro_selecao.tabelas.value = temp;
	
/////////////////////////////////////////////////////////////////////////////////
}


function adiciona(origem, destino) 
{
	var i = 0; //contador
	var cont = 0;
	var ate = 0;
	ate = origem.options.length;
	for(var i=0; i<ate; i++) 
	{			
		if (origem.options[i].selected)
		{
			// adiciona
			var temp = new Option();
			temp.value = origem.options[i].value;
			temp.text = origem.options[i].text;
			destino.options[destino.options.length] = temp;
		}
	}
	
	for(var i=0; i<ate; i++) 
	{			
		if (origem.options[i].selected)
		{
			// remove
			origem.options[i].value = "";
			origem.options[i].text = "";			
		}
	}
	arruma(origem);
/////////////////////////////////////////////////////////////////////////////////
	var tamanho = document.cadastro_selecao.destino.options.length;
	var temp = "";
	document.cadastro_selecao.tabelas.value = "";
	for(i=0;i<tamanho; i++)
	{
		//alert(tamanho)
		temp = temp +" "+ document.cadastro_selecao.destino.options[i].value;
	}
	document.cadastro_selecao.tabelas.value = temp;
	
/////////////////////////////////////////////////////////////////////////////////
}

function Moveup(dbox) {
for(var i = 0; i < dbox.options.length; i++) {
if (dbox.options[i].selected && dbox.options[i] != "" && dbox.options[i] != dbox.options[0]) {
var tmpval = dbox.options[i].value;
var tmpval2 = dbox.options[i].text;
dbox.options[i].value = dbox.options[i - 1].value;
dbox.options[i].text = dbox.options[i - 1].text
dbox.options[i-1].value = tmpval;
dbox.options[i-1].text = tmpval2;
      }
   }
}

function Movedown(ebox) {
for(var i = 0; i < ebox.options.length; i++) {
if (ebox.options[i].selected && ebox.options[i] != "" && ebox.options[i+1] != ebox.options[ebox.options.length]) {
var tmpval = ebox.options[i].value;
var tmpval2 = ebox.options[i].text;
ebox.options[i].value = ebox.options[i+1].value;
ebox.options[i].text = ebox.options[i+1].text
ebox.options[i+1].value = tmpval;
ebox.options[i+1].text = tmpval2;
      }
   }
}
