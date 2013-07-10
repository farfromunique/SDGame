<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"

//footer file


$LoginTimeStr = "UPDATE `Logins` SET `LastLogin`='" . $tu . "' WHERE `CharUID`='" . $_SESSION["CharUID"] . "'";
if ($LoginTimeUpdate = mysqli_query($ud,$LoginTimeStr))
{
	// Everything worked!
}
else
{
	echo "<div id='Message' onclick='javascript:hideMessage();'>Not Updated<br />" . $LoginTimeStr . "</div>";
}

mysqli_close($con);
mysqli_close($ud);
?>

</body></html>
