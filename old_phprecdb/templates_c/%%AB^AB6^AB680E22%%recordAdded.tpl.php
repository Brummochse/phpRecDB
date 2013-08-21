<?php /* Smarty version 2.6.26, created on 2012-07-21 15:45:15
         compiled from admin/recordAdded.tpl */ ?>
<?php if (isset ( $this->_tpl_vars['concertId'] )): ?>
<p>Concert added Successfully with ConcertID: (<?php echo $this->_tpl_vars['concertId']; ?>
)!</p>
<?php endif; ?>

<?php if (isset ( $this->_tpl_vars['recordingId'] )): ?>
    <p>Recording Added Successfully with RecordingID: (<?php echo $this->_tpl_vars['recordingId']; ?>
)!</p>
<?php endif; ?>
<p>

<?php if ($this->_tpl_vars['c_videoOrAudio'] == 'video'): ?>
	videoId: (<?php echo $this->_tpl_vars['videoId']; ?>
)
<?php endif; ?>

<?php if ($this->_tpl_vars['c_videoOrAudio'] == 'audio'): ?>
	audioId: (<?php echo $this->_tpl_vars['audioId']; ?>
)
<?php endif; ?>


</p>
<?php if (isset ( $this->_tpl_vars['editRecordLink'] )): ?>
    <p><a href='<?php echo $this->_tpl_vars['editRecordLink']; ?>
'>edit Recording</a></p>
<?php endif; ?>