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

$targetLoc = $_REQUEST["Loc"];

$currentLocationGetStr = "SELECT Current_Location_W FROM Character_Details WHERE UID = " . $_SESSION["CharUID"];
$currentLocationSetStr = "UPDATE Character_Details SET Current_Location_W='" . $_REQUEST["Loc"] . "' WHERE UID = " . $_SESSION["CharUID"];
$currentLocationName = "SELECT LocationName_W FROM Locations WHERE UID = " . $_REQUEST["Loc"];

$SetLoc = mysqli_query($ud,$currentLocationSetStr);
$GetLoc = mysqli_query($ud,$currentLocationGetStr);
$GetName = mysqli_query($ud,$currentLocationName);

while($row = mysqli_fetch_array($GetLoc))
{
	$_SESSION["CurrLoc"] = $row['Current_Location_W'];
}
while($row = mysqli_fetch_array($GetName))
{
	$_SESSION["CurrLocName"] = $row['LocationName_W'];
}

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'index.php';
header("Location: http://$host$uri/$extra");
exit;
?>
