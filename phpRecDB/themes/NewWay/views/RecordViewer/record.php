<div id="RVballs">
<div class="RecordView" id="RVtop">
	<span id="videooraudio">
		<?=($r[RI::VIDEOORAUDIO] == RI::VIDEO) ? 'Video' : 'Audio';?>
	</span>
	<span id="tradestatus">
		<?=$r[RI::TRADESTATUS];?>
	</span>
	<span id="dates">
		<?php
			if ($r[RI::CREATION] != '') {
		?>
		<label>created:</label>
		<?=$r[RI::CREATION];
			}
			if ($r[RI::LASTMODIFIED] != '') {
		?>
		<label>last modified:</label>
		<?= $r[RI::LASTMODIFIED];
			}
		?>
	</span>
</div>
<div id="RVcol1">
	<div class="RecordView" id="RV2">
		<div class="RVbox">
			<h2><?=$r[RI::ARTIST]; ?></h2>
			<h3><?=$r[RI::DATE]; ?></h3>
			<h4>
				<?=$r[RI::COUNTRY]; ?> - <?=$r[RI::CITY]; ?><br />
				<?=$r[RI::VENUE];
					if ($r[RI::SUPPLEMENT] != '') {
				?><br />
				<?=$r[RI::SUPPLEMENT]; } ?>
			</h4>
			<?php
				if ($r[RI::MISC] == true) {
			?>
			<h5>(MISC)</h5>
			<?php
				}
				if ($r[RI::SOURCEIDENTIFICATION] != '') {
			?>
			<h5>Version: <?=$r[RI::SOURCEIDENTIFICATION]; ?></h5>
			<?php
				}
			?>
		</div>
	</div>
<?php
if ($r[RI::SETLIST] != '') {
?>
	<div class="RecordView" id="RV5">
		<h1>Setlist</h1>
		<div class="RVbox">
			<?= nl2br($r[RI::SETLIST]); ?>
		</div>
	</div>
<?php
}
?>
</div>
<div id="RVcol2">
	<div class="RecordView" id="RV3">
		<h1>Info</h1>
		<div class="RVbox">
			<?php
				if ($r[RI::VIDEOORAUDIO] == RI::VIDEO) {
			?>
			<?php if ($r[RI::SUMLENGTH] != '') { ?><label>Length:</label> <?=$r[RI::SUMLENGTH].' min'; } ?>
			<?php if ($r[RI::QUALITY] != '') { ?><br /><label>Quality:</label> <?=$r[RI::QUALITY].'/10'; } ?>
			<?php if ($r[RI::MEDIUM] != '') { ?><br /><label>Media:</label> <?=($r[RI::SUMMEDIA] != '' ? $r[RI::SUMMEDIA] . 'x ' : '') . $r[RI::MEDIUM]; } ?>
			<?php if ($r[RI::SOURCE] != '') { ?><br /><label>Source:</label> <?=$r[RI::SOURCE]; } ?>
			<?php if ($r[RI::SOURCENOTES] != '') { ?><br /><label>Sourcenotes:</label> <?=nl2br($r[RI::SOURCENOTES]); } ?>
			<?php if ($r[RI::RECTYPE] != '') { ?><br /><label>Filming Type:</label> <?=$r[RI::RECTYPE]; } ?>
			<?php if ($v[RI::ASPECTRATIO] != '') { ?><br /><label>Aspect Ratio:</label> <?=$v[RI::ASPECTRATIO]; } ?>
			<?php if ($v[RI::VIDEOFORMAT] != '') { ?><br /><label>Videoformat:</label> <?=$v[RI::VIDEOFORMAT]; } ?>
			<?php if ($v[RI::BITRATE] != '') { ?><br /><label>Bitrate:</label> <?=$v[RI::BITRATE]; } ?>
                        <?php if ($r[RI::USERDEFINED1] != '') { ?><br><label><?= $r[RI::USERDEFINED1LABEL] ?>:</label> <?=$r[RI::USERDEFINED1]; } ?>
                        <?php if ($r[RI::USERDEFINED2] != '') { ?><br><label><?= $r[RI::USERDEFINED2LABEL] ?>:</label> <?=$r[RI::USERDEFINED2]; } ?>
			<?php
				}
				if ($r[RI::VIDEOORAUDIO] == RI::AUDIO) {
			?>
			<?php if ($r[RI::SUMLENGTH] != '') { ?><label>Length:</label> <?=$r[RI::SUMLENGTH].' min'; } ?>
			<?php if ($r[RI::QUALITY] != '') { ?><br><label>Quality:</label> <?=$r[RI::QUALITY].'/10'; } ?>
			<?php if ($r[RI::MEDIUM] != '') { ?><br><label>Media:</label> <?=($r[RI::SUMMEDIA] != '' ? $r[RI::SUMMEDIA] . 'x ' : '') . $r[RI::MEDIUM]; } ?>
			<?php if ($r[RI::SOURCE] != '') { ?><br><label>Source:</label> <?=$r[RI::SOURCE]; } ?>
			<?php if ($r[RI::SOURCENOTES] != '') { ?><br><label>Sourcenotes:</label> <?=nl2br($r[RI::SOURCENOTES]); } ?>
			<?php if ($r[RI::RECTYPE] != '') { ?><br><label>Recording Type:</label> <?=$r[RI::RECTYPE]; } ?>
			<?php if ($a[RI::BITRATE] != '') { ?><br><label>Bitrate:</label> <?=$a[RI::BITRATE]; } ?>
			<?php if ($a[RI::FREQUENCY] != '') { ?><br><label>Frequency:</label> <?=$a[RI::FREQUENCY]; } ?>
                        <?php if ($r[RI::USERDEFINED1] != '') { ?><br><label><?= $r[RI::USERDEFINED1LABEL] ?>:</label> <?=$r[RI::USERDEFINED1]; } ?>
                        <?php if ($r[RI::USERDEFINED2] != '') { ?><br><label><?= $r[RI::USERDEFINED2LABEL] ?>:</label> <?=$r[RI::USERDEFINED2]; } ?>
			<?php
				}
			?>
		</div>
	</div>
