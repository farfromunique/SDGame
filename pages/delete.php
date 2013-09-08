<?php
    $site_root = $_SERVER["SERVER_NAME"];
    $serverRoot = $_SERVER["DOCUMENT_ROOT"];
    spl_autoload_register(function ($class) {
        global $serverRoot;
        require_once $serverRoot . 'classes/' . $class . '.class.php';
    });
    session_start();

if (!$_SESSION["IsGM"] or !isset($_REQUEST["Type"]))
{
	header("Location: http://$host$uri/$extra");
	exit;
}

require 'connections.php';

if ($_REQUEST["Type"] == "comment")
{
	$DelQry = "DELETE FROM Conversations WHERE UID = '" . $_REQUEST["UID"] . "'";
	if (!$Del = mysqli_query($ud,$DelQry))
	{
		die('Bad query: ' . $DelQry);
	}
}

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'index.php';
header("Location: http://$host$uri/$extra");
exit;
?>