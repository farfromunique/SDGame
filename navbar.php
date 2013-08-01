<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"


//Define Queries
$all_locations = mysqli_query($con,"SELECT * FROM  Locations");
?>
<div class='navbar'>
Locations<br />
	<ul>
<?php while ($row = mysqli_fetch_array($all_locations)): ?>
	<li><span class='goto' id='goto<?php echo $row['UID'] ?>'><?php echo $row['LocationName_W'] ?></span>
<?php endwhile; ?>
</ul>
<p>Special Pages<br />
	<ul>
		<li><span id='chat'>Chat</span></li>
		<li><a href='/logout.php'>Log Out</a></li>
		<li><span id='character'>Update Character Description</span></li>
		<li><span id='timezone'>Update / Set timezone</span></li>
		<li><span id='powers'>Buy Powers</span></li>
	</ul>
<?php if ($_SESSION["IsGM"] == True): ?>
	<b>GM-Only Pages</b>
	<ul>
		<li><span id='insert'>Add Stuff</span></li>
	</ul>
<?php endif; ?>
</div>
