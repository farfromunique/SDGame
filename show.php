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
$LookAt = $_REQUEST["id"];

// Page-Specific Queries
$WhoToLookAt = mysqli_query($con,"SELECT * FROM  Character_Details WHERE UID = " . $LookAt);

//Body
echo "<div class='content'><h2>Character Details for: ";
while ($row = mysqli_fetch_array($WhoToLookAt))
	{
	switch ($row['Gender'])
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
				echo "Error! Gender set to: " . $row['Gender'];
				die();
		}
	
	if ($row['Height_Category'] == "average height")
		{
			$needAnN = "n";
		}
	else
		{
			$needAnN = "";
		}
	echo $row['Name'];
	echo "</h2><h3>" . $row['Age'] . " year-old " . $gender[0] . " of Rank " . $row['Rank'] . "</h3>";
	echo "<p>" . $row['Name'] . " is a" . $needAnN . " " . $row['Height_Category'] . " " . $gender[1] . ", with " . $row['Hair'] . " hair and eyes of "
			. $row['Eyes'] . ". " . $gender[4] . " skin is " . $row['Skin'];
			if($row['Distinguishing_Marks'])
				{
					echo " and " . lcfirst($gender[3]) . " has " . lcfirst($row['Distinguishing_Marks']) . ".";
				}
			else 
				{
					echo ".";
				}
	
	$CharName = $row['Name'];
	$CharAge = $row['Age'];
	$CharGend = $row['Gender'];
	$CharHeight = $row['Height'];
	$CharSkin = $row['Skin'];
	$CharEyes = $row['Eyes'];
	$CharHair = $row['Hair'];
	$CharDist = $row['Distinguishing_Marks'];
	$CharHeightCat = $row['Height_Category'];
	
	}

if($_SESSION["IsGM"] == 1)
{

	echo "<p>Do you want to <a href='#' onClick='javascript:ShowCharUpdate();'>change anything</a> (GM ONLY)?";
	echo "<div id='updateChar' class='hidden'><form action='newchar.php' method='post'>
		<input name='update' value='GM' type='hidden'>
		<input name='UpdateUID' value='" . $LookAt . "' type='hidden'>
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
		<input type='Submit' value='Update!'>
		</form>
		</div>";
}

//Footer
require 'components/footer.php';

?>
