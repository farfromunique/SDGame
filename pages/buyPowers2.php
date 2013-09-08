<?php
    $site_root = $_SERVER["SERVER_NAME"];
    $serverRoot = $_SERVER["DOCUMENT_ROOT"] . '/';
    spl_autoload_register(function ($class) {
        global $serverRoot;
        require_once $serverRoot . 'classes/' . $class . '.class.php';
    });
    session_start();

require 'connections.php';

$XP_Cost = $_POST["XP_Cost"];
$PowerUID = $_POST["PowerUID"];

// Update XP
$XP_Update_Str = "UPDATE Character_Details SET XP_Current=(XP_Current - " . $XP_Cost . ") WHERE UID = " . $_SESSION["CharUID"];
if (!$XP_Update = mysqli_query($ud,$XP_Update_Str))
{
	die("Error in XP Update! <a href=javascript:history.back>back up</a>");
}

// Add Power to Link Table
$PowerTableUpdateStr = "INSERT INTO PowersLink(CharUID, PowerUID) VALUES (" . $_SESSION['CharUID'] . ", " . $PowerUID . ")";
if (!$PowerTableUpdate = mysqli_query($ud,$PowerTableUpdateStr))
{
	die("Error in PowersLink Insert! <a href=javascript:history.back>back up</a>");
}

?>