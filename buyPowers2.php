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
{
	// XP Query
	{
		$XPStr = "SELECT XP_Current FROM Character_Details WHERE UID = " . $_SESSION["CharUID"];
		$GetXP = "";
		$XP = "";
	}

	// All Powers Query
	{
	$AllPowersStr = "SELECT * FROM Powers WHERE AddonType='Base'"; // Query Text
	$GetAllPowers = ""; // Query
	$AllPowers = array(); // Array of results
	}
	
	// Current Powers Query
	{
	$CurrPowersStr = "SELECT PowersLink.PowerSpecifics AS Specifics, Powers.Description AS Description, Powers.Power AS Power, Powers.Name AS Name, Powers.AddonType AS AddonType, Powers.UID AS UID
				FROM PowersLink
				INNER JOIN Powers ON PowersLink.PowerUID = Powers.UID
				WHERE PowersLink.CharUID = " . $_SESSION["CharUID"];
	$GetCurrPowers = "";
	$CurrPowers = array();
	}
	
	// Availiable Upgrades Query
	{
	$AbleToUpgradeStr="SELECT DISTINCT Pow1.Requires_Other_Power AS UID, Pow2.Power AS Power, Pow2.Name AS Name, Pow2.Description AS Description, Pow2.XP_Cost AS XP_Cost
					FROM Powers AS Pow1 
					JOIN Powers AS Pow2 
					ON Pow1.Requires_Other_Power = Pow2.UID 
					WHERE Pow2.UID 
						IN (SELECT PowerUID 
							FROM PowersLink 
							WHERE CharUID ='" . $_SESSION["CharUID"] . "')";
	$GetAbleToUpgrade = "";
	$AbleToUpgrade = array();
	}
}

// Page-Specific queries
{
	// $XP (Current XP)
	{
		$GetXP = mysqli_query($con,$XPStr);
		$XP = mysqli_fetch_array($GetXP);
		$XP = $XP[0];
	}
	
	// $AllPowers (All Base Powers)
	// $AllPowers[$i][n]: $i is row, n corresponds to table here:
	{
		// [0] = UID
		// [1] = Power
		// [2] = Name
		// [3] = Description
		// [4] = AddonType
		// [5] = XP_Cost
	}
	{
		$i = 0;
		$GetAllPowers = mysqli_query($con,$AllPowersStr);
		while ($row = mysqli_fetch_array($GetAllPowers))
		{
			$AllPowers[$i][0] = $row['UID'];
			$AllPowers[$i][1] = $row['Power'];
			if ($row['AddonType'] == 'Base')
			{
				$AllPowers[$i][2] = 'Base';
			}
			else
			{
				$AllPowers[$i][2] = $row['Name'];
			}
			$AllPowers[$i][3] = $row['Description'];
			$AllPowers[$i][4] = $row['AddonType'];
			$AllPowers[$i][5] = $row['XP_Cost'];
			$i++;
		}
	}	
	
	// $CurrPowers
	// $CurrPowers[$i][n]: $i is row, n corresponds to table here:
	{
		// [0] = UID
		// [1] = Power
		// [2] = Name
		// [3] = Description
		// [4] = AddonType
	}
	{
		$i = 0;
		$GetCurrPowers = mysqli_query($con,$CurrPowersStr);
		while ($row = mysqli_fetch_array($GetCurrPowers))
		{
			$CurrPowers[$i][0] = $row['UID'];
			$CurrPowers[$i][1] = $row['Power'];
			if ($row['AddonType'] == 'Base')
			{
				$CurrPowers[$i][2] = 'Base';
			}
			else
			{
				$CurrPowers[$i][2] = $row['Name'];
			}
			$CurrPowers[$i][3] = $row['Description'];
			$CurrPowers[$i][4] = $row['AddonType'];
			$CurrPowers[$i][5] = $row['XP_Cost'];
			$i++;
		}
	}
	
	// $AbleToUpgrade
	// $AbleToUpgrade[$i][n]: $i is row, n corresponds to table here:
	{
		// [0] = UID
		// [1] = Power
		// [2] = Name
		// [3] = Description
		// [4] = XP_Cost
		// [5] = Requires_Other_Power
	}
	{
		$i = 0;
		$GetAbleToUpgrade = mysqli_query($con,$AbleToUpgradeStr);
		while ($row = mysqli_fetch_array($GetAbleToUpgrade))
		{
			$AbleToUpgrade[$i][0] = $row['UID'];
			$AbleToUpgrade[$i][1] = $row['Power'];
			if ($row['AddonType'] == 'Base')
			{
				$AbleToUpgrade[$i][2] = 'Base';
			}
			else
			{
				$AbleToUpgrade[$i][2] = $row['Name'];
			}
			$AbleToUpgrade[$i][3] = $row['Description'];
			$AbleToUpgrade[$i][4] = $row['XP_Cost'];
			$i++;
		}
	}
	

	// $UpgradeList
	{
		for ($i=0;$i<count($AbleToUpgrade);$i++)
		{
			$UpgradeListStr = "SELECT * 
							FROM Powers 
							WHERE (Requires_Other_Power = " . $AbleToUpgrade[$i][0] . ") 
							AND (UID NOT IN 
								(SELECT PowerUID 
								FROM PowersLink 
								WHERE CharUID = " . $_SESSION["CharUID"] . "))";
			$GetUpgradeList = mysqli_query($con,$UpgradeListStr);
			$j=0;
			while ($row = mysqli_fetch_array($GetUpgradeList))
			{
				$UpgradeList[$i][$j][0] = $row['UID'];
				$UpgradeList[$i][$j][1] = $row['Power'];
				$UpgradeList[$i][$j][2] = $row['Name'];
				$UpgradeList[$i][$j][3] = $row['Description'];
				$UpgradeList[$i][$j][4] = $row['XP_Cost'];
				$UpgradesListSize[$i] = $j;
				$j++;
			}
		}

	}
}

