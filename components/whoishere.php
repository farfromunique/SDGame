<div class='whoishere'>
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
	</table>
	<hr />
	<a href='users.php'>All characters</a>
</div>
