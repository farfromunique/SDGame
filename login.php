<?php
// Availiable $_SESSION variables:
//  CurrLoc: Integer tied to Locations Table UID
//  CharUID: Integer tied to Character_Details UID
//  CharName: String of the Characater Name
//  IsGM: Boolean of whether or not this is a GM account
//  LoggedIn: "Yes" or not "Yes" answer to the question "Is there a logged in person?"
//  TZ: String containng a timezone

session_start();

$UName = "'" . $_POST['User'] . "'";
$PWord = md5($_POST['Pword']);
$pw=mysqli_connect("sdgame.db","sdgame_pw","ReadOnly","Characters");

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
				$_SESSION["CharName"] = $row['Name'];
			}
			$GM_Indicator = explode("-",$_SESSION["CharName"]);
			if ($GM_Indicator[0] == "GM")
			{
				$_SESSION["IsGM"] = True;
			}
			else
			{
				$_SESSION["IsGM"] = False;
			}
			header('Location: http://game.acwpd.com/');
			
			
		}
			else // Passwords don't match
			{
				echo "Invalid Password. Try Again";
				$_SESSION["LoggedIn"] = "No";
				$_SESSION["CharUID"] = 0;
				echo "<html>
				<head>
				<link rel='stylesheet' type='text/css' href='basic.css'>
				</head>
				<div id='Register'"; //Closing Angle Bracket missing intentionally
				require 'components/register.php';
				echo "</div>";
			}	
		}
}
else if (mysqli_affected_rows($pw) == 0) // Invalid Login Name
{
	$_SESSION["LoggedIn"] = "No";
	$_SESSION["CharUID"] = 0;
	echo "<html>
	<head>
	<link rel='stylesheet' type='text/css' href='basic.css'>
	</head>
	<body>";
	echo "<div id='Register'>";
	echo "<span>Invalid Login Name. Try Again.</span";  //Closing Angle Bracket missing intentionally
	require 'components/register.php';
	echo "</div>";
}
else // Non-Unique LoginName (how did this happen?)
{
	$message="Hey! Someone just managed to get more than 1 result on the query<br />" . $loginStr . "<br />Better check the DB!";
	$headers = "From:TheGame@acwpd.com";
	mail('game@acwpd.com','Duplicate Username',$message,$headers);
}
?>
