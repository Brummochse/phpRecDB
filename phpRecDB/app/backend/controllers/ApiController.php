<?php


class ApiController extends CController
{
// Members
    /**
     * Key which has to be in HTTP USERNAME and PASSWORD headers
     */
    Const APPLICATION_ID = 'ASCCPE';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array();
    }

    /**
     * @var RestEndpoint[]
     */
    private $restEndpoints=[];

    private function AddRestEndpoint(RestEndpoint $endpoint) {
        $this->restEndpoints[$endpoint->getName()]=$endpoint;

    }

    public function init()
    {
        parent::init();
        $this->AddRestEndpoint(new RecordEndpoint());
        $this->AddRestEndpoint(new InfoEndpoint());
    }

    private function getEndpoint(string $name) {
        if (!key_exists($name,$this->restEndpoints)) {
            throw new BadMethodCallException();
        }
        return $this->restEndpoints[$name];
    }

    private function processRestAction(callable  $executable) {
        try {
            $resultArray=$executable();
            $encode = CJSON::encode($resultArray);
            $this->_sendResponse(200,$encode,'application/json');
        }
        catch(BadMethodCallException $e)
        {
            $this->_sendResponse(501);
        }
        catch(Exception $e)
        {
            $this->_sendResponse(500);
        }
    }

    public function actionList()
    {
        $this->processRestAction(function ()
        {
            return $this->getEndpoint($_GET['model'])->list();
        });
    }

    public function actionView()
    {
        $this->processRestAction(function ()
        {
            return $this->getEndpoint($_GET['model'])->view();
        });

    }

    public function actionCreate()
    {

        $this->processRestAction(function ()
        {
            return $this->getEndpoint($_GET['model'])->create();
        });

    }

    public function actionUpdate()
    {
        $this->processRestAction(function ()
        {
            return $this->getEndpoint($_GET['model'])->update();
        });

    }

    public function actionDelete()
    {
        $this->processRestAction(function ()
        {
            return $this->getEndpoint($_GET['model'])->delete();
        });
    }

    private function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        header('Content-type: ' . $content_type);

        if($body != '')
        {
            echo $body;
        }
        else
        {
            $message = $this->_getStatusCodeMessage($status);
            $this->renderPartial('error', array('status'=>$status,'message'=>$message));
        }
        Yii::app()->end();
    }

    private function _getStatusCodeMessage($status)
    {
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    private function _checkAuth()
    {
        // Check if we have the USERNAME and PASSWORD HTTP headers set?
        if(!(isset($_SERVER['HTTP_X_USERNAME']) and isset($_SERVER['HTTP_X_PASSWORD']))) {
            // Error: Unauthorized
            $this->_sendResponse(401);
        }
        $username = $_SERVER['HTTP_X_USERNAME'];
        $password = $_SERVER['HTTP_X_PASSWORD'];
        // Find the user
        $user=User::model()->find('LOWER(username)=?',array(strtolower($username)));
        if($user===null) {
            // Error: Unauthorized
            $this->_sendResponse(401, 'Error: User Name is invalid');
        } else if(!$user->validatePassword($password)) {
            // Error: Unauthorized
            $this->_sendResponse(401, 'Error: User Password is invalid');
        }
    }
}