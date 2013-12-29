/**
 * Concatenates the values of a variable into an easily readable string
 *
 * ex: document . write('<pre>' + print_r(obj) + '</pre>');
 * alert(print_r(obj))
 *
 * by Matt Hackett [scriptnode.com]
 * @param {Object} x The variable to debug
 * @param {Number} max The maximum number of recursions allowed (keep low, around 5 for HTML elements to prevent errors) [default: 10]
 * @param {String} sep The separator to use between [default: a single space ' ']
 * @param {Number} l The current level deep (amount of recursion). Do not use this parameter: it's for the function's own use
 */
function print_r(x, max, sep, l)
{
    l = l || 0;
    max = max || 10;
    sep = sep || ' ';
    if (l > max) {
        return "[WARNING: Too much recursion]\n";
    }
    var
		i,
		r = '',
		t = typeof x,
		tab = '';

    if (x === null) {
        r += "(null)\n";
    } else if (/object/i . test(t)) {
            l++;
            for (i = 0; i < l; i++) {
                tab += sep;
            }
            if (x && x . length) {
                t = 'array';
            }
            r += '(' + t + ") :\n";
            for (i in x) {
                try {
                    r += tab + '[' + i + '] : ' + print_r(x[i], max, sep, (l + 1));
                }
                catch (e) {
                    return '[ERROR: ' + e + "]\n";
                }
            }
        } else {
            if (t == 'string') {
                if (x == '') {
                    x = '(empty)';
                }
            }
            r += '(' + t + ') ' + x + "\n";
        }
        return r;
}

/**
 * Event
 *
 * @package BancoDeClasses
 * @author Luis Fernando Gomes
 * @copyright 01/2010
 * @version 1.0
 * @access public
 *
 * Histórico:
 *
 * Data			| Versão | Modificação
 * ------------------------------------------------------------------------------------------------
 * 				|   	 | ------------------------------------------------------------------------
 * ------------------------------------------------------------------------------------------------
 *
 */
var Event = {
	/**
	 * add()
	 *
	 * Adiciona um evento a um objeto.
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
	 * Ex:
	 * obj = document . getElementById('id');
	 *
	 * Event . add(obj, 'click', nomeDaFuncao);
	 * Event . add(obj, 'keypress', function() { //faça qualquer coisa });
	 *
	 * @param object obj								O objeto que receberá o evento.
	 * @param string type								O tipo de evento. Ex: 'click', 'keypress', 'focus'.
	 * @param function/string fn						A função a ser executada.
	 * @return
	 */
	add : function (obj, type, fn)
	{
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
	},
	/**
	 * remove()
	 *
	 * Remove um evento de um objeto.
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
	 * Ex:
	 * obj = document . getElementById('id');
	 *
	 * Event . remove(obj, 'click', nomeDaFuncao)
	 *
	 * @param object obj								O objeto que receberá o evento.
	 * @param string type								O tipo de evento. Ex: 'click', 'focus'.
	 * @param function/string fn						A função a ser executada.
	 * @return
	 */
	remove : function (obj, type, fn)
	{
	    if (obj . detachEvent) {
	        obj . detachEvent('on' + type, obj[type + fn]);
	        obj[type + fn] = null;
	    } else {
	    	obj . removeEventListener(type, fn, false);
	    }
	}
}

function insertAfter(newElement, targetElement)
{
    var parent = targetElement . parentNode;
    if (parent . lastChild == targetElement) {
        parent . appendChild(newElement);
    } else {
        parent . insertBefore(newElement, targetElement . nextSibling);
    }
}

//#####################################
//mensagens de erro customizáveis
//#####################################

mensagens = new Array();
mensagens['branco'] = 'O campo %s \u00E9 de preenchimento obrigat\u00F3rio!';
mensagens['cep'] = 'CEP inv\u00E1lido!';
mensagens['cnpj'] = 'CNPJ inv\u00E1lido!';
mensagens['cpf'] = 'CPF inv\u00E1lido!';
mensagens['data'] = 'Data inv\u00E1lida!';
mensagens['email'] = 'Email inv\u00E1lido!';
mensagens['telefone'] = 'Telefone inv\u00E1lido!';
mensagens['hora'] = 'Hora inv\u00E1lida!';
mensagens['minLen'] = 'Campo %s deve conter no m\u00EDnimo %d caracteres';
mensagens['maxLen'] = 'Campo %s deve conter no m\u00E1ximo %d caracteres';
mensagens['nome'] = 'Nome inv\u00E1lido!';
mensagens['rg'] = 'RG inv\u00E1lido!';
mensagens['url'] = 'URL inv\u00E1lida!';
mensagens['valor'] = 'Valor inv\u00E1lido!';
mensagens['confirmacao'] = 'Campos de confirma\u00E7\u00E3o diferentes';
mensagens['selecione'] = 'Selecione uma op\u00E7\u00E3o no campo %s';

//#####################################
//constantes
//#####################################

if (document . all) {
    sender = 'event . srcElement';
} else {
    sender = 'e . target';
}

