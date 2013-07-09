<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

if ((!$_SESSION["TZ"]) and ($_SESSION["LoggedIn"]=="Yes"))
{
  echo "<div id='Important' class='dismissable''>
	Please take a moment to <a href='TZChoice.php'>set your timezone</a>. (<a href='javascript:DismissImportant();'>Dismiss Message</a>)
	</div>";
}
?>
