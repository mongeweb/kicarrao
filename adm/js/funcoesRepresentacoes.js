function funcoesRepresentacoes()
{
	objNumArquivos = document . getElementById('numArquivos');
	objAumenta = document . getElementById('aumenta');
	objDiminui = document . getElementById('diminui');
	
	Contador = new Contador(1, 1, 999, objNumArquivos, objAumenta, objDiminui);
	Contador . init();
	
//	alert('the text value of: ' + objAumenta.innerHTML);// - the text value of x
//    alert('the name of: ' + objAumenta.nodeName);// - the name of x
//    alert('the value of: ' + objAumenta.value.nodeValue);// - the value of x
//    alert('the parent of: ' + objAumenta.parentNode);// - the parent node of x
//    alert('the child nodes of: ' + objAumenta.childNodes);// - the child nodes of x
//    alert('the attributes of: ' + objAumenta.attributes[0].nodeName);// - the attributes nodes of x
//    alert('the attributes of: ' + objAumenta.attributes[0].nodeValue);// - the attributes nodes of x
}

/**
 * adicionarGrupoDeInputs()
 * 
 * Função para adicionar linhas em 
 * uma tabela especificada no parâmetro 
 * tabela cada uma com duas colunas.
 * Uma contendo o label passado no 
 * parâmetro label e outra um input 
 * do tipo passado no parâmetro type 
 * com o nome passado no parâmetro name.
 *
 * É possível adicionar eoutro input para legenda passando o parâmetro legenda:
 * legenda == 1 =>	Legenda ao lado na mesma linha
 * legenda == 2 =>	Legenda em nova linha
 * 
 * Dependências:
 * 1 - limparLinhas(tabela)
 * 
 */
function adicionarGrupoDeInputs(tabela, numeroDeElementos, label, type, name, legenda, labelLegenda, typeLegenda, nameLegenda)
{
	numeroDeElementos = typeof(numeroDeElementos) != 'undefined' ? numeroDeElementos : 1;
	label = typeof(label) != 'undefined' ? label : 'Default Value';
	type = typeof(type) != 'undefined' ? type : 'text';
	name = typeof(name) != 'undefined' ? name : 'Default Value';
	legenda = typeof(legenda) != 'undefined' ? legenda : false;
	
	labelLegenda = typeof(labelLegenda) != 'undefined' ? labelLegenda : 'Default Value';
	typeLegenda = typeof(typeLegenda) != 'undefined' ? typeLegenda : 'text';
	nameLegenda = typeof(nameLegenda) != 'undefined' ? nameLegenda : 'Default Value';

    limparLinhas(tabela);
    
    /** Propriedades do input **/
    size = 35;
    sizeLegenda = 50;
    
    /** Propriedades das células **/
    cellLeftAlign = 'right';
    cellLeftWidth = '100';
    
    cellRightAlign = 'left';
    cellRightWidth = '100';
    
    var numLinhas = tabela . rows . length;
    var contador = numLinhas / 2;

    for (var n = 1; n <= numeroDeElementos; n++) {
        contador++;

        var linha = tabela . insertRow(-1);
        var newcell = linha . insertCell(-1);
        
        var txt = document . createTextNode(label + ' ' + contador);
        newcell . appendChild(txt);
        newcell . align = cellLeftAlign;
        newcell . width = cellLeftWidth;

        var newcell = linha . insertCell(-1);
        
        var objInput = document . createElement("input");
        objInput . setAttribute('type', type);
        objInput . setAttribute('name', name + 's[]');
        objInput . setAttribute('id', name + contador);
        objInput . setAttribute('size', size);
        
        newcell . align = cellRightAlign;
        newcell . appendChild(objInput);
        
        if (legenda) {
        	switch (legenda){ 
				case 1: /** Legenda ao lado na mesma linha **/
					var txt = document . createTextNode(' | (' + labelLegenda + ') ');
					
					newcell . appendChild(txt);
					
					var objInput2 = document . createElement("input");
			        objInput2 . setAttribute('type', typeLegenda);
			        objInput2 . setAttribute('name', nameLegenda + 's[]');
			        objInput2 . setAttribute('id', nameLegenda + contador);
			        objInput2 . setAttribute('size', sizeLegenda);
			        
			        newcell . appendChild(objInput2);
				break;
				
				case 2: /** Legenda em nova linha **/
					var linha = tabela . insertRow(-1);
			        var newcell = linha . insertCell(-1);
			        
			        var objInput2 = document . createElement("input");
			        objInput2 . setAttribute('type', typeLegenda);
			        objInput2 . setAttribute('name', nameLegenda + 's[]');
			        objInput2 . setAttribute('id', nameLegenda + contador);
			        objInput2 . setAttribute('size', sizeLegenda);
			        
			        var txt = document . createTextNode(labelLegenda + ' ' + contador);
	        		
					newcell . align = cellLeftAlign;
			        newcell . width = cellLeftWidth;
			        
			        newcell . appendChild(txt);
										
			        var newcell = linha . insertCell(-1);
			        
			        newcell . align = cellRightAlign;
			        
			        newcell . appendChild(objInput2);
				break;
			}
        }
    }
}