//#####################################
//objeto xform
//#####################################
function xform(obj, settings)
{
    this . resetProps = function()
    {
        this . addErro = function() {};
        this . adicionar = function() {};
        this . campos = new Array();
        this . erros = new Array();
        this . exibirObrigatorios = true;// exibir os span's com asterisco
        this . form = {};
        this . formId = '';
        this . notifyErros = function() {};
        this . remover = function() {};
        this . resetErros = function() {};
        this . status = true;
        this . settings = {}
        this . total = 0;
        this . valida = function() {};
        this . version = '1.4';
    }
    this . resetProps();

    this . settings = $.extend(
                        {
                            showVersion: false
                            ,notifyBar: false
                            ,exibirObrigatorios: false
                            ,callback: function() {}
                            ,callbackTrue: function() {}
                            ,callbackFalse: function() {}
                        }
                        ,settings || {});

    this . resetErros = function()
    {
        this . erros = new Array();
    }
    this . addErro = function(erro, reset)
    {
        var erro = typeof(erro) != 'undefined' || erro != '' ? erro : 'erro';
        var reset = typeof(reset) != 'undefined' || reset != '' ? reset : false;

        if (reset) {
            this . erros = new Array();
        }
        this.erros.push(erro);
    }
    this . notifyErros = function()
    {
        var html = this.settings.showVersion ? '<p>Validador '+this.version+'</p>' : '';
        html += '<ul class="erro"><li>'+this.erros.join('</li><li>')+'</li></ul>';

        var text = this.settings.showVersion ? 'Validador '+this.version+"\n" : '';
        text += this.erros.join("\n");

        if (this.settings.notifyBar) {
            if (!$.notifyBar) {
                alert('Falta jquery.notifyBar.js');
                alert(text);
            }
            $.notifyBar({ cls: 'error', close: true, delay: 10000, html: html});            
        } else {
            alert(text);
        }
    }
    this . resetErros();

    if ($(obj).size() > 0) {
        this . form = $(obj).get(0);
        this . formId = $(obj).attr('id');
    } else {
        this . addErro('Formu\u00E1rio inv\u00E1lido!');
        this . status = false;
    }
    setTabIndex($(obj).get(0));

    this.exibirObrigatorios = this.settings.exibirObrigatorios; // exibir os span's com asterisco

    //metodo para adicionar inputs
	this . adicionar = function(campo, tipoValidacao, branco, confirmacao, objConfirmacao)
	{
        if ($(campo).size() <= 0) {
            this . addErro('Campo inv\u00E1lido!('+campo+')');
            this . notifyErros();
            return false;
        }
        //alert($(campo).attr('id') +' '+ $(campo).size());
        if ($(campo).size() > 1) {
            campo = $(campo).get();
        } else {
            campo = $(campo).get(0);
        }

		// seta valor default
		var tipoValidacao = typeof(tipoValidacao) != 'undefined' || tipoValidacao != '' ? tipoValidacao : 'tudo';
		var branco = typeof(branco) != 'undefined' ? branco : false;
		var confirmacao = typeof(confirmacao) != 'undefined' ? confirmacao : false;
    	var objConfirmacao = typeof(objConfirmacao) != 'undefined' ? objConfirmacao : document . createElement('INPUT');

        if (confirmacao) {
            if ($(objConfirmacao).size() <= 0) {
                this . addErro('Campo inv\u00E1lido!('+objConfirmacao+')');
                this . notifyErros();
                return false;
            }
            if ($(objConfirmacao).size() > 1) {
                objConfirmacao = $(objConfirmacao).get();
            } else {
                objConfirmacao = $(objConfirmacao).get(0);
            }
        }
        // teste para radio button
        var campoId = campo . length > 0 && campo[0] . type == 'radio' ? campo[0] . id : campo . id;
        var campoName = campo . length > 0 && campo[0] . type == 'radio' ? campo[0] . name : campo . name;

//        if (campo . length > 0 && campo[0] . type == 'radio') {
//    	    //alert(campo[0] . id);
//    	    var campoId = campo[0] . id;
//	        var campoName = campo[0] . id;
//        } else {
//            //alert(campo . id);
//        	var campoId = campo . id;
//        	var campoName = campo . id;
//        }

		// flag
		var chave = -1;
		for (key in this . campos) {
            var thisObj = this . campos[key];

            if (typeof(thisObj) != 'object') {
                continue;
            }

            // teste para radio button
            var thisId = thisObj . campo . length > 0 && thisObj . campo[0] . type == 'radio' ? thisObj . campo[0] . id : this . campos[key] . campo . id;
            var thisName = thisObj . campo . length > 0 && thisObj . campo[0] . type == 'radio' ? thisObj . campo[0] . name : this . campos[key] . campo . name;

//            if (this . campos[key] . campo . length > 0 && this . campos[key] . campo[0] . type == 'radio') {
//	            var thisId = this . campos[key] . campo[0] . id;
//                var thisName = this . campos[key] . campo[0] . name;
//	        } else {
//	        	var thisId = this . campos[key] . campo . id;
//                var thisName = this . campos[key] . campo . name;
//	        }
	        // testa se já esxiste o campo na validação
			if (thisId === campoId) {
	            chave = key;
	        }
		}
		// se não existe adiciona
		if (chave == -1) {
	    	this . campos[this . total++] = new xinput(campo, tipoValidacao, branco, confirmacao, objConfirmacao);

            objInput = campo;
            // acrescenta span se obrigatório
            if (this.settings.exibirObrigatorios && !this . campos[this . total - 1] . branco && objInput . type != 'hidden') {
            	objSpan = document . createElement('SPAN');
            	objSpan . className = 'erro';
            	objSpan . innerHTML = ' *';
            	if (objInput . parentNode) {
                    var objParent = objInput . parentNode;
                    // There is no insertAfter method,
                    // however it can be emulated using
                    // a combination of insertBefore and nextSibling.
                    objParent . insertBefore(objSpan, objInput . nextSibling);
        		}
            }
	    	//alert('adicionando: ' + campoName + ' total: ' + this . total);
	    }
        //alert('campo: ' + campoName + ' ok');
	}
    //metodo para remover inputs
	this . remover = function(campo)
	{
        if ($(campo).size() <= 0) {
            this . addErro('Campo inv\u00E1lido!('+campo+')');
            this . notifyErros();
            return false;
        }
        if ($(campo).size() > 1) {
            campo = $(campo).get();
        } else {
            campo = $(campo).get(0);
        }
        // teste para radio button
        var campoId = campo . length > 0 && campo[0] . type == 'radio' ? campo[0] . id : campo . id;
        var campoName = campo . length > 0 && campo[0] . type == 'radio' ? campo[0] . name : campo . name;

//        if (campo . length > 0 && campo[0] . type == 'radio') {
//    	    //alert(campo[0] . id);
//    	    var campoId = campo[0] . id;
//	        var campoName = campo[0] . id;
//        } else {
//            //alert(campo . id);
//        	var campoId = campo . id;
//        	var campoName = campo . id;
//        }

		// flag
		var chave = -1;
        // testa se existe o campo na validação
		for (key in this . campos) {
            var thisObj = this . campos[key];

            if (typeof(thisObj) != 'object') {
                continue;
            }

            // teste para radio button
            var thisId = thisObj . campo . length > 0 && thisObj . campo[0] . type == 'radio' ? thisObj . campo[0] . id : this . campos[key] . campo . id;
            var thisName = thisObj . campo . length > 0 && thisObj . campo[0] . type == 'radio' ? thisObj . campo[0] . name : this . campos[key] . campo . name;

//            if (this . campos[key] . campo . length > 0 && this . campos[key] . campo[0] . type == 'radio') {
//	            var thisId = this . campos[key] . campo[0] . id;
//                var thisName = this . campos[key] . campo[0] . name;
//	        } else {
//	        	var thisId = this . campos[key] . campo . id;
//                var thisName = this . campos[key] . campo . name;
//	        }
	        // testa se já esxiste o campo na validação
			if (thisId === campoId) {
	            chave = key;
	        }
		}
		// se existe remove
		if (chave != -1) {
            objInput = campo;
            // remove o span se obrigatório
			if (this . campos[parseInt(chave)] . mascara != '' && this . campos[parseInt(chave)] . mascara != 'tudo' && typeof  this . campos[parseInt(chave)] . mascara  == 'function')
			{
            //if (this.settings.exibirObrigatorios && !this . campos[parseInt(chave)] . branco && objInput . type != 'hidden') {
            	if (objInput . parentNode) {
                    objParent = objInput . parentNode;
                    for (var i = 0; i < objParent . childNodes . length; i++) {
                        objChild = objParent . childNodes[i];
                        if (objChild . className == 'erro') {
                            objParent . removeChild(objChild);
                        }
                	}
        		}
				var thisOnKeyUp = 'Event . remove(objInput, "keyup", function() ' + "\n" + '{' + "\n\t" + 'this . value = ' + this . campos[parseInt(chave)] . mascara + '(this . value);' + "\n" + '});';
            }
		    
            if (this . campos[parseInt(chave)] . mascara != '' && this . campos[parseInt(chave)] . mascara != 'tudo') {
                eval(thisOnKeyUp);

                if (this . minLen > 0) {
                    switch ($(objInput).get(0).tagName) {
                        case 'INPUT':
                            $(objInput).attr('minLength', '');
							if ($.fn.mask) {
				                $(objInput).unmask();
							}
                            break;
                        case 'TEXTAREA':
                            
                            break;
                        default :
                    }
                }
                if (this . maxLen > 0) {
                    switch ($(objInput).get(0).tagName) {
                        case 'INPUT':
                            $(objInput).attr('maxLength', this . maxLen);
                            break;
                        case 'TEXTAREA':
                            if ($('#'+$(objInput).attr('id')+'Cont').size() <= 0) {
            //                    objValidador . addErro('Falta #'+$(objInput).attr('id')+'Cont');
            //                    objValidador . notifyErros();
                            }
                            $(objInput).apTextCounter({
                        		maxCharacters: this . maxLen
                                ,tracker: '#'+$(objInput).attr('id')+'Cont'
                                ,trackerTemplate: '%s caracter(es) restantes'
                        		,onTrackerUpdated: function(msg) {
                        			if (msg.count <= 0) {
                        				$(msg.config.tracker).css('color', 'red');
                        			} else {
                        				$(msg.config.tracker).css('color', 'black');
                        			}
                        		}
                        	});
                            break;
                        default :
                    }
                }

            }
			for (i = parseInt(chave); i < (this . campos . length - 1); i++) {
				this . campos[i] = this . campos[(i + 1)];
			}
			this . campos . pop();
			this . total--;
			//alert('removendo: ' + campoName + ' total: ' + this . total);
		}
	}
    this . valida = function(event)
    {
        // Editado em 14/09/11
        // Esse if serve para o validador funcionar em todos os navegadores. 
        if (navigator.appName.indexOf('Microsoft') != -1) {
            window.event.cancelBubble=true; // O IE só entende este comando, enquanto os outros navegadores so entedem o abaixo
        }else{
            event.stopPropagation();
        }
        //alert(this . name);
        setTabIndex(this);

    	obj = this . parent; // this aqui é o objForm

        var ixx = obj . campos;

    	//alert(ixx.valueOf());
        ixx . sort(sortCampos);

        obj.resetErros();
        var retorno = true;

        for (var y = 0; y < ixx . length; y++) {
        	//alert(print_r(ixx[y] . campo, 5));
        	//alert(ixx[y] . campo . name + ' ' + ixx[y] . campo . type + ' ' + ixx[y] . campo . tabIndex/* + ' ' + ixx[y] . campo[0] . tabIndex*/);

            if (ixx[y] . campo . length > 0 && ixx[y] . campo[0]) {
                if (ixx[y] . campo[0] . type == 'radio') {
                    var objCampo = ixx[y] . campo[0];
                    if (!window . returnValueRadioButton) {
                        obj . addErro('Necess\u00E1rio arquivo radioButtonFunctions.js');
                        continue;
                    }
                    var campoValue = returnValueRadioButton(ixx[y] . campo);
                }
                if (ixx[y] . campo . type == 'select-one') {
                    var objCampo = ixx[y] . campo;
                    var campoValue = objCampo . value;
                }
                //alert('campo: ' + ixx[y] . campo . type + ' campo[0]: ' + ixx[y] . campo[0] . type);
            } else {
                if (ixx[y] . campo . type == 'checkbox') {
                    var objCampo = ixx[y] . campo;
                    if (!window . returnValueCheckbox) {
                        obj . addErro('Necess\u00E1rio arquivo checkboxFunctions.js');
                        continue;
                    }
                    var campoValue = ixx[y] . campo . checked ? returnValueCheckbox(ixx[y] . campo) : '';
                } else {
                    var objCampo = ixx[y] . campo;
                    var campoValue = objCampo . value;
                }
            }
            /*if (ixx[y] . campo . length > 0 && (ixx[y] . campo[0] . type == 'radio')) {
                var objCampo = ixx[y] . campo[0];
                if (!window . returnValueRadioButton) {
                    alert('Necessário radioButtonFunctions.js');
                    continue;
                }
                var campoValue = returnValueRadioButton(ixx[y] . campo);
            } else {
                var objCampo = ixx[y] . campo;
                var campoValue = objCampo . value;
            }*/
            var campoId = objCampo . id;
	        var campoName = objCampo . name;
            var campoTitle = objCampo . title;
            var txt = '';
            if (campoId) {
                var txt = '|campoId: ' + campoId;
            }
            if (campoName) {
                var txt = txt + '|campoName: ' + campoName;
            }
            campoValue = jQuery.trim(campoValue);
            //alert(txt);
    		if (!branco(campoValue)) {
	            if (ixx[y].minLen > 0 && campoValue.length < ixx[y].minLen) {
                    obj . addErro(mensagens['minLen'].replace(/%d/, ixx[y].minLen).replace(/%s/, campoTitle));
                    if (retorno) {
                        objCampo . focus();
                    }
	                retorno = false;
	            }
	            if (ixx[y].maxLen > 0 && campoValue.length > ixx[y].maxLen) {
                    obj . addErro(mensagens['maxLen'].replace(/%d/, ixx[y].maxLen).replace(/%s/, campoTitle));
                    if (retorno) {
                        objCampo . focus();
                    }
	                retorno = false;
	            }
    	        // valida campos com confirmação de valores
    	        if (ixx[y] . confirmacao) {
    	            if (objCampo . value != ixx[y] . objConfirmacao . value) {
                        //alert(mensagens['confirmacao'] + campoName + ', ' + ixx[y] . objConfirmacao . name);
                        obj . addErro(mensagens['confirmacao']);
                        if (retorno) {
                            objCampo . focus();
                        }
    	                retorno = false;
    	            }
    	        }
    	        // teste para radio button
                if (ixx[y] . campo . length > 0 && ixx[y] . campo[0] . type == 'radio') {
                    var i = returnIndexRadioButton(ixx[y] . campo);
    				if (i < 0) {
    				    obj . addErro(mensagens['selecione'].replace(/%s/, campoTitle));
                        if (retorno) {
                            ixx[y] . campo[0] . focus();
                        }
    					retorno = false;
    	            }
                }
    			switch (ixx[y] . tipo) {
    			    case 'cep':
    			    	if (!verificaCEP(campoValue)) {
    			    	    obj . addErro(mensagens['cep']);
    		                if (retorno) {
                                objCampo . focus();
                            }
                            retorno = false;
    		            }
    			        break;

    			    case 'cnpj':
    			    	if (!verificaCNPJ(campoValue)) {
    			    	    obj . addErro(mensagens['cnpj']);
    		                if (retorno) {
                                objCampo . focus();
                            }
    		                retorno = false;
    		            }
    			        break;

    				case 'cpf':
    					if (!verificaCPF(campoValue)) {
                            obj . addErro(mensagens['cpf']);
    		                if (retorno) {
                                objCampo . focus();
                            }
    		                retorno = false;
    		            }
    			        break;

    				case 'dataBr':
    					if (!verificaData(campoValue)) {
                            obj . addErro(mensagens['data']);
    		                if (retorno) {
                                objCampo . focus();
                            }
    		                retorno = false;
    		            }
    			        break;

    				case 'email':
    					if (!verificaEmail(campoValue)) {
                            obj . addErro(mensagens['email']);
    		                if (retorno) {
                                objCampo . focus();
                            }
    		                retorno = false;
    		            }
    			        break;

    				case 'fone5':
    					if (!verificaFone5(campoValue)) {
    		                obj . addErro(mensagens['telefone']);
    		                if (retorno) {
                                objCampo . focus();
                            }
    		                retorno = false;
    		            }
    			        break;

                    case 'hora':
    					if (!verificaHora(campoValue)) {
    		                obj . addErro(mensagens['hora']);
    		                if (retorno) {
                                objCampo . focus();
                            }
    		                retorno = false;
    		            }
    			        break;

                    case 'inteiro':
    			    	if (!campoValue.match(/^\d+$/)) {
                            obj . addErro(mensagens['valor']);
    		                if (retorno) {
                                objCampo . focus();
                            }
    		                retorno = false;
    		            }
    			        break;

                    case 'nome':
    					if (!verificaNome(campoValue)) {
    		                obj . addErro(mensagens['nome']);
    		                if (retorno) {
                                objCampo . focus();
                            }
    		                retorno = false;
    		            }
    			        break;

    			    case 'rg':
    			    	if (!verificaRG(campoValue)) {
    		                obj . addErro(mensagens['rg']);
    		                if (retorno) {
                                objCampo . focus();
                            }
    		                retorno = false;
    		            }
    			        break;

    			    case 'url':
    			    	if (!verificaUrl(campoValue)) {
    		                obj . addErro(mensagens['url']);
    		                if (retorno) {
                                objCampo . focus();
                            }
    		                retorno = false;
    		            }
    			        break;

                    case 'valor':
    			    	if (!verificaValor(campoValue)) {
                            obj . addErro(mensagens['valor']);
    		                if (retorno) {
                                objCampo . focus();
                            }
    		                retorno = false;
    		            }
    			        break;
    			}
    		} else {
    			// valida campos obrigatórios
    			if (!ixx[y] . branco) {
                    // sendo vedado branco e value vazia
                    obj . addErro(mensagens['branco'].replace(/%s/, campoTitle));
                    if (retorno) {
                        if(!jQuery.browser.msie)
                            objCampo . focus();
                    }
                    retorno = false;
    	        }
    		}
        }
        if (!retorno) {
            obj . notifyErros();
            if (typeof obj.settings.callbackFalse == 'function') {
                obj.settings.callbackFalse(obj);
            }
        } else {
            if (typeof obj.settings.callbackTrue == 'function') {
                retorno = obj.settings.callbackTrue(obj);
            }
        }
        if (typeof obj.settings.callback == 'function') {
            obj.settings.callback(obj);
        }
        return retorno;
    }
    if ($(obj).size() > 0) {
        obj = $(obj).get(0);
        obj . onsubmit = this . valida;
        obj . parent = this;
    }
    if (this.erros.length > 0) {
        this . notifyErros();
    }
}

