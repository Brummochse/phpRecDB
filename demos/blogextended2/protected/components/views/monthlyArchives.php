<ul>
<?php foreach ($this->findAllPostDate() as $month=>$val): ?>
<li>
<?php echo CHtml::link("$month ($val)", array('post/PostedInMonth',
					      'time'=>strtotime($month),
					      'pnc'=>'c'));  ?>
</li>
<?php endforeach; ?>
</ul>
<!-- $Id: monthlyArchives.php 51 2010-01-28 07:13:58Z mocapapa@g.pugpug.org $ -->
