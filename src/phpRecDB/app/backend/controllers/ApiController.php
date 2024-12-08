<?php


class ApiController extends CController
{

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
    private $restEndpoints = [];

    private function AddRestEndpoint(RestEndpoint $endpoint)
    {
        $this->restEndpoints[$endpoint->getName()] = $endpoint;

    }

    public function init()
    {
        parent::init();
        $this->AddRestEndpoint(new RecordEndpoint());
        $this->AddRestEndpoint(new InfoEndpoint());
    }

    private function getEndpoint(string $name)
    {
        if (!key_exists($name, $this->restEndpoints)) {
            throw new BadMethodCallException();
        }
        return $this->restEndpoints[$name];
    }

    private function processRestAction(callable $executable)
    {
        try {
            if (!$this->checkAuthentication()) {
                $this->sendResponse(401);
            }
            $resultArray = $executable();
            $encode = empty($resultArray) ?'' : CJSON::encode($resultArray);
            $this->sendResponse(200, $encode, 'application/json');
        } catch (BadMethodCallException $e) {
            $this->sendResponse(501);
        } catch (Exception $e) {
            $this->sendResponse(500);
        }
    }

    public function actionList()
    {
        $this->processRestAction(function () {
            return $this->getEndpoint($_GET['model'])->list();
        });
    }

    public function actionView()
    {
        $this->processRestAction(function () {
            return $this->getEndpoint($_GET['model'])->view();
        });

    }

    public function actionCreate()
    {
        $this->processRestAction(function () {
            return $this->getEndpoint($_GET['model'])->create();
        });

    }

    public function actionUpdate()
    {
        $this->processRestAction(function () {
            return $this->getEndpoint($_GET['model'])->update();
        });
    }

    public function actionDelete()
    {
        $this->processRestAction(function () {
            return $this->getEndpoint($_GET['model'])->delete();
        });
    }

    private function sendResponse($status = 200, $body = '', $content_type = 'text/html')
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        header('Content-type: ' . $content_type);

        if ($body != '') {
            echo $body;
        } else {
            $message = $this->_getStatusCodeMessage($status);
            $this->renderPartial('response', array('status' => $status, 'message' => $message));
        }
        Yii::app()->end();
    }

    private function _getStatusCodeMessage($status)
    {
        $codes = array(
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

    private function checkAuthentication()
    {
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            $user = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];

            $userIdentity = new UserIdentity($user, $password);

            try {
                if ($userIdentity->authenticate() && $userIdentity->getState("roles") == "admin") {
                    return true;
                }
            } catch (CException $e) {
            }
        }
        return false;
    }
}