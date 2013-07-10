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
	echo "<div class='important' onclick='javascript:hideMessage();'>Not Updated<br />" . $LoginTimeStr . "</div>";
}
if (isset($con))
{
	mysqli_close($con);
}
if (isset($ud))
{
	mysqli_close($ud);
}
if (isset($pw))
{
	mysqli_close($pw);
}
?>

</body></html>