<?php
if ($r[RI::TAPER] != '' || $r[RI::TRANSFERER] != '' || (isset($v[RI::AUTHORER]) && $v[RI::AUTHORER] != '')) {
?>
	<div class="RecordView" id="RV6">
		<div class="RVbox">
			<?php if ($r[RI::TAPER] != '') { ?><label>Taper:</label> <?= $r[RI::TAPER]; } ?>
			<?php if ($r[RI::TRANSFERER] != '') { ?><br /><label>Transferer:</label> <?= $r[RI::TRANSFERER]; } ?>
			<?php if ($r[RI::VIDEOORAUDIO] == RI::VIDEO) { 
				if ($v[RI::AUTHORER] != '') {
			?><br /><label>Authorer:</label> <?= $v[RI::AUTHORER]; }
				}
			?>
		</div>
	</div>
<?php
}
if ($r[RI::NOTES] != '') {
?>
	<div class="RecordView" id="RV7">
		<h1>Notes</h1>
		<div class="RVbox">
			<?= nl2br($r[RI::NOTES]); ?>
		</div>
	</div>
<?php
}
?>
</div>
<?php if (isset($v[RI::SCREENSHOTS])) { ?>
<div class="RecordView" id="RV4">
	<h1>Screenshots</h1>
	<div class="RVbox">
	<?php
		foreach ($v[RI::SCREENSHOTS] as $screenshot) {
			echo CHtml::link(
				CHtml::image($screenshotFolder.'/'.$screenshot->thumbnail),$screenshotFolder.'/'.$screenshot->screenshot_filename,
				array("rel" => "lightbox-rel")
			);
		}
	?>
	</div>
</div>
<?php
}
?>
<?php
if (isset($v[RI::YOUTUBESAMPLES])) {
?>
<h1 id="YouT">Youtube Samples</h1>
<br style="clear: left;" />
	<?php
		foreach ($v[RI::YOUTUBESAMPLES] as $youtube) {
	?>
<div class="YouTubeBoxes">
	<h2><?php echo $youtube->title; ?></h2>
	<div class="RVbox">
	<?php
			$this->widget('ext.youtube.JYoutube', array('youtubeId' => $youtube->youtubeId,'width' => '445','height' => '364'));
	?>
	</div>
</div>
	<?php
		}
	?>
<?php
}
?>
<br style="clear:both;" />
</div>