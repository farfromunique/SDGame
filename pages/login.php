<?php
    $site_root = $_SERVER["SERVER_NAME"];
    $serverRoot = $_SERVER["DOCUMENT_ROOT"];
    spl_autoload_register(function ($class) {
        global $serverRoot;
        require_once $serverRoot . 'classes/' . $class . '.class.php';
    });
    session_start();
    include_once ($serverRoot . 'include/connections.php');

$you = new User;
if ($you->login($pw,$_POST["User"],$_POST["Pword"]) == 'Invalid Login name or Password') {
	header('Location: ' . $site_root . 'login/failed');
	exit;
}
$yours = new Character();
$yours->load($ud,$you->Character);


$_SESSION["User"] = serialize($you);
$_SESSION["Character"] = serialize($yours);
header('Location: ' . $site_root);
?>