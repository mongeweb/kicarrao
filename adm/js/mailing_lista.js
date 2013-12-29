Event . add(window, 'load', function()
{
	if (!document.getElementById) {
		return false;
	}
	objForm = document . getElementById('cadastro');

	objSelAll = document . getElementById('selAll');
	objSpanCheckar = document . getElementById('checkar');
	objBtnGerarCsv = document . getElementById('gerarCsv');

	objSituacao = objForm . situacao;

    /** Usado para dar tempo de incluir os arquivos **/
    //setTimeout('setProperties();', 1000);
    setProperties();
});

/** Usado para dar tempo de incluir os arquivos **/
function setProperties()
{
	objSelAll . click();
	objSelAll . onclick = function()
	{
		CheckAll(objForm, objSelAll, objSpanCheckar);
	}
    objSelAll . click();
    
    if (objBtnGerarCsv)
    {
        objBtnGerarCsv . onclick = gerarCsv;
    }
}

function gerarCsv(requestFile)
{
    var requestFile = typeof(requestFile) != "undefined" ? requestFile : 'mailing/mailingGravaCsv.php';

    xmlFunc = new Array();
    xmlFunc['requestFile'] = 'mailing/mailingGravaCsv.php';
    xmlFunc['method'] = 'POST';

    xmlFunc['onError'] = function()
    {
//whenCompleted();
        var e = document . getElementById('status');
        if (e) {
            e . innerHTML += 'Error!<hr />';
        } else {
            alert('Element: status is undefined!');
        }
    }

	var texto = '';
    var code = 'xmlFunc["vars"] = {\n';
    var codes = 0;
    for (var i = 0; i < objForm . elements . length; i++) {
        var x = objForm . elements[i];
        if((x . type == 'checkbox') && (x . checked) && (x . id != objSelAll . id)) {
            codes++;
            if (codes > 1) {
                code += ', ';
            }
            code += '"id' + i + '" : Array("' + x . value + '", false)\n';
        	texto += (texto . indexOf('?') >= 0) ? '&' : texto += '?';
			texto += ('id' + i + '=' + x . value);
      	}
    }
    code += '};';
//            alert(code);
    eval(code);

    xmlFunc['onCompletion'] = function()
    {
//                whenCompleted();
//                var e = document . getElementById('response');
//                if (XMLHttpClass . responseStatus[XMLHttpClass . qtdRequests]) {
//                    var string = 'Mensagem: ' + XMLHttpClass . response[XMLHttpClass . qtdRequests] + '';
//                } else {
//                    var string = '<p>URLString Sent: ' + XMLHttpClass . URLString[XMLHttpClass . qtdRequests] + '</p>';
//                }
//                e . innerHTML = string;

        OpenWindow('mailing/mailingGeralista.php');

    }
    if (codes > 0) {
    	XMLHttpClass . requestHTTP(xmlFunc);
    } else {
        alert('Selecione um nome na lista.');
        //location . reload(true); //return url;
    }
}