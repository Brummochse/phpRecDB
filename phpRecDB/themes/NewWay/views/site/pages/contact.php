<div id="ContactPage">
	<div id="blocker">
		<div id="EmailLogo"></div>
		If you are interested in a trade contact me at:
		<h2>
			<?php
				if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR."_email.php")) {
    					include dirname(__FILE__) . DIRECTORY_SEPARATOR."_email.php";
				} else {
					echo "myemail@address.com";
				}
			?>
		</h2>
	</div>
	<div id="ContactTail"></div>
</div>