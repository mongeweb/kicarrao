var XMLHttpClass = {
    XMLHttpObj : null
    , mutableProperties : ['method', 'execute', 'element', 'elementObj', 'requestFile', 'vars', 'onLoading', 'onLoaded', 'onInteractive', 'onCompletion', 'onError', 'onFail']
    
    , resetData : function (i)
    {
        i = typeof(i) != 'undefined' ? i : -1;

        if (i != -1) {
            this . method[i] = 'POST';
            this . URLString[i] = '';
            this . encodeURIString[i] = true;
            this . execute[i] = false;
            this . element[i] = null;
            this . elementObj[i] = null;
            this . requestFile[i] = '';
            this . vars[i] = new Object();
            this . response[i] = '';
            this . responseXML[i] = '';
            this . responseStatus[i] = new Array(2);
        } else {
            this . method = new Array();
            this . URLString = new Array();
            this . encodeURIString = new Array();
            this . execute = new Array();
            this . element = new Array();
            this . elementObj = new Array();
            this . requestFile = new Array();
            this . vars = new Array();
            this . response = new Array();
            this . responseXML = new Array();
            this . responseStatus = new Array();
            
            this . queryStringSeparator = '?';
            this . argumentSeparator = '&';

            this . qtdRequests = 0;
        }
    }

	, resetFunctions : function(i) {
        i = typeof(i) != 'undefined' ? i : -1;

        if (i != -1) {
            this . onLoading[i] = function() { };
      		this . onLoaded[i] = function() { };
      		this . onInteractive[i] = function() { };
      		this . onCompletion[i] = function() { };
      		this . onError[i] = function() { };
    		this . onFail[i] = function() { };
        } else {
            this . onLoading = new Array();
      		this . onLoaded = new Array();
      		this . onInteractive = new Array();
      		this . onCompletion = new Array();
      		this . onError = new Array();
    		this . onFail = new Array();
        }
    }
    
    , reset : function ()
    {
//        var e = document . getElementById('status');
//        e . innerHTML += '<p>reset</p>';

        this . resetFunctions();
        this . resetData();
    }
	
	, getXMLHttpObj : function ()
	{
        if (this . XMLHttpObj == null) {
            var axO = ['Microsoft.XMLHTTP', 'Msxml2.XMLHTTP', 'Msxml2.XMLHTTP.6.0', 'Msxml2.XMLHTTP.4.0', 'Msxml2.XMLHTTP.3.0'];
    	    for (var i = 0; i < axO . length; i++) {
    	        try {
    	            this . XMLHttpObj = new ActiveXObject(axO[i]);
    	        }
    	        catch (e) {
                    this . XMLHttpObj = null;
    	        }
    	    }
    
            if (!this . XMLHttpObj) {
                if (typeof XMLHttpRequest != 'undefined') {
                    this . XMLHttpObj = new XMLHttpRequest();
                } else {
                    this . failed = true;
                }
            }
    	}
        return this . XMLHttpObj;
    }

    , encVar : function (name, value, returnvars)
    {
        if (true == returnvars) {
            return Array(encodeURIComponent(name), encodeURIComponent(value));
        } else {
            this . vars[this . qtdRequests][encodeURIComponent(name)] = Array(encodeURIComponent(value), true);
        }
    }

    , processURLString : function (string, encode)
    {
        encoded = encodeURIComponent(this . argumentSeparator);
        regexp = new RegExp(this . argumentSeparator + "|" + encoded);
        varArray = string . split(regexp);
        for (i = 0; i < varArray . length; i++) {
            urlVars = varArray[i] . split("=");
            if (true == encode) {
                this . encVar(urlVars[0], urlVars[1]);
            } else {
                this . setVar(urlVars[0], urlVars[1]);
            }
        }
    }

    , createURLString : function (urlstring)
    {
        if (this . encodeURIString[this . qtdRequests] && this . URLString[this . qtdRequests] . length) {
            this . processURLString(this . URLString[this . qtdRequests], true);
        }

        if (urlstring) {
            if (this . URLString[this . qtdRequests] . length) {
                this . URLString[this . qtdRequests] += this . argumentSeparator + urlstring;
            } else {
                this . URLString[this . qtdRequests] = urlstring;
            }
        }

        // prevents caching of URLString
        this . vars[this . qtdRequests]['rndval'] = Array(new Date() . getTime(), true);
        //alert(this . vars[this . qtdRequests]['rndval']);
        //this . setVar("rndval", new Date() . getTime());

        urlstringtemp = new Array();
        for (key in this . vars[this . qtdRequests]) {
            if (false == this . vars[this . qtdRequests][key][1] && true == this . encodeURIString[this . qtdRequests]) {
                encoded = this . encVar(key, this . vars[this . qtdRequests][key][0], true);
                delete this . vars[key];
                this . vars[this . qtdRequests][encoded[0]] = Array(encoded[1], true);
                key = encoded[0];
            }

            urlstringtemp[urlstringtemp . length] = key + "=" + this . vars[this . qtdRequests][key][0];
        }
        if (urlstring) {
            this . URLString[this . qtdRequests] += this . argumentSeparator + urlstringtemp . join(this . argumentSeparator);
        } else {
            this . URLString[this . qtdRequests] += urlstringtemp . join(this . argumentSeparator);
        }
    }
    
    , next : function (urlstring) {
        this . qtdRequests++;
        if (this . qtdRequests < this . method . length) {
            this . Execute(urlstring);
            //setTimeout(elementName + ' . Execute(' + urlstring + ');', 20);
        }
    }

    , runResponse : function ()
    {
        eval(this . response[this . qtdRequests]);
    }

	, requestHTTP : function (arrParams)
    {
        var e = document . getElementById('status');
        var indice = this . method . length;
        
        this . resetData(indice);
        this . resetFunctions(indice);

        for (param in arrParams) {
            for (propertie in this . mutableProperties) {
                if (param == this . mutableProperties[propertie]) {
                    eval('this . ' + param + '[indice] = arrParams[param];');
//                    e . innerHTML += '<p>' + param + ': ' + arrParams[param] + '</p>';
                }
            }
            
        }
//        e . innerHTML += '<hr />';
//        for (propertie in this . mutableProperties) {
//            e . innerHTML += '<p>XMLHttpClass . ' + this . mutableProperties[propertie] + ' = ' + XMLHttpClass[this . mutableProperties[propertie]] + ';</p>';
//        }
        
        if ((this . qtdRequests + 1) == this . method . length) {
            this . Execute();
        }
	}

    , Execute : function(urlstring)
    {
        this . getXMLHttpObj();
        
        if (this . failed) {
            this . onFail[this . qtdRequests]();
        } else {
            this . createURLString(urlstring);
            if (this . element[this . qtdRequests]) {
                this . elementObj[this . qtdRequests] = document . getElementById(this . element[this . qtdRequests]);
            }
            if (this . getXMLHttpObj()) {
                var self = this;
                if (this . method[this . qtdRequests] == 'GET') {
                    totalurlstring = this . requestFile[this . qtdRequests] + this . queryStringSeparator + this . URLString[this . qtdRequests];
                    this . getXMLHttpObj() . open(this . method[this . qtdRequests], totalurlstring, true);
                } else {
                    this . getXMLHttpObj() . open(this . method[this . qtdRequests], this . requestFile[this . qtdRequests], true);
                    try {
                        this . getXMLHttpObj() . setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    }
                    catch (e) {
                    }
                }

                this . getXMLHttpObj() . onreadystatechange = function ()
                {
                    switch (self . getXMLHttpObj() . readyState) {
                        case 1:
                            self . onLoading[self . qtdRequests]();
                            break;
                        case 2:
                            self . onLoaded[self . qtdRequests]();
                            break;
                        case 3:
                            self . onInteractive[self . qtdRequests]();
                            break;
                        case 4:
                            self . response[self . qtdRequests] = self . getXMLHttpObj() . responseText;
                            self . responseXML[self . qtdRequests] = self . getXMLHttpObj() . responseXML;
                            self . responseStatus[self . qtdRequests][0] = self . getXMLHttpObj() . status;
                            self . responseStatus[self . qtdRequests][1] = self . getXMLHttpObj() . statusText;

                            if (self . execute[self . qtdRequests]) {
                                self . runResponse();
                            }

                            if (self . elementObj[self . qtdRequests]) {
                                elemNodeName = self . elementObj[self . qtdRequests] . nodeName;
                                elemNodeName . toLowerCase();
                                if (elemNodeName == "input" || elemNodeName == "select" || elemNodeName == "option" || elemNodeName == "textarea") {
                                    self . elementObj[self . qtdRequests] . value = self . response[self . qtdRequests];
                                } else {
                                    self . elementObj[self . qtdRequests] . innerHTML = self . response[self . qtdRequests];
                                }
                            }
                            if (self . responseStatus[self . qtdRequests][0] == "200") {
                                self . onCompletion[self . qtdRequests]();
                            } else {
                                self . onError[self . qtdRequests]();
                            }

                            self . URLString[self . qtdRequests] = "";
                            self . next(urlstring);
                            break;
                    }
                };

                this . getXMLHttpObj() . send(this . URLString[this . qtdRequests]);
            }
        }
    }
};

