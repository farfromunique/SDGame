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
		$UpdateString = "INSERT INTO Locations (`LocationName_W`, `LocationName_D`) VALUES ($LocationW, $LocationD)";
		break;
	
	default:
		header('Location: http://game.acwpd.com/');
		break;
}

if (!$Qry=mysqli_query($ud,$UpdateString))
{
	die('Error in query: ' . $UpdateString);
}
header('Location: http://game.acwpd.com/');
?>