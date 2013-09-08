<?php
    $site_root = $_SERVER["SERVER_NAME"];
    $serverRoot = $_SERVER["DOCUMENT_ROOT"];
    spl_autoload_register(function ($class) {
        global $serverRoot;
        require_once $serverRoot . 'classes/' . $class . '.class.php';
    });
    session_start();
    require_once ($serverRoot . 'include/connections.php');

    // require_once $remoteRoot . 'time.php';

    $parser = new Parser;

    $params = $parser->getParameters($_SERVER['REQUEST_URI']);

    if (($params[1] != 'kronjob') && ($params[1] != 'register')) {
        if ( ! isset($_SESSION['User'])) {
            $params[1] = "login"; // should be 0 once deployed
        }
    }

    $title = 'Sweet Dreams Online';

    switch ($params[1]) { // should be 0 once deployed
        case 'logout': // 'fall through' behavior emulated within logout.php with header: Location command.
            $useHeader = false;
            $useHeadBar = false;
            $bePretty = false;
            $main = $parser->buildOutput('pages/logout.php');
            $useFooter = false;
            break;

        case 'login':
            $title .= ' | Login';
            $useHeader = true;
            $useHeadBar = false;
            $bePretty = false;
            $main = $parser->buildOutput('pages/register.php');
            $useFooter = false;
            break;

        case 'register':
            $title .= ' | Register';
            $useHeader = true;
            $useHeadBar = false;
            $bePretty = true;
            $main = $parser->buildOutput('pages/registered.php');
            $useFooter = true;
            break;

        case 'kronjob':
            $useHeader = false;
            $useHeadBar = false;
            $bePretty = false;
            $main = $parser->buildOutput('pages/kronjob.php');
            $useFooter = false;
            break;

        case 'powers':
            $title .= ' | Powers';
            $useHeader = true;
            $useHeadBar = true;
            $bePretty = true;
            $main = $parser->buildOutput('pages/buyPowers.php');
            $useFooter = true;
            break;

        case 'character':
            $title .= ' | Character';
            $useHeader = true;
            $useHeadBar = true;
            $bePretty = true;
            $main = $parser->buildOutput('pages/newchar.php');
            $useFooter = true;
            break;

        case 'goto':
            $useHeader = false;
            $useHeadBar = false;
            $bePretty = false;
            $main = $parser->buildOutput('pages/goto.php');
            $useFooter = true;
            break;

        case 'timezone':
            $title .= ' | Set Timezone';
            $useHeader = true;
            $useHeadBar = true;
            $bePretty = true;
            $main = $parser->buildOutput('pages/TZChoice.php');
            $useFooter = true;
            break;

        case 'insert':
            $title .= ' | GM-Only: Insert';
            $useHeader = true;
            $useHeadBar = true;
            $bePretty = true;
            if ($_SESSION["IsGM"]) {
                $main = $parser->buildOutput('pages/insert.php');
            } else {
                $main = $parser->buildOutput('pages/converse.php');
            }
            $useFooter = true;
            break;

        default:
            $useHeader = true;
            $useHeadBar = true;
            $bePretty = true;
            $main = $parser->buildOutput('pages/converse.php');
            $useFooter = true;
            break;
        }
    $header = '';
    $footer = '';
?>
<html>
    <head>

        <?php
            if ($useHeader) {
                $header = $parser->buildOutput('include/header.php');
                echo $header;
            }
        ?>

    </head>
    <body>

        <?php
            if ($useHeadBar) {
                $headbar = $parser->buildOutput('include/headbar.php');
                echo $headbar;
            }

            if ($bePretty) {
                echo '<div class="content">';
            }

            echo $main;

            if ($bePretty) {
                echo '</div>';
            }

            if ($useFooter) {
                $footer = $parser->buildOutput('include/footer.php');
                echo $footer;
            }
        ?>
    </body>
</html>