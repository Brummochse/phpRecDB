<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getTheme()->getBaseUrl(); ?>/css/recordDetail.css" />
<?php
if ($items != NULL) 
 {
?>
    <div class="panel">
        <?php
        $this->widget('ArtistMenu', array('properties' => array(
                'items' => $items,
                'cssFile' => Yii::app()->getTheme()->getBaseUrl() . '/css/mbmenu.css',
                )));
        ?>
    </div>

 <?php
}
?>
<div id='phpRecDbInfo'>
        
        <div id='headerinfo'>
            <span id='videooraudio'><?=($r[RI::VIDEOORAUDIO]==RI::VIDEO)?'Video':'Audio'; ?></span>
            <span id='tradestatus'><?= $r[RI::TRADESTATUS]; ?></span>
            <span id='dates'>
                <?php if ($r[RI::CREATION] != '') { ?><label>created:</label> <?=$r[RI::CREATION]; } ?>
                <?php if ($r[RI::LASTMODIFIED] != '') { ?><label>last modified:</label> <?=$r[RI::LASTMODIFIED]; } ?>
            </span>
        </div>

        <div id='concertinfo'>
            <?php $this->renderPartial('_concert', array('r'=>$r)); ?>
        </div>


        <div class='infobox'>
            <?php 
            if ($r[RI::VIDEOORAUDIO]==RI::VIDEO) {
                $this->renderPartial('_video', array('r'=>$r,'v'=>$v)); 
            } 
            if ($r[RI::VIDEOORAUDIO]==RI::AUDIO) {
                $this->renderPartial('_audio', array('r'=>$r,'a'=>$a)); 
            }
            ?>
            
        </div>

        <?php if ($r[RI::TAPER] != '' || $r[RI::TRANSFERER] != '' || (isset($v[RI::AUTHORER]) && $v[RI::AUTHORER] != '')) { ?>
        <div class='infobox'>
            <?php if ($r[RI::TAPER] != '') { ?><label>Taper:</label> <?=$r[RI::TAPER]; } ?>
            <?php if ($r[RI::TRANSFERER] != '') { ?><br><label>Transferer:</label> <?=$r[RI::TRANSFERER]; } ?>
            
             <?php if ($r[RI::VIDEOORAUDIO]==RI::VIDEO) { ?>
                <?php if ($v[RI::AUTHORER] != '') { ?><br><label>Authorer:</label> <?=$v[RI::AUTHORER]; } ?>
            <?php } ?>
        </div>
        <?php } ?>

        <?php if ($r[RI::SETLIST] != '') { ?>
        <div class='infobox'><label>Setlist:</label><br>
            <?= nl2br($r[RI::SETLIST]); ?>
        </div>
        <?php } ?>

        <?php if ($r[RI::NOTES] != '') { ?>
        <div class='infobox'><label>Notes:</label><br> 
            <?= nl2br($r[RI::NOTES]); ?>
        </div>
        <?php } ?>

        <?php if (isset($v[RI::SCREENSHOTS])) { ?>
        <div class='infobox'><label>Screenshots:</label><br>
           <?php 
                foreach ($v[RI::SCREENSHOTS] as $screenshot) {
                   
//                    $this->widget('ext.lyiightbox.LyiightBox2', array(
//                        'thumbnail' => $screenshotFolder.$screenshot->thumbnail,
//                        'image' => $screenshotFolder.$screenshot->screenshot_filename,
//                        'title' => $r[RI::ARTIST].' '.$r[RI::DATE].' '.$r[RI::COUNTRY].' - '.$r[RI::CITY].' '.$r[RI::VENUE].' '.$r[RI::SUPPLEMENT],
//                        'group' => 'sample'
//   
//                    )); 
                    
                    
                    
                     echo CHtml::link(CHtml::image($screenshotFolder.'/'.$screenshot->thumbnail), $screenshotFolder.'/'.$screenshot->screenshot_filename, array("rel"=>"group"));
                }
                $this->widget('application.extensions.fancybox.EFancyBox', array(
                    'target' => 'a[rel="group"]',
                    'config' => array(
                        'titleShow' => true,
                        'scrolling' => 'auto',
                        'titlePosition' => 'outside'))
                 );
            ?>
        </div>
        <?php } ?>

        <?php if (isset($v[RI::YOUTUBESAMPLES])) { ?>
        <div class='infobox'><label>Youtube Samples:</label><br/>
                <?php
                foreach ($v[RI::YOUTUBESAMPLES] as $youtube) {
                    echo $youtube->title;
                    ?>
                    <br/>
                    <?php
                    $this->widget('ext.youtube.JYoutube', array(
                        'youtubeId' => $youtube->youtubeId,
                        'width' => '480',
                        'height' => '300',
                    ));
                    ?>
                    <br/>
                    <?php
                }
                ?>
        </div>
       <?php } ?>

</div>
