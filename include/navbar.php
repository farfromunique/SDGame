<?php
    require_once ('connections.php');
    $results = array();
    $results = $allLocations->execute(PDO::FETCH_ASSOC);
?>
<div class='navbar'>
    Locations<br />
	<ul>

    	<li>
            <?php foreach ($results as $result): ?>
                    <span class='goto' id='goto<?php echo $result['UID']?>'><?php echo $result['LocationName_W']?></span>
            <?php endforeach; ?>
        </li>
    </ul>
<p>Special Pages<br />
	<ul>
		<li><span id='chat'>Chat</span></li>
		<li><a href='/pages/logout.php'>Log Out</a></li>
		<li><span id='character'>Update Character Description</span></li>
		<li><span id='timezone'>Update / Set timezone</span></li>
		<li><span id='powers'>Buy Powers</span></li>
	</ul>
<?php if ($_SESSION["IsGM"] == True): ?>
	<b>GM-Only Pages</b>
	<ul>
		<li><span id='insert'>Add Stuff</span></li>
	</ul>
<?php endif; ?>
</div>