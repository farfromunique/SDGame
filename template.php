<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone
require 'components/header.php';

// Page-Specific variables

// Page-Specific queries

//Body
echo "<div id='content'><h2>";

//Footer
require 'components/footer.php';

?>
