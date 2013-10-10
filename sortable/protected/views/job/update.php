<?php
$this->breadcrumbs=array(
	'Jobs'=>array('index'),
	$model->jid=>array('view','id'=>$model->jid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Job', 'url'=>array('index')),
	array('label'=>'Create Job', 'url'=>array('create')),
	array('label'=>'View Job', 'url'=>array('view', 'id'=>$model->jid)),
	array('label'=>'Manage Job', 'url'=>array('admin')),
);
?>

<h1>Update Job <?php echo $model->jid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>