/**
 * limparLinhas()
 * 
 * Função para remover linhas em uma  
 * tabela especificada no parâmetro tabela.
 * Função auxiliar a adicionarGrupoDeInputs().
 * 
 */
function limparLinhas(tabela)
{
		var numLinhas = tabela . rows . length;
		
		if (numLinhas > 0) {
			for (var i=1; i<=numLinhas; i++) {
				tabela . deleteRow(-1);
			}
		}
}

/**
 * Contador()
 * 
 * Muda o número de um input text conforme os botões enviados nos parâmetros.
 * 
 * @param integer valorInicial			Valor inicial exibido pelo input.
 * @param integer valorMinimo			Valor mínimo exibido pelo input.
 * @param integer valorMaximo			Valor máximo exibido pelo input.
 * @param object objInputExibeNumero	Objeto input text que exibe o numero.
 * @param object objBotaoAumenta		Objeto button que aumenta.
 * @param object objBotaoDiminui		Objeto button que diminui.
 * @return
 */
function Contador(valorInicial, valorMinimo, valorMaximo, objInputExibeNumero, objBotaoAumenta, objBotaoDiminui)
{
	this . contador = typeof(valorInicial) != 'undefined' ? valorInicial : 0;
    this . valorMinimo = typeof(valorMinimo) != 'undefined' ? valorMinimo : 0;
    this . valorMaximo = typeof(valorMaximo) != 'undefined' ? valorMaximo : 999;

    this . init = function ()
    {
        Contador . atualiza();
        objBotaoAumenta . onclick = Contador . aumenta;
        objBotaoDiminui . onclick = Contador . diminui;
		adicionarGrupoDeInputs(document . getElementById("tabelaArquivos"), this . contador, 'Arquivo', 'file', 'arquivo', 1, 'Legenda', 'text', 'tituloArquivo');
    }

    this . atualiza = function ()
    {
        objInputExibeNumero . value = Contador . contador;
        adicionarGrupoDeInputs(document . getElementById("tabelaArquivos"), this . contador, 'Arquivo', 'file', 'arquivo', 1, 'Legenda', 'text', 'tituloArquivo');
    }

    this . aumenta = function ()
    {
        if (!Contador . testeValorMaximo()) {
            Contador . contador++;
            Contador . atualiza();
        }
    }

    this . diminui = function ()
    {
        if (!Contador . testeValorMinimo()) {
            Contador . contador--;
            Contador . atualiza();
        }
    }

    this . testeValorMinimo = function ()
    {
        if (this . contador <= this . valorMinimo) {
            return true;
        } else {
            return false;
        }
    }

    this . testeValorMaximo = function ()
    {
        if (this . contador >= this . valorMaximo) {
            return true;
        } else {
            return false;
        }
    }
}