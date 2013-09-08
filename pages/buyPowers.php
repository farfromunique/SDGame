<?php
    $site_root = $_SERVER["SERVER_NAME"];
    $serverRoot = $_SERVER["DOCUMENT_ROOT"] . '/';
    spl_autoload_register(function ($class) {
        global $serverRoot;
        require_once $serverRoot . 'classes/' . $class . '.class.php';
    });
    session_start();
require 'connections.php';

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
	$CurrPowersStr = 'SELECT PowersLink.PowerSpecifics AS Specifics, Powers.Description AS Description, Powers.Power AS Power, Powers.Name AS Name, Powers.AddonType AS AddonType, Powers.UID AS UID
				FROM PowersLink
				INNER JOIN Powers ON PowersLink.PowerUID = Powers.UID
				WHERE PowersLink.CharUID = ' . $_SESSION["CharUID"] . ' ORDER BY Power';
	$GetCurrPowers = "";
	$CurrPowers = array();
	}
	
	// available Upgrades Query
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
				$UpgradeList[$i][$j][5] = $row['Requires_Specifics'];
				$UpgradesListSize[$i] = $j;
				$j++;
			}
		}

	}
}

?>
<script>
	var Current_XP = <?php echo $XP ?>;

	var AllPowers = [];
		<?php for ($i=0;$i<count($AllPowers);$i++): ?>
		AllPower<?php echo $i ?> = new Array('<?php echo $AllPowers[$i][0] ?>', '<?php echo $AllPowers[$i][1] ?>', '<?php echo $AllPowers[$i][2] ?>', '<?php echo $AllPowers[$i][3] ?>', '<?php echo $AllPowers[$i][4] ?>', '<?php echo $AllPowers[$i][5] ?>');
		<?php endfor; ?>

		<?php for ($i=0;$i<count($AllPowers);$i++): ?>
		AllPowers.push(AllPower<?php echo $i ?>);
		<?php endfor; ?>

	var CurrentPowers = [];
		<?php for ($i=0;$i<count($CurrPowers);$i++): ?>
		CurrPower<?php echo $i ?> = new Array('<?php echo $CurrPowers[$i][0] ?>', '<?php echo $CurrPowers[$i][1] ?>', '<?php echo $CurrPowers[$i][2] ?>', '<?php echo $CurrPowers[$i][3] ?>', '<?php echo $CurrPowers[$i][4] ?>', '<?php echo $CurrPowers[$i][5] ?>');
		<?php endfor; ?>

		<?php for ($i=0;$i<count($CurrPowers);$i++): ?>
		CurrentPowers.push(CurrPower<?php echo $i ?>);
		<?php endfor; ?>

	var availableUpgrades = [];
		<?php for ($i=0;$i<count($AbleToUpgrade);$i++): ?>
		AvailPower<?php echo $i ?> = new Array('<?php echo $AbleToUpgrade[$i][0] ?>','<?php echo $AbleToUpgrade[$i][1] ?>','<?php echo $AbleToUpgrade[$i][2] ?>','<?php echo $AbleToUpgrade[$i][3] ?>','<?php echo $AbleToUpgrade[$i][4] ?>','<?php echo $AbleToUpgrade[$i][5] ?>');
		<?php endfor; ?>
		<?php for ($i=0;$i<count($AbleToUpgrade);$i++): ?>
		availableUpgrades.push(AvailPower<?php echo $i ?>);
		<?php endfor; ?>

	<?php for ($i=0;$i<count($AllPowers);$i++): ?>
		<?php $thisPower = str_ireplace(' ','_',$AllPowers[$i][1]); ?>
		Power_<?php echo $thisPower ?> = '<br /><?php echo $AllPowers[$i][3] ?><br /><br /><b>XP Cost: </b><?php echo $AllPowers[$i][4] ?>';
	<?php endfor; ?>

	<?php settype($UpgradesListSize[$i],"int"); ?>
	<?php for ($i=0;$i<count($AbleToUpgrade);$i++): ?>
	var UpgradeList<?php echo $AbleToUpgrade[$i][0] ?> = [];
		<?php for ($j=0;$j<=$UpgradesListSize[$i];$j++): ?>
			UpgradeList<?php echo $AbleToUpgrade[$i][0] ?>.push(new Array('<?php echo $UpgradeList[$i][$j][0] ?>','<?php echo $UpgradeList[$i][$j][1] ?>','<?php echo $UpgradeList[$i][$j][2] ?>','<?php echo $UpgradeList[$i][$j][3] ?>','<?php echo $UpgradeList[$i][$j][4] ?>','<?php echo $UpgradeList[$i][$j][5] ?>'));
		<?php endfor; ?>
	<?php endfor; ?>
</script>

<h2>Buy Powers for your character</h2>
	<?php echo "<h3>You currently have <span id='XP'>" . $XP . "</span> XP to spend.</h3>"; ?>
	
	<div class='selectIt'>
		<a href='#' onClick='Review()'>Review</a> | 
		<a href='#' onClick='NewPower()'>New Power</a> | 
		<a href='#' onClick='Upgrade()'>Upgrade Power</a>
	</div>
	
	<div id='SpendReview' class='spend'>
	You currently have the following powers:
	<ul>
	<?php for ($i=0;$i<count($CurrPowers);$i++): ?>
		<li><?php echo $CurrPowers[$i][1]; ?> - <?php echo $CurrPowers[$i][2]; ?></li>
	<?php endfor; ?>
	</ul>
	</div>

	<div id='SpendBuyNew' class='spend'>
		
        <label for="availablePowers">Select power to purchase:</label>
        <select id='availablePowers' onChange='buyThis();'>
			<option selected='true'>-- Select A Power --</option>
			
			<?php for ($i=0;$i<count($AllPowers);$i++): ?>
			<option id='BuyPowerUID<?php echo $AllPowers[$i][0]; ?>'><?php echo $AllPowers[$i][1]; ?></option>
			<?php endfor; ?>
			
		</select>
		<div id='secondBuyNew' class='hidden'></div>
		
		<div id='thirdBuyNew' class='hidden'></div>
		
	</div>
	<div id='SpendUpgrade' class='spend'>
		Select power to upgrade:
		<ul>
		<?php for ($i=0;$i<count($AbleToUpgrade);$i++): ?>
			<?php if (count($UpgradeList[$i]) == 0): ?>
			<li><?php echo $AbleToUpgrade[$i][1] ?> - <?php echo $AbleToUpgrade[$i][2] ?></li>
			<?php else: ?>
			<li><a href='#' name='UpgradeList<?php echo $AbleToUpgrade[$i][0] ?>' onClick='upgradeList(this.name)'>
				<?php echo $AbleToUpgrade[$i][1] ?> - <?php echo $AbleToUpgrade[$i][2] ?></a></li>
			<?php endif; ?>
		<?php endfor; ?>
		
		<div id='secondUpgrade' class='hidden'></div>
		
		<div id='thirdUpgrade' class='hidden'></div>