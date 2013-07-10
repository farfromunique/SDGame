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
<?php
if ($conversRows > 0)
{
	while ($row = mysqli_fetch_array($convers))
		{
			$TDS=strtotime($row['TDS']);
			$TDS=$TDS-$tzOffset;
			
			echo "<div class='comment' id=" . $row['UID'] . ">";
			if ($_SESSION["IsGM"])
			{
				echo "<form action='delete.php' method='POST' class='GM_Button'>
						<input type='hidden' name='UID' value='" . $row['UID'] . "'>
						<input type='hidden' name='Type' value='comment'>
						<input type='submit' value='Delete'>
					  </form>";
			}
			echo "<span class='attrib'><a href='show.php?id=" . $row['CharUID'] . "'>" . $row['Name'] .
			"</a> wrote, at " . date('g:i A',$TDS) . ":</span>" . $row['Comment'] . "</div>";
		}
}
else
{
	echo "<i>Nobody seems to have said anything for a while...</i>";
}
?>
	<form action='index.php' method='post'>
	<input type='hidden' name='UD_type' value='Converse'>
	<input type='text' name='Comm' class='TalkBox'>
	<input type='submit' value='Talk' class='TalkButton'>
	</form>
</div>
