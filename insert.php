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
?>
<div class='content'>
	<h2>Insert Into Database (GM-only)</h2>
	<?php if (!$_SESSION["IsGM"]): ?>
	You do not have permission to view this page.
	
	<?php else: ?>
	
	<center>
	What would you like to insert? <br />
	<a href='#' onClick='showLocations()'>Locations</a> | 
	<a href='#'>Powers</a>
	</center>

	<div id='Location-Insert' class='hidden'>
		<form action='insert2.php' method='post'>
			Location name (waking)<input type='text' name='LocNameW'><br />
			Location name (dreaming)<input type='text' name='LocNameD'><br />
			<input type='hidden' name='type' value='Location'>
			<input type='submit' value='Add!'>
		</form>
	</div>
	
	<div id='Power-Insert' class='hidden'>
	
	</div>
<?php endif; ?>

<?php
//Footer
require 'components/footer.php';
?>
