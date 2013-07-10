<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone


// This page is not designed to be accessed by a human, but rather by a kron-job

$con=mysqli_connect("database.db","username","password","Characters");
$ud=mysqli_connect("database.db","username","password","Characters");

switch ($_REQUEST["Type"])
{
  case "Daily":
		$ArchiveQry1="INSERT INTO Conversations_bkup SELECT * FROM Conversations WHERE Conversations.TDS < now()-3600";
		$ArchiveQry2="DELETE FROM Conversations WHERE Conversations.TDS < Now()-3600";
		$OptimizeQry1="OPTIMIZE TABLE Conversations";
		$OptimizeQry2="OPTIMIZE TABLE Conversations_bkup";
		
		$qry=mysqli_query($ud,$ArchiveQry1);
		$qry=mysqli_query($ud,$ArchiveQry2);
		$qry=mysqli_query($ud,$OptimizeQry1);
		$qry=mysqli_query($ud,$OptimizeQry2);
		
		break;
	case "Weekly":
		$OptimizeQryBase="OPTIMIZE TABLE ";
		$Tables=array("Character_Details","Conversations","Conversations_bkup","Locations","Logins","Powers","PowersLink");
		for ($i=0; $i<count($Tables); $i++)
		{
			$qry=mysqli_query($ud,$OptimizeQryBase . $Tables[$i]);
		}
		break;
}

mysqli_close($ud);
mysqli_close($con);
?>
