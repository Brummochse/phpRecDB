<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>
			<?php
				if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR."_title.php")) {
    					include dirname(__FILE__) . DIRECTORY_SEPARATOR."_title.php";
				} else {
					echo "phpRecDB Bootlegs";
				}
			?>
		</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<div id="topBar"></div>
		<div id="MainSection">
			<div id="header">
				<h1>
					<?php
						if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR."_title.php")) {
    							include dirname(__FILE__) . DIRECTORY_SEPARATOR."_title.php";
						} else {
							echo "phpRecDB Bootlegs";
						}
					?>
				</h1>
			</div>
			<div id="topNav">
				<?= CHtml::link('The List', './'); ?>
				<?= CHtml::link('Updates', '?r=site/page&view=updates'); ?>
				<?= CHtml::link('Statistics', '?r=site/page&view=stats'); ?>
				<?= CHtml::link('Contact', '?r=site/page&view=contact'); ?>
			</div>
			<div id="section">
				<?php include dirname(__FILE__) . DIRECTORY_SEPARATOR."content.php"; ?>
			</div>
		</div>
		<div id="footer">
			<div id="BottomBarContent">
				<div id="Credits">
					Powered by <a href="http://www.phprecdb.com">phpRecDB</a> Version <?= Yii::app()->params['version'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Theme by Rezter
				</div>
				<div id="BackToTop">
					<a href="#" class="go-top">To the top &#x25B2;</a>
				</div>
			</div>
		</div>
<script type="text/javascript">
		$(document).ready(function() {
			$('.go-top').click(function(event) {
				event.preventDefault();

				$('html, body').animate({scrollTop: 0}, 300);
			})
		});
</script>
	</body>
</html>