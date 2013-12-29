/**
 * getMultiple()
 * 
 * Retorna um array todas as oções selecionadas.
 * 
 * @author Luis Fernando Gomes
 * @copyright 01/2010
 * @version 1.0
 * 
 * Histórico:
 * 
 * Data			| Versão | Modificação
 * ------------------------------------------------------------------------------------------------
 * 				|   	 | ------------------------------------------------------------------------
 * ------------------------------------------------------------------------------------------------
 *  
 * @param object objSelect				Objeto input select que contém os options.
 * @return
 */
function getMultiple(objSelect)
{
    objSelect = typeof(objSelect) == 'object' && objSelect . tagName == 'SELECT' ? objSelect : document . createElement('SELECT');

    var arSelected = new Array();

    if (objSelect .  multiple) {
//        while (objSelect . selectedIndex != -1) {
//            arSelected . push(objSelect . options[objSelect . selectedIndex] . value);
//            objSelect . options[objSelect . selectedIndex] . selected = false;
//        } 
            //You can use the arSelected array for further processing.
    
        for (var i = 0; i < objSelect . options . length; i++) {
            if (objSelect . options[i] . selected) {
                arSelected . push(objSelect . options[i] . value);
            }
        }
    }
    
    return arSelected;
}

function setSelect(objSelect, value)
{
    objSelect = typeof(objSelect) == 'object' && objSelect . tagName == 'SELECT' ? objSelect : document . createElement('SELECT');
    value = typeof(value) != 'undefined' ? value : '';
    
    len = objSelect . options . length;
    if (len > 0) {
        for (index = 0; index < len; index++) {
            if (objSelect . options[index] . value == value || objSelect . options[index] . text == value) {
                objSelect . selectedIndex = index;
                return;
            }
        }
    }        
}

/**
 * removeAllOptions()
 * 
 * Remove todos os options de um select.
 * 
 * @author Luis Fernando Gomes
 * @copyright 01/2010
 * @version 1.0
 * 
 * Histórico:
 * 
 * Data			| Versão | Modificação
 * ------------------------------------------------------------------------------------------------
 * 				|   	 | ------------------------------------------------------------------------
 * ------------------------------------------------------------------------------------------------
 *  
 * @param object objSelect				Objeto input select que contém os options.
 * @return
 */
function removeAllOptions(objSelect)
{
    objSelect = typeof(objSelect) == 'object' && objSelect . tagName == 'SELECT' ? objSelect : document . createElement('SELECT');

	for (var i = objSelect . length - 1; i >= 0; i--) {
        objSelect . remove(i);
    }
}

/**
 * sortSelect()
 * 
 * Ordena um select pelo texto podendo ser case sensitive ou não.
 * 
 * @author Luis Fernando Gomes
 * @copyright 11/2009
 * @version 1.0
 * 
 * Histórico:
 * 
 * Data			| Versão | Modificação
 * ------------------------------------------------------------------------------------------------
 * 				|   	 | ------------------------------------------------------------------------
 * ------------------------------------------------------------------------------------------------
 * 
 * Ex:
 * ##################### xhtml #####################
 * <select name="nome" id="nome"> 
 * 		<option value="5">Luis</option>
 * 		<option value="2">Fernando</option>
 * </select>
 * 
 * <input type="button" name="sort" id="sort" value="Ordenar" />
 * 
 * ################### javascript ##################
 * objSelect = document . getElementById('nome');
 * objButton = document . getElementById('sort');
 * 
 * objButton . onclick = function()
 * {
 *		sortSelect(objSelect, true);
 * }
 *  
 * @param object objSelect				Objeto input select que contém os options.
 * @param bool	 caseSensitive			Default false.
 * @return
 */
function sortSelect(objSelect, caseSensitive)
{
    objSelect = typeof(objSelect) == 'object' && objSelect . tagName == 'SELECT' ? objSelect : document . createElement('SELECT');
	caseSensitive = typeof(caseSensitive) != 'undefined' ? caseSensitive : false;

    if (!caseSensitive) {
    	compareFunction = function(opt1, opt2)
    	{
		    // not case sensitive
		    return opt1 . text . toLowerCase() < opt2 . text . toLowerCase() ? -1 : opt1 . text . toLowerCase() > opt2 . text . toLowerCase() ? 1 : 0;
		}
    } else {
    	compareFunction = function(opt1, opt2)
    	{
		    // case sensitive
		    return opt1 . text < opt2 . text ? -1 : opt1 . text > opt2 . text ? 1 : 0;
		}
    }
    
    var options = new Array(objSelect . options . length);
    for (var i = 0; i < options . length; i++) {
    	options[i] = new Option(objSelect . options[i] . text,
								objSelect . options[i] . value,
								objSelect . options[i] . defaultSelected,
								objSelect . options[i] . selected);
    }
    options . sort(compareFunction);
    objSelect . options . length = 0;
    for (var i = 0; i < options . length; i++) {
    	objSelect . options[i] = options[i];
    }
}

