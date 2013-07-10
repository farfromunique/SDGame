<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

session_start();

$ud=mysqli_connect("database.db","username","password","Characters");

$targetLoc = $_REQUEST["Loc"];

$currentLocationGetStr = "SELECT Current_Location_W FROM Character_Details WHERE UID = " . $_SESSION["CharUID"];
$currentLocationSetStr = "UPDATE Character_Details SET Current_Location_W='" . $_REQUEST["Loc"] . "' WHERE UID = " . $_SESSION["CharUID"];

$SetLoc = mysqli_query($ud,$currentLocationSetStr);
$GetLoc = mysqli_query($ud,$currentLocationGetStr);

while($row = mysqli_fetch_array($GetLoc))
{
  $_SESSION["CurrLoc"] = $row['Current_Location_W'];
	mysqli_close($ud);
	header('Location: http://game.acwpd.com/');
}


?>