//#####################################
//objeto xinput
//#####################################
function xinput(objInput, tipoValidacao, branco, confirmacao, objConfirmacao)
{
	// seta valor default
	this . campo = typeof(objInput) != 'undefined' ? objInput : document . createElement('INPUT');
	this . tipo = typeof(tipoValidacao) != 'undefined' && tipoValidacao != '' ? tipoValidacao : 'tudo';
    this . branco = typeof(branco) != 'undefined' ? branco : false;
    this . confirmacao = typeof(confirmacao) != 'undefined' ? confirmacao : false;
    this . objConfirmacao = typeof(objConfirmacao) != 'undefined' ? objConfirmacao : document . createElement('INPUT');

    var minLen = maxLen = 0;
    if (this . tipo . match(/\(.*\)$/)) {
        var limite = this . tipo . replace(/[^\d\,]/g, '');
        if (limite.indexOf(',') > -1) {
            var minLen = parseInt($.trim(limite.split(',')[0]));
            var minLen = isNaN(minLen) ? 0 : minLen;
            var maxLen = parseInt($.trim(limite.split(',')[1]));
            var maxLen = isNaN(maxLen) ? 0 : maxLen;
        } else {
            limite = isNaN(parseInt(limite)) ? 0 : parseInt(limite);
            var maxLen = limite;
        }
    }
    this . minLen = minLen;
    this . maxLen = maxLen;
//    objValidador . addErro('limite '+limite + ' minLen '+minLen +' maxnLen '+maxLen);
//    objValidador . notifyErros();
    this . tipo = this . tipo . replace(/\(.*\)$/, '');

    var thisOnKeyUp = 'Event . add(objInput, "keyup", function() ' + "\n" + '{' + "\n\t" + 'this . value = ' + this . tipo + '(this . value);' + "\n" + '});';
	if (objInput . length > 0 && objInput[0] . type == 'radio') {
        var thisOnKeyUp = '//alert("teste")';//'setEventRadioButton(objInput, "keyup", function() ' + "\n" + '{' + "\n\t" + 'this . value = ' + this . tipo + '(this . value);' + "\n" + '});'
    }

	switch (this . tipo) {
		case 'tudo':
            this . mascara = this . tipo;
	        break;

	    case 'cep':
            this . mascara = this . tipo;
	        // Seta Mascara
            switch ($(objInput).get(0).tagName) {
                case 'INPUT':
                    if ($.fn.mask) {
                        $(objInput).mask('99999-999');
                    } else {
                        // Seta tamanho do campo
                        objInput . setAttribute('maxLength', 9);
            	        eval(thisOnKeyUp);
            			// Seta tratador de tecla 
            			objInput . onkeypress = function(e)
            			{
            				return validaTecla(e, 'inteiro');
            			}
                    }
                    break;
                default :
            }
	        break;

	    case 'cnpj':
            this . mascara = this . tipo;
	        // Seta Mascara
            switch ($(objInput).get(0).tagName) {
                case 'INPUT':
                    if ($.fn.mask) {
                        $(objInput).mask('999.999.999/9999-99');
                    } else {
                        // Seta tamanho do campo
                        objInput . setAttribute('maxLength', 19);
            	        eval(thisOnKeyUp);
            			// Seta tratador de tecla 
            			objInput . onkeypress = function(e)
            			{
            				return validaTecla(e, 'inteiro');
            			}
                    }
                    break;
                default :
            }
	        break;

		case 'cpf':
            this . mascara = this . tipo;
	        // Seta Mascara
            switch ($(objInput).get(0).tagName) {
                case 'INPUT':
                    if ($.fn.mask) {
                        $(objInput).mask('999.999.999-99');
                    } else {
                        // Seta tamanho do campo
                        objInput . setAttribute('maxLength', 14);
            	        eval(thisOnKeyUp);
            			// Seta tratador de tecla 
            			objInput . onkeypress = function(e)
            			{
            				return validaTecla(e, 'inteiro');
            			}
                    }
                    break;
                default :
            }
	        break;

		case 'dataBr':
            this . mascara = this . tipo;
	        // Seta Mascara
            switch ($(objInput).get(0).tagName) {
                case 'INPUT':
                    if ($.fn.mask) {
                        $(objInput).mask('99/99/9999');
                    } else {
                        // Seta tamanho do campo
                        objInput . setAttribute('maxLength', 10);
            	        eval(thisOnKeyUp);
            			// Seta tratador de tecla 
            			objInput . onkeypress = function(e)
            			{
            				return validaTecla(e, 'inteiro');
            			}
                    }
                    break;
                default :
            }
	        break;

		case 'email':
	        // Seta tamanho do campo
			objInput . setAttribute('maxLength', 150);
            // Seta Mascara
            this . mascara = this . tipo;
	        // Seta tratador de tecla
			objInput . onkeypress = function(e)
			{
				return validaTecla(e, 'email');
			}
	        break;

		case 'fone5':
            this . mascara = this . tipo;
	        // Seta Mascara
            switch ($(objInput).get(0).tagName) {
                case 'INPUT':
                    if ($.fn.mask) {
                        $(objInput).mask('(99) 9999-9999');
                    } else {
                        // Seta tamanho do campo
                        objInput . setAttribute('maxLength', 14);
            	        eval(thisOnKeyUp);
            			// Seta tratador de tecla 
            			objInput . onkeypress = function(e)
            			{
            				return validaTecla(e, 'inteiro');
            			}
                    }
                    break;
                default :
            }
	        break;

        case 'hora':
            this . mascara = this . tipo;
	        // Seta Mascara
            switch ($(objInput).get(0).tagName) {
                case 'INPUT':
                    if ($.fn.mask) {
                        $(objInput).mask('99:99?:99');
                    } else {
                        // Seta tamanho do campo
                        objInput . setAttribute('maxLength', 8);
            	        eval(thisOnKeyUp);
            			// Seta tratador de tecla 
            			objInput . onkeypress = function(e)
            			{
            				return validaTecla(e, 'inteiro');
            			}
                    }
                    break;
                default :
            }
	        break;

        case 'inteiro':
            this . mascara = this . tipo;
	        // Seta Mascara
            switch ($(objInput).get(0).tagName) {
                case 'INPUT':
                    if ($.maskMoney) {
                        $(objInput).maskMoney({thousands: '', precision: 0});
                    } else {
            	        eval(thisOnKeyUp);
            			// Seta tratador de tecla 
            			objInput . onkeypress = function(e)
            			{
            				return validaTecla(e, 'inteiro');
            			}
                    }
                    break;
                default :
            }
	        break;

		case 'nome':
	        // Seta tamanho do campo
			objInput . setAttribute('maxLength', 255);
			// Seta Mascara
            this . mascara = this . tipo;
	        //eval(thisOnKeyUp);
			// Seta tratador de tecla
			objInput . onkeypress = function(e)
			{
				return validaTecla(e, 'nome');
			}
	        break;

	    case 'rg':
	        // Seta tamanho do campo
			//objInput . setAttribute('maxLength', 13); // com trços
            objInput . setAttribute('maxLength', 10); // sem trços
	        // Seta Mascara
            this . mascara = this . tipo;
	        eval(thisOnKeyUp);
			// Seta tratador de tecla
			objInput . onkeypress = function(e)
			{
				return validaTecla(e, 'inteiro');
			}
	        break;

		case 'url':
            // Seta Mascara
            this . mascara = this . tipo;
	        eval(thisOnKeyUp);
			/** Seta tratador de tecla
			objInput . onkeypress = function(e)
			{
				return validaTecla(e, 'url');
			}**/
	        break;

        case 'valor':
            this . mascara = this . tipo;
	        // Seta Mascara
            switch ($(objInput).get(0).tagName) {
                case 'INPUT':
                    if ($.maskMoney) {
                        $(objInput).maskMoney({thousands: '', decimalPoint: ','});
                    } else {
            	        eval(thisOnKeyUp);
            			// Seta tratador de tecla 
            			objInput . onkeypress = function(e)
            			{
            				return validaTecla(e, 'valor');
            			}
                    }
                    break;
                default :
            }
	        break;

        default :
            // Seta Mascara
            this . mascara = this . tipo;
			eval(thisOnKeyUp);
            var onKeyPress = 'validaTecla(e, "' + this . tipo + '");';
            objInput . onkeypress = function(e)
			{
                return eval(onKeyPress);
			}
			//alert(objInput . onkeypress);
	}
    if (this . minLen > 0) {
        switch ($(objInput).get(0).tagName) {
            case 'INPUT':
                $(objInput).attr('minLength', this . minLen);
                break;
            case 'TEXTAREA':
                
                break;
            default :
        }
    }
    if (this . maxLen > 0) {
        switch ($(objInput).get(0).tagName) {
            case 'INPUT':
                $(objInput).attr('maxLength', this . maxLen);
                break;
            case 'TEXTAREA':
                if ($('#'+$(objInput).attr('id')+'Cont').size() <= 0) {
//                    objValidador . addErro('Falta #'+$(objInput).attr('id')+'Cont');
//                    objValidador . notifyErros();
                }
                $(objInput).apTextCounter({
            		maxCharacters: this . maxLen
                    ,tracker: '#'+$(objInput).attr('id')+'Cont'
                    ,trackerTemplate: '%s caracter(es) restantes'
            		,onTrackerUpdated: function(msg) {
            			if (msg.count <= 0) {
            				$(msg.config.tracker).css('color', 'red');
            			} else {
            				$(msg.config.tracker).css('color', 'black');
            			}
            		}
            	});
                break;
            default :
        }
    }
}

