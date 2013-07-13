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
$ExistingPowerStr="SELECT UID, Power, AddonType, Name FROM Powers";
// Page-Specific queries
$ExistingPowersQry=mysqli_query($con,$ExistingPowerStr);
while ($row=mysqli_fetch_array($ExistingPowersQry))
{
	$Powers[i][0] = $row['UID'];
	$Powers[i][1] = $row['Power'];
	$Powers[i][2] = $row['AddonType'];
	$Powers[i][3] = $row['Name'];
}
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
			<input type='hidden' name='type' value='Location'>
			<label for='LocNameW'>Location name (Waking)</label><input type='text' id='LocNameW' name='LocNameW'><br />
			<label for='LocNameD'>Location name (Dreaming)</label><input type='text' id='LocNameD' name='LocNameD'><br />
			<input type='submit' value='Add!'>
		</form>
	</div>
	
	<div id='Power-Insert' class='hidden'>
		<form action='insert2.php' method='post'>
			<input type='hidden' name='type' value='Power'>
			<label for='Power'>Power Name</label><input type='text' id='Power' name='Power'><br />
			<label for='AddonType'>Addon Type</label>
				<select name='AddonType' id='AddonType'>
					<option value='Base'>Base</option>
					<option value='Desc'>Desc / Short Name</option>
					<option value='Choice'>Choice</option>
					<option value='Positive'>Positive</option>
					<option value='Negative'>Negative</option>
				</select>
			<label for='Name'>Addon Name</label><input type='text' name='Name' id='Name'>
			<label for='Description'>Long Description</label>
				<textarea id='Description' rows='3' cols='60'></textarea>
			<label for='XP_Cost'>XP Cost</label><input type='text' id='XP_Cost' name='XP_Cost'>
			<label for='Requires_Specifics'>This power requires details be entered</label>
				<input type='checkbox' id='Requires_Specifics' name='Requires_Specifics'>
			<label for='Requires_Other_Power'>This power has a prerequisite Power</label>
				<select id='Requires_Other_Power' name='Requires_Other_Power'>
					<option value='(None)' selected='true'>(None)</option>
					<?php for ($i=0;$i<count($Powers);$i++): ?>
					<option value='<?php echo $Powers[i][0] ?>'><?php echo $Powers[i][1] ?>: <?php echo $Powers[i][3] ?>
					<?php endfor; ?>
				</select>
		</form>
	</div>
<?php endif; ?>

<?php
//Footer
require 'components/footer.php';
?>
