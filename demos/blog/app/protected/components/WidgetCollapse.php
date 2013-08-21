<?php
  // @version $Id: WidgetCollapse.php 45 2010-01-27 09:33:16Z mocapapa@g.pugpug.org $

class WidgetCollapse extends CApplicationComponent
{
	public $enable;

	public function __construct()
	{
	}

	public function init()
	{
		parent::init();
		if ($this->enable) {
			$cs=Yii::app()->clientScript;

			$params = array(
				'BASEURL'=>Yii::app()->request->baseUrl,
				'HTTPHOST'=>$_SERVER['HTTP_HOST']
			);
                        $script = 'var PARAMS = eval('.CJavaScript::jsonEncode($params).');';
                        $cs->registerScript('widget-params', $script, CClientScript::POS_BEGIN);

			$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/persist.js', CClientScript::POS_HEAD);
			$script = implode('',file(Yii::app()->basePath.'/../js/widget-collapse.min.js'));
			$cs->registerScript('widget-collapse', $script, CClientScript::POS_READY);
		}
	}
}