//#####################################
//Funções de Máscara
//#####################################

/*Função que padroniza alpha */
function alpha(v)
{
    v += '';
    v = v . replace(/[^a-z]/ig, ''); //Remove tudo o que não é letra
    return v;
}

/*Função que padroniza alfanumerico */
function alfanumerico(v)
{
    v += '';
    v = v . replace(/[^a-z0-9]/ig, ''); //Remove tudo o que não é dígito ou letra
    return v;
}

/*Função que padroniza CEP 12345-678*/
function cep(v)
{
    v = v . replace(/\D/g, ''); //Remove tudo o que não é dígito
    v = v . replace(/^(\d{5})(\d)/, '$1-$2');
    return v;
}

/*Função que padroniza CNPJ 012.345.678/9012-34*/
function cnpj(v)
{
    v += '';
    v = v . replace(/\D/g, ''); //Remove tudo o que não é dígito
    v = v . replace(/^(\d{3})(\d)/, '$1.$2');
    v = v . replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
    v = v . replace(/\.(\d{3})(\d)/, '.$1/$2');
    v = v . replace(/(\d{4})(\d)/, '$1-$2');
    return v;
}

/*Função que padroniza CPF 123.456.789-01*/
function cpf(v)
{
    v += '';
    v = v . replace(/\D/g, ''); //Remove tudo o que não é dígito
    v = v . replace(/(\d{3})(\d)/, '$1.$2');
    v = v . replace(/(\d{3})(\d)/, '$1.$2');

    v = v . replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    return v;
}

