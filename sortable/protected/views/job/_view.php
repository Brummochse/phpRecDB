<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jid), array('view', 'id'=>$data->jid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jdesc')); ?>:</b>
	<?php echo CHtml::encode($data->jdesc); ?>
	<br />


</div>