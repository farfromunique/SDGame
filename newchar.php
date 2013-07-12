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

// Get $_POST variables
$UserName=$_POST["Uname"];
$CharName=$_POST["Cname"];
$CharNameo="'" . $CharName . "'";
$Pass=md5($_POST["Pword"]);
$CharAge=$_POST["Age"];
$CharGend=$_POST["Gender"];
$CharHeight=$_POST["Height"];
$CharSkin=$_POST["Skin"];
$CharEyes=$_POST["Eyes"];
$CharHair=$_POST["Hair"];
$CharDist=$_POST["DistinguishingMarks"];
$CharUID = $_SESSION["CharUID"];
$UpdateUID = $_POST["UpdateUID"];
$currentLoc = $_SESSION["CurrLoc"];
$AuthCode = $_POST["Auth"];


//Height Categories
// 'very short (<120)','short (<168)','average height(<185)','tall(<200)','very tall(>=200)','monstrous (not currently set)'
if ($CharHeight < 120) {$CharHeightCat = 'very short';}
else if ($CharHeight < 168) {$CharHeightCat = 'short';}
else if ($CharHeight < 185) {$CharHeightCat = 'average height';}
else if ($CharHeight < 200) {$CharHeightCat = 'tall';}
else {$CharHeightCat = 'very tall';}

if ($CharHeightCat == "average height")
{$needAnN = "n";}
else
{$needAnN = "";}

$UpdateQry="UPDATE Character_Details 
	SET Age = '" . $CharAge . "', Gender = '" . $CharGend . "', Height = '" . $CharHeight . 
	"', Skin = '" . $CharSkin . "', Eyes = '" . $CharEyes . "', Hair = '" . $CharHair . 
	"', Distinguishing_Marks = '" . $CharDist . "', Height_Category = '" . $CharHeightCat . "' WHERE UID = " . $CharUID;

switch ($CharGend)
{
	case "M":
		$gender=array("Male","guy","dude","He","His");
		break;
	case "F":
		$gender=array("Female","gal","chick","She","Her");
		break;
	case "Other":
		$gender=array("Individual","person","person",$row['Name'],"Their");
		break;
	default:
		die("Error! " . $CharGend);
}

?>

<div class='content'>

<?php if ($_REQUEST["update"] == "Yes"): ?>
		
	<?php if ($CreateChar=mysqli_query($ud,$UpdateQry)): ?>
		<h1>Character Updated</h1>
		<h2>Character Description for: <?php echo $CharName; ?></h2>
		<h3><?php echo $CharAge ?> year-old <?php echo $gender[0] ?> of Rank 1</h3>
		<p><?php echo $CharName ?> is a<?php echo $needAnN ?> <?php echo $CharHeightCat ?> <?php echo $gender[1] ?>
			, with <?php echo $CharHair ?> hair and eyes of <?php echo $CharEyes ?>.
			<?php echo $gender[4] ?> skin is <?php echo $CharSkin; ?>
			<?php if($CharDist): ?>
				" and <?php echo lcfirst($gender[3]) ?> has <?php lcfirst($CharDist) ?>.
			<?php else: ?>
				.
			<?php endif; ?>
	<?php else: ?>
		Update failed...<br /><?php echo $UpdateQry; ?>
	<?php endif; ?>
	
