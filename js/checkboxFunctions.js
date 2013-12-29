// ##################### 1 #####################

/**
 * CheckAll()
 * 
 * Seleciona todos os checkbox do formulário.
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
 * <input type="checkbox" name="selAll" id="selAll" /><span id="checkar">Marcar todos</span>
 * <input type="checkbox" name="locais[]" value="" />
 * <input type="checkbox" name="locais[]" value="" />
 * <input type="checkbox" name="locais[]" value="" />
 * 
 * ################### javascript ##################
 * objForm = document . getElementById('cadastro');
 * objSelAll = document . getElementById('selAll');
 * objSpanCheckar = document . getElementById('checkar');
 * 
 * objSelAll . onclick = function()
 * {
 *		CheckAll(objForm, objSelAll, objSpanCheckar);
 * }
 *  
 * @param object objForm				Objeto formulário que contém os checkbox.
 * @param object objSelect				Objeto input checkbox que define a seleção dos outros checkbox.
 * @param object objSpan				Objeto span que exibe o texto "Marcar todos" ou "Desmarcar todos".
 * @return
 */
function CheckAll(objForm, objCheck, objSpan)
{
	objForm = typeof(objForm) != "undefined" ? objForm : null;
	objSelAll = typeof(objCheck) != "undefined" ? objCheck : null;
	objSpanCheckar = typeof(objSpan) != "undefined" ? objSpan : null;

	for (var i = 0; i < objForm . elements . length; i++) {
        var x = objForm . elements[i];
        if(x . type == "checkbox" && (x . id != objSelAll . id)) {
			x . checked = objSelAll . checked;
      	}
    }

	if (!objSelAll . checked) {
 		objSpanCheckar . innerHTML = "Marcar todos";
 	} else {
 		objSpanCheckar . innerHTML = "Desmarcar todos";
 	}
}

// ##################### 2 #####################

function selecionarTodosCheckboxPorId(qtd)
{
    for (i = 0; i < qtd; i++) {
        if (!document . getElementById(i) . checked) {
            document . getElementById(i) . checked = 1;
        }
    }
}

function deselecionarTodosCheckboxPorId(qtd)
{
    for (i = 0; i < qtd; i++) {
        if (document . getElementById(i) . checked) {
            document . getElementById(i) . checked = 0;
        }
    }
}

// ##################### 3 #####################

function selecionarTodosCheckbox()
{
    for (i = 0; i < document . cadastro . elements . length; i++) {
        if (document . cadastro . elements[i] . type == "checkbox") {
            document . cadastro . elements[i] . checked = 1;
        }
    }
}

function deselecionarTodosCheckbox()
{
    for (i = 0; i < document . cadastro . elements . length; i++) {
        if (document . cadastro . elements[i] . type == "checkbox") {
            document . cadastro . elements[i] . checked = 0;
        }
    }
}