<?php
    $site_root = $_SERVER["SERVER_NAME"];
    $serverRoot = $_SERVER["DOCUMENT_ROOT"] . '/';
    spl_autoload_register(function ($class) {
        global $serverRoot;
        require_once $serverRoot . 'classes/' . $class . '.class.php';
    });
    session_start();
require 'connections.php';

// Page-Specific Variables
$allCharsStr="SELECT `Character_Details`.`UID`, `Character_Details`.`Name`, 
				 `Character_Details`.`Rank`, `Locations`.`LocationName_W` AS `Location`, `Locations`.`UID` AS `LocUID`
			FROM `Character_Details` JOIN `Locations` ON `Character_Details`.`Current_Location_W`=`Locations`.`UID`
			ORDER BY `Locations`.`UID` ASC";
			
// Page-Specific Queries
$allChars = mysqli_query($con,$allCharsStr);

//Body
?>
	<h2>List of all characters</h2>
	<table width=85% border='1'>
		<tr>
			<th>Name</th>
			<th width='45'>Rank</th>
		</tr>
		<?php
		$rowCount = 0;
		while($row = mysqli_fetch_array($allChars))
		{
		$ThisRowLoc = $row['Location'];
			?>
			<tr>
				<td colspan='2' align='center'><b><a href=goto.php?Loc=<?php echo $row['LocUID'] ?>><?php echo $row['Location'] ?></a><b></td>
			</tr>
		<tr>
			<td><a href='show.php?id=<?php echo $row['UID'] ?>'><?php echo $row['Name'] ?></a></td>
			<td align='center'><?php echo $row['Rank'] ?></td>
		</tr>
		<?php
		$LastRowLoc = $ThisRowLoc;
	}
	?>
	</table>
<?php require 'footer.php'; ?>