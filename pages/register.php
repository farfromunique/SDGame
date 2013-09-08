<?php
    $site_root = $_SERVER["SERVER_NAME"];
    $serverRoot = $_SERVER["DOCUMENT_ROOT"] . '/';
    spl_autoload_register(function ($class) {
        global $serverRoot;
        require_once $serverRoot . 'classes/' . $class . '.class.php';
    });
    session_start();
    include_once ($serverRoot . 'include/connections.php');
?>
<div class='register'><h1>Welcome!</h1>
	<p>You don't seem to be logged in at the moment. Please take a moment to either Log In or Register.</p>
	<br /><br />
    <div class='table-replace centered-div' width='400px'>
        <strong>Login:</strong>
        <form action='<?php echo $site_root ?>pages/login.php' method='POST'>
            <label for='User'>Username:</label>
            <input name='User' maxlength='32' type='text'>
            <br />
            <label for='Pword'>Password:</label>
            <input name='Pword' maxlength='32' type='password'>
            <br />
            <input name='Submit' type='submit' value='Log In!'>
        </form>
    <hr />
        <strong>Register:</strong>
        <form action='<?php echo $site_root ?>register' method='post'>
            <label for='Uname'>Username:</label>
            <input name='Uname' maxlength='32'>
            <br />
            <label for='Cname'>Character Name:</label>
            <input name='Cname' maxlength='32'>
            <br />
            <input name='Submit' type='submit' class='left' value='Log In!'>
        </form>
    </div>
	<br /><br />
	Please note that you must be 13 to register.<br />
	Current server time and date: <?php echo date('Y-m-d h:i:s',time()); ?>
</div>