<?php elseif ($_REQUEST["update"] == "Old"): ?>
	
	<?php
	$CurrentData=mysqli_query($ud,"SELECT * FROM Character_Details WHERE UID = " . $CharUID);
		while ($row = mysqli_fetch_array($CurrentData))
		{
			$CharName = $row['Name'];
			$CharAge = $row['Age'];
			$CharGend = $row['Gender'];
			$CharHeight = $row['Height'];
			$CharSkin = $row['Skin'];
			$CharEyes = $row['Eyes'];
			$CharHair = $row['Hair'];
			$CharDist = $row['Distinguishing_Marks'];
			$CharHeightCat = $row['Height_Category'];
			$CharRank = $row['Rank'];
		}
	
	switch ($CharGend)
	{
		case "M":
			$gender=array("Male","guy","dude","He","His");
			break;
		case "F":
			$gender=array("Female","gal","chick","She","Her");
			break;
		case "Other":
			$gender=array("Individual","person","person",$row['Name'],"Their");
			break;
		default:
			die("Error! Gender set to " . $CharGend . ". Stopping!");		
	}
	?>	
	<h1>Character as-is</h1>
	<h2>Character Description for: <?php echo $CharName; ?></h2>
	<h3><?php echo $CharAge ?> year-old <?php echo $gender[0] ?> of Rank <?php echo $CharRank; ?></h3>
	<p><?php echo $CharName ?> is a<?php echo $needAnN; ?> <?php echo $CharHeightCat ?> <?php echo $gender[1] ?>
		, with <?php echo $CharHair ?> hair and eyes of <?php echo $CharEyes ?>. <?php echo $gender[4] ?> skin is <?php echo $CharSkin; ?>
		<?php if($CharDist): ?>
			 and <?php echo lcfirst($gender[3]) ?> has <?php echo lcfirst($CharDist) ?>.
		<?php else: ?>
			.
		<?php endif; ?>
<?php elseif ($_REQUEST["update"] == "GM"): ?>
	<?php
	$UpdateQry="UPDATE Character_Details 
		SET Age = '" . $CharAge . "', Gender = '" . $CharGend . "', Height = '" . $CharHeight . 
			"', Skin = '" . $CharSkin . "', Eyes = '" . $CharEyes . "', Hair = '" . $CharHair . 
			"', Distinguishing_Marks = '" . $CharDist . "', Height_Category = '" . $CharHeightCat . "' WHERE UID = " . $UpdateUID;
	switch ($CharGend)
	{
		case "M":
			$gender=array("Male","guy","dude","He","His");
			break;
		case "F":
			$gender=array("Female","gal","chick","She","Her");
			break;
		case "Other":
			$gender=array("Individual","person","person",$row['Name'],"Their");
			break;
		default:
			echo "Error! " . $CharGend;
			die();
	}
	if ($CharHeightCat == "average height")
	{
		$needAnN = "n";
	}
	else
	{
		$needAnN = "";
	}
	?>
	<?php if ($CreateChar=mysqli_query($ud,$UpdateQry)): ?>
		<h1>Character Updated by GM</h1>
		<h2>Character Description for: <?php echo $CharName; ?></h2>
		<h3><?php echo $CharAge ?> year-old <?php echo $gender[0] ?> of Rank <?php echo $CharRank; ?></h3>
		<p><?php echo $CharName ?> is a<?php echo $needAnN; ?> <?php echo $CharHeightCat ?> <?php echo $gender[1] ?>
		, with <?php echo $CharHair ?> hair and eyes of <?php echo $CharEyes ?>. <?php echo $gender[4] ?> skin is <?php echo $CharSkin; ?>
		<?php if($CharDist): ?>
			 and <?php echo lcfirst($gender[3]) ?> has <?php echo lcfirst($CharDist) ?>.
		<?php else: ?>
			.
		<?php endif; ?>
	<?php else: ?>
		Update failed...<br /><?php echo $UpdateQry; ?>
	<?php endif; ?>
