<?php
session_start();
include 'connections.php';
$charsHereStr='SELECT UID, Name, Rank FROM Character_Details WHERE Current_Location_W = ' . $_SESSION["CurrLoc"] . ' LIMIT 5';
$charsHere = mysqli_query($con,$charsHereStr);
$totalCharsHereStr = 'SELECT COUNT(UID) AS Count FROM Character_Details WHERE Current_Location_W = ' . $_SESSION["CurrLoc"];
$totalCharsHere = mysqli_query($con,$totalCharsHereStr);
?>
You are logged in as:<br />
<?php echo $_SESSION["CharName"]; ?>
<br />
Others who are here:
<hr />
<table width=100%>
	<tr>
		<th>Name</th>
		<th width=25%>Rank</th>
	</tr>
	<?php while($row = mysqli_fetch_array($charsHere)): ?>
		<?php if($row['UID'] != $_SESSION['CharUID']): ?>
			<tr>
				<td><a href='show.php?id=<?php echo $row['UID'] ?>'><?php echo $row['Name'] ?></a></td>
				<td align='center'><?php echo $row['Rank'] ?></td>
			</tr>
		<?php endif; ?>
	<?php endwhile; ?>
	<?php while($count = mysqli_fetch_array($totalCharsHere)): ?>
		<?php if($count['Count'] > 5) : ?>
			<tr>
				<td colspan=2 align='center'>... and <?php echo $count['Count'] - 5 ?> more</td>
			</tr>
		<?php endif; ?>
	<?php endwhile; ?>
</table>
<hr />
<a href='users.php'>All characters</a>