?>
<script>";
	var Current_XP = <?php echo $XP ?>;

	<?php for ($i=0;$i<count($AllPowers);$i++): ?>
		AllPower <?php echo $i ?> = new Array('<?php echo $AllPowers[$i][0] ?>', '<?php echo $AllPowers[$i][1] ?>', '<?php echo $AllPowers[$i][2] ?>', '<?php echo $AllPowers[$i][3] ?>', '<?php echo $AllPowers[$i][4] ?>', '<?php echo $AllPowers[$i][5] ?>');
	<?php endfor; ?>

	var AllPowers = new Array();
	<?php for ($i=0;$i<count($AllPowers);$i++): ?>
		AllPowers.push(AllPower<?php echo $i ?>);
	<?php endfor; ?>

	<?php for ($i=0;$i<count($CurrPowers);$i++): ?>
		CurrPower<?php echo $i ?> = new Array('<?php echo $CurrPowers[$i][0] ?>', '<?php echo $CurrPowers[$i][1] ?>', '<?php echo $CurrPowers[$i][2] ?>', '<?php echo $CurrPowers[$i][3] ?>', '<?php echo $CurrPowers[$i][4] ?>', '<?php echo $CurrPowers[$i][5] ?>');
	<?php endfor; ?>

	var CurrentPowers = new Array();
	<?php for ($i=0;$i<count($CurrPowers);$i++): ?>
		CurrentPowers.push(CurrPower<?php echo $i ?>);
	<?php endfor; ?>
</script>

	
	// JS: AvailiableUpgrades

		echo "<script name='AvailiableUpgrades'>";
		for ($i=0;$i<count($AbleToUpgrade);$i++)
		{
			echo "AvailPower" . $i . " = new Array(" 
			. "'" . $AbleToUpgrade[$i][0] . "', " 
			. "'" . $AbleToUpgrade[$i][1] . "', " 
			. "'" . $AbleToUpgrade[$i][2] . "', " 
			. "'" . $AbleToUpgrade[$i][3] . "', " 
			. "'" . $AbleToUpgrade[$i][4] . "', " 
			. "'" . $AbleToUpgrade[$i][5] . "')";
			echo "
			";
		}
		echo "var AvailiableUpgrades = new Array();";
		for ($i=0;$i<count($AbleToUpgrade);$i++)
		{
			echo "AvailiableUpgrades.push(AvailPower" . $i . ");";
		}
		echo "</script>";

	
	// JS: Power_X Objects

		echo "<script name='Power_X'>";
		for ($i=0;$i<count($AllPowers);$i++)
		{
			$thisPower = str_ireplace(' ','_',$AllPowers[$i][1]);
			echo  "Power_" . $thisPower . " = '<br />" . $AllPowers[$i][3] . "<br /><br /><b>XP Cost: </b>" . $AllPowers[$i][4] . "';
					";
		}
		echo "</script>";

	
	//JS: UpgradeList

	echo "<script name='UpgradeList'>";
	settype($UpgradesListSize[$i],"int");
	for ($i=0;$i<count($AbleToUpgrade);$i++)
	{
		echo "var UpgradeList" . $AbleToUpgrade[$i][0] . " = new Array();
";
		for ($j=0;$j<=$UpgradesListSize[$i];$j++)
		{
			echo "UpgradeList" . $AbleToUpgrade[$i][0] . ".push(Array('"
				. $UpgradeList[$i][$j][0] . "', '"
				. $UpgradeList[$i][$j][1] . "', '"
				. $UpgradeList[$i][$j][2] . "', '"
				. $UpgradeList[$i][$j][3] . "', '"
				. $UpgradeList[$i][$j][4] . "'));
";
		}
	}
	echo "</script>";


//Body
?>
<div class='content'>
	<h2>Buy Powers for your character</h2>
	<?php echo "<h3>You currently have <span id='XP'>" . $XP . "</span> XP to spend.</h3>"; ?>
	
	<div class='selectIt'>
		<a href='#' onClick='SpendReview()'>Review</a> | 
		<a href='#' onClick='SpendNewPower()'>New Power</a> | 
		<a href='#' onClick='SpendUpgrade()'>Upgrade Power</a>
	</div>
	<div id='SpendReview' class='spend'>
	
	</div>
	<div id='SpendBuyNew' class='spend'>
		Select power to purchase:
		<select id='availiablePowers' onChange='buyThis(this.options.selectedIndex - 1);'>
			<option selected='true'>-- Select A Power --</option>
			<?php 
					for ($i=0;$i<count($AllPowers);$i++)
					{
						echo "<option id='BuyPowerUID" . $AllPowers[$i][0] . "'>" .  $AllPowers[$i][1] . "</option>";
					}
			?>
		</select>
		<div id='secondBuyNew' class='hidden'>
		</div>
		<div id='thirdBuyNew' class='hidden'>
		</div>
	</div>
	<div id='SpendUpgrade' class='spend'>
		Select power to upgrade:
		<ul>
		<?php
			for ($i=0;$i<count($AbleToUpgrade);$i++)
			{
				echo "<li><a href='#' name='UpgradeList" . $AbleToUpgrade[$i][0] . "' onClick='upgradeList(this.name)'>" . $AbleToUpgrade[$i][1] . " - " . $AbleToUpgrade[$i][2] . "</a></li>";
			}
		?>
		<div id='secondUpgrade' class='hidden'>
		
		</div>
		<div id='thirdUpgrade' class='hidden'>
		
		</div>
	</div>
<?php	
require 'components/footer.php';
?>
