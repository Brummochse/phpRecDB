<?php if ($r[RI::SUMLENGTH] != '') { ?><label>Length:</label> <?=$r[RI::SUMLENGTH]; } ?>
<?php if ($r[RI::QUALITY] != '') { ?><br><label>Quality:</label> <?=$r[RI::QUALITY].'/10'; } ?>
<?php if ($r[RI::MEDIUM] != '') { ?><br><label>Media:</label> <?=($r[RI::SUMMEDIA] != '' ? $r[RI::SUMMEDIA] . 'x ' : '') . $r[RI::MEDIUM]; } ?>
<?php if ($r[RI::SOURCE] != '') { ?><br><label>Source:</label> <?=$r[RI::SOURCE]; } ?>
<?php if ($r[RI::SOURCENOTES] != '') { ?><br><label>Sourcenotes:</label> <?=nl2br($r[RI::SOURCENOTES]); } ?>
<?php if ($r[RI::RECTYPE] != '') { ?><br><label>Recording Type:</label> <?=$r[RI::RECTYPE]; } ?>

<?php if ($a[RI::BITRATE] != '') { ?><br><label>Bitrate:</label> <?=$a[RI::BITRATE]; } ?>
<?php if ($a[RI::FREQUENCY] != '') { ?><br><label>Frequency:</label> <?=$a[RI::FREQUENCY]; } ?>