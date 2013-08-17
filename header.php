<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

// Initialize $_SESSION
session_start();
$d_root = './';

// require MySQL Sessions
require_once ('connections.php');

// Set Time-based Variables

require_once ('time.php');

$currentChar = $_SESSION["CharUID"];

$GMTest = explode("-",$_SESSION["CharName"]);
$_SESSION["IsGM"] = ($GMTest[0] == "GM");
// Set Query Strings
{
$locationStr=	"SELECT LocationName_W FROM Locations WHERE UID = " . $_SESSION["CurrLoc"];
$allCharsStr=	"SELECT `Character_Details`.`UID`, `Character_Details`.`Name`, 
				  `Character_Details`.`Rank`, `Locations`.`LocationName_W` AS `Location`, `Locations`.`UID` AS `LocUID`
			FROM `Character_Details` JOIN `Locations` ON `Character_Details`.`Current_Location_W`=`Locations`.`UID`
			ORDER BY `Locations`.`UID` ASC";

// "Every Page" queries
$location = mysqli_query($con,$locationStr);
}

// Link CSS and JS files



?>
<html>
	<head>
		<link rel='stylesheet' type='text/css' href='http://game.acwpd.com/basic.css'>
		<script src='http://game.acwpd.com/basic.js' type='text/javascript'></script>
		<script src='http://game.acwpd.com/ajax.js' type='text/javascript'></script>
		<title>Sweet Dreams: Online</title>
	</head>
	<body>
<?php
// Build page layout
	require_once ('ImportantStuff.php');

	require_once ('register.php');

	require_once ('navbar.php');
	
	echo '<div class=\'whoishere\' id=\'whoishere\'>';
	require_once ('whoishere.php');
	echo '</div>';
?>