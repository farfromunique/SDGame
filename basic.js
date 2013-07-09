function Collapse_Power(id)
{
  b_id = "more_" + id;
	a_id = "less_" + id;
	document.getElementById(id).style.display='none';
	document.getElementById(a_id).style.display='none';
	document.getElementById(b_id).style.display='inline';
}

function Expand_Power(id)
{
	a_id = "more_" + id;
	b_id = "less_" + id;
	document.getElementById(id).style.display='block';
	document.getElementById(a_id).style.display='none';
	document.getElementById(b_id).style.display='inline';
}

function ShowCharUpdate()
{
	document.getElementById('updateChar').style.display='inline';
}

function DismissImportant()
{
	document.getElementById('Important').style.display='none';
}

function hideMessage()
{
	document.getElementById('Message').style.display='none';
}

function hideAllHidden()
{
	for (i=0;i<document.getElementsByClassName("hidden").length;i++)
	{
		document.getElementsByClassName("hidden")[i].style.display='none';
	}
}

function SpendReview()
{
	document.getElementById('SpendReview').style.display='block';
	document.getElementById('SpendBuyNew').style.display='none';
	document.getElementById('SpendUpgrade').style.display='none';
}

function SpendNewPower()
{
	document.getElementById('SpendReview').style.display='none';
	document.getElementById('SpendBuyNew').style.display='block';
	document.getElementById('SpendUpgrade').style.display='none';
}

function SpendUpgrade()
{
	document.getElementById('SpendReview').style.display='none';
	document.getElementById('SpendBuyNew').style.display='none';
	document.getElementById('SpendUpgrade').style.display='block';
}

function upgradeThis(passed)
{
	document.getElementById("secondUpgrade").innerHTML=JSON.parse(passed);
	document.getElementById("secondUpgrade").style.display='block';
}

function buyThis(passed)
{
	var PowerIndex = document.getElementById('availiablePowers').selectedIndex - 1;
	var pwr = window['AllPower' + PowerIndex][3] + "<br />";
	pwr = pwr + "<b>XP Cost:</b> " + window['AllPower' + PowerIndex][5];
	pwr = pwr + "<br /><br /><a href='#' onClick='buySelected(" + PowerIndex + ");'>Buy This Power</a>";
	document.getElementById("secondBuyNew").innerHTML=pwr;
	document.getElementById("secondBuyNew").style.display='block';
	document.getElementById("thirdBuyNew").style.display='none';
}

function upgradeList(passed)
{
	var PowerArray = [];
	var DetailPowerID = [];
	var EscapedPowerID = [];
	PowerArray.push([]);
	PowerArray = window[passed];
	var OutputThing="";
	for (i=0;i<PowerArray.length;i++)
	{
		DetailPowerID[i] = 'detail' + PowerArray[i][0];
	}
	
	for (i=0;i<PowerArray.length;i++)
	{
		OutputThing = OutputThing + "<br><a href='#' onClick='showUpgradeDetails(" + PowerArray[i][0] + ")'>" + PowerArray[i][2] + "</a><div class='hidden' id='" + DetailPowerID[i] + "'>" + PowerArray[i][3] + "</div>";
	}
	document.getElementById("secondUpgrade").innerHTML=OutputThing;
	document.getElementById("secondUpgrade").style.display='block';
}

function showUpgradeDetails(div_id)
{
	hideAllHidden();
	document.getElementById('secondUpgrade').style.display='block';
	document.getElementById('detail' + div_id).style.display='block';
}

function chooseToUpgrade(passed,id)
{
	hideAllHidden();
	var PowerArray = [];
	var BuyPowerID = [];
	PowerArray.push([]);
	PowerArray = window[passed];
	var OutputThing="";
	for (i=0;i<PowerArray.length;i++)
	{
		BuyPowerID[i] = "Buy" + PowerArray[i][0];
	}
	
	for (i=0;i<PowerArray.length;i++)
	{
		OutputThing = OutputThing + "<br>" + PowerArray[i][2] + "<div class='hidden' id='" + BuyPowerID[i] + "'>" + PowerArray[i][3] + "</div>";
	}
	document.getElementById('thirdUpgrade').style.display='block';
}

function buySelected(powerID)
{
	var myXP = document.getElementById("XP").innerHTML;
	var FormBuild = "<form action='buyPowers.php' method='POST'>";
	FormBuild = FormBuild + "<input type='hidden' name='PowerUID' value='" + window['AllPower' + powerID][0] + "'>";
	FormBuild = FormBuild + "<input type='hidden' name='XP_Cost' value='" + window['AllPower' + powerID][5] + "'>";
	var NotEnoughXP = "You do not have enough XP to afford this Power.";
	if (myXP >= window['AllPower' + powerID][5])
	{
		//FormBuild = FormBuild + EnoughXP;
		FormBuild = FormBuild + "<input type='submit' value='Buy it!'>";
	} else {
		//FormBuild = FormBuild + NotEnoughXP;
	}
	FormBuild = FormBuild + "</form>";
	document.getElementById("thirdBuyNew").innerHTML = FormBuild;
	document.getElementById("thirdBuyNew").style.display='inline';
}
