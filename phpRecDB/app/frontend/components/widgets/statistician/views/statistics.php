<?php
//infrastructure for ajax loading dialogs with loading animation
$this->widget('LoadingWidget');
$ajaxUpdateOption = array('update' => '#dialog_div', 'beforeSend' => 'function(){Loading.show();}', 'complete' => 'function(){ Loading.hide();}');
?>
<div id="dialog_div" style="display: none"></div>



<?php
$this->widget('zii.widgets.jui.CJuiAccordion', array(
    'cssFile' => 'jquery-ui.css',
    'theme' => "css",
    'themeUrl' => Yii::app()->params['wwwUrl'],
    'panels' => array(
        'Options' => $this->render('_options', null, true),
    ),
    'options' => array(
        'collapsible' => true,
        'active' => false,
    ),
));
?>


<h3>Artist Statistics</h3>
<?php
$this->widget('zii.widgets.CDetailView', array(
    'cssFile' => Yii::app()->params['wwwUrl'] . '/css/detailView.css',
    'data' => $artistStats,
    'attributes' => array(
        array(
            'name' => 'Artist Count',
            'value' => $artistStats['artistCount'],
        ),
        array(
            'name' => 'Most Common Artists',
            'type' => 'raw',
            'value' => CHtml::ajaxButton('Open Dialog', $artistStats['commonArtistsURL'], $ajaxUpdateOption),
        )
    )
));
?>

<h3>Various Record Statistics</h3>
<?php
$this->widget('zii.widgets.CDetailView', array(
    'cssFile' => Yii::app()->params['wwwUrl'] . '/css/detailView.css',
    'data' => $variousRecordStats
));
?>

<h3>Location Statistics</h3>
<?php
$this->widget('zii.widgets.CDetailView', array(
    'cssFile' => Yii::app()->params['wwwUrl'] . '/css/detailView.css',
    'data' => $locationStats,
    'attributes' => array(
        array(
            'name' => 'Country Count',
            'value' => $locationStats['countriesCount'],
        ),
        array(
            'name' => 'Most Common Countries',
            'type' => 'raw',
            'value' => CHtml::ajaxButton('Open Dialog', $locationStats['commonCountriesURL'], $ajaxUpdateOption),
        ),
        array(
            'name' => 'City Count',
            'value' => $locationStats['citiesCount'],
        ),
        array(
            'name' => 'Most Common Cities',
            'type' => 'raw',
            'value' => CHtml::ajaxButton('Open Dialog', $locationStats['commonCitiesURL'], $ajaxUpdateOption),
        ),
        array(
            'name' => 'Venue Count',
            'value' => $locationStats['venuesCount'],
        ),
        array(
            'name' => 'Most Common Venues',
            'type' => 'raw',
            'value' => CHtml::ajaxButton('Open Dialog', $locationStats['commonVenuesURL'], $ajaxUpdateOption),
        ),
    )
));
?>