/**
 * removeOptionsVazios()
 * 
 * Remove os options vazios de um select.
 * 
 * @author Luis Fernando Gomes
 * @copyright 11/2009
 * @version 1.0
 * 
 * Histórico:
 * 
 * Data			| Versão | Modificação
 * ------------------------------------------------------------------------------------------------
 * 				|   	 | ------------------------------------------------------------------------
 * ------------------------------------------------------------------------------------------------
 * 
 * Ex:
 * ##################### xhtml #####################
 * <select name="nome" id="nome"> 
 * 		<option value="5">Luis</option>
 * 		<option value="2">Fernando</option>
 * 		<option value=""></option>
 * </select>
 * 
 * <input type="button" name="remove" id="remove" value="Remover Vazios" />
 * 
 * ################### javascript ##################
 * objSelect = document . getElementById('nome');
 * objButton = document . getElementById('remove');
 * 
 * objButton . onclick = function()
 * {
 *		emoveVazios(objSelect);
 * }
 *  
 * @param object objSelect				Objeto input select que contém os options.
 * @return
 */
function removeOptionsVazios(objSelect)
{
    objSelect = typeof(objSelect) == 'object' && objSelect . tagName == 'SELECT' ? objSelect : document . createElement('SELECT');
	
	for(var i = 0; i < objSelect . options . length; i++) {
		if(objSelect . options[i] . value == '') {
			for(var j = i; j < objSelect . options . length - 1; j++) {
				objSelect . options[j] . value = objSelect . options[j + 1] . value;
				objSelect . options[j] . text = objSelect . options[j + 1] . text;
			}
			objSelect . options . length -= 1;
			removeOptionsVazios(objSelect);
			break;
   		}
	}
}


/**
 * transferir()
 * 
 * transferir de um select para outro a(s) opção(ões) selecionada(s);
 * 
 * Depende das funções removeOptionsVazios() e sortSelect();
 * @author Luis Fernando Gomes
 * @copyright 11/2009
 * @version 1.0
 * 
 * Histórico:
 * 
 * Data			| Versão | Modificação
 * ------------------------------------------------------------------------------------------------
 * 				|   	 | ------------------------------------------------------------------------
 * ------------------------------------------------------------------------------------------------
 * 
 * Ex:
 * ##################### xhtml #####################
 * <select name="nome" id="nome"> 
 * 		<option value="5">Luis</option>
 * 		<option value="2">Fernando</option>
 * </select>
 *
 * <select name="sobrenome" id="sobrenome"> 
 * 		<option value="1">Gomes</option>
 * 		<option value="3">Torres</option>
 * </select>
 *  
 * <input type="button" name="transferir" id="transferir" value="Transferir" />
 * 
 * ################### javascript ##################
 * objSelectOrigem = document . getElementById('nome');
 * objSelectDestino = document . getElementById('sobrenome');
 * objButton = document . getElementById('transferir');
 * 
 * objButton . onclick = function()
 * {
 *		transferir(objSelectOrigem, objSelectDestino);
 * }
 *  
 * @param object objSelectOrigem				Objeto input select que contém o(s) option(s).
 * @param object objSelectDestino				Objeto input select que receberá o(s) option(s).
 * @return
 */
function transferir(objSelectOrigem, objSelectDestino)
{
    objSelectOrigem = typeof(objSelectOrigem) == 'object' && objSelectOrigem . tagName == 'SELECT' ? objSelectOrigem : document . createElement('SELECT');
    objSelectDestino = typeof(objSelectDestino) == 'object' && objSelectDestino . tagName == 'SELECT' ? objSelectDestino : document . createElement('SELECT');
	
    for (var i = 0; i < objSelectOrigem . options . length; i++) {
        if ((objSelectOrigem . options[i] . selected) && (objSelectOrigem . options[i] . value != '')) {
            var temp = new Option();
            temp . value = objSelectOrigem . options[i] . value;
            temp . text = objSelectOrigem . options[i] . text;
            // adiciona
            objSelectDestino . options[objSelectDestino . options . length] = temp;
            // esvazia
            objSelectOrigem . options[i] . value = '';
            objSelectOrigem . options[i] . text = '';
        }
    }
    removeOptionsVazios(objSelectOrigem);
    sortSelect(objSelectOrigem);
    sortSelect(objSelectDestino);
}