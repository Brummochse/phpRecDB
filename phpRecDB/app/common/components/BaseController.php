<?php


abstract class BaseController extends CController
{

    public function filters()
    {
        return array('setUrlSettings');
    }

    public function filterSetUrlSettings($filterChain)
    {
        Yii::app()->params['wwwUrl']=Yii::app()->baseUrl.'/'.$this->getWwwUrlPath();
        Yii::app()->params['screenshotsUrl']=Yii::app()->baseUrl.'/'.$this->getScreenshotPath();
        $filterChain->run();
    }

    protected abstract function getWwwUrlPath() ;

    protected abstract  function getScreenshotPath();
}