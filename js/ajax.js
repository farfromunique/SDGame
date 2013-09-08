var sRoot = "http://game.acwpd.com/OO/";
function loadMyPage(pageName,displayURL,targetDiv) {
    var ajax;
    document.getElementById("content").innerHTML = "Loading ...";
	ajax = new XMLHttpRequest();
	ajax.open("GET",sRoot + pageName,true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				document.getElementById(targetDiv).innerHTML = ajax.responseText;
			}
		};
	ajax.send(null);
	window.history.pushState({site:"Sweet Dreams Online"},"","/" + displayURL + "/");
}

function postToPage(pageName,postData,displayURL) {
	var xmlhttp;
    document.getElementById("content").innerHTML = "Loading ...";
	xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST",sRoot + pageName, true);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4)
			{
				document.getElementById("content").innerHTML = xmlhttp.responseText;
			}
		};
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(postData);
	window.history.pushState({site:"Sweet Dreams Online"},"","/" + displayURL + "/");
}

function postAndRedirect(pageName,postData,redirectTo,displayURL) {
	var xmlhttp;
    document.getElementById("content").innerHTML = "Loading ...";
	xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST",sRoot + pageName, true);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4)
			{
				loadMyPage(redirectTo,displayURL,'content');
			}
		};
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(postData);
	window.history.pushState({site:"Sweet Dreams Online"},"","/" + displayURL + "/");
}

function chat() {
	var params;
	params = "UD_type=Converse&Comm=" + document.getElementById('message').value;
	postToPage('converse.php',params);
	window.history.pushState({site:"Sweet Dreams Online"},"","/OO/chat/");
}

function getChat() {
	loadMyPage('converse.php','chat','content');
}

function typeChat(event) {
	if (event.which == 13)
	{
		chat();
		return false;
	}
	return true;
}

function removeRecord(uid) {
	var params;
	params = "Type=comment&UID=" + uid;
	postAndRedirect('delete.php',params,'converse.php','chat');
}

function timezone() {
	loadMyPage('TZChoice.php','timezone','content');
}

function powers() {
	loadMyPage('buyPowers.php','powers','content');
}

function character() {
	loadMyPage('newchar.php','character','content');
}

function insert() {
	loadMyPage('insert.php','insert','content');
}

function whoIsHere() {
	loadMyPage('whoishere.php','','whoishere');
}

function goto(location,text) {
	var params = 'Loc='+location;
	document.getElementById('CurrLoc').innerHTML = text;
	postAndRedirect('goto.php',params,'converse.php','goto/'+location);
	
}

function tzset() {
	var i;
    var params;
	var TZs = document.getElementsByName('TZ');
	for (i = 0; i<TZs.length;i++) {
		if (TZs[i].checked) {
			params = 'TZ=' + TZs[i].value;
		}
	}
	postAndRedirect('tz_update.php',params,'converse.php','chat');
}

function DismissImportant() {
	if (document.getElementById('Important')) {
	document.getElementById('Important').style.display='none';
	}
}

function hideMessage() {
	if(document.getElementById('Message')) {
		document.getElementById('Message').style.display='none';
	}
}

document.addEventListener('DOMContentLoaded',function() {
	var i;
    var gotos;
    if (document.getElementById('chat')) {
    document.getElementById('chat').onclick = function() { getChat(); };
    }
    if (document.getElementById('timezone')) {
	document.getElementById('timezone').onclick = function() { timezone(); };
    }
    if (document.getElementById('character')) {
	document.getElementById('character').onclick = function() { character(); };
    }
	if (document.getElementById('powers')) {
		document.getElementById('powers').onclick = function() { powers(); };
	}
	
	if (document.getElementById('insert'))
	{
		document.getElementById('insert').onclick = function() { insert(); };
	}
	
	if (document.getElementById('tzset'))
	{
		document.getElementById('tzset').onclick = function() { tzset(); };
	}
	
	if (document.getElementById('Imptimezone'))
	{
		document.getElementById('Imptimezone').onclick = function() { timezone(); };
	}
	
	if (document.getElementById('Important'))
	{
		document.getElementById('Important').onclick = function() { DismissImportant(); };
	}
	
	gotos = document.getElementsByClassName('goto');
	for (i=0;i<gotos.length;i++)
	{
		gotos[i].onclick = function()
		{
			var num = this.id;
			var useNum = num.replace("goto","");
			goto(useNum,this.innerHTML);
			whoIsHere();
		};
	}
});

function powerBuy(PowerUID,XPCost)
{
	var params;
	var SpecName = "SpecificsFor" + PowerUID;
	
	params = "PowerUID=" + PowerUID + "&XP_Cost=" + XPCost;
	if (document.getElementById(SpecName)) 
	{
		params += "&Details=" + window[SpecName];
	}
	postAndRedirect('buyPowers2.php',params,'buyPowers.php','powers');
}