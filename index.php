<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone
require 'components/header.php';

//Body
echo "<div id='content'><h2>You are currently at ";
while ($row = mysqli_fetch_array($location))
  {
	echo $row['LocationName_W'];
	}

echo ".</h2><h3>It is now " . $tf;
echo "</h3>";
echo "</div>";

//Conversation
require 'components/converse.php';

//Footer
require 'components/footer.php';

?>
