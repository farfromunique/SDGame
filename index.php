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
?>
<div class='content'>
	<h2>You are currently at <?php echo $_SESSION["CurrLocName"]; ?></h2>
	<h3>It is now <?php echo $tf; ?></h3>
</div>
<?php
//Conversation
require 'components/converse.php';

//Footer
require 'components/footer.php';
?>
