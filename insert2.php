<?php
session_start();
if (!$_SESSION["IsGM"])
{ header('Location: http://game.acwpd.com/'); }
require 'components/connections.php';

$InsertType = $_POST["type"];

switch ($InsertType)
{
	case "Location":
		$LocationW = '"' . $_POST["LocNameW"] . '"';
		$LocationD = '"' . $_POST["LocNameD"] . '"';
		$UpdateString = "INSERT INTO Locations (`LocationName_W`, `LocationName_D`) VALUES ($LocationW, $LocationD);";
		break;
		
	case "Power":
		$Power = "'" . $_POST["Power"] . "'";
		$AddonType = "'" . $_POST["AddonType"] . "'";
		$Name = "'" . $_POST["Name"] . "'";
		$Description = $_POST["Description"];
		$XP_Cost = "'" . $_POST["XP_Cost"] . "'";
		$Requires_Specifics = "'" . $_POST["Requires_Specifics"] . "'";
		$Requires_Other_Power = "'" . $_POST["Requires_Other_Power"] . "'";
		$UpdateString = "INSERT INTO Powers (`Power`, `AddonType`, `Name`, `Description`, `XP_Cost`, `Requires_Specifics`, `Requires_Other_Power`)
									 VALUES ($Power, $AddonType, $Name, '$Description', $XP_Cost, $Requires_Specifics, $Requires_Other_Power);";
		break;
	
	default:
		header('Location: http://game.acwpd.com/');
		break;
}
 
if (!$Qry=mysqli_query($ud,$UpdateString))
{
	die('Error in query: ' .  $UpdateString);
}
header('Location: http://game.acwpd.com/insert.php');
?>
