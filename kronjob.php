<?php
#remove the directory path we don't want 
$request  = str_replace("", "", $_SERVER['REQUEST_URI']); 
#split the path by '/'  
$site_array  = mb_split("/", $request);  

foreach($site_array as $key => $value)
{ 
	if($value == "") { 
		unset($site_array[$key]); 
	} 
} 

$params = array_values($site_array); 


require 'connections.php';

switch ($params[1])
{
	case "Daily":
		$ArchiveQry1="INSERT INTO Conversations_bkup SELECT * FROM Conversations WHERE Conversations.TDS < now()-86400";
		$ArchiveQry2="DELETE FROM Conversations WHERE Conversations.TDS < Now()-86400";
		$OptimizeQry1="OPTIMIZE TABLE Conversations";
		$OptimizeQry2="OPTIMIZE TABLE Conversations_bkup";
		
		$qry=mysqli_query($ud,$ArchiveQry1);
		$qry=mysqli_query($ud,$ArchiveQry2);
		$qry=mysqli_query($ud,$OptimizeQry1);
		$qry=mysqli_query($ud,$OptimizeQry2);
		
		echo '<!-- Daily Done -->';
		
		break;
	case "Weekly":
		$OptimizeQryBase="OPTIMIZE TABLE ";
		$Tables=array("Character_Details","Conversations","Conversations_bkup","Locations","Logins","Powers","PowersLink");
		for ($i=0; $i<count($Tables); $i++)
		{
			$qry=mysqli_query($ud,$OptimizeQryBase . $Tables[$i]);
		}
		
		echo '<!-- Weekly Done -->';
		
		break;
}
mysqli_close($ud);
?>
