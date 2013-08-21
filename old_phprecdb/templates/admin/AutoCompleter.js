var autoCompleters = new Array();
var indexCounter=0;
var serviceUrl='recordingWizardServer.php';

function getAutoCompleter(indexNr) {
	for(i=0;i<autoCompleters.length;i++)
 	{
  		if (autoCompleters[i].index==indexNr) {
  			return autoCompleters[i];
  		}
	}
	return null;
}

function AutoCompleter(type,inputObj,outputDiv,loadingDiv,dbStatusDiv) {
	var paramAutoCompleters = new Array();	
	this.effectedAutoCompleter = null;
	
	this.type=type;
	this.loadingDiv=loadingDiv;
	this.inputObj=inputObj;
	this.outputDiv=outputDiv;
	this.dbStatusDiv=dbStatusDiv;
	
	autoCompleters.push(this);
	this.index=indexCounter;
	indexCounter++;
	this.isFocused=false;
	
	this.OnFocusLost=function() {
		this.isFocused=false;
		this.outputDiv.innerHTML='';
		this.setLoadingState(false);
		this.checkAlreadyExistsState();
	}
	
	this.addParamAutoCompleter=function(paramAutoCompleter) {
		paramAutoCompleters.push(paramAutoCompleter);
	}
	
	this.setEffectedAutoCompleter=function(effectedAutoCompleter) {
		this.effectedAutoCompleter=effectedAutoCompleter;
	}

	this.request=function(url, paramStr, thisIndex, callback) {
        var xhr = false;
        if( window.XMLHttpRequest && ! window.ActiveXObject) {
                xhr = new XMLHttpRequest();
        } else if ( window.ActiveXObject ) {
                try {
                        xhr = new ActiveXObject("Msxml2.XMLHTTP");
                } catch(e) {
                        try {
                                xhr = new ActiveXObject("Microsoft.XMLHTTP");
                        } catch(e) {
                                xhr = false;
                        }
                }
        }
        if ( ! xhr ) {
                throw 'browser not ajax-capable';
        }
        xhr.onreadystatechange = function() {
                if( xhr.readyState == 4 && xhr.status == 200 ) {
                        callback(xhr,thisIndex);
                }
        };
        url += paramStr;
        xhr.open('GET', url, true);
        xhr.send(null);
	}

	this.setLoadingState=function (loadingState) {
		if (loadingState) {
			loadingStateHtml = "<img src='loading.gif' >";
		} else {
			loadingStateHtml='';
		}
		this.loadingDiv.innerHTML=loadingStateHtml;
	}
	
	this.suggest=function (value,event) { 
		if (this.isControlKeyEvent(event)) {
			this.executeControlKeyEvent(event);
			return;
		}
		paramStr=this.getParamStr(value);
		
		this.setLoadingState(true);
		this.request(serviceUrl, paramStr, this.index, function(xhr,indexNr) {
        	showProposals(xhr, indexNr)
		});
	}
	
	this.checkAlreadyExistsState=function () {
		value=this.inputObj.value;
		paramStr=this.getParamStr(value);
		this.request(serviceUrl, paramStr, this.index, function(xhr,indexNr) {
        	updateAlreadyExistsState(xhr, indexNr)
		});
	}
	
	this.getParamStr=function(value) {
			params = new Array();
			params.push(new Array('v',value)); //values
			params.push(new Array('t',this.type)); //type
			for(i=0;i<paramAutoCompleters.length;i++)
 			{
  				params.push(new Array(paramAutoCompleters[i].type,paramAutoCompleters[i].inputObj.value));
			}
			paramStr = '?';
 			for(i=0; i<params.length; i++) {
    			if(i>0)paramStr += '&';
    			paramStr += params[i][0]+'='+escape(params[i][1]);
  			}
			return paramStr;
	}
	
	this.isControlKeyEvent=function (event) {
		if((event.keyCode == 38)||(event.keyCode == 40)) return true
		else return false;
	}
	
	this.executeControlKeyEvent=function (event)
	{
		currentSelection=document.getElementById('selection'+this.index).selectedIndex;
		size=document.getElementById('selection'+this.index).options.length-1;
		
	    if(event.keyCode == 38 && currentSelection>0) //up
	    {
			document.getElementById('selection'+this.index).selectedIndex=currentSelection-1;
	    }
	
	    if(event.keyCode == 40 && currentSelection<size) //down
	    {
			document.getElementById('selection'+this.index).selectedIndex=currentSelection+1;
	    }
	}
	
	this.keydown=function (event) {
		this.isFocused=true;
		if(event.keyCode=='13') {
			if(event.preventDefault){ event.preventDefault(); } 
			
			//überprüfen ob ie läuft und "ende" taste auslösen, nötig um fokus im feld zu behalten
			if (window.navigator.userAgent.indexOf("MSIE ") > -1) {
				event.keyCode=35;
			}
			currentSelection=document.getElementById('selection'+this.index).selectedIndex;
			currentText=document.getElementById('selection'+this.index).options[currentSelection].text;
			this.inputObj.value=currentText;
			this.inpuFtObj.focus();
			setAlreadyExistsState(this.index,true);
		}
		if (!this.isControlKeyEvent(event)) {
			this.outputDiv.innerHTML='';
		}
	}
	
	this.onblur=function () {
  		this.checkAlreadyExistsState();
	}
}

