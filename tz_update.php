<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

session_start();

require 'connections.php';

$SetTZ = $_REQUEST["TZ"];

$GetLoginUID = "SELECT UID FROM Logins WHERE CharUID = " . $_SESSION["CharUID"];
$GetUID = mysqli_query($ud,$GetLoginUID);

while ($MyUID=mysqli_fetch_array($GetUID))
{
	$LoginUID=$MyUID['UID'];
}
$SetLoginTZ = "UPDATE Logins SET TimeZone='" . $_REQUEST["TZ"] . "' WHERE UID = " . $LoginUID;

$SetMyTZ = mysqli_query($ud,$SetLoginTZ);

$_SESSION["TZ"] = $SetTZ;
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
header("Location: http://$host$uri/");
exit;

?>