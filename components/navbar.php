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
<?php
while ($row = mysqli_fetch_array($all_locations))
	{
	echo "<li><a href='goto.php?Loc=" . $row['UID'] . "'>" . $row['LocationName_W'] . "</a>";
	}
?>
</ul>
<p>Special Pages<br />
	<ul>
<?php
if ($_SESSION["LoggedIn"] == "Yes")
{
	echo "<li><a href='logout.php'>Log Out</a></li>";
}
?>
	<li><a href='newchar.php?update=Old'>Update Character Description</a></li>
	<li><a href='TZChoice.php'>Update / Set timezone</a></li>";
	<li><a href='buyPowers2.php'>Buy Powers</a></li>";
</ul>
<?php
if ($_SESSION["IsGM"] == True)
{

	echo "<b>GM-Only Pages</b><ul>";
	echo "<li>Add Stuff (disabled)</li>";
	echo "<li><a href='powersList.php'>List of Powers</a></li>";
	echo "</ul>";
}
?>
</div>
