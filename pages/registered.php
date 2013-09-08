<?php
    $site_root = $_SERVER["SERVER_NAME"];
    $serverRoot = $_SERVER["DOCUMENT_ROOT"];
    spl_autoload_register(function ($class) {
        global $serverRoot;
        require_once $serverRoot . 'classes/' . $class . '.class.php';
    });
    session_start();
    require_once ($serverRoot . 'include/connections.php');

    $desiredChar = $_POST["Cname"];
    $desiredUser = $_POST["Uname"];

    $you = new User;
    $yours = new Character;

    $goodUser = false;
    $goodCharacter = false;
    if ($you->nameAvailable($con,$desiredUser)) {
        $goodUser = true;
    }

    if ($yours->nameAvailable($con,$desiredChar)) {
        $goodCharacter = true;
    }
?>

<?php if (( ! $goodUser) && (! $goodCharacter)): ?>
	
	<h2>We're sorry, neither that Login Name <strong>nor</strong> Character name is available.</h2>
	<p> Please choose another of each.</p>
	<form action='registered.php' method='post'>
        <label>
            Login Name:
            <input name='Uname' type='text'>
        </label><br />
        <label>
            Character Name:
            <input name='Cname' type='text'>
        </label><br />
		<input type='Submit' value='Register!'>
	</form>
	
<?php elseif (! $goodCharacter): ?>
	
	<h2>We're sorry, that Character Name is not available.</h2>
	<p> Please choose another.</p>
	<form action='registered.php' method='post'>
        <label>
            Character Name:
            <input name='Cname' type='text'>
        </label><br />
		<input type='hidden' name='Uname' value='<?php echo $desiredUser ?>'>
		<input type='Submit' value='Register!'>
	</form>
	
<?php elseif (! $goodUser): ?>
	
	<h2>We're sorry, that Login Name is not available.</h2>
	<p> Please choose another.</p>
	<form action='registered.php' method='post'>
        <label>
            Login Name:
            <input name='Uname' type='text'>
        </label><br />
		<input type='hidden' name='Cname' value='<?php echo $desiredChar ?>'>
		<input type='Submit' value='Register!'>
	</form>
	
<?php else: ?>

	<?php $restricted = explode("-",$desiredChar) ?>
	<?php if ($restricted[0] == "GM"): ?>
		<h2>This character name is available, but restricted!
		<br />Please input your authorization code below:</h2>
		<form action='<?php echo $site_root ?>character' method='post'>
    <label>
        Authorization Code:
        <input type='text' name='Auth'>
    </label><br /><br />
				<b>Please tell us about <?php echo $desiredChar ?>...</b>";
	<?php else: ?>
		<h2>Character name is available!</h2>
		Please tell us about <?php echo $desiredChar ?>...
		<form action='<?php echo $site_root ?>character/new' method='post'>
			<input type='hidden' name='Auth' value='AaronSaidYes'>
	<?php endif; ?>
		<br />Login Name: <?php echo $desiredUser ?><br />
			Character Name: <?php echo $desiredChar ?><br />
			<input type='hidden' name='Uname' value='<?php echo $desiredUser ?>'>
			<input type='hidden' name='Cname' value='<?php echo $desiredChar ?>'>
            <label>
                Password:
                <input name='Pword' type='password'>
            </label><br />
            <label>
                Age:
                <input name='Age' type='text' maxlength='3'>
            </label><br />
			Gender: <br />
            <label>Male:
                <input name='Gender' type='radio' value='M'>
            </label>
            <label>
                Female:
                <input name='Gender' type='radio' value='F'>
            </label>
            <label>
                Other:
                <input name='Gender' type='radio' value='Other'>
            </label><br />
            <label>
                Height (in Centimeters):
                <input name='Height' type='text' maxlength='3'>
            </label><br />
            <label>
                Skin Color:
                <input name='Skin' type='text'>
            </label><br />
            <label>
                Eye Color:
                <input name='Eyes' type='text'>
            </label><br />
            <label>
                Hair Color:
                <input name='Hair' type='text'>
            </label><br />
            <label>Any Distinguishing Marks? <br />
                <textarea name='DistinguishingMarks' rows='2' cols='30'></textarea>
            </label><br />
			<input type='Submit' value='Generate!'>
			</form>
			<br /><a href='logout.php'>Abort! I want to create a different character!</a>
			<?php
			$_SESSION["LoggedIn"] = "Yes";
			$_SESSION["CharName"] = $desiredChar;
			$_SESSION["CurrLoc"] = '1';
			$_SESSION["User"] = serialize($you);
			$_SESSION["Character"] = serialize($yours);
			?>
<?php endif; ?>