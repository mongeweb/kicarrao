$(document).ready(function()
{
    objValidador = new xform($('form#cadastro').get(0));
					//adicionar(campo, tipoValidacao, branco, confirmacao, objConfirmacao)

    //objValidador . adicionar($('input#titulo').get(0));

    $('input#numCampos').val(Contador . init(2, 1, 999))
        .keyup(function()
        {
            if(window.mg_dalay) {
                window.clearTimeout(window.mg_dalay);
            }

            window.mg_dalay = window.setTimeout(function()
            {
                var num = $('input#numCampos').val();
                if (num >= Contador . valorMinimo && num <= Contador . valorMaximo) {
                    Contador . contador = num;
                } else {
                    $('input#numCampos').val(Contador . contador);
                }
                adicionarInputs($('div#groupDivs').get(0), Contador . contador, 'Campo', 'select', 'campo');
                $.post('clientes/clientes_importarCsv.php',
                       {act: 'mostrar'},
                        function(valor)
                        {
                            $('select[name="campos[]"]').html(valor);
                        }
                );
            }, 700);
        });
    adicionarInputs($('div#groupDivs').get(0), Contador . contador, 'Campo', 'select', 'campo');
    $.post('clientes/clientes_importarCsv.php',
           {act: 'mostrar'},
            function(valor)
            {
                $('select[name="campos[]"]').html(valor);
            }
    );

    $('#maisCampos').click(function()
    {
		var num = Contador . aumenta();
        $('input#numCampos').val(num);
        adicionarInputs($('div#groupDivs').get(0), num, 'Campo', 'select', 'campo');
        $.post('clientes/clientes_importarCsv.php',
               {act: 'mostrar'},
                function(valor)
                {
                    $('select[name="campos[]"]').html(valor);
                }
        );
	});

    $('#menosCampos').click(function()
    {
		var num = Contador . diminui();
        $('input#numCampos').val(num);
        adicionarInputs($('div#groupDivs').get(0), num, 'Campo', 'select', 'campo');
        $.post('clientes/clientes_importarCsv.php',
               {act: 'mostrar'},
                function(valor)
                {
                    $('select[name="campos[]"]').html(valor);
                }
        );
	});

});

/**
 * adicionarInputs()
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
function adicionarInputs(objParent, numeroDeElementos, textoLabel, type, name, legenda, textoLabelLegenda, typeLegenda, nameLegenda)
{
    objParent = typeof(objParent) != 'undefined' ? objParent : document . createElement('DIV');
	numeroDeElementos = typeof(numeroDeElementos) != 'undefined' ? numeroDeElementos : 1;
	textoLabel = typeof(textoLabel) != 'undefined' ? textoLabel : 'Default Value';
	type = typeof(type) != 'undefined' ? type : 'text';
	name = typeof(name) != 'undefined' ? name : 'Default Value';
	legenda = typeof(legenda) != 'undefined' ? legenda : false;
	
	textoLabelLegenda = typeof(textoLabelLegenda) != 'undefined' ? textoLabelLegenda : 'Default Value';
	typeLegenda = typeof(typeLegenda) != 'undefined' ? typeLegenda : 'text';
	nameLegenda = typeof(nameLegenda) != 'undefined' ? nameLegenda : 'Default Value';

    limparObj(objParent);
    
    /** Propriedades do input 
    size = 35;
    sizeLegenda = 50; **/
    classInput = '';
    classLegenda = '';
    
    /** Propriedades das células 
    cellLeftAlign = 'right';
    cellLeftWidth = '100'; **/
    classLabel = '';
    
    /*cellRightAlign = 'left';
    cellRightWidth = '100';*/ 
    
