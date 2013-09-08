<?php
    $site_root = $_SERVER["SERVER_NAME"];
    $serverRoot = $_SERVER["DOCUMENT_ROOT"] . '/';
    spl_autoload_register(function ($class) {
        global $serverRoot;
        require_once $serverRoot . 'classes/' . $class . '.class.php';
    });
    session_start();
    require_once ($serverRoot . 'include/connections.php');

    $you = unserialize($_SESSION["User"]);
    $yours = unserialize($_SESSION["Character"]);
    $parser = new Parser();

    $params = $parser->getParameters($_SERVER['REQUEST_URI']);

    // Get $_POST variables
    $UserName=$_POST["Uname"];
    $CharName=$_POST["Cname"];
    $CharNameo="'" . $CharName . "'";
    $Pass=$_POST["Pword"];
    $CharAge=$_POST["Age"];
    $CharGend=$_POST["Gender"];
    $CharHeight=$_POST["Height"];
    $CharSkin=$_POST["Skin"];
    $CharEyes=$_POST["Eyes"];
    $CharHair=$_POST["Hair"];
    $CharDist=$_POST["Distinguishing_Marks"];
    $CharUID = $_SESSION["CharUID"];
    $UpdateUID = $_POST["UpdateUID"];
    $currentLoc = $_SESSION["CurrLoc"];
    $AuthCode = $_POST["Auth"];

    /* parameter options:
        new = register a new character to the DB / site and link to the user
        update = update data about (this) existing character
        GM = update data about (any) existing character
            character name is provided as next-level parameter
        [default] display = display data about (any) existing character
            character name is provided as next-level parameter
    */

    switch ($params[2]) { //should be 1 once deployed
        case 'new':
            if ($you->register($UserName,$Pass) != 'Success') {
                die("Register Failed."); // make an error handler class, and assign this to it.
            }
            $you->login($pw,$UserName,$Pass);
            $output = $yours->makeMe($CharName,$CharAge,$CharGend,$CharHeight,$CharSkin,$CharEyes,$CharHair,$CharDist);
            break;

        case 'update':
            $output = $yours->makeMe($CharName,$CharAge,$CharGend,$CharHeight,$CharSkin,$CharEyes,$CharHair,$CharDist);
            break;

        case 'GM':
            $theirs = new Character();
            $theirs->load($params[3]); //should be 2 once deployed
            $output = $theirs->makeMe($CharName,$CharAge,$CharGend,$CharHeight,$CharSkin,$CharEyes,$CharHair,$CharDist);
            break;

        case 'display':
        default:
            if (! isset($params[3])) {
                $params[3] = $yours->UID;
            }
            $theirs = new Character();
            $theirs->load($params[3]);
            $output = $theirs->DescribeMe();
            break;
    }

    switch ($output) {
        case false:
            echo 'An error has occurred: Last Good location was ' . $yours->LastGood;
            break;

        default:
            echo $output;
            break;
    }
?>