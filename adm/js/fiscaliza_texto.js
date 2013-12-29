
var flagbotaoctrl = 0;
function desabilitaMenu(e)
{
	if(flagbotaoctrl == 0)
	{
	
	
	if (window.Event)
	{
	if (e.which == 2 || e.which == 3 || e.which == 1)
	return false;
	}
	else
	{
	event.cancelBubble = true
	event.returnValue = false;
	return false;
	}
	}
}

//desabilita botão direito
function desabilitaBotaoDireito(e)
{
if(flagbotaoctrl == 0)
{
	if (window.Event)
	{
	if (e.which == 2 || e.which == 3)
	return false;
	}
	else
	if (event.button == 2 || event.button == 3)
	{
	event.cancelBubble = true
	event.returnValue = false;
	return false;
	}
}
}

//ESSAS SERÃO AS TECLAS DESABILITADAS
var msg = 'Função desabilitada';
var asciiF5 = 17; // CTRL

if(flagbotaoctrl == 0)
{

	if(document.all){ //ie has to block in the key down
	document.onkeydown = onKeyPress;
	}else if (document.layers || document.getElementById){ //NS and mozilla have to block in the key press
	document.onkeypress = onKeyPress;
	}
}

function onKeyPress(evt) 
{
if(flagbotaoctrl == 0)
{
	window.status = '';
	
	var oEvent = (window.event) ? window.event : evt;
	
	
	var nKeyCode = oEvent.keyCode ? oEvent.keyCode : oEvent.which ? oEvent.which : void 0;
	var bIsFunctionKey = false;
	
	if(oEvent.charCode == null || oEvent.charCode == 0)
	{
	f5button = (nKeyCode == asciiF5)
	
	}
	
	var sChar = String.fromCharCode(nKeyCode).toUpperCase();
	
	
	var oTarget = (oEvent.target) ? oEvent.target : oEvent.srcElement;
	var sTag = oTarget.tagName.toLowerCase();
	var sTagType = oTarget.getAttribute("type");
	var bAltPressed = (oEvent.altKey) ? oEvent.altKey : oEvent.modifiers & 1 > 0;
	
	var bRet = true;
	
	if(sTagType != null){sTagType = sTagType.toLowerCase();}
	
	
	if(f5button){
	bRet = false;
	}
	if(!bRet){
	try{
	oEvent.returnValue = false;
	oEvent.cancelBubble = true;
	
	if(document.all){
	oEvent.keyCode = 0;
	}else{
	oEvent.preventDefault();
	oEvent.stopPropagation();
	}
	
	
	alert(msg);
	}catch(ex){
	alert(msg);
	
	}
	}
	return bRet;
}
}
// - Desabilita o Botão direito do mouse
function desabilitar()
{

return false
}
//document.oncontextmenu=desabilitar 
///////////////////

if(flagbotaoctrl == 0)
{
	//desabilita botão direito do mouse
	if ( window.Event )
	document.captureEvents(Event.MOUSEUP);
	if ( document.layers )
	document.captureEvents(Event.MOUSEDOWN);
	
	document.oncontextmenu = desabilitaMenu;
	document.onmousedown = desabilitaBotaoDireito;
	document.onmouseup = desabilitaBotaoDireito;
}
