<?php if ($r[RI::SUMLENGTH] != '') { ?><label>Length:</label> <?=$r[RI::SUMLENGTH].' min'; } ?>
<?php if ($r[RI::QUALITY] != '') { ?><br><label>Quality:</label> <?=$r[RI::QUALITY].'/10'; } ?>
<?php if ($r[RI::MEDIUM] != '') { ?><br><label>Media:</label> <?=($r[RI::SUMMEDIA] != '' ? $r[RI::SUMMEDIA] . 'x ' : '') . $r[RI::MEDIUM]; } ?>
<?php if ($r[RI::SOURCE] != '') { ?><br><label>Source:</label> <?=$r[RI::SOURCE]; } ?>
<?php if ($r[RI::SOURCENOTES] != '') { ?><br><label>Sourcenotes:</label> <?=nl2br($r[RI::SOURCENOTES]); } ?>
<?php if ($r[RI::RECTYPE] != '') { ?><br><label>Filming Type:</label> <?=$r[RI::RECTYPE]; } ?>

<?php if ($v[RI::ASPECTRATIO] != '') { ?><br><label>Aspect Ratio:</label> <?=$v[RI::ASPECTRATIO]; } ?>
<?php if ($v[RI::VIDEOFORMAT] != '') { ?><br><label>Video Format:</label> <?=$v[RI::VIDEOFORMAT]; } ?>
<?php if ($v[RI::BITRATE] != '') { ?><br><label>Bitrate:</label> <?=$v[RI::BITRATE]; } ?>