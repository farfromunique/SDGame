<?php
    $site_root = 'http://game.acwpd.com/OO/';
    $serverRoot = '/f5/sdgame/public/OO/';
    spl_autoload_register(function ($class) {
        global $serverRoot;
        require_once $serverRoot . 'classes/' . $class . '.class.php';
    });
    session_start();
    require_once ($serverRoot . 'include/connections.php');

    if ( isset($lastActive) ) {
        if ( ! $lastActive->execute()) {
            echo '<!-- last active date not set! -->';
        }
    }
	unset($con);
	unset($ud);
	unset($pw);
?>