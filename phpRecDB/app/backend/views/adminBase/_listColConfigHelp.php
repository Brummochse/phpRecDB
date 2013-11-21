
<?php
//signature explanation///////////////////begin

$this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'sigExplain'));
?>

<div class="modal-header">
    <h1>List Columns Configuration</h1>
</div>
<div class="modal-body">
    <h2>colors</h2>
    <dl>
        <dt>green
        </dt>
        <dd>this columns are not allowed to remove
        </dd>
         <dt>red
        </dt>
        <dd>this columns are only available in administration panel
        </dd>
    </dl>
    <h2>special columns</h2>
    <dl>
        <dt>Location
        </dt>
        <dd>combines the 4 columns Country, City, Venue and Supplement into one single column
        </dd>
         <dt>Buttons
        </dt>
        <dd>the buttons to interact with a record (show in frontend, edit&delete in administration panel)
        </dd>
    </dl>
</div>

<?php
$this->endWidget();
//signature explanation///////////////////end
?>