<?php else: ?>
	<?php if ($AuthCode != "AaronSaidYes"): ?>
	Authorization (<?php echo $AuthCode ?>) Incorrect.<br />Try again: 
		<form action='newchar.php' method='post'>
			<input type='text' name='Auth'>
			<input type='hidden' name='Uname' value='<?php echo $UserName ?>'>
			<input type='hidden' name='Cname' value='<?php echo $CharName ?>'>
			<input type='hidden' name='Pword' value='<?php echo $Pass ?>'>
			<input type='hidden' name='Age' value='<?php echo $CharAge ?>'>
			<input type='hidden' name='Gender' value='<?php echo $CharGend ?>'>
			<input type='hidden' name='Height' value='<?php echo $CharHeight ?>'>
			<input type='hidden' name='Skin' value='<?php echo $CharSkin ?>'>
			<input type='hidden' name='Eyes' value='<?php echo $CharEyes ?>'>
			<input type='hidden' name='Hair' value='<?php echo $CharHair ?>'>
			<input type='hidden' name='DistinguishingMarks' value='<?php echo $CharDist ?>'>
			<input type='submit' value='Check Code'>
		</form>
		<br />Or <a href='logout.php'>go back</a>.
		<?php die(); ?>
	<?php endif; ?>
	<?php
	if ($CreateChar=mysqli_query($ud,"INSERT INTO Character_Details (Name, Age, Gender, Height, Skin, Eyes, Hair, Distinguishing_Marks, Current_Location_W)
								VALUES ('$CharName','$CharAge','$CharGend','$CharHeight','$CharSkin','$CharEyes','$CharHair','$CharDist','1')"))
	{
		echo "<h1>Character Created</h1>";
		echo "<h2>Character Description for: ";
		switch ($CharGend)
		{
			case "M":
				$gender=array("Male","guy","dude","He","His");
				break;
			case "F":
				$gender=array("Female","gal","chick","She","Her");
				break;
			case "Other":
				$gender=array("Individual","person","person",$row['Name'],"Their");
				break;
			default:
				echo "Error! " . $CharGend;
				die();
		}
		echo $CharName;
		echo "</h2><h3>" . $CharAge . " year-old " . $gender[0] . " of Rank 1</h3>";
		echo "<p>" . $CharName . " is a " . $CharHeightCat . " " . $gender[1] . ", with " . $CharHair . " hair and eyes of "
			. $CharEyes . ". " . $gender[4] . " skin is " . $CharSkin;
		if($CharDist)
		{
			echo " and " . lcfirst($gender[3]) . " has " . lcfirst($CharDist) . ".";
		}
		else 
		{
		echo ".";
		}
	}
	else
	{
		echo "Character Create Failed<br />";
	}
	?>
<?php endif; ?>
<?php
$qry="SELECT * FROM Character_Details WHERE Name = '" . $CharName . "'";

$GetCharUID=mysqli_query($ud,$qry);

while ($rows = mysqli_fetch_array($GetCharUID))
{
	$GetCharUIDo=$rows['UID'];
	$_SESSION["CharUID"] = $rows['UID'];
}

$CreateUser=mysqli_query($ud,"INSERT INTO Logins (LoginName, Password, CharUID, LastLogin)
								  VALUES ('$UserName','$Pass','$GetCharUIDo','$t')");

echo "<p>Do you want to <a href='#' onClick='javascript:ShowCharUpdate();'>change anything</a>?";
echo "<div id='updateChar' class='hidden'><form action='newchar.php' method='post'>
			<input name='update' value='Yes' type='hidden'>
			Character Name: <input name='Cname' type='hidden' value='" . $CharName . "'>" . $CharName . "<br />
			Password: --NOT DISPLATYED--<br />
			Age: <input name='Age' type='text' maxlength='3' value='" . $CharAge ."'><br />";
			if ($CharGend == "M")
			{
				echo "Gender: <br />
				Male: <input name='Gender' type='radio' value='M' checked='true'>
				Female: <input name='Gender' type='radio' value='F'>
				Other: <input name='Gender' type='radio' value='Other'><br />";
			}
			else if ($CharGend == "F")
			{
				echo "Gender: <br />
				Male: <input name='Gender' type='radio' value='M'>
				Female: <input name='Gender' type='radio' value='F' checked='true'>
				Other: <input name='Gender' type='radio' value='Other'><br />";
			}
			else
			{
				echo "Gender: <br />
				Male: <input name='Gender' type='radio' value='M'>
				Female: <input name='Gender' type='radio' value='F'>
				Other: <input name='Gender' type='radio' value='Other' checked='true'><br />";
			}
			echo "Height (in Centimeters)<input name='Height' type='text' maxlength='3' value='" . $CharHeight . "'><br />
			Skin Color: <input name='Skin' type='text' value='" . $CharSkin . "'><br />
			Eye Color: <input name='Eyes' type='text' value='" . $CharEyes . "'><br />
			Hair Color: <input name='Hair' type='text' value='" . $CharHair . "'><br />
			Any Distinguishing Marks? <br /><textarea name='DistinguishingMarks' rows='2' cols='30'>" . $CharDist . "</textarea><br />
			<input type='Submit' value='Generate!'>
			</form>
		</div>";

//Footer
require 'components/footer.php';

?>
