<?php

if(!isset($con))
{
session_start();

require_once ('connections.php');
require_once ('time.php');
}
$currentChar = $_SESSION["CharUID"];

if (isset($_POST["UD_type"]))
	{
		if ($_POST["UD_type"]="Converse")
			{
				$newComment = $_POST["Comm"];
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

<?php if ($conversRows > 0): ?>
	<?php while ($row = mysqli_fetch_array($convers)): ?>
		<?php
		$TDS=strtotime($row['TDS']);
		$TDS=$TDS-$tzOffset;
		?>
		<div class='comment' id= <?php echo $row['UID']; ?> >
			<?php if ($_SESSION["IsGM"]): ?>
					<input type='submit' class='GM_Button' value='Delete' onClick='removeRecord(<?php echo $row['UID']; ?>)'>
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
	<input type='text' name='Comm' class='TalkBox' id='message' onkeypress='return typeChat(event)'>
	<input type='submit' value='Talk' class='TalkButton' onClick='chat()'>
</div>
<!--
<script>
setTimeout(getChat(), 15000);
</script>
-->
