<?php if ((!$_SESSION["TZ"]) and ($_SESSION["LoggedIn"]=="Yes")): ?>
	<div class='important' id='Important'>
	Please take a moment to <a href='TZChoice.php'>set your timezone</a>. (<a href='javascript:DismissImportant();'>Dismiss Message</a>)
	</div>
<?php endif; ?>
