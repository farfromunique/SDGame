<?php
    $site_root = $_SERVER["SERVER_NAME"];
    $serverRoot = $_SERVER["DOCUMENT_ROOT"] . '/';
    spl_autoload_register(function ($class) {
        global $serverRoot;
        require_once $serverRoot . 'classes/' . $class . '.class.php';
    });
    session_start();


if ( ! isset($yours)) {
	$yours = unserialize($_SESSION["Character"]);
}

$chat = new Conversation($messageCount,$conversation,1); // '1' needs to be replaced with the character's location'

$currentChar = $_SESSION["CharUID"];

if (isset($_POST["UD_type"])) {
	if ($_POST["UD_type"]="Converse") {
		$newComment = $_POST["Comm"];
		$chat->Send($sendChat,$yours->UID,$newComment);
	}
}

?>
<!--suppress HtmlFormInputWithoutLabel -->
<?php echo $chat ?>
<input type='text' name='Comm' class='TalkBox' id='message' onkeypress='return typeChat(event)'>
<input type='submit' value='Talk' class='TalkButton' onClick='chat()'>