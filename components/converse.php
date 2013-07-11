<?php
if (isset($_REQUEST["UD_type"]))
	{
		if ($_REQUEST["UD_type"]="Converse")
			{
				$newComment = $_REQUEST["Comm"];
				$udstr="INSERT INTO Conversations (Location, TDS, Char_num, Comment)
						VALUES ('" . $_SESSION["CurrLoc"] . "','$tu','$currentChar','$newComment')";
				
				$conversUD = mysqli_query($ud,$udstr);	
			}
	}
$conversStr = "SELECT Conversations.UID, Conversations.Location, Conversations.TDS, 
								Character_Details.Name, Conversations.Comment, Character_Details.UID AS CharUID
								FROM Conversations 
								INNER JOIN Character_Details ON Conversations.Char_num = Character_Details.UID 
								WHERE TDS >= " . $tfOld ." AND Location = " . $_SESSION["CurrLoc"] . " ORDER BY UID DESC LIMIT 0, 10";
$convers = mysqli_query($con,$conversStr);	
$conversRows = mysqli_affected_rows($con);
?>
<div class='conversation'>
<?php if ($conversRows > 0): ?>
	<?php while ($row = mysqli_fetch_array($convers)): ?>
		<?php
		$TDS=strtotime($row['TDS']);
		$TDS=$TDS-$tzOffset;
		?>
		<div class='comment' id= <?php echo $row['UID']; ?> >
			<?php if ($_SESSION["IsGM"]): ?>
				<form action='delete.php' method='POST' class='GM_Button'>
					<input type='hidden' name='UID' value=' <?php echo $row['UID']; ?> '>
					<input type='hidden' name='Type' value='comment'>
					<input type='submit' value='Delete'>
				</form>
			<?php endif; ?>
			<span class='attrib'>
				<a href='show.php?id=<?php echo $row['CharUID']; ?>'>
					<?php echo $row['Name']; ?>
				</a> wrote, at <?php echo date('g:i A',$TDS); ?>:
			</span>
			<?php echo $row['Comment']; ?>
		</div>
	<?php endwhile; ?>
	<?php else: ?>
		<i>Nobody seems to have said anything for a while...</i>
	<?php endif; ?>
	<form action='index.php' method='post'>
	<input type='hidden' name='UD_type' value='Converse'>
	<input type='text' name='Comm' class='TalkBox'>
	<input type='submit' value='Talk' class='TalkButton'>
	</form>
</div>
