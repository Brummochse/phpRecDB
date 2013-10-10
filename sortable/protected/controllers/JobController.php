<?php

class JobController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to 'column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'drag', 'orderAjax'),//DTZ MODIFIED
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','drag','orderAjax'),//DTZ MODIFIED
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Job;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Job']))
		{
			$model->attributes=$_POST['Job'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->jid));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Job']))
		{
			$model->attributes=$_POST['Job'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->jid));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Job');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Job('search');
		if(isset($_GET['Job']))
			$model->attributes=$_GET['Job'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionDrag()
	{
		$cmodel=new Job;
		$model=new Job('search');
		if(isset($_GET['Job']))
			$model->attributes=$_GET['Job'];

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		$dataProvider = new CActiveDataProvider('Job', array(
			'pagination' => false,
			'criteria' => array(
				'order' => 'jseq ASC, jdesc DESC',
			),
			));
		$this->render('drag',array(
			'dataProvider'=>$dataProvider,
			'model'=>$cmodel //model for creation
		));

	}

	public function actionOrderAjax()
	{
		// Handle the POST request data submission
		if (Yii::app()->request->isPostRequest && isset($_POST['Command']) && ($_POST['Command']=='add') )
		{
			$model=new Job;
			$model->attributes['jdesc']=$_POST['jdesc'];
			$model->jdesc=$_POST['jdesc'];
			if ($model->validate())
			{
				$model->save();
				$delete = '<a class="delete" title="Delete" href="/draggable/index.php?r=job/delete&amp;id={'. $model->jid .'}"><img src="images/editdelete.png" alt="Delete" /></a>';
				echo '<li id="'.$model->jid.'" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'.$model->jdesc.$delete.'</li>';
			}
		}
		elseif (Yii::app()->request->isPostRequest && isset($_POST['Order']))
		{
			// Since we converted the Javascript array to a string,
			// convert the string back to a PHP array
			$models = explode(',', $_POST['Order']);

			for ($i = 0; $i < sizeof($models); $i++)
			{
				if ($model = Job::model()->findbyPk($models[$i]))
				{
					$model->jseq = $i;

					$model->save();
				}
			}
			print_r($_POST);
		}
		// Handle the regular model order view
		else
		{
			$dataProvider = new CActiveDataProvider('Job', array(
			'pagination' => false,
			'criteria' => array(
				'order' => 'jseq ASC, jdesc DESC',
			),
			));

			$this->render('order',array(
			'dataProvider' => $dataProvider,
			));
		}
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Job::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='job-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