//    var numLinhas = tabela . rows . length;
//    var contador = numLinhas / 2;
    var contador = 0;

    for (var n = 1; n <= numeroDeElementos; n++) {
        contador++;

//        var linha = tabela . insertRow(-1);
//        var newcell = linha . insertCell(-1);
        var objLinha = document . createElement('DIV');
        
        var objLabel = document . createElement('LABEL');
        if (classLabel) {
            objLabel . style . className = classLabel;
        }

        var txt = document . createTextNode(textoLabel + ' ' + contador);
        objLabel . appendChild(txt);
//        newcell . align = cellLeftAlign;
//        newcell . width = cellLeftWidth;
        
        objLinha . appendChild(objLabel);

//        var newcell = linha . insertCell(-1);
        
        switch (type) {
            case 'select':
                var objInput = document . createElement('SELECT');
                break;
            case 'text':
            case 'password':
            case 'radio':
            case 'checkbox':
            case 'file':
            case 'radio':
            default :
                var objInput = document . createElement('INPUT');
                objInput . setAttribute('type', type);
        }

        objInput . setAttribute('name', name + 's[]');
        objInput . setAttribute('id', name + contador);
//        objInput . setAttribute('size', size);
        if (classInput) {
            objInput . style . className = classInput;
        }
        
//        newcell . align = cellRightAlign;
//        newcell . appendChild(objInput);
        objLinha . appendChild(objInput);
        
        objParent . appendChild(objLinha);
        
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
//					var linha = tabela . insertRow(-1);
//			        var newcell = linha . insertCell(-1);
                    var objLinha = document . createElement('DIV');
                    
                    var objLabel = document . createElement('LABEL');
                    if (classLabel) {
                        objLabel . style . className = classLabel;
                    }
                    
                    var txt = document . createTextNode(textoLabelLegenda + ' ' + contador);
                    objLabel . appendChild(txt);
                    
                    objLinha . appendChild(objLabel);

			        var objInput2 = document . createElement('INPUT');
			        objInput2 . setAttribute('type', typeLegenda);
			        objInput2 . setAttribute('name', nameLegenda + 's[]');
			        objInput2 . setAttribute('id', nameLegenda + contador);
                    if (classInput) {
                        objInput2 . style . className = classInput;
                    }

                    objLinha . appendChild(objInput2);

                    objParent . appendChild(objLinha);
				break;
			}
        }
    }
}

/**
 * limparObj()
 * 
 * Função para remover todos os  
 * objetos filho do objeto especificado no
 * parâmetro obj.
 * Função auxiliar a adicionarInputs().
 * 
 */
function limparObj(obj)
{
    obj = typeof(obj) != 'undefined' && obj != '' ? obj : document . createElement('DIV');

    while (obj . lastChild) {
        obj . removeChild(obj . lastChild);
    }
}

/**
 * Contador()
 * 
 * Retorna o número do contador.
 * 
 * @param integer valorInicial			Valor inicial.
 * @param integer valorMinimo			Valor minimo.
 * @param integer valorMaximo			Valor máximo.
 * @return
 */
Contador = 
{
    contador : 0
    , valorMinimo : 0
    , valorMaximo : 999
    
	, init : function (valorInicial, valorMinimo, valorMaximo)
    {
        this . contador = typeof(valorInicial) != 'undefined' ? valorInicial : this . contador;
        this . valorMinimo = typeof(valorMinimo) != 'undefined' ? valorMinimo : this . valorMinimo;
        this . valorMaximo = typeof(valorMaximo) != 'undefined' ? valorMaximo : this . valorMaximo;

        return this . atualiza();
    }

    , atualiza : function ()
    {
        return this . contador;
    }

    , aumenta : function ()
    {
        if (!this . testeValorMaximo()) {
            this . contador++;
        }
        return this . atualiza();
    }

    , diminui : function ()
    {
        if (!this . testeValorMinimo()) {
            this . contador--;
        }
        return this . atualiza();
    }

    , testeValorMinimo : function ()
    {
        if (this . contador <= this . valorMinimo) {
            return true;
        } else {
            return false;
        }
    }

    , testeValorMaximo : function ()
    {
        if (this . contador >= this . valorMaximo) {
            return true;
        } else {
            return false;
        }
    }
}