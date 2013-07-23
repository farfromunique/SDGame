<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

session_start();

require 'components/connections.php';

$XP_Cost = $_POST["XP_Cost"];
$PowerUID = $_POST["PowerUID"];

// Update XP
$XP_Update_Str = "UPDATE Character_Details SET XP_Current=(XP_Current - " . $XP_Cost . ") WHERE UID = " . $_SESSION["CharUID"];
if (!$XP_Update = mysqli_query($ud,$XP_Update_Str))
{
	die("Error in XP Update! <a href=javascript:history.back>back up</a>");
}

// Add Power to Link Table
$PowerTableUpdateStr = "INSERT INTO PowersLink(CharUID, PowerUID) VALUES (" . $_SESSION['CharUID'] . ", " . $PowerUID . ")";
if (!$PowerTableUpdate = mysqli_query($ud,$PowerTableUpdateStr))
{
	die("Error in PowersLink Insert! <a href=javascript:history.back>back up</a>");
}

// Return to buyPowers2.php
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'buyPowers2.php';
header("Location: http://$host$uri/$extra");
exit;
?>
