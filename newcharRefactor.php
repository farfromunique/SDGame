<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

require 'components/header.php';
?>
<style>
  .important {
		display:none;
	}
	.register {
		display:none;
	}
	.whoshere {
		display:none;
	}
</style>
<?php
$User = array();
$User['Name'] = $_POST["Uname"];
$User['Pass'] = md5($_POST["Pword"]);
$User['AuthCode'] = $_POST["Auth"];

$Character = array();
$Character['Name'] = $_POST["Cname"];
$Character['Age'] = $_POST["Age"];
$Character['Gender'] = $_POST["Gender"];
$Character['Height'] = $_POST["Height"];
$Character['Skin'] = $_POST["Skin"];
$Character['Eyes'] = $_POST["Eyes"];
$Character['Hair'] = $_POST["Hair"];
$Character['Marks'] = $_POST["DistinguishingMarks"];
$Character['UID'] = $_SESSION["CharUID"];
$Character['Location'] = $_SESSION["CurrLoc"];

//Height Categories
// 'very short (<120)','short (<168)','average height(<185)','tall(<200)','very tall(>=200)','monstrous (not currently set)'
if ($Character['Height'] < 120) {$Character['HeightCategory'] = ' very short';}
else if ($Character['Height'] < 168) {$Character['HeightCategory'] = ' short';}
else if ($Character['Height'] < 185) {$Character['HeightCategory'] = 'n average height';}
else if ($Character['Height'] < 200) {$Character['HeightCategory'] = ' tall';}
else {$Character['HeightCategory'] = ' very tall';}

$UpdateQry="UPDATE Character_Details 
	SET Age = '" . $Character['Age'] . "', 
	    Gender = '" . $Character['Genger'] . "', 
	    Height = '" . $Character['Height'] . "', 
	    Skin = '" . $Character['Skin'] . "', 
	    Eyes = '" . $Character['Eyes'] . "', 
	    Hair = '" . $Character['Hair'] . "', 
	    Distinguishing_Marks = '" . $Character['Marks'] . "', 
	    Height_Category = '" . $Character['HeightCategory'] . "' 
	WHERE UID = " . $Character['UID'];



switch ($Character['Genger'])
{
	case "M":
		$Character['Genger']=array($Character['Genger'],"Male","guy","dude","He","His");
		break;
	case "F":
		$Character['Genger']=array($Character['Genger'],"Female","gal","chick","She","Her");
		break;
	case "Other":
		$Character['Genger']=array($Character['Genger'],"Individual","person","person",$row['Name'],"Their");
		break;
	default:
		die("Error! " . $Character['Genger']);
}

