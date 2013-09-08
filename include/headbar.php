<?php
    $site_root = 'http://game.acwpd.com/OO/';
    $serverRoot = '/f5/sdgame/public/OO/';
    spl_autoload_register(function ($class) {
        global $serverRoot;
        require_once $serverRoot . 'classes/' . $class . '.class.php';
    });
    session_start();
    require_once $serverRoot . 'include/time.php';
    if ( ! isset($yours)) {
        if (isset($_SESSION['Character'])) {
            $yours = unserialize($_SESSION['Character']);
        }
    }

?>
<div class='headBar'>
    <h2>You are currently at <span id='CurrLoc'><?php echo $_SESSION["CurrLocName"]; ?></span></h2>
    <h3>It is now <?php echo $localTime->format('Y-m-d g:i A'); ?></h3>
</div>