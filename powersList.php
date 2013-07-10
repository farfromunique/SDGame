<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

require 'components/header.php';

// NOTE: This page is buggy, and needs a re-write!

// Page-Specific variables

//Page-Specific Queries
$PowerNames=mysqli_query($con,"SELECT * FROM Powers WHERE AddonType = 'Base'");

//Body
echo "<div class='content'><h2>List of all (imported) Powers:</h2>"; //Header

// Level 1: Power Names
{
	echo "<ul>"; 
	while ($row = mysqli_fetch_array($PowerNames)) // List Power Names
	// Columns availiable are: UID (Int), Power(Str), AddonType(Str), Name(Str), Description(Str),
	//   XP_Cost(Int), Requires_Specifics(Bool), Requires_Other_Power(Int)

	// [+] / [-] buttons
	echo "<li id='" . $row['Power'] . "'>" . $row['Power'] . 
		" <a href='#' class='more' id='more_" . $row['UID'] . "' onClick='javascript:Expand_Power(" . $row['UID'] . ");'>[+]</a>
		  <a href='#' class='less' id='less_" . $row['UID'] . "' onClick='javascript:Collapse_Power(" . $row['UID'] . ");'>[-]</a>
		  </li>";
	
	// Level 2: Addon Types
	{
		echo "<ul class='collapse' id='" . $row['UID'] . "'>";

		// Set query for Base Description
		$ThisPowerBaseStr="SELECT * FROM Powers WHERE Power='" . $row['Power'] . "' AND AddonType='Base'";
		$ThisPower=mysqli_query($con,$ThisPowerBaseStr);
		
		while ($rowB = mysqli_fetch_array($ThisPower)) // echo the power's short and long desc'
		{
			// Columns availiable are: UID (Int), Name(Str), AddonType(Str), Power(Str), Description(Str),
			//   XP_Cost(Int), Requires_Specifics(Bool), Requires_Other_Power(Int)
			echo "<li>" . $rowB['AddonType'] . " - " . $rowB['Name'] . "</li>";
			 // Level 3: Base Details
			{ 
				echo "<ul>"; 
				if($rowB['XP_Cost'] == 0)
				{
					echo "<li>XP Cost: Free</li>";
				}
				else
				{
					echo "<li>XP Cost: " . $rowB['XP_Cost'] . " xp</li>";
				}
				echo "<li>" . $rowB['Description'] . "</li>";
				$ThisPowerChoicesStr="SELECT * FROM Powers WHERE Requires_Other_Power='" . $rowB['UID'] . "' 
								  AND AddonType='Choice' ORDER BY AddonType ASC";
		 	
				$ThisPowerAddonsStr="SELECT * FROM Powers WHERE Requires_Other_Power='" . $row['UID'] . "' 
								 AND NOT(AddonType='Base') AND NOT(AddonType='Choice') ORDER BY AddonType ASC";
			
				$ThisPowerAddons=mysqli_query($con,$ThisPowerAddonsStr);
				$ThisPowerChoices=mysqli_query($con,$ThisPowerChoicesStr);
			 	
				// Power Choices requiring Base Power
				if (mysqli_affected_rows($con)>0)
				{
					echo "<li>You must choose exactly one of the following:</li>";
					
					// Level 4: Choices this Power requires
					{
						echo "<ul>";
						while ($rowC = mysqli_fetch_array($ThisPowerChoices)) // Power Choices query
						{
							echo "<li><b>" . $rowC['Name'] . "</b></li>";
							// Level 5: Choices this Power requires (Description of)
							{
								echo "<ul>
								<li>" . $rowC['Description'] . "</li>";
								$ThisChoiceAddonsStr="SELECT * FROM Powers WHERE Requires_Other_Power='" . $rowC['UID'] . "' ORDER BY AddonType ASC";
								if ($ThisChoiceAddons=mysqli_query($con,$ThisChoiceAddonsStr))
								{
								echo "<li>Addons that require this choice:</li>";
									// Level 6: Addons requiring this choice
									{
										echo "<ul>";
										while ($rowD=mysqli_fetch_array($ThisChoiceAddons))
										{
											echo "<li>" . $rowD['Name'] . " (<i>" . $rowD['AddonType'] . "</i>)";
										}
										echo "</ul>";
									}
								}		 		
								echo "</ul>";
							}
						}
					}
				}
			}
			echo "</ul>";
		}
		// Addons requiring Base Power
		while ($rowC = mysqli_fetch_array($ThisPowerAddons)) // Actual Addons query
		{
			// Columns availiable are: UID (Int), Name(Str), AddonType(Str), ShortDesc(Str), LongDesc(Str),
			//   XP_Cost(Int), Requires_Specifics(Bool), Requires_Other_Power(Int)	
		 	echo "<li><b>" . $rowC['Name'] . "</b></li>";
		 	// Level N-1: Addons for this Base
			{
				echo "<ul>
				<li>Addon Type: " . $rowC['AddonType'] . "</li>";
				if($rowC['XP_Cost'] == 0)
				{
					echo "<li>XP Cost: Free</li>";
				}
				else
				{
					echo "<li>XP Cost: " . $rowC['XP_Cost'] . " xp</li>";
				}
					
				echo "<li>" . $rowC['Description'] . "</li>";
				if($rowC['Requires_Specifics'] == 1)
				{
					// Level N: Requires Specifics?
					{
						echo "<ul> 
								<li><i>Requires specifics...(implemented later)</i></li>
							</ul>";
					}
				}
				echo "</ul>";
			}
		}
		echo "</ul>";
		// Close Level 3
	}
	echo "</ul>";
	// Close Level 2
}
// Close Level 1


//Footer
require 'components/footer.php';

?>
