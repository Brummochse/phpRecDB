<?php
$this->breadcrumbs=array(
	'Jobs'=>array('index'),
	'Sortable',
);

$this->menu=array(
	array('label'=>'List Job', 'url'=>array('index')),
	array('label'=>'Create Job', 'url'=>array('create')),
	array('label'=>'Manage Job', 'url'=>array('admin')),
);

?>

<p>The order of the items are kept in database by saving current sequence in column 'Jseq'. They are displayed here with  <tt>order by Jseq ASC</tt>.
</p>
<style type="text/css">
	#orderlist { list-style-type: none; margin: 3px 3px 20px 3px; padding: 2px; width: 60%; background-color:#FAF0B1;}
	#orderlist li { margin: 5px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
	#orderlist li span { position: absolute; margin-left: -1.3em; }
	#orderlist li img {float:right}
	.edit_add {background: url(images/edit_add.png) no-repeat;width:22px; height:22px;text-indent: -9999px; padding: 2px;}
	</style>

<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'job-form',
		'enableAjaxValidation'=>true,
	)); ?>

		<?php

		// Organize the dataProvider data into a Zii-friendly array
		$items = CHtml::listData($dataProvider->getData(), 'jid', 'jdesc');

		// Prepare for the delete button in each Job
		$delete = '<a class="delete" title="Delete" href="/draggable/index.php?r=job/delete&amp;id={id}"><img src="images/editdelete.png" alt="Delete" /></a>';

		$this->widget('zii.widgets.jui.CJuiSortable', array(
		'id'=>'orderlist',	// default is class="ui-sortable" id="yw0"
		'items' => $items,
		'itemTemplate'=>'<li id="{id}" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{content}'.$delete.'</li>',
		));
		?>

		<?php
			// Add a Submit button to add a new job
			echo CHtml::ajaxSubmitButton('Add',
			array('job/orderAjax'),
			array(	//AJAX options
				'type' => 'POST',
				'success'=>'js: function(data) {
							$("#display").append(data);
							$("#orderlist").append(data);
							alert(data);
							}',
				'beforeSend' => 'function(html) { alert("before add"); }',
				'data' => array(
					'Order' => 'js:$("ul#orderlist").sortable("toArray").toString()', //the actual order
					'jdesc' => 'js:$("#'.CHtml::activeId($model,'jdesc').'").val()',  //the value of new job
					'Command'=>'add'
					)
				),
			array(	//HTML options
				'class'=>'edit_add',
				)
			);
			?>
		<?php echo $form->textField($model,'jdesc',array('size'=>50,'maxlength'=>50)); ?>


		<div class="row buttons">
			<?php
			// Add a Submit button to send data to the controller
			echo CHtml::ajaxSubmitButton('Submit Changes',
			array('job/orderAjax'),
			array(
				'type' => 'POST',

				'success'=>'js: function(data) {
							$("#display").append(data);
							alert(data);
							}',
				'beforeSend' => 'function(html) { alert("before send"); }',
				'data' => array(
				// Turn the Javascript array into a PHP-friendly string
				'Order' => 'js:$("ul#orderlist").sortable("toArray").toString()',
				)
			));
			?>
		</div>

	<?php $this->endWidget(); ?>
	<div id="display"></div>
</div><!-- form -->
<?php echo '<br/>starting with values: [Jid] Jdesc<br/> ';foreach($items as $i=>$item) echo '['.$i.'] '.$item.'<br/>'; ?>


