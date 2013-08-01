<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

session_start();

require 'connections.php';

$UName = "'" . $_POST['User'] . "'";
$PWord = md5($_POST['Pword']);


$loginStr="SELECT CharUID, Password, TimeZone FROM Logins WHERE LoginName = " . $UName;
$logins = mysqli_query($pw,$loginStr);

$t=time();

if (mysqli_affected_rows($pw) == 1) // Precisely 1 Login Name matches what was entered
{
	while ($row = mysqli_fetch_array($logins))
		{
			if ($row['Password']==$PWord) // Passwords Match
			{
				$_SESSION["LoggedIn"] = "Yes";
				$_SESSION["CharUID"] = $row['CharUID'];
				$_SESSION["TZ"]=$row['TimeZone'];
				$LoggedInAt = mysqli_query($pw, "UPDATE Logins SET LastLogin " . $t . " WHERE UID = " . $_SESSION["CharUID"]);
				$GetLoc = mysqli_query($pw,"SELECT Current_Location_W, Name FROM Character_Details WHERE UID = " . $_SESSION["CharUID"]);
				while ($row = mysqli_fetch_array($GetLoc))
				{
					$_SESSION["CurrLoc"] = $row['Current_Location_W'];
					$GetLocNameStr = 'SELECT LocationName_W FROM Locations WHERE UID = ' . $_SESSION["CurrLoc"];
					$GetLocName = mysqli_query($con,$GetLocNameStr);
					while ($rowB = mysqli_fetch_array($GetLocName))
					{
						$_SESSION["CurrLocName"] = $rowB['LocationName_W'];
					}
					$_SESSION["CharName"] = $row['Name'];
				}
			
				$GM_Indicator = explode("-",$_SESSION["CharName"]);
				$_SESSION["IsGM"] = ($GM_Indicator[0] == "GM");
				
				$host  = $_SERVER['HTTP_HOST'];
				$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				header("Location: http://$host$uri/");
				exit;
			
			}
			else // Passwords don't match
			{
				$_SESSION["LoggedIn"] = "No";
				$_SESSION["CharUID"] = 0;
				?>
				<html>
					<head>
						<link rel='stylesheet' type='text/css' href='basic.css'>
					</head>
					<body>
						<span>Invalid Login or Password. Try Again</span>
					<?php
						require ('register.php');
			}	
		}
}
else if (mysqli_affected_rows($pw) == 0) // Invalid Login Name
{
	$_SESSION["LoggedIn"] = "No";
	$_SESSION["CharUID"] = 0;
	?>
	<html>
		<head>
			<link rel='stylesheet' type='text/css' href='basic.css'>
		</head>
		<body>
			<span>Invalid Login or Password. Try Again</span>
		<?php
			require ('register.php');
}
else // Non-Unique LoginName (how did this happen?)
{
	$message="Hey! Someone just managed to get more than 1 result on the query\n" . $loginStr . "\nBetter check the DB!";
	$headers = "From:TheGame@acwpd.com";
	mail('game@acwpd.com','Duplicate Username',$message,$headers);
	echo "Something very odd happened. The site admin has been contacted. Our apologies.";
}
require ('footer.php');
?>
