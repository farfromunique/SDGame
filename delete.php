<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

session_start();

if (!$_SESSION["IsGM"] or !isset($_REQUEST["Type"]))
{
	header('Location: http://game.acwpd.com/');
}

require 'components/connections.php';

if ($_REQUEST["Type"] == "comment")
{
	$DelQry = "DELETE FROM Conversations WHERE UID = '" . $_REQUEST["UID"] . "'";
	if (!$Del = mysqli_query($ud,$DelQry))
	{
		die('Bad query: ' . $DelQry);
	}
}

header('Location: http://game.acwpd.com/');

require 'components/footer.php';
?>
