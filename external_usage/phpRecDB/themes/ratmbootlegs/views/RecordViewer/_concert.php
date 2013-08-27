<h2><?=$r[RI::ARTIST]; ?></h2>
<h3><?=$r[RI::DATE]; ?></h3>
<h4><?=$r[RI::COUNTRY]; ?> - <?=$r[RI::CITY]; ?>
<br><?=$r[RI::VENUE]; ?> <?php if ($r[RI::SUPPLEMENT] != '') { ?><br><?=$r[RI::SUPPLEMENT]; } ?></h4>
<?php if ($r[RI::MISC] == true) { ?><h5>(MISC)</h5><?php } ?>
<?php if ($r[RI::SOURCEIDENTIFICATION] != '') { ?><h5>Version: <?=$r[RI::SOURCEIDENTIFICATION]; ?></h5><?php } ?>
