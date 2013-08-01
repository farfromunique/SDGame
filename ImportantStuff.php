<?php if ((!$_SESSION["TZ"]) and ($_SESSION["LoggedIn"]=="Yes")): ?>
	<div class='important' id='Important'>
		Please take a moment to <span id='Imptimezone'>set your timezone</span>. (<span id='ImpDismiss'>Dismiss Message</span>)
	</div>
<?php endif; ?>
