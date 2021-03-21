<?php if ($r[RI::SUMLENGTH] != '') { ?><label>Length:</label> <?= number_format($r[RI::SUMLENGTH],2,':','').' min'; } ?>
<?php if ($r[RI::QUALITY] != '') { ?><br><label>Quality:</label> <?=$r[RI::QUALITY].'/10'; } ?>
<?php if ($r[RI::MEDIUM] != '') { ?><br><label>Media:</label> <?=($r[RI::SUMMEDIA] != '' ? $r[RI::SUMMEDIA] . 'x ' : '') . $r[RI::MEDIUM]; } ?>
<?php if ($r[RI::SOURCE] != '') { ?><br><label>Source:</label> <?=$r[RI::SOURCE]; } ?>
<?php if ($r[RI::SOURCENOTES] != '') { ?><br><label>Sourcenotes:</label> <?=nl2br($r[RI::SOURCENOTES]); } ?>
<?php if ($r[RI::RECTYPE] != '') { ?><br><label>Filming Type:</label> <?=$r[RI::RECTYPE]; } ?>
<?php if ($r[RI::USERDEFINED1] != '') { ?><br><label><?= $r[RI::USERDEFINED1LABEL] ?>:</label> <?=$r[RI::USERDEFINED1]; } ?>
<?php if ($r[RI::USERDEFINED2] != '') { ?><br><label><?= $r[RI::USERDEFINED2LABEL] ?>:</label> <?=$r[RI::USERDEFINED2]; } ?>
<?php if (!empty($r[RI::SIZE])) { ?><br><label>Size:</label> <?= number_format($r[RI::SIZE],0,',','.')   .' MB'; } ?>
<?php if (!empty($r[RI::CODEC])) { ?><br><label>Codec:</label> <?= $r[RI::CODEC]; } ?>


<?php if ($v[RI::ASPECTRATIO] != '') { ?><br><label>Aspect Ratio:</label> <?=$v[RI::ASPECTRATIO]; } ?>
<?php if ($v[RI::VIDEOFORMAT] != '') { ?><br><label>Video Format:</label> <?=$v[RI::VIDEOFORMAT]; } ?>
<?php if (!empty($v[RI::BITRATE])) { ?><br><label>Bitrate:</label> <?=$v[RI::BITRATE]; } ?>

<?php if (!empty($v[RI::WIDTH])) { ?><br><label>Resolution:</label> <?=$v[RI::WIDTH].' x '.$v[RI::HEIGHT]; } ?>
<?php if (!empty($v[RI::FRAMERATE])) { ?><br><label>Framerate:</label> <?=$v[RI::FRAMERATE]; } ?>

<?php if (!empty($v[RI::MENU])) { ?><br><label>Menu:</label> yes<?php } ?>
<?php if (!empty($v[RI::CHAPTERS])) { ?><br><label>Chapters:</label> yes<?php } ?>