/*Função que padroniza DATA*/
function dataBr(v)
{
    v += '';
    v = v . replace(/\D/g, ''); //Remove tudo o que não é dígito
    v = v . replace(/(\d{2})(\d)/, '$1/$2');
    v = v . replace(/(\d{2})(\d)/, '$1/$2');
    return v;
}

/*Função que padroniza  telefone (11) 4184-1241*/
function fone5(v)
{
    v += '';
    v = v . replace(/\D/g, ''); //Remove tudo o que não é dígito
    v = v . replace(/^(\d\d)(\d)/g, '($1) $2');
    v = v . replace(/(\d{4})(\d)/, '$1-$2');
    return v;
}

/*Função que padroniza Hora*/
function hora(v)
{
    v = v . replace(/\D/g, '');
    v = v . replace(/(\d{2})(\d)/, '$1:$2');
    return v;
}

/*Função que padroniza  telefone (11) 4184-1241*/
function inteiro(v)
{
    v += '';
    return v . replace(/\D/g, ''); //Remove tudo o que não é dígito
}

/*Função que padroniza nome*/
function nome(v)
{
	// ,<.>;:/?[{]}| [0-9'"!@#\$£%¢¨¬&\*\(\)-_=\+]
    //v = v . replace(/[^a-z À-ú\W]/gi, '');
    return v;
}

/*Função que padroniza Rg 123.123.123-1*/
function rg(v)
{
    v += '';
    v = v . replace(/\D/g, ''); //Remove tudo o que não é dígito
	//v = v . replace(/^(\d{3})(\d{3})(\d{3})(\d)/g, '$1.$2.$3-$4');
    return v;
}

/*Função que padroniza o Site*/
function url(v)
{
    v += '';
    protocolo   = /^((ht|f)tp(s?)\:\/\/|~\/|\/)/ . test(v) ? v . replace(/^((ht|f)tp(s?)\:\/\/|~\/|\/)(.*)/, '$1') : 'http://';
    protocolo   = protocolo != '' ? protocolo : 'http://';
    dominio     = v = v . replace(/^((ht|f)tp(s?)\:\/\/|~\/|\/)/, '');
    caminho     = '';
    if (v . indexOf('/') > -1) {
    	dominio = v . split('/')[0];
        caminho = v . replace(/[^\/]*/, '');
        dominio = dominio . replace(/[^\w\.\+-:@]/g, '');
        caminho = caminho . replace(/[^\w\d\+-@:\?&=%\(\)\.]/g, '');
        caminho = caminho . replace(/([\?&])=/, '$1');
    }
    if (caminho != '') {
    	dominio = dominio . replace(/\.+$/, '');
    }
    if (dominio != '') {
    	v = protocolo + dominio + caminho;
    } else {
    	v = dominio + caminho;
    }
    return v;
}

/*Função que padroniza valor monétario*/
function valor(v)
{
    v += '';
    v = v . replace(/\D\./g, ''); //Remove tudo o que não é dígito
    //v = v . replace(/^([0-9]{3}\.?){3}-[0-9]{2}$/, '$1.$2');
    //v = v . replace(/(\d{3})(\d)/g, '$1,$2');
    //v = v . replace(/(\d)(\d{2})$/, '$1.$2'); //Coloca ponto antes dos 2 últimos digitos
    return v;
}

//#####################################
//insere/remove o sinal de negatico de um campo
//#####################################

function inverte(a)
{
    valor = a . value;
    if (valor . indexOf('-') == -1) {
        a . value = '-' + valor;
    } else {
        a . value = valor . substr(1, 100);
    }
}

//#####################################
//Funcoes de validação
//#####################################
function branco(valor)
{
    if (valor == '') {
        return true;
    } else {
        return false;
    }
}

/************************************************
* function verificaCEP
* Verifica se um CEP é válido
* Input: cep a ser verificado
* exp = /((\d){3}).((\d){3}).((\d){3})-(\d)/
************************************************/
function verificaCEP(xcep)
{
    exp = /^\d{5}\-\d{3}$/;
	if (!exp . test(xcep)) {
        return false;
    } else {
        return true;
    }
}

/**
 *
 * VALIDA CNPJ COM 14 OU 15 DIGITOS
 * A VALIDAÇÃO É FEITA COM OU SEM OS CARACTERES SEPARADORES, PONTO, HIFEN, BARRA
 *
 * ESTE MÉTODO FOI ADAPTADO POR:
 * Shiguenori Suguiura Junior <junior@dothcom.net>
 *
 * http://blog.shiguenori.com
 * http://www.dothcom.net
 *
 */
