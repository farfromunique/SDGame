<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

session_start();

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = '';

$request  = str_replace("", "", $_SERVER['REQUEST_URI']); 
$site_array  = mb_split("/", $request);  
foreach($site_array as $key => $value)
{ 
	if($value == "") { 
		unset($site_array[$key]); 
	} 
} 
$params = array_values($site_array); 

require 'connections.php';

if ($params[2])
{
	$targetLoc = $params[1];
	$fromURL = True;
}
else
{
	$targetLoc = $_REQUEST["Loc"];
}


$validLocation = false;
$allLocations = 'SELECT UID FROM Locations';
$allLocs = mysqli_query($con, $allLocations);
while ($row['UID'] = mysqli_fetch_array($allLocs))
{
	$i = 0;
	if ($targetLoc == $row['UID'][$i])
	{
		$currentLocationGetStr = "SELECT Current_Location_W FROM Character_Details WHERE UID = " . $_SESSION["CharUID"];
		$currentLocationSetStr = "UPDATE Character_Details SET Current_Location_W='" . $targetLoc . "' WHERE UID = " . $_SESSION["CharUID"];
		$currentLocationName = "SELECT LocationName_W FROM Locations WHERE UID = " . $targetLoc;
		
		$SetLoc = mysqli_query($ud,$currentLocationSetStr);
		$GetLoc = mysqli_query($ud,$currentLocationGetStr);
		$GetName = mysqli_query($ud,$currentLocationName);
		
		while($row = mysqli_fetch_array($GetLoc))
		{
			$_SESSION["CurrLoc"] = $row['Current_Location_W'];
		}
		
		while($row = mysqli_fetch_array($GetName))
		{
			$_SESSION["CurrLocName"] = $row['LocationName_W'];
		}
		
	} else {
		$i++;
	}
}
if ($fromURL)
{
	echo '<script>
			whoIsHere();
			getChat();
		</script>';
}
?>
