<?php $this->beginContent('//layouts/admin'); ?>
backup start
    <?php
    $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	));
    
    
    $this->widget('zii.widgets.CMenu',array(
			'items'=>$this->menu));
                            

echo $content;
?>


backup end
<?php $this->endContent(); ?>
