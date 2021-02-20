<?php


abstract class BaseController extends CController
{

    public function filters()
    {
        return array('setWwwUrl');
    }

    public function filterSetWwwUrl($filterChain)
    {
        Yii::app()->params['wwwUrl']=Yii::app()->baseUrl.'/'.$this->getWwwUrlPath();
        $filterChain->run();
    }

    public abstract function getWwwUrlPath();
}