// reseto as propriedades
XMLHttpClass . reset();

function whenLoading()
{
    var e = document . getElementById('status');
    if (e) {
        e . innerHTML += '<p>Sending Data...</p>';
    } else {
        alert('Element: status is undefined!');
    }
}

function whenLoaded()
{
    var e = document . getElementById('status');
    if (e) {
        e . innerHTML += '<p>Data Sent...</p>';
    } else {
        alert('Element: status is undefined!');
    }
}

function whenInteractive()
{
    var e = document . getElementById('status');
    if (e) {
        e . innerHTML += '<p>getting data...</p>';
    } else {
        alert('Element: status is undefined!');
    }
}

function whenCompleted()
{
    var e = document . getElementById('status');
    if (e) {
        if (XMLHttpClass . responseStatus[XMLHttpClass . qtdRequests]) {
            var string = '<p>Status Code: ' + XMLHttpClass . responseStatus[XMLHttpClass . qtdRequests][0] + '</p><p>Status Message: ' + XMLHttpClass . responseStatus[XMLHttpClass . qtdRequests][1] + '</p><p>URLString Sent: ' + XMLHttpClass . URLString[XMLHttpClass . qtdRequests] + '</p><p>Response: ' + XMLHttpClass . response[XMLHttpClass . qtdRequests] + '</p><hr />';
        } else {
            var string = '<p>URLString Sent: ' + XMLHttpClass . URLString[XMLHttpClass . qtdRequests] + '</p>';
        }
        e . innerHTML += string;
    } else {
        alert('Element: status is undefined!');
    }
}

function whenError()
{
    var e = document . getElementById('status');
    if (e) {
        e . innerHTML += '<p>Error...</p>';
    } else {
        alert('Element: status is undefined!');
    }
}

function whenFail()
{
    var e = document . getElementById('status');
    if (e) {
        e . innerHTML += '<p>Erro ao instanciar objeto Ajax...</p>';
    } else {
        alert('Element: status is undefined!');
    }
}