function showProposals(xhr,indexNr) {
		thisAutoCompleter=getAutoCompleter(indexNr);
		thisAutoCompleter.setLoadingState(false);
		if (!thisAutoCompleter.isFocused) {
			return;
		}
		var output = ''; 
		text = xhr.responseText;
		autoCompleterVisible=false;
		if (text != "") {
			textPieces = text.split(";");			
			currentText=thisAutoCompleter.inputObj.value;
			alreadyExistsState=evaluateAlreadyExistsState(textPieces,currentText);
			
			if (alreadyExistsState&&(textPieces.length==1)) 
			{
				//vorgeschlagener text ist gleicher text der bereits in input steht
				//auswahlbox wird nicht angezeigt
			} else {
				autoCompleterVisible=true;
				output +='<select id="selection'+thisAutoCompleter.index+'" size="4" >';
				for (var teil in textPieces) {
					output +='<option>'+textPieces[teil]+'</option>';
				} 
				output +='</select>';
			}
		}
		thisAutoCompleter.outputDiv.innerHTML = output;
		setAlreadyExistsState(indexNr,alreadyExistsState);
		if (autoCompleterVisible && document.getElementById('selection'+thisAutoCompleter.index)!=null) {
			document.getElementById('selection'+thisAutoCompleter.index).selectedIndex=0;
		}
}

function updateAlreadyExistsState(xhr, indexNr) {
	thisAutoCompleter=getAutoCompleter(indexNr);
	text = xhr.responseText;
	alreadyExistsState=false;
	if (text != "") {
		textPieces = text.split(";");			
		currentText=thisAutoCompleter.inputObj.value;
		alreadyExistsState=evaluateAlreadyExistsState(textPieces,currentText);
	}
	setAlreadyExistsState(indexNr,alreadyExistsState);
	if (thisAutoCompleter.effectedAutoCompleter!=null) {
		thisAutoCompleter.effectedAutoCompleter.checkAlreadyExistsState();
	}
}

//prüfung ob wert currenttext schon in db vorhanden
//textPieces enthält alle vorschläge, ist ein array
function evaluateAlreadyExistsState(textPieces,currentText) {
	alreadyExistsState=false;
	for (var teil in textPieces) {
		if (currentText.toLowerCase()==textPieces[teil].toLowerCase()) {
			alreadyExistsState=true;
		}
	} 
	return alreadyExistsState;
}

function setAlreadyExistsState(indexNr,existsState) {
	thisAutoCompleter=getAutoCompleter(indexNr);
	output ='';
	if (thisAutoCompleter.inputObj.value.length>0 || thisAutoCompleter.outputDiv.innerHTML.length>0) {
		if (existsState) {
			output +='<font color=green>exist</font>'
		} else {
			output +='<font color=red>new</font>'
		}
	}
	thisAutoCompleter.dbStatusDiv.innerHTML =output;
}

function createXmlHttp() {
	if (window.ActiveXObject) {
		try {
			xmlHttpObj= new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				xmlHttpObj= new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
			}
		}
	} else if (window.XMLHttpRequest) {
		try {
			xmlHttpObj= new XMLHttpRequest();
		} catch (e) {
		}
	}
	return xmlHttpObj;
} 