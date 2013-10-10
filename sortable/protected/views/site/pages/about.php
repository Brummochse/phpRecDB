<?php
$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>
<h1>About</h1>
<style type="text/css">
	#sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; background-color:#FAF0B1;}
	#sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
	#sortable li span { position: absolute; margin-left: -1.3em; }
	</style>
	<script type="text/javascript">
	$(function() {
		$("#sortable").sortable();
		$("#sortable").disableSelection();
	});
</script>

<?php
$this->widget('zii.widgets.jui.CJuiSortable', array(
    'id'=>'sortable',	// default is class="ui-sortable" id="yw0"
    'items'=>array(
        'id1'=>'<li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 1</li>',
        'id2'=>'<li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li>',
        'id3'=>'<li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li>',
    ),
    // additional javascript options for the accordion plugin
    'options'=>array(
        'delay'=>'300',
    ),
));
?>
<p>This is a "static" page.</p>