function verificaCNPJ(scnpj, element)
{
    if (!/^(\d{2,3}).?(\d{3}).?(\d{3})\/?(\d{4})-?(\d{2})/ . test(scnpj)) {
        
        return false;
    }
   // DEIXA APENAS OS NÚMEROS
   cnpj = scnpj . replace(/\D/g, '');
   /*cnpj = cnpj.replace('/','');
   cnpj = cnpj.replace('.','');
   cnpj = cnpj.replace('.','');
   cnpj = cnpj.replace('-','');*/

   var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
   digitos_iguais = 1;

   if (cnpj.length < 14 && cnpj.length < 15) {
      return false;
   }
   for (i = 0; i < cnpj.length - 1; i++) {
      if (cnpj.charAt(i) != cnpj.charAt(i + 1)) {
         digitos_iguais = 0;
         break;
      }
   }

   if (!digitos_iguais) {
      tamanho = cnpj.length - 2;
      numeros = cnpj.substring(0, tamanho);
      digitos = cnpj.substring(tamanho);
      soma = 0;
      pos = tamanho - 7;

      for (i = tamanho; i >= 1; i--) {
         soma += numeros.charAt(tamanho - i) * pos--;
         if (pos < 2) {
            pos = 9;
         }
      }
      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
      if (resultado != digitos.charAt(0)) {
         return false;
      }
      tamanho = tamanho + 1;
      numeros = cnpj.substring(0,tamanho);
      soma = 0;
      pos = tamanho - 7;
      for (i = tamanho; i >= 1; i--){
         soma += numeros.charAt(tamanho - i) * pos--;
         if (pos < 2){
            pos = 9;
         }
      }
      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
      if (resultado != digitos.charAt(1)) {
         return false;
      }
      return true;
   } else {
      return false;
   }
}

/************************************************
* function verificaCGC
* Verifica se um CGC é válido
* Input: cgc a ser verificado
************************************************/
function verificaCGC(scgc)
{
	cgc = scgc . replace(/\D/g,'');
    if ((cgc . indexOf('-') != -1) || (cgc . indexOf('.') != -1) || (cgc . indexOf('/') != -1)) {
        return false;
    }
    var df, resto, dac = '';
    df = 5 * cgc . charAt(0) + 4 * cgc . charAt(1) + 3 * cgc . charAt(2) + 2 * cgc . charAt(3) + 9 * cgc . charAt(4) + 8 * cgc . charAt(5) + 7 * cgc . charAt(6) + 6 * cgc . charAt(7) + 5 * cgc . charAt(8) + 4 * cgc . charAt(9) + 3 * cgc . charAt(10) + 2 * cgc . charAt(11);
    resto = df % 11;
    dac += ((resto <= 1) ? 0 : (11 - resto));
    df = 6 * cgc . charAt(0) + 5 * cgc . charAt(1) + 4 * cgc . charAt(2) + 3 * cgc . charAt(3) + 2 * cgc . charAt(4) + 9 * cgc . charAt(5) + 8 * cgc . charAt(6) + 7 * cgc . charAt(7) + 6 * cgc . charAt(8) + 5 * cgc . charAt(9) + 4 * cgc . charAt(10) + 3 * cgc . charAt(11) + 2 * parseInt(dac);
    resto = df % 11;
    dac += ((resto <= 1) ? 0 : (11 - resto));
    return (dac == cgc . substring(cgc . length - 2, cgc . length));
}

/************************************************
* function verificaCPF
* Verifica se um CPF é válido
* Input: cpf a ser verificado
************************************************/
function verificaCPF(xcpf)
{
    var cpf = xcpf . replace(/\D/g, '');
    if (cpf == '00000000000' || cpf == '11111111111' || cpf == '22222222222'
    || cpf == '33333333333' || cpf == '44444444444' || cpf == '55555555555' || cpf == '66666666666'
    || cpf == '77777777777' || cpf == '88888888888' || cpf == '99999999999')
	{
	   return false;
    }
	var dac = '', inicio = 2, fim = 10, soma, digito, i, j;
    for (j = 1; j <= 2; j++) {
        soma = 0;
        for (i = inicio; i <= fim; i++) {
            soma += parseInt(cpf . substring(i - j - 1, i - j)) * (fim + 1 + j - i);
        }
        if (j == 2) {
            soma += 2 * digito;
		}
        digito = (10 * soma) % 11;
        if (digito == 10) {
            digito = 0;
		}
        dac += digito;
        inicio = 3;
        fim = 11;
    }
    return (dac == cpf . substring(cpf . length - 2, cpf . length));
}

function verificaData(data, gtt)
{
    gtt = gtt || false;
    if ((data == null) || (data . length < 10)) {
        return false;
    }
    var jsDataValida = true;
    var jsDia = data . substring(0, 2) - 0;
    var jsMes = data . substring(3, 5) - 1;
    var jsAno = data . substring(6, 10) - 0;
    var oData = new Date(jsAno, jsMes, jsDia);
    if (jsDia != oData . getDate()) {
        jsDataValida = false;
    }
    if (jsMes != oData . getMonth()) {
        jsDataValida = false;
    }
    if (jsAno != oData . getFullYear()) {
        jsDataValida = false;
    }
    if (gtt) {
        var oDataHoje = new Date();
        if (oData < oDataHoje) {
            jsDataValida = false;
        }
    }
    return jsDataValida;
}

function verificaEmail(email)
{
    var s = new String(email);
    // { } ( ) < > [ ] | \ /
    if ((s . indexOf('{') >= 0) || (s . indexOf('}') >= 0) || (s . indexOf('(') >= 0) || (s . indexOf(')') >= 0) || (s . indexOf('<') >= 0) || (s . indexOf('>') >= 0) || (s . indexOf('[') >= 0) || (s . indexOf(']') >= 0) || (s . indexOf('|') >= 0) || (s . indexOf('\'') >= 0) || (s . indexOf('/') >= 0)) {
    	return false;
    }
    // & * $ % ? ! ^ ~ ` ' "
    if ((s . indexOf('&') >= 0) || (s . indexOf('*') >= 0) || (s . indexOf('$') >= 0) || (s . indexOf('%') >= 0) || (s . indexOf
        ('?') >= 0) || (s . indexOf('!') >= 0) || (s . indexOf('^') >= 0) || (s . indexOf('~') >= 0) || (s . indexOf('`') >= 0) || (s . indexOf("'") >= 0)) {
       	return false;
	}
    // , ; : = #
    if ((s . indexOf(',') >= 0) || (s . indexOf(';') >= 0) || (s . indexOf(':') >= 0) || (s . indexOf('=') >= 0) || (s . indexOf('#') >= 0)) {
    	return false;
    }
    // procura se existe apenas um @
    if ((s . indexOf('@') < 0) || (s . indexOf('@') != s . lastIndexOf('@'))) {
    	return false;
    }
    // verifica se tem pelo menos um ponto após o @
    if (s . lastIndexOf('.') < s . indexOf('@')) {
        return false;
    }
    return true;
}

/************************************************
* function verificaTelefone
* Verifica se um telefone é válido
* Input: telefone a ser verificado
* exp = /\(\d{2}\) \d{4}\-\d{4}/
************************************************/
function verificaFone5(tel)
{
    exp = /\(\d{2}\) \d{4}\-\d{4}/;
	if (!exp . test(tel)) {
        return false;
    } else {
        return true;
    }
}

function verificaHora(xhora)
{
    exp = /([0-1]\d|[2][0-3]):([0-5]\d)(:([0-5]\d))?/;
	if (!exp . test(xhora)) {
        return false;
    } else {
        return true;
    }
}

function verificaNome(nome)
{
    //exp = /^[a-z\u00A1-\uFFFF]*$/i;
    exp = /^[a-z\u00C0-\u00ff A-Z]+$/i;
	if (!exp . test(nome)) {
        return false;
    } else {
        return true;
    }
}

