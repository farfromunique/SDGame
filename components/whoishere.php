<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
?>
<center>You are logged in as:<br />
<?php echo $_SESSION["CharName"]; ?>
</center><br />
<center>Others who are here:</center>
<hr />
<table width=100%>
	<tr>
		<th>Name</th>
		<th width=25%>Rank</th>
	</tr>
<?php 
	while($row = mysqli_fetch_array($charsHere))
	  {
	  	if($row['UID']!=$currentChar)
	  	{
		  echo "<tr>";
		  echo "<td><a href='show.php?id=" . $row['UID'] . "'>" . $row['Name'] . "</a></td>";
		  echo "<td align='center'>" . $row['Rank'] . "</td>";
		  echo "</tr>";
	  	}
	  }
?>
</table>
<hr />
<center><a href='users.php'>All characters</a></center>
