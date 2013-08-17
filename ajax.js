var sRoot = "http://game.acwpd.com/";
function loadMyPage(pageName,displayURL,targetDiv)
{
	document.getElementById("main").innerHTML = "Loading ...";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET",sRoot + pageName,true);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4)
			{
				document.getElementById(targetDiv).innerHTML = xmlhttp.responseText;
			}
		};
	xmlhttp.send(null);
	window.history.pushState({site:"Sweet Dreams Online"},"","/" + displayURL + "/");
}

function postToPage(pageName,postData,displayURL)
{
	document.getElementById("main").innerHTML = "Loading ...";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST",sRoot + pageName, true);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4)
			{
				document.getElementById("main").innerHTML = xmlhttp.responseText;
			}
		};
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(postData);
	window.history.pushState({site:"Sweet Dreams Online"},"","/" + displayURL + "/");
}

function postAndRedirect(pageName,postData,redirectTo,displayURL)
{
	document.getElementById("main").innerHTML = "Loading ...";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST",sRoot + pageName, true);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4)
			{
				loadMyPage(redirectTo,displayURL,'main');
			}
		};
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(postData);
	window.history.pushState({site:"Sweet Dreams Online"},"","/" + displayURL + "/");
}

function chat()
{
	var params;
	params = "UD_type=Converse&Comm=" + document.getElementById('message').value;
	postToPage('converse.php',params);
	window.history.pushState({site:"Sweet Dreams Online"},"","/chat/");
	return;
}

function getChat()
{
	loadMyPage('converse.php','chat','main');
}

function typeChat(e)
{
	if (e.keycode == 13 || event.which == 13)
	{
		chat();
		return false;
	}
	return true;
}

function removeRecord(uid)
{
	var params;
	params = "Type=comment&UID=" + uid;
	postAndRedirect('delete.php',params,'converse.php','chat');
}

function timezone()
{
	loadMyPage('TZChoice.php','timezone','main');
}

function powers()
{
	loadMyPage('buyPowers.php','powers','main');
}

function character()
{
	loadMyPage('newchar.php','character','main');
}

function insert()
{
	loadMyPage('insert.php','insert','main');
}

function whoIsHere()
{
	loadMyPage('whoishere.php','','whoishere');
}

function goto(location,text)
{
	var params = 'Loc='+location;
	document.getElementById('CurrLoc').innerHTML = text;
	postAndRedirect('goto.php',params,'converse.php','goto/'+location);
	
}

function tzset()
{
	var params;
	var TZs = document.getElementsByName('TZ');
	for (var i = 0; i<TZs.length;i++)
	{
		if (TZs[i].checked)
		{
			params = 'TZ=' + TZs[i].value;
		}
	}
	postAndRedirect('tz_update.php',params,'converse.php','chat');
}
document.addEventListener('DOMContentLoaded',function(){
	document.getElementById('chat').onclick = function() { getChat(); };
	document.getElementById('timezone').onclick = function() { timezone(); };
	document.getElementById('character').onclick = function() { character(); };
	document.getElementById('powers').onclick = function() { powers(); };
	
	var gotos = document.getElementsByClassName('goto');
	for (var i=0;i<gotos.length;i++)
	{
		gotos[i].onclick = function()
		{
			var num = this.id;
			var useNum = num.replace("goto","");
			goto(useNum,this.innerHTML);
			whoIsHere();
		};
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
	
	if (document.getElementById('ImpDismiss'))
	{
		document.getElementById('ImpDismiss').onclick = function() { DismissImportant(); };
	}
});

function powerBuy(PowerUID,XPCost)
{
	var params;
	var SpecName = "SpecificsFor" + PowerUID;
	
	params = "PowerUID=" + PowerUID + "&XP_Cost=" + XPCost;
	if (document.getElementById(SpecName)) 
	{
		params = params + "&Details=" & window[SpecName];
	}
	postAndRedirect('buyPowers2.php',params,'buyPowers.php','powers');
}