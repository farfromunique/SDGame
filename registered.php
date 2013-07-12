<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

require 'components/header.php';
?>
<style>
	.important {
		display:none;
	}
	.register {
		display:none;
	}
	.whoshere {
		display:none;
	}
</style>
<?php
// Page-Specific Variables
$desiredChar = $_POST["Cname"];
$desiredUser = $_POST["Uname"];

// Page-Specific Queries
$charCheck = "SELECT Name AS Names FROM Character_Details WHERE Name = '" . $desiredChar . "'";
$charTaken = mysqli_query($ud,$charCheck);
$charResult = mysqli_affected_rows($ud);

$userCheck = "SELECT LoginName AS Login FROM Logins WHERE LoginName = '" . $desiredUser . "'";
$userTaken = mysqli_query($ud,$userCheck);
$userResult = mysqli_affected_rows($ud);
?>
<div class='content'>
<?php if ((! $charResult == 0) and (! $userResult == 0)): ?>
	<center><h2>We're sorry, neither that Login Name <b>nor</b> Character name is availiable.</h2>
	<p> Please choose another of each.</p>
	<form action='registered.php' method='post'>
		Login Name: <input name='Uname' type='text'><br />
		Character Name: <input name='Cname' type='text'><br />
		<input type='Submit' value='Register!'>
	</form>
<?php elseif (! $charResult == 0): ?>
	<center><h2>We're sorry, that Character Name is not availiable.</h2>
	<p> Please choose another.</p>
	<form action='registered.php' method='post'>
		Character Name: <input name='Cname' type='text'><br />
		<input type='hidden' name='Uname' value='" . $desiredUser . "'>
		<input type='Submit' value='Register!'>
	</form>
<?php elseif (! $userResult == 0): ?>
	<center><h2>We're sorry, that Login Name is not availiable.</h2>
	<p> Please choose another.</p>
	<form action='registered.php' method='post'>
		Login Name: <input name='Uname' type='text'><br />
		<input type='hidden' name='Cname' value='" . $desiredChar . "'>
		<input type='Submit' value='Register!'>
	</form>
<?php else: ?>
	<?php $restricted = explode("-",$desiredChar) ?>
	<?php if ($restricted[0] == "GM"): ?>
		<center><h2>This character name is availiable, but restricted!
		<br />Please input your authorization code below:</h2>
		<form action='newchar.php' method='post'>
			Authorization Code: <input type='text' name='Auth'><br /><br />
				<b>Please tell us about " . $desiredChar . "...</b>";
	<?php else: ?>
		<center><h2>Character name is availiable!</h2>
		Please tell us about " . $desiredChar . "...";
		<form action='newchar.php' method='post'>
			<input type='hidden' name='Auth' value='AaronSaidYes'>
	<?php endif; ?>
		<br />Login Name: <?php echo $desiredUser ?><br />
			Character Name: <?php echo $desiredChar ?><br />
			<input type='hidden' name='Uname' value='<?php echo $desiredUser ?>'>
			<input type='hidden' name='Cname' value='<?php echo $desiredChar ?>'>			
			Password: <input name='Pword' type='password'><br />
			Age: <input name='Age' type='text' maxlength='3'><br />
			Gender: <br />
			Male: <input name='Gender' type='radio' value='M'>
			Female: <input name='Gender' type='radio' value='F'>
			Other: <input name='Gender' type='radio' value='Other'><br />
			Height (in Centimeters):<input name='Height' type='text' maxlength='3'><br />
			Skin Color: <input name='Skin' type='text'><br />
			Eye Color: <input name='Eyes' type='text'><br />
			Hair Color: <input name='Hair' type='text'><br />
			Any Distinguishing Marks? <br /><textarea name='DistinguishingMarks' rows='2' cols='30'></textarea><br />
			<input type='Submit' value='Generate!'>
			</form>
			<br /><a href='logout.php'>Abort! I want to create a different character!</a>";
			<?php
			$_SESSION["LoggedIn"] = "Yes";
			$_SESSION["CharName"] = $desiredChar;
			$_SESSION["CurrLoc"] = '1';
			?>
<?php endif; ?>
<?php require 'components/footer.php'; ?>
