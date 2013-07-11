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
	<li><a href='goto.php?Loc=<?php echo $row['UID'] ?> '><?php echo $row['LocationName_W'] ?></a>
<?php endwhile; ?>
</ul>
<p>Special Pages<br />
	<ul>
		<li><a href='logout.php'>Log Out</a></li>
		<li><a href='newchar.php?update=Old'>Update Character Description</a></li>
		<li><a href='TZChoice.php'>Update / Set timezone</a></li>
		<li><a href='buyPowers2.php'>Buy Powers</a></li>
	</ul>
<?php if ($_SESSION["IsGM"] == True): ?>
	<b>GM-Only Pages</b>
	<ul>
	<li>Add Stuff (disabled)</li>
	</ul>
<?php endif; ?>
</div>