/************************************************
* function verificaRG
* Verifica se um RG é válido
* Input: rg a ser verificado
* exp = /((\d){3}).((\d){3}).((\d){3})-(\d)/
************************************************/
function verificaRG(xrg)
{
    //exp = /((\d){3}).((\d){3}).((\d){3})-(\d)/; // comtraços
    exp = /((\d){10})/; // sem traços
	if (!exp . test(xrg)) {
        return false;
    } else {
        return true;
    }
}

function verificaUrl(xurl)
{
    var exp = /^(((ht|f)tp(s?))\:\/\/|~\/|\/){1}([0-9a-zA-Z]+:[0-9a-zA-Z]+@)?(([a-zA-Z]{1}([0-9a-zA-Z-]+\.?)*(\.[0-9a-zA-Z]{2,5}){1})(:[0-9]{1,5})?)+((\/?[0-9a-zA-Z_-]+\/)+|\/?)([0-9a-zA-Z]+([0-9a-zA-Z_-]?[0-9a-zA-Z]+)?(\.[0-9a-zA-Z]{3,4})?)?([,][0-9a-zA-Z]+)*((\?[0-9a-zA-Z]+=[0-9a-zA-Z_]+)?(&[0-9a-zA-Z]+=[0-9a-zA-Z]+)*([,][0-9a-zA-Z]*)*)?$/;
	if (!exp . test(xurl)) {
        return false;
    } else {
        return true;
    }
}

function verificaValor(xvalor)
{
	exp = /^\d+(.\d{1,})?$/;
	if (!exp . test(xvalor)) {
        return false;
    } else {
        return true;
    }
}

function sortCampos(xinputA, xinputB)
{
    if (xinputA . campo . length > 0 && xinputA . campo[0] . type == 'radio') {
        var tabIndexA = xinputA . campo[0] . tabIndex;
        var idA = xinputA . campo[0] . id;
    } else {
        var tabIndexA = xinputA . campo . tabIndex;
        var idA = xinputA . campo . id;
    }

	if (xinputB . campo . length > 0 && xinputB . campo[0] . type == 'radio') {
        var tabIndexB = xinputB . campo[0] . tabIndex;
        var idB = xinputB . campo[0] . id;
    } else {
    	var tabIndexB = xinputB . campo . tabIndex;
        var idB = xinputB . campo . id;
    }
	//alert(idA + ' = ' + tabIndexA + ' : ' + idB + ' = ' + tabIndexB);
	return tabIndexA - tabIndexB;
}

//#####################################
//tratadores de teclas
//#####################################

function permDefaultCharacters(e)
{
	e = typeof(e) != 'undefined' ? e : null;

	var teclasPermitidas = new Array(8/**Backspace**/, 9/**TAB**/, 19/**pause/break**/, 20/**caps lock**/, 27/**escape**/, 33/**page up**/, 34/**page down**/, 35/**End**/, 36/**Home**/, 37/**Seta Esquerda**/, 38/**Seta Cima**/, 39/**Seta Direita**/, 40/**Seta Baixo**/, 45/**Insert**/, 46/**Delete**/, 112/**F1**/, 113/**F2**/, 114/**F3**/, 115/**F4**/, 116/**F5**/, 117/**F6**/, 118/**F7**/, 119/**F8**/, 120/**F9**/, 121/**F10**/, 122/**F11**/, 123/**F12**/, 144/**num lock**/, 145/**scroll lock**/);

	//alert(teclasPermitidas.valueOf());

	if (!e) {
	    var e = window . event;
	}

	alvo = eval(sender);

	var charCode = (e . which) ? e . which : e . keyCode;

	var x = charCode;
	for (var i = 0; i < teclasPermitidas . length; i++) {
		if (x == teclasPermitidas[i]) {
			return true;
		}
	}
    return false;
}

/**
 * validaTecla()
 *
 * @author Luis Fernando Gomes
 * @copyright 11/2009
 * @version 1.0
 *
 * Função para limitar o uso de teclas desnecessárias em certos campos.
 *
 * IMPORTANTE
 * A função deve ser chamada no evento ONKEYPRESS, pelo seguinte motivo:
 *
 * No evento onkeypress a validação é feita por caracter ascii.
 * Não possível validar por exemplo as teclas de setas, home, end, etc.
 * Para termos o código dessas teclas, a função tem de ser chamada no evento onkeydown.
 * Outra coisa importante, no evento onkeydown as teclas numéricas do teclado alfa,
 * e do teclado numérico são diferentes: Por exemplo, o "1" do teclado alfa, ou seja,
 * que está em cima do "Q", tem o código 49, já no teclado numérico esse código é 105.
 * É por isso que quando a função era chamada no evento onkeypress, letras eram
 * liberadas, pois nesse evento a validação é feita pelo caractere ascii, e nesse caso o
 * código referente ao "1" dos dois teclados é o mesmo, 49.
 *
 * Histórico:
 *
 * Data			| Versão | Modificação
 * ------------------------------------------------------------------------------------------------
 * 				|  		 | ------------------------------------------------------------------------
 * ------------------------------------------------------------------------------------------------
 *
 * @param string e				O objeto window . event.
 * @param string tipo			O tipo de validação.
 * @return bool
 */
