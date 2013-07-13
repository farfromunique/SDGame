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

// require MySQL Sessions
require 'components/connections.php';

// Set Time-based Variables
{
$t=time(); // Current Time
$u=$t;
$tf = date('Y-m-d g:i A',$t); // Time, Formatted (in server TZ) (To be dislayed)
$tu = date('Y-m-d G:i:s',$t); // Time, Formatted (in server TZ) (For the update process)
$tfOld = "'" . date('Y-m-d G:i:s',$t-86400) . "'"; // Time minus 1 day, formatted. For use in pulling conversations.
if (isset($_SESSION["TZ"])) // If the user has set a TimeZone
{
	$tz=date_create(date('Y-m-d g:i:s',$t),timezone_open($_SESSION["TZ"])); // Timezone
	$t=$t+date_offset_get($tz); // Time, modified to be accurate to Timezone
	$tf = date('Y-m-d g:i A',$t); // Time, Formatted (in User TZ) (to be displayed)	
}
$tzOffset=($u-$t); // Number of seconds difference from server (UTC) to user
}

// Set Other Variabls
{
$currentChar = $_SESSION["CharUID"];
//   Is User a GM?
{
$GMTest = explode("-",$_SESSION["CharName"]);
if($GMTest[0] == "GM")
{
	$_SESSION["IsGM"] = True;
}}}

// Set Query Strings
{
$charsHereStr=	"SELECT UID, Name, Rank FROM Character_Details WHERE Current_Location_W = " . $_SESSION["CurrLoc"];
$locationStr=	"SELECT LocationName_W FROM Locations WHERE UID = " . $_SESSION["CurrLoc"];
$allCharsStr=	"SELECT `Character_Details`.`UID`, `Character_Details`.`Name`, 
				  `Character_Details`.`Rank`, `Locations`.`LocationName_W` AS `Location`, `Locations`.`UID` AS `LocUID`
			FROM `Character_Details` JOIN `Locations` ON `Character_Details`.`Current_Location_W`=`Locations`.`UID`
			ORDER BY `Locations`.`UID` ASC";

// "Every Page" queries
$charsHere = mysqli_query($con,$charsHereStr);
$location = mysqli_query($con,$locationStr);
}

// Link CSS and JS files
{
?>
<html>
	<head>
		<link rel='stylesheet' type='text/css' href='basic.css'>
		<script src='basic.js'></script>
		<title>Sweet Dreams: Online</title>
	</head>
	<body>
<?php
}
// Build page layout
{
		require 'components/ImportantStuff.php';

		require 'components/register.php';

		require 'components/navbar.php';

		require 'components/whoishere.php';
}
?>
