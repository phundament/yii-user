<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{                    
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if ($model->validate() && Yii::app()->user->id) {
                    
                    // Check if is set CodeCard code if CodeCard authentication is required
                    $code_card = Yii::app()->getModule('user')->codeCard;
                    
                    if (!empty($code_card['require']) && !Yii::app()->user->hasState('valid_login_code_is_set')) {
                        $this->redirect(array('/user/login/enterCode'));
                    }
                    
					$this->_finishLogin();
				}
			}
            
			// display the login form
			//$this->render('/user/login',array('model'=>$model));
                        
                        // special view for www login form
                        
                        if (isset($_GET['www'])) {
                           
                            $this->render('/user/www_login',array('model'=>$model));
                        }    
                        else
                            $this->render('/user/ace_login',array('model'=>$model));
		} elseif (isset($_GET['www']))  Yii::app()->end();
                else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
        
    public function actionAjaxStatus(){
        
      //  header("content-type:application/json");
        if (Yii::app()->user->isGuest) {
            echo $_GET['callback']."(".json_encode(array('status' => 0)).")";
        } else {
        
            $user = Yii::app()->user->name;
            echo $_GET['callback']."(".json_encode(array('status' => 1, 'user' => $user)).")";
        }    
        
        Yii::app()->end();
    }  
    
  
        
    
    public function actionEnterCode()
    {
        
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('/user/login'));
        }
        
        $code_card = Yii::app()->getModule('user')->codeCard;
        
        if (empty($code_card['require'])) {
            $this->_finishLogin();
        }
        
        if (Yii::app()->user->hasState('valid_login_code_is_set')) {
            $this->_finishLogin();
        }
        
        $error = '';
        
        if (!empty($_POST['code']) && !empty($_POST['session_id'])) {
            $add_data     = $_POST['code'];
            $session_id   = $_POST['session_id'];
            $request_type = 'validate_code';
        } else {
            $add_data     = '';
            $session_id   = '';
            $request_type = 'logon';
        }
        
        $request = array(
            'request_type' => $request_type,
            'user_id'      => Yii::app()->user->getId(),
            'add_data'     => $add_data,
            'session_id'   => $session_id
        );
        
        $reply = array (
            'error' => ''
        );
        
        CodeCard::request($request, $reply);
        
        if ($reply['error']) {
            $error = UserModule::t($reply['error']);
        } elseif ($reply['reply_type'] == 'success') {
            // set state and redirect to previous page or profile
            Yii::app()->user->setState('valid_login_code_is_set', true);
            $this->_finishLogin();
        }
        
        $view = 'codeCard';
        if (Yii::app()->getModule('user')->view) {
            
            $alt_view = Yii::app()->getModule('user')->view . '.login.'.$view;
            
            if (is_readable(Yii::getPathOfAlias($alt_view) . '.php')) {
                $view = $alt_view;
            }
            
        }
        
		$this->render($view,
            array(
                'reply' => $reply,
                'error' => $error,
            )
        );
        
    }
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit_at = date('Y-m-d H:i:s');
		$lastVisit->save();
	}
    
    private function _finishLogin()
    {
        
        $this->lastViset();
        
        $this->_setLanguage();
        
        if (Yii::app()->getBaseUrl() . "/index.php" === Yii::app()->user->returnUrl) {
            $this->redirect(Yii::app()->controller->module->returnUrl);
        } else {
            $this->redirect(Yii::app()->user->returnUrl);
        }
        
    }
    
    private function _setLanguage()
    {
        
        $model = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        
        $userLang = $model->profile->getAttribute('lang');
        
        if ($userLang) {
            Yii::app()->language = $userLang;
        }
        
    }

}