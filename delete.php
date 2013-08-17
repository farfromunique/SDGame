<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'converse.php';
session_start();

if (!$_SESSION["IsGM"] or !isset($_REQUEST["Type"]))
{
	header("Location: http://$host$uri/$extra");
	exit;
}

require 'connections.php';

if ($_REQUEST["Type"] == "comment")
{
	$DelQry = "DELETE FROM Conversations WHERE UID = '" . $_REQUEST["UID"] . "'";
	if (!$Del = mysqli_query($ud,$DelQry))
	{
		die('Bad query: ' . $DelQry);
	}
}

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'index.php';
header("Location: http://$host$uri/$extra");
exit;
?>