function validaTecla(e, tipo)
{
	// INICIALIZO AS VARIÁVEIS
	e = typeof(e) != 'undefined' ? e : null;
	tipo = typeof(tipo) != 'undefined' && tipo != '' ? tipo : 'tudo';

	// TESTE PARA IE FF
	if (!e) {
	    var e = window . event;
	}

	// TESTE PARA INICIALIZAR O target
	alvo = eval(sender);

	// PEGA O VALOR DA TECLA PRESSIONADA
	var charCode = (e . which) ? e . which : e . keyCode;
	var charValue = String . fromCharCode(charCode); //alert(charCode + '=>' + charValue);

					// 0=> todos 1=> cada
	var ControlChars = new Array(false, false); //1 a 31 e 127
	var SpecialChars = new Array(false, false); //32 a 47 e 58 a 64 e 91 a 96 e 123 a 126 e 128 a 254
	var DigitsOfNumbers = new Array(false, false); //48 a 57
	var Letters = false; //65 a 90 e 97 a 122
	var LettersUpper = new Array(false, false);
	var LettersLower = new Array(false, false);
	var Accents = false; //259 a 221 e 224 a 255

	// ########################## ControlChars ##########################
	var PermControlChars = new Array(true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true);

	var CodeASCIIControlChars = new Array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 127);

	// ########################## SpecialChars ##########################
	//32 a 47
	var PermSlCs31a47 = new Array(true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true);

	//58 a 64
	var PermSlCs58a64 = new Array(true, true, true, true, true, true, true);

	//91 a 96
	var PermSlCs91a96 = new Array(true, true, true, true, true, true);

	//123 a 126
	var PermSlCs123a126 = new Array(true, true, true, true);

	//VerySecialChars
	var PermVerySecialChars = new Array(true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true);

	//32 a 47
	var CodeASCIISlCs31a47 = new Array(32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47);

	//58 a 64
	var CodeASCIISlCs58a64 = new Array(58, 59, 60, 61, 62, 63, 64);

	//91 a 96
	var CodeASCIISlCs91a96 = new Array(91, 92, 93, 94, 95, 96);

	//123 a 126
	var CodeASCIISlCs123a126 = new Array(123, 124, 125, 126);

	//VerySecialChars
	var CodeASCIIVerySecialChars = new Array(128, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, 142, 145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156, 158, 160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 197, 198, 208, 215, 216, 222, 223, 229, 230, 240, 247, 248, 254);

	var PermSpecialChars = new Array() . concat(PermSlCs31a47, PermSlCs58a64, PermSlCs91a96, PermSlCs123a126, PermVerySecialChars);
	var CodeASCIISpecialChars = new Array() . concat(CodeASCIISlCs31a47, CodeASCIISlCs58a64, CodeASCIISlCs91a96, CodeASCIISlCs123a126, CodeASCIIVerySecialChars);

    // ########################## DigitsOfNumbers ##########################
	//&#48; to &#57;      Digits or numbers 0-9
	var PermDigitsOfNumbers = new Array(true, true, true, true, true, true, true, true, true, true);
	var CodeASCIIDigitsOfNumbers = new Array(48, 49, 50, 51, 52, 53, 54, 55, 56, 57);

	// ########################## Letters ##########################
	//&#65; to &#90;     Letters A-Z
	var PermLettersUpper = new Array(true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true);
	var CodeASCIILettersUpper = new Array(65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90);

	//&#97; to &#122;     Letters a-z
	var PermLettersLower = new Array(true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true);
	var CodeASCIILettersLower = new Array(97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122);

	//&#159; to &#221;     Letters Accents A-Z
	var PermLettersAccentsUpper = new Array(true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true);
	var CodeASCIILettersAccentsUpper = new Array(159, 192, 193, 194, 195, 196, 199, 200, 201, 202, 203, 204, 205, 206, 207, 209, 210, 211, 212, 213, 214, 217, 218, 219, 220, 221);

	// ########################## Accents ##########################
	//&#224; to &#255;     Letters Accents a-z
	var PermLettersAccentsLower = new Array(true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true);
	var CodeASCIILettersAccentsLower = new Array(224, 225, 226, 227, 228, 231, 232, 233, 234, 235, 236, 237, 238, 239, 241, 242, 243, 244, 245, 246, 249, 250, 251, 252, 253, 255);

	// ########################## TIPOS DE VALIDAÇÃO ##########################
	switch (tipo){
		case 'tudo':
			ControlChars[0] = true; //1 a 31 e 127
			SpecialChars[0] = true; //32 a 47 e 58 a 64 e 91 a 96 e 123 a 126 e 128 a 254
			DigitsOfNumbers[0] = true; //48 a 57
			Letters = true; //65 a 90 e 97 a 122
			Accents = true; //259 a 221 e 224 a 255
		break;

        case 'alpha':
			ControlChars[0] = true; //1 a 31 e 127
			Letters = true; //65 a 90 e 97 a 122
		break;

        case 'alfanumerico':
			ControlChars[0] = true; //1 a 31 e 127
			DigitsOfNumbers[0] = true; //48 a 57
			Letters = true; //65 a 90 e 97 a 122
		break;

		case 'controlChars':
			ControlChars[0] = true; //1 a 31 e 127
		break;

		case 'email':
			ControlChars[0] = true; //1 a 31 e 127
			Letters = true; //65 a 90 e 97 a 122
			DigitsOfNumbers[0] = true; //48 a 57
			SpecialChars[1] = true;
			var PermSpecialChars = new Array(true, true, true);
			var CodeASCIISpecialChars = new Array(45, 46, 95);// - , ., _ //{95=> _}
			if (charValue == '@') {
				if(alvo . value . indexOf(charValue) != -1) {
	            	return false;
	            } else {
	            	return true;
	            }
	        }
		break;

		case 'inteiro':
			ControlChars[0] = true; //1 a 31 e 127
			DigitsOfNumbers[0] = true; //48 a 57
		break;

		case 'nome':
			ControlChars[0] = true; //1 a 31 e 127
			Letters = true; //65 a 90 e 97 a 122
			Accents = true; //259 a 221 e 224 a 255

			SpecialChars[1] = true;
			var PermSpecialChars = new Array(true);//Space - SPC
			var CodeASCIISpecialChars = new Array('32');
		break;

		case 'url':
			ControlChars[0] = true; //1 a 31 e 127
			Letters = true; //65 a 90 e 97 a 122

			SpecialChars[1] = true;
			var PermSpecialChars = new Array(true, true, true, true);
			var CodeASCIISpecialChars = new Array(38, 47, 61, 63);// & , (slash), =, ?
		break;

        case 'valor':
			ControlChars[0] = true; //1 a 31 e 127
			DigitsOfNumbers[0] = true; //48 a 57
			if (charValue == '.') {
				if(alvo . value . indexOf(charValue) != -1) {
	            	return false;
	            } else {
	            	return true;
	            }
	        }
		break;
	}

	// CONCATENA OS ACENTOS NAS LETRAS
	if (Accents) {
 		PermLettersUpper = PermLettersUpper . concat(PermLettersAccentsUpper);
 		CodeASCIILettersUpper = CodeASCIILettersUpper . concat(CodeASCIILettersAccentsUpper);
 		PermLettersLower = PermLettersLower . concat(PermLettersAccentsLower);
 		CodeASCIILettersLower = CodeASCIILettersLower . concat(CodeASCIILettersAccentsLower);
 	}

	// ########################## Teclas Permitidas ##########################
	var arrayTeclas = new Array();

	if (ControlChars[0]) {
		//  CONCATENA AO ARRAY TODO AO DAS TECLAS
		arrayTeclas = arrayTeclas . concat(CodeASCIIControlChars);
	} else {
		if (ControlChars[1]) {
			//  PERCORRE O ARRAY
			for (i = 0; i < CodeASCIIControlChars . length; i++) {
				if (PermControlChars[i]) {
					//  ACRESCENTA AO ARRAY
					arrayTeclas . push(CodeASCIIControlChars[i]);
			    }
		 	}
		}
	}

	if (SpecialChars[0]) {
		arrayTeclas = arrayTeclas . concat(CodeASCIISpecialChars);
	} else {
		if (SpecialChars[1]) {
			for (i = 0; i < PermSpecialChars . length; i++) {
		 		if (PermSpecialChars[i]) {
					arrayTeclas . push(CodeASCIISpecialChars[i]);
			    }
		 	}
		}
	}

	if (DigitsOfNumbers[0]) {
		arrayTeclas = arrayTeclas . concat(CodeASCIIDigitsOfNumbers);
	} else {
		if (DigitsOfNumbers[1]) {
			for (i = 0; i < PermDigitsOfNumbers . length; i++) {
		 		if (PermDigitsOfNumbers[i]) {
					arrayTeclas . push(CodeASCIIDigitsOfNumbers[i]);
			    }
		 	}
		}
	}

	if (Letters) {
		arrayTeclas = arrayTeclas . concat(CodeASCIILettersUpper, CodeASCIILettersLower);

	} else {
		if (LettersUpper[0]) {
			arrayTeclas = arrayTeclas . concat(CodeASCIILettersUpper);
		} else {
			if (LettersUpper[1]) {
				for (i = 1; i < PermLettersUpper . length; i++) {
			 		if (PermLettersLower[i]) {
						arrayTeclas . push(CodeASCIILettersUpper[i]);
				    }
			 	}
			}
		}
		if (LettersLower[0]) {
			arrayTeclas = arrayTeclas . concat(CodeASCIILettersLower);
		} else {
			if (LettersLower[1]) {
				for (i = 0; i < PermLettersLower . length; i++) {
			 		if (PermLettersLower[i]) {
						arrayTeclas . push(CodeASCIILettersLower[i]);
				    }
			 	}
			}
		}
	}

	teclasPermitidas = arrayTeclas;
	// alert(teclasPermitidas . valueOf());
	//  PERCORRE O ARRAY PROCURANDO A TECLA PRESSIONADA
	for (var i = 0; i < teclasPermitidas . length; i++) {
		if (charCode == teclasPermitidas[i]) {
			//  RETORNA VERDADEIRO SE ACHOU
			return true;
		}
	}
	// RETORNA FALSO SE NÃO ACHOU
    return false;
}

function setTabIndex(objForm)
{
    if (typeof objForm != 'object') {
        return false;
    }
    var tabIndex = 0;
	var j = Math.floor(Math.random()*1000);
    for (var i = 0; i < objForm . elements . length; i++) {
        obj = objForm . elements[i];
		if((obj . type != 'hidden') && (obj . type != 'fieldset')){
			tabIndex = obj . name;
        	obj . tabIndex = (j + 1 + i);
		}
    }
}

function invertTabIndex(objForm)
{
    for (var i = 0, j = objForm . elements . length; i < objForm . elements . length; i++, j--) {
        objForm . elements[i] . tabIndex = j;
    }
}
