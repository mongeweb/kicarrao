function returnIndexRadioButton(objRadio)
{
    var myOption = -1;
    for (var i = objRadio . length - 1; i > -1; i--) {
        if (objRadio[i] . checked) {
            myOption = i;
            break;
        }
    }
    return myOption;
}

function returnValueRadioButton(objRadio)
{
	var i = -1;
	var value = "";
	var objRadio = typeof(objRadio) != 'undefined' ? objRadio : null;
	if (objRadio != null) {
		i = returnIndexRadioButton(objRadio);
		if (i != -1) {
      		value = objRadio[i] . value;
      	}
 	}
	return value;
}

/**
 * setPropertieRadioButton()
 * 
 * @author Luis Fernando Gomes
 * @copyright 11/2009
 * @version 1.0
 * 
 * Função para adicionar uma propriedade a um Radio Button.
 * 
 * Ex:
 *  objRadioButton = objForm . nomeDoRadioButton;
 *	setPropertieRadioButton(objRadioButton, 'onclick', nomeDaFuncao);
 * 
 * Histórico:
 * 
 * Data			| Versão | Modificação
 * ------------------------------------------------------------------------------------------------
 * 				|  		 | ------------------------------------------------------------------------
 * ------------------------------------------------------------------------------------------------
 * 
 * @param object objRadio									O objeto Radio Button pego pelo nome.
 * @param string propertie									O tipo de evento. Ex: 'onclick', 'onfocus'.
 * @param function/string valuePropertie					O valoe da propriedade.
 * @return bool 				
 */
function setPropertieRadioButton(objRadio, propertie, valuePropertie)
{
    for (var i = objRadio . length - 1; i > -1; i--) {
    	eval("objRadio[i] . " + propertie + " = " + valuePropertie);
    }
}

/**
 * setEventRadioButton()
 * 
 * @author Luis Fernando Gomes
 * @copyright 01/2010
 * @version 1.0
 * 
 * Função para adicionar um evento a um Radio Button.
 * 
 * Ex:
 *  objRadioButton = objForm . nomeDoRadioButton;
 *	setEventRadioButton(objRadioButton, 'click', nomeDaFuncao); 
 * 
 * Histórico:
 * 
 * Data			| Versão | Modificação
 * ------------------------------------------------------------------------------------------------
 * 				|  		 | ------------------------------------------------------------------------
 * ------------------------------------------------------------------------------------------------
 * 
 * @param object objRadio							O objeto Radio Button pego pelo nome.
 * @param string type								O tipo de evento. Ex: 'click', 'focus'.
 * @param function/string fn						A função a ser executada.
 * @return bool 				
 */
function setEventRadioButton(objRadio, type, fn)
{
    var objRadio = typeof(objRadio) != "undefined" ? objRadio : document . createElement("INPUT");
    var type = typeof(type) != "undefined" ? type : 'click';
    var fn = typeof(fn) != "undefined" ? fn : function(){};

    var radioLength = objRadio . length;
    if (radioLength == undefined) {
        radioLength = 1;
        objRadio[0] = objRadio;
    }
    
    for (var i = radioLength - 1; i > -1; i--) {
        var obj = objRadio[i];
        if (obj . attachEvent) {
	        obj['e' + type + fn] = fn;
	        obj[type + fn] = function ()
	        {
	            obj['e' + type + fn](window . event);
	        }
	        obj . attachEvent('on' + type, obj[type + fn]);
	    } else {
	    	obj . addEventListener(type, fn, false);
	    }
    }
}

/**
 * getCheckedValue()
 * 
 * @author Luis Fernando Gomes
 * @copyright 01/2010
 * @version 1.0
 * 
 * return the value of the radio button that is checked
 * return an empty string if none are checked, or
 * there are no radio buttons
 *  
 * Histórico:
 * 
 * Data			| Versão | Modificação
 * ------------------------------------------------------------------------------------------------
 * 				|  		 | ------------------------------------------------------------------------
 * ------------------------------------------------------------------------------------------------
 * 
 * @param object radioObj							O objeto Radio Button pego pelo nome.
 * @return void 				
 */
function getCheckedValue(radioObj)
{
    if (!radioObj)
        return "";
    var radioLength = radioObj . length;
    if (radioLength == undefined)
        if (radioObj . checked)
            return radioObj . value;
        else
            return "";
    for (var i = 0; i < radioLength; i++) {
        if (radioObj[i] . checked) {
            return radioObj[i] . value;
        }
    }
    return "";
}

/**
 * setCheckedValue()
 * 
 * @author Luis Fernando Gomes
 * @copyright 01/2010
 * @version 1.0
 * 
 * set the radio button with the given value as being checked
 * do nothing if there are no radio buttons
 * if the given value does not exist, all the radio buttons
 * are reset to unchecked
 *  
 * Histórico:
 * 
 * Data			| Versão | Modificação
 * ------------------------------------------------------------------------------------------------
 * 				|  		 | ------------------------------------------------------------------------
 * ------------------------------------------------------------------------------------------------
 * 
 * @param object radioObj							O objeto Radio Button pego pelo nome.
 * @param string newValue							O novo valor a ser selecionado.
 * @return void 				
 */
function setCheckedValue(radioObj, newValue)
{
    if (!radioObj)
        return;
    var radioLength = radioObj . length;
    if (radioLength == undefined) {
        radioObj . checked = (radioObj . value == newValue . toString());
        return;
    }
    for (var i = 0; i < radioLength; i++) {
        radioObj[i] . checked = false;
        if (radioObj[i] . value == newValue . toString()) {
            radioObj[i] . checked = true;
        }
    }
}