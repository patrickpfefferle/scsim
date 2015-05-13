<?php

/**
 * API Controller to handle API-Access
 *
 * @author  Andreas Vratny <andreas@vratny.de>
 *
 * @version 1.0.1
 *
 */

class ApiController extends Controller
{
// Members
    /**
     * Key which has to be in HTTP USERNAME and PASSWORD headers
     */
    Const APPLICATION_ID = 'ASCCPE';

    /**
     * Default response format
     * either 'json' or 'xml'
     */
    private $format = 'json';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array();
    }

//Besondere Action für Übersetzung bei Clientapps
    public function actionTranslate()
    {
        if (!isset($_GET['lang']))
            $this->_sendResponse(500, 'Error: Parameter <b>lang</b> is missing');
        if (!isset($_POST['text']))
            $this->_sendResponse(500, 'Error: Parameter <b>text</b> is missing');
        $lang = Yii::app()->params['availableLanguage'];
        $lang[]='en';
        if (!in_array($_GET['lang'], $lang)) {
            $this->_sendResponse(500, 'Error: Language not allowed!');
        }
        Yii::app()->language = $_GET['lang'];
        $this->_sendResponse(200, Yii::t('app', $_POST['text']));
    }

// Actions
    public function actionList()
    {
        $user = $this->_checkAuth();
        // Get the respective model instance
        switch ($_GET['model']) {
            case 'machine':
                $models = CdMachine::model()->findAll('admin_id=:admin_id', array(':admin_id' => $user->id));
                break;
            case 'product':
                $models = CdProduct::model()->findAll('admin_id=:admin_id', array(':admin_id' => $user->id));
                break;
            case 'inputpart':
                $models = CdInputpart::model()->findAll('admin_id=:admin_id', array(':admin_id' => $user->id));
                break;
            case 'step':
                $models = CdStep::model()->findAll('admin_id=:admin_id', array(':admin_id' => $user->id));
                break;
            case 'workflow':
                $models = CdWorkflow::model()->findAll('admin_id=:admin_id', array(':admin_id' => $user->id));
                break;
            case 'gameset':
                $models = CdGameset::model()->findAll('admin_id=:admin_id', array(':admin_id' => $user->id));
                break;
            case 'periodevent':
                $models = CdPeriodevent::model()->findAll('admin_id=:admin_id', array(':admin_id' => $user->id));
                break;
            case 'sellingforecast':
                $models = CdSellingforecast::model()->findAll('admin_id=:admin_id', array(':admin_id' => $user->id));
                break;
            default:
                // Model not implemented error
                $this->_sendResponse(501, sprintf(
                    'Error: Mode <b>list</b> is not implemented for model <b>%s</b>',
                    $_GET['model']));
                Yii::app()->end();
        }
        // Did we get some results?
        if (empty($models)) {
            // No
            $this->_sendResponse(200, json_encode(json_decode("[]")), 'application/json');
        } else {
            // Prepare response
            $rows = array();
            foreach ($models as $model)
                $rows[] = $model->attributes;
            // Send the response
            $this->_sendResponse(200, CJSON::encode($rows), 'application/json');
        }
    }

    public function actionView()
    {
        $user = $this->_checkAuth();

        // Check if id was submitted via GET
        if (!isset($_GET['id']))
            $this->_sendResponse(500, 'Error: Parameter <b>id</b> is missing');

        switch ($_GET['model']) {
            // Find respective model
            case 'machine':
                $model = CdMachine::model()->findAll('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            case 'product':
                $model = CdProduct::model()->findAll('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            case 'inputpart':
                $model = CdInputpart::model()->findAll('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            case 'step':
                $model = CdStep::model()->findAll('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            case 'workflow':
                $model = CdWorkflow::model()->findAll('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            case 'gameset':
                $model = CdGameset::model()->findAll('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            case 'periodevent':
                $model = CdPeriodevent::model()->findAll('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            case 'sellingforecast':
                $model = CdSellingforecast::model()->findAll('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            default:
                $this->_sendResponse(501, sprintf(
                    'Mode <b>view</b> is not implemented for model <b>%s</b>',
                    $_GET['model']));
                Yii::app()->end();
        }
        // Did we find the requested model? If not, raise an error
        if (is_null($model))
            $this->_sendResponse(200, json_encode(json_decode("{}")), 'application/json');
        else
            $this->_sendResponse(200, CJSON::encode($model), 'application/json');
    }

    public function actionCreate()
    {
        $user = $this->_checkAuth();

        switch ($_GET['model']) {
            // Get an instance of the respective model
            case 'machine':
                $model = new CdMachine();
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            case 'product':
                $model = new CdProduct();
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            case 'inputpart':
                $model = new CdInputpart();
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            case 'step':
                $model = new CdStep();
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            case 'workflow':
                $model = new CdWorkflow();
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            case 'gameset':
                $model = new CdGameset();
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            case 'periodevent':
                $model = new CdPeriodevent();
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            case 'sellingforecast':
                $model = new CdSellingforecast();
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            default:
                $this->_sendResponse(501,
                    sprintf('Mode <b>create</b> is not implemented for model <b>%s</b>',
                        $_GET['model']));
                Yii::app()->end();
        }
        // Try to assign POST values to attributes
        foreach ($_POST as $var => $value) {
            // Does the model have this attribute? If not raise an error
            if ($model->hasAttribute($var))
                if ($var != 'created' && $var != 'admin_id' && $var != 'id') {
                    $model->$var = $value;
                } else
                    $this->_sendResponse(500,
                        sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var,
                            $_GET['model']));
        }
        // Try to save the model
        if ($model->save())
            $this->_sendResponse(200, CJSON::encode($model), 'application/json');
        else {
            // Errors occurred
            $msg = "<h1>Error</h1>";
            $msg .= sprintf("Couldn't create model <b>%s</b>", $_GET['model']);
            $msg .= "<ul>";
            foreach ($model->errors as $attribute => $attr_errors) {
                $msg .= "<li>Attribute: $attribute</li>";
                $msg .= "<ul>";
                foreach ($attr_errors as $attr_error)
                    $msg .= "<li>$attr_error</li>";
                $msg .= "</ul>";
            }
            $msg .= "</ul>";
            $this->_sendResponse(500, $msg);
        }
    }

    public function actionUpdate()
    {
        $user = $this->_checkAuth();
        // Parse the PUT parameters. This didn't work: parse_str(file_get_contents('php://input'), $put_vars);
        $json = file_get_contents('php://input'); //$GLOBALS['HTTP_RAW_POST_DATA'] is not preferred: http://www.php.net/manual/en/ini.core.php#ini.always-populate-raw-post-data
        $put_vars = CJSON::decode($json, true); //true means use associative array

        switch ($_GET['model']) {
            // Find respective model
            case 'machine':
                $model = CdMachine::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            case 'product':
                $model = CdProduct::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            case 'inputpart':
                $model = CdInputpart::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            case 'step':
                $model = CdStep::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            case 'workflow':
                $model = CdWorkflow::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            case 'gameset':
                $model = CdGameset::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            case 'periodevent':
                $model = CdPeriodevent::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            case 'sellingforecast':
                $model = CdSellingforecast::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                if ($model != null) {
                    $model->admin_id = $user->id;
                }
                break;
            default:
                $this->_sendResponse(501,
                    sprintf('Error: Mode <b>update</b> is not implemented for model <b>%s</b>',
                        $_GET['model']));
                Yii::app()->end();
        }
        // Did we find the requested model? If not, raise an error
        if ($model === null)
            $this->_sendResponse(400,
                sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",
                    $_GET['model'], $_GET['id']));

        // Try to assign PUT parameters to attributes
        foreach ($put_vars as $var => $value) {
            // Does model have this attribute? If not, raise an error

            if ($model->hasAttribute($var)) {
                //ignore fields
                if ($var != 'created' && $var != 'admin_id' && $var != 'id') {
                    $model->$var = $value;
                }
            } else {
                $this->_sendResponse(500,
                    sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>',
                        $var, $_GET['model']));
            }
        }
        // Try to save the model
        if ($model->save())
            $this->_sendResponse(200, CJSON::encode($model), 'application/json');
        else
            // Errors occurred
            $msg = "<h1>Error</h1>";
        $msg .= sprintf("Couldn't update model <b>%s</b>", $_GET['model']);
        $msg .= "<ul>";
        foreach ($model->errors as $attribute => $attr_errors) {
            $msg .= "<li>Attribute: $attribute</li>";
            $msg .= "<ul>";
            foreach ($attr_errors as $attr_error)
                $msg .= "<li>$attr_error</li>";
            $msg .= "</ul>";
        }
        $msg .= "</ul>";
        $this->_sendResponse(500, $msg);
    }

    public function actionDelete()
    {
        $user = $this->_checkAuth();

        switch ($_GET['model']) {
            // Load the respective model
            case 'machine':
                $model = CdMachine::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            case 'product':
                $model = CdProduct::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            case 'inputpart':
                $model = CdInputpart::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            case 'step':
                $model = CdStep::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            case 'workflow':
                $model = CdWorkflow::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            case 'gameset':
                $model = CdGameset::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            case 'periodevent':
                $model = CdGameset::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            case 'sellingforecast':
                $model = CdGameset::model()->find('id=:id and admin_id=:admin_id', array(':admin_id' => $user->id, ':id' => $_GET['id']));
                break;
            default:
                $this->_sendResponse(501,
                    sprintf('Error: Mode <b>delete</b> is not implemented for model <b>%s</b>',
                        $_GET['model']));
                Yii::app()->end();
        }
        // Was a model found? If not, raise an error
        if ($model === null)
            $this->_sendResponse(400,
                sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",
                    $_GET['model'], $_GET['id']));

        // Delete the model
        $num = $model->delete();
        if ($num > 0)
            $this->_sendResponse(200, $num); //this is the only way to work with backbone
        else
            $this->_sendResponse(500,
                sprintf("Error: Couldn't delete model <b>%s</b> with ID <b>%s</b>.",
                    $_GET['model'], $_GET['id']));
    }


    //Additional Methods
    private function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
    {
        // set the status
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        // and the content type
        header('Content-type: ' . $content_type.'; charset=UTF-8');

        // pages with body are easy
        if ($body != '') {
            // send the body
            echo $body;
        } // we need to create the body if none is passed
        else {
            // create some body messages
            $message = '';

            // this is purely optional, but makes the pages a little nicer to read
            // for your users.  Since you won't likely send a lot of different status codes,
            // this also shouldn't be too ponderous to maintain
            switch ($status) {
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }

            // servers don't always have a signature turned on
            // (this is an apache directive "ServerSignature On")
            $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

            // this should be templated in a real-world solution
            $body = '
                    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
                    <html>
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                        <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
                    </head>
                    <body>
                            <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
                            <p>' . $message . '</p>
                            <hr />
                            <address>' . $signature . '</address>
                    </body>
                    </html>';

            echo $body;
        }
        Yii::app()->end();
    }

    private function _getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
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

    private function _checkAuth($has2beAdmin = false)
    {
        $isAuthorized = false;

        // Check if we have the USERNAME and PASSWORD HTTP headers set?
        if (!(isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW']))) {
            // Error: Unauthorized
            $isAuthorized = false;
        } else {
            $email = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];
            $user = User::model()->find('LOWER(email)=?', array(strtolower($email)));
            // Find the user
            if ($user === null) {
                // Error: Unauthorized
                $this->_sendResponse(401, 'Error: User Name is invalid');
            } else if (!$user->validatePassword($password)) {
                // Error: Unauthorized
                $this->_sendResponse(401, 'Error: User Password is invalid');
            }
            $isAuthorized = true;
        }

        //Check if we have a Passkey
        if (!$isAuthorized) {
            if (!isset(Yii::app()->request->cookies['passcode'])) {
                $this->_sendResponse(401, 'Error: You have to login for api access');
            }
            $user = User::model()->find('cookieauthkey=:c', array(':c' => Yii::app()->request->cookies['passcode']->value));
            if ($user === null) {
                $this->_sendResponse(401, 'Error: Passcode invalid');
            } else      $isAuthorized = true;

            if (!$isAuthorized) {
                $this->_sendResponse(401);
            }
        }

        return